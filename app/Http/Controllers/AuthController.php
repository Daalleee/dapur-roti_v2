<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class AuthController extends Controller
{
    public function showPublicHome()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
        
        return view('home', compact('products', 'categories'));
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => 'user', // Default role is user
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Registration successful!');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->intended('/admin');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showProductDetail($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('product.detail', compact('product'));
    }

    public function showByCategory($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('kategori_id', $id)->with('category')->get();
        return view('category.show', compact('category', 'products'));
    }

    public function showAllCategories()
    {
        $categories = Category::with('products')->get();
        $allProducts = Product::with('category')->get();
        return view('categories.index', compact('categories', 'allProducts'));
    }

    public function showOrderHistory()
    {
        $orders = Order::with('product')->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('user.orders', compact('orders'));
    }

    public function showCheckout($productId)
    {
        $product = Product::findOrFail($productId);
        return view('checkout', compact('product'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'jumlah' => 'required|integer|min:1',
            'alamat_pengiriman' => 'required|string',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $product = Product::findOrFail($request->product_id);
        $totalHarga = $product->getFinalPrice() * $request->jumlah;

        // Handle payment proof upload
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('bukti_pembayaran', $filename, 'public');
        }

        // Generate custom order ID
        $customOrderId = $this->generateCustomOrderId();

        $order = Order::create([
            'custom_order_id' => $customOrderId,
            'user_id' => Auth::id(),
            'produk_id' => $request->product_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $totalHarga,
            'bukti_pembayaran' => $path ?? null,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'status' => 'Diproses', // Change status directly to processing since proof is uploaded
        ]);

        return redirect()->route('user.orders')->with('success', 'Pesanan Anda (ID: ' . $customOrderId . ') telah dibuat dan menunggu konfirmasi admin.');
    }

    private function generateCustomOrderId(): string
    {
        // Generate format like AB830 or AB939MJ
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $prefix = $letters[rand(0, strlen($letters) - 1)] . $letters[rand(0, strlen($letters) - 1)];
        
        if (rand(0, 1) === 0) {
            // Format: AB + 3 digits (e.g., AB830)
            $numbers = rand(100, 999);
            $id = $prefix . $numbers;
        } else {
            // Format: AB + 3 digits + 2 letters (e.g., AB939MJ)
            $numbers = rand(100, 999);
            $suffix = $letters[rand(0, strlen($letters) - 1)] . $letters[rand(0, strlen($letters) - 1)];
            $id = $prefix . $numbers . $suffix;
        }

        // Make sure the ID is unique
        while (Order::where('custom_order_id', $id)->exists()) {
            $id = $this->generateCustomOrderId(); // Recursive call to try again
        }

        return $id;
    }

    public function uploadProofOfPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Check if the authenticated user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized to upload proof for this order');
        }

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('bukti_pembayaran', $filename, 'public');
            
            $order->update([
                'bukti_pembayaran' => $path,
                'status' => 'Diproses' // Update status to processing after proof upload
            ]);
        }

        return redirect()->route('user.orders')->with('success', 'Bukti pembayaran berhasil diunggah. Pesanan Anda sedang diproses.');
    }
}

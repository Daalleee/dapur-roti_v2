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

class AdminController extends Controller
{
    //

    public function index()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        // Get statistics for dashboard
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'Selesai')->sum('total_harga');

        return view('admin.dashboard', compact('totalProducts', 'totalOrders', 'totalRevenue'));
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if user exists and has admin role
        $user = User::where('email', $request->email)->first();

        if ($user && $user->isAdmin() && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records or you are not an admin.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }

    // Product management
    public function products()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        if ($request->kategori_option === 'new') {
            $request->validate([
                'new_kategori' => 'required|string|max:255|unique:categories,nama_kategori',
                'nama_produk' => 'required|string|max:255',
                'harga' => 'required|integer|min:0',
                'harga_diskon' => 'nullable|integer|min:0',
                'stok' => 'required|integer|min:0',
                'deskripsi' => 'required|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'multiple_foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Create new category
            $category = Category::create([
                'nama_kategori' => $request->new_kategori,
            ]);
            $kategori_id = $category->id;
        } else {
            $request->validate([
                'kategori_id' => 'required|exists:categories,id',
                'nama_produk' => 'required|string|max:255',
                'harga' => 'required|integer|min:0',
                'harga_diskon' => 'nullable|integer|min:0',
                'stok' => 'required|integer|min:0',
                'deskripsi' => 'required|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'multiple_foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            $kategori_id = $request->kategori_id;
        }

        $data = $request->all();
        $data['kategori_id'] = $kategori_id;
        
        // Remove the fields that aren't part of the Product model
        unset($data['kategori_option'], $data['new_kategori']);
        
        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('produk', $filename, 'public');
            $data['foto'] = $path;
        }

        $product = Product::create($data);

        // Handle multiple images
        if ($request->hasFile('multiple_foto')) {
            foreach ($request->file('multiple_foto') as $image) {
                $filename = time() . '_' . rand(1000, 9999) . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('produk', $filename, 'public');
                
                $product->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function editProduct($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $product = Product::findOrFail($id);

        if ($request->kategori_option === 'new') {
            $request->validate([
                'new_kategori' => 'required|string|max:255|unique:categories,nama_kategori',
                'nama_produk' => 'required|string|max:255',
                'harga' => 'required|integer|min:0',
                'harga_diskon' => 'nullable|integer|min:0',
                'stok' => 'required|integer|min:0',
                'deskripsi' => 'required|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'multiple_foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Create new category
            $category = Category::create([
                'nama_kategori' => $request->new_kategori,
            ]);
            $kategori_id = $category->id;
        } else {
            $request->validate([
                'kategori_id' => 'required|exists:categories,id',
                'nama_produk' => 'required|string|max:255',
                'harga' => 'required|integer|min:0',
                'harga_diskon' => 'nullable|integer|min:0',
                'stok' => 'required|integer|min:0',
                'deskripsi' => 'required|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'multiple_foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            $kategori_id = $request->kategori_id;
        }

        $data = $request->all();
        $data['kategori_id'] = $kategori_id;
        
        // Remove the fields that aren't part of the Product model
        unset($data['kategori_option'], $data['new_kategori']);
        
        if ($request->hasFile('foto')) {
            // Delete old image if exists
            if ($product->foto) {
                Storage::disk('public')->delete($product->foto);
            }
            
            $image = $request->file('foto');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('produk', $filename, 'public');
            $data['foto'] = $path;
        }

        $product->update($data);

        // Handle multiple images
        if ($request->hasFile('multiple_foto')) {
            foreach ($request->file('multiple_foto') as $image) {
                $filename = time() . '_' . rand(1000, 9999) . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('produk', $filename, 'public');
                
                $product->images()->create([
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function deleteProduct($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $product = Product::findOrFail($id);
        
        // Delete main image if exists
        if ($product->foto) {
            Storage::disk('public')->delete($product->foto);
        }
        
        // Delete additional images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    // Category management
    public function categories()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:categories',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function editCategory($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:categories,nama_kategori,' . $id,
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function deleteCategory($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $category = Category::findOrFail($id);
        
        // Check if category has products associated
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Tidak dapat menghapus kategori yang memiliki produk terkait.');
        }
        
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    // Order management
    public function orders()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $orders = Order::with(['user', 'product'])->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function editOrder($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $order = Order::with(['user', 'product'])->findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    public function updateOrder(Request $request, $id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Dikirim,Selesai',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }

    // Reports
    public function reports()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        // Get all completed orders
        $orders = Order::with(['user', 'product'])->where('status', 'Selesai')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $totalRevenue = $orders->sum('total_harga');

        // Get monthly sales report (for chart)
        $monthlySales = Order::where('status', 'Selesai')
            ->selectRaw('MONTH(created_at) as month, SUM(total_harga) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.reports.index', compact('orders', 'totalRevenue', 'monthlySales'));
    }

    public function generatePdfReport()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $orders = Order::with(['user', 'product'])->where('status', 'Selesai')
            ->orderBy('created_at', 'desc')
            ->get();
        $totalRevenue = $orders->sum('total_harga');
        
        return view('admin.reports.pdf', compact('orders', 'totalRevenue'));
    }
}

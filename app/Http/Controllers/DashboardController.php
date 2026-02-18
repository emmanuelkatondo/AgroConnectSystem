<?php
namespace App\Http\Controllers;
use App\Models\District;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Role;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role_id === 1) { 
            // Fetch necessary data for the admin dashboard
            $users = User::with('role')->get();
            $regions = Region::all();
            $products = Product::all();
            $orders = Order::with(['buyer', 'product'])->get();
            return view('dashboard.admin', compact('users', 'products', 'orders', 'regions'));
        } elseif ($user->role_id === 2) { 
            $users = User::with('role')->get();
            // Fetch all products belonging to the seller
            $products = Product::where('seller_id', Auth::id())
                ->with('seller.region', 'seller.district', 'seller.ward')
                ->get();
            // Fetch all orders for the seller's products
            $orders = Order::whereHas('product', function ($query) {
                $query->where('seller_id', Auth::id());
            })->with('product')->get();
            return view('dashboard.seller', compact('products', 'orders', 'users'));
        } elseif ($user->role_id === 3) { 
             // Fetch all products
           $products = Product::with('seller.region', 'seller.district', 'seller.ward')->get();
           $orders = Order::where('buyer_id', Auth::id())->with('product')->get();
            return view('dashboard.buyer', compact('products', 'orders'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}

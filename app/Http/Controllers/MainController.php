<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Region;
use App\Models\District;
use App\Models\Ward;
use App\Models\Product;
use App\Models\Order;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function showLoginForm()
    {  $regions = Region::all(); // Fetch all regions from the database
        return view('login', compact('regions'));
    }

    public function showRegisterForm(Request $request)
    {
        $regions = Region::all();
        $districts = District::all();
        $wards = Ward::all();
        return view('register', compact('regions', 'districts', 'wards'));
    }

    public function register(Request $request)
    {
        // validation
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'region_id' => 'required|exists:regions,id',
            'district_id' => 'required|exists:districts,id',
            'ward_id' => 'required|exists:wards,id',
            'password' => 'required|min:4|',
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'region_id' => $request->region_id,
            'district_id' => $request->district_id,
            'ward_id' => $request->ward_id,
            'role_id' => 3, // default role = buyer
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Account created successfully!');
    }
        public function login(Request $request){
        // Validate login fields
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            $user = Auth::user();
                return redirect()->route('dashboard');
            
        }

        // Login failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function addseller(Request $request)
    {
        // validation
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'region_id' => 'required|exists:regions,id',
            'district_id' => 'required|exists:districts,id',
            'ward_id' => 'required|exists:wards,id',
            'password' => 'required|min:4|',
        ]);
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'region_id' => $request->region_id,
            'district_id' => $request->district_id,
            'ward_id' => $request->ward_id,
            'role_id' => 2, // default role = seller
            'password' => Hash::make($request->password),
        ]);

        return redirect('dashboard')->with('success', 'Account created successfully!');
    }
    
    public function deleteUser(Request $request){
    $user = User::findOrFail($request->id);

    // Prevent admin from deleting their own account (optional)
    if (Auth::id() === $user->id) {
        return back()->with('error', 'You cannot delete your own account.');
    }

    $user->delete();

    return back()->with('success', 'User deleted successfully.');
}

public function uploadProduct(Request $request)
{
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:10000',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:16384',
    ]);
    // Save the product to the database
    $product = new Product();
    $product->name = $request->name;
    $product->description = $request->description;
    $product->seller_id = Auth::user()->id;
    $product->price = $request->price;
    $product->quantity = $request->quantity;
    // Check kama kuna image ime-uploadiwa
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $product->image = file_get_contents($image); // Soma contents za picha
    }
    $product->save();

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Product uploaded successfully!');
}
public function editProduct(Request $request)
{
    $product = Product::findOrFail($request->id);

    $product->name = $request->name;
    $product->price = $request->price;
    $product->quantity = $request->quantity;
    $product->save();

    return redirect()->back()->with('success', 'Product updated successfully.');
}

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function editOrder(Request $request)
{
    $request->validate([
        'id' => 'required|exists:orders,id',
        'status' => 'required|string|in:pending,approved,canceled',
    ]);
    $order = Order::findOrFail($request->id);
    $order->update([
        'status' => $request->status,
    ]);

    return redirect()->back()->with('success', 'Order updated successfully.');
}

public function deleteOrder(Request $request)
{
    $request->validate([
        'id' => 'required|exists:orders,id',
    ]);

    $order = Order::findOrFail($request->id);
    $order->delete();

    return redirect()->back()->with('success', 'Order deleted successfully.');
}
    // Cancel order
public function cancelOrder($id)
{
    $order = Order::findOrFail($id);

    if ($order->status === 'pending') {
        // Restore the product's quantity
        $product = $order->product;
        $product->quantity += $order->quantity;
        $product->save();
        // Delete the order
        $order->delete();
        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }

    return redirect()->back()->with('error', 'You cannot cancel an approved order.');
}
public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'password' => 'required|min:4|confirmed',
    ]);

    // Check if the current password matches
    if (!Hash::check($request->current_password, Auth::user()->password)) {
        return back()->withErrors(['current_password' => 'The current password is incorrect.']);
    }
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $user->password = Hash::make($request->password); // Manually hash the password
    $user->save();
    return back()->with('success', 'Password changed successfully!');
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
    ]);
    $product = Product::findOrFail($id);
    // Ensure the authenticated user is the owner of the product
    if ($product->seller_id !== Auth::id()) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }
    $product->update($request->only(['name', 'description', 'quantity', 'price']));
    return redirect()->back()->with('success', 'Product updated successfully.');
}

// Delete product
public function destroy($id)
{
    $product = Product::findOrFail($id);
    // Ensure the authenticated user is the owner of the product
    if ($product->seller_id !== Auth::id()) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }
    $product->delete();
    return redirect()->back()->with('success', 'Product deleted successfully.');
}
//make order
public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);
    $product = Product::findOrFail($request->product_id);
    // Check if the requested quantity is available
    if ($request->quantity > $product->quantity) {
        return redirect()->back()->with('error', 'Requested quantity exceeds available stock.');
    }
    // Check if an order already exists for the same product, buyer, and seller
    $existingOrder = Order::where('buyer_id', Auth::id())
        ->where('product_id', $product->id)
        ->whereHas('product', function ($query) use ($product) {
            $query->where('seller_id', $product->seller_id);
        })
        ->where('status', 'pending') // Only update pending orders
        ->first();

    if ($existingOrder) {
        // Update the existing order
        $newQuantity = $existingOrder->quantity + $request->quantity;
        // Check if the new quantity exceeds available stock
        if ($newQuantity > $product->quantity) {
            return redirect()->back()->with('error', 'Requested quantity exceeds available stock.');
        }
        $existingOrder->quantity = $newQuantity;
        $existingOrder->total_price = $product->price * $newQuantity;
        $existingOrder->save();
        // Reduce the product quantity
        $product->update(['quantity' => $product->quantity - $request->quantity]);
        return redirect()->back()->with('success', 'Order updated successfully.');
    }
    // Create a new order if no existing order is found
    $order = Order::create([
        'buyer_id' => Auth::id(),
        'product_id' => $product->id,
        'quantity' => $request->quantity,
        'total_price' => $product->price * $request->quantity,
        'status' => 'pending',
    ]);
    // Reduce the product quantity
    $product->update(['quantity' => $product->quantity - $request->quantity]);
    return redirect()->back()->with('success', 'Order placed successfully.');
}
public function editUser(Request $request)
{
    $request->validate([
        'id' => 'required|exists:users,id',//ensure the user exists
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $request->id,//exclude the current user from the unique check
    ]);

    /** @var \App\Models\User $user */
    // Update the user's details
    $user = User::findOrFail($request->id);
    $user->first_name = $request->name;
    $user->email = $request->email;
    $user->save();
    return redirect()->back()->with('success', 'Your profile has been updated successfully.');
}

public function resetPassword(Request $request)
{
    $request->validate([
        'id' => 'required|exists:users,id', // Ensure the user ID exists
        'password' => 'required|string|min:4|confirmed', // Validate the new password
    ]);

    // Find the user by ID
    $user = User::findOrFail($request->id);
    // Update the user's password
    $user->password = bcrypt($request->password);
    $user->save();
    return redirect()->back()->with('success', 'Password reset successfully.');
}

public function viewOrders()
{
    // Fetch orders for products belonging to the authenticated seller
    $orders = Order::whereHas('product', function ($query) {
        $query->where('seller_id', Auth::id());
    })->with(['product', 'buyer.region'])->get();
    return view('dashboard', compact('orders'));
}

public function approveOrder(Order $order)
{// Ensure the order belongs to the authenticated seller's product
    if ($order->product->seller_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }
    // Update the order status to 'approved'
    $order->update(['status' => 'approved']);
    return redirect()->back()->with('success', 'Order approved successfully.');
}
public function getRegions()
    {
        return dd(Region::all());
    }

    public function getDistricts($regionId)
    {
        return District::where('region_id', $regionId)->get();
    }

    public function getWards($districtId)
    {
        return Ward::where('district_id', $districtId)->get();
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap -->
    <link href="/build/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/build/assets/icon/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .header {
            background-color: #1d3557;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            font-size: 1.5rem;
            margin: 0;
        }
        .menu-toggle {
            font-size: 1.5rem;
            cursor: pointer;
            color: white;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            left: -250px;
            top: 0;
            margin-top: 60px;
            background-color: #1d3557;
            color: white;
            transition: 0.3s;
            padding-top: 20px;
        }
        .sidebar.show {
            left: 0;
        }
        .sidebar h4 {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
        .sidebar .list-group-item {
            background: none;
            color: white;
            border: none;
            font-weight: 500;
            padding: 10px 20px;
        }
        .sidebar .list-group-item:hover {
            background: #457b9d;
            cursor: pointer;
        }
        .content {
            margin-left: 0;
            transition: margin-left 0.3s;
            padding: 20px;
        }
        .content.shift {
            margin-left: 250px;
        }
        .card-box {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            width: 18rem;
            background: linear-gradient(135deg,rgb(142, 134, 134), #f8f9fa);
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card-body {
            text-align: center;
            padding: 20px;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #1d3557;
        }
        .card-text {
            font-size: 1rem;
            color: #6c757d;
        }
        .card i {
            font-size: 3rem;
            margin-bottom: 10px;
            color: #1d3557;
        }
        .card i.text-primary {
            color: #007bff;
        }
        .card i.text-success {
            color: #28a745;
        }
        .card i.text-warning {
            color: #ffc107;
        }
        .table-container {
            margin-top: 20px;
        }
        .table {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background-color: #1d3557;
            color: white;
        }
    </style>
</head>
<body>

<div class="header">
    <i class="fas fa-bars menu-toggle" id="menuToggle"></i>
    <h1>Admin Dashboard</h1>
    <span>Welcome, <strong>{{ Auth::user()->first_name }}</strong></span>
</div>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h4 class="text-center"><i class="fas fa-user-shield me-2"></i>Admin Panel</h4>
        <ul class="list-group p-3">
            <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#viewUsersModal">
                <i class="fas fa-users me-2"></i> View Users
            </li>
            <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#uploadedProductsModal">
                <i class="fas fa-box-open me-2"></i> Uploaded Products
            </li>
            <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#viewOrdersModal">
                <i class="fas fa-shopping-cart me-2"></i> View Orders
            </li>
            <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#addSellerModal">
                <i class="fas fa-user-plus me-2"></i> Add Seller
            </li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

        <!-- Main Content -->
        <div class="content" id="mainContent">
        <!-- Cards -->
        <div class="card-box">
            <!-- Users Card -->
            <div class="card shadow-sm p-3" data-bs-toggle="modal" data-bs-target="#viewUsersModal">
                <div class="card-body">
                    <i class="fas fa-users text-primary"></i>
                    <h5 class="card-title">Users</h5>
                    <p class="card-text">Total: <span class="text-success">{{ $users->count() }}</span></p>
                </div>
            </div>

            <!-- Products Card -->
            <div class="card shadow-sm p-3" data-bs-toggle="modal" data-bs-target="#uploadedProductsModal">
                <div class="card-body">
                    <i class="fas fa-box-open text-success"></i>
                    <h5 class="card-title">Products</h5>
                    <p class="card-text">Total: <span class="text-success">{{ $products->count() }}</span></p>
                </div>
            </div>

            <!-- Orders Card -->
            <div class="card shadow-sm p-3" data-bs-toggle="modal" data-bs-target="#viewOrdersModal">
                <div class="card-body">
                    <i class="fas fa-shopping-cart text-warning"></i>
                    <h5 class="card-title">Orders</h5>
                    <p class="card-text">Total: <span class="text-success">{{ $orders->count() }}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Users Modal -->
<div class="modal fade" id="viewUsersModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Users</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="text-center">{{ $user->id }}</td>
                            <td class="text-center">{{ $user->first_name }}</td>
                            <td class="text-center">{{ $user->email }}</td>
                            <td class="text-center">{{ $user->role->name }}</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editUserModal" 
                                        data-id="{{ $user->id }}" 
                                        data-name="{{ $user->first_name }}" 
                                        data-email="{{ $user->email }}">
                                    Edit
                                </button>
                                <button class="btn btn-secondary btn-sm" 
                                         data-bs-toggle="modal" 
                                         data-bs-target="#resetPasswordModal" 
                                         data-id="{{ $user->id }}" 
                                         data-name="{{ $user->first_name }}">
                                         Reset Password
                                        </button>
                                @if(Auth::user()->id !== $user->id)
                                <button class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteConfirmModal" 
                                        data-id="{{ $user->id }}">
                                    Delete
                                </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Products Modal -->
<div class="modal fade" id="uploadedProductsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Uploaded Products</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Seller</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->seller->first_name }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal" 
                                    data-id="{{ $product->id }}" 
                                     data-name="{{ $product->name }}" 
                                        data-price="{{ $product->price }}" 
                                          data-quantity="{{ $product->quantity }}">
                                           Edit
                                     </button>
                                     <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal" 
                                         data-id="{{ $product->id }}">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Orders Modal -->
<div class="modal fade" id="viewOrdersModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Orders</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Buyer</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->product->name }}</td>
                                <td>{{ $order->buyer->first_name }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ number_format(($order->product->price ?? 0) * ($order->quantity ?? 0), 2) }}</td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editOrderModal" data-id="{{ $order->id }}" data-status="{{ $order->status }}">Edit</button>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal" data-id="{{ $order->id }}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Edit User</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            <form method="POST" action="{{ route('editUser') }}" id="editUserForm">
               @csrf
               <input type="hidden" name="id" id="editUserId">
               <div class="mb-3">
                   <label for="editUserName" class="form-label">Name</label>
                   <input type="text" class="form-control" id="editUserName" name="name" value="{{ Auth::user()->first_name }}" required>
               </div>
               <div class="mb-3">
                   <label for="editUserEmail" class="form-label">Email</label>
                   <input type="email" class="form-control" id="editUserEmail" name="email" value="{{ Auth::user()->email }}" required>
                </div>
                <button type="submit" class="btn btn-warning">Save Changes</button>
            </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Delete</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this item?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{route('deleteUser',['id' => $user->id]) }}" id="deleteForm">
                    @csrf
                    <input type="hidden" name="id" id="deleteItemId">
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Delete</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this item?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{route('admin.deleteOrder',['id' => $user->id]) }}" id="deleteForm">
                    @csrf
                    <input type="hidden" name="id" id="deleteItemId">
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- confirm delete product modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Delete</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this item?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{route('seller.deleteProduct',['id' => $user->id]) }}" id="deleteForm">
                    @csrf
                    <input type="hidden" name="id" id="deleteItemId">
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add Seller Modal -->
<div class="modal fade" id="addSellerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Add Seller</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('addseller') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" placeholder="Password (Min 4 chars)" required>
                    </div>
                    <div class="mb-3">
                        <label>Select Region</label>
                        <select name="region_id" id="region" class="form-control" required>
                            <option value="">-- Choose Region --</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Select District</label>
                        <select name="district_id" id="district" class="form-control" required disabled>
                            <option value="">-- Choose District --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Select Ward</label>
                        <select name="ward_id" id="ward" class="form-control" required disabled>
                            <option value="">-- Choose Ward --</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Add Seller</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Edit Product</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.editProduct') }}">
                    @csrf
                    <input type="hidden" name="id" id="editProductId">
                    <div class="mb-3">
                        <label for="editProductName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editProductName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editProductPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="editProductPrice" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="editProductQuantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="editProductQuantity" name="quantity" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Delete</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this product?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="" id="deleteForm">
                    @csrf
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Order Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Edit Order</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            <form method="POST" action="{{ route('admin.editOrder') }}">
                  @csrf
                 <input type="hidden" name="id" id="editOrderId">
                 <div class="mb-3">
                 <label for="editOrderStatus" class="form-label">Status</label>
                 <select class="form-control" id="editOrderStatus" name="status" required>
                 <option value="pending">Pending</option>
                 <option value="approved">Approved</option>
                 <option value="canceled">Canceled</option>
                 </select>
                 </div>
                <button type="submit" class="btn btn-warning">Save Changes</button>
               </form>
            </div>
        </div>
    </div>
</div>
<!--request change password modal-->
<div class="modal fade" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title">Reset Password</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('resetPassword') }}">
                    @csrf
                    <input type="hidden" name="id" id="resetUserId">
                    <div class="mb-3">
                        <label for="resetUserName" class="form-label">User</label>
                        <input type="text" class="form-control" id="resetUserName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-secondary">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="/build/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('mainContent');

    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('show');
        content.classList.toggle('shift');
    });

    const editUserModal = document.getElementById('editUserModal');
    editUserModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const userId = button.getAttribute('data-id');
        const userName = button.getAttribute('data-name');
        const userEmail = button.getAttribute('data-email');

        const editUserId = document.getElementById('editUserId');
        const editUserName = document.getElementById('editUserName');
        const editUserEmail = document.getElementById('editUserEmail');
       // Populate the modal fields
        document.getElementById('editUserId').value = userId;
        document.getElementById('editUserName').value = userName;
        document.getElementById('editUserEmail').value = userEmail;
    });

    const deleteConfirmModal = document.getElementById('deleteConfirmModal');
    deleteConfirmModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');

        const deleteItemId = document.getElementById('deleteItemId');
        deleteItemId.value = id;
    });
    //change password modal
    const resetPasswordModal = document.getElementById('resetPasswordModal');
    resetPasswordModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        // Extract user data from data-* attributes
        const userId = button.getAttribute('data-id');
        const userName = button.getAttribute('data-name');

        // Populate the modal fields
        document.getElementById('resetUserId').value = userId;
        document.getElementById('resetUserName').value = userName;
    });

    // Fetch districts and wards dynamically
    document.addEventListener('DOMContentLoaded', function () {
        const regionSelect = document.getElementById('region');
        const districtSelect = document.getElementById('district');
        const wardSelect = document.getElementById('ward');

        // Fetch districts when a region is selected
        regionSelect.addEventListener('change', function () {
            const regionId = this.value;
            districtSelect.innerHTML = '<option value="">-- Choose District --</option>';
            wardSelect.innerHTML = '<option value="">-- Choose Ward --</option>';
            districtSelect.disabled = true;
            wardSelect.disabled = true;

            if (regionId) {
                fetch(`/districts/${regionId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(district => {
                            districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                        });
                        districtSelect.disabled = false;
                    });
            }
        });

        // Fetch wards when a district is selected
        districtSelect.addEventListener('change', function () {
            const districtId = this.value;
            wardSelect.innerHTML = '<option value="">-- Choose Ward --</option>';
            wardSelect.disabled = true;

            if (districtId) {
                fetch(`/wards/${districtId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(ward => {
                            wardSelect.innerHTML += `<option value="${ward.id}">${ward.name}</option>`;
                        });
                        wardSelect.disabled = false;
                    });
            }
        });
    });

// Edit Product Modal
const editProductModal = document.getElementById('editProductModal');
editProductModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const productId = button.getAttribute('data-id');
    const productName = button.getAttribute('data-name');
    const productPrice = button.getAttribute('data-price');
    const productQuantity = button.getAttribute('data-quantity');

    document.getElementById('editProductId').value = productId;
    document.getElementById('editProductName').value = productName;
    document.getElementById('editProductPrice').value = productPrice;
    document.getElementById('editProductQuantity').value = productQuantity;
});

// Delete Product Modal
const deleteProductConfirmModal = document.getElementById('deleteConfirmModal');
deleteConfirmModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const productId = button.getAttribute('data-id');

    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/delete-product/${productId}`;
});

// Edit Order Modal
const editOrderModal = document.getElementById('editOrderModal');
editOrderModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const orderId = button.getAttribute('data-id');
    const orderStatus = button.getAttribute('data-status');

    document.getElementById('editOrderId').value = orderId;
    document.getElementById('editOrderStatus').value = orderStatus;
});
</script>
</body>
</html>
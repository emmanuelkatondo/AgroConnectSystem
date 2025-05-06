<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="/build/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/build/assets/icon/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-header {
            top: 0;
            left: 0;
            width: 100%;
            position: fixed;
            z-index: 1000;
            background-color: #343a40;
            color: #fff;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .menu-toggle {
            font-size: 1.5rem;
            cursor: pointer;
            color: white;
        }
        .card {
            margin-top: 100px;
        }
        .card:hover {
            transform: scale(1.02);
            transition: all 0.3s ease-in-out;
        }
        .card i {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            margin-top: 70px;
            left: -250px;
            background-color: #343a40;
            color: white;
            transition: all 0.3s ease-in-out;
            z-index: 1000;
        }
        .sidebar.show {
            left: 0;
        }
        .sidebar .list-group-item {
            background: none;
            color: white;
            border: none;
            font-weight: 500;
        }
        .sidebar .list-group-item:hover {
            background: #495057;
            cursor: pointer;
        }
        .content {
            margin-left: 0;
            transition: margin-left 0.3s ease-in-out;
        }
        .content.shift {
            margin-left: 250px;
        }
        .modal-header {
            background-color: #343a40;
            color: white;
            border-bottom: 1px solid #dee2e6;
        }
        .modal-footer {
        border-top: 1px solid #dee2e6;
    }
        .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }
        
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h4 class="text-center py-3"><i class="fas fa-user-shield me-2"></i>Seller Menu</h4>
    <ul class="list-group">
        <!-- Upload Product Menu -->
        <li class="list-group-item" id="menuUploadProduct">
            <i class="fas fa-upload me-2 text-primary"></i>
            <span>Upload Product</span>
        </li>

        <!-- View Products Menu -->
        <li class="list-group-item" id="menuViewProducts">
            <i class="fas fa-boxes me-2 text-success"></i>
            <span>View Products</span>
        </li>

        <!-- View Orders Menu -->
        <li class="list-group-item" id="menuViewOrders">
            <i class="fas fa-shopping-cart me-2 text-warning"></i>
            <span>View Orders</span>
        </li>

        <!-- Reset Password Menu -->
        <li class="list-group-item">
            <button class="btn btn-secondary btn-sm w-100" 
                    data-bs-toggle="modal" 
                    data-bs-target="#resetPasswordModal" 
                    data-id="{{ Auth::user()->id }}" 
                    data-name="{{ Auth::user()->first_name }}">
                    <i class="fas fa-key me-2 text-primary"></i>
                Reset Password
            </button>
        </li>

        <!-- Logout Menu -->
        <li class="list-group-item">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100"><i class="fas fa-sign-out-alt me-2 text-light"></i>Logout</button>
            </form>
        </li>
    </ul>
</div>

<!-- Main Content -->
<div class="content" id="mainContent">
    <div class="container my-5">
        <header class="dashboard-header">
            <i class="fas fa-bars menu-toggle" id="menuToggle"></i>
            <h3>Welcome, {{ Auth::user()->first_name }} <span class="badge bg-secondary">Seller</span></h3>
        </header>

        <div class="row g-4 mt-4">
            <!-- Upload Product -->
            <div class="col-md-4">
                <div class="card text-center shadow-sm p-3" id="uploadProductCard" data-bs-toggle="modal" data-bs-target="#uploadProductModal">
                    <i class="fas fa-upload text-primary"></i>
                    <h5>Upload New Product</h5>
                    <p class="text-muted">Add and showcase your products to potential buyers.</p>
                </div>
            </div>

            <!-- View/Edit Products -->
            <div class="col-md-4">
                <div class="card text-center shadow-sm p-3" id="viewProductsCard" data-bs-toggle="modal" data-bs-target="#viewProductsModal">
                    <i class="fas fa-boxes text-success"></i>
                    <h5>My Products</h5>
                    <p class="text-muted">Edit or delete products you have listed.</p>
                </div>
            </div>

            <!-- View Orders -->
            <div class="col-md-4">
                <div class="card text-center shadow-sm p-3" id="viewOrdersCard" data-bs-toggle="modal" data-bs-target="#orderHistoryModal">
                    <i class="fas fa-shopping-cart text-warning"></i>
                    <h5>Orders</h5>
                    <p class="text-muted">View orders placed by buyers and approve them.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Upload Product Modal -->
<div class="modal fade" id="uploadProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('seller.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="productDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="productDescription" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="productQuantity" class="form-label">Quantity in (kg)</label>
                        <input type="number" class="form-control" id="productQuantity" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="productPrice" class="form-label">Price in TZS</label>
                        <input type="number" class="form-control" id="productPrice" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="productImage" class="form-label">Product Image</label>
                        <input type="file" class="form-control" id="productImage" name="image" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- View Products Modal -->
<div class="modal fade" id="viewProductsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">My Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Quantity (kg)</th>
                            <th>Price (per kg)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                <img src="{{ $product->getImageSrc() }}" style="width: 100px; height: 100px; object-fit: cover;" alt="Product Image">
                            </td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->quantity }} kg</td>
                            <td>{{ $product->price }} TZS</td>
                            <td>
                             <button class="btn btn-warning btn-sm" 
                                     data-bs-toggle="modal" 
                                     data-bs-target="#editProductModal" 
                                     data-id="{{ $product->id }}" 
                                     data-name="{{ $product->name }}" 
                                     data-description="{{ $product->description }}" 
                                     data-quantity="{{ $product->quantity }}" 
                                     data-price="{{ $product->price }}">
                                     Edit
                                    </button>
                                     <button class="btn btn-danger btn-sm" 
                                     data-bs-toggle="modal" 
                                      data-bs-target="#deleteConfirmModal" 
                                       data-id="{{ $product->id }}">
                                        Delete
                                        </button>
                                     </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No products found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- View Orders Modal -->
<div class="modal fade" id="orderHistoryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Order History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Buyer</th>
                                <th>Buyer Email</th>
                                <th>Buyer Phone</th>
                                <th>Location</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                         @php
                                 $grandTotal = 0; // Initialize a variable to store the total price for all products
                         @endphp
                            @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->product->name }}</td>
                                <td>{{ $order->buyer->first_name }} {{ $order->buyer->last_name }}</td>
                                <td>{{ $order->buyer->email }}</td>
                                <td>{{ $order->buyer->phone }}</td>
                                <td>{{ $order->buyer->region->name ?? 'N/A' }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ $order->quantity * $order->product->price }} TZS</td>
                                @php
                                    $grandTotal += $order->quantity * $order->product->price; // Add to grand total
                                @endphp
                                <td>
                                    <span class="badge {{ $order->status === 'pending' ? 'bg-warning' : 'bg-success' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($order->status === 'pending')
                                    <form action="{{ route('seller.approveOrder', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    @else
                                    <span class="text-muted">Approved</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">No orders found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="7" class="text-end">Grand Total:</th>
                                <th>{{ $grandTotal }} TZS</th> <!-- Display the grand total -->
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Confirmation Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('seller.editProduct') }}">
                    @csrf
                    <input type="hidden" name="id" id="editProductId">
                    <div class="mb-3">
                        <label for="editProductName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="editProductName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editProductDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editProductDescription" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editProductQuantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="editProductQuantity" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="editProductPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="editProductPrice" name="price" required>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this product?</p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('seller.deleteProduct') }}">
                    @csrf
                    <input type="hidden" name="id" id="deleteProductId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- change Password Modal -->
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
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const menuToggle = document.getElementById('menuToggle');

    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('show');
        mainContent.classList.toggle('shift');
    });

    document.getElementById('menuViewOrders').addEventListener('click', () => {
        const orderHistoryModal = new bootstrap.Modal(document.getElementById('orderHistoryModal'));
        orderHistoryModal.show();
    });

    // Edit Product Modal
    const editProductModal = document.getElementById('editProductModal');
    editProductModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        // Extract product data from data-* attributes
        const productId = button.getAttribute('data-id');
        const productName = button.getAttribute('data-name');
        const productDescription = button.getAttribute('data-description');
        const productQuantity = button.getAttribute('data-quantity');
        const productPrice = button.getAttribute('data-price');

        // Populate the modal fields
        document.getElementById('editProductId').value = productId;
        document.getElementById('editProductName').value = productName;
        document.getElementById('editProductDescription').value = productDescription;
        document.getElementById('editProductQuantity').value = productQuantity;
        document.getElementById('editProductPrice').value = productPrice;
    });

    // Delete Product Modal
    const deleteConfirmModal = document.getElementById('deleteConfirmModal');
    deleteConfirmModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        // Extract product ID from data-* attributes
        const productId = button.getAttribute('data-id');

        // Populate the hidden input field
        document.getElementById('deleteProductId').value = productId;
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
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buyer Dashboard</title>
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
            background-color:rgb(20, 132, 67);
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
            margin-top: 20px;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            padding: 15px;
        }
        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            margin-top: 70px;
            left: -250px;
            background-color:rgb(11, 143, 48);
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
            background:rgb(6, 155, 41);
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
            background-color:rgb(40, 135, 75);
            color: white;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h4 class="text-center py-3"><i class="fas fa-user me-2"></i>Buyer Menu</h4>
    <ul class="list-group">
        <li class="list-group-item" id="menuViewProducts">View Products</li>
        <li class="list-group-item" id="menuOrderHistory">Order History</li>
         <!-- Reset Password Menu -->
         <li class="list-group-item">
            <button class="btn btn-secondary btn-sm w-100" 
                    data-bs-toggle="modal" 
                    data-bs-target="#resetPasswordModal" 
                    data-id="{{ Auth::user()->id }}" 
                    data-name="{{ Auth::user()->first_name }}">
                    <i class="fas fa-key me-2 text-primary"></i>
                change Password
            </button>
        </li>
        <li class="list-group-item">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100">Logout</button>
            </form>
        </li>
    </ul>
</div>

<!-- Main Content -->
<div class="content" id="mainContent">
    <div class="container my-5">
        <header class="dashboard-header">
            <i class="fas fa-bars menu-toggle" id="menuToggle"></i>
            <h3>Welcome, {{ Auth::user()->first_name }} <span class="badge bg-light text-dark">Buyer</span></h3>
        </header>

        <div class="row g-4 mt-5">
            @foreach($products as $product)
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ $product->getImageSrc() }}" alt="{{ $product->name }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Price: {{ $product->price }} TZS</p>
                        <p class="card-text">Available: {{ $product->quantity }} kg</p>
                        <button class="btn btn-primary btn-sm view-details-btn" 
                                data-product-id="{{ $product->id }}" 
                                data-product-name="{{ $product->name }}" 
                                data-product-description="{{ $product->description }}" 
                                data-product-price="{{ $product->price }}" 
                                data-product-quantity="{{ $product->quantity }}" 
                                data-product-seller_id="{{ $product->seller->first_name }} {{ $product->seller->last_name }}" 
                                data-product-seller-email="{{ $product->seller->email }}"
                                data-product-seller-phone="{{ $product->seller->phone }}"
                                data-seller-location="{{ $product->seller->region->name }}-{{ $product->seller->district->name }}-{{ $product->seller->ward->name }}">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Product Details Modal -->
<div class="modal fade" id="productDetailsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productDetailsTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>description:</strong> <span id="productDescription"></span> </p>
                <p><strong>Price:</strong> <span id="productPrice"></span> TZS</p>
                <p><strong>Available Quantity:</strong> <span id="productQuantity"></span> kg</p>
                <p><strong>Seller name:</strong> <span id="sellerName"></span></p>
                <p><strong>Seller Email:</strong> <span id="sellerEmail"></span></p>
                <p><strong>Seller Phone:</strong> <span id="sellerPhone"></span></p>
                <p><strong>Location:</strong> <span id="sellerLocation"></span></p>
                <button class="btn btn-primary" id="placeOrderBtn" data-bs-toggle="modal" data-bs-target="#placeOrderModal">Place Order</button>
            </div>
        </div>
    </div>
</div>

<!-- Place Order Modal -->
<div class="modal fade" id="placeOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Place Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('buyer.placeOrder') }}" method="POST">
                    @csrf
                    <input type="hidden" id="orderProductId" name="product_id">
                    <div class="mb-3">
                        <label for="orderQuantity" class="form-label">Quantity (in kg)</label>
                        <input type="number" class="form-control" id="orderQuantity" name="quantity" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Confirm Order</button>
                </form>
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
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Order ID</th>
                                <th>Product</th>
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
                                <td>{{ $order->quantity }} kg</td>
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
                                    <button class="btn btn-danger btn-sm" onclick="showCancelModal('{{ $order->id }}')">Cancel</button>
                                    @else
                                    <span class="text-muted">Approved</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No orders found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Grand Total:</th>
                                <th>{{ $grandTotal }} TZS</th>
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

<!-- Cancel order Confirmation Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Cancellation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this order?</p>
            </div>
            <div class="modal-footer">
                <form id="cancelOrderForm" method="POST" action="">
                    @csrf
                    <button type="submit" class="btn btn-danger">Yes, Cancel</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Go Back</button>
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
                    <button type="submit" class="btn btn-secondary">change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="/build/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('mainContent');

        // Sidebar toggle
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            content.classList.toggle('shift');
        });

        // Handle View Details Button
        document.querySelectorAll('.view-details-btn').forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                const productDescription = this.getAttribute('data-product-description');
                const productPrice = this.getAttribute('data-product-price');
                const productQuantity = this.getAttribute('data-product-quantity');
                const sellerName = this.getAttribute('data-product-seller_id');
                const sellerEmail = this.getAttribute('data-product-seller-email');
                const sellerPhone = this.getAttribute('data-product-seller-phone');
                const sellerLocation = this.getAttribute('data-seller-location');

                // Set the modal content
                document.getElementById('productDetailsTitle').textContent = productName;
                document.getElementById('productDescription').textContent = productDescription;
                document.getElementById('productPrice').textContent = productPrice;
                document.getElementById('productQuantity').textContent = productQuantity;
                document.getElementById('sellerName').textContent = sellerName;
                document.getElementById('sellerEmail').textContent = sellerEmail;
                document.getElementById('sellerPhone').textContent = sellerPhone;
                document.getElementById('sellerLocation').textContent = sellerLocation;

                document.getElementById('placeOrderBtn').setAttribute('data-product-id', productId);

                const productDetailsModal = new bootstrap.Modal(document.getElementById('productDetailsModal'));
                productDetailsModal.show();
            });
        });

        // Handle Place Order Button
        document.getElementById('placeOrderBtn').addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');
            document.getElementById('orderProductId').value = productId;
        });

        // Reset Password Modal
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

        // Handle Order History Modal
        document.getElementById('menuOrderHistory').addEventListener('click', function () {
            const orderHistoryModal = new bootstrap.Modal(document.getElementById('orderHistoryModal'));
            orderHistoryModal.show();
        });

        // Function to show the cancel confirmation modal
        window.showCancelModal = function (orderId) {
            const cancelForm = document.getElementById('cancelOrderForm');
            cancelForm.action = `/buyer/cancel-order/${orderId}`; // Update the form action dynamically
            const cancelModal = new bootstrap.Modal(document.getElementById('cancelOrderModal'));
            cancelModal.show();
        };
    });
</script>
</body>
</html>
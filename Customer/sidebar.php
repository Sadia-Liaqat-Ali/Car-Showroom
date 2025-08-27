<!-- sidebar.php -->
<div class="col-md-3 p-0" style="position: fixed; top: 0; left: 0; bottom: 0; width: 250px; z-index: 100;">
    <div class="bg-dark text-white p-3" style="height: 100%; overflow-y: auto;">
        <div class="text-center mb-4">
            <h4>Customer Panel</h4>
        </div>
        <div class="list-group">
            <a href="dashboard.php" class="list-group-item list-group-item-action text-white bg-primary">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="browse-cars.php" class="list-group-item list-group-item-action text-white bg-secondary">
                <i class="bi bi-car-front-fill"></i> Browse Cars
            </a>
             <a href="view-orders.php" class="list-group-item list-group-item-action text-white bg-secondary">
                <i class="bi bi-truck"></i> My Orders
            </a>
            <a href="view_delivery_charges.php" class="list-group-item list-group-item-action text-white bg-secondary">
                <i class="bi bi-truck"></i> View Delivery Charges
            </a>
            <a href="view-installment-alerts.php" class="list-group-item list-group-item-action text-white bg-secondary">
                <i class="bi bi-bell-fill"></i> View Installment Alerts
            </a>
            <a href="logout.php" class="list-group-item list-group-item-action text-white bg-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
</div>

<!-- Internal CSS for sidebar with blue background hover -->
<style>
    .sidebar {
        background-color: #343a40;
        color: #fff;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        width: 250px;
        padding-top: 50px;
    }

    .sidebar a {
        color: white;
        padding: 15px;
        text-decoration: none;
        display: block;
    }

    .sidebar a:hover {
        background-color: #007bff;
        color: white;
    }

    .bg-primary {
        background-color: #007bff !important;
    }

    .bg-secondary {
        background-color: #6c757d !important;
    }

    .bg-danger {
        background-color: #dc3545 !important;
    }
</style>

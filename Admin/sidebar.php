<div class="col-md-3 p-0" style="position: fixed; top: 0; left: 0; bottom: 0; width: 250px; z-index: 100;">
    <div class="bg-dark text-white p-3" style="height: 100%; overflow-y: auto;">
        <div class="text-center mb-4">
            <h4>Admin Panel</h4>
        </div>
        <div class="list-group">
            <a href="dashboard.php" class="list-group-item list-group-item-action text-white bg-primary">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
            <a href="add-cars.php" class="list-group-item list-group-item-action text-white bg-secondary">
                <i class="bi bi-car-front"></i> Add Cars
            </a>
            <a href="manage-cars.php" class="list-group-item list-group-item-action text-white bg-secondary">
                <i class="bi bi-car-front"></i> Manage Cars
            </a>
            <a href="order-management.php" class="list-group-item list-group-item-action text-white bg-secondary">
                <i class="bi bi-file-earmark-text"></i> Orders Tracking
            </a>
            <a href="generate_reports.php" class="list-group-item list-group-item-action text-white bg-secondary">
                <i class="bi bi-bar-chart"></i> Generate Reports
            </a>
            <a href="manage-delivery-charges.php" class="list-group-item list-group-item-action text-white bg-secondary">
                <i class="bi bi-truck"></i> Manage Delivery Charges
            </a>
            <a href="logout.php" class="list-group-item list-group-item-action text-white bg-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
</div>

<!-- Internal CSS for sidebar with blue background hover -->
<style>
    /* Sidebar Styles */
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
        background-color: #007bff; /* Blue background on hover */
        color: white; /* Ensures the text remains white */
    }

    /* You can keep the rest of the classes as it is for normal background color */
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

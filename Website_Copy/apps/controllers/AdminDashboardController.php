<?php
require_once __DIR__ . '/../models/AdminProduct.php';
require_once __DIR__ . '/../models/AdminCustomer.php';
require_once __DIR__ . '/../models/AdminOrder.php';

class AdminDashboardController {

    public function index() {
        if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin'){
            header("Location: index.php?page=login");
            exit;
        }

        // Use session to store messages across redirects
        if(!isset($_SESSION['success_message'])) $_SESSION['success_message'] = '';
        if(!isset($_SESSION['error_message'])) $_SESSION['error_message'] = '';

        // Handle GET deletions
        if(isset($_GET['delete_product'])){
            $deleted = AdminProduct::delete($_GET['delete_product']);
            $_SESSION['success_message'] = $deleted ? "Product deleted successfully!" : "Failed to delete product.";
            header("Location: index.php?page=admin_dashboard");
            exit;
        }

        if(isset($_GET['delete_customer'])){
            $deleted = AdminCustomer::delete($_GET['delete_customer']);
            $_SESSION['success_message'] = $deleted ? "Customer deleted successfully!" : "Failed to delete customer.";
            header("Location: index.php?page=admin_dashboard");
            exit;
        }

        if(isset($_GET['delete_order'])){
            $deleted = AdminOrder::delete($_GET['delete_order']);
            $_SESSION['success_message'] = $deleted ? "Order deleted successfully!" : "Failed to delete order.";
            header("Location: index.php?page=admin_dashboard");
            exit;
        }

        // Handle POST updates/adds
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            try {
                // Products
                if(isset($_POST['add_product'])){
                    AdminProduct::add($_POST, $_FILES);
                    $_SESSION['success_message'] = "Product added successfully!";
                }
                if(isset($_POST['update_product'])){
                    AdminProduct::update($_POST['id'], $_POST);
                    $_SESSION['success_message'] = "Product updated successfully!";
                }

                // Customers
                if(isset($_POST['add_customer'])){
                    AdminCustomer::add($_POST);
                    $_SESSION['success_message'] = "Customer added successfully!";
                }
                if(isset($_POST['update_customer'])){
                    AdminCustomer::update($_POST['cust_id'], $_POST);
                    $_SESSION['success_message'] = "Customer updated successfully!";
                }

                // Orders
                if(isset($_POST['update_order'])){
                    AdminOrder::updateStatus($_POST['order_id'], $_POST['status']);
                    $_SESSION['success_message'] = "Order status updated successfully!";
                }
                if(isset($_POST['add_order'])){
                    AdminOrder::add($_POST);
                    $_SESSION['success_message'] = "Order added successfully!";
                }
                if(isset($_POST['update_full_order'])){
                    AdminOrder::update($_POST['order_id'], $_POST);
                    $_SESSION['success_message'] = "Order updated successfully!";
                }

            } catch(Exception $e){
                $_SESSION['error_message'] = $e->getMessage();
            }

            header("Location: index.php?page=admin_dashboard");
            exit;
        }

        // Fetch all data
        $products = AdminProduct::getAll();
        $customers = AdminCustomer::getAll();
        $orders = AdminOrder::getAll();

        // Read messages
        $success_message = $_SESSION['success_message'];
        $error_message = $_SESSION['error_message'];

        // Reset messages
        $_SESSION['success_message'] = '';
        $_SESSION['error_message'] = '';

        require __DIR__ . '/../views/admin_dashboard.php';
    }
}

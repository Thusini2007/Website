<?php
session_start();
require_once 'db.php';

// Autoloader for controllers and models
spl_autoload_register(function($class){
    $controllerPath = __DIR__ . '/apps/controllers/' . $class . '.php';
    $modelPath = __DIR__ . '/apps/models/' . $class . '.php';

    if(file_exists($controllerPath)){
        require_once $controllerPath;
    } elseif(file_exists($modelPath)){
        require_once $modelPath;
    }
});

// Determine page
$page = $_GET['page'] ?? 'home';

// Routing
switch($page){

    case 'home':
        if(class_exists('HomeController')) (new HomeController())->index();
        else echo "HomeController not found.";
        break;

    case 'about':
        if(class_exists('HomeController')) (new HomeController())->about();
        else echo "HomeController not found.";
        break;

    case 'faq':
        if(class_exists('FaqController')) (new FaqController())->index();
        else echo "FaqController not found.";
        break;

    case 'contactus':
        if(class_exists('ContactController')) (new ContactController())->index();
        else echo "ContactController not found.";
        break;

    case 'products':
        if(class_exists('ProductController')) (new ProductController())->index();
        else echo "ProductController not found.";
        break;

    case 'cart':
        if(class_exists('CartController')) (new CartController())->index();
        else echo "CartController not found.";
        break;

    case 'checkout':
        if(class_exists('CheckoutController')) (new CheckoutController())->index();
        else echo "CheckoutController not found.";
        break;

    case 'login':
        if(class_exists('LoginController')) (new LoginController())->index();
        else echo "LoginController not found.";
        break;

    case 'register':
        if(class_exists('RegisterController')) (new RegisterController())->index();
        else echo "RegisterController not found.";
        break;

    case 'logout':
        if(class_exists('LogoutController')) (new LogoutController())->index(); // <-- fixed
        else echo "LogoutController not found.";
        break;

    case 'admin_dashboard':
        if(class_exists('AdminDashboardController')) (new AdminDashboardController())->index();
        else echo "AdminDashboardController not found.";
        break;

    case 'customer_dashboard':
        if(class_exists('CustomerDashboardController')) (new CustomerDashboardController())->index();
        else echo "CustomerDashboardController not found.";
        break;

    default:
        if(class_exists('HomeController')) (new HomeController())->index();
        else echo "HomeController not found.";
        break;
}

<?php
session_start();

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Services\Auth\AuthService;
use App\Services\User\UserService; 

// Instantiate the UserService class
$userService = new UserService(); 

// Instantiate the AuthService class and inject the UserService instance
$authService = new AuthService($userService);

// Check if the user is already logged in, redirect to intended page
if ($authService->isLoggedIn()) {
    header('Location: index.php'); // Replace with the actual intended page
    exit();
}

// Initialize an error message variable
$error = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Authenticate user using AuthService
    $loginResult = $authService->login($username, $password);
    if ($loginResult) {
        header('Location: dashboard.php');
        exit();
    } elseif (!$loginResult) {
        $error = "Invalid credentials. Please try again.";
    } else {
        $error = $loginResult; // Display database error message
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet">
    <style>
        /* Add your CSS styles here */
        .bg-image-vertical {
            position: relative;
            overflow: hidden;
            background-repeat: no-repeat;
            background-position: right center;
            background-size: auto 100%;
        }
        @media (min-width: 1025px) {
            .h-custom-2 {
                height: 100%;
            }
        }
    </style>
</head>
<body>

<section class="vh-100 bg-image-vertical">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 text-black">
                <div class="px-5 ms-xl-4">
                    <i class="fas fa-crow fa-2x me-3 pt-5 mt-xl-4" style="color: #709085;"></i>
                    <span class="h1 fw-bold mb-0">Logo</span>
                </div>
                <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
                    
                    <form style="width: 23rem;" method="POST">
                    <?php if (isset($error)) : ?>
                        <p class="text-danger"><?= $error ?></p>
                    <?php endif; ?>
                        <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log in</h3>
                        <div class="form-outline mb-4">
                            <input type="text" id="form2Example18" class="form-control form-control-lg" name="username" required />
                            <label class="form-label" for="form2Example18">Username</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="password" id="form2Example28" class="form-control form-control-lg" name="password" required />
                            <label class="form-label" for="form2Example28">Password</label>
                        </div>
                        <div class="pt-1 mb-4">
                            <button class="btn btn-info btn-lg btn-block" type="submit">Login</button>
                        </div>
                        <p class="small mb-5 pb-lg-2"><a class="text-muted" href="#!">Forgot password?</a></p>
                        <p>Don't have an account? <a href="#!" class="link-info">Register here</a></p>
                    </form>
                </div>
            </div>
            <div class="col-sm-6 px-0 d-none d-sm-block">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img3.webp"
                     alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
            </div>
        </div>
    </div>
</section>

<script

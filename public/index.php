<?php
session_start();

require_once dirname( __DIR__ ) . '/vendor/autoload.php';

use App\Services\Auth\AuthService;
use App\Services\User\UserService;
use App\Services\Storage\StorageService;

// Instantiate the UserService class
$userService = new UserService();

// Instantiate the AuthService class and inject the UserService instance
$authService = new AuthService( $userService );

// Check if the user is already logged in, redirect to intended page
if ( $authService->isLoggedIn() ) {
	header( 'Location: dashboard.php' );
	exit();
}

// Instantiate the StorageService
$storageService = new StorageService();

// Initialize an error message variable
$error = '';

// Variable to store sitemap content
$sitemapContent = '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>View Sitemap</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css">
	<style>
		body {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
			margin: 0;
			background-color: #f0f0f0;
		}

		.button-container {
			text-align: center;
		}

		.view-button {
			display: inline-block;
			padding: 15px 30px;
			font-size: 18px;
			background-color: #007bff;
			color: white;
			border: none;
			border-radius: 5px;
			cursor: pointer;
		}

		.view-button:hover {
			background-color: #0056b3;
		}

		.login-button {
			position: absolute;
			top: 10px;
			right: 10px;
			padding: 10px 20px;
			font-size: 14px;
			background-color: #28a745;
			color: white;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			text-decoration: none;
		}

		.login-button:hover {
			background-color: #218838;
		}
	</style>
</head>

<body>
	<a href="login.php" class="login-button">Login</a>
	<div class="button-container">
		<button id="viewResultsBtn" class="view-button">View Current Sitemap</button>
	</div>
	<div class="modal fade" id="resultsModal" tabindex="-1" aria-labelledby="resultsModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id=""> Current Sitemap</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<?php
					$sitemapContent = $storageService->viewSiteMapFile();
					if ( $sitemapContent !== false ) {
						echo $sitemapContent;
					} else {
						echo '<div class="alert alert-info">No available sitemap.</div>';
					}
					?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		document.getElementById("viewResultsBtn").addEventListener("click", function() {
			$('#resultsModal').modal('show');
		});
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
</body>

</html>

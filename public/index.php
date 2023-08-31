<?php
session_start();

require_once dirname( __DIR__ ) . '/vendor/autoload.php';

use App\Services\Auth\AuthService;
use App\Services\User\UserService;
use App\Services\Crawler\CrawlerService;
use App\Services\Storage\StorageService;

// Instantiate the UserService class
$userService = new UserService();

// Instantiate the AuthService class and inject the UserService instance
$authService = new AuthService( $userService );

// Check if the user is already logged in, redirect to intended page
if ( ! $authService->isLoggedIn() ) {
	header( 'Location: login.php' );

	exit();
}

// Instantiate the StorageService
$storageService = new StorageService();
$guzzleClient   = new \GuzzleHttp\Client();

// Instantiate the CrawlerService class
$crawlerService = new CrawlerService( $guzzleClient, $storageService );

// Initialize an error message variable
$error = '';

// Handle crawl form submission
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	$url = $_POST['url'];

	// Verify url is valid
	$isValidUrl = $crawlerService->isValidUrl( $url );

	if ( ! $isValidUrl ) {
		$error = 'Enter a valid URL';
	} else {

		$internalLinks = $crawlerService->crawlHomePage( $url );

		try {


			$lastestResultCount = $storageService->getLastCrawlResultsCount();

			// There are no crawls
			if ( $latestResultCount > 0 ) {
				$storageService->deleteLastCrawlResults();

				// delete existing site map file
				$storageService->deleteSiteMapFile();
			}

			$storageService->storeResults( $internalLinks );

			// create sitemap file
			$storageService->createSitemapHtmlFile( $internalLinks );
		} catch ( \Exception $e ) {
			$error = 'Error saving data';
			exit();
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Settings</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css">
	<style>
		.intro {
			height: 100%;
		}

		/* .gradient-custom {
			background: #fa709a;
			background: -webkit-linear-gradient(to bottom right, rgba(250, 112, 154, 1), rgba(254, 225, 64, 1));
			background: linear-gradient(to bottom right, rgba(250, 112, 154, 1), rgba(254, 225, 64, 1));
		} */
	</style>
</head>

<body>

	<section class="intro">
		<div class="mask d-flex align-items-center h-100 gradient-custom">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 col-lg-9 col-xl-7">
						<div class="card">
							<div class="card-body p-4 p-md-5">
								<h3 class="mb-4 pb-2">Trigger Crawl 🐍</h3>

								<form method="POST">
									<?php if ( isset( $error ) ) : ?>
										<p class="text-danger"><?php echo $error; ?></p>
									<?php endif; ?>
									<div class="row">
										<div class="col-md-12 mb-4">
											<div class="form-outline">
												<input type="text" id="url" name="url" class="form-control" required />
												<label class="form-label" for="url">Enter url to crawl</label>
											</div>
										</div>
									</div>


									<div class="row">
										<div class="col-12">
											<div class="mt-4">
												<input class="btn btn-warning btn-lg" type="submit" value="Crawl" />
											</div>
										</div>
									</div>

								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
</body>

</html>

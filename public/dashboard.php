<?php
session_start();

require_once dirname( __DIR__ ) . '/vendor/autoload.php';

use App\Services\Auth\AuthService;
use App\Services\User\UserService;
use App\Services\Database\RedisService;
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

// Logout button handling
if ( isset( $_POST['logout'] ) ) {
	$authService->logout();
	header( 'Location: login.php' );
	exit();
}


// Instantiate the StorageService
$storageService = new StorageService();
$guzzleClient   = new \GuzzleHttp\Client();

// Instantiate redis service
$redis = new RedisService();

// Instantiate the CrawlerService class
$crawlerService = new CrawlerService( $guzzleClient, $storageService );

// Initialize an error message variable
$error = '';

// Initialize success message variable
$successMessage = '';

$crawlTriggered = false;

// Handle crawl form submission
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	$url = $_POST['url'];

	// Verify url is valid
	if ( ! $crawlerService->isValidUrl( $url ) ) {
		$error = 'Enter a valid URL';
	}

	try {
		$internalLinks = $crawlerService->crawlHomePage( $url );

		if ( ! $internalLinks || count( $internalLinks ) < 1 ) {
			$error = 'Crawl unsuccessful. No crawl results';
		} else {

			// Delete existing results and sitemap
			$latestResultCount = $storageService->getLastCrawlResultsCount();
			if ( $latestResultCount > 0 ) {
				$storageService->deleteLastCrawlResults();
				$storageService->deleteSiteMapFile();
			}

			// Store results and create a sitemap
			$storageService->storeResults( $internalLinks );
			$storageService->createSitemapHtmlFile( $internalLinks );

			$crawlTriggered = true;

			$redis->setKeyValue( $crawlerService::CRAWL_CAHCE_KEY, $crawlerService::CRAWL_CACHE_SECONDS, $crawlTriggered );

			$successMessage = 'Crawl successful and data saved';
		}
	} catch ( \Exception $e ) {
		error_log( $e->getMessage() . '\n', 3, '/var/log/error.log' );
		$error = 'Error during crawling or data storage';
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Settings</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css">
	<style>
		.intro {
			height: 100%;
		}

		.logout-btn {
			position: absolute;
			top: 10px;
			right: 10px;
		}

		#viewResultsBtn {
			position: absolute;
			top: 10px;
			right: 150px;
			/* Adjust the value to your preference */
		}
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
												<input type="url" id="url" name="url" class="form-control" required />
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
			<div class="d-flex justify-content-between align-items-center mt-3">
				<form method="POST" class="logout-btn">
					<input type="hidden" name="logout" value="1">
					<button class="btn btn-danger btn-lg" type="submit">Logout</button>
				</form>
				<button class="btn btn-primary btn-lg" id="viewResultsBtn">View Sitemap List</button>
			</div>
		</div>
	</section>
	<div class="modal fade" id="resultsModal" tabindex="-1" aria-labelledby="resultsModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="resultsModalLabel">Sitemap</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body"></div>
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
		<?php if ( $_SERVER['REQUEST_METHOD'] === 'POST' && empty( $error ) ) : ?>
			alert("<?php echo $successMessage; ?>");
		<?php elseif ( $_SERVER['REQUEST_METHOD'] === 'POST' && ! empty( $error ) ) : ?>
			alert("<?php echo $error; ?>");
		<?php endif; ?>

		document.getElementById("viewResultsBtn").addEventListener("click", function() {
			$('#resultsModal').modal('show');
		});
	</script>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
</body>

</html>

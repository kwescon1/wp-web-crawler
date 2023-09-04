<?php

namespace App\Services\Crawler;

use App\Services\Storage\StorageServiceInterface;
// use \GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

class CrawlerService implements CrawlerServiceInterface {




	private $storageService;
	private $client;

	public function __construct( ClientInterface $client, StorageServiceInterface $storageService ) {

		$this->storageService = $storageService;
		$this->client         = $client;
	}


	/**
	 * @param string $url
	 *
	 * verify string is a url
	 *
	 * @return bool
	 */
	public function isValidUrl( string $url ): bool {
		return filter_var( $url, FILTER_VALIDATE_URL );
	}


	/**
	 * @param string $url
	 *
	 * crawl and extract internal hyperlinks
	 *
	 * since we are exctracting content from just the homepage
	 * parse the incoming url
	 * extract the host which is the root url(homepage)
	 * crawl the homepage
	 *
	 * @return array|NULL
	 */

	public function crawlHomePage( string $url ): ?array {

		$parsedUrl = parse_url( $url );

		$rootUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];

		$res = $this->client->request( 'GET', $rootUrl );

		// This regex extracts URLs from HTML anchor (a) tags.
		$regex = '/<a\s+(?:[^>]*?\s+)?href="([^"]*)"/i';

		// Use regular expression to extract links
		preg_match_all( $regex, $res->getBody()->getContents(), $matches );

		if ( empty( $matches[1] ) ) {
			return null;
		}

		$internalLinks = [];

		foreach ( $matches[1] as $link ) {
			// extract internal links
			// checks if the link starts with a slash /, which indicates that it's a relative internal link.

			if ( strpos( $link, '/' ) === 0 ) {
				// return full link
				$internalLinks[] = $rootUrl . $link;
			}
		}

		// create hompage html file
		$this->storageService->createHomePageHtmlFile( $res->getBody() );

		$path = dirname( dirname( dirname( __DIR__ ) ) ) . '/output' . '/url.txt';
		// store url in file for cron purposes
		file_put_contents( $path, $rootUrl );

		// remove duplicate links
		return array_unique( $internalLinks );
	}
}

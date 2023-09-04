<?php


require_once __DIR__ . '/../../../vendor/autoload.php';



use App\Services\Cron\CronScript;
use \GuzzleHttp\Client;
use App\Services\Storage\StorageService;
use App\Services\Crawler\CrawlerService;

$client     = new Client();
$storage    = new StorageService();
$crawler    = new CrawlerService( $client, $storage );
$cronScript = new CronScript( $crawler );


$cronScript->hourlyCrawlCron();

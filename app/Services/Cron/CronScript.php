<?php

namespace App\Services\Cron;

use App\Services\Crawler\CrawlerServiceInterface;
use App\Services\Database\RedisService;

class CronScript
{
    private $crawlerService;
    private $redisClient;

    public function __construct(CrawlerServiceInterface $crawlerService)
    {

        $this->crawlerService = $crawlerService;
        $this->redisClient = new RedisService;
    }

    public function hourlyCrawlCron()
    {
        $cache = $this->redisClient->getKeyValue($this->crawlerService::CRAWL_CAHCE_KEY);

        //if cache key value is false, no need to run hourly cron
        if (!$cache) {
            return;
        }

        $path = dirname(dirname(dirname(__DIR__))) . '/output' . '/url.txt';
        //store url in file for cron purposes
        $url = file_get_contents($path);


        $string = "Running cron at. This was successful " . date("Y-m-d H:i:s");

        try {
            $this->crawlerService->crawlHomePage($url);

            // Log crawl output to /var/log/cron.log
            return error_log("Crawl result: " . print_r($string, true), 3, '/var/log/cron.log');
        } catch (\Exception $e) {
            error_log("Cron failed. Below is the error \n" . $e->getMessage());
        }
    }
}

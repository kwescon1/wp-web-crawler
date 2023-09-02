<?php

namespace App\Services\Cron;

use App\Services\Crawler\CrawlerServiceInterface;

class CronScript
{
    private $crawlerService;

    public function __construct(CrawlerServiceInterface $crawlerService)
    {

        $this->crawlerService = $crawlerService;
    }

    public function hourlyCrawlCron()
    {
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

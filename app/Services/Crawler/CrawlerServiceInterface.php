<?php

namespace App\Services\Crawler;

interface CrawlerServiceInterface
{

    public const CRAWL_CAHCE_KEY = 'crawl';
    public const CRAWL_CACHE_SECONDS = 3600 * 24;

    public function isValidUrl(string $url): bool;

    public function crawlHomePage(string $url): ?array;
}

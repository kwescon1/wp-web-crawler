<?php

namespace App\Services\Crawler;

interface CrawlerServiceInterface{
    public function isValidUrl(string $url) : bool;

    public function crawlHomePage(string $url) :? array;
}
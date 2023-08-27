<?php

namespace App\Services\Storage;

interface StorageServiceInterface{

    public function getLastCrawlResultsCount();

    public function deleteLastCrawlResults(): bool;

    public function deleteSiteMapFile():bool;

    public function createHomePageHtmlFile($data):void;
}
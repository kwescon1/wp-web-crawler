<?php

namespace App\Services\Storage;

use App\Models\Result;
use App\Services\Database\DatabaseService;

class StorageService extends DatabaseService implements StorageServiceInterface
{

    /**
     * Define the path of the output folder 
     * 
     * @var $outputFolderPath
     */
    private $outputFolderPath;
    

    public function __construct() {

        // initialize the database connection needed for database operations in the child class.
        parent::__construct(); 

        $this->outputFolderPath = dirname(dirname(dirname(__DIR__))) . '/output';
    }


    public const SITEMAP = "sitemap.html";
    public const HOMEPAGE = "homepage.html";

    /**
     * @var $table
     */
    private $table = Result::TABLE;

    public function storeResults($internalLinks)
    {
        $insertQuery = "INSERT INTO crawl_results (url) VALUES (:url)";

        $stmt = $this->connection->prepare($insertQuery);

        foreach ($internalLinks as $link) {
            $stmt->bindParam(':url', $link);
            $stmt->execute();
        }
    }

    public function getLastCrawlResultsCount()
    {

        $selectQuery = "SELECT COUNT(*) FROM {$this->table}";
        
return $this->connection->query($selectQuery)->fetchColumn();

    }

    public function deleteLastCrawlResults(): bool
    {
        $deleteQuery = "DELETE FROM {$this->table} WHERE created_at < NOW()";

        $statement = $this->connection->prepare($deleteQuery);

        return $statement->execute();

    }

    private function verifySiteMapFileExists(): bool
    {

        $this->createOutputFolder($this->outputFolderPath);

        return file_exists($this->outputFolderPath . '/' . self::SITEMAP);
    }

    public function verifyHomePageFileExists(): bool
    {

        $this->createOutputFolder($this->outputFolderPath);

        return file_exists($this->outputFolderPath . '/' . self::HOMEPAGE);
    }

    // Create a sitemap.html file
    public function createSitemapHtmlFile(array $internalLinks) {

        $this->createOutputFolder($this->outputFolderPath);

        $sitemapContent = "<ul>";
        foreach ($internalLinks as $link) {

            $sitemapContent .= "<li><a href='{$link}'>{$link}</a></li>";
        }

        $sitemapContent .= "</ul>";
        file_put_contents($this->outputFolderPath . '/' . self::SITEMAP, $sitemapContent);
    }

     // Create a homepage.html file
     public function createHomePageHtmlFile($data):void {

        $this->createOutputFolder($this->outputFolderPath);
        
        file_put_contents($this->outputFolderPath . '/' . self::HOMEPAGE, $data);
    }

    public function deleteSiteMapFile(): bool
    {
        if (!$this->verifySiteMapFileExists()) {
            return false;
        }
        return unlink($this->outputFolderPath . '/' . self::SITEMAP);
    }

    private function createOutputFolder($outputFolderPath): void
    {
        if (!is_dir($outputFolderPath)) {
            mkdir($outputFolderPath);
        }
    }

}

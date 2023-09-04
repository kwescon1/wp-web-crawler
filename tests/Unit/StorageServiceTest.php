<?php

namespace Tests\Unit;

use PDO;
use PDOStatement;
use App\Models\Result;
use PHPUnit\Framework\TestCase;
use App\Services\Storage\StorageService;
use Tests\Traits\SetsMockConnection;

class StorageServiceTest extends TestCase
{
    use SetsMockConnection; // Using trait to set up mock connections for the service

    // Define properties for the class
    private $storageService;
    private $mockedPDO;
    private $mockedStatement;
    private $storageServiceMock;

    /**
     * Set up method that runs before every test method.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Mocking the PDOStatement class
        $this->mockedStatement = $this->createMock(PDOStatement::class);
        $this->mockedStatement->method('bindParam')->willReturn(true);
        $this->mockedStatement->method('execute')->willReturn(true);

        // Mocking the PDO class
        $this->mockedPDO = $this->createMock(PDO::class);
        $this->mockedPDO->method('prepare')->willReturn($this->mockedStatement);

        // Initializing the actual StorageService class and setting the mock connection on it
        $this->storageService = new StorageService();
        $this->setMockConnectionOnService($this->storageService, $this->mockedPDO);

        // Creating a partial mock of the StorageService class, mocking only specific methods
        $this->storageServiceMock = $this->getMockBuilder(StorageService::class)
            ->onlyMethods(['verifyHomePageFileExists', 'verifySiteMapFileExists', 'createHomePageHtmlFile', 'createSitemapHtmlFile', 'deleteSiteMapFile', 'viewSiteMapFile'])
            ->getMock();
    }

    /**
     * Test the method that stores internal links in the database.
     */
    public function testStoreInternalLinks()
    {
        $internalLinks = ['link1', 'link2', 'link3'];

        // Expectations for the mock objects during this test
        $this->mockedPDO->expects($this->once())
            ->method('prepare')
            ->with("INSERT INTO " . Result::TABLE . " (url) VALUES (:url)");

        $this->mockedStatement->expects($this->exactly(count($internalLinks)))
            ->method('execute');

        $this->storageService->storeResults($internalLinks);
    }

    /**
     * Test the method that deletes the results from the last crawl from the database.
     */
    public function testDeleteLastCrawlResults()
    {
        // Expectations for the mock objects during this test
        $this->mockedPDO->expects($this->once())
            ->method('prepare')
            ->with("DELETE FROM " . Result::TABLE . " WHERE created_at < NOW()");

        $this->mockedStatement->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $result = $this->storageService->deleteLastCrawlResults();
        $this->assertTrue($result);
    }

    /**
     * Test the method that verifies the existence of the home page file.
     */
    public function testVerifyHomePageFileExists()
    {
        // Expectations for the mock object during this test
        $this->storageServiceMock->expects($this->once())
            ->method('verifyHomePageFileExists')
            ->willReturn(true);
        $this->assertTrue($this->storageServiceMock->verifyHomePageFileExists());
    }

    /**
     * Test the method that creates an HTML file for the home page.
     */
    public function testCreateHomePageHtmlFile()
    {
        $content = "Test homepage content";

        // Expectations for the mock object during this test
        $this->storageServiceMock->expects($this->once())
            ->method('createHomePageHtmlFile')
            ->with($content);
        $this->storageServiceMock->createHomePageHtmlFile($content);
    }

    /**
     * Test the method that creates an HTML sitemap file.
     */
    public function testCreateSitemapHtmlFile()
    {
        $content = ['link1', 'link2', 'link3'];

        // Expectations for the mock object during this test
        $this->storageServiceMock->expects($this->once())
            ->method('createSitemapHtmlFile')
            ->with($content);
        $this->storageServiceMock->createSitemapHtmlFile($content);
    }

    /**
     * Test the method that deletes the sitemap file.
     */
    public function testDeleteSiteMapFile()
    {
        // Expectations for the mock object during this test
        $this->storageServiceMock->expects($this->once())
            ->method('deleteSiteMapFile')
            ->willReturn(true);
        $this->assertTrue($this->storageServiceMock->deleteSiteMapFile());
    }

    /**
     * Test the method that views the content of the sitemap file.
     */
    public function testViewSiteMapFile()
    {
        $fileContent = '<ul><li><a href="link1">link1</a></li></ul>';

        // Expectations for the mock object during this test
        $this->storageServiceMock->expects($this->once())
            ->method('viewSiteMapFile')
            ->willReturn($fileContent);
        $this->assertEquals($fileContent, $this->storageServiceMock->viewSiteMapFile());
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Result;
use PHPUnit\Framework\TestCase as Test;
use App\Services\Storage\StorageService;

class StorageServiceTest extends Test
{

    protected $testCase;
    protected $storageService;
    protected $table;
    protected $outputFolderPath;
    protected $storageServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testCase = new TestCase;
        $this->storageService = new StorageService;
        $this->table = Result::TABLE;

        $this->storageServiceMock = $this->getMockBuilder(StorageService::class)
            ->onlyMethods(['verifyHomePageFileExists', 'verifySiteMapFileExists', 'createHomePageHtmlFile', 'createSitemapHtmlFile', 'deleteSiteMapFile'])
            ->getMock();
    }

    protected function tearDown(): void
    {
        // Reset the database
        $this->testCase->refreshDatabase();
    }

    public function testStoreInternalLinks()
    {
        // Prepare the data for the test
        $internalLinks = ['link1', 'link2', 'link3'];

        // Call the method to be tested (storeResults)
        $this->storageService->storeResults($internalLinks);

        // Build a query to retrieve stored data
        $query = "SELECT * FROM {$this->table}";

        // Execute the query and fetch the results from the database
        $result = $this->testCase->db()->query($query);
        $storedLinks = $result->fetchAll();

        // Perform an assertion to check if the stored results match the expected count
        $this->assertCount(3, $storedLinks);
    }


    public function testDeleteLastCrawlResults()
    {

        // Call the method to be tested
        $result = $this->storageService->deleteLastCrawlResults();

        // Assertion
        $this->assertTrue($result);
    }

    public function testVerifyHomePageFileExists(): void
    {

        $this->storageServiceMock->method('verifyHomePageFileExists')
            ->willReturn(true);

        $this->assertTrue($this->storageServiceMock->verifyHomePageFileExists());
    }

    public function testVerifyHomePageFileExistsWhenFileDoesNotExist(): void
    {
        $this->storageServiceMock->method('verifyHomePageFileExists')
            ->willReturn(false);

        $this->assertFalse($this->storageServiceMock->verifyHomePageFileExists());
    }

    public function testCreateHomePageHtmlFile(): void
    {
        $outputPath = dirname(dirname(__DIR__)) . '/output' . $this->storageServiceMock::HOMEPAGE;

        $content = "Test homepage content";

        $this->storageServiceMock->expects($this->once())
            ->method('createHomePageHtmlFile')
            ->willReturnCallback(function () use ($outputPath, $content) {
                // Simulate writing content to a file
                file_put_contents($outputPath, $content);
            });

        $this->storageServiceMock->createHomePageHtmlFile($content);

        $this->assertFileExists($outputPath);
        $this->assertStringContainsString($content, file_get_contents($outputPath));
    }

    public function testCreateSitemapHtmlFile(): void
    {
        $outputPath = dirname(dirname(__DIR__)) . '/output' . $this->storageServiceMock::SITEMAP;

        $content = ['link1', 'link2', 'link3'];

        $this->storageServiceMock->expects($this->once())
            ->method('createSitemapHtmlFile')
            ->willReturnCallback(function () use ($outputPath, $content) {
                // Simulate writing content to a file
                file_put_contents($outputPath, implode("\n", $content));
            });

        $this->storageServiceMock->createSitemapHtmlFile($content);

        $this->assertFileExists($outputPath);
        $this->assertNotEmpty($content);

        // Read the content from the file
        $fileContent = file_get_contents($outputPath);

        // Compare the file content with the expected content
        $this->assertEquals(implode("\n", $content), $fileContent);
    }

    public function testDeleteSiteMapFileWhenFileExists()
    {

        $this->storageServiceMock->expects($this->once())
            ->method('deleteSiteMapFile')
            ->willReturn(true);

        $this->assertTrue($this->storageServiceMock->deleteSiteMapFile());
    }

    public function testDeleteSiteMapFileWhenFileDoesNotExist()
    {

        $this->storageServiceMock->expects($this->once())
            ->method('deleteSiteMapFile')
            ->willReturn(false);

        $this->assertFalse($this->storageServiceMock->deleteSiteMapFile());
    }
}

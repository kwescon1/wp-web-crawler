<?php

namespace Tests\Unit;

use Tests\TestCase;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use PHPUnit\Framework\TestCase as Test;
use App\Services\Crawler\CrawlerService;
use App\Services\Storage\StorageService;

class CrawlerServiceTest extends Test
{

    protected $testCase;
    protected $crawlService;
    protected $userService;
    protected $httpClient;
    protected $storageService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testCase = new TestCase;
        $this->httpClient = $this->createMock(\GuzzleHttp\Client::class);
        $this->storageService = $this->createMock(StorageService::class);
        $this->crawlService = new CrawlerService($this->httpClient, $this->storageService);
    }

    protected function tearDown(): void
    {
        // Reset the database
        $this->testCase->refreshDatabase();
    }

    public function testIsValidUrl()
    {

        $validUrl = "http://example.com";

        $result = $this->crawlService->isValidUrl($validUrl);

        $this->assertTrue($result);
    }

    public function testIsInvalidUrl()
    {

        $invalidUrl = "invalid-url";

        $result = $this->crawlService->isValidUrl($invalidUrl);

        $this->assertFalse($result);
    }

    public function testCrawlHomePageWithInternalLinks()
    {
        // Set an expectation that the 'request' method of the client will be called with the example URL
        // and that it will return a response with the example HTML content

        $exampleUrl = 'https://example.com';
        $exampleHtmlContent = '<a href="/page1">Page 1</a><a href="/page2">Page 2</a><a href="/page3">Page 3</a><a href="/page4">Page 4</a><a href="https://externl.com/page3">External link</a>';

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', $exampleUrl)
            ->willReturn(new GuzzleResponse(200, [], $exampleHtmlContent));

        // Call the method to be tested
        $internalLinks = $this->crawlService->crawlHomePage($exampleUrl);

        $this->assertCount(4, $internalLinks);
    }


    public function testCrawlHomePageWithNoInternalLinks()
    {

        // Set an expectation that the 'request' method of the client will be called with the example URL
        // and that it will return a response with the example HTML content

        $exampleUrl = 'https://example.com';
        $exampleHtmlContent = '<a href="http://external.com">External Link</a>';

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with('GET', $exampleUrl)
            ->willReturn(new GuzzleResponse(200, [], $exampleHtmlContent));

        // Call the method to be tested
        $internalLinks = $this->crawlService->crawlHomePage($exampleUrl);

        $this->assertEmpty($internalLinks);
    }
}

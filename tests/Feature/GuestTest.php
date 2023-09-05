<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class AuthTest extends TestCase
{

    protected $baseUrl;
    protected $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->baseUrl = 'http://wp_webserver';
        $this->client = new Client(['base_uri' => $this->baseUrl]);
    }

    public function testGuestPageIsAccessible(): void
    {
        $response = $this->client->get('/');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Login', (string)$response->getBody());
        $this->assertStringContainsString('View Current Sitemap', (string)$response->getBody());
    }
}

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

    public function testLoginPageIsAccessible()
    {
        $response = $this->client->get('/login.php');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Log in', (string)$response->getBody());
    }

    public function testFailedLogin()
    {
        $response = $this->client->post('/login.php', [
            'form_params' => [
                'username' => 'invalid_username',
                'password' => 'invalid_password',
            ],
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Invalid credentials. Please try again.', (string)$response->getBody());
    }
}

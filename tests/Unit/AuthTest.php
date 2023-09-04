<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\Auth\AuthService;
use App\Services\User\UserServiceInterface;

class AuthTest extends TestCase
{
    private $authService;
    private $userServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock for UserServiceInterface
        $this->userServiceMock = $this->createMock(UserServiceInterface::class);

        // Create an instance of AuthService and inject the mock
        $this->authService = new AuthService($this->userServiceMock);
    }

    public function testSuccessfulUserLogin()
    {
        $userId = 1;
        $username = 'user';
        $password = 'test_password';

        // Configure the mock to return a user with the provided username
        $this->userServiceMock->expects($this->once())
            ->method('findUserByUsername')
            ->with($username)
            ->willReturn(['id' => $userId, 'username' => $username, 'password' => password_hash($password, PASSWORD_DEFAULT)]);

        // Call the method to be tested
        $result = $this->authService->login($username, $password);

        $this->assertTrue($result);

        $userIsLoggedIn = $this->authService->isLoggedIn();

        $this->assertTrue($userIsLoggedIn);
    }

    public function testUnsuccessfulUserLogin()
    {
        $username = 'user';
        $password = 'test_password';

        // Configure the mock to return null for the provided username
        $this->userServiceMock->expects($this->once())
            ->method('findUserByUsername')
            ->with($username)
            ->willReturn(null);

        // Call the method to be tested
        $result = $this->authService->login($username, $password);

        $this->assertFalse($result);
    }
}

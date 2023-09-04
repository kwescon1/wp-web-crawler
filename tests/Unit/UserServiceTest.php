<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\User\UserService;
use Tests\Traits\SetsMockConnection;

class UserServiceTest extends TestCase
{
    use SetsMockConnection;

    protected $userServiceMock;
    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();

        // This instance will be used to test methods that we aren't mocking
        $this->userService = new UserService();

        // This mock will be used to test interactions
        $this->userServiceMock = $this->createMock(UserService::class);
    }

    public function testUserDoesNotExist()
    {
        $username = 'user';

        // Configure the mock to return null
        $this->userServiceMock->expects($this->once())
            ->method('findUserByUsername')
            ->with($username)
            ->willReturn(null);

        // Here, we use the mock to simulate a call
        $result = $this->userServiceMock->findUserByUsername($username);

        $this->assertNull($result);
    }

    public function testUserExists()
    {
        $username = 'existingUser';
        $mockedUser = [
            'id' => 1,
            'username' => $username,
            'email' => 'existingUser@example.com'
        ];

        // Configure the mock to return the mocked user
        $this->userServiceMock->expects($this->once())
            ->method('findUserByUsername')
            ->with($username)
            ->willReturn($mockedUser);

        // Here, we use the mock to simulate a call
        $result = $this->userServiceMock->findUserByUsername($username);

        $this->assertNotNull($result);
        $this->assertEquals($mockedUser, $result);
    }
}

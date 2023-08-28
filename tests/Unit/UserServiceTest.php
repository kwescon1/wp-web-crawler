<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\User\UserService;
use PHPUnit\Framework\TestCase as Test;

class UserServiceTest extends Test
{

    protected $testCase;
    protected $userService;

    protected function setUp(): void
    {

        parent::setUp();

        $this->testCase = new TestCase;
        $this->userService = new UserService();
        
        // Reset the database
        $this->testCase->refreshDatabase();
    }

    public function testUserDoesNotExist()
    {
        $username = 'user';

        // Call the method to be tested
        $result = $this->userService->findUserByUsername($username);

        $this->assertNull($result);        
    }

    public function testUserExists()
    {
        // Insert a user into the database
        $username = 'testuser';
        $password = 'password123';

        $this->insertUser($username, $password);

        // Verify if the user exists in the database
        $user = $this->userService->findUserByUsername($username);

        // Assertions
        $this->assertNotNull($user);
        $this->assertEquals($username, $user['username']);
    }

    private function insertUser($username, $password)
    {
        $insertQuery = "INSERT INTO " . User::TABLE . " (username, password) VALUES (:username, :password)";
        
        $stmt = $this->testCase->db()->prepare($insertQuery);

        $stmt->bindValue(':username', $username, $this->testCase->db()::PARAM_STR);
        $stmt->bindValue(':password', $password, $this->testCase->db()::PARAM_STR);
        $stmt->execute();
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\Auth\AuthService;
use App\Services\User\UserService;
use PHPUnit\Framework\TestCase as Test;

class AuthTest extends Test
{

    protected $testCase;
    protected $authService;
    protected $userService;

    protected function setUp(): void
    {

        parent::setUp();

        $this->testCase = new TestCase;
        $this->userService = new UserService;
        $this->authService = new AuthService($this->userService);

        // Reset the database
        $this->testCase->refreshDatabase();
    }

    public function testSuccessfulUserLogin()
    {
        $username = 'user';
        $password = 'test_password';

        $this->insertUser($username, password_hash($password, PASSWORD_DEFAULT));

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

        $this->insertUser($username, $password);

        // Call the method to be tested
        $result = $this->authService->login($username, $password);

        $this->assertFalse($result);
    }

    public function testLogoutUnsetsUserSession()
    {
        //mock the $_SESSION superglobal
        $_SESSION = ['user_id' => 123];

        // Call the logout method
        $this->authService->logout();

        // Assert that the user_id session variable is unset
        $this->assertArrayNotHasKey('user_id', $_SESSION);
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

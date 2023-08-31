<?php

namespace App\Services\Auth;

use App\Services\User\UserServiceInterface;

class AuthService implements AuthServiceInterface {


	private $userService;

	public function __construct( UserServiceInterface $userService ) {
		$this->userService = $userService;
	}

	public function isLoggedIn(): bool {
		return isset( $_SESSION['user_id'] );
	}

	public function login( string $username, string $password ): bool {
		try {
			$user = $this->userService->findUserByUsername( $username );

			if ( $user && password_verify( $password, $user['password'] ) ) {
				$_SESSION['user_id'] = $user['id'];

				return true;
			}

			return false;
		} catch ( \PDOException $exception ) {
			return $exception->getMessage();
		}
	}

	public function logout(): void {
		unset( $_SESSION['user_id'] );
	}
}

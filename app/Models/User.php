<?php

namespace App\Models;

class User {
	private $id;
	private $username;

	public const TABLE = 'users';

	public function getId(): int {
		return $this->id;
	}

	public function getUsername(): string {
		return $this->username;
	}
}

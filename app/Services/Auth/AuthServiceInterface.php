<?php

namespace App\Services\Auth;

interface AuthServiceInterface
{

    public function isLoggedIn(): bool;
    public function login(string $username, string $password): bool;
    public function logout(): void;
}

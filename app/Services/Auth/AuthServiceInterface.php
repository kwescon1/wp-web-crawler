<?php

namespace App\Services\Auth;

interface AuthServiceInterface{

    public function isLoggedIn(): bool;
    public function login(string $username,string $password);
    public function logout(): void;
}
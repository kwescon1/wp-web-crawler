<?php

namespace App\Services\User;

interface UserServiceInterface{

    public function findUserByUsername(string $username) :? array;
}
<?php

namespace App\Services;


use App\Repositories\UserRepositories;

class UserService
{
    protected UserRepositories $userRepositories;

    public function __construct(UserRepositories $userRepositories)
    {
        $this->userRepositories = $userRepositories;
    }

    /**
     * @return void
     */
    public function createUsers()
    {
        $this->userRepositories->createUsers();
    }

    /**
     * @return array
     */
    public function userSearch (): array
    {
        return $this->userRepositories->userSearch();
    }
}

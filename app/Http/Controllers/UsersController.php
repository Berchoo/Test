<?php

namespace App\Http\Controllers;

use App\Services\UserService;

class UsersController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return true
     */
    public function createUsersRedis ()
    {
        $this->userService->createUsers();

        return true;
    }

    /**
     * @return array
     */
    public function userSearch ()
    {
        return $this->userService->userSearch();
    }

}

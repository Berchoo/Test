<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Redis;

class UserRepositories
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @return void
     */
    public function createUsers()
    {
        $users = [
            ['name' => 'John', 'surname' => 'Doe', 'age' => 25, 'gender' => 'Male', 'score' => 100],
            ['name' => 'Jane', 'surname' => 'Smith', 'age' => 23, 'gender' => 'Female', 'score' => 50],
            ['name' => 'Ann', 'surname' => 'Tree', 'age' => 45, 'gender' => 'Female', 'score' => 70],
            ['name' => 'Yerke', 'surname' => 'Yerk', 'age' => 2, 'gender' => 'Male', 'score' => 25],
            ['name' => 'Sake', 'surname' => 'Sakosh', 'age' => 15, 'gender' => 'Female', 'score' => 40],
            ['name' => 'Bake', 'surname' => 'Bak', 'age' => 7, 'gender' => 'Male', 'score' => 20],
        ];

        foreach ($users as $index => $user) {
            $userId = $index + 1;

            // Save user details in a hash
            Redis::hset("user:$userId", 'name', $user['name']);
            Redis::hset("user:$userId", 'surname', $user['surname']);
            Redis::hset("user:$userId", 'age', $user['age']);
            Redis::hset("user:$userId", 'gender', $user['gender']);
            Redis::hset("user:$userId", 'score', $user['score']);

            // Add user to the sorted set for ranking
            Redis::zadd('users_ranking', $user['score'], $userId);
        }
    }

    /**
     * @return array
     */
    public function userSearch(): array
    {
        $userKeyPattern = 'user:*';

        // Initialize the cursor to start scanning
        $cursor = '0';
        $users = [];

        do {
            // Scan for keys matching the pattern
            [$cursor, $keys] = Redis::scan($cursor, 'MATCH', $userKeyPattern);

            // Retrieve the values for each key
            foreach ($keys as $key) {
                // Get all attributes for the user using hgetall
                $userDetails = Redis::hgetall($key);

                // Add the user details to the result array
                $users[] = $userDetails;
            }
        } while ($cursor !== '0');

        return $users;
    }
}

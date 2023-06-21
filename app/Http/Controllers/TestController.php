<?php

namespace App\Http\Controllers;

use App\Jobs\PrepareJob;
use App\Jobs\PublishJob;
use App\Jobs\SendMessage;

class TestController extends Controller
{
    /**
     * Testing Queue action.
     *
     * @return string
     */
    public function test()
    {
        SendMessage::withChain([
            new PrepareJob('Sub Task 1 ...'),
            new PublishJob('Sub Task 2 ...')
        ])
            ->dispatch('Start Jobs ...');

        return 'Time: ' . now()->toDateTimeString();
    }
}

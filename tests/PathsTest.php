<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PathsTest extends TestCase
{
    public static $pathsApi = '/v1/paths';

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStore()
    {
        $correctPageUrl = '/' . str_random(10);
        $incorrectPageUrl = str_random(10);
        $correctSessionId = str_random(40);
        $incorrectSessionId = str_random(20);
        $correctLoadingtime = 2.5;
        $incorrectLoadingtime = str_random(5);


        $this->json('POST', self::$pathsApi, [
            'url' => $correctPageUrl,
            'session_id' => $correctSessionId,
            'loading_time' => $correctLoadingtime])
            ->seeJson([
                'code' => 201
            ]);

        $this->json('POST', self::$pathsApi, [
            'url' => $incorrectPageUrl,
            'session_id' => $incorrectSessionId,
            'loading_time' => $incorrectLoadingtime])
            ->seeJson([
                'code' => 422
            ]);
    }
}

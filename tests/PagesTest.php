<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PagesTest extends TestCase
{
    public static $apiPrefix = '/v1/';
    public static $pagesApi = 'pages';
    public static $exitPagesApi = 'exitPages';
    public static $pagesAverageLoadingTimeApi = 'pagesAverageLoadingTime';

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get(self::$apiPrefix . self::$pagesApi)
            ->seeJsonStructure([
                'code',
                'message',
                'pages'
            ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStore()
    {
        $pageUrl = '/' . str_random(10);
        $pagesApi = self::$apiPrefix . self::$pagesApi;

        $this->json('POST', $pagesApi, ['url' => $pageUrl])
            ->seeJson([
                'code' => 201,
                'visits' => 1,
            ]);

        $this->json('POST', $pagesApi, ['url' => $pageUrl])
            ->seeJson([
                'code' => 200,
                'visits' => 2,
            ]);

        $this->json('POST', $pagesApi, ['url' => str_random(10)])
            ->seeJson([
                'code' => 422
            ]);

        $this->json('POST', $pagesApi)
            ->seeJson([
                'code' => 422,
            ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetExitPages()
    {
        $this->get(self::$apiPrefix . self::$exitPagesApi)
            ->seeJsonStructure([
                'code',
                'message',
                'exitPages'
            ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPagesAverageLoadingTime()
    {
        $this->get(self::$apiPrefix . self::$pagesAverageLoadingTimeApi)
            ->seeJsonStructure([
                'code',
                'message',
                'pages'
            ]);
    }
}

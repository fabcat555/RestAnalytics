<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StatisticsTest extends TestCase
{
    public static $apiPrefix = '/v1/';
    public static $pagesPerSessionApi = 'pagesPerSession';
    public static $bounceRateApi = 'bounceRate';
    public static $averageLoadingTimeApi = 'averageLoadingTime';
    public static $averageSessionTimeApi = 'averageSessionTime';

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPagesPerSession()
    {
        $this->get(self::$apiPrefix . self::$pagesPerSessionApi)
            ->seeJsonStructure([
                'code',
                'message',
                'pagesPerSession'
            ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBounceRate()
    {
        $this->get(self::$apiPrefix . self::$bounceRateApi)
            ->seeJsonStructure([
                'code',
                'message',
                'bounceRate'
            ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAverageLoadingTime() {
        $this->get(self::$apiPrefix . self::$averageLoadingTimeApi)
            ->seeJsonStructure([
                'code',
                'message',
                'averageLoadingTime'
            ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAverageSessionTime()
    {
        $this->get(self::$apiPrefix . self::$averageSessionTimeApi)
            ->seeJsonStructure([
                'code',
                'message',
                'averageSessionTime'
            ]);
    }
}

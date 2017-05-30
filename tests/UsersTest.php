<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersTest extends TestCase
{
    public static $usersApi = '/v1/users/';

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStore()
    {
        $correctSessionId = str_random(40);
        $incorrectSessionId = str_random(20);
        $correctIp = '151.56.83.99';
        $incorrectIp = str_random();
        $correctLanguage = 'it';
        $incorrectLanguage = str_random(1);
        $browser = str_random();
        $os = str_random();
        $nation = str_random();
        $correctScreenResolution = '1920x1080';
        $incorrectScreenResolution = str_random();

        $this->json('POST', self::$usersApi, [
                'session_id' => $correctSessionId,
                'ip'         => $correctIp,
                'language'   => $correctLanguage,
                'browser'    => $browser,
                'os'         => $os,
                'nation'     => $nation,
                'screen_resolution' => $correctScreenResolution
            ])
            ->seeJson([
                'code' => 201,
            ]);

        $this->json('POST', self::$usersApi, [
            'session_id' => $incorrectSessionId,
            'ip'         => $correctIp,
            'language'   => $correctLanguage,
            'browser'    => $browser,
            'os'         => $os,
            'nation'     => $nation,
            'screen_resolution' => $correctScreenResolution
        ])
            ->seeJson([
                'code' => 422,
            ]);

        $this->json('POST', self::$usersApi, [
            'session_id' => $correctSessionId,
            'ip'         => $incorrectIp,
            'language'   => $correctLanguage,
            'browser'    => $browser,
            'os'         => $os,
            'nation'     => $nation,
            'screen_resolution' => $correctScreenResolution
        ])
            ->seeJson([
                'code' => 422,
            ]);

        $this->json('POST', self::$usersApi, [
            'session_id' => $correctSessionId,
            'ip'         => $correctIp,
            'language'   => $incorrectLanguage,
            'browser'    => $browser,
            'os'         => $os,
            'nation'     => $nation,
            'screen_resolution' => $correctScreenResolution
        ])
            ->seeJson([
                'code' => 422,
            ]);

        $this->json('POST', self::$usersApi, [
            'session_id' => $correctSessionId,
            'ip'         => $correctIp,
            'language'   => $correctLanguage,
            'browser'    => $browser,
            'os'         => $os,
            'nation'     => $nation,
            'screen_resolution' => $incorrectScreenResolution
        ])
            ->seeJson([
                'code' => 422,
            ]);

        $this->json('POST', self::$usersApi)
            ->seeJson([
                'code' => 422,
            ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetUsersByCriterion()
    {
        $criterionApi = 'criterion/';

        $this->get(self::$usersApi . $criterionApi . 'language')
            ->seeJsonStructure([
                'result',
                'code',
                'message'
            ]);

        $this->get(self::$usersApi . $criterionApi . 'browser')
            ->seeJsonStructure([
                'result',
                'code',
                'message'
            ]);

        $this->get(self::$usersApi . $criterionApi . 'os')
            ->seeJsonStructure([
                'result',
                'code',
                'message'
            ]);

        $this->get(self::$usersApi . $criterionApi . 'nation')
            ->seeJsonStructure([
                'result',
                'code',
                'message'
            ]);

        $this->get(self::$usersApi . $criterionApi . 'screen_resolution')
            ->seeJsonStructure([
                'result',
                'code',
                'message'
            ]);

        $this->get(self::$usersApi . $criterionApi . str_random())
            ->seeJson([
                'code' => 406
            ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetUsersByTimeRange()
    {
        $timeRangeApi = 'timeRange/';

        $this->get(self::$usersApi . $timeRangeApi . 'day')
            ->seeJsonStructure([
                'timeRange',
                'activeUsers',
                'code',
                'message'
            ]);

        $this->get(self::$usersApi . $timeRangeApi . 'week')
            ->seeJsonStructure([
                'timeRange',
                'activeUsers',
                'code',
                'message'
            ]);

        $this->get(self::$usersApi . $timeRangeApi . 'month')
            ->seeJsonStructure([
                'timeRange',
                'activeUsers',
                'code',
                'message'
            ]);

        $this->get(self::$usersApi . $timeRangeApi . 'year')
            ->seeJsonStructure([
                'timeRange',
                'activeUsers',
                'code',
                'message'
            ]);

        $this->get(self::$usersApi . $timeRangeApi . str_random())
            ->seeJson([
                'code' => 406
            ]);
    }
}

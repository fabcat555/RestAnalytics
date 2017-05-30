<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActiveSessionsTest extends TestCase
{
    public static $activeSessionsApi = '/v1/activeSessions';
    public static $createSessionApi = '/v1/createSession';

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get(self::$activeSessionsApi)
            ->seeJsonStructure([
                'code',
                'message',
                'activeSessions'
            ]);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testStore()
    {
        $sessionId = str_random(40);
        $this->json('POST', self::$activeSessionsApi, ['session_id' => $sessionId, 'flag' => '1'])
            ->seeJson([
                'code' => 201,
            ]);

        $this->json('POST', self::$activeSessionsApi, ['session_id' => $sessionId, 'flag' => '0'])
            ->seeJson([
                'code' => 200,
            ]);

        $this->json('POST', self::$activeSessionsApi, ['session_id' => str_random(20), 'flag' => '1'])
            ->seeJson([
                'code' => 422,
            ]);

        $this->json('POST', self::$activeSessionsApi, ['session_id' => str_random(20)])
            ->seeJson([
                'code' => 422,
            ]);
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testCreateSession()
    {
        $this->get(self::$createSessionApi)
            ->seeJsonStructure([
                'code',
                'message',
                'session_id'
            ]);
    }
}

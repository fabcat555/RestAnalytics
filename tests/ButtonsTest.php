<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ButtonsTest extends TestCase
{
    public static $buttonsApi = '/v1/buttons';

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get(self::$buttonsApi)
            ->seeJsonStructure([
                'code',
                'message',
                'buttons'
            ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStore()
    {
        $buttonId = str_random(10);
        $this->json('POST', self::$buttonsApi, ['button_id' => $buttonId])
            ->seeJson([
                'code' => 201,
                'clicks' => 1,
            ]);

        $this->json('POST', self::$buttonsApi, ['button_id' => $buttonId])
            ->seeJson([
                'code' => 200,
                'clicks' => 2,
            ]);

        $this->json('POST', self::$buttonsApi)
            ->seeJson([
                'code' => 422,
            ]);
    }
}

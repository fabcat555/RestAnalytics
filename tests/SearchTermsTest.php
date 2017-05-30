<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchTermsTest extends TestCase
{
    public static $searchTermsApi = '/v1/searchTerms';

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get(self::$searchTermsApi)
            ->seeJsonStructure([
                'code',
                'message',
                'searchTerms'
            ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStore()
    {
        $searchTerm = str_random(10);
        $this->json('POST', self::$searchTermsApi, ['search_term' => $searchTerm])
            ->seeJson([
                'code' => 201,
                'hits' => 1,
            ]);

        $this->json('POST', self::$searchTermsApi, ['search_term' => $searchTerm])
            ->seeJson([
                'code' => 200,
                'hits' => 2,
            ]);

        $this->json('POST', self::$searchTermsApi)
            ->seeJson([
                'code' => 422,
            ]);
    }
}

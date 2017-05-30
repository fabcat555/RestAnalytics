<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Http\Requests;

class StatisticsController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * Returns the average number of pages visited by a user in a single session.
     */
    public function getPagesPerSession()
    {
        $result = DB::table('paths')
                ->select(DB::raw('( (SELECT count(*) FROM paths) /
                (SELECT count(DISTINCT session_id)))
                AS pages_per_session'))
                ->get();

        return response()->json(['code' => 200, 'message' => 'ok', 'pagesPerSession' => $result], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * Returns the average loading time.
     */
    public function getAverageLoadingTime()
    {
        $result = DB::table('paths')->avg('loading_time');

        return response()->json(['code' => 200, 'message' => 'ok', 'averageLoadingTime' => $result], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * Returns the bounce rate.
     */
    public function getBounceRate()
    {
        $result = DB::table('paths')
            ->select(DB::raw('DISTINCT ( (SELECT COUNT(*) FROM
            (SELECT * FROM paths
            GROUP BY session_id
            HAVING COUNT(session_id)=1)
            AS bounced_sessions) /
            (SELECT COUNT(*) FROM
            (SELECT DISTINCT session_id FROM paths)
            AS total_sessions))*100 AS bounce_rate'))
            ->get();

        return response()->json(['code' => 200, 'message' => 'ok', 'bounceRate' => $result], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * Returns the average session time.
     */
    public function getAverageSessionTime()
    {
        $averageSessionTime = DB::table('active_sessions')->avg('total_time');

        return response()->json(['code' => 200, 'message' => 'ok', 'averageSessionTime' => $averageSessionTime], 200);
    }

}

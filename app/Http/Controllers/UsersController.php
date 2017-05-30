<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

use DB;

use App\Http\Requests;

use App\User;
use App\ActiveSession;

class UsersController extends Controller
{
    /**
     * @param Request $request(session_id, ip, language, browser, os, nation, screen_resolution)
     * @return mixed
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'session_id' => [
                'required',
                'regex:/^[a-zA-Z0-9]*$/',
                'min:40',
                'max:40'
            ],
            'ip' => [
                'required',
                'regex:/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/'
            ],
            'language' => 'required|min:2',
            'browser' => 'required',
            'os' => 'required',
            'nation' => 'required',
            'screen_resolution' => [
                'required',
                'regex:/^([0-9]{3,4})x([0-9]{3,4})$/'
            ]
        ]);

        if ($v->fails())
        {
            return response()->json(['errors' => array(['code' => 422, 'message' => 'Data missing', 'errors' => $v->messages()])], 422);
        }

        else
        {
            $user = User::create($request->all());

            $response = response()->json(['code' => 201, 'message' => 'created', 'user' => $user], 201);
            return $response;
        }
    }

    /**
     * @param $criterion
     * @return mixed
     *
     * Returns the number of users matching the $criterion.
     */
    public function getUsersByCriterion($criterion)
    {
        switch ($criterion)
        {
            case 'language':
            case 'browser':
            case 'os':
            case 'nation':
            case 'screen_resolution':
            $result = DB::table('users')
                    ->select(DB::raw($criterion . ' AS criterion, count(*) AS activeUsers'))
                    ->groupBy('criterion')
                    ->orderBy('activeUsers', 'desc')->get();
            break;
            default:
                return response()->json(['errors' => array(['code' => 406, 'message' => 'Incorrect parameter'])], 406);
        }

        return response()->json(['code' => 200, 'message' => 'ok', 'result' => $result], 200);
    }

    /**
     * @param $timeRange
     * @return mixed
     *
     * Returns the number of users active within the $timeRange.
     */
    public function getUsersByTimeRange($timeRange)
    {
        switch ($timeRange)
        {
            case 'day':
                $users = User::whereDate('created_at', '>=', Carbon::now()->subDay())->count();
                break;
            case 'week':
                $users = User::whereDate('created_at', '>=', Carbon::now()->subWeek())->count();
                break;
            case 'month':
                $users = User::whereDate('created_at', '>=', Carbon::now()->subMonth())->count();
                break;
            case 'year':
                $users = User::whereDate('created_at', '>=', Carbon::now()->subYear())->count();
                break;
            default:
                return response()->json(['errors' => array(['code' => 406, 'message' => 'Incorrect parameter'])], 406);
        }

        return response()->json(['timeRange' => $timeRange, 'code' => 200, 'message' => 'ok', 'activeUsers' => $users], 200);
    }
}

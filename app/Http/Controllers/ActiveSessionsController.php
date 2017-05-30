<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

use App\Http\Requests;

use App\ActiveSession;

use DB;

class ActiveSessionsController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * Returns a JSON-formatted collection of ActiveSession with end_time set to null.
     */
    public function index()
    {
        return response()->json([
            'code' => 200,
            'message' => 'ok',
            'activeSessions' => ActiveSession::whereNull('end_time')->count()], 200);
    }

    /**
     * @param Request $request(session_id, flag[0|1])
     * @return \Illuminate\Http\JsonResponse
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
            'flag' => [
                'required',
                'boolean'
            ]
        ]);

        if ($v->fails())
            return response()->json(['errors' => array(['code' => 422, 'message' => 'Data missing', 'errors' => $v->messages()])], 422);

        else
        {
            $sessionId = $request->input('session_id');
            $flag = $request->input('flag');

            $activeSession = ActiveSession::where('session_id', '=', $sessionId)->first();

            if (!$activeSession)
            {
                $activeSession = ActiveSession::create($request->all());

                $response = response()->json([
                    'message' => 'created',
                    'session' => $activeSession,
                    'code' => 201
                ], 201);

                return $response;
            }

            else
            {
                DB::table('active_sessions')
                    ->where('session_id', $sessionId)
                    ->update(['end_time' => ($flag==1) ? null : Carbon::now()->toDateTimeString()]);

                return response()->json(['code' => 200, 'message' => 'ok'], 200);
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createSession(Request $request)
    {
        return response()->json(['code' => 200, 'message' => 'ok', 'session_id' => $request->session()->getId()], 200);
    }
}

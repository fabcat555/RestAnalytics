<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;

use App\Path;

class PathsController extends Controller
{
    /**
     * @param Request $request(session_id, url, loading_time)
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
            'url' => [
                'required',
                'regex:/^\/.*$/'
            ],
            'loading_time' => [
                'required',
                'regex:/^[0-9]+(\.[0-9]{1,3})?$/'
            ],
        ]);

        if ($v->fails())
            return response()->json(['errors' => array(['code' => 422, 'message' => 'Data missing', 'errors' => $v->messages()])], 422);

        else
        {
            $path = Path::create($request->all());

            $response = response()->json(['code' => 201, 'message' => 'ok', 'data' => $path], 201);
            return $response;
        }
    }
}

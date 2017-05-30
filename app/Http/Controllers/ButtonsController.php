<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;

use App\Button;

class ButtonsController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * Returns a JSON-formatted collections of all the Button, ordered by clicks.
     */
    public function index()
    {
        return response()->json(['code' => 200, 'message' => 'ok', 'buttons' => Button::orderBy('clicks', 'desc')->get()], 200);
    }

    /**
     * @param Request $request(button_id)
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'button_id' => 'required',
        ]);

        if ($v->fails())
            return response()->json(['errors' => array(['code' => 422, 'message' => 'Data missing', 'errors' => $v->messages()])], 422);

        else
        {
            $button = Button::firstOrNew(['button_id' => $request->input('button_id')]);
            $button->clicks += 1;
            $button->save();
            $isNew = $button->clicks==1;
            $code = $isNew ? 201 : 200;

            $response = response()->json(['code' => $code, 'message' => $isNew ? 'created' : 'updated', 'button' => $button], $code);
            return $response;
        }
    }

}

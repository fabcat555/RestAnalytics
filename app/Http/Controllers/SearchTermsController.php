<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;

use App\SearchTerm;

class SearchTermsController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * Returns a JSON-formatted collection of SearchTerm, ordered by hits.
     */
    public function index()
    {
        return response()->json(['code' => 200, 'message' => 'ok', 'searchTerms' => SearchTerm::orderBy('hits', 'desc')->get()], 200);
    }

    /**
     * @param Request $request(search_term)
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'search_term' => 'required',
        ]);

        if ($v->fails())
            return response()->json(['errors' => array(['code' => 422, 'message' => 'Data missing', 'errors' => $v->messages()])], 422);

        else
        {
            $searchTerm = SearchTerm::firstOrNew(['search_term' => $request->input('search_term')]);
            $searchTerm->hits += 1;
            $searchTerm->save();
            $isNew = $searchTerm->hits==1;
            $code = $isNew ? 201 : 200;

            $response = response()->json(['code' => $code, 'message' => $isNew ? 'created' : 'updated', 'searchTerm' => $searchTerm], $code);

            return $response;
        }
    }
}

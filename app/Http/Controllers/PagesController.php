<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;

use App\Page;

use DB;

class PagesController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * Returns a JSON-formatted collections of all Page, ordered by visits.
     */
    public function index()
    {
        return response()->json(['code' => 200, 'message' => 'ok', 'pages' => Page::orderBy('visits', 'desc')->get()], 200);
    }

    /**
     * @param Request $request(url)
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'url' => [
                'required',
                'regex:/^\/.*$/'
            ]
        ]);

        if ($v->fails())
        {
            return response()->json(['errors' => array(['code' => 422, 'message' => 'Data missing', 'errors' => $v->messages()])], 422);
        }

        else
        {
            $page = Page::firstOrNew(['url' => $request->input('url')]);
            $page->visits += 1;
            $page->save();
            $isNew = $page->visits==1;
            $code = $isNew ? 201 : 200;

            $response = response()->json(['code' => $code, 'message' => $isNew ? 'created' : 'updated', 'page' => $page], $code);
            return $response;
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * Returns a JSON-formatted collection of Page corresponding to the exit pages.
     */
    public function getExitPages()
    {
        $result = DB::select(
                'SELECT url, count(*) as exitCount from
                  (SELECT url
                  FROM paths AS p1
                  WHERE p1.created_at =
                  (SELECT MAX(created_at) FROM paths AS p2 WHERE p1.session_id = p2.session_id) ORDER BY url)
                  as distinctExitPages
                  GROUP BY url');

        return response()->json(['code' => 200, 'message' => 'ok', 'exitPages' => $result], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * Returns a JSON-formatted list of pages with the respective average loading time.
     */
    public function getPagesAverageLoadingTime()
    {
        $result = DB::table('paths')
            ->select(DB::raw('url, AVG(loading_time) AS average_load_time'))
            ->groupBy('url')
            ->get();

        return response()->json(['code' => 200, 'message' => 'ok', 'pages' => $result], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\City;
use Closure;
use Illuminate\Http\Request;

class AjaxController extends Controller
{

    public function __construct()
    {
        $this->middleware(function (Request $request, Closure $next) {
            if (!$request->ajax()) {
                abort(404);
            }
            $next($request);
        });
    }

    /**
     * Get all city by province id
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function cities($id)
    {
        $cities = City::query()->where('province_id', $id)->get();
        return response()->json($cities, 200);
    }
}

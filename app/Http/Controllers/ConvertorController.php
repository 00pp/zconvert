<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Helper;

class ConvertorController extends Controller
{
    public function index(Request $request, $type)
    {
        $slugs = Helper::getConvertSlugs();

        if(!in_array($type, $slugs)) abort(404);

        return view('convertor.page', compact('type'));
    }
}

<?php

namespace App\Tools\URL;

use Illuminate\Http\Request;

class Domain
{

    public static function getTld(Request $request)
    {
        return substr($request, strrpos($request, ".")+1);
    }

}
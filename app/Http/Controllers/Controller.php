<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController {

	use DispatchesJobs, ValidatesRequests;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function request()
    {
        return $this->request();
    }

}

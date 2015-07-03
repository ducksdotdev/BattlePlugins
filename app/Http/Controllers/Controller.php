<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController {

    use DispatchesJobs, ValidatesRequests;

    public function redirectBackWithErrors($errors) {
        return redirect()->back()->withErrors($errors);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectBackWithSuccess($msg) {
        return redirect()->back()->with('success', $msg);
    }
}

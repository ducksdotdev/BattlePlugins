<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
abstract class Controller extends BaseController {

    use DispatchesJobs, ValidatesRequests;

    /**
     * @param $errors
     * @return $this
     */
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

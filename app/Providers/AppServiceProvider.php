<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot () {
		if (auth()->check() && auth()->user()->admin) {
			view()->share('alerts', Alert::whereUser(Auth::user()->id)->latest()->get());
		}
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register () {
		//
	}

}

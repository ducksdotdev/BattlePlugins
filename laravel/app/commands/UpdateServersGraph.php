<?php

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class UpdateServersGraph extends Command{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'graphs:reloadserver';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Reload servers graph.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(){
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire(){
		Cache::forget("getTotalServers");
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments(){
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions(){
		return array();
	}

}
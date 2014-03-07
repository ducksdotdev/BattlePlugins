<?php

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Queue;

class UpdateStatistics extends Command{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'battle:forcesave';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Save statistics.';

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
		$data = Cache::get('newStatistics', array());
		if(count($data) >= Config::get('statistics.max-cached')){
			Queue::push('BattleTools\Queue\UpdateStatistics', array());
		}
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
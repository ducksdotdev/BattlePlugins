<?php

use BattleTools\Util\DateUtil;
use BattleTools\Util\ListSentence;
use BattleTools\Util\MinecraftStatus;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateStatistics extends Command{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'battle:savestats';

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
		$start = Carbon::now();

		$cache = Cache::get('statistics', array());

		$success = array();
		$error = array();

		$plugins = DB::table('plugins')->select('name')->get();

		$limitedKeys = Config::get('statistics.limited-keys');
		$allowedKeys = Config::get('statistics.tracked');

		Log::info(count($cache).' new statistics this half hour.');

		foreach($cache as $cacheItem){
			$keys = $cacheItem['keys'];
			$server = $cacheItem['server'];
			$time = $cacheItem['time'];

			$pluginRequests = DB::table('plugin_statistics')
				->where('inserted_on', $time)
				->where('server', $server)
				->select('plugin')->get();

			$serverRequests = DB::table('server_statistics')
				->where('inserted_on', $time)
				->where('server', $server)
				->select('key')
				->get();

			foreach(array_keys($keys) as $key){
				if(ListSentence::startsWith($key, 'p')){
					$plugin = substr($key, 1);

					if(!in_array($plugin, $pluginRequests) && in_array($plugin, $plugins)){
						$value = $keys[$key];
						$success[$key] = $value;

						DB::table('plugin_statistics')->insert(array(
							'server'      => $server,
							'plugin'      => $plugin,
							'version'     => $value,
							'inserted_on' => $time
						));
					}
				}else{
					if(!in_array($key, $serverRequests) && !in_array($key, $limitedKeys)){
						if(in_array($key, $allowedKeys)){
							$value = $keys[$key];

							$success[$key] = $value;

							DB::table('server_statistics')->insert(array(
								'server'      => $server,
								'key'         => $key,
								'value'       => $value,
								'inserted_on' => $time
							));
						}else{
							$error[$key] = 'invalid';
						}
					}else{
						$error[$key] = 'duplicate';
					}
				}
			}
		}

		Cache::forget('statistics');
		Log::info('Statistics added. This took '.Carbon::now()->diffInSeconds($start).' seconds to completed.');

		Cache::put('lastUpdate', Carbon::now(), DateUtil::getTimeToNextThirty());
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

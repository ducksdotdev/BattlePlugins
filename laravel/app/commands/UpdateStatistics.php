<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateStatistics extends Command {

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
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

		$cache = Cache::get('statistics');

		$time = self::getTime();

		$success = array();
		$error = array();

		foreach($cache as $cacheItem){
			$keys = $cacheItem['keys'];
			$server = $cacheItem['server'];

			foreach(array_keys($keys) as $key){
				if(ListSentence::startsWith($key, 'p')){
					$plugin = substr($key, 1);

					$plugins = DB::table('plugins')->where('name', $plugin)->get();

					$count = DB::table('plugin_statistics')
						->where('inserted_on', $time)
						->where('server', $server)
						->where('plugin', $plugin)
						->get();

					if(count($count) == 0 && count($plugins) > 0){
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
					$count = DB::table('server_statistics')
						->where('inserted_on', $time)
						->where('server', $server)
						->where('key', $key)
						->select('key')
						->get();

					if(count($count) == 0){
						if(!(in_array($key, $count) && in_array($key, Config::get('statistics.limited-keys')))){
							$allowedKeys = Config::get('statistics.tracked');

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
					}else{
						$error[$key] = 'exists';
					}
				}
			}
		}

		Cache::forget('statistics');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

}

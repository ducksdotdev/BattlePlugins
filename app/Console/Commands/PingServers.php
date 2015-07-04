<?php

namespace App\Console\Commands;

use App\Jobs\PingServersJob;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class PingServers extends Command {

    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pingservers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pings servers from servers.php config file to check if they are online.';

    /**
     * Create a new command instance.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $this->dispatch(new PingServersJob());
    }

}

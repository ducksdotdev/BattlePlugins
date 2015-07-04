<?php


namespace App\Jobs;


use App\Tools\URL\Domain;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Cache;

class PingServersJob extends Job implements SelfHandling {

    public function handle() {
        Cache::forever('serverData', static::process());
    }

    public function process() {
        $serverData = [];
        foreach (config('servers') as $name => $server) {
            $serverData['servers'][] = [
                'name'   => $name,
                'online' => Domain::isOnline($server),
                'url'    => $server
            ];
        }

        $serverData['updated_at'] = Carbon::now();

        return $serverData;
    }
}
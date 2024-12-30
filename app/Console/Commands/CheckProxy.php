<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Proxies;
use App\Models\ProxyChecks;

class CheckProxy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:proxy {proxy} {check_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check a single proxy';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $proxy = $this->argument('proxy');
        $checkId = $this->argument('check_id');
        list($ip, $port) = explode(':', $proxy);

        $client = new Client([
            'timeout' => 5,
            'proxy' => "http://$ip:$port",
        ]);

        try {
            $response = $client->get('http://httpbin.org/ip');
            echo $externalIP = json_decode($response->getBody(), true)['origin'];
            $speed = $response->getHeaderLine('X-Request-Duration');

            Proxies::create([
                'ip' => $ip,
                'port' => $port,
                'type' => 'http',
                'status' => true,
                'speed' => $speed,
                'external_ip' => $externalIP,
                'check_id' => $checkId,
            ]);
        } catch (\Exception $e) {
            Proxies::create([
                'ip' => $ip,
                'port' => $port,
                'status' => false,
                'check_id' => $checkId,
            ]);
        }

        $proxyCheck = ProxyChecks::find($checkId);
        $proxyCheck->working_proxies = Proxies::where('check_id', $checkId)->where('status', true)->count();
        $proxyCheck->save();
    }
}

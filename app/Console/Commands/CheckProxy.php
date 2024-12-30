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
            'timeout'  => 10, // Тайм-аут для запроса
            'proxy'    => "http://" . $proxy, // Указываем прокси
        ]);

        $proxy = Proxies::create([
            'ip' => $ip,
            'port' => $port,
            'type' => 'http',
            'check_id' => $checkId,
        ]);

        try {
            $response = $client->get('http://google.com/');

            if ($response->getStatusCode() === 200) {

                $externalIP = json_decode($response->getBody(), true)['origin'];
                $speed = $response->getHeaderLine('X-Request-Duration');

                Proxies::where('id', $proxy->id)->update([
                    'status' => true,
                    'speed' => $speed,
                    'external_ip' => $externalIP,
                ]);
            }
        } catch (\Exception $e) {
            Proxies::where('id', $proxy->id)->update([
                'status' => false
            ]);
        }

        $proxyCheck = ProxyChecks::find($checkId);
        $proxyCheck->working_proxies = Proxies::where('check_id', $checkId)->where('status', true)->count();
        $proxyCheck->save();
    }
}

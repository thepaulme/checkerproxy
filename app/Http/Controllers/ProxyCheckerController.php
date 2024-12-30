<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Proxies;
use App\Models\ProxyChecks;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
class ProxyCheckerController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function checkProxies(Request $request)
    {
        $proxies = explode("\n", $request->input('proxies'));
        $proxyChecks = ProxyChecks::create([
            'started_at' => now(),
            'total_proxies' => count($proxies),
        ]);

        chdir(getcwd() . '/..');

        $processes = [];
        foreach ($proxies as $proxy) {
            $process = new Process(['php', 'artisan', 'check:proxy', $proxy, $proxyChecks->id]);
            $process->start();
            $processes[] = $process;
        }

        chdir(getcwd() . '/public');

        return response()->json(['check_id' => $proxyChecks->id]);
    }

    public function checkProgress($id)
    {
        $proxyChecks = ProxyChecks::find($id);

        $progress = Proxies::where('check_id', $id)->count();
        $finished = $proxyChecks->finished_at !== null;

        return response()->json([
            'progress' => "$progress из {$proxyChecks->total_proxies} прокси проверено",
            'finished' => $finished,
            'results' => $finished ? "Всего: {$proxyChecks->total_proxies}, из них рабочих: {$proxyChecks->working_proxies}" : '',
        ]);
    }
}

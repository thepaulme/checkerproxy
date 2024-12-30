<?php

namespace App\Http\Controllers;

use App\Models\Proxies;
use App\Models\ProxyChecks;
use Illuminate\Http\Request;

class ProxyHistoryController extends Controller
{
    public function history()
    {
        // Получаем все проверки
        $checks = ProxyChecks::all();
        return view('history.index', compact('checks'));
    }

    public function show($id)
    {
        // Находим проверку по id
        $check = ProxyChecks::findOrFail($id);
        
        // Получаем все прокси, связанные с этой проверкой
        $proxies = Proxies::where('check_id', $id)->get();
        return view('history.show', compact('check', 'proxies'));
    }
}

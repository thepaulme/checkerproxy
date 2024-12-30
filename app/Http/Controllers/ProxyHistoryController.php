<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProxyHistoryController extends Controller
{
    public function index()
    {
        $checks = ProxyCheck::withCount('proxies')->get();
        return view('proxy_checker.history', compact('checks'));
    }

    public function show($id)
    {
        $check = ProxyCheck::with('proxies')->findOrFail($id);
        return view('proxy_checker.detail', compact('check'));
    }
}

@extends('layouts.main')

@section('content')
<h1>Proxy Check History</h1>
    <ul>
        @foreach ($checks as $check)
            <li>
                <a href="{{ route('proxy.history.show', $check->id) }}">
                    {{ $check->started_at }} - {{ $check->total_proxies }} proxies
                </a>
            </li>
        @endforeach
    </ul>
@endsection
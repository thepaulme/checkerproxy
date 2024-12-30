@extends('layouts.main')

@section('content')
<h1>История проверки прокси</h1>
    <ul>
        @foreach ($checks as $check)
            <li>
                <a href="{{ route('proxy.history.show', $check->id) }}">
                    {{ $check->started_at }}. Всего {{ $check->total_proxies }} прокси
                </a>
            </li>
        @endforeach
    </ul>
@endsection
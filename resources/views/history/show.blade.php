@extends('layouts.main')

@section('content')
    <h1>Детали проверки прокси</h1>
    <p><strong>Дата и время начала:</strong> {{ $check->started_at }}</p>
    <p><strong>Дата и время окончания:</strong> {{ $check->finished_at ?? 'N/A' }}</p>
    <p><strong>Всего прокси:</strong> {{ $check->total_proxies }}</p>
    <p><strong>Рабочие прокси:</strong> {{ $check->working_proxies ?? 'N/A' }}</p>

    <h2>Список прокси</h2>
    <table border="1">
        <thead>
            <tr>
                <th>IP:Port</th>
                <th>Тип</th>
                <th>Страна</th>
                <th>Город</th>
                <th>Статус</th>
                <th>Скорость</th>
                <th>Реальный IP</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proxies as $proxy)
                <tr>
                    <td>{{ $proxy->ip }}:{{ $proxy->port }}</td>
                    <td>{{ $proxy->type ?? 'N/A' }}</td>
                    <td>{{ $proxy->country ?? 'N/A' }}</td>
                    <td>{{ $proxy->city ?? 'N/A' }}</td>
                    <td>{{ $proxy->status ? 'Работает' : 'Не работает' }}</td>
                    <td>{{ $proxy->speed ?? 'N/A' }}</td>
                    <td>{{ $proxy->external_ip ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
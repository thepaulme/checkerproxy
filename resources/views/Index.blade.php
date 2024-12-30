@extends('layouts.main')

@section('content')
    <a href="/history">История проверок</a>
    <h3>Проверка прокси-серверов</h3>
    <form>
        @csrf
        <textarea id="proxies" rows="10" class="form-control" placeholder="Введите адреса прокси"></textarea>
        <button id="check-button" class="btn btn-primary mt-3">Проверить</button>
    </form>

    <div class="mt-3">
        <div id="progress"></div>
        <div id="results"></div>
    </div>

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('[name="_token"]').val()
    }
});
$('#check-button').click(function(e) {
    e.preventDefault();
    var proxies = $('#proxies').val();
    $.post('/check-proxies', { proxies: proxies }, function(data) {

        var checkId = data.check_id;
        var interval = setInterval(function() {
            $.get('/check-progress/' + checkId, function(data) {
                $('#progress').html(data.progress);
                if (data.finished) {
                    clearInterval(interval);
                    $('#results').html(data.results);
                }
            });
        }, 1000);
    })
});
</script>
@endsection
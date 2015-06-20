@if ($event['created_by'] == Auth::user()->username)
    <a href="/event/{{ $event['id'] }}/edit">
        <button class="btn btn-default btn-xs pull-right">Edit</button>
    </a>
@endif

@extends('layouts.base')

@section('content')
    <h1>Latest ADs</h1>

    @foreach ($rows as $row)
        <div class="pt-4 d-flex">
            @if ($row->pic)
                <img src="{{ '/images/' . substr($row->pic, 0, 4) . '/s_' . $row->pic . '.webp' }}" width="120"
                     height="90" alt="main_pic"/>
            @else
                <img src="/s_noimg.webp" width="120" height="90" alt="main_pic"/>
            @endif
            <div class="ms-3 me-auto">
                <a href="{{ route("show-ad", ['id' => $row->id]) }}"
                   class="h4 text-dark text-decoration-none">{{ $row->title }}</a><br/>
                <strong class="text-info">
                    &euro;{{ number_format($row->price, 2) }}
                    @if ($row->price_freq == 'per_month')
                        per month
                    @elseif($row->price_freq == 'per_week')
                        per week
                    @endif
                </strong><br/>
                <small class="text-muted">{{ $row->location }}</small>
            </div>
        </div>
    @endforeach
@endsection

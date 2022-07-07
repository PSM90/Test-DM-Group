@extends('layouts.main')

@section('content')
    <section class="travels">
        <div class="continents-tabs-container">
            <ul>
                @foreach($travels as $code => $continents)
                    <li>{{ $continents }}</li>
                @endforeach
            </ul>
        </div>
    </section>
@endsection

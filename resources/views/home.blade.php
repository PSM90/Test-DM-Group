@extends('layouts.main')

@section('content')
    <section class="travels">
        <div class="continents-tabs-container">
            <ul>
                @foreach($travels as $travel)
                    <li class="active">{{ $travel }}</li>
                @endforeach
                <li>Asia</li>
                <li>Africa</li>
                <li>America</li>
                <li>Oceania</li>
            </ul>
        </div>
    </section>
@endsection

@extends('layouts.app')

@section('content')

@if(isset($book))
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h1>{{$book['title']}}</h1>
            <img src="{{$book['cover']}}">
        </div>
        <div class="col-md-6">
        @foreach($authors as $author)
            <div class="card">
                <div class="card-body">

                        <h2>Autor: {{$author['name']}}</h2>

                    <p>Más sobre este autor <a href="{{$author['url']}}" target="_blank">aquí</a></p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection
@extends('layouts/app')

@section('content')
    <a href="/posts" class="btn btn-primary">Go Back</a>
    <h1>{{$p->title}}</h1>
    <div>
        {{$p->body}}
    </div>
    <hr>
    <small>Written on {{$p->created_at}}</small>


@endsection
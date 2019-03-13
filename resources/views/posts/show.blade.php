@extends('layouts/app')

@section('content')
    <a href="/posts" class="btn btn-primary">Go Back</a>
    <h1>{{$p->title}}</h1>
    <div>
        {!! $p->body !!}
    </div>
    <hr>
    <small>Written on {{$p->created_at}} by {{$p->user->name}}</small>
    <hr>
    <a href="/posts/{{$p->id}}/edit" class="btn btn-primary">Edit</a>
    
    {!! Form::open(['action' => ['PostsController@destroy', $p->id], 'method' => 'POST', 'class' => 'float-right']) !!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
    {!! Form::close() !!}


@endsection
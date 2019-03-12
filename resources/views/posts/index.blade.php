@extends('layouts/app')

@section('content')
    <h1>Posts</h1>
    @if(count($posts) > 0) 
        @foreach($posts as $p) 
            <div class="card card-body bg-light">
                <h3 class="card-title"> <a href="/posts/{{$p->id}}">{{$p->title}}</a> </h3>
                {{-- <p class="card-text">{{$p->body}}</p> --}}
                <small>Written on {{$p->created_at}}</small>

            </div>
        @endforeach
        {{$posts->links()}}
    @else 
        <p>No posts found!</p>
    @endif
@endsection
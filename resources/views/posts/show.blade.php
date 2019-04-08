@extends('layouts.app')

@section('content')
        <h4>{{ $post->title }}</h4>
        <span>{{ $post->user->name }}</span>
        <span>{{ $post->category->name }}</span>

        <p>
            {{ $post->tags->pluck('name')->implode(', ') }}
        </p>
@endsection

@extends('layouts.app')

@section('content')

<div class="container">
    <chat-room :user="{{ Auth::user() }}" :room="{{ $room }}"></chat-room>
</div>
@endsection

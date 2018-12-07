@extends('layouts.app')

@section('content')

<div class="container">
    <chat-messages :user="{{ Auth::user() }}"></chat-messages>
</div>
@endsection

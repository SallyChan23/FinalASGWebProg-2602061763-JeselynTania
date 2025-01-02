@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Notifications</h1>

    <h2 class="mb-3">Friend Requests</h2>
    @forelse ($friendRequests as $request)
        <div class="card mb-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">{{ $request->user->name }}</h5>
                    <p class="card-text text-muted">sent you a friend request</p>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            <p>No pending friend requests.</p>
        </div>
    @endforelse

    <h2 class="mb-3">Unread Messages</h2>
    @forelse ($unreadMessages as $message)
        <div class="card mb-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">{{ $message->sender->name }}</h5>
                    <p class="card-text">{{ $message->message }}</p>
                </div>
                <a href="{{ route('chat.detail', ['receiverId' => $message->sender->id]) }}" class="btn btn-primary">View</a>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            <p>No unread messages.</p>
        </div>
    @endforelse
</div>
@endsection
@extends('layout.app')

@section('content')
<h1 class="text-center my-4">Chat</h1>

<div class="container">
    <div class="row">
        @foreach ($conversations as $receiverId => $chats)
        @php
                $user = $chats->first()->sender_id === Auth::id() 
                    ? $chats->first()->receiver 
                    : $chats->first()->sender;
            @endphp
            <div class="col-md-6 mb-3">
                <a href="{{ route('chat.detail', ['receiverId' => $receiverId]) }}" class="text-decoration-none">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex align-items-center">
                        @if ($user->profile_picture)
                                    <img src="{{ asset('uploads/profile_pictures/' . $user->profile_picture) }}" 
                                         alt="{{ $user->name }}" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                @else
                                    <div style="width: 50px; height: 50px; background-color: #ccc; border-radius: 50%;"></div>
                                @endif
                            <div>
                                <h5 class="card-title mb-1">
                                    {{ $chats->first()->sender_id === Auth::id() 
                                        ? $chats->first()->receiver->name 
                                        : $chats->first()->sender->name }}
                                </h5>
                                <p class="card-text text-muted mb-0" style="font-size: 0.9em;">
                                    {{ Str::limit($chats->last()->message, 50) }} <!-- Truncate long messages -->
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
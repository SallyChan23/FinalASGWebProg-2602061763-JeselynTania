@extends('layout.app')

@section('content')
    <div class="chat-container">
        <h1 class="chat-header">Chat with {{ $receiver->name }}</h1>

        <div class="chat-box" id="chat-box">
            @if ($messages->isEmpty())
                <div class="chat-message system-message">
                    <p>No messages yet. Start the conversation!</p>
                </div>
            @else
                @foreach ($messages as $message)
                    <div class="chat-message {{ $message->sender_id === Auth::id() ? 'chat-sent' : 'chat-received' }}">
                        <div class="chat-bubble">
                            <p>{{ $message->message }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <form method="POST" action="{{ route('chat.send') }}" class="chat-form">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
            <input type="text" name="message" placeholder="Type your message..." required class="chat-input">
            <button type="submit" class="chat-send-button"> > </button>
        </form>
    </div>
@endsection

<style>
    .chat-container {
        max-width: 600px;
        margin: 20px auto;
        background: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .chat-header {
        background: #007bff;
        color: #fff;
        padding: 10px 20px;
        font-size: 18px;
        text-align: center;
    }

    .chat-box {
        max-height: 400px;
        overflow-y: auto;
        padding: 10px;
        background: #fff;
        border-bottom: 1px solid #ddd;
    }

    .chat-message {
        display: flex;
        margin-bottom: 10px;
    }

    .chat-sent {
        justify-content: flex-end;
    }

    .chat-received {
        justify-content: flex-start;
    }

    .chat-bubble {
        max-width: 70%;
        padding: 10px 15px;
        border-radius: 20px;
        color: #fff;
        font-size: 14px;
    }

    .chat-sent .chat-bubble {
        background: #007bff;
        border-bottom-right-radius: 0;
    }

    .chat-received .chat-bubble {
        background: #6c757d;
        border-bottom-left-radius: 0;
    }

    .chat-form {
        display: flex;
        padding: 10px;
        background: #f1f1f1;
        gap: 10px;
    }

    .chat-input {
        flex: 1;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 20px;
        outline: none;
    }

    .chat-send-button {
        background: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        font-size: 14px;
        border-radius: 20px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .chat-send-button:hover {
        background: #0056b3;
    }

    .system-message {
        text-align: center;
        font-size: 14px;
        color: #888;
        margin-top: 20px;
    }
</style>
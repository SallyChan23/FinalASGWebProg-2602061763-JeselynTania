@extends('layout.app')

@section('content')
<div class="container mt-5">
        <h1 class="text-center mb-4">Connect Friends</h1>
        <div class="row justify-content-center">
            @if (session('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            @endif
            @foreach ($users as $user)
                <div class="col-md-4 d-flex justify-content-center">
                    <div class="user-card">
                        @if ($user->profile_picture)
                            <img src="{{ asset('uploads/profile_pictures/' . $user->profile_picture) }}" 
                                 alt="Profile Picture">
                        @else
                            <img src="{{ asset('default_profile_picture.png') }}" 
                                 alt="Default Profile Picture">
                        @endif
                        <h2>{{ $user->name }}</h2>
                        <p>{{ $user->profession }}</p>
                        <p>
                            {{ json_decode($user->field_of_work, true) 
                                ? implode(', ', json_decode($user->field_of_work)) 
                                : 'No fields of work specified' }}
                        </p>
                        <form action="{{ route('wishlist.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="wishlist_user_id" value="{{ $user->id }}">
                            @if ($user->isMutual)
                                <a href="{{ route('chat.detail', ['receiverId' => $user->id]) }}" class="btn btn-primary">Chat</a>
                            @else
                                <form action="{{ route('wishlist.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="wishlist_user_id" value="{{ $user->id }}">
                                    <button type="submit" class="thumb-button">👍</button>
                                </form>
                            @endif
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>



 <style>
        .user-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            max-width: 300px;
            text-align: center;
            margin: 20px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .user-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .user-card h2 {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .user-card p {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .btn-primary {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-size: 1rem;
        cursor: pointer;
    }
        .btn-primary:hover {
            background-color: #0056b3;
    }

    </style>

@endsection
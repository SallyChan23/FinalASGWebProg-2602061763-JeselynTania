@extends('layout.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Profile Section -->
        <div class="col-md-4 text-center border-end">
            @if ($authUser->profile_picture)
                <img src="{{ asset('uploads/profile_pictures/' . $authUser->profile_picture) }}" 
                     alt="@lang('profile.profile_picture')" 
                     class="rounded-circle mb-3" width="150" height="150">
            @else
                <img src="{{ asset('default_profile_picture.png') }}" 
                     alt="@lang('profile.default_profile_picture')" 
                     class="rounded-circle mb-3" width="150" height="150">
            @endif
            <h1 class="fw-bold">{{ $authUser->name }}</h1>
            <p class="text-muted">{{ $authUser->profession }}</p>
            <p>{{ implode(', ', json_decode($authUser->field_of_work, true) ?? []) }}</p>
            <p class="text-muted">{{ $authUser->email }}</p>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                @csrf
                <div class="mb-3">
                    <input type="file" name="profile_picture" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary w-20">@lang('profile.update_profile_button')</button>
            </form>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-danger w-10">@lang('profile.logout_button')</button>
            </form>
        </div>

        <div class="col-md-8">
            <h1 class="text-center fw-bold mb-4">@lang('profile.friends_list')</h1>
            <div class="row">
                @forelse ($mutualFriends as $friend)
                    <div class="col-md-6 mb-4">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                @if ($friend->profile_picture)
                                    <img src="{{ asset('uploads/profile_pictures/' . $friend->profile_picture) }}" 
                                         alt="@lang('profile.profile_picture')" 
                                         class="rounded-circle mb-3" width="100" height="100">
                                @else
                                    <img src="{{ asset('default_profile_picture.png') }}" 
                                         alt="@lang('profile.default_profile_picture')" 
                                         class="rounded-circle mb-3" width="100" height="100">
                                @endif
                                <h5 class="card-title">{{ $friend->name }}</h5>
                                <p class="text-muted">{{ $friend->profession }}</p>
                                <p class="small text-muted">
                                    {{ implode(', ', json_decode($friend->field_of_work, true) ?? [__('profile.no_fields')]) }}
                                </p>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('chat.detail', ['receiverId' => $friend->id]) }}" class="btn btn-primary">@lang('profile.chat_button')</a>
                                    <form action="{{ route('profile.removeFriend', ['friendId' => $friend->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger"> @lang('profile.remove_button') </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">@lang('profile.no_friends')</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    .border-end {
        border-right: 1px solid #ddd;
    }

    .card {
        transition: transform 0.3s ease;
        background: rgba(124, 172, 255, 0.06);
        border-radius: 16px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(5.7px);
        -webkit-backdrop-filter: blur(5.7px);
        border: 1px solid rgba(124, 172, 255, 0.2);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
        transition: background-color 0.3s;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }
</style>
@endsection
@extends('layout.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>@lang('home.connect_friend')</h1>
        
        <form class="row g-2 align-items-center mb-4" action="{{ route('home') }}" method="GET">
            <div class="col-md-6">
                <input class="form-control" type="search" name="search" placeholder="@lang('home.search_placeholder')"
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="gender" class="form-select">
                    <option value="">@lang('home.all_genders')</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>
                        @lang('home.male')
                    </option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>
                        @lang('home.female')
                    </option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100" type="submit">@lang('home.search_button')</button>
            </div>
        </form>
    </div>

    @if (request('search') || request('gender'))
        <h2 class="mb-3">
            @lang('home.search_results')
            @if (request('search')) @lang('home.for') "{{ request('search') }}" @endif
            @if (request('gender')) (@lang('home.gender'): {{ ucfirst(request('gender')) }}) @endif
        </h2>
    @endif

    <div class="row">
        @forelse ($users as $user)
            <div class="col-md-4 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        @if ($user->profile_picture)
                            <img src="{{ asset('uploads/profile_pictures/' . $user->profile_picture) }}" 
                                 alt="@lang('home.profile_picture')" class="rounded-circle mb-3" width="100" height="100">
                        @else
                            <img src="{{ asset('default_profile_picture.png') }}" 
                                 alt="@lang('home.default_profile_picture')" class="rounded-circle mb-3" width="100" height="100">
                        @endif
                        <h5 class="card-title">{{ $user->name }}</h5>
                        <p class="text-muted mb-1">{{ $user->profession }}</p>
                        <p class="text-muted small">
                            {{ implode(', ', json_decode($user->field_of_work, true) ?? [__('home.no_fields')]) }}
                        </p>
                        <form action="{{ route('wishlist.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="wishlist_user_id" value="{{ $user->id }}">
                            @if ($user->isMutual)
                                <a href="{{ route('chat.detail', ['receiverId' => $user->id]) }}" 
                                class="btn btn-primary">@lang('home.chat_button')</a>
                            @elseif ($user->isFollowing)
                                <button type="button" class="btn btn-secondary" disabled>@lang('home.following_button')</button>
                            @else
                                <button type="submit" class="btn btn-outline-primary">@lang('home.thumbs_up') </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted text-center">@lang('home.no_users_found')</p>
        @endforelse
    </div>
</div>

<style>
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
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-outline-primary {
        border-color: #007bff;
        color: #007bff;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
    }
</style>
@endsection
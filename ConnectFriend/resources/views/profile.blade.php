@extends('layout.app')
@section('content')

<div class="container py-5">
        <h1 class="text-center">Profile Page</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 text-center">
                        <img src="{{ $user->profile_picture ? asset('uploads/profile_pictures/' . $user->profile_picture) : asset('default_profile_picture.png') }}"
                             alt="Profile Picture"
                             class="img-thumbnail rounded-circle"
                             style="width: 150px; height: 150px;">
                    </div>

                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Upload New Profile Picture</label>
                        <input type="file" name="profile_picture" id="profile_picture" class="form-control" accept="image/*">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
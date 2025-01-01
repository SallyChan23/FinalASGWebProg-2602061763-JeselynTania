<!-- resources/views/profile.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
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

                    <!-- Display Current Profile Picture -->
                    <div class="mb-3 text-center">
                        <img src="{{ $user->profile_picture ? asset('uploads/profile_pictures/' . $user->profile_picture) : asset('default_profile_picture.png') }}"
                             alt="Profile Picture"
                             class="img-thumbnail rounded-circle"
                             style="width: 150px; height: 150px;">
                    </div>

                    <!-- Upload New Profile Picture -->
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Upload New Profile Picture</label>
                        <input type="file" name="profile_picture" id="profile_picture" class="form-control" accept="image/*">
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
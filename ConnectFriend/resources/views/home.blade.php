<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Welcome to the Home Page</h1>
        <div class="row justify-content-center">
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
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
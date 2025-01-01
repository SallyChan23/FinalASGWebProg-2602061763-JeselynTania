<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Registration Form</h4>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{ route('register.submit') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm your password" required>
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select id="gender" name="gender" class="form-select" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="field_of_work" class="form-label">Field of Work (select at least 3)</label>
                                <div class="d-flex gap-2">
                                    <input type="text" name="field_of_work[]" class="form-control" placeholder="Field 1" required>
                                    <input type="text" name="field_of_work[]" class="form-control" placeholder="Field 2" required>
                                    <input type="text" name="field_of_work[]" class="form-control" placeholder="Field 3" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="profession" class="form-label">Profession</label>
                                <select id="profession" name="profession" class="form-select" required>
                                    <option value="" selected disabled>Select your profession</option>
                                    <option value="Creative">Creative</option>
                                    <option value="Developer">Developer</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Marketing">Marketing</option>
                                    <option value="Designer">Designer</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="linkedin_username" class="form-label">LinkedIn Username</label>
                                <input type="url" id="linkedin_username" name="linkedin_username" class="form-control" placeholder="https://www.linkedin.com/in/username" required>
                            </div>
                            <div class="mb-3">
                                <label for="mobile_number" class="form-label">Mobile Number</label>
                                <input type="text" id="mobile_number" name="mobile_number" class="form-control" placeholder="Enter your mobile number" required>
                            </div>
                            <div class="mb-3">
                                <label for="registration_fee" class="form-label">Registration Fee</label>
                                <input type="hidden" name="registration_fee" value="{{ $registration_fee }}" class="form-control">
                                <p>{{ $registration_fee }}</p>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
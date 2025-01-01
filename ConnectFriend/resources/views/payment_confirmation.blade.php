<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .confirmation-container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            width: 350px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            margin-bottom: 20px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .secondary {
            background-color: #f44336;
        }

        .secondary:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <h1>Payment Confirmation</h1>
        @if(session('message'))
            <p>{{ session('message') }}</p>
        @endif

        <form method="POST" action="{{ route('payment.confirmation.submit') }}">
            @csrf
            <button type="submit" name="action" value="yes">Yes, add to wallet balance</button>
            <button type="submit" class="secondary" name="action" value="no">No, re-enter payment</button>
        </form>
    </div>
</body>
</html>
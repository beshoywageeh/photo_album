<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Photo Album</title>
  <!-- Bootstrap CSS link -->
  @include('layout.css')
  <style>
    body {
      background-color: #f8f9fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .container {
      text-align: center;
    }
    h1 {
      margin-bottom: 30px;
    }
    .btn-custom {
      font-size: 18px;
      padding: 12px 30px;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Photo Album</h1>
    <p class="lead">Welcome to your personal photo album. Please choose an action:</p>
    <a href="{{ route('register') }}" class="btn btn-primary btn-custom">Register</a>
    <a href="{{ route('login') }}" class="btn btn-secondary btn-custom ml-3">Login</a>
  </div>

  <!-- Bootstrap JS and Popper.js -->
  
</body>
</html>

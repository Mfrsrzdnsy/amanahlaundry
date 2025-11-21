<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <title>Amanah Laundry - Register</title>

    <link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/css/style.css" />
</head>

<body>
    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-left">
                        <img class="img-fluid" src="/assets/img/login.png" alt="Logo" />
                    </div>

                    <div class="login-right">
                        <div class="login-right-wrap">

                            <h1>Create Account</h1>
                            <p class="account-subtitle">Already have an account? <a
                                    href="{{ route('login') }}">Login</a></p>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label>Name</label>
                                    <input name="name" class="form-control" type="text" required />
                                </div>

                                <div class="form-group">
                                    <label>Username</label>
                                    <input name="username" class="form-control" type="text" required />
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input name="password" class="form-control" type="password" required />
                                </div>

                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input name="password_confirmation" class="form-control" type="password" required />
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Register</button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>

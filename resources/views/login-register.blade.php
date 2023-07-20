<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login &amp; Register</title>
    <link rel="stylesheet" href="{{ url('frontend/css/style1.css') }}">
    
</head>

<body>
    <h2>Welcome to Todo-List</h2>
    @if(session('message'))
        <div class="alert-warning">
            {{ session('message') }}
        </div>
    @endif
    @if ($errors->any())
    <div class="alert-warning">
        {{ $errors->first() }}
    </div>
    @endif
    
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <h1>Create Account</h1>

                <div class="form-group row">
                    <div class="col-md-6">
                        <input id="name" type="text" placeholder="Name"
                            class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required
                            autocomplete="name">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                   
                    <div class="col-md-6">
                        <input id="email" type="email" placeholder="Email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required
                            autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    
                    <div class="col-md-6">
                        <input id="password" type="password" placeholder="Password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                   
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" placeholder="Confirm Password"
                            name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit">
                            {{('SIGN UP') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group row">
                    <h1>Sign in</h1>

                    <div class="col-md-6">
                        <input id="email" type="email" placeholder="Email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required
                            autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">

                    <div class="col-md-6">
                        <input id="password" type="password" placeholder="Password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit">
                            {{('Sign in') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>Sigin to access your Todo List</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, User!</h1>
                    <p>Create an account to start your journey</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    
    <footer>
        <p>
            Created with <i class="fa fa-heart"></i> by
            <a target="_blank" href="https://florin-pop.com">Florin Pop</a>
            - Read how I created this and how you can join the challenge
            <a target="_blank" href="https://www.florin-pop.com/blog/2019/03/double-slider-sign-in-up-form/">here</a>.
        </p>
    </footer>

    <script src="{{ url('frontend/js/app1.js') }}"></script>
</body>

</html>
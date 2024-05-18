<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        @layer demo {
            button {
                all: unset;
            }
        }

    </style>

</head>
<body>

    @php
    $routeName = request()->route()->getName();
    @endphp



    <nav class="navbar navbar-expand-lg bg-body-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Le Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a @class(['nav-link', 'active'=> str_starts_with($routeName, 'blog.')]) aria-current="page" href="{{ route('blog.index') }}">Blog</a>
                    </li>
                </ul>
                <div class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @auth
                        {{ \Illuminate\Support\Facades\Auth::user()->name }}

                        <form class="nav-item" action="{{ route('auth.logout') }}" method="post">
                            @method("delete")
                            @csrf
                            <button class="nav-link">Se déconnecter</button>
                        </form>
                    @endauth

                    @guest
                    <div class="nav-item">
                        <a class="nav-link" href="{{ route('auth.login') }}">Se connecter</a>
                    </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        @if('success')
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @yield('content')
    </div>


</body>
</html>

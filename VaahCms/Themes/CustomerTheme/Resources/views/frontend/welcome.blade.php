@extends("customertheme::frontend.layouts.default")

@section('vaahcms_extend_frontend_head')

@endsection

@section('vaahcms_extend_frontend_css')

@endsection

@section('vaahcms_extend_frontend_scripts')

@endsection

@section('content')
    <nav class="navbar">
        <div class="container">
            <div id="navbarMenu" class="navbar-menu">
                <div class="navbar-end">
                    <div class="tabs is-right">
                        <ul>
                            <li><a href="/home">Home</a> </li>
                            @auth()
                                <li><a href="/signout">Log out</a></li>
                            @endauth
                            @guest()
                                <li><a href="/signin">Login</a></li>
                                <li><a href="/signup">Register</a></li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container has-text-centered mt-6">

        <div class="notification is-link is-light">
            This page should contain welcome message which does not require any database to run.
            You can write theme setup information.
        </div>
        <div>
            <h1>Customer theme</h1>
        </div>

        <section class="hero">
            <div class="hero-body">
                <p class="title">CustomerTheme</p>

                <p class="subtitle">Welcome Page.</p>

            </div>
        </section>
        @yield('footer')
    </div>

@endsection




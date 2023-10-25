@extends("customertheme::frontend.layouts.default")

@section('vaahcms_extend_frontend_head')

@endsection

@section('vaahcms_extend_frontend_css')
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.0/css/bulma.min.css" />
@endsection

@section('vaahcms_extend_frontend_scripts')

@endsection

@section('content')

<div class="container has-text-centered mt-6">

        <section class="hero">
            <div class="hero-body">
                <p class="title">CustomerTheme</p>

                <p class="subtitle">Default Page</p>
                <p class="subtitle">This is the fallback page.</p>

            </div>
        </section>

</div>
@endsection
@section('footer')

    {!! config('settings.global.copyright_text'); !!}

@endsection

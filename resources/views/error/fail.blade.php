@extends('layout.user')

@section('title', 'Error Page')

@section('content')
    <section>
        <div class="container position-relative">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <h1 class="mb-4 display-1 lh-sm">Error</h1>
                <img src="{{ asset('img/illustrations/error_vector.png') }}" class="img-fluid" width="45%" alt="">
                @if (isset($error))
                    <h4>{{ $error }}</h4>
                @endif
            </div>
        </div>
    </section>
@endsection

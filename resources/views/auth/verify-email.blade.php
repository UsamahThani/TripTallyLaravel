@extends('layout.auth')

@section('title', 'Verify Email')

@section('content')
    <main id="top">
        <div id="particles-js" class="position-absolute overflow-hidden top-0 start-0 w-100 h-100"></div>
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div class="card shadow-lg p-3 w-100" style="max-width: 400px; background-color: rgba(255, 255, 255, 0.9);">
                <div class="card-body">
                    <h3 class="text-center mb-3">Verify Email Address</h3>
                    <div class="d-flex justify-content-center w-100">
                        <img src="{{asset('img/icons/verified.gif')}}" class="img-fluid" width="150px" alt="">
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <div class="d-flex justify-content-center mt-3">
                            @if (session('success'))
                                <button type="submit" class="btn btn-success">Resend Email Verification</button>
                            @else
                                <button type="submit" class="btn btn-success">Send Email Verification</button>
                            @endif
                        </div>

                    </form>
                </div>
            </div>
        </div>
        </div>
    </main>
@endsection

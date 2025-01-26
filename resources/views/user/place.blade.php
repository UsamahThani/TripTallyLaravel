@extends('layout.user')

@section('title', 'Place Result')

@section('content')
    <section>
        <div class="container">
            <div class="title d-flex w-100 justify-content-center my-4">
                <h1 class="fw-bold">{{ session('searchType') }} Result</h1>
            </div>
            <div class="hotel-container row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 justify-content-center">
                @foreach ($placeList as $place)
                    <div class="col my-3">
                        <div class="card card-place bg-light h-100 border border-1 rounded-1" style="width: 18rem;">
                            <img src="{{ $place['photo_url'] }}" class="card-img-top img-fluid object-fit-cover"
                                style="height: 200px;" alt="hotel image">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title fw-bold">{{ $place['place_name'] }}</h6>
                                <p class="card-text" style="font-size: 12px">{{ $place['place_location'] }}</p>
                                <div class="price-rating w-100 d-flex justify-content-between align-items-center mt-auto">
                                    <p>RM {{ $place['price'] }}</p>
                                    <p>{{ $place['rating'] }}/5</p>
                                </div>
                                <div class="mt-auto w-100 d-flex justify-content-between">
                                    <form action="{{ route('cart.create') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="place_id" value="{{ $place['place_id'] }}">
                                        <input type="hidden" name="place_name" value="{{ $place['place_name'] }}">
                                        <input type="hidden" name="place_location" value="{{ $place['place_location'] }}">
                                        <input type="hidden" name="price" value="{{ $place['price'] }}">
                                        <input type="hidden" name="place_type" value="{{ session('searchType') }}">
                                        @php
                                            $isBooked = in_array($place['place_id'], $bookedPlaces);
                                        @endphp
                                        <input type="submit"
                                            value="{{ (session('searchType') === 'Hotels' && $hotelBooked) || $isBooked ? 'Booked' : 'Book' }}"
                                            class="btn btn-secondary booked-btn"
                                            {{ (session('searchType') === 'Hotels' && $hotelBooked) || $isBooked ? 'disabled' : '' }}>
                                    </form>
                                    <a href="#" class="btn btn-primary">Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@extends('layout.user')

@section('title', 'Place Result')

@section('content')
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11; display: none;">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
            <div class="toast-header bg-success text-white">
                <img src="{{ asset('img/favicons/favicon-32x32.png') }}" class="rounded me-2" alt="...">
                <strong class="me-auto">{{ config('app.name') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                @if (session('success'))
                    {{ session('success') }}
                @elseif (session('error'))
                    {{ session('error') }}
                @endif
            </div>
        </div>
    </div>
    <section>
        <div class="container">
            <div class="title d-flex w-100 justify-content-center my-4">
                <h1 class="fw-bold">{{ session('searchType') }} Result</h1>
            </div>
            <div
                class="hotel-container row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 justify-content-center">
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
                                    <form id="cart-form-{{ $place['place_id'] }}" action="{{ route('cart.create') }}"
                                        method="POST"
                                        class="{{ session('searchType') == 'Attractions' ? 'ajax-form' : '' }}">
                                        @csrf
                                        <input type="hidden" name="place_id" value="{{ $place['place_id'] }}">
                                        <input type="hidden" name="place_name" value="{{ $place['place_name'] }}">
                                        <input type="hidden" name="place_location" value="{{ $place['place_location'] }}">
                                        <input type="hidden" name="price" value="{{ $place['price'] }}">
                                        <input type="hidden" name="photo_url" value="{{ $place['photo_url'] }}">
                                        <input type="hidden" name="place_type" value="{{ session('searchType') }}">
                                        @php
                                            $isBooked = in_array($place['place_id'], $bookedPlaces);
                                        @endphp
                                        <input type="submit"
                                            value="{{ (session('searchType') === 'Hotels' && $hotelBooked) || $isBooked ? 'Booked' : 'Book' }}"
                                            class="btn btn-success booked-btn"
                                            {{ (session('searchType') === 'Hotels' && $hotelBooked) || $isBooked ? 'disabled' : '' }}>
                                    </form>
                                    <a href="{{ route('place.detail', ['place_id' => $place['place_id'], 'price' => $place['price']]) }}" class="btn btn-primary">Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            function showToast(message, type = 'success') {
                var toastElement = $('#liveToast');
                var toastBody = toastElement.find('.toast-body');
                var toastHeader = toastElement.find('.toast-header');

                // Update the message and style based on the type
                toastBody.text(message);
                toastHeader.removeClass('bg-success bg-danger');
                toastHeader.addClass(type === 'success' ? 'bg-success' : 'bg-danger');

                // Show the toast container (make it visible)
                toastElement.closest('.position-fixed').fadeIn();

                // Show the toast using Bootstrap's Toast API
                var bsToast = new bootstrap.Toast(toastElement[0]);
                bsToast.show();

                // Automatically hide the toast container after the toast disappears
                bsToast._element.addEventListener('hidden.bs.toast', function() {
                    toastElement.closest('.position-fixed').fadeOut();
                });
            }
            @if (session('searchType') == 'Attractions')
                $('form.ajax-form').on('submit', function(event) {
                    event.preventDefault();
                    var form = $(this);
                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: form.serialize(),
                        success: function(response) {
                            console.log('Place added to cart successfully');
                            form.find('input[type="submit"]').val('Booked').prop('disabled',
                                true);
                            showToast('Place has been added successfully!', 'success');
                        },
                        error: function(response) {
                            showToast('Place added failed!', 'error');
                            console.log('Place added to cart failed');
                        }
                    });
                });
            @endif
        });
    </script>
@endsection

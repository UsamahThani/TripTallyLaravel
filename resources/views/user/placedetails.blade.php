@extends('layout.user')

@section('title', $placeData['name'] . ' Details')

@section('content')
    <style>
        .slide-img-btn {
            position: absolute;
            height: 100%;
            background-color: transparent;
            border: none;
            transition: background-color 0.3s ease;
            z-index: 2;
        }

        .slide-img-btn:hover {
            background-color: rgba(200, 199, 199, 0.804)
        }

        .slide-img-btn.rounded-start {
            left: 0;
        }

        .slide-img-btn.rounded-end {
            right: 0;
        }

        .set-img {
            overflow-x: scroll;
            scroll-behavior: smooth;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .set-img::-webkit-scrollbar {
            display: none;
        }

        #primary-img {
            transition: opacity 0.5s ease-in-out;
        }

        #map {
            height: 400px;
            width: 100%;
        }

        #street-view {
            height: 400px;
            width: 100%;
        }
    </style>
    <section>
        <div class="container">
            <div class="title d-flex w-100 justify-content-center my-4">
                <h1 class="fw-bold">{{ $placeData['name'] }}</h1>
            </div>
            <div class="place-details p-3 bg-light rounded">
                <div class="row">
                    <div class="col-md-4">
                        <div class="group-img">
                            <div class="d-flex justify-content-center">
                                <img id="primary-img" src="{{ $firstPhoto }}" class="img-fluid object-fit-cover rounded"
                                    style="height: 400px; width: 400px;" alt="">
                            </div>
                            <div class="my-2 d-flex justify-content-around position-relative w-100">
                                <div class="d-flex position-relative" style="height: 100px;">
                                    <button class="slide-img-btn rounded-start"><i
                                            class="fa-solid fa-caret-left text-dark"></i></button>
                                </div>
                                <div class="d-flex set-img">
                                    @foreach ($otherPhoto as $photo)
                                        <img id="secondary-img" src="{{ $photo }}"
                                            class="img-fluid object-fit-cover rounded mx-2"
                                            style="height: 100px; width: 100px; cursor: pointer;"
                                            onclick="swapImage(event)">
                                    @endforeach
                                </div>
                                <div class="d-flex position-relative" style="height: 100px;">
                                    <button class="slide-img-btn rounded-end"><i
                                            class="fa-solid fa-caret-right text-dark"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 d-flex flex-column justify-content-between">
                        <table class="table p-4 table-light table-striped-columns h-100 place-info-table">

                            <tr>
                                <th>Place Name</th>
                                <td>:</td>
                                <td>{{ $placeData['name'] }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>:</td>
                                <td>{{ $placeData['address'] }}</td>
                            </tr>
                            <tr>
                                <th>Rating</th>
                                <td>:</td>
                                <td>{{ $placeData['rating'] }}</td>
                            </tr>
                            <tr>
                                <th>Total Ratings</th>
                                <td>:</td>
                                <td>{{ $placeData['user_ratings_total'] }}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>:</td>
                                <td>{{ isset($placeData['types']) ? htmlspecialchars(implode(', ', $placeData['types'])) : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Opening Hours</th>
                                <td>:</td>
                                <td>
                                    @if (isset($placeData['opening_hours']['periods']) && count($placeData['opening_hours']['periods']) == 6)
                                        <table class="table">
                                            <tbody>
                                                @foreach ($placeData['opening_hours']['periods'] as $period)
                                                    @php
                                                        // Get the day of the week (0 = Sunday, 1 = Monday, etc.)
                                                        $openDay = $period['open']['day'] ?? null;
                                                        $closeDay = $period['close']['day'] ?? null;

                                                        // Convert the day numbers to weekday names
                                                        $daysOfWeek = [
                                                            0 => 'Sunday',
                                                            1 => 'Monday',
                                                            2 => 'Tuesday',
                                                            3 => 'Wednesday',
                                                            4 => 'Thursday',
                                                            5 => 'Friday',
                                                            6 => 'Saturday',
                                                        ];

                                                        $openDayName =
                                                            $openDay !== null ? $daysOfWeek[$openDay] : 'N/A';
                                                        $closeDayName =
                                                            $closeDay !== null ? $daysOfWeek[$closeDay] : 'N/A';

                                                        // Format the time (convert from 24-hour format to 12-hour format)
                                                        $openingTime = isset($period['open']['time'])
                                                            ? date('h:i A', strtotime($period['open']['time']))
                                                            : 'N/A';
                                                        $closingTime = isset($period['close']['time'])
                                                            ? date('h:i A', strtotime($period['close']['time']))
                                                            : 'N/A';
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $openDayName }}</td>
                                                        <td>{{ $openingTime }}</td>
                                                        <td>{{ $closingTime }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p class="text-danger d-flex justify-content-center">
                                            Opening hours not available</p>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Phone Number</th>
                                <td>:</td>
                                <td>{{ $placeData['phone_num'] }}</td>
                            </tr>
                            <tr>
                                <th>Website</th>
                                <td>:</td>
                                <td>
                                    <a href="{{ isset($placeData['website']) ? $placeData['website'] : '#' }}"
                                        target="_blank"> {{ isset($placeData['website']) ? 'Visit Website' : 'N/A' }} </a>
                                </td>
                            </tr>

                        </table>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success btn-lg">Book</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="title d-flex w-100 justify-content-center my-4">
                <h2 class="fw-bold">Location</h2>
            </div>
            <div class="place-iframe p-3 bg-light rounded">
                <div id="map" class="mb-2 rounded"></div>
                <div id="street-view" class="rounded"></div>
            </div>
        </div>
        <div class="container">
            <div class="title d-flex w-100 justify-content-center my-4">
                <h2 class="fw-bold">Review</h2>
            </div>
            <div class="place-iframe p-3 bg-light rounded">
                
            </div>
        </div>
    </section>
    <section>
        
    </section>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.api_key') }}&callback=initMap"
        async defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.querySelector(".set-img");
            const btnLeft = document.querySelector(".slide-img-btn.rounded-start");
            const btnRight = document.querySelector(".slide-img-btn.rounded-end");

            const scrollAmount = 120; // Adjust for how much it scrolls per click

            btnLeft.addEventListener("click", function() {
                if (container.scrollLeft <= 0) {
                    container.scrollLeft = container.scrollWidth - container.clientWidth;
                } else {
                    container.scrollBy({
                        left: -scrollAmount,
                        behavior: "smooth"
                    });
                }
            });

            btnRight.addEventListener("click", function() {
                if (container.scrollLeft + container.clientWidth >= container.scrollWidth) {
                    container.scrollLeft = 0;
                } else {
                    container.scrollBy({
                        left: scrollAmount,
                        behavior: "smooth"
                    });
                }
            });

        });

        function swapImage(event) {
            // Get the clicked secondary image
            const secondaryImg = event.target;
            // Get the primary image
            const primaryImg = document.getElementById('primary-img');

            // Add transition effect
            primaryImg.style.opacity = 0;

            setTimeout(() => {
                // Swap the src attributes
                const tempSrc = primaryImg.src;
                primaryImg.src = secondaryImg.src;
                secondaryImg.src = tempSrc;

                // Restore opacity
                primaryImg.style.opacity = 1;
            }, 500); // Match the duration of the CSS transition
        }

        function initMap() {
            // Get Latitude and Longitude from Laravel Session
            var lat = {{ $placeData['geometry']['location']['lat'] }}; // Default: KL
            var lng = {{ $placeData['geometry']['location']['lng'] }}; // Default: KL
            var location = {
                lat: lat,
                lng: lng
            };

            // Initialize Google Map
            var map = new google.maps.Map(document.getElementById("map"), {
                center: location,
                zoom: 14
            });

            // Initialize Street View
            var streetView = new google.maps.StreetViewPanorama(
                document.getElementById("street-view"), {
                    position: location,
                    pov: {
                        heading: 165,
                        pitch: 0
                    },
                    zoom: 1
                }
            );

            // Connect Street View to the map
            map.setStreetView(streetView);

            // Add a marker to the map
            var marker = new google.maps.Marker({
                position: location,
                map: map,
                draggable: true
            });

            // Update Street View when marker is moved
            marker.addListener("dragend", function(event) {
                var newLocation = {
                    lat: event.latLng.lat(),
                    lng: event.latLng.lng()
                };
                map.setCenter(newLocation);
                streetView.setPosition(newLocation);
            });

            // Update marker when clicking on the map
            map.addListener("click", function(event) {
                var newLocation = {
                    lat: event.latLng.lat(),
                    lng: event.latLng.lng()
                };
                // marker.setPosition(newLocation);
                streetView.setPosition(newLocation);
            });
        }
    </script>
@endsection

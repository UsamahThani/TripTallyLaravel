@extends('layout.user')

@section('title', $placeData['name'] . ' Details')

@section('content')
    <section>
        <div class="container">
            <div class="title d-flex w-100 justify-content-center my-4">
                <h1 class="fw-bold">>{{ $placeData['name'] }}</h1>
            </div>
            <div class="place-details p-3 bg-light rounded">
                <div class="row">
                    <div class="col-md-4">
                        <div class="group-img">
                            <div class="d-flex justify-content-center">
                                <img id="primary-img" src="{{ $firstPhoto }}"
                                    class="img-fluid object-fit-cover rounded" style="height: 400px; width: 400px;"
                                    alt="">
                            </div>
                            <div class="set-img my-2 d-flex justify-content-between">
                                @for ($i = 0; $i < 4; $i++)
                                    <img id="secondary-img" src="{{ asset('img/gallery/indonesia.png') }}"
                                        class="img-fluid object-fit-cover rounded" style="height: 100px; width: 100px;"
                                        alt="">
                                @endfor
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
                                    <table class="table">
                                        <tbody>
                                            @foreach ($placeData['opening_hours']['periods'] as $period)
                                                @php
                                                    // Get the day of the week (0 = Sunday, 1 = Monday, etc.)
                                                    $openDay = $period['open']['day'];
                                                    $closeDay = $period['close']['day'];

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

                                                    $openDayName = $daysOfWeek[$openDay];
                                                    $closeDayName = $daysOfWeek[$closeDay];

                                                    // Format the time (convert from 24-hour format to 12-hour format)
                                                    $openingTime = date('h:i A', strtotime($period['open']['time']));
                                                    $closingTime = date('h:i A', strtotime($period['close']['time']));
                                                @endphp
                                                <tr>
                                                    <td>{{ $openDayName }}</td>
                                                    <td>{{ $openingTime }}</td>
                                                    <td>{{ $closingTime }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
    </section>
@endsection

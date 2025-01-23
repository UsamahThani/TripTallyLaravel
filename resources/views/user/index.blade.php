@extends('layout.user')

@section('title', 'Main Page')

@section('content')
    <section class="py-0">
        <div class="bg-holder d-none d-md-block"
            style="background-image:url({{ asset('img/background/vector_travel.png') }});background-position:right bottom;background-size:contain;">
        </div>
        <!--/.bg-holder-->

        <div class="container position-relative">
            <div class="row align-items-center min-vh-75 my-lg-8">
                <div class="col-md-7 col-lg-6 text-center text-md-start py-8">
                    <h1 class="mb-4 display-1 lh-sm">Trip Finder</h1>
                    <form action="{{ route('trip.place') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <label class="visually-hidden" for="autoSizingSelect">From Location</label>
                            <select class="form-select expandable-select" name="from_location" required
                                id="autoSizingSelect" style="color:#828282;" onfocus='this.size=5;' onblur='this.size=1;'
                                onchange='this.size=1; this.blur();'>
                                <option value="" disabled selected>From</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state['name'] }}">{{ $state['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <label class="visually-hidden" for="autoSizingSelect">Destination Location</label>
                            <select class="form-select expandable-select" name="dest_location" required
                                id="autoSizingSelect" style="color:#828282;" onfocus='this.size=5;' onblur='this.size=1;'
                                onchange='this.size=1; this.blur();'>
                                <option value="" disabled selected>Destination</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state['name'] }}">{{ $state['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text text-dark d-flex justify-content-center" style="width: 55px"><i
                                    class="fa-solid fa-plane-departure fa-lg"></i></span>
                            <input placeholder="Departure Date" class="form-control" required name="depart_date"
                                type="text" style="color:#828282;" onfocus="(this.type='date')" id="departureDate" />
                            <input placeholder="Return Date" class="form-control" required type="text"
                                style="color:#828282;" name="return_date" id="returnDate" onfocus="(this.type='date')" />
                            <span class="input-group-text text-dark d-flex justify-content-center" style="width: 55px"><i
                                    class="fa-solid fa-plane-arrival fa-flip-horizontal fa-lg"></i></span>
                        </div>
                        <div class="input-group mb-4">
                            <span class="input-group-text text-dark d-flex justify-content-center fw-bold"
                                style="width: 55px">RM</span>
                            <input placeholder="Max Budget" min="200" required step="1.00" class="form-control"
                                type="number" style="color:#828282;" name="budget" />
                            <input placeholder="Person" min="1" max="10" required class="form-control"
                                type="number" style="color:#828282;" name="person_num" />
                            <span class="input-group-text text-dark d-flex justify-content-center" style="width: 55px"><i
                                    class="fa-solid fa-user fa-lg"></i></span>
                        </div>
                        <div class="input-group mb-3">
                            <input type="submit" class="form-control btn btn-primary" value="Search" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        const departureDateInput = document.getElementById('departureDate');
        const returnDateInput = document.getElementById('returnDate');
        const today = new Date();
    
        // Function to format date as YYYY-MM-DD
        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
    
        // Set today's date as the minimum for the departure date
        departureDateInput.setAttribute('min', formatDate(today));
        returnDateInput.setAttribute('min', formatDate(today));
    
        departureDateInput.addEventListener('change', function() {
            const departureDate = departureDateInput.value;
            returnDateInput.setAttribute('min', departureDate);
        });
    </script>

    <script>
        const expandableSelects = document.querySelectorAll('.expandable-select');

        expandableSelects.forEach(select => {
            select.addEventListener('focus', () => {
                select.style.maxHeight = '200px'; // Expand smoothly
                select.style.overflowY = 'auto'; // Enable scrolling if needed
            });

            select.addEventListener('blur', () => {
                setTimeout(() => { // Slight delay to allow transition to complete before removing scroll
                    select.style.maxHeight = '40px'; // Collapse smoothly
                    select.style.overflowY = 'hidden'; // Prevent scrollbar flickering
                }, 100); // Adjust this delay as needed for smoothness
            });

            select.addEventListener('change', () => {
                select.style.maxHeight = '40px'; // Collapse when option is selected
                select.style.overflowY = 'hidden'; // Disable scrolling
            });
        });
    </script>

    <style>
        .expandable-select {
            transition: max-height 0.3s ease-in-out;
            /* Smooth transition for opening and closing */
            overflow-y: hidden;
            /* Prevent scrollbar initially */
            max-height: 40px;
            /* Initial collapsed height */
        }
    </style>
@endsection

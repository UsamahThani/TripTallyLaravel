@extends('layout.user')

@section('title', 'Main Page')

@section('content')
    <section class="py-0">
        <div class="bg-holder d-none d-md-block"
            style="background-image:url({{ asset('img/illustrations/hero.png') }});background-position:right bottom;background-size:contain;">
        </div>
        <!--/.bg-holder-->

        <div class="container position-relative">
            <div class="row align-items-center min-vh-75 my-lg-8">
                <div class="col-md-7 col-lg-6 text-center text-md-start py-8">
                    <h1 class="mb-4 display-1 lh-sm">Trip Finder</h1>
                    <form action="">
                        <div class="input-group mb-3">
                            <label class="visually-hidden" for="autoSizingSelect">From Location</label>
                            <select class="form-select" name="from_location" required id="autoSizingSelect"
                                style="color:#828282;" onfocus='this.size=5;' onblur='this.size=1;'
                                onchange='this.size=1; this.blur();'>
                                <option value="" disabled selected>From</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state['name'] }}">{{ $state['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <label class="visually-hidden" for="autoSizingSelect">Destination Location</label>
                            <select class="form-select" name="from_location" required id="autoSizingSelect"
                                style="color:#828282;" onfocus='this.size=5;' onblur='this.size=1;'
                                onchange='this.size=1; this.blur();'>
                                <option value="" disabled selected>Destination</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state['name'] }}">{{ $state['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text text-dark"><i class="fa-solid fa-plane-departure fa-lg"></i></span>
                            <input placeholder="Departure Date" class="form-control" type="text" style="color:#828282;"
                                onfocus="(this.type='date')" id="departureDate" />
                            <input placeholder="Return Date" class="form-control" type="text" style="color:#828282;"
                                name="return_date" id="returnDate" onfocus="(this.type='date')" />
                            <span class="input-group-text text-dark"><i class="fa-solid fa-plane-arrival fa-flip-horizontal fa-lg"></i></span>
                        </div>
                        <div class="input-group mb-4">
                            <span class="input-group-text text-dark">RM</span>
                            <input placeholder="Max Budget" min="200" step="1.00" class="form-control"
                                type="number" style="color:#828282;" name="return_date" />
                            <input placeholder="Person" min="1" max="10" class="form-control" type="number"
                                style="color:#828282;" name="return_date" />
                            <span class="input-group-text text-dark"><i class="fa-solid fa-user fa-xl"></i></span>
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

        departureDateInput.addEventListener('change', function() {
            const departureDate = departureDateInput.value;
            returnDateInput.setAttribute('min', departureDate);
        });
    </script>
@endsection

@extends('layout.user')

@section('title', 'Hotel Result')

@section('content')
    <section>
        <div class="container">
            <div class="title d-flex w-100 justify-content-center my-4">
                <h1 class="fw-bold">Hotel Result</h1>
            </div>
            <div class="hotel-container row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 justify-content-center">
                @foreach ($placeList as $place)
                <div class="col my-3">
                    <div class="card bg-light border border-1 rounded-1" style="width: 18rem;">
                        <img src="{{$place->photo_url}}" class="card-img-top img-fluid object-fit-cover" style="height: 200px;" alt="hotel image">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold">{{$place->place_name}}</h6>
                            <p class="card-text" style="font-size: 12px">{{$place->address}}</p>
                            <div class="price-rating w-100 d-flex justify-content-between align-items-center mt-auto">
                                <p>RM {{$place->price}}</p>
                                <p>{{$place->rating}}/5</p>
                            </div>
                            <div class="mt-auto w-100 d-flex justify-content-between">
                                <button class="btn btn-secondary booked-btn">Add to Cart</button>
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
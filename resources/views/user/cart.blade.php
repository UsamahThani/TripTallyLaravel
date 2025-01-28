@extends('layout.user')

@section('title', 'Cart')

@section('content')
    <section>
        <div class="container ">
            <div class="row">
                <div class="col-8">
                    <div class="w-100 mt-4 mb-5 ">
                        <h1 class="fw-bold">Cart</h1>
                        <span>{{ $trip['from_location'] }}</span> <i class="fa-solid fa-right-long mx-3"></i>
                        <span>{{ $trip['dest_location'] }}</span><br>
                        <span>{{ $trip['depart_date'] }}</span> <i class="fa-solid fa-left-long mx-3"></i>
                        <span>{{ $trip['return_date'] }}</span>
                    </div>
                    <div class="cart">
                        <div class="category mb-2">
                            <hr>
                            <h4>Hotels</h4>
                            <hr>
                        </div>
                        @if ($hotelsCart)
                            <div class="d-flex justify-content-between p-3 bg-light rounded-1 mb-4">
                                <div class="place-detail d-flex">
                                    <img src="{{ $hotelsCart['photo_url'] }}" class="rounded-1 object-fit-cover"
                                        width="200px" height="150px" alt="">
                                    <div class="mx-3">
                                        <h4 class="fw-bold">{{ $hotelsCart['place_name'] }}</h4>
                                        <span>{{ $hotelsCart['place_location'] }}</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column justify-content-between">
                                    <form action="{{ route('cart.delete') }}" method="POST" class="d-flex justify-content-end">
                                        @csrf
                                        <input type="hidden" value="{{ $hotelsCart['cart_id'] }}" name="cart_id">
                                        <button type="submit" class="btn"
                                            onmouseover="this.dataset.originalColor = this.style.color; this.style.color='red'"
                                            onmouseout="this.style.color = this.dataset.originalColor"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </form>
                                    <div class="d-flex w-100 justify-content-end">
                                        <h5>RM {{ $hotelsCart['price'] }}</h5>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="d-flex justify-content-center m-4">
                                <span class="fs-sm-1">No hotel in cart</span>
                            </div>
                        @endif
                        <div class="category mb-2">
                            <hr>
                            <h4>Attractions</h4>
                            <hr>
                        </div>
                        @if ($attractionsCart)
                            @foreach ($attractionsCart as $poi)
                                <div class="d-flex justify-content-between p-3 bg-light rounded-1 mb-4">
                                    <div class="place-detail d-flex">
                                        <img src="{{ $poi['photo_url'] }}" class="rounded-1 object-fit-cover" width="200px"
                                            height="150px" alt="">
                                        <div class="mx-3">
                                            <h4 class="fw-bold">{{ $poi['place_name'] }}</h4>
                                            <span>{{ $poi['place_location'] }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column justify-content-between" style="width: 100px">
                                        <form action="{{ route('cart.delete') }}" method="POST"
                                            class="d-flex justify-content-end">
                                            @csrf
                                            <input type="hidden" value="{{ $poi['cart_id'] }}" name="cart_id">
                                            <button type="submit" class="btn"
                                                onmouseover="this.dataset.originalColor = this.style.color; this.style.color='red'"
                                                onmouseout="this.style.color = this.dataset.originalColor"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        </form>
                                        <div class="d-flex w-100 justify-content-end">
                                            <h5>RM {{ $poi['price'] }}</h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="d-flex justify-content-center m-4">
                                <span class="fs-sm-1">No hotel in cart</span>
                            </div>

                        @endif
                    </div>
                </div>
                <div class="col-4">
                    <div class="w-100 mt-4 mb-5 sticky-top bg-500 text-white p-3 rounded-1" style="top: 10rem;">
                        <h3 class="fw-bold mt-4">Summary</h3>
                        <hr>
                        <div class="d-flex justify-content-between my-3">
                            <h5>Maximum Budget:</h5>
                            <span class="text-success fs-sm-2">RM {{ $trip['budget'] }}</span>
                        </div>
                        <div class="d-flex justify-content-between my-3">
                            <h5>Hotel Total:</h5>
                            <span class="text-success fs-sm-2">RM {{ $hotelsCart['price'] ?? 0.00 }}</span>
                        </div>
                        <div class="d-flex justify-content-between my-3">
                            <h5>Attractions Total: </h5>
                            <span class="text-success fs-sm-2">RM {{ $poiTotal ?? 0.00 }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between my-3">
                            <h3>Grand Total</h3>
                            <h3 class="text-success">RM {{ $grandTotal ?? 0.00 }}</h3>
                        </div>
                        <hr>
                        <div class="my-4">
                            <button class="btn btn-success w-100">Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('layout.user')

@section('title', 'Cart')

@section('content')
    <section>
        <div class="container ">
            <div class="row">
                <div class="col-8">
                    <div class="w-100 mt-4 mb-5 ">
                        <h1 class="fw-bold">Cart</h1>
                        <span>Kelantan -> Kuala Lumpur</span><br>
                        <span>24-01-2025 -> 27-01-2025</span>
                    </div>
                    <div class="cart">
                        <div class="category mb-2">
                            <hr>
                            <h4>Hotels</h4>
                            <hr>
                        </div>
                        <div class="d-flex justify-content-between p-3 bg-light rounded-1 mb-4">
                            <div class="place-detail d-flex">
                                <img src="{{ asset('img/gallery/backpacking.png') }}" class="rounded-1" width="200px"
                                    alt="">
                                <div class="mx-3">
                                    <h4 class="fw-bold">Place Name</h4>
                                    <span>Location</span>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-between">
                                <form action="#" class="d-flex justify-content-end">
                                    <input type="hidden" value="cart_id" name="cart_id">
                                    <button type="submit" class="btn"
                                        onmouseover="this.dataset.originalColor = this.style.color; this.style.color='red'"
                                        onmouseout="this.style.color = this.dataset.originalColor"><i
                                            class="fa-solid fa-trash"></i></button>
                                </form>
                                <h4>RM 200</h4>
                            </div>
                        </div>
                        <div class="category mb-2">
                            <hr>
                            <h4>Attractions</h4>
                            <hr>
                        </div>
                        <div class="d-flex justify-content-between p-3 bg-light rounded-1 mb-4">
                            <div class="place-detail d-flex">
                                <img src="{{ asset('img/gallery/backpacking.png') }}" class="rounded-1" width="200px"
                                    alt="">
                                <div class="mx-3">
                                    <h4 class="fw-bold">Place Name</h4>
                                    <span>Location</span>
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-between">
                                <form action="#" class="d-flex justify-content-end">
                                    <input type="hidden" value="cart_id" name="cart_id">
                                    <button type="submit" class="btn"
                                        onmouseover="this.dataset.originalColor = this.style.color; this.style.color='red'"
                                        onmouseout="this.style.color = this.dataset.originalColor"><i
                                            class="fa-solid fa-trash"></i></button>
                                </form>
                                <h4>RM 200</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="w-100 mt-4 mb-5 sticky-top bg-primary text-white p-3" style="top: 10rem;">
                        <span>test</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

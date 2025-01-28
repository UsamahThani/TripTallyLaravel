@extends('layout.user')

@section('title', 'some name here')

@section('content')
<section>
    <div class="container">
        <div class="title d-flex w-100 justify-content-center my-4">
            <h1 class="fw-bold">Name here</h1>
        </div>
        <div class="place-details p-3 bg-light rounded">
            <div class="row">
                <div class="col-md-4">
                    <div class="group-img">
                        <div class="d-flex justify-content-center">
                            <img src="{{asset('img/gallery/indonesia.png')}}" class="img-fluid object-fit-cover rounded" style="height: 400px; width: 400px;" alt="">
                        </div>
                        <div class="set-img my-2 d-flex justify-content-between">
                            @for ($i = 0; $i < 4; $i++)
                            <img src="{{asset('img/gallery/indonesia.png')}}" class="img-fluid object-fit-cover rounded" style="height: 100px; width: 100px;" alt="">
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="col-md-8 d-flex flex-column justify-content-between">
                    <table class="table p-4 table-light table-hover table-striped-columns">
                        @for ($i = 1; $i < 10; $i++)
                        <tr>
                            <th>Place Name</th>
                            <td>something</td>
                        </tr>
                        @endfor
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
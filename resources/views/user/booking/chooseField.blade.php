@extends('user.layouts.main')

@section('content')
    <!-- Header -->
    <header class="ex-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1">
                    <h1>Our Fields</h1>
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </header> <!-- end of ex-header -->
    <!-- end of header -->

    <div class="container py-5">
        <div class="d-flex justify-content-end">
            <form method="GET" action="{{ route('user.search') }}">
                <div class="input-group">
                    <input class="form-control" name="search" placeholder="Search Field Type" aria-label="Search">
                    <button class="btn-solid-small" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Blog Start -->
        <div class="container pt-2">
            <div class="row pb-3">
                @if ($fieldDatas->isEmpty())
                    <div class="col-md-12 text-center">
                        <p>Data not available</p>
                    </div>
                @else
                    @foreach ($fieldDatas as $data)
                        <div class="col-lg-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm mb-2">
                                <img class="card-img-top p-2 rounded-4" src="{{ asset('storage/' . $data->thumbnail) }}"
                                    alt="" />
                                <div class="card-body bg-light p-4">
                                    <h4 class="text-center">{{ $data->name }}</h4>
                                    <div class="text-center py-2">
                                        <p>{{ $data->field_type }}</p>
                                    </div>
                                    <table>
                                        <tr>
                                            <td>Jenis Material</td>
                                            <td>:</td>
                                            <td class="text-capitalize">{{ $data->field_material }}</td>
                                        </tr>
                                        <tr>
                                            <td>Lokasi Lapangan</td>
                                            <td>:</td>
                                            <td>{{ $data->field_location }}</td>
                                        </tr>
                                        <tr>
                                            <td>Harga</td>
                                            <td>:</td>
                                            <td>
                                                @if ($data->field_type == 'Futsal')
                                                    Rp. {{ number_format($data->morning_price, 0, ',', '.') }} - Rp.
                                                    {{ number_format($data->night_price, 0, ',', '.') }}
                                                @else
                                                    Rp. {{ number_format($data->night_price, 0, ',', '.') }}
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="py-3">
                                        <a style="position: absolute;
                                        bottom: 15px;left: 50%;
                                        transform: translateX(-50%);" href="{{ route('user.bookingCreate', $data->id) }}" class="btn-solid-small">Book
                                            Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="col-md-12 mb-4">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mb-0">
                            {{ $fieldDatas->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    <!-- Blog End -->
@endsection

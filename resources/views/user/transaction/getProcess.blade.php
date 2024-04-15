@extends('user.layouts.main')

@section('content')
    <section class="py-3" style="background-color: #eee;">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12 col-lg-10 col-xl-8">
                    <div class="card">
                        <div class="card-body p-md-5">
                            @if($transaction->payment_method_dp == 1)
                            <div>
                                <h4>Mohon datang ke GOR untuk melakukan pembayaran, maksimal 1 jam setelah pemesanan.</h4>
                            </div>
                            @else
                            <div>
                                <h4>Mohon ditunggu, pembayaran Anda sedang diproses.</h4>
                            </div>

                            @endif
                            <div class="mt-3">
                                <a href="{{ route('user.index') }}">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

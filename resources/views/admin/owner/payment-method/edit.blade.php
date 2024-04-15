@extends('admin.layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Metode Pembayaran</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form class="form-card p-4" action="{{ route('owner.paymentMethodUpdate', $paymentMethod->id) }}"
                    method="POST">
                    @method('PUT')
                    @csrf
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex">
                            <label class="form-control-label">Nama Bank<span class="text-danger"> *</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ $paymentMethod->name }}"
                                placeholder="Masukkan Nama Bank">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex">
                            <label class="form-control-label">Nomor Rekening<span class="text-danger"> *</span>
                            </label>
                            <input type="number" id="account_number" name="account_number"
                                value="{{ $paymentMethod->account_number }}" placeholder="Masukkan Nomor Rekening"
                                min="0">
                            @error('account_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-12 flex-column d-flex">
                            <label class="form-control-label">Nama Rekening<span class="text-danger"> *</span>
                            </label>
                            <input type="text" id="account_name" name="account_name"
                                value="{{ $paymentMethod->account_name }}" placeholder="Masukkan Nama Rekening">
                            @error('account_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-end py-4 px-4">
                        <div class="form-group col-sm-2">
                            <button type="submit" class="btn-block btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@extends('user.layouts.main')

@section('content')
    <section class="py-3" style="background-color: #eee;">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12 col-lg-10 col-xl-8">
                    <div class="card">
                        <form class="form-card p-4" action="{{ route('user.paymentTransactionStore', $transaction->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="card-body p-md-5">
                                <div>
                                    <h4>Invoice | {{ $transaction->id }}</h4>
                                </div>
                                <div
                                    class="px-3 py-4 border border-primary border-2 rounded mt-4 d-flex justify-content-between">
                                    <div class="d-flex flex-row align-items-center">
                                        <img src="{{ asset('storage/' . $transaction->booking->first()->fieldData->thumbnail) }}"
                                            class="rounded" width="60" />
                                        <div class="d-flex flex-column ms-4">
                                            <span class="h5 mb-1">{{ $transaction->booking->fieldData->name }}</span>
                                            <span
                                                class="small text-muted">{{ $transaction->booking->fieldData->field_type }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center">
                                        <sup class="dollar font-weight-bold text-muted">Rp.</sup><span
                                            class="h2 mx-1 mb-0">{{ number_format($transaction->down_payment, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <hr style="border-top: 2px solid #000;">
                                <p>Harap lakukan pembayaran sesuai nominal yang tertera di atas ke rekening berikut ini</p>
                                <div class="mt-2 d-flex justify-content-center align-items-center">
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="d-flex flex-column ms-3">
                                            <h1 id="accountNumber">{{ $transaction->paymentMethodDP->account_number }}</h1>
                                            <div class="text-center">
                                                <span
                                                    class="large text-muted">{{ $transaction->paymentMethodDP->account_name }}
                                                    -
                                                    {{ $transaction->paymentMethodDP->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-lg btn-primary ms-3" data-bs-container="body"
                                        data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Copied"
                                        onclick="copyToClipboard()">Copy</button>
                                </div>
                                <hr style="border-top: 2px solid #000;">
                                <div id="paymentProof" class="form-group col-12">
                                    <label for="payment_proof" class="form-control-label">Bukti Pembayaran<span
                                            class="text-danger">
                                            *</span></label>
                                    <input class="form-control" type="file" name="payment_proof" id="payment_proof"
                                        onchange="previewPaymentProof(this)">
                                    @error('payment_proof')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="mt-3">
                                        <img class="pb-3" id="payment-proof-preview"style="width: 100px;">
                                    </div>
                                </div>

                                <div id="accountName" class="form-group col-12">
                                    <label for="account_name" class="form-control-label">Masukkan Nama Rekening
                                        Pengirim<span class="text-danger"> *</span>
                                    </label>
                                    <input type="text" id="account_name" name="account_name" class="form-control">
                                    <!-- Pesan kesalahan jika terjadi kesalahan validasi -->
                                    @error('account_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary btn-block btn-lg">
                                        Proceed to payment <i class="fas fa-long-arrow-alt-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        function copyToClipboard() {
            var accountNumber = document.getElementById("accountNumber");
            var range = document.createRange();
            range.selectNode(accountNumber);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
            document.execCommand("copy");
            window.getSelection().removeAllRanges();

            // Menampilkan popover
            var popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            var popoverList = [].slice.call(popoverTriggerList);

            popoverList.forEach(function(popoverTriggerEl) {
                var popover = new bootstrap.Popover(popoverTriggerEl);
                popover.show();

                // Menutup popover setelah 5 detik
                setTimeout(function() {
                    popover.hide();
                }, 2000); // 5000 milidetik = 5 detik
            });
        }
    </script>
    <script>
        // Function to preview the selected image
        function previewPaymentProof(input) {
            var preview = document.getElementById('payment-proof-preview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection

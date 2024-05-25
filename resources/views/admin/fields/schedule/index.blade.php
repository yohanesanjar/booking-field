@extends('admin.layouts.main')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Jadwal Lapangan</h1>
    </div>
    @if (session('success'))
        <div class="alert alert-success d-flex justify-content-between align-items-center">
            {{ session('success') }}
            <button type="button" class="btn-close flex-end" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- Content Row -->
    <div class="row">

        <!-- Area Chart -->
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">Jam</th>
                        <th class="text-center" scope="col">Aktif</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fieldSchedule as $schedule)
                        <tr>
                            <td class="text-center">{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.scheduleUpdate', $schedule->id) }}" method="POST"
                                    class="schedule-form">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-check">
                                        <input class="form-check-input schedule-checkbox" type="checkbox" name="is_active"
                                            id="is_active" {{ $schedule->is_active == 1 ? 'checked' : '' }}>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endsection

    @section('script')
    <script>
        $(document).ready(function () {
            $('.schedule-checkbox').change(function () {
                console.log('Checkbox changed!');
                $(this).closest('form').submit();
            });
        });
    </script>
    @endsection

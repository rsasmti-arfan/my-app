@extends('dashboard.app')
@section('title', 'Devices')

@section('button_nav')

    || Data Devices || &nbsp;&nbsp;
    <button type="button" id="addBtn" class=" btn btn-light btn-outline-primary"><i class="bi bi-plus-circle"></i>&nbsp;Add
        New</button>
    &nbsp;

    Toggle column: <a class="toggle-vis" data-column="1">Id</a>
    <!-- -- <a class="toggle-vis" data-column="5">Password</a> -->

@endsection

@section('content')
    <div class="container mt-3 mb-5">
        <div class="col-md-12">
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="card card-body">

                        @include('partials.flash')

                        <form action="{{ route('devices.update', ['device' => $device]) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="hp" class="form-label fw-bold">HP</label>
                                <input type="text" name="phone" class="form-control" id="hp"
                                    placeholder="628....." value="{{ old('phone', $device->phone) }}">
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="bi bi-plus-circle"></i>&nbsp;Save</button>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-header py-3">
                            <span class="fw-bold">Whatsapp Session</span>
                        </div>
                        <div class="card-body">
                            <div class="text-center">

                                <div class="spinner-border" role="status" id="loader">
                                    <span class="visually-hidden">Loading...</span>
                                </div>

                                <div id="qrcode-wrapper" class="text-center">
                                    {{-- <img src="{{ asset('images/qr.png') }}" alt="qrcode" class="img-thumbnail"> --}}
                                </div>

                                <div class="text-center mb-3">
                                    <strong class="text-primary" id="log-message">Whatsapp Session.</strong>
                                </div>

                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    <button type="button" class="btn btn-outline-primary"
                                        @if (empty($device->phone)) disabled @endif id="btn--scan">Scan</button>
                                    <button type="button" class="btn btn-outline-info"
                                        @if (empty($device->phone)) disabled @endif
                                        id="btn--cek-session">Check</button>
                                    <button type="button" class="btn btn-outline-danger"
                                        @if (empty($device->phone)) disabled @endif
                                        id="btn--delete-session">Destroy</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function() {

            $('#loader').hide();
            let sessionId = "{{ $device->phone }}";

            /** Btn scan wa */
            $('#btn--scan').click(function() {
                $.ajax({
                    url: "{{ env('NODE_WA_URL') }}/sessions/add",
                    type: "POST",
                    data: {
                        id: sessionId,
                        isLegacy: false
                    },
                    beforeSend: function() {
                        $('#btn--scan').attr('disabled', 'disabled');
                        $('#loader').show();
                        $('#timer').html('');
                    },
                    success: function(response) {
                        $('#loader').hide();
                        let qrcode = response.data.qr
                        $('#log-message').text(response.message)
                        $('#qrcode-wrapper').html(`<img src="${qrcode}" alt="qrcode">`)
                    },
                    error: function(error) {
                        let message = error.responseJSON.message
                        $('#log-message').text(message)
                        $('#loader').hide();
                    },
                    complete: function() {
                        $('#btn--scan').attr('disabled', false);
                        $('#loader').hide();
                    }
                });
            })

            /** Btn cek session */
            $('#btn--cek-session').click(function() {
                $.ajax({
                    url: `{{ env('NODE_WA_URL') }}/sessions/status/${sessionId}`,
                    type: "GET",
                    beforeSend: function() {
                        $('#btn--cek-session').attr('disabled', 'disabled');
                        $('#loader').show();
                    },
                    success: function(response) {
                        console.log(response)
                        let status = response.data.status
                        $('#loader').hide();
                        $('#log-message').text(status)
                        $('#qrcode-wrapper').html('')
                    },
                    error: function(error) {
                        let message = error.responseJSON.message
                        $('#log-message').text(message)
                    },
                    complete: function() {
                        $('#btn--cek-session').attr('disabled', false);
                        $('#loader').hide();
                    }
                });
            })

            /** Btn delete session */
            $('#btn--delete-session').click(function() {
                $.ajax({
                    url: `{{ env('NODE_WA_URL') }}/sessions/delete/${sessionId}`,
                    type: "DELETE",
                    beforeSend: function() {
                        $('#btn--delete-session').attr('disabled', 'disabled');
                        $('#loader').show();
                    },
                    success: function(response) {
                        console.log(response)
                        $('#loader').hide();
                        $('#log-message').text(response.message)
                        $('#qrcode-wrapper').html('')
                    },
                    error: function(error) {
                        let message = error.responseJSON.message
                        $('#log-message').text(message)
                    },
                    complete: function() {
                        $('#btn--delete-session').attr('disabled', false);
                        $('#loader').hide();
                    }
                });
            })

        })
    </script>
@endpush

@extends('layouts.app')

@section('content')
    <div class="container api-key">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Api Key</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                         <div class="row">
                             <label for="api-key">Api Key:</label>
                         </div>

                         <div class="row">
                             <textarea id="api-key" rows="5" cols="60" id="api-key" name="api-key">{{ $apiKey }}</textarea>

                         </div>

                         <div class="row mt-3">
                             <form method="post" id="generate-api-key-form" action="{{ route('generate-api-key') }}">
                                 @csrf
                                 <div class="form-group">
                                     <button class="btn btn-danger" id="generate-btn" type="submit">{{ isset($apiKey) ? 'Regenerate': 'Generate' }}</button>
                                 </div>
                             </form>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#generate-api-key-form').submit(function() {
                $.ajax({
                    url: '/generate-api-key',
                    type: 'post',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json'
                    // success: function (data) {
                    //     console.info(data);
                    // }
                }).done(function(data) {
                    console.log(data);
                    $('#api-key').val(data['apiKey']);
                });

                return false;
            });
        });
    </script>

@endsection
@extends('layouts.app')

@section('content')
{{--Select2 CDN link--}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
{{--Select Chosen CDN link--}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.js"></script>
{{--Bootstrap CDN link--}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('visitors') }}">
                        @csrf

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                                <div class="col-md-6">
                                    <input id="address" type="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address') }}" required>

                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Age') }}</label>

                                <div class="col-md-6">
                                    <input id="age" type="text" class="form-control{{ $errors->has('age') ? ' is-invalid' : '' }}" name="age" value="{{ old('age') }}" required autofocus>

                                    @if ($errors->has('age'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('age') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Division</th>
                                    <th>Place</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Durations</th>
                                    <th>Add/Remove</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <select type="text" class="chosen-select form-control{{ $errors->has('division_id') ? ' is-invalid' : '' }}" name="division_id[]"  required >
                                            <option value="">Select One</option>
                                            <option value="1">Dhaka</option>
                                            <option value="2">Barisal</option>
                                            <option value="3">Khulna</option>
                                            <option value="4">Rajshahi</option>
                                            <option value="5">Rongpur</option>
                                            <option value="6">Chattagram</option>
                                            <option value="7">Maymenshing</option>
                                            <option value="8">Sylhet</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control{{ $errors->has('place') ? ' is-invalid' : '' }}" name="place[]" value="{{ old('place') }}" required autofocus>
                                    </td>
                                    <td>
                                        <input type="text" class="date-picker form-control{{ $errors->has('from_date') ? ' is-invalid' : '' }}" name="from_date[]" required autofocus>
                                    </td>
                                    <td>
                                        <input type="text" class="date-picker form-control{{ $errors->has('to_date') ? ' is-invalid' : '' }}" name="to_date[]" required autofocus>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control{{ $errors->has('durations') ? ' is-invalid' : '' }}" name="durations[]" value="{{ old('durations') }}" required autofocus>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm addMore"><i class='fas fa-plus-circle' style='font-size:18px'></i></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary float-center">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        $(document).on('click', '.addMore', function () {
           var thisRow = $(this).closest('tr');
            $("select.chosen-select").chosen('destroy');
           var nextRow = '<tr>'+thisRow.html()+'</tr>';
           thisRow.find('button').addClass('remove btn-danger').removeClass('addMore btn-primary').html('<i class="fas fa-trash" style="font-size:18px"></i>');
           $('tbody').append(nextRow);
            $('.chosen-select').chosen(0);
            $('.chosen-single').css({'height':'33px','line-height':'33px'});
            $('.date-picker').datepicker({format: 'dd-mm-yyyy'}).datepicker("setDate", new Date());

        });

        $(document).on('click', '.remove', function () {
           $(this).closest('tr').remove();
        });
    </script>

{{--Select2 Js--}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Select One',
        });
    });
</script>
{{--Select Chosen--}}
<script>
    $(document).ready(function() {
        $(".chosen-select").chosen(0);
        $('.chosen-single').css({'height':'33px','line-height':'33px'});
    });
</script>

{{--Select Chosen--}}
<script>
    $(document).ready(function() {
        $('.date-picker').datepicker({
            format: 'dd-mm-yyyy',
        });
    });
</script>


@endsection

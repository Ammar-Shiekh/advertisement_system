@extends('layouts.app')

@section('title')
    Create Advertisement
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create advertisement') }}</div>

                    <div class="card-body">
                        {!! Form::open(['method'=>'POST', 'action'=>'AdvertisementsController@store', 'files'=>true]) !!}
                        @foreach($devices as $device)
                            <div class="form-group">
                                {!! Form::checkbox('devices[]', $device['id'], false) !!}
                                {!! Form::label('devices[]', $device['name']) !!}
                                {!! Form::label('durations[]', 'Duration') !!}
                                {!! Form::number('durations[]', '5', ['min' => '1', 'max' => '15', 'disabled' => 'disabled']) !!}
                            </div>
                        @endforeach
                        <div class="form-group">
                            {!! Form::label('photo', 'Photo') !!}
                            {!! Form::file('photo', ['accept' => '.jpg', 'class'=>'form-control-file']) !!}
                            @include('includes.validations-for', ['field'=>'photo'])
                        </div>
                        <div class='form-group'>
                            {!! Form::submit('Create Advertisement', ['class'=>'btn btn-primary']) !!}
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(() => {
            $('input[type="checkbox"]').change(function() {
                $($(this).closest('.form-group').find('input[type="number"]')[0]).attr("disabled", !this.checked);
            });
        });
    </script>
@endsection

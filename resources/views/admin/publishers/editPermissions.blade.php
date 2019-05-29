@extends('layouts.app')

@section('title')
    Update {{$publisher->name}} permissions
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Update '.$publisher->name.' permissions') }}</div>
                    <div class="card-body">
                        {!! Form::open([
                            'method'=>'POST',
                            'action'=>[
                                'PublishersManagementController@updatePermissions',
                                $publisher->id
                            ]
                        ]) !!}
                        <ul class="list-group list-group-flush">
                            <li id="update-devices" class="list-group-item">
                                <h6>Update current devices</h6>
                                <p class="card-text">
                                    <small class="text-muted">Check the device if you want to remove it</small>
                                </p>
                                @foreach($publisher_devices as $publisher_device)
                                    <div class="form-group">
                                        {!! Form::checkbox('remove_devices[]', $publisher_device->pivot['id'], false) !!}
                                        {!! Form::label('remove_devices[]', $publisher_device['name']) !!}
                                        <span class="text-danger removed" style="display: none">Removed</span>
                                    </div>
                                @endforeach
                            </li>
                            <li id="new_devices" class="list-group-item">
                                <h6>Add new devices</h6>
                                @foreach($other_devices as $other_device)
                                    <div class="form-group">
                                        {!! Form::checkbox('new_devices[]', $other_device['id'], false) !!}
                                        {!! Form::label('new_devices[]', $other_device['name']) !!}
                                        <span class="text-info added" style="display: none">Added</span>
                                    </div>
                                @endforeach
                            </li>
                        </ul>
                        <div class='form-group'>
                            {!! Form::submit('Update Permissions', ['class'=>'btn btn-primary']) !!}
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
            $('#update-devices input[type="checkbox"]').change(function() {
                const formGroup = $(this).closest('.form-group');
                $(formGroup.find('input[type="number"]')[0]).attr("disabled", this.checked);
                $(formGroup.find('span.removed')[0]).css('display', this.checked ? 'inline' : 'none');
            });
            $('#new_devices input[type="checkbox"]').change(function() {
                const formGroup = $(this).closest('.form-group');
                $(formGroup.find('input[type="number"]')[0]).attr("disabled", !this.checked);
                $(formGroup.find('span.added')[0]).css('display', this.checked ? 'inline' : 'none');
            });
        });
    </script>
@endsection

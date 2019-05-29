@extends('layouts.app')

@section('title')
    Update advertisement
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Update advertisement') }}</div>
                    <img src="{{\App\Helpers\PhotosHelper::getPhotoPath('advertisement', $advertisement->id)}}"
                         class="card-img-top">
                    <div class="card-body">
                        {!! Form::open(['method'=>'PUT', 'action'=>['AdvertisementsController@update', $advertisement->id]]) !!}
                        <ul class="list-group list-group-flush">
                            <li id="update-devices" class="list-group-item">
                                <h6>Update current devices</h6>
                                <p class="card-text">
                                    <small class="text-muted">Check the device if you want to remove the ad from it</small>
                                </p>
                                @foreach($advertisement_devices as $advertisement_device)
                                    <div class="form-group">
                                        {!! Form::checkbox('remove_devices[]', $advertisement_device['id'], false) !!}
                                        {!! Form::label('remove_devices[]', $advertisement_device['name']) !!}
                                        {!! Form::label('update_durations[]', 'Duration') !!}
                                        {!! Form::number('update_durations[]', $advertisement_device->pivot['duration'],
                                            ['min' => '1', 'max' => '15']) !!}
                                        {!! Form::hidden('update_devices[]', $advertisement_device['id']) !!}
                                        <span class="text-danger removed" style="display: none">Removed</span>
                                    </div>
                                @endforeach
                            </li>
                            <li id="new_devices" class="list-group-item">
                                <h6>Add to new devices</h6>
                                @foreach($other_devices as $other_device)
                                    <div class="form-group">
                                        {!! Form::checkbox('new_devices[]', $other_device['id'], false) !!}
                                        {!! Form::label('new_devices[]', $other_device['name']) !!}
                                        {!! Form::label('new_durations[]', 'Duration') !!}
                                        {!! Form::number('new_durations[]', '5',
                                            ['min' => '1', 'max' => '15', 'disabled' => 'disabled']) !!}
                                        <span class="text-info added" style="display: none">Added</span>
                                    </div>
                                @endforeach
                            </li>
                        </ul>
                        <div class='form-group'>
                            {!! Form::submit('Update Advertisement', ['class'=>'btn btn-primary']) !!}
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
                $(formGroup.find('input[type="hidden"]')[0]).attr("disabled", this.checked);
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

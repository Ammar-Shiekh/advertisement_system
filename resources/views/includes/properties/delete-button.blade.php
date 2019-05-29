{!! Form::open(['method'=>'DELETE', 'action'=>[$content['action'], $content['id']]]) !!}
<div class='form-group'>
    {!! Form::submit('Delete', ['class'=>'btn btn-danger']) !!}
</div>
{!! Form::close() !!}
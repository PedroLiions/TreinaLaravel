@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            {{ Form::open(array('url' => 'foo/bar')) }}
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
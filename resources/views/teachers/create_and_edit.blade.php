@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Teacher /
                    @if($teacher->id)
                        Edit #{{$teacher->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($teacher->id)
                    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('teachers.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                	<label for="name-field">Name</label>
                	<input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $teacher->name ) }}" />
                </div> 
                <div class="form-group">
                	<label for="password-field">Password</label>
                	<input class="form-control" type="text" name="password" id="password-field" value="{{ old('password', $teacher->password ) }}" />
                </div> 
                <div class="form-group">
                	<label for="desc-field">Desc</label>
                	<textarea name="desc" id="desc-field" class="form-control" rows="3">{{ old('desc', $teacher->desc ) }}</textarea>
                </div> 
                <div class="form-group">
                	<label for="video_url-field">Video_url</label>
                	<textarea name="video_url" id="video_url-field" class="form-control" rows="3">{{ old('video_url', $teacher->video_url ) }}</textarea>
                </div> 
                <div class="form-group">
                    <label for="imgs-field">Imgs</label>
                    <input class="form-control" type="text" name="imgs" id="imgs-field" value="{{ old('imgs', $teacher->imgs ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('teachers.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Course /
                    @if($course->id)
                        Edit #{{$course->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($course->id)
                    <form action="{{ route('courses.update', $course->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('courses.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $course->title ) }}" />
                </div> 
                <div class="form-group">
                	<label for="banner-field">Banner</label>
                	<textarea name="banner" id="banner-field" class="form-control" rows="3">{{ old('banner', $course->banner ) }}</textarea>
                </div> 
                <div class="form-group">
                    <label for="ori_price-field">Ori_price</label>
                    <input class="form-control" type="text" name="ori_price" id="ori_price-field" value="{{ old('ori_price', $course->ori_price ) }}" />
                </div> 
                <div class="form-group">
                    <label for="now_price-field">Now_price</label>
                    <input class="form-control" type="text" name="now_price" id="now_price-field" value="{{ old('now_price', $course->now_price ) }}" />
                </div> 
                <div class="form-group">
                	<label for="body-field">Body</label>
                	<textarea name="body" id="body-field" class="form-control" rows="3">{{ old('body', $course->body ) }}</textarea>
                </div> 
                <div class="form-group">
                    <label for="view_count-field">View_count</label>
                    <input class="form-control" type="text" name="view_count" id="view_count-field" value="{{ old('view_count', $course->view_count ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('courses.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
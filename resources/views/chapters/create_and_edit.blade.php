@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Chapter /
                    @if($chapter->id)
                        Edit #{{$chapter->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($chapter->id)
                    <form action="{{ route('chapters.update', $chapter->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('chapters.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $chapter->title ) }}" />
                </div> 
                <div class="form-group">
                    <label for="price-field">Price</label>
                    <input class="form-control" type="text" name="price" id="price-field" value="{{ old('price', $chapter->price ) }}" />
                </div> 
                <div class="form-group">
                	<label for="media_type-field">Media_type</label>
                	<input class="form-control" type="text" name="media_type" id="media_type-field" value="{{ old('media_type', $chapter->media_type ) }}" />
                </div> 
                <div class="form-group">
                	<label for="media_url-field">Media_url</label>
                	<textarea name="media_url" id="media_url-field" class="form-control" rows="3">{{ old('media_url', $chapter->media_url ) }}</textarea>
                </div> 
                <div class="form-group">
                    <label for="couse_id-field">Couse_id</label>
                    <input class="form-control" type="text" name="couse_id" id="couse_id-field" value="{{ old('couse_id', $chapter->couse_id ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('chapters.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
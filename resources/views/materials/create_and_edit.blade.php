@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Material /
                    @if($material->id)
                        Edit #{{$material->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($material->id)
                    <form action="{{ route('materials.update', $material->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('materials.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $material->title ) }}" />
                </div> 
                <div class="form-group">
                	<label for="body-field">Body</label>
                	<textarea name="body" id="body-field" class="form-control" rows="3">{{ old('body', $material->body ) }}</textarea>
                </div> 
                <div class="form-group">
                	<label for="thumbnail-field">Thumbnail</label>
                	<textarea name="thumbnail" id="thumbnail-field" class="form-control" rows="3">{{ old('thumbnail', $material->thumbnail ) }}</textarea>
                </div> 
                <div class="form-group">
                	<label for="media_type-field">Media_type</label>
                	<input class="form-control" type="text" name="media_type" id="media_type-field" value="{{ old('media_type', $material->media_type ) }}" />
                </div> 
                <div class="form-group">
                	<label for="media_url-field">Media_url</label>
                	<textarea name="media_url" id="media_url-field" class="form-control" rows="3">{{ old('media_url', $material->media_url ) }}</textarea>
                </div> 
                <div class="form-group">
                    <label for="category_id-field">Category_id</label>
                    <input class="form-control" type="text" name="category_id" id="category_id-field" value="{{ old('category_id', $material->category_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="view_count-field">View_count</label>
                    <input class="form-control" type="text" name="view_count" id="view_count-field" value="{{ old('view_count', $material->view_count ) }}" />
                </div> 
                <div class="form-group">
                    <label for="zan_count-field">Zan_count</label>
                    <input class="form-control" type="text" name="zan_count" id="zan_count-field" value="{{ old('zan_count', $material->zan_count ) }}" />
                </div> 
                <div class="form-group">
                    <label for="order-field">Order</label>
                    <input class="form-control" type="text" name="order" id="order-field" value="{{ old('order', $material->order ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('materials.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
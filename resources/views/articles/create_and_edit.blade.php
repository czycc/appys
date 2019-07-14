@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Article /
                    @if($article->id)
                        Edit #{{$article->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($article->id)
                    <form action="{{ route('articles.update', $article->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('articles.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $article->title ) }}" />
                </div> 
                <div class="form-group">
                	<label for="top_img-field">Top_img</label>
                	<textarea name="top_img" id="top_img-field" class="form-control" rows="3">{{ old('top_img', $article->top_img ) }}</textarea>
                </div> 
                <div class="form-group">
                	<label for="body-field">Body</label>
                	<textarea name="body" id="body-field" class="form-control" rows="3">{{ old('body', $article->body ) }}</textarea>
                </div> 
                <div class="form-group">
                	<label for="type-field">Type</label>
                	<input class="form-control" type="text" name="type" id="type-field" value="{{ old('type', $article->type ) }}" />
                </div> 
                <div class="form-group">
                	<label for="media_url-field">Media_url</label>
                	<textarea name="media_url" id="media_url-field" class="form-control" rows="3">{{ old('media_url', $article->media_url ) }}</textarea>
                </div> 
                <div class="form-group">
                    <label for="multi_imgs-field">Multi_imgs</label>
                    <input class="form-control" type="text" name="multi_imgs" id="multi_imgs-field" value="{{ old('multi_imgs', $article->multi_imgs ) }}" />
                </div> 
                <div class="form-group">
                    <label for="price-field">Price</label>
                    <input class="form-control" type="text" name="price" id="price-field" value="{{ old('price', $article->price ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('articles.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
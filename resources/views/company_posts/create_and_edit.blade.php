@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> CompanyPost /
                    @if($company_post->id)
                        Edit #{{$company_post->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($company_post->id)
                    <form action="{{ route('company_posts.update', $company_post->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('company_posts.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                	<label for="title-field">Title</label>
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $company_post->title ) }}" />
                </div> 
                <div class="form-group">
                	<label for="body-field">Body</label>
                	<textarea name="body" id="body-field" class="form-control" rows="3">{{ old('body', $company_post->body ) }}</textarea>
                </div> 
                <div class="form-group">
                	<label for="thumbnail-field">Thumbnail</label>
                	<textarea name="thumbnail" id="thumbnail-field" class="form-control" rows="3">{{ old('thumbnail', $company_post->thumbnail ) }}</textarea>
                </div> 
                <div class="form-group">
                	<label for="media_type-field">Media_type</label>
                	<input class="form-control" type="text" name="media_type" id="media_type-field" value="{{ old('media_type', $company_post->media_type ) }}" />
                </div> 
                <div class="form-group">
                	<label for="media_url-field">Media_url</label>
                	<textarea name="media_url" id="media_url-field" class="form-control" rows="3">{{ old('media_url', $company_post->media_url ) }}</textarea>
                </div> 
                <div class="form-group">
                    <label for="category_id-field">Category_id</label>
                    <input class="form-control" type="text" name="category_id" id="category_id-field" value="{{ old('category_id', $company_post->category_id ) }}" />
                </div> 
                <div class="form-group">
                    <label for="view_count-field">View_count</label>
                    <input class="form-control" type="text" name="view_count" id="view_count-field" value="{{ old('view_count', $company_post->view_count ) }}" />
                </div> 
                <div class="form-group">
                    <label for="zan_count-field">Zan_count</label>
                    <input class="form-control" type="text" name="zan_count" id="zan_count-field" value="{{ old('zan_count', $company_post->zan_count ) }}" />
                </div> 
                <div class="form-group">
                    <label for="weight-field">Weight</label>
                    <input class="form-control" type="text" name="weight" id="weight-field" value="{{ old('weight', $company_post->weight ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('company_posts.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
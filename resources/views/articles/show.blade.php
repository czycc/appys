@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Article / Show #{{ $article->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('articles.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('articles.edit', $article->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Title</label>
<p>
	{{ $article->title }}
</p> <label>Top_img</label>
<p>
	{{ $article->top_img }}
</p> <label>Body</label>
<p>
	{{ $article->body }}
</p> <label>Type</label>
<p>
	{{ $article->type }}
</p> <label>Media_url</label>
<p>
	{{ $article->media_url }}
</p> <label>Multi_imgs</label>
<p>
	{{ $article->multi_imgs }}
</p> <label>Price</label>
<p>
	{{ $article->price }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Comment / Show #{{ $comment->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('comments.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('comments.edit', $comment->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Article_id</label>
<p>
	{{ $comment->article_id }}
</p> <label>User_id</label>
<p>
	{{ $comment->user_id }}
</p> <label>Comment_id</label>
<p>
	{{ $comment->comment_id }}
</p> <label>Content</label>
<p>
	{{ $comment->content }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

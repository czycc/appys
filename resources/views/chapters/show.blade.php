@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Chapter / Show #{{ $chapter->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('chapters.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('chapters.edit', $chapter->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Title</label>
<p>
	{{ $chapter->title }}
</p> <label>Price</label>
<p>
	{{ $chapter->price }}
</p> <label>Media_type</label>
<p>
	{{ $chapter->media_type }}
</p> <label>Media_url</label>
<p>
	{{ $chapter->media_url }}
</p> <label>Couse_id</label>
<p>
	{{ $chapter->couse_id }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

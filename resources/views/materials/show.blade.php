@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Material / Show #{{ $material->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('materials.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('materials.edit', $material->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Title</label>
<p>
	{{ $material->title }}
</p> <label>Body</label>
<p>
	{{ $material->body }}
</p> <label>Thumbnail</label>
<p>
	{{ $material->thumbnail }}
</p> <label>Media_type</label>
<p>
	{{ $material->media_type }}
</p> <label>Media_url</label>
<p>
	{{ $material->media_url }}
</p> <label>Category_id</label>
<p>
	{{ $material->category_id }}
</p> <label>View_count</label>
<p>
	{{ $material->view_count }}
</p> <label>Zan_count</label>
<p>
	{{ $material->zan_count }}
</p> <label>Order</label>
<p>
	{{ $material->order }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>CompanyPost / Show #{{ $company_post->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('company_posts.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('company_posts.edit', $company_post->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Title</label>
<p>
	{{ $company_post->title }}
</p> <label>Body</label>
<p>
	{{ $company_post->body }}
</p> <label>Thumbnail</label>
<p>
	{{ $company_post->thumbnail }}
</p> <label>Media_type</label>
<p>
	{{ $company_post->media_type }}
</p> <label>Media_url</label>
<p>
	{{ $company_post->media_url }}
</p> <label>Category_id</label>
<p>
	{{ $company_post->category_id }}
</p> <label>View_count</label>
<p>
	{{ $company_post->view_count }}
</p> <label>Zan_count</label>
<p>
	{{ $company_post->zan_count }}
</p> <label>Weight</label>
<p>
	{{ $company_post->weight }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

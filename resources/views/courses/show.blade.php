@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Course / Show #{{ $course->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('courses.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('courses.edit', $course->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Title</label>
<p>
	{{ $course->title }}
</p> <label>Banner</label>
<p>
	{{ $course->banner }}
</p> <label>Ori_price</label>
<p>
	{{ $course->ori_price }}
</p> <label>Now_price</label>
<p>
	{{ $course->now_price }}
</p> <label>Body</label>
<p>
	{{ $course->body }}
</p> <label>View_count</label>
<p>
	{{ $course->view_count }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

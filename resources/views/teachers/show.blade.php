@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Teacher / Show #{{ $teacher->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('teachers.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('teachers.edit', $teacher->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Name</label>
<p>
	{{ $teacher->name }}
</p> <label>Password</label>
<p>
	{{ $teacher->password }}
</p> <label>Desc</label>
<p>
	{{ $teacher->desc }}
</p> <label>Video_url</label>
<p>
	{{ $teacher->video_url }}
</p> <label>Imgs</label>
<p>
	{{ $teacher->imgs }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

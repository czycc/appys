@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <i class="glyphicon glyphicon-align-justify"></i> Course
                        <a class="btn btn-success pull-right" href="{{ route('courses.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
                    </h1>
                </div>

                <div class="panel-body">
                    @if($courses->count())
                        <table class="table table-condensed table-striped">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Title</th> <th>Banner</th> <th>Ori_price</th> <th>Now_price</th> <th>Body</th> <th>View_count</th>
                                <th class="text-right">OPTIONS</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td class="text-center"><strong>{{$course->id}}</strong></td>

                                    <td>{{$course->title}}</td> <td>{{$course->banner}}</td> <td>{{$course->ori_price}}</td> <td>{{$course->now_price}}</td> <td>{{$course->body}}</td> <td>{{$course->view_count}}</td>

                                    <td class="text-right">
                                        <a class="btn btn-xs btn-primary" href="{{ route('courses.show', $course->id) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>

                                        <a class="btn btn-xs btn-warning" href="{{ route('courses.edit', $course->id) }}">
                                            <i class="glyphicon glyphicon-edit"></i>
                                        </a>

                                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                            {{csrf_field()}}
                                            <input type="hidden" name="_method" value="DELETE">

                                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $courses->render() !!}
                    @else
                        <h3 class="text-center alert alert-info">Empty!</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
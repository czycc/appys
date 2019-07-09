@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-align-justify"></i> Material
                    <a class="btn btn-success pull-right" href="{{ route('materials.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
                </h1>
            </div>

            <div class="panel-body">
                @if($materials->count())
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Title</th> <th>Body</th> <th>Thumbnail</th> <th>Media_type</th> <th>Media_url</th> <th>Category_id</th> <th>View_count</th> <th>Zan_count</th> <th>Order</th>
                                <th class="text-right">OPTIONS</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($materials as $material)
                                <tr>
                                    <td class="text-center"><strong>{{$material->id}}</strong></td>

                                    <td>{{$material->title}}</td> <td>{{$material->body}}</td> <td>{{$material->thumbnail}}</td> <td>{{$material->media_type}}</td> <td>{{$material->media_url}}</td> <td>{{$material->category_id}}</td> <td>{{$material->view_count}}</td> <td>{{$material->zan_count}}</td> <td>{{$material->order}}</td>
                                    
                                    <td class="text-right">
                                        <a class="btn btn-xs btn-primary" href="{{ route('materials.show', $material->id) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i> 
                                        </a>
                                        
                                        <a class="btn btn-xs btn-warning" href="{{ route('materials.edit', $material->id) }}">
                                            <i class="glyphicon glyphicon-edit"></i> 
                                        </a>

                                        <form action="{{ route('materials.destroy', $material->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                            {{csrf_field()}}
                                            <input type="hidden" name="_method" value="DELETE">

                                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $materials->render() !!}
                @else
                    <h3 class="text-center alert alert-info">Empty!</h3>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-align-justify"></i> CompanyPost
                    <a class="btn btn-success pull-right" href="{{ route('company_posts.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
                </h1>
            </div>

            <div class="panel-body">
                @if($company_posts->count())
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Title</th> <th>Body</th> <th>Thumbnail</th> <th>Media_type</th> <th>Media_url</th> <th>Category_id</th> <th>View_count</th> <th>Zan_count</th> <th>Weight</th>
                                <th class="text-right">OPTIONS</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($company_posts as $company_post)
                                <tr>
                                    <td class="text-center"><strong>{{$company_post->id}}</strong></td>

                                    <td>{{$company_post->title}}</td> <td>{{$company_post->body}}</td> <td>{{$company_post->thumbnail}}</td> <td>{{$company_post->media_type}}</td> <td>{{$company_post->media_url}}</td> <td>{{$company_post->category_id}}</td> <td>{{$company_post->view_count}}</td> <td>{{$company_post->zan_count}}</td> <td>{{$company_post->weight}}</td>
                                    
                                    <td class="text-right">
                                        <a class="btn btn-xs btn-primary" href="{{ route('company_posts.show', $company_post->id) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i> 
                                        </a>
                                        
                                        <a class="btn btn-xs btn-warning" href="{{ route('company_posts.edit', $company_post->id) }}">
                                            <i class="glyphicon glyphicon-edit"></i> 
                                        </a>

                                        <form action="{{ route('company_posts.destroy', $company_post->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                            {{csrf_field()}}
                                            <input type="hidden" name="_method" value="DELETE">

                                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $company_posts->render() !!}
                @else
                    <h3 class="text-center alert alert-info">Empty!</h3>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-align-justify"></i> Shop
                    <a class="btn btn-success pull-right" href="{{ route('shops.create') }}"><i class="glyphicon glyphicon-plus"></i> Create</a>
                </h1>
            </div>

            <div class="panel-body">
                @if($shops->count())
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Shop_phone</th> <th>Real_name</th> <th>Banner</th> <th>Idcard</th> <th>License</th> <th>Shop_imgs</th> <th>Longitude</th> <th>Latitude</th> <th>Status</th> <th>Province</th> <th>City</th> <th>District</th> <th>Address</th> <th>Wechat_qrcode</th> <th>User_id</th>
                                <th class="text-right">OPTIONS</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($shops as $shop)
                                <tr>
                                    <td class="text-center"><strong>{{$shop->id}}</strong></td>

                                    <td>{{$shop->shop_phone}}</td> <td>{{$shop->real_name}}</td> <td>{{$shop->banner}}</td> <td>{{$shop->idcard}}</td> <td>{{$shop->license}}</td> <td>{{$shop->shop_imgs}}</td> <td>{{$shop->longitude}}</td> <td>{{$shop->latitude}}</td> <td>{{$shop->status}}</td> <td>{{$shop->province}}</td> <td>{{$shop->city}}</td> <td>{{$shop->district}}</td> <td>{{$shop->address}}</td> <td>{{$shop->wechat_qrcode}}</td> <td>{{$shop->user_id}}</td>
                                    
                                    <td class="text-right">
                                        <a class="btn btn-xs btn-primary" href="{{ route('shops.show', $shop->id) }}">
                                            <i class="glyphicon glyphicon-eye-open"></i> 
                                        </a>
                                        
                                        <a class="btn btn-xs btn-warning" href="{{ route('shops.edit', $shop->id) }}">
                                            <i class="glyphicon glyphicon-edit"></i> 
                                        </a>

                                        <form action="{{ route('shops.destroy', $shop->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete? Are you sure?');">
                                            {{csrf_field()}}
                                            <input type="hidden" name="_method" value="DELETE">

                                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $shops->render() !!}
                @else
                    <h3 class="text-center alert alert-info">Empty!</h3>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
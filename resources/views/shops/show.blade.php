@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Shop / Show #{{ $shop->id }}</h1>
            </div>

            <div class="panel-body">
                <div class="well well-sm">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-link" href="{{ route('shops.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
                        </div>
                        <div class="col-md-6">
                             <a class="btn btn-sm btn-warning pull-right" href="{{ route('shops.edit', $shop->id) }}">
                                <i class="glyphicon glyphicon-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <label>Shop_phone</label>
<p>
	{{ $shop->shop_phone }}
</p> <label>Real_name</label>
<p>
	{{ $shop->real_name }}
</p> <label>Banner</label>
<p>
	{{ $shop->banner }}
</p> <label>Idcard</label>
<p>
	{{ $shop->idcard }}
</p> <label>License</label>
<p>
	{{ $shop->license }}
</p> <label>Shop_imgs</label>
<p>
	{{ $shop->shop_imgs }}
</p> <label>Longitude</label>
<p>
	{{ $shop->longitude }}
</p> <label>Latitude</label>
<p>
	{{ $shop->latitude }}
</p> <label>Status</label>
<p>
	{{ $shop->status }}
</p> <label>Province</label>
<p>
	{{ $shop->province }}
</p> <label>City</label>
<p>
	{{ $shop->city }}
</p> <label>District</label>
<p>
	{{ $shop->district }}
</p> <label>Address</label>
<p>
	{{ $shop->address }}
</p> <label>Wechat_qrcode</label>
<p>
	{{ $shop->wechat_qrcode }}
</p> <label>User_id</label>
<p>
	{{ $shop->user_id }}
</p>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h1>
                    <i class="glyphicon glyphicon-edit"></i> Shop /
                    @if($shop->id)
                        Edit #{{$shop->id}}
                    @else
                        Create
                    @endif
                </h1>
            </div>

            @include('common.error')

            <div class="panel-body">
                @if($shop->id)
                    <form action="{{ route('shops.update', $shop->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('shops.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    
                <div class="form-group">
                	<label for="shop_phone-field">Shop_phone</label>
                	<input class="form-control" type="text" name="shop_phone" id="shop_phone-field" value="{{ old('shop_phone', $shop->shop_phone ) }}" />
                </div> 
                <div class="form-group">
                	<label for="real_name-field">Real_name</label>
                	<input class="form-control" type="text" name="real_name" id="real_name-field" value="{{ old('real_name', $shop->real_name ) }}" />
                </div> 
                <div class="form-group">
                	<label for="banner-field">Banner</label>
                	<input class="form-control" type="text" name="banner" id="banner-field" value="{{ old('banner', $shop->banner ) }}" />
                </div> 
                <div class="form-group">
                	<label for="idcard-field">Idcard</label>
                	<input class="form-control" type="text" name="idcard" id="idcard-field" value="{{ old('idcard', $shop->idcard ) }}" />
                </div> 
                <div class="form-group">
                	<label for="license-field">License</label>
                	<input class="form-control" type="text" name="license" id="license-field" value="{{ old('license', $shop->license ) }}" />
                </div> 
                <div class="form-group">
                    <label for="shop_imgs-field">Shop_imgs</label>
                    <input class="form-control" type="text" name="shop_imgs" id="shop_imgs-field" value="{{ old('shop_imgs', $shop->shop_imgs ) }}" />
                </div> 
                <div class="form-group">
                    <label for="longitude-field">Longitude</label>
                    <input class="form-control" type="text" name="longitude" id="longitude-field" value="{{ old('longitude', $shop->longitude ) }}" />
                </div> 
                <div class="form-group">
                    <label for="latitude-field">Latitude</label>
                    <input class="form-control" type="text" name="latitude" id="latitude-field" value="{{ old('latitude', $shop->latitude ) }}" />
                </div> 
                <div class="form-group">
                    <label for="status-field">Status</label>
                    <input class="form-control" type="text" name="status" id="status-field" value="{{ old('status', $shop->status ) }}" />
                </div> 
                <div class="form-group">
                	<label for="province-field">Province</label>
                	<input class="form-control" type="text" name="province" id="province-field" value="{{ old('province', $shop->province ) }}" />
                </div> 
                <div class="form-group">
                	<label for="city-field">City</label>
                	<input class="form-control" type="text" name="city" id="city-field" value="{{ old('city', $shop->city ) }}" />
                </div> 
                <div class="form-group">
                	<label for="district-field">District</label>
                	<input class="form-control" type="text" name="district" id="district-field" value="{{ old('district', $shop->district ) }}" />
                </div> 
                <div class="form-group">
                	<label for="address-field">Address</label>
                	<input class="form-control" type="text" name="address" id="address-field" value="{{ old('address', $shop->address ) }}" />
                </div> 
                <div class="form-group">
                	<label for="wechat_qrcode-field">Wechat_qrcode</label>
                	<input class="form-control" type="text" name="wechat_qrcode" id="wechat_qrcode-field" value="{{ old('wechat_qrcode', $shop->wechat_qrcode ) }}" />
                </div> 
                <div class="form-group">
                    <label for="user_id-field">User_id</label>
                    <input class="form-control" type="text" name="user_id" id="user_id-field" value="{{ old('user_id', $shop->user_id ) }}" />
                </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a class="btn btn-link pull-right" href="{{ route('shops.index') }}"><i class="glyphicon glyphicon-backward"></i>  Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
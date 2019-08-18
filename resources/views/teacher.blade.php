@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>
                        <i class="glyphicon glyphicon-align-justify"></i> 教师所属课程订单列表
                        @if(session('teacher'))
                            <a class="btn btn-danger pull-right" href="{{ url('teacher/logout') }}"><i
                                        class="glyphicon glyphicon-plus"></i> 注销登陆</a>
                        @endif
                    </h1>
                </div>

                <div class="panel-body">
                    @if(session('teacher'))
                        @if($orders->count())
                            <table class="table table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>标题</th>
                                    <th>订单号</th>
                                    <th>金额</th>
                                    <th>支付时间</th>
                                    <th>支付方式</th>
                                    <th>备注</th>
                                    {{--<th class="text-right">OPTIONS</th>--}}
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="text-center"><strong>{{$order->id}}</strong></td>

                                        <td>{{$order->title}}</td>
                                        <td>{{$order->no}}</td>
                                        <td>{{$order->total_amount}}</td>
                                        <td>{{$order->paid_at}}</td>
                                        <td>{{$order->pay_method}}</td>
                                        <td>{{$order->extra}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {!! $orders->render() !!}
                        @else
                            <h3 class="text-center alert alert-info">暂无订单！</h3>
                        @endif
                    @else
                        <div class="row">
                            <form class="form-horizontal col-md-offset-4 col-md-4" method="POST"
                                  action="{{ url('teacher/login') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">姓名</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" id="inputEmail3"
                                               placeholder="姓名">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="inputPassword3" name="password"
                                               placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-default login ">登录</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
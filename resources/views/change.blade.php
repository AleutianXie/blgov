@extends('adminlte::page')

@section('title', '修改密码')

@section('content_header')
    <h1 class="m-0 text-dark">修改密码</h1>
@stop
@section('css')
<style>
    .label {
        text-align:justify;
        text-align-last:justify;
        width: 80px;
    }
</style>
@stop
@section('content')
    <div class="row">
        <div class="container-fluid">
            <div class="card card-default color-palette-box">
                <form enctype="multipart/form-data" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="card-body">
                        <div class="row">
                            <label for="name" class="label">用户名：</label>
                            <input id="name" name="name" type="text" readonly value="{{$user->name}}"/>
                        </div>
                        <br/>
                        <div class="row">
                            <label for="password" class="label">密码：</label>
                            <input id="password" name="password" type="password" />
                        </div>
                        <br/>
                        <div class="row">
                            <div class="alert-danger">{{ __($errors->first('password')) }}</div>
                        </div>
                        <br/>
                        <div class="row">
                            <label for="password_confirmation" class="label">确认密码：</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" />
                        </div>
                        <br/>
                        <div class="row">
                            <div class="alert-danger">{{ __($errors->first('password_confirmation')) }}</div>
                        </div>
                        <br/>
                        <div class="row">
                            @if (empty($enterprise->report) || $enterprise->report->status == 3)
                                <div class="col-md-3 offset-md-3">
                                    <button type="submit" class="btn btn-primary btn-lg" data-toggle="offcanvas">修改</button>
                                </div>
                            @endif
                        </div>
                        <br/>
                        <!-- /.col -->
                    </div>
                </form>
                <!-- /.row -->
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#town').select2({
                placeholder: '请选择'
            }).val('{{old('town')}}').trigger("change");
        });
    </script>
@stop

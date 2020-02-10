@extends('adminlte::page')

@section('title', '企业详情')

@section('content_header')
    <h1 class="m-0 text-dark">企业详情</h1>
@stop

@section('content')
    <div class="row">
        <div class="container-fluid">
            <!-- COLOR PALETTE -->
            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tag"></i>
                        {{$enterprise->EnterpriseName}}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <h4 class="text-left"><span>企业名称：{{$enterprise->EnterpriseName}}</span></h4>
                            <h4 class="text-left"><span>企业总人数：{{$enterprise->EmployeesNumber}}</span></h4>
                            <h4 class="text-left"><span>所属街道：{{$towns[$enterprise->TownID]}}</span></h4>
                            <h4 class="text-left"><span>联系人：{{$enterprise->Contacts}}</span></h4>
                            <h4 class="text-left"><span>企业规模：{{$enterprise->EnterpriseScale == 1 ? '规上' : '规下'}}</span></h4>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6 col-md-6">
                            <h4 class="text-left"><span>企业组织机构代码：{{$enterprise->OrganizationCode}}</span></h4>
                            <h4 class="text-left"><span>企业复工人数：{{$enterprise->BackEmpNumber}}</span></h4>
                            <h4 class="text-left"><span>企业地址：{{$enterprise->Address}}</span></h4>
                            <h4 class="text-left"><span>手机号码：{{$enterprise->PhoneNumber}}</span></h4>
                            <h4 class="text-left"><span>行业：{{$enterprise->industry}}</span></h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">
                        申报材料
                    </h3>
                </div>
                @if(isset($enterprise->report) && !empty($enterprise->report->docs))
                <div class="card-body">
                        @foreach(json_decode($enterprise->report->docs) as $item)
                        <div class="row">
                            <a href="{{$item->url}}" target="download">{{$item->name}}</a>
                        </div>
                        @endforeach
                </div>
                @endif
                <!-- /.card-body -->
            </div>
            @if (Auth::user()->town_id)
        <div class="card card-default color-palette-box">
            <div class="card-header">
                <h3 class="card-title">
                    审批意见
                </h3>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="row">
                    <textarea name="comment" id="" cols="30" rows="10" style="width: 100%;">{{old('comment')}}</textarea>
                </div>
                    <div class="row">
                        <div class="alert-danger">{{ __($errors->first('comment')) }}</div>
                    </div>
                <br/>
                <div class="row">
                    <select  name="status" id="status" class="col-md-3">
                        <option value=""></option>
                        <option value="2">审批通过</option>
                        <option value="3">不通过</option>
                    </select>
                    <div class="col-md-3 offset-md-3">
                        <button type="submit" class="btn btn-primary btn-sx" data-toggle="offcanvas">提交</button>
                    </div>
                </div>
                    <div class="row">
                        <div class="alert-danger">{{ __($errors->first('status')) }}</div>
                    </div>
                </form>
            </div>
        </div>
            @endif
    </div>
@stop

@section('js')
    <script>

                $(document).ready(function() {
                    $('#status').select2({
                        placeholder: '请选择'
                    }).val('{{old('status')}}').trigger("change");;
                });
    </script>
@stop

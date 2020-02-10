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
                            <h4 class="text-left"><span>企业总人数：{{$enterprise->EmployeeNumber}}</span></h4>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6 col-md-6">
                            <h4 class="text-left"><span>企业组织机构代码：{{$enterprise->OrganizationCode}}</span></h4>
                            <h4 class="text-left"><span>企业复工人数：{{$enterprise->BackEmpNumber}}</span></h4>
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
{{--                @if(isset($enterprise->report) && !empty($enterprise->report->docs))--}}
                <div class="card-body">
                    <div class="row">
                        <a href="http://www.baidu.com" target="download">企业复工申请表</a>
                    </div>
                    <div class="row">
                        <a href="http://www.baidu.com" target="download">企业复工申请表</a>
                    </div>
                    <div class="row">
                        <a href="http://www.baidu.com" target="download">企业复工申请表</a>
                    </div>
                    <div class="row">
                        <a href="http://www.baidu.com" target="download">企业复工申请表</a>
                    </div>
{{--                        @foreach(json_decode($enterprise->report->docs) as $item)--}}
{{--                        @endforeach--}}
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
{{--                @endif--}}
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@stop

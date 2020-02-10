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
                        文件下载列表
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <a href="/storage/950a6719ee251781eacfe3fe00f9e37a.docx" target="download">《企业（单位）复工申请（承诺）表》</a>
                    </div>
                    <div class="row">
                        <a href="/storage/f3b676170fc6c0bbf95c792b318b45d8.docx" target="download">《企业（单位）返工人员调查总表》</a>
                    </div>
                    <div class="row">
                        <a href="/storage/0839f271ec76a9178eef12e606d15283.docx" target="download">《企业（单位）复工防疫方案》</a>
                    </div>
                </div>
            </div>
        <!-- /.card-body -->

            <div class="card card-default color-palette-box">
                <div class="card-header">
                    <h3 class="card-title">
                        文件上传列表
                    </h3>
                </div>
                <form enctype="multipart/form-data" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="card-body">
                    <div class="row">
                        <h5>《企业（单位）复工申请（承诺）表》</h5>
                    </div>
                    <br/>
                    <div class="row">
                        <input id="file1" name="file1" type="file">
                    </div>
                    <br/>
                    <div class="row">
                        <h5>《企业（单位）返工人员调查总表》</h5>
                    </div>
                    <br/>
                    <div class="row">
                        <input id="file2" name="file2" type="file">
                    </div>
                    <br/>
                    <div class="row">
                        <h5>《企业（单位）复工防疫方案》</h5>
                    </div>
                    <br/>
                    <div class="row">
                        <input id="file3" name="file3" type="file">
                    </div>
                    <br/>
                    <div class="row">
                        <h5>附件</h5>
                    </div>
                    <br/>
                    <div class="row">
                        <input id="file4" name="file4" type="file">
                    </div>
                    <br/>
                    <div class="row">
                        <select name="town" id="town" class="col-md-3">
                            <option value=""></option>
                            <option value="1">审批通过</option>
                            <option value="2">不通过</option>
                        </select>
                        <div class="col-md-3 offset-md-3">
                            <button type="submit" class="btn btn-primary btn-lg" data-toggle="offcanvas">点击申报</button>
                        </div>
                    </div>
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
            });
        });
    </script>
@stop

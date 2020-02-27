@extends('adminlte::page')

@section('title', '企业详情')

@section('content_header')
    <h1 class="m-0 text-dark">预审申报</h1>
@stop
<style>
h4{font-size:12px;}
</style>
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
                <div class="card-body" style="display:none">
                    <div class="row">
                        <div class="col-sm-6 col-md-6 message-name">
                            <h4 class="text-left"><span>企业名称：{{$enterprise->EnterpriseName}}</span></h4>
                            <h4 class="text-left"><span>企业总人数：{{$enterprise->EmployeesNumber}}</span></h4>
                            <h4 class="text-left"><span>所属街道：{{$towns[$enterprise->TownID]}}</span></h4>
                            <h4 class="text-left"><span>联系人：{{$enterprise->Contacts}}</span></h4>
                            <h4 class="text-left"><span>企业规模：{{$enterprise->EnterpriseScale == 1 ? '规上' : '规下'}}</span></h4>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6 col-md-6">
                            <h4 class="text-left"><span>企业统一社会信用代码：{{$enterprise->OrganizationCode}}</span></h4>
                            <h4 class="text-left"><span>企业复工人数：{{$enterprise->BackEmpNumber}}</span></h4>
                            <h4 class="text-left"><span>企业地址：{{$enterprise->Address}}</span></h4>
                            <h4 class="text-left"><span>手机号码：{{$enterprise->PhoneNumber}}</span></h4>
                            <h4 class="text-left"><span>行业：{{$enterprise->Industry ?? ''}}</span></h4>
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
                <div class="card-body" style="padding-bottom:50px;">
                    <div class="row">
                        <a href="/storage/950a6719ee251781eacfe3fe00f9e37a.docx" download="《企业（单位）复工申请（承诺）表》.docx" target="download">《企业（单位）复工申请（承诺）表》</a>
                        <div style="position: absolute;right: 50px;">
                        <p style="color:red; margin-bottom:0;margin-left:7px">瞻岐镇需在附件中另提交以下文件的附件3：</p>
                        <a href="/fugong.doc" download="《鄞防[2020]5号工业复工文件》.doc" target="download">《鄞防[2020]5号工业复工文件》</a>
                        <p style="color:red; margin-bottom:0;margin-left:7px">塘溪镇企业采用以下文件作为复工申请填报模板，请在附件中提交：</p>
                        <a href="/tangxi.docx" download="《塘溪镇企业新型冠状病毒感染肺炎疫情企业复工模板》.docx" target="download">《塘溪镇企业新型冠状病毒感染肺炎疫情企业复工模板》</a>
                        </div>
                    </div>  
                    <div class="row">
                        <a href="/storage/f3b676170fc6c0bbf95c792b318b45d8.docx" download="《企业（单位）返工人员调查总表》.docx" target="download">《企业（单位）返工人员调查总表》</a>
                        @if (count($enterprise->employees) > 0)
                            <a href="/employee/export" download="企业（单位）返工人员调查总表" target="download" class="btn btn-sm btn-primary">下载移动端员工填报数据</a>
                        @endif
                        <div style="position: absolute;right: 50px;">
                        </div>
                    </div>
                    <div class="row">
                        <a href="/storage/0839f271ec76a9178eef12e606d15283.docx" download="《企业（单位）复工防疫方案》.docx" target="download">《企业（单位）复工防疫方案》</a>
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
				                    <span style="display: flex;
									                    height:38px;
														    justify-content: center;
															    color: rgba;
																    color: rgba(0,0,0,0.65);
																	    align-items: center;">选择申报街道：</span>
																		                        <select name="town" id="town" class="col-md-3">
																								                            <option value=""></option>
																															                            @foreach($towns as $id => $name)
																																						                                <option value="{{$id}}">{{$name}}</option>
																																														                            @endforeach
																																																					                        </select>
																																																											</div>
																																																											<br/>
																																																											<div class="row">
																																																											                        <div class="alert-danger">{{ __($errors->first('town')) }}</div>
																																																																	                    </div>
																																																																						<br/>
                    <div class="row">
                        <h5>《企业（单位）复工申请（承诺）表》</h5>
                        <span style="color: blue;">(支持doc、docx、pdf，文件大小不能超过10M)</span>
                    </div>
                    <br/>
                    <div class="row">
                        <input id="file1" name="file1" type="file">
                    </div>
                    <br/>
                    <div class="row">
                        <div class="alert-danger">{{ __($errors->first('file1')) }}</div>
                    </div>
                    <br/>
                    <div class="row">
                        <h5>《企业（单位）返工人员调查总表》</h5>
                        <span style="color: blue;">(支持doc、docx、pdf，文件大小不能超过10M)</span>
                    </div>
                    <br/>
                    <div class="row">
                        <input id="file2" name="file2" type="file">
                    </div>
                    <br/>
                    <div class="row">
                        <div class="alert-danger">{{ __($errors->first('file2')) }}</div>
                    </div>
                    <br/>
                    <div class="row">
                        <h5>《企业（单位）复工防疫方案》</h5>
                        <span style="color: blue;">(支持doc、docx、pdf，文件大小不能超过10M)</span>
                    </div>
                    <br/>
                    <div class="row">
                        <input id="file3" name="file3" type="file">
                    </div>
                    <br/>
                    <div class="row">
                        <div class="alert-danger">{{ __($errors->first('file3')) }}</div>
                    </div>
                    <br/>
                    <div class="row">
                        <h5>附件</h5>
                        <span style="color: blue;">(支持rar、zip，文件大小不能超过10M)</span>
                    </div>
                    <br/>
                    <div class="row">
                        <input id="file4" name="file4" type="file">
                    </div>
                    <br/>
                    <div class="row">
                        <div class="alert-danger">{{ __($errors->first('file4')) }}</div>
                    </div>
                    <br/>
                    <div class="row">
                        @if (empty($enterprise->report) || $enterprise->report->status == 3 || ($enterprise->report->status == 2 && $enterprise->report->town_id == 700011) || ($enterprise->report->status == 2 && $enterprise->report->town_id == 700013))
                            <div class="col-md-3 offset-md-3">
                                <button type="submit" class="btn btn-primary btn-lg" data-toggle="offcanvas">点击申报</button>
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

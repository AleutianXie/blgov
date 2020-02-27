@extends('adminlte::page')

@section('title', '企业详情')

@section('content_header')
    <h1 class="m-0 text-dark">企业详情</h1>
@stop

@section('content')
    <div class="row" id="showSpin">
        <div class="container-fluid" id="spinBody">
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
                            <p class="text-left"><span>企业名称：{{$enterprise->EnterpriseName}}</span></p>
                            <p class="text-left"><span>企业总人数：{{$enterprise->EmployeesNumber}}</span></p>
                            <p class="text-left"><span>所属街道：{{$towns[$enterprise->TownID]}}</span></p>
                            <p class="text-left"><span>联系人：{{$enterprise->Contacts}}</span></p>
                            <p class="text-left"><span>企业规模：{{$enterprise->EnterpriseScale == 1 ? '规上' : '规下'}}</span></p>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6 col-md-6">
                            <p class="text-left"><span>企业统一社会信用代码：{{$enterprise->OrganizationCode}}</span></p>
                            <p class="text-left"><span>企业复工人数：{{$enterprise->BackEmpNumber}}</span></p>
                            <p class="text-left"><span>企业地址：{{$enterprise->Address}}</span></p>
                            <p class="text-left"><span>手机号码：{{$enterprise->PhoneNumber}}</span></p>
                            <p class="text-left"><span>行业：{{$enterprise->Industry}}</span></p>
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
                            <a href="{{$item->url}}" target="download" download="{{$item->name}}{{strchr($item->url,'.')}}">{{$item->name}}</a>
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
                <button class="btn btn-xs btn-default showHistoryReport" style="margin-top: -8px;margin-left: 10px;">历史意见</button>
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
    <div class="modal fade" id="showHistoryReportModal" tabindex="-1" role="dialog" aria-labelledby="modalHeader" aria-hidden="true">
        <div class="modal-dialog" style="max-width:80%;max-height:90%;overflow:auto;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeader">历史审批意见</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="modalBody">
                    <div class="row" style="font-weight: bold; background: #FAFAFA;margin-left:2px;">
                        <div class="col-sm-2">序号</div>
                        <div class="col-sm-2">申报时间</div>
                        <div class="col-sm-3">申报对象</div>
                        <div class="col-sm-5">申请结果</div>
                    </div>
                   <div id="showHtml"></div>
                </div>
                <div class="modal-footer">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
@stop

@section('js')
<script src="/lib/spin.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#status').select2({
                placeholder: '请选择'
            }).val('{{old('status')}}').trigger("change");

            $('.showHistoryReport').click(function(){
                var showSpin = new Spinner().spin(document.getElementById('showSpin'));
                $('#showHistoryReportModal').modal().on('hidden.bs.modal', function(){
                    if (showSpin.el != undefined) {
                        showSpin.stop();
                    }
                });
                $.ajax({
                    url: '/enterprise/revision?enterprise_id={{$enterprise->EnterpriseID??""}}',
                    method: 'get',
                    success: function(response){
                        var html = '';
                        var res = response.revisions;
                        var towns = response.towns;
                        for(var i=0; i < res.length; i++){
                            html += '<div style="border: 1px solid #e1e4ea;margin-bottom: 12px;"><div class="row" style="padding:2px;"><div class="col-sm-2">'+res[i].id+'</div><div class="col-sm-2">'+res[i].created_at+'</div><div class="col-sm-3">'+towns[res[i].town_id]+'</div>';
                            if (res[i].status == 1){
                                html += '<div class="col-sm-5" style="color: blue">【审核中】</div>'
                            } else if (res[i].status == 2){
                                html += '<div class="col-sm-5" style="color: green">【审核通过】</div>'
                            }else if (res[i].status == 3){
                                html += '<div class="col-sm-5" style="color: red">【未通过】</div>'
                            }
                            if (res[i].comment){
                                html += '<div class="row" name="comment" style="width: 100%;line-height: 30px;padding: 15px;"><div style="border-top: 1px solid #f4f1f1;width: 100%;"></div>'+res[i].comment+'</div>';
                            }
                            if (res[i].docs){
                                var arr = JSON.parse(res[i].docs);
                                for(var j=0; j < arr.length; j++){
                                    html += '<a href="'+arr[j].url+'" target="download" download="'+arr[j].name+'.'+(arr[j].url).split(".").pop()+'">'+arr[j].name+'</a>';
                                }
                            }
                            html += '</div></div>';
                        }
                        $('#showHtml').html(html);
                        showSpin.stop();
                    },
                    error: function(){
                        showSpin.stop();
                    }
                })
            });
        });
    </script>
@stop

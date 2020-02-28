@extends('adminlte::page')

@section('title', '注册企业汇总')

@section('content_header')
    <h1 class="m-0 text-dark">注册企业汇总</h1>
@stop
@section('css')
<link rel="stylesheet" href="/css/common.css" />
<link rel="stylesheet" href="/css/layui.css" />
<style>
    ul {
        list-style: none;
    }

    table {
        width: 100% !important;
    }

    #layui-table-page1 {
        text-align: right;
    }

    .Btn-class {
        display: inline-block;
        margin-left: 59px;
    }

    .Btn-class span {
        display: inline-block;
        width: 58px;
        margin-right: 46px;
        color: rgba(0, 0, 0, 0.65);
        text-align: center;

    }

    .list {
        margin-bottom: 50px;
        position: relative;
        height: 260px;
        transition: all 1s;
        overflow: hidden;
    }

    .back-active {
        height: 0;
    }

    .list li {
        padding: 20px 35px;
        font-size: 16px;
    }

    .list-title {
        font-weight: bold;
    }

    .color {
        display: inline-block;
        /* padding:5px 10px; */
        background: #1890FF;
        color: #fff !important;
        border-radius: 4px;

    }

    .back {
        position: absolute;
        color: #1890FF;
        right: 20px;
        top: 20px;
        cursor: pointer;
        z-index: 10;
    }

    .back img {
        width: 20px;
        height: 20px;
    }
    #test28,#test29{
        padding:0 10px;
        color: rgba(0,0,0,0.65);
        border:1px solid #e2e2e2
    }
    th,td{
        padding: .75rem;
    }
</style>
<link rel="stylesheet" href="/lib/bootstrap-datetimepicker.min.css">
@stop

@section('content')

<div class="card query-card">
    <div class="card-body query-card-body">
        <div class="row query-row1" style="margin-top: -5px;">
            <div class="col-md-5 query-row1-one">
                <div style="display:inline-block">
                    <button class="btn" style="font-weight:bold;margin-left:-12px;">状态:</button>
                    <a href="/statistical/company?end={{session('end')}}&reportStatus=0&industry={{session('industry')}}&start={{session('start')}}&townType={{session('townType')}}&EnterpriseName={{session('EnterpriseName')}}&Address={{session('Address')}}&per_page={{session('per_page')}}">
                        <button class="btn reportStatus @if(session('reportStatus')==0 || !session('reportStatus')) btn-primary @endif" data-id="0">全部</button>
                    </a>
                    <a href="/statistical/company?end={{session('end')}}&reportStatus=1&start={{session('start')}}&industry={{session('industry')}}&EnterpriseName={{session('EnterpriseName')}}&Address={{session('Address')}}&per_page={{session('per_page')}}&townType={{session('townType')}}">
                        <button class="btn reportStatus  @if(session('reportStatus')==1) btn-primary @endif"" data-id="1">审批中</button>
                    </a>
                    <a href="/statistical/company?end={{session('end')}}&reportStatus=2&industry={{session('industry')}}&start={{session('start')}}&townType={{session('townType')}}&EnterpriseName={{session('EnterpriseName')}}&Address={{session('Address')}}&per_page={{session('per_page')}}">
                        <button class="btn reportStatus @if(session('reportStatus') == 2) btn-primary @endif" data-id="2">通过</button>
                    </a>
                    <a href="/statistical/company?end={{session('end')}}&reportStatus=3&industry={{session('industry')}}&EnterpriseName={{session('EnterpriseName')}}&Address={{session('Address')}}&start={{session('start')}}&per_page={{session('per_page')}}&townType={{session('townType')}}">
                        <button class="btn reportStatus @if(session('reportStatus') == 3) btn-primary @endif" data-id="3">不通过</button>
                    </a>
                </div>
            </div>
            <div class="col-md-5  query-row1-town">
                <label for="">复工时间段:</label>
                <input type="text" name="startDate" value="{{session('showStart')}}" class="form-control" style="width: 120px;display:inline-block">
                ~
                <input type="text" name="endDate" value="{{session('showEnd')}}" class="form-control" style="width: 120px;display:inline-block">
            </div>

            <div class="col-md-2" style="text-align:right;line-height:40px;">
                <a href="/statistical/company?start=&end="  style="margin-right:5px;" class="refresh">刷新</a>
                <a href="#" class="upDownQueryParams" data-tag='f' data-id="0"><span>收起</span> <i class="fa fa-angle-up"></i></a>
            </div>
        </div>
        <div class="row query-row2" style="margin-top:5px;">
            <div class="col-md-12">
                <button class="btn" style="font-weight:bold;margin-left:-12px;">行业:</button>
                <a href="/statistical/company?reportStatus={{session('reportStatus')}}&industry=0&townType={{session('townType')}}&EnterpriseName={{session('EnterpriseName')}}&Address={{session('Address')}}&start={{session('start')}}&end={{session('end')}}&per_page={{session('per_page')}}">
                    <button class="btn @if(session('industry') == 0 || !session('industry')) btn-primary @endif" data-id="">全部</button>
                </a>
                @foreach($industry as $key => $indust)
                <a href="/statistical/company?reportStatus={{session('reportStatus')}}&per_page={{session('per_page')}}&start={{session('start')}}&end={{session('end')}}&ctime={{time()}}&&industry={{$key}}&townType={{session('townType')}}&EnterpriseName={{session('EnterpriseName')}}&Address={{session('Address')}}">
                    <button class="btn industryBtn @if(session('industry') == $key) btn-primary @endif" data-id="{{$key}}">{{$indust}}</button>
                </a>
                @endforeach
            </div>
        </div>
        <div class="row query-row3" style="margin-top:5px;">
            <div class="col-md-12">
                <button class="btn" style="font-weight:bold;margin-left:-12px;">乡镇:</button>
                @if(count($townType) == 1)
                @foreach($townType as $key => $type)
                    <button class="btn btn-primary townTypeBtn" data-id="{{$key}}">{{$type}}</button>
                @endforeach
                @else
                <a href="/statistical/company?reportStatus={{session('reportStatus')}}&start={{session('start')}}&end={{session('end')}}&industry={{session('industry')}}&EnterpriseName={{session('EnterpriseName')}}&Address={{session('Address')}}&townType=0&per_page={{session('per_page')}}">
                    <button class="btn @if(session('townType') == 0 || !session('townType')) btn-primary @endif" data-id="">全部</button>
                </a>
                @foreach($townType as $key => $type)
                <a href="/statistical/company?ctime={{time()}}&reportStatus={{session('reportStatus')}}&per_page={{session('per_page')}}&start={{session('start')}}&end={{session('end')}}&industry={{session('industry')}}&EnterpriseName={{session('EnterpriseName')}}&Address={{session('Address')}}&townType={{$key}}">
                    <button class="btn @if(session('townType') == $key) btn-primary @endif" data-id="{{$key}}">{{$type}}</button>
                </a>
                @endforeach
                @endif
            </div>
        </div>

        <div class="row query-row4" style="margin-top:5px;">
            <div class="col-md-12">
                <button class="btn" style="font-weight:bold;margin-left:-12px;">企业名称:</button>
                <input type="text" id="EnterpriseName" name=EnterpriseName" @if(session('EnterpriseName') != '0') value="{{session('EnterpriseName')}}" @endif class="form-control" placeholder="企业名称" style="width: 260px;display:inline-block"/>

                <button class="btn" style="font-weight:bold;margin-left:-12px;">企业地址:</button>
                <input type="text" id="Address" name=Address" @if(session('Address') != '0') value="{{session('Address')}}" @endif class="form-control" placeholder="企业地址例：首南街道;中河街道" style="width: 260px;display:inline-block"/>

                <button class="btn btn-white btn-info btn-bold btn-see"><i class="ace-icon fa fa-search nav-search-icon green"></i>查找</button>
                <button  class="btn btn-primary report-list" ><i class="ace-icon fa fa-download nav-search-icon green"></i>导出</button>

            </div>
        </div>

        <span id='frsc' style="display: none;">{{@csrf_token()}}</span>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table-striped table-bordered table-hover" id="datatable">
            <thead>
                <tr>
                    <th>企业名称</th>
                    <th>所属区县</th>
                    <th>所属乡镇</th>
                    <th>所属行业</th>
                    <th>企业规模</th>
                    <th>计划开工时间</th>
                    <th>审批状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @if ($enterprises->count())
                @foreach($enterprises as $enterp)
                <tr>
                    <td>{{$enterp->EnterpriseName}}</td>
                    <td>{{$enterp->District}}</td>
                    <td>{{$enterp->town->TownName ?? ''}}</td>
                    <td>{{$enterp->industries->IndustryName ?? ''}}</td>
                    <td>{{$enterp->EnterpriseScale ==1?'规上':'规下'}}</td>
                    <td>{{$enterp->StartDate}}</td>
                    <td>
                        @if(!$enterp->report)
                            <span style="color:#000000">未申报</span>
                        @else 
                            @if($enterp->report->status == 1) <span style="color:blue">审批中</span>
                            @elseif($enterp->report->status == 2) <span style="color:green">通过</span>
                            @elseif($enterp->report->status == 3) <span style="color:red">未通过</span>
                            @endif
                        @endif
                    </td>
                    <td><a href="/enterprise/{{$enterp->EnterpriseID}}" target="_blank" data-tag='f'>详情</a></td>
                </tr>
                @endforeach
                @else
                    <tr><td colspan="8" style="text-align:center;height:50px;">表中数据为空</td></tr>
                @endif
            </tbody>
        </table>
        <div style="width: 100%;display:flex;margin-top:20px;">
            <div style="flex: 1;">
                显示第 {{$enterprises->firstItem()}} 至 {{$enterprises->lastItem()}} 项结果，共 {{$enterprises->total()}} 项
            </div>
            <div style="width:130px;">
                    每页 <select  class="form-control grid-per-pager" style="width:60px;display: inline-block;">
                            <option value="/statistical/company?ctime={{time()}}&reportStatus={{session('reportStatus')}}&start={{session('start')}}&end={{session('end')}}&industry={{session('industry')}}&townType={{session('townType')}}&EnterpriseName={{session('EnterpriseName')}}&Address={{session('Address')}}&per_page=10" @if(session('per_page') == 10) selected @endif>10</option>
                            <option value="/statistical/company?ctime={{time()}}&reportStatus={{session('reportStatus')}}&start={{session('start')}}&end={{session('end')}}&industry={{session('industry')}}&townType={{session('townType')}}&EnterpriseName={{session('EnterpriseName')}}&Address={{session('Address')}}&per_page=20" @if(session('per_page') == 20) selected @endif>20</option>
                            <option value="/statistical/company?ctime={{time()}}&reportStatus={{session('reportStatus')}}&start={{session('start')}}&end={{session('end')}}&industry={{session('industry')}}&townType={{session('townType')}}&EnterpriseName={{session('EnterpriseName')}}&Address={{session('Address')}}&per_page=30" @if(session('per_page') == 30) selected @endif>30</option>
                            <option value="/statistical/company?ctime={{time()}}&reportStatus={{session('reportStatus')}}&start={{session('start')}}&end={{session('end')}}&industry={{session('industry')}}&townType={{session('townType')}}&EnterpriseName={{session('EnterpriseName')}}&Address={{session('Address')}}&per_page=50" @if(session('per_page') == 50) selected @endif>50</option>
                        </select> 条
            </div>
            <div style="width: auto;">
                {{$enterprises->appends(['reportStatus'=>session('reportStatus'),'townType'=>session('townType'),'EnterpriseName'=>session('EnterpriseName'),'Address'=>session('Address'),'industry'=>session('industry'),'end'=>session('end'),'start'=>session('start'),'per_page'=>session('per_page')])->links()}}
            </div>
        </div>
    </div>
</div>
  
@stop
@section('js')
<script src="/lib/bootstrap-datetimepicker.min.js"></script>
<script src="/lib/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="/lib/spin.min.js"></script>
<script>
    var upDownQueryParams = localStorage.getItem('upDownQueryParams');
    if (upDownQueryParams != null || upDownQueryParams != undefined) {
        if (upDownQueryParams == 0) {
            $('.upDownQueryParams').find('span').html('收起');
            $('.upDownQueryParams').attr('data-id',0);
            willDown(0,0);
        } else if(upDownQueryParams == 1){
            $('.upDownQueryParams').find('span').html('展开');
            $('.upDownQueryParams').attr('data-id',1);
            willUp(0,0);
        }
    }
    $('a').click(function(){
        if ($(this).data('tag') != 'f'){
            new Spinner().spin(document.getElementById('datatable'));
        }
    })
    $('.grid-per-pager').on("change", function (e) {
        window.location.href = this.value;
    });
    $('.endTime').on('change', function(){
        console.log($(this).value)
    });
    var startDate = 0;
    @if(session('start'))
        startDate = '{{session('start')}}';
    @endif
    var endDate = 0;
    @if(session('start'))
        endDate = '{{session('end')}}';
    @endif
    $("input[name='startDate']").datetimepicker({
        minView : "month", 
        language : 'zh-CN',
        autoclose : true,
        format : 'yyyy-mm-dd',
        todayBtn : true,
      }).on('changeDate', function(start){
            startDate = start.date.valueOf();
            if (endDate) {
                new Spinner().spin(document.getElementById('datatable'));
                window.location.href = '/statistical/company?ctime={{time()}}&reportStatus='+"{{session('reportStatus')}}"+'&requestID={{str_shuffle(join('',range('a','z')))}}&industry={{session('industry')}}&townType={{session('townType')}}&EnterpriseName={{session('EnterpriseName')}}&Address={{session('Address')}}&per_page={{session('per_page')}}&start='+startDate+'&end='+endDate;
            }
      });

    $("input[name='endDate']").datetimepicker({
        minView : "month", 
        language : 'zh-CN',
        autoclose : true,
        format : 'yyyy-mm-dd',
        todayBtn : true,
      }).on('changeDate', function(end){
        endDate = end.date.valueOf();
        if (startDate != 0) {
            new Spinner().spin(document.getElementById('datatable'));
            window.location.href = '/statistical/company?ctime={{time()}}&reportStatus='+"{{session('reportStatus')}}"+'&requestID={{str_shuffle(join('',range('a','z')))}}&industry={{session('industry')}}&townType={{session('townType')}}&EnterpriseName={{session('EnterpriseName')}}&Address={{session('Address')}}&per_page={{session('per_page')}}&start='+startDate+'&end='+endDate;
        }
      });
    $('.reportStatus').click(function(){
        $('.reportStatus').removeClass('btn-primary');
        $(this).addClass('btn-primary');
    });
    $('.industryBtn').click(function(){
        $('.industryBtn').removeClass('btn-primary');
        $(this).addClass('btn-primary');
    });
    $('.townTypeBtn').click(function(){
        $('.townTypeBtn').removeClass('btn-primary');
        $(this).addClass('btn-primary');
    });
    $('.refresh').click(function(){
        $("input[name='startDate']").val('');
        $("input[name='endDate']").val('');
    })
    $('.upDownQueryParams').click(function(){
        var id = $(this).attr('data-id');
        if (id == 0) {
        //up
            $(this).css({"margin-right":"20px"});
            $(this).attr('data-id',1);
            $(this).find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
            localStorage.setItem('upDownQueryParams',1);
            $(this).find('span').html('展开');
            willUp(120,100);
        } else {
        //down
            $(this).css({"margin-right":"0px"});
            $(this).attr('data-id',0);
            $(this).find('i').removeClass('fa-angle-down').addClass('fa-angle-up')
            localStorage.setItem('upDownQueryParams',0);
            $(this).find('span').html('收起');
            willDown(100,120);
        }
    });
    function willUp(row2,row3){
        $('.query-row2').slideUp(row2);
        $('.query-row3').slideUp(row3);
        $('.query-row4').slideUp(row3);
        $('.query-row1-one').css({"opacity":"0"});
        $('.query-row1-town').css({"opacity":"0"});
        $('.refresh').css({"opacity":"0"});
        $('.query-card-body').css({"margin-top":"20px","padding":"0"});
        $('.query-card').css({"box-shadow":"0 0 1px rgb(244, 246, 249),0 1px 3px rgb(244, 246, 249)","background":"#f4f6f9","margin-bottom":"0"});
    }

    function willDown(row2,row3){
        $('.query-row2').slideDown(row2);
        $('.query-row3').slideDown(row3);
        $('.query-row4').slideDown(row3);
        $('.query-row1-one').css({"opacity":"1"});
        $('.query-row1-town').css({"opacity":"1"});
        $('.refresh').css({"opacity":"1"});
        $('.query-card-body').css({"margin-top":"0","padding": "1.25rem"});
        $('.query-card').css({"box-shadow":"0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2)","background":"#fff","margin-bottom":"1rem"});
    }

    var EnterpriseName = 0;
    @if(session('EnterpriseName'))
        EnterpriseName = '{{session('EnterpriseName')}}';
            @endif
    var Address = 0;
    @if(session('Address'))
        Address = '{{session('Address')}}';
    @endif
    $('.btn-see').click(function(){
        EnterpriseName = document.getElementById("EnterpriseName").value;
        Address = document.getElementById("Address").value;
        window.location.href = '/statistical/company?ctime={{time()}}&reportStatus='+"{{session('reportStatus')}}"+'&requestID={{str_shuffle(join('',range('a','z')))}}&industry={{session('industry')}}&townType={{session('townType')}}&per_page={{session('per_page')}}&start={{session('start')}}&end={{session('end')}}&EnterpriseName='+EnterpriseName+'&Address='+Address;
    });

    $(document).on('click', '.report-list', function (e) {
        var target = $(e.target).parent();
        var url = "/report/exportlist?status={{session('reportStatus')}}&industry={{session('industry')}}&town={{session('townType')}}&enterprise={{session('EnterpriseName')}}&address={{session('Address')}}" + target.serialize();
        window.location = url;
        e.preventDefault();
    });

</script>
@stop
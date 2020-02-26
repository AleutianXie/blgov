@extends('adminlte::page')

@section('title', '申报进度')

@section('content_header')
    <h1 class="m-0 text-dark">申报进度</h1>
@stop

@section('css')
    <link rel="stylesheet" href="{{url('css/common.css')}}" />
@stop
@section('content')

<section class="content-box">
    <div class="container table" style="width: 100%;max-width:100%;">
        <div class="row" style="font-weight: bold; background: #FAFAFA;margin-left:2px;">
            <div class="col-sm-1">序号</div>
            <div class="col-sm-3">企业名称</div>
            <div class="col-sm-1">审批单位</div>
            <div class="col-sm-1">总复工人数</div>
            <div class="col-sm-2">申报时间</div>
            <div class="col-sm-2">批复时间</div>
            <div class="col-sm-2">申请结果</div>
        </div>
        @if (count($revisions)>0)
            @foreach($revisions as $revision)
                <div style="border: 1px solid #e1e4ea;margin-bottom: 12px;">
                    <div class="row" style="padding:2px;">
                        <div class="col-sm-1">
                            {{$revision->id}}
                        </div>
                        <div class="col-sm-3">{{$enterprise->EnterpriseName}}</div>
                        <div class="col-sm-1">{{$towns[$revision->town_id]}}</div>
                        <div class="col-sm-1">{{$enterprise->BackEmpNumber}}</div>
                        <div class="col-sm-2">{{$revision->created_at}}</div>
                        <div class="col-sm-2">{{$enterprise->report->report_at}}</div>
                        <div class="col-sm-2">
                            @if ($revision->status == 2)
                                <span style="color: green">【审核通过】</span>
                            @endif
                            @if ($revision->status == 3)
                                <span style="color: red">【未通过】</span>
                            @endif
                            @if ($revision->status == 1)
                                <span style="color: blue">【审核中】</span>
                            @endif
                        </div>
                    </div>
                    @if (!empty($revision->comment))
                        <div class="row" name="comment" style="width: 100%;line-height: 30px;padding: 15px;">
                            <div style="border-top: 1px solid #f4f1f1;width: 100%;"></div>
                            {{$revision->comment}}
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</section>

    @stop

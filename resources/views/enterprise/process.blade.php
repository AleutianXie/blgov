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
    <div class="container table" style="width: 100%;">
        <div class="row" style="font-weight: bold; background: #FAFAFA;">
            <div class="col-sm-2">序号</div>
            <div class="col-sm-2">申报时间</div>
            <div class="col-sm-3">申报对象</div>
            <div class="col-sm-5">申请结果</div>
        </div>
        @if (count($revisions)>0)
            @foreach($revisions as $revision)
                <div class="row">
                    <div class="col-sm-2">{{$revision->id}}</div>
                    <div class="col-sm-2">{{$revision->created_at}}</div>
                    <div class="col-sm-3">{{$towns[$revision->town_id]}}</div>
                    <div class="col-sm-5">
                        @if ($revision->status == 2)
                            <span style="color: #03933A">【通过，请准备实地勘查】</span>
                        @endif
                        @if ($revision->status == 3)
                            <span style="color: #DD5B5B">【未通过】</span>
                        @endif
                        @if ($revision->status == 1)
                            <span style="color: #1890ff">【审核中】</span>
                        @endif
                    </div>
                </div>
                @if (!empty($revision->comment))
                    <div class="row">
                        <textarea name="comment" id="" cols="30" rows="10" style="width: 100%;">{{$revision->comment}}</textarea>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</section>

    @stop

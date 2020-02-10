@extends('adminlte::page')

@section('title', '企业目录')

@section('content_header')
    <h1 class="m-0 text-dark">企业目录</h1>
@stop

@section('content')
{{--    <div class="row">--}}
{{--        <div class="well well-sm" style="margin-bottom: 10px;">--}}
{{--            <form action="" class="form-inline">--}}
{{--                <input type="select" id="status" name="status" value="{{ !empty($filter['name']) ? $filter['name'] : '' }}"--}}
{{--                       placeholder="姓名" class="form-control">--}}
{{--                <input type="text" id="mobile" name="mobile"--}}
{{--                       value="{{ !empty($filter['mobile']) ? $filter['mobile'] : '' }}" placeholder="手机号"--}}
{{--                       class="form-control">--}}
{{--                <input type="text" id="email" name="email" placeholder="邮箱" class="form-control">--}}
{{--                <button type="submit" class="btn btn-white btn-info btn-bold">--}}
{{--                    <i class="ace-icon fa fa-search nav-search-icon green"></i>搜索--}}
{{--                </button>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="row">
        <div class="col-12">
                <!-- 企业列表--开始 -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" style="width:100%"></table>
                </div>
                <!-- 企业列表--结束 -->
        </div>
    </div>
@stop


@section('js')
    <script type="text/javascript">
        // datatables配置
        $('table').dataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('enterprise.list') }}',
            language: {
                url: '{{ asset('js/localisation/Chinese.json') }}'
            },
            searching: false,
            ordering: false,
            dom: "<'row'<'col-sm-6'l><'col-sm-6'f>><'row'tr><'row'<'col-sm-5'i><'col-sm-7'p>>",
            columns: [
                {
                    title: '企业名称',
                    data: 'EnterpriseName',
                },
                {
                    title: '行业类别',
                    data: 'Industry',
                },
                {
                    title: '申请次数',
                    data: 'version',
                    defaultContent: '',
                },
                {
                    title: '申请时间',
                    data: 'report_at'
                },
                {
                    title: '操作',
                    data: null,
                    render: function (data, type, row) {
                        return '<a href="/enterprise/' + row.EnterpriseID + '">详情</a>';
                    }
                }
            ],
            {{--createdRow: function (row, data, index) {--}}
            {{--    // console.log(row, $('td', row).eq(7).html());--}}
            {{--    $('td', row).eq(5).children('a').editable({--}}
            {{--        emptytext: '新增反馈',--}}
            {{--        params: {'_token' : '{{ csrf_token() }}'},--}}
            {{--        validate: function(value) {--}}
            {{--            if($.trim(value) == '') {--}}
            {{--                return '反馈不能为空！';--}}
            {{--            }--}}
            {{--        }--}}
            {{--    });--}}
            {{--    $('td', row).eq(6).html($('td', row).eq(6).text());--}}
            {{--    $('td', row).eq(7).html($('td', row).eq(7).text());--}}
            {{--}--}}
        })
    </script>
@endsection




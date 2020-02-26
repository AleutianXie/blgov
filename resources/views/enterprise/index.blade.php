@extends('adminlte::page')

@section('title', '企业目录')

@section('content_header')
    <h1 class="m-0 text-dark">企业目录</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="" class="form-row">
                @if (!empty(Auth::user()->industry_id_min))
                    <div class="col-md-1">
                        <select id="town" name="town" class="form-control">
                            <option value=""></option>
                            @foreach($towns as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="col-md-1">
                <select id="status" name="status" class="form-control">
                    <option value=""></option>
                    <option value="1">审批中</option>
                    <option value="2">审批通过</option>
                    <option value="3">不通过</option>
                </select>
                </div>
                <div class="col-md-2">
                <select id="industry" name="industry" class="form-control">
                    <option value=""></option>
                    @foreach($industries as $id => $name)
                        <option value="{{$id}}">{{$name}}</option>
                    @endforeach
                </select>
                </div>
                    <div class="col-md-2">
                        <input type="text" name="enterprise" id="enterprise" class="form-control" placeholder="企业名称" />
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="address" id="address" class="form-control" placeholder="企业地址例：首南街道;中河街道" />
                    </div>
                <button type="submit" class="btn btn-white btn-info btn-bold">
                    <i class="ace-icon fa fa-search nav-search-icon green"></i>查找
                </button>
{{--                    <a  href="/report/export" download="企业（单位）返工人员调查总表" class="btn btn-primary" ><i class="ace-icon fa fa-download nav-search-icon green"></i>导出</a>--}}
                   <button  class="btn btn-primary" ><i class="ace-icon fa fa-download nav-search-icon green"></i>导出</button>
            </form>
        </div>
    </div>

    <br/>

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
       let dt = $('table').dataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('report.list') }}',
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
                    title: '企业地址',
                    data: 'Address',
                },
                @if (!empty(Auth::user()->industry_id_min))
                {
                    title: '申报乡镇',
                    data:'town'
                },
                @endif
                {
                    title: '行业类别',
                    data: 'Industry'
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
                    title: '审核状态',
                    render: function (data, type, row) {
                        var color = 'blank';
                        if(row.status == '审核通过') {
                            color = 'green';
                        } else if (row.status == '不通过'){
                            color = 'red';
                        } else if (row.status == '审核中'){
                            color = 'blue';
                        }
                        return '<span style="color:'+color+'">'+row.status+'</span>';
                    }
                },
                {
                    title: '操作',
                    data: null,
                    render: function (data, type, row) {
                        return '<a href="/enterprise/' + row.EnterpriseID + '" target="_blank">详情</a>';
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
        });
        $(document).ready(function() {
            $('#status').select2({
                placeholder: '全部状态',
                allowClear: true
            });
            $('#industry').select2({
                placeholder: '全部行业',
                allowClear: true
            });
            @if (!empty(Auth::user()->industry_id_min))
                $('#town').select2({
                    placeholder: '全部乡镇',
                    allowClear: true
                });
            @endif
        });

        $(document).on('submit', '.form-row', function (e) {
            var target = $(e.target);
            dt.api().ajax.url('{{ route('report.list') }}' + '?' + target.serialize()).load();
            e.preventDefault();
        });
        $(document).on('click', '.btn-primary', function (e) {
            var target = $(e.target).parent();
            var url = "/report/export?" + target.serialize();
            window.location = url;
            e.preventDefault();
        });
    </script>
@endsection




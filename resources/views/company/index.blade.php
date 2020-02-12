@extends('adminlte::page')

@section('title', '基本信息')

@section('content_header')
    <h1 class="m-0 text-dark">基本信息</h1>
@stop
@section('css')
<link rel="stylesheet" href="/css/common.css" />
<style>
    .form-control{
        background: #f4f6f9;
    }
    .form-control:disabled, .form-control[readonly] {
        background-color: #f4f6f9;
        opacity: 1;
    }
</style>
@stop

@section('content')
<div class="form">
      <div class="form-row">
        <label>企业名称:</label>
      <input type="text" class="form-control" value="{{$company->EnterpriseName}}" disabled/>
      </div>
      <div class="form-row">
        <label>组织机构代码证:</label>
      <input type="text" class="form-control" value="{{$company->OrganizationCode}}" disabled  />
      </div>
      <div class="form-row">
        <label>所属街道:</label>
        <input type="text" class="form-control" value="{{$company->town->TownName ?? ''}}" disabled  />
      </div>
      <div class="form-row">
        <label>企业地址:</label>
        <input type="text" class="form-control" value="{{$company->Address}}" disabled  />
      </div>
      <div class="form-row">
        <label>联系人:</label>
        <input type="text" class="form-control" value="{{$company->Contacts}}" disabled  />
      </div>
      <div class="form-row">
        <label>手机号码:</label>
        <input type="text" class="form-control" value="{{$company->PhoneNumber}}" disabled  />
      </div>
      <div class="form-row">
        <label>企业规模:</label>
        <input type="text" class="form-control" value="{{$company->EnterpriseScale == 1 ?'规上':'规下'}}" disabled  />
      </div>
      <div class="form-row">
        <label>行业大类:</label>
        <input type="text" class="form-control" value="{{$company->industry->IndustryName ?? ''}}" disabled  />
      </div>
      <div class="form-row">
        <label>行业系分类:</label>
        <input type="text" class="form-control" value="{{$company->Industry}}" disabled  />
      </div>
      <div class="form-row">
        <label>员工人数:</label>
        <input type="number" class="form-control" value="{{$company->EmployeesNumber}}" disabled  />
      </div>
      <div class="form-row">
        <label>复工人数:</label>
        <input type="number" class="form-control" value="{{$company->BackEmpNumber}}" disabled  />
      </div>
      <div class="form-row">
        <label>开工时间:</label>
        <input type="text" id="date-picker" class="form-control" value="{{$company->StartDate}}" disabled />
      </div>
      <div class="form-row">
        <label>企业复工情况说明:</label>
        <textarea class="form-control" rows="3" style="resize: none" disabled>{{$company->ProductingPlan}}</textarea>
      </div>
      <div class="form-row"></div>
      <div class="form-row" style="display: flex; justify-content: center;">
        <a href="{{route('company.modify')}}"><button class="btn btn-primary" type="submit">编辑</button></a>
        &emsp;&emsp;
        <button class="btn btn-default" disabled type="submit">保存</button>
      </div>
    </div>
@stop
@section('js')
<script src="https://cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
    $(function() {
      $("#date-picker").datepicker();
    });
  </script>
@stop
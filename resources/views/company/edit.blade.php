@extends('adminlte::page')

@section('title', '基本信息编辑')

@section('content_header')
    <h1 class="m-0 text-dark">信息编辑</h1>
@stop
@section('css')
<link rel="stylesheet" href="/css/common.css" />
<style>
    .form-control{
        /* background: #f4f6f9; */
    }
    .form-control:disabled, .form-control[readonly] {
        background-color: #f4f6f9;
        opacity: 1;
    }
</style>
@stop

@section('content')
<div class="form">
  <form method="post" action="{{route('company.update')}}">
      @csrf
      @method('PUT')
      @if ($errors->any())
          <div class="alert alert-danger" style="margin-left: 100px;">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      <div class="form-row">
        <label>企业名称:</label>
      <input type="text" class="form-control" value="{{$company->EnterpriseName}}" disabled/>
      </div>
      <div class="form-row">
        <label>统一社会信用代码:</label>
        <input type="text" class="form-control" value="{{$company->OrganizationCode}}" name="OrganizationCode" maxlength="100" placeholder="请输入文字" />
      </div>
      <div class="form-row">
        <label>所属街道:</label>
        <select name="TownID" class="form-control" >
          @foreach($towns as $key => $town)
          <option value="{{$key}}" @if($company->TownID == $key) selected @endif>{{$town}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-row">
        <label>企业地址:</label>
        <input type="text" class="form-control" value="{{$company->Address}}" name="Address" maxlength="255" placeholder="请输入文字" />
      </div>
      <div class="form-row">
        <label>联系人:</label>
        <input type="text" class="form-control" value="{{$company->Contacts}}" name="Contacts"  maxlength="32" placeholder="请输入文字" />
      </div>
      <div class="form-row">
        <label>手机号码:</label>
        <input type="text" class="form-control" value="{{$company->PhoneNumber}}" name="PhoneNumber" maxlength="32" placeholder="请输入文字" />
      </div>
      <div class="form-row">
        <label>企业规模:</label>
        <select name="EnterpriseScale" class="form-control" >
          <option value="1" @if($company->EnterpriseScale == 1) selected @endif>规上</option>
          <option value="0" @if($company->EnterpriseScale == 0) selected @endif>规下</option>
        </select>
      </div>
      <div class="form-row">
        <label>行业大类:</label>
        <select name="IndustryTableID" class="form-control" >
            @foreach($industries as $industry)
            <option value="{{$industry->IndustryTableID}}" @if($company->IndustryTableID == $industry->IndustryTableID) selected @endif>{{$industry->IndustryName}}</option>
            @endforeach
        </select>
      </div>
      <div class="form-row">
        <label>行业细分:</label>
        <input type="text" class="form-control" value="{{$company->Industry}}" name="Industry"  maxlength="100" placeholder="请输入文字" />
      </div>
      <div class="form-row">
        <label>员工人数:</label>
        <input type="number" class="form-control" @if($errors->has('EmployeesNumber') || old('EmployeesNumber')) value="{{old('EmployeesNumber')}}" @else  value="{{$company->EmployeesNumber}}" @endif name="EmployeesNumber"  max="200000" maxlength="10" placeholder="请输入人数" />
      </div>
      <div class="form-row">
        <label>复工人数:</label>
        <input type="number" class="form-control" @if($errors->has('BackEmpNumber')) value="{{old('BackEmpNumber')}}" @else value="{{$company->BackEmpNumber}}" @endif name="BackEmpNumber"  max="200000" maxlength="10" placeholder="请输入人数" />
      </div>
      <div class="form-row">
        <label>开工时间:</label>
        <input type="date" id="date-picker" class="form-control" value="{{$company->StartDate}}" name="StartDate" placeholder="开工时间"/>
      </div>
      <div class="form-row">
        <label>企业复工情况说明:</label>
        <textarea class="form-control" rows="3" style="resize: none" name="PreventionDesc">{{$company->PreventionDesc}}</textarea>
      </div>
      <div class="form-row"></div>
      <div class="form-row" style="display: flex; justify-content: center;">
        <a href="{{route('company')}}"><button class="btn btn-default" type="button">取消</button></a>
        &emsp;&emsp;
        <button class="btn btn-primary" type="submit">保存</button>
      </div>
  </form>
</div>
@stop

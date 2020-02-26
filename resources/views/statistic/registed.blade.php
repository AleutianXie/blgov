@extends('adminlte::page')

@section('title', '已注册企业统计')

@section('content_header')
    <h1 class="m-0 text-dark">注册企业统计</h1>
@stop
@section('css')
<link rel="stylesheet" href="/css/common.css" />
<script src="/lib/echarts.min.js"></script>
<style>
    body,
    html {
      width: 100%;
      height: 100%;
      padding: 0;
      margin: 0;
      background: #F0F2F5;
    }

    .title {
      height: 150px;
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .divide,
    .divide2 {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 23%;
      height: 100%;
      color: #fff;

    }

    .divide {
      background: #1890FF;
    }

    .divide2 {
      background: #00D6A7;
    }

    .divide p,
    .divide2 p {
      margin: 10px 0;
      text-align: center;
    }

    ul {
      list-style: none;
    }

    .list ul {
      width: 50%;
      margin: 20px 0;
    }

    .list ul li {
      color: #000000;
      font-size: 13px;
      margin: 20px 0;
    }



    .list-title {
      width: 40%;
    }

    .list-title2 {
      width: 60%;
    }

    .list-title2 ul li {
      float: left;
      width: 50%;
    }
    
  </style>
@stop
@section('content')
<div class="title">
    <div class="divide">
      <div id="companyTotal">
        <p style="font-size: 30px;" id="companyTotalVal">0</p>
        <p style="font-size: 20px;">企业数量</p>
      </div>
    </div>
    <div class="divide2">
      <div id="userTotal">
        <p style="font-size: 30px;" id="userTotalVal">0</p>
        <p style="font-size: 20px;">人员总数</p>
      </div>
    </div>
    <div class="divide">
      <div id="backUser">
        <p style="font-size: 30px;" id="backUserVal">0
        </p>
        <p style="font-size: 20px;">复工人员总数</p>
      </div>
    </div>
    <div class="divide2">
      <div id="lookUser">
        <p style="font-size: 30px;" id="lookUserVal">0
        </p>
        <p style="font-size: 20px;">观察人员总数</p>
      </div>
    </div>
  </div>

  <div class="list" style="display:flex">
    <div class="list-title" id="genderSpin">
      <div style=" margin-bottom: 20px;">行业占比</div>
      <div style="display:flex">
        <div id="genderMain" style="width: 100%;height:200px;"></div>
        <ul>
          <li>
            <span
              style=" display:inline-block; width: 10px;height: 10px;border-radius: 50%; background: #fecd5d;"></span>
              工业：<span id="gongyeCount"></span>
          </li>
          <li>
            
          <li>
            <span
              style=" display:inline-block; width: 10px;height: 10px;border-radius: 50%; background: #ff5599;"></span>
              建筑房产：<span id="buildCount"></span>
          </li>
          <li>
            <span
              style=" display:inline-block; width: 10px;height: 10px;border-radius: 50%; background: #4089ff;"></span>
              其他商贸业：<span id="otherCount"></span>
          </li>
        </ul>
      </div>
    </div>
    <div class="list-title2">
      <div style=" margin-bottom: 20px;">员工外出情况</div>
      <div style="display:flex" id="outUserSpin">
        <div id="OutMain" style="width: 100%;height:200px;"></div>
        <ul>
          <li>
            <span
              style=" display:inline-block; width: 10px;height: 10px;border-radius: 50%; background: #F04864;"></span>
              无：<span id="outWu"></span>
          </li>
          <li>
            <span
              style=" display:inline-block; width: 10px;height: 10px;border-radius: 50%; background: #FACC14;"></span>
              湖北：<span id="outHubei"></span>
          </li>
          <li>
            <span
              style=" display:inline-block; width: 10px;height: 10px;border-radius: 50%; background: #8543E0;"></span>
              温州：<span id="outWenzhou"></span>
          </li>
          <li>
            <span
              style=" display:inline-block; width: 10px;height: 10px;border-radius: 50%; background: #1890FF;"></span>
              台州：<span id="outTaizhou"></span>
          </li>
          <li>
            <span
              style=" display:inline-block; width: 10px;height: 10px;border-radius: 50%; background: #13C2C2;"></span>
            其他：<span id="outOther"></span>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="list-next" style="display: flex; justify-content: space-between; border:none;height: 500px;">
    <div class="form-one" style="width: 48%;" id="contactUser">
      <div style="padding-bottom: 15px;
      border-bottom: 1px solid #E8E8E8;">接触史人数统计</div>
      <div id="touchMain" style="width: 100%;height:200px;"></div>
    </div>
    <div class="form-two" style="width: 48%;" id="backNbo">
      <div style="padding-bottom: 15px;
      border-bottom: 1px solid #E8E8E8;"> 返甬时间轴</div>
      <div id="backMain" style="width: 100%;height:235px;"></div>
    </div>
    <span id="town_id" data-town="{{$town_id}}"></span>
  </div>
@stop
@section('js')
<script src="/lib/spin.min.js"></script>
<script type="text/javascript">
    var companyTotal = new Spinner().spin(document.getElementById('companyTotal'));
    var userTotal = new Spinner().spin(document.getElementById('userTotal'));
    var backUser = new Spinner().spin(document.getElementById('backUser'));
    var lookUser = new Spinner().spin(document.getElementById('lookUser'));
    var outUserSpin = new Spinner().spin(document.getElementById('outUserSpin'));

    var genderSpin = new Spinner().spin(document.getElementById('genderSpin'));
    var town_id = $('#town_id').data('town');
    var summary_url = "{{$urls['summary']}}";
    var medical_url = "{{$urls['medical']}}";
    var touch_url = "{{$urls['touch']}}";
    var back_time_url = "{{$urls['back']}}"+'?star=2020-01-01&end=2020-06-01';
    var wu = 0; //0
    var hubei = 0;//1
    var wenzhou = 0;//2
    var taizhou = 0;//3
    var other = 0;//4

    if (town_id && town_id != undefined){
        summary_url = summary_url + '?town='+town_id;
        medical_url = medical_url + '?town='+town_id;
        touch_url = touch_url + '?town='+town_id;
        back_time_url = back_time_url + '&town='+town_id;
    }
    var genderMain = echarts.init(document.getElementById('genderMain'));
    var genderOption = {
      color: ["#fecd5d", "#ff5599", "#4089ff"],
      series: [
        {
          type: "pie",
          // radius: ["45%", "70%"],
          labelLine: {
            normal: {
              show: true
            }
          },
          label: {
            show: false
          },
          data: []
        }
      ]
    };
    var OutMain = echarts.init(document.getElementById('OutMain'));
    var OutMainOption = {
      color: ["#F04864", "#FACC14", "#8543E0", "#1890FF", "#13C2C2"],
      series: [
        {
          type: "pie",
          radius: ["50%", "70%"],
          labelLine: {
            normal: {
              show: true
            }
          },
          label: {
            show: false
          },
          data: []
        }
      ]
    };
    $.ajax({
      url: summary_url,
      method: 'get',
      success: function(res){
        var summary = res.summary;
        for(var i = 0; i<summary.length;i++){
          if (summary[i].label == '企业数量') {$('#companyTotalVal').html(summary[i].value);companyTotal.stop()}
          if (summary[i].label == '员工总数') {$('#userTotalVal').html(summary[i].value);userTotal.stop()}
          if (summary[i].label == '在甬员工数') {$('#backUserVal').html(summary[i].value);backUser.stop()}
        }
        var gender = res.gender;
        
        var outing = res.outing;
        for(var k=0;k<outing.length;k++){
            if (outing[k].key == '宁波'){
                wu = parseInt(outing[k].value)
                $('#outWu').html(outing[k].value)
            } else if (outing[k].key == '湖北'){
                hubei = parseInt(outing[k].value)
                $('#outHubei').html(outing[k].value)
            } else if (outing[k].key == '温州'){
                wenzhou = parseInt(outing[k].value)
                $('#outWenzhou').html(outing[k].value)
            } else if (outing[k].key == '台州'){
                taizhou = parseInt(outing[k].value)
                $('#outTaizhou').html(outing[k].value);
            } else if (outing[k].key == '其它'){
                other = parseInt(outing[k].value)
                $('#outOther').html(outing[k].value)
            }
        }
        OutMainOption.series[0].data = [
            {value: wu,name: '无'},
            {value: hubei,name: '湖北'},
            {value: wenzhou,name: '温州'},
            {value: taizhou,name: '台州'},
            {value: other,name: '其他'},
        ];
        outUserSpin.stop();
        OutMain.setOption(OutMainOption);
      }
    });
    $.ajax({
      url: medical_url,
      method: 'get',
      success: function(res){
        for(var i = 0; i<res.length;i++){
          if (res[i].label == '医学观察人数') {$('#lookUserVal').html(res[i].value);lookUser.stop()}
        }
      }
    });
    var touchMain = echarts.init(document.getElementById('touchMain'));
    var touchOption = {
      color: ["#00D6A7", "#1890ff", "#F2637B"],
      tooltip: {
        trigger: 'axis',
        axisPointer: {
          type: 'shadow'
        }
      },
      grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
      },
      xAxis: {
        type: 'value',
        boundaryGap: [0, 0.01]
      },
      yAxis: {
        type: 'category',
        data: ['无接触', '疑似接触']
      },
      series: [
        {
          type: 'bar',
          data: [],
          itemStyle: {
            color: function (params) {

              // build a color map as your need.

              var colorList = [

                '#108EE9', '#FFA93A', '#F2637B'

              ];

              return colorList[params.dataIndex]

            },
          }
        }
      ]
    };
    $.ajax({
      url: touch_url,
      method: 'get',
      success: function(res){
        for(var i = 0; i<res.length;i++){
          if (res[i].key == '无接触') {
            touchOption.series[0].data.push(res[i].value);
          }
          if (res[i].key == '湖北接触') {
            touchOption.series[0].data.push(res[i].value);
          }
        }
        touchMain.setOption(touchOption);
      }
    });
    //
    //option4.xAxis.data.push(d);
     //         option4.series[0].data.push(OutgoingDesc[d]);
     var backTimeOption = {
      color: '#1890FF',
      tooltip: {
        trigger: 'axis',
        formatter: function (params) {
          return params[0].name + '<br>返回人数： ' + params[0].data + '人';
        }
      },
      xAxis: {
        type: 'category',
        data: []
      },
      yAxis: {
        type: 'value'
      },
      series: [{
        data: [],
        type: 'line'
      }]
    };
    var backTimeMain = echarts.init(document.getElementById('backMain'));
    $.ajax({
      url: back_time_url,
      method: 'get',
      success: function(res){
        var OutgoingDesc = [];
        for (var i = 0; i< res.length; i++){
          if (res[i].value > 0){
            backTimeOption.xAxis.data.push(res[i].time);
            backTimeOption.series[0].data.push(res[i].value);
          }
        }
        backTimeMain.setOption(backTimeOption);
      }
    });

    $.ajax({
      url: '/statistical/fetchIndustry',
      method: 'get',
      success: function(res){
        var gongye = 0; //600006
        var build = 0; //600007 + 600008
        var other = 0;
        for (var i =0;i<res.length;i++){
          if (res[i].IndustryTableID == 600006){
            gongye = parseInt(res[i].count);
          } else if (res[i].IndustryTableID == 600007){
            build += parseInt(res[i].count);
          } else if (res[i].IndustryTableID == 600008){
            build += parseInt(res[i].count);
          } else {
            other += parseInt(res[i].count);
          }
        }
        genderOption.series[0].data.push({value:gongye,name:'工业'});
        $('#gongyeCount').html(gongye);
        genderOption.series[0].data.push({value:build,name:'建筑房产'});
        $('#buildCount').html(build);
        genderOption.series[0].data.push({value:other,name:'其他商贸业'});
        $('#otherCount').html(other);
        genderMain.setOption(genderOption);
        genderSpin.stop();
      }
    });
</script>
@stop
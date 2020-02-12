@extends('adminlte::page')

@section('title', '查询和统计')

@section('content_header')
    <h1 class="m-0 text-dark">预审材料申报企业统计</h1>
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
      <div>
        <p style="font-size: 30px;" id="reportTotal"></p>
        <p style="font-size: 20px;">申报企业</p>
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
    <div class="list-title">
      <div style=" margin-bottom: 20px;">审批状态</div>
      <div style="display:flex">
        <div id="main" style="width: 100%;height:200px;"></div>
        <ul>
          <li>
            <span
              style=" display:inline-block; width: 10px;height: 10px;border-radius: 50%; background: #00D6A7;"></span>
            通过：<span id="psssCount"></span>
          </li>
          <li>
            <span
              style=" display:inline-block; width: 10px;height: 10px;border-radius: 50%; background: #1890ff;"></span>
            未通过：<span id="noPsssCount"></span>
          </li>
          <li>
            <span
              style=" display:inline-block; width: 10px;height: 10px;border-radius: 50%; background: #F2637B;"></span>
            审批中：<span id="ingCount"></span>
          </li>
        </ul>
      </div>
    </div>
    <div class="list-title2">
      <div style=" margin-bottom: 20px;">员工外出情况</div>
      <div style="display:flex" id="outUser">
        <div id="main2" style="width: 100%;height:200px;"></div>
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
      <div id="main3" style="width: 100%;height:200px;"></div>
    </div>
    <div class="form-two" style="width: 48%;" id="backNbo">
      <div style="padding-bottom: 15px;
      border-bottom: 1px solid #E8E8E8;"> 返甬时间轴</div>
      <div id="main4" style="width: 100%;height:235px;"></div>
    </div>
    <span id="csrf" data-item="1"></span>
  </div>
@stop
@section('js')
<script src="/lib/spin.min.js"></script>
<script type="text/javascript">
    var userTotal = new Spinner().spin(document.getElementById('userTotal'));
    var backUser = new Spinner().spin(document.getElementById('backUser'));
    var lookUser = new Spinner().spin(document.getElementById('lookUser'));
    var outUser = new Spinner().spin(document.getElementById('outUser'));
    //接触史人数统计
    var contactUser = new Spinner().spin(document.getElementById('contactUser'));
    var backNbo = new Spinner().spin(document.getElementById('backNbo'));
    
    var reportCount = {!! $statusGroup !!};
    var ing = reportCount[1] == undefined ? 0 : reportCount[1];
    var pass = reportCount[2] == undefined ? 0 : reportCount[2];
    var noPass = reportCount[3] == undefined ? 0 : reportCount[3];
    var total = ing + pass + noPass;
    $('#reportTotal').html(total);

    $('#ingCount').html(ing);
    $('#noPsssCount').html(noPass);
    $('#psssCount').html(pass);
    var option2 = {
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
            data: [
              
            ]
          }
        ]
      };
      var option3 = {
    
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
    var myChart2 = echarts.init(document.getElementById('main2'));
    var myChart3 = echarts.init(document.getElementById('main3'));
    var option4 = {
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
    var myChart4 = echarts.init(document.getElementById('main4'));
    
    $.ajax({
        url: '/statistical/data',
        async:true,
        success:function(res){
            var EmployeesNumbers = 0;
            var BackEmpNumbes = 0;
            var IsMedicalObservation = 0;
            
            var wu = 0; //0
            var hubei = 0;//1
            var wenzhou = 0;//2
            var taizhou = 0;//3
            var other = 0;//4

            var ContactSituation0 = 0;
            var ContactSituation1 = 0;

            var OutgoingDesc = {};

            for(var i =0;i<res.length;i++){
                
                if (res[i].EmployeesNumber != undefined) {
                    EmployeesNumbers = EmployeesNumbers + res[i].EmployeesNumber;
                }
                if (res[i].BackEmpNumber != undefined) {
                    BackEmpNumbes =BackEmpNumbes + res[i].BackEmpNumber;
                }

                //user
                if (res[i].users != undefined && res[i].users.length) {
                    var users = res[i].users;
                    for(var j=0;j<users.length;j++){
                        if (users[j].IsMedicalObservation){
                            IsMedicalObservation += 1;
                        }
                        if (users[j].OutgoingSituation == 0){
                            wu +=1;
                        }
                        if (users[j].OutgoingSituation == 1){
                            hubei +=1;
                        }
                        if (users[j].OutgoingSituation == 2){
                            wenzhou +=1;
                        }
                        if (users[j].OutgoingSituation == 3){
                            taizhou +=1;
                        }
                        if (users[j].OutgoingSituation == 4){
                            other +=1;
                        }

                        if (users[j].ContactSituation == 0){
                            ContactSituation0 +=1;
                        }

                        if (users[j].ContactSituation == 1){
                            ContactSituation1 +=1;
                        }

                        if (users[j].OutgoingDesc && users[j].OutgoingDesc != undefined && users[j].OutgoingDesc != 0){
                            if (OutgoingDesc[users[j].OutgoingDesc] != undefined) {
                              OutgoingDesc[users[j].OutgoingDesc] += 1;
                            } else {
                              OutgoingDesc[users[j].OutgoingDesc] = 1;
                            }
                            
                        }
                        
                    }
                }
            }

            console.log(EmployeesNumbers, BackEmpNumbes)
            
           
            for(var d in OutgoingDesc){
              option4.xAxis.data.push(d);
              option4.series[0].data.push(OutgoingDesc[d]);
            }
            myChart4.setOption(option4);
            console.log(OutgoingDesc)
            console.log(ContactSituation0,ContactSituation1)
            console.log(wu,hubei,wenzhou,taizhou,other)
            $('#userTotalVal').html(EmployeesNumbers);
            userTotal.stop();
            $('#backUserVal').html(BackEmpNumbes);
            backUser.stop();
            $('#lookUserVal').html(IsMedicalObservation);
            lookUser.stop();

            console.log(IsMedicalObservation)

            $('#outWu').html(wu);
            $('#outHubei').html(hubei);
            $('#outWenzhou').html(wenzhou);
            $('#outTaizhou').html(taizhou);
            $('#outOther').html(other);
            
            option2.series[0].data = [
                {value: wu,name: '无'},
                {value: hubei,name: '湖北'},
                {value: wenzhou,name: '温州'},
                {value: taizhou,name: '台州'},
                {value: other,name: '其他'},
            ];
            option3.series[0].data = [ContactSituation0,ContactSituation1];
            myChart2.setOption(option2);
            outUser.stop();

            myChart3.setOption(option3);
            contactUser.stop();

            backNbo.stop();

        }   
    })
    
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));
    
    
    // var myChart2 = echarts.init(document.getElementById('main3'));
    // 指定图表的配置项和数据
    var option = {

      color: ["#00D6A7", "#1890ff", "#F2637B"],
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
          data: [
            {
              value: pass,
              name: '通过'
            },
            {
              value: noPass,
              name: '不通过'
            },
            {
              value: ing,
              name: '审批中'
            }
          ]
        }
      ]
    };
    

    myChart.setOption(option);
</script>
@stop
<!DOCTYPE html>
<html>
<head>
    <title>{{config('app.name')}}</title>
    <style>
        html,
        body {
            padding: 0;
            margin: 0;
            background: #f0f3f7;
        }
        h1 {
            font-size: 30px;
            font-weight: 400;
            text-align: center;
            margin-top: 160px;
        }
        .login-form-container {
            margin: 0 auto;
            margin-top: 60px;
            width: 400px;
        }
        .switch-tab {
            display: flex;
            font-size: 18px;
        }
        .switch-tab .tab-item {
            position: relative;
            width: 50%;
            text-align: center;
        }
        .switch-tab .tab-item span {
            transition: all 0.3s;
            cursor: pointer;
        }
        .switch-tab .tab-item span:hover {
            color: #1890ff;
        }
        .switch-tab .tab-item.active {
            color: #1890ff;
        }
        .switch-tab .tab-item.active::before {
            content: "";
            position: absolute;
            left: 50%;
            bottom: -20px;
            transform: translateX(-50%);
            width: 60%;
            height: 4px;
            background: #1890ff;
        }
        .login-form {
            margin-top: 60px;
        }
        .form-row {
            position: relative;
            display: flex;
            margin-bottom: 30px;
            justify-content: space-between;
        }
        .form-input {
            height: 46px;
            width: 100%;
            border: 0;
            padding: 0 12px;
            padding-left: 38px;
            outline: none;
            font-size: 18px;
            color: #666;
            box-sizing: border-box;
        }
        .form-input-box {
            width: 100%;
            position: relative;
            box-sizing: border-box;
            border: 1px solid #d9d9d9;
            border-radius: 5px;
            overflow: hidden;
        }
        .input-prefix-icon {
            left: 6px;
        }
        .input-suffix-icon {
            right: 6px;
        }
        .input-suffix-icon,
        .input-prefix-icon {
            position: absolute;
            width: 24px;
            height: 24px;
            top: 11px;
        }
        .form-button {
            display: block;
            height: 46px;
            width: 100%;
            border: 0;
            outline: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        .form-button.normal {
            color: rgba(0, 0, 0, 0.65);
            background: white;
            border: 1px solid #d9d9d9;
        }
        .form-button.primary {
            color: white;
            background: #1890ff;
        }

        footer {
            position: absolute;
            left: 0;
            bottom: 30px;
            width: 100%;
        }
        footer p {
            text-align: center;
            color: rgba(0, 0, 0, 0.45);
            font-size: 14px;
        }

        .bg-image {
            display: block;
            position: absolute;
        }
        .bg-image.n1 {
            width: 28%;
            left: 6%;
            bottom: 0;
        }
        .bg-image.n2 {
            width: 130px;
            top: 30%;
            left: 10%;
        }
        .bg-image.n3 {
            width: 130px;
            right: 10%;
            top: 20%;
        }
        .bg-image.n4 {
            width: 130px;
            right: 30%;
            top: 50%;
        }
        .bg-image.n5 {
            width: 70px;
            right: 10%;
            bottom: 10%;
        }
    </style>
</head>
<body>
<h1>{{config('app.name')}}</h1>
<div class="login-form-container">
    <!-- <div class="switch-tab">
      <div class="tab-item">
        <span>
          帐号密码登录
        </span>
      </div>
      <div class="tab-item active">
        <span>
          手机号登录
        </span>
      </div>
    </div> -->
    <form action="/login" method="post">
        {{ csrf_field() }}
    <div class="login-form">
        <div class="form-row">
            <div class="form-input-box">
                <input type="text" class="form-input" placeholder="手机号" name="name" />
                <img class="input-prefix-icon" src="img/phone.png" />
            </div>
        </div>
        @if ($errors->has('name'))
            <div class="invalid-feedback" style="color:red">
                {{ $errors->first('name') }}
            </div>
        @endif

        <div class="form-row">
            <!-- <div class="form-input-box" style="width: 250px;"> -->
            <div class="form-input-box">
                <input type="password" name="password" class="form-input" placeholder="密码" />
                <img class="input-prefix-icon" src="img/mail.png" />
                <!-- <img class="input-suffix-icon" src="img/correct.png" /> -->
            </div>
            <!-- <button
              class="form-button normal"
              style="width: 150px; margin-left: 10px;"
            >
              获取验证码
            </button> -->
        </div>
        @if ($errors->has('password'))
            <div class="invalid-feedback" style="color:red">
                {{ $errors->first('password') }}
            </div>
        @endif
        <div class="form-row">
            <button type="submit" class="form-button primary" style="">登录</button>
        </div>
    </div>
    </form>
</div>

<footer>
    <p>主办单位：宁波市鄞州区新型冠状病毒感染的肺炎疫情防控领导小组</p>
    <p>技术支持：宝略科技（浙江）有限公司</p>
</footer>

<img class="bg-image n1" src="/img/bg1.png" />
<img class="bg-image n2" src="/img/bg2.png" />
<img class="bg-image n3" src="/img/bg3.png" />
<img class="bg-image n4" src="/img/bg4.png" />
<img class="bg-image n5" src="/img/bg5.png" />
</body>
</html>

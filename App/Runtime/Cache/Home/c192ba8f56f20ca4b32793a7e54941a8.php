<?php if (!defined('THINK_PATH')) exit();?><html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <title>账单系统</title>
    <link href="__PUBLIC__/css/ionic/ionic.min.css" rel="stylesheet">
    <script src="__PUBLIC__/js/ionic.bundle.min.js"></script>
    <script src="__PUBLIC__/js_date/jquery.1.7.2.min.js"></script>
        <script src="__PUBLIC__/js_date/mobiscroll_002.js" type="text/javascript"></script>
      <script src="__PUBLIC__/js_date/mobiscroll_004.js" type="text/javascript"></script>
      <link href="__PUBLIC__/css_date/mobiscroll_002.css" rel="stylesheet" type="text/css">
      <link href="__PUBLIC__/css_date/mobiscroll.css" rel="stylesheet" type="text/css">
      <script src="__PUBLIC__/js_date/mobiscroll.js" type="text/javascript"></script>
      <script src="__PUBLIC__/js_date/mobiscroll_003.js" type="text/javascript"></script>
      <script src="__PUBLIC__/js_date/mobiscroll_005.js" type="text/javascript"></script>
      <link href="__PUBLIC__/css_date/mobiscroll_003.css" rel="stylesheet" type="text/css">
	<title>Document</title>
</head>
<style>
body {
    padding: 0;
    margin: 0;
    font-family: arial, verdana, sans-serif;
    font-size: 12px;
    background: #ddd;
}
input, select {
    width: 100%;
    padding: 5px;
    margin: 5px 0;
    border: 1px solid #aaa;
    box-sizing: border-box;
    border-radius: 5px;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -webkit-border-radius: 5px;
}
.header {
    border: 1px solid #333;
    background: #111;
    color: white;
    font-weight: bold;
    text-shadow: 0 -1px 1px black;
    background-image: linear-gradient(#3C3C3C,#111);
    background-image: -webkit-gradient(linear,left top,left bottom,from(#3C3C3C),to(#111));
    background-image: -moz-linear-gradient(#3C3C3C,#111);
}
.header h1 {
    text-align: center;
    font-size: 16px;
    margin: .6em 0;
    padding: 0;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}
.item-select select.kv_select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    position: absolute;
    top: 0;
    bottom: 0;
    right: 0;
    padding: 8px 48px 8px 16px;
    max-width: 65%;
    border: none;
    background: #fff;
    color: #333;
    text-indent: .01px;
    text-overflow: '';
    white-space: nowrap;
    font-size: 14px;
    cursor: pointer;
    direction: rtl;
}
</style>
<body ng-controller="MyCtrl">
<div class="bar bar-header bar-positive">
  <h1 class="title">账单系统</h1>
</div>
<form method='post' id="form_do" name="form_do" action="<?php echo U(GROUP_NAME. '/Bill/edit');?>">
<div class="content has-header" ng-app="" ng-init="quantity=<?php echo ($vo["num"]); ?>;price=<?php echo ($vo["price"]); ?>">
<div class="list">
      <input type="hidden" name='id' value='<?php echo ($vo["id"]); ?>'>
    <label class="item item-input">
      <span class="input-label">名称：</span>
      <input type="text" name='name' value='<?php echo ($vo["name"]); ?>'>
    </label>
    <label class="item item-input">
      <span class="input-label">单价：</span>
      <input type="text" ng-model="price" name='price' value='<?php echo ($vo["price"]); ?>'>
    </label>
    <label class="item item-input">
      <span class="input-label">数量：</span>
      <input type="text" ng-model="quantity" name='num' value='<?php echo ($vo["num"]); ?>'>
    </label>
    <label class="item item-input">
      <span class="input-label">总价：{{quantity * price}}</span>
      <input type="text"  name='totalprice' value='<?php echo ($vo["totalprice"]); ?>'>
    </label>
    <label class="item item-input">
      <span class="input-label">购买时间：</span>
      <input type="text"  name='buytime' id="appDate" value='<?php echo ($vo["buytime"]); ?>'>
    </label>

	<div class="item item-input item-select">
	    <div class="input-label">
	      类别：
	    </div>
	    <select class="kv_select" name='category'>
	      <option selected="" value=1>生活用品</option>
	      <option value=2>蔬菜</option>
	      <option value=3>水果</option>
	      <option value=4>交通</option>
	      <option value=5>加餐</option>
	      <option value=6>家里补贴</option>
	      <option value=7>娱乐</option>
	      <option value=8>项目公关应酬</option>
	    </select>
	  </div>

  </div>

  <!-- <div ng-app="" ng-init="quantity=1;price=5">

  <h2>价格计算器</h2>

  数量： <input type="number" ng-model="quantity">
  价格： <input type="number" ng-model="price">

  <p><b>总价：</b> {{ quantity * price }}</p>

  </div> -->
  <div class="padding">
    <button class="button button-block button-positive">提交</button>
  </div>
</div>
</form>

<div class="tab-nav tabs">

  <!-- Dashboard Tab -->
  <ion-tab icon-off="ion-ios-pulse" icon-on="ion-ios-pulse-strong" href="#/tab/dash"></ion-tab>

  <!-- Chats Tab -->
  <ion-tab icon-off="ion-ios-chatboxes-outline" icon-on="ion-ios-chatboxes" href="#/tab/chats"></ion-tab>

  <!-- Account Tab -->
  <ion-tab icon-off="ion-ios-gear-outline" icon-on="ion-ios-gear" href="#/tab/account"></ion-tab>


<a ng-class="{'tab-item-active': isTabActive(), 'has-badge':badge, 'tab-hidden':isHidden()}" ng-disabled="disabled()" class="tab-item tab-item-active" icon-on="ion-ios-pulse-strong" icon-off="ion-ios-pulse"><!-- ngIf: badge --><!-- ngIf: getIconOn() && isTabActive() --><i class="icon ion-ios-pulse-strong" ng-if="getIconOn() &amp;&amp; isTabActive()"></i><!-- end ngIf: getIconOn() && isTabActive() --><!-- ngIf: getIconOff() && !isTabActive() --><span class="tab-title ng-binding" ng-bind-html="title">Status</span></a><a ng-class="{'tab-item-active': isTabActive(), 'has-badge':badge, 'tab-hidden':isHidden()}" ng-disabled="disabled()" class="tab-item" icon-on="ion-ios-chatboxes" icon-off="ion-ios-chatboxes-outline"><!-- ngIf: badge --><!-- ngIf: getIconOn() && isTabActive() --><!-- ngIf: getIconOff() && !isTabActive() --><i class="icon ion-ios-chatboxes-outline" ng-if="getIconOff() &amp;&amp; !isTabActive()"></i><!-- end ngIf: getIconOff() && !isTabActive() --><span class="tab-title ng-binding" ng-bind-html="title">Chats</span></a><a ng-class="{'tab-item-active': isTabActive(), 'has-badge':badge, 'tab-hidden':isHidden()}" ng-disabled="disabled()" class="tab-item" icon-on="ion-ios-gear" icon-off="ion-ios-gear-outline"><!-- ngIf: badge --><!-- ngIf: getIconOn() && isTabActive() --><!-- ngIf: getIconOff() && !isTabActive() --><i class="icon ion-ios-gear-outline" ng-if="getIconOff() &amp;&amp; !isTabActive()"></i><!-- end ngIf: getIconOff() && !isTabActive() --><span class="tab-title ng-binding" ng-bind-html="title">Account</span></a></div>


    
    <script src="__PUBLIC__/js/angular.min.js"></script>
      <script type="text/javascript">
            $(function () {
          var currYear = (new Date()).getFullYear();  
          var opt={};
          opt.date = {preset : 'date'};
          opt.datetime = {preset : 'datetime'};
          opt.time = {preset : 'time'};
          opt.default = {
            theme: 'android-ics light', //皮肤样式
                display: 'modal', //显示方式 
                mode: 'scroller', //日期选择模式
            dateFormat: 'yyyy-mm-dd',
            lang: 'zh',
            showNow: true,
            nowText: "今天",
                startYear: currYear - 10, //开始年份
                endYear: currYear + 10 //结束年份
          };

            $("#appDate").mobiscroll($.extend(opt['date'], opt['default']));
            var optDateTime = $.extend(opt['datetime'], opt['default']);
            var optTime = $.extend(opt['time'], opt['default']);
            $("#appDateTime").mobiscroll(optDateTime).datetime(optDateTime);
            $("#appTime").mobiscroll(optTime).time(optTime);
            });
        </script>
</body>
</html>
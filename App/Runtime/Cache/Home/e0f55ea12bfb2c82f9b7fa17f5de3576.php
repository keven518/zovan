<?php if (!defined('THINK_PATH')) exit();?><html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <title>账单系统</title>
    <link href="http://www.runoob.com/static/ionic/css/ionic.min.css" rel="stylesheet">
    <script src="http://www.runoob.com/static/ionic/js/ionic.bundle.min.js"></script>
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
<div class="content has-header ionic-pseudo">

      <div class="list">
		<?php if(is_array($list)): foreach($list as $key=>$p): ?><div class="item item-button-right">
          <?php echo ($p["name"]); ?>—<?php echo ($p["totalprice"]); ?>—<?php echo (date('Y-m-d',$p['buytime'])); ?>
          <a class="button-positive" style="float:right; display:block"  href="<?php echo U(GROUP_NAME. '/Bill/del',array('id' => $p['id']));?>">
            <i class="ion-close-round"></i>
          </a>
          <a class="button-positive" style="float:right; margin-right:10px; color:#000; display:block" href="<?php echo U(GROUP_NAME. '/Bill/edit',array('id' => $p['id']));?>">
            <i class="icon ion-android-create"></i>
          </a>
        </div><?php endforeach; endif; ?>

      </div>

    </div>




    
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

          var buyDate = new Date(<?php echo ($vo["buytime"]); ?>* 1000);
          var buyDateM , buyDateD;
          if((buyDate.getMonth()+1)<10){
        	  buyDateM = '0' + (buyDate.getMonth()+1);
          }else{
        	  buyDateM = (buyDate.getMonth()+1);
          }
          if(buyDate.getDate()<10){
        	  buyDateD = '0' + buyDate.getDate();
          }else{
        	  buyDateD = buyDate.getDate();
          }
          var buyDateStr = buyDate.getFullYear() +'-'+ buyDateM +'-'+ buyDateD;

			$('#appDate').val(buyDateStr);

            $("#appDate").mobiscroll($.extend(opt['date'], opt['default']));
            var optDateTime = $.extend(opt['datetime'], opt['default']);
            var optTime = $.extend(opt['time'], opt['default']);
            $("#appDateTime").mobiscroll(optDateTime).datetime(optDateTime);
            $("#appTime").mobiscroll(optTime).time(optTime);
            });
        </script>
</body>
</html>
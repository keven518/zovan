<?php if (!defined('THINK_PATH')) exit();?><html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
    <title>账单系统</title>
    <link href="__PUBLIC__/css/ionic/ionic.min.css" rel="stylesheet">
    <script src="__PUBLIC__/js/ionic.bundle.min.js"></script>
	<title>Document</title>
</head>
<style>
body {
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
<form method='post' id="form_do" name="form_do" action="<?php echo U(GROUP_NAME. '/Bill/add');?>">
<div class="content has-header" ng-app="" ng-init="quantity=1;price=5">
  <div class="list">
    <label class="item item-input">
      <span class="input-label">名称：</span>
      <input type="text" name='name'>
    </label>
    <label class="item item-input">
      <span class="input-label">单价：</span>
      <input type="text" ng-model="price" name='price'>
    </label>
    <label class="item item-input">
      <span class="input-label">数量：</span>
      <input type="text" ng-model="quantity" name='num'>
    </label>
    <label class="item item-input">
      <span class="input-label">总价：{{quantity * price}}</span>
      <input type="text"  name='totalprice'>
    </label>
    <label class="item item-input">
      <span class="input-label">购买时间：</span>
      <input type="text"  name='buytime'>
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



    
    <script src="__PUBLIC__/js/angular.min.js"></script>
    <script type="text/javascript">
	/*var myModele = angular.module('myMode',[]);
	
	myModele.directive('hello',function(){
	     return{
			 restrict:'B',
			 template:'<div class="red">hello 2131313<strong>你好</strong>everyone</div>',
			 replace:true
		 }	
	})*/
    
    </script>
</body>
</html>
<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo ($title); ?>-我的网站</title>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.2.min.js" ></script>
<link href="__PUBLIC__/css/css.css" rel="stylesheet" type="text/css" />
</head>

<body>
<!--top -->
<div id="top">
<!--[if IE 6]>
<script src="__PUBLIC__/js/DD_belatedPNG_0.0.8a-min.js" language="javascript" type="text/javascript"></script>
<script>
  DD_belatedPNG.fix('#top_logo');   /* string argument can be any CSS selector */
</script>
<![endif]-->
<script type="text/javascript">
$(function(){
	var $chkurl = "<?php echo U('Public/loginChk');?>";
	$.get($chkurl,function(data){
		//alert(data);
		if (data.status == 1) {
			$('#top_login_ok').show();
			$('#top_login_no').hide();
			//$('#top_login_ok').find('span');
			$('#top_login_ok>span').html('欢迎您，'+data.nickname);
		}else {			
			$('#top_login_ok').hide();
			$('#top_login_no').show();
		}
	},'json');	
});
</script>
<div class="warp" id="herd">
	<div id="top_fla">
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="998" height="159">
	  <param name="movie" value="__PUBLIC__/images/top.swf" />
	  <param name="quality" value="high" />
	  <PARAM NAME=wmode value="transparent">
	  <embed src="__PUBLIC__/images/top.swf" quality="high" wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="998" height="159"></embed>
	</object>
	</div>
	<div id="top_member">
		<!--<a href="<?php echo U(GROUP_NAME.'/Product/basket');?>">购物车</a>-->
		<div id="top_login_no">
		<a href="<?php echo U(GROUP_NAME.'/Public/register');?>">会员注册</a>	
		<a href="<?php echo U(GROUP_NAME.'/Public/login');?>">会员登录</a>	
		<span>欢迎您，游客！您可以选择</span>	
		</div>
		<div id="top_login_ok" style="display:none;">
		<a href="<?php echo U(GROUP_NAME.'/Member/index');?>">会员中心</a>	
		<a href="<?php echo U(GROUP_NAME.'/Public/logout');?>">安全退出</a>
		<span>欢迎您， </span>
		</div>
			
	</div>
	<div id="top_logo"><a href="http://localhost/zovan"></a></div>
</div>
<!--menu -->
<div id="menu">
	<ul>
		<li><a href="http://localhost/zovan">首 页</a></li>
		<?php
 $_typeid = 0; if($_typeid == -1) $_typeid = I('cid', 0, 'intval'); $_navlist = getCategory(1); import('Class.Category', APP_PATH); if($_typeid == 0) { $_navlist = Category::toLayer($_navlist); }else { $_navlist = Category::toLayer($_navlist, 'child', $_typeid); } foreach($_navlist as $autoindex => $navlist): $navlist['url'] = getUrl($navlist); ?><li><a href='<?php echo ($navlist["url"]); ?>'><?php echo ($navlist["name"]); ?></a></li><?php endforeach;?>
	</ul>
</div>

<div class="warp1 mt">
<div id="ggao"><b>最新公告：</b><span><marquee><?php
 $where = array('endtime' => array('gt',time())); if (0 > 0) { import('Class.Page', APP_PATH); $count = M('announce')->where($where)->count(); $thisPage = new Page($count, 0); $thisPage->rollPage = 5; $thisPage->setConfig('theme'," %upPage% %linkPage% %downPage% 共%totalPage%页"); $limit = $thisPage->firstRow. ',' .$thisPage->listRows; $page = $thisPage->show(); }else { $limit = "1"; } $_announcelist = M('announce')->where($where)->order("starttime DESC")->limit($limit)->select(); if (empty($_announcelist)) { $_announcelist = array(); } foreach($_announcelist as $autoindex => $announcelist): if(0) $announcelist['title'] = str2sub($announcelist['title'], 0, 0); if(100) $announcelist['content'] = str2sub(strip_tags($announcelist['content']), 100, 0); echo ($announcelist["content"]); endforeach;?></marquee></span></div>
</div>
<div class="clear"></div>

</div>

<div class="content">
	<div class="warp1 mt">

<div class="left f_l">


	<div class="mt">
	<h3 class="left_bt">最新专题</h3>
	<div class="xbox left_box" id="abt">
	<ul class="sywz">
	
	<?php
 $_typeid = 0; $_keyword = ""; if ($_typeid>0) { import('Class.Category', APP_PATH); $_selfcate = Category::getSelf(getCategory(), $_typeid); if ($_selfcate) { $_tablename = strtolower($_selfcate['tablename']); $ids = Category::getChildsId(getCategory(), $_typeid, true); $where = array('special.status' => 0, 'special.cid'=> array('IN',$ids)); }else { $_typeid = 0; } } if ($_typeid == 0) { $where = array('special.status' => 0); } if ($_keyword != '') { $where['special.title'] = array('like','%'.$_keyword.'%'); } if (0 > 0) { $where['_string'] = 'special.flag & 0 = 0 '; } if (0 > 0) { import('Class.Page', APP_PATH); $count = D('SpecialView')->where($where)->count(); $thisPage = new Page($count, 0); $ename = I('e', '', 'htmlspecialchars,trim'); if (!empty($ename) && C('URL_ROUTER_ON') == true) { $thisPage->url = ''.$ename. '/p'; } $thisPage->rollPage = 5; $thisPage->setConfig('theme'," %upPage% %linkPage% %downPage% 共%totalPage%页"); $limit = $thisPage->firstRow. ',' .$thisPage->listRows; $page = $thisPage->show(); }else { $limit = "10"; } $_spelist = D('SpecialView')->nofield('content')->where($where)->order("id DESC")->limit($limit)->select(); if (empty($_spelist)) { $_spelist = array(); } foreach($_spelist as $autoindex => $spelist): if (($spelist['flag'] & B_JUMP) && !empty($spelist['jumpurl'])) { $spelist['url'] = $spelist['jumpurl']; }else { if(C('URL_ROUTER_ON') == true) { $spelist['url'] = U('Special/'.$spelist['id'],''); }else { $spelist['url'] = U('Special/shows', array('id'=> $spelist['id'])); } } if(16) $spelist['title'] = str2sub($spelist['title'], 16, 0); if(0) $spelist['description'] = str2sub($spelist['description'], 0, 0); ?><li><a href="<?php echo ($spelist["url"]); ?>"><?php echo ($spelist["title"]); ?></a></li><?php endforeach;?>
	</ul>
	</div>
	</div>

	<div class="mt">
	<h3 class="left_bt">联系我们</h3>
	<div class="xbox left_contactbox">
	  <p>联系地址：昆明北京路<br />
	  电话：0871-66666</p>
	</div>
	</div>	
</div>

<div class="right f_r">
	<h3 class="nybt"><i>您当前的位置：<?php
 $_sname = ""; $_typeid = -1; if($_typeid == -1) $_typeid = I('cid', 0, 'intval'); if ($_typeid == 0 && $_sname == '') { $_sname = isset($title) ? $title : ''; } echo getPosition($_typeid, $_sname, "", 0, ""); ?> </i><span><?php echo ($title); ?></span></h3>
	<!---->
	<div class="wzzw xbox" style="width:699px; overflow:hidden;">
		<ul class="speli">
		<?php
 $_typeid = 0; $_keyword = ""; if ($_typeid>0) { import('Class.Category', APP_PATH); $_selfcate = Category::getSelf(getCategory(), $_typeid); if ($_selfcate) { $_tablename = strtolower($_selfcate['tablename']); $ids = Category::getChildsId(getCategory(), $_typeid, true); $where = array('special.status' => 0, 'special.cid'=> array('IN',$ids)); }else { $_typeid = 0; } } if ($_typeid == 0) { $where = array('special.status' => 0); } if ($_keyword != '') { $where['special.title'] = array('like','%'.$_keyword.'%'); } if (0 > 0) { $where['_string'] = 'special.flag & 0 = 0 '; } if (10 > 0) { import('Class.Page', APP_PATH); $count = D('SpecialView')->where($where)->count(); $thisPage = new Page($count, 10); $ename = I('e', '', 'htmlspecialchars,trim'); if (!empty($ename) && C('URL_ROUTER_ON') == true) { $thisPage->url = ''.$ename. '/p'; } $thisPage->rollPage = 5; $thisPage->setConfig('theme'," %upPage% %linkPage% %downPage% 共%totalPage%页"); $limit = $thisPage->firstRow. ',' .$thisPage->listRows; $page = $thisPage->show(); }else { $limit = "10"; } $_spelist = D('SpecialView')->nofield('content')->where($where)->order("id DESC")->limit($limit)->select(); if (empty($_spelist)) { $_spelist = array(); } foreach($_spelist as $autoindex => $spelist): if (($spelist['flag'] & B_JUMP) && !empty($spelist['jumpurl'])) { $spelist['url'] = $spelist['jumpurl']; }else { if(C('URL_ROUTER_ON') == true) { $spelist['url'] = U('Special/'.$spelist['id'],''); }else { $spelist['url'] = U('Special/shows', array('id'=> $spelist['id'])); } } if(0) $spelist['title'] = str2sub($spelist['title'], 0, 0); if(0) $spelist['description'] = str2sub($spelist['description'], 0, 0); ?><li>
			<a href="<?php echo ($spelist["url"]); ?>" class="preview"><img src="<?php echo ($spelist["litpic"]); ?>"></a>
			<a href="<?php echo ($spelist["url"]); ?>" class="title"><?php echo ($spelist["title"]); ?></a>
			<span class="info">
				<small>日期：</small><?php echo (date('Y-m-d H:i:s',$spelist["publishtime"])); ?>	
			</span>
			<p class="intro">
				<?php echo ($spelist["description"]); ?>
			</p>
		</li><?php endforeach;?>
		</ul>
		<div class="clear"></div>
		<!--分页 -->
		<div class="scott mt"> <?php echo ($page); ?><div class="clear"></div></div>
	</div>
</div>


<div class=" clear"></div>
</div>
</div>

<div class="warp1 mt" id="bottom">
	<a href="http://localhost/zovan">我的网站</a>版权所有
	<br />
	联系地址：昆明北京路  电话：0871-66666<br />
	Copyright © 2014-2014 XYHCMS. 行云海软件 版权所有 <a href="http://www.0871k.com" target="_blank">Power by XYHCMS</a>
</div>
<?php
 echo '<script type="text/javascript" src="'.U(GROUP_NAME. '/Public/online').'"></script>'; ?>


</body>
</html>
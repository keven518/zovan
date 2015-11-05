<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo ($title); ?>-我的网站</title>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.2.min.js" ></script>
<link href="__PUBLIC__/css/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function changeVcode(obj){
	$("#VCode").attr("src",'/zovan/index.php?g=Home&m=Public&a=verify'+ '#'+Math.random());
	return false;
}
</script>
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
<h3 class="nybt"><span>留言本</span></h3>
<div class="form">
		<form method='post' id="form_do" name="form_do" action="/zovan/index.php?m=Guestbook&a=add">
		<dl>
			<dt>姓名：</dt>
			<dd>
				<input type="text" name="username" class="inp_one" />
			</dd>
		</dl>
		<dl>
			<dt> 电话：</dt>
			<dd>
				<input type="text" name="tel" class="inp_one"/>
			</dd>
		</dl>
		<dl>
			<dt>Email：</dt>
			<dd>
				<input type="text" name="email" class="inp_one" />
			</dd>
		</dl>
		<dl>
			<dt>QQ：</dt>
			<dd>
				<input type="text" name="qq" class="inp_one" />
			</dd>
		</dl>
		<dl>
			<dt>留言：</dt>
			<dd>
				<textarea name="content" cols="50" rows="10"></textarea>
			</dd>
		</dl>

		<?php if(C('cfg_verify_guestbook') == 1): ?><dl>
			<dt>验证码</dt>
			<dd>
				<input type="text" name="vcode" class="inp_small" /><img src="/zovan/index.php?g=Home&m=Public&a=verify" id="VCode" onclick="javascript:changeVcode(this);" />
			</dd>
		</dl><?php endif; ?>
		<div class="form_b">		
			<input type="submit" class="btn_blue" id="submit" value="提 交">
		</div>
	   </form>
	</div>
<div class=" clear"></div>
</div>


<div class="warp1 mt"> 
	<h3 class="nybt"><span>留言列表</span></h3>   
	<?php if(is_array($vlist)): foreach($vlist as $key=>$v): ?><div class="guestbook_title"><?php echo ($v["username"]); ?> <?php echo (date('Y-m-d H:i:s', $v["posttime"])); ?></div>
			<div class="guestbook_msg">
			<?php echo ($v["content"]); ?>
			<?php if($v['replytime']): ?><div class="guestbook_reply">
					<strong>回复：</strong><?php echo ($v["reply"]); ?> <?php echo (date('Y-m-d H:i:s', $v["replytime"])); ?>
				</div><?php endif; ?>
			</div><?php endforeach; endif; ?>
    <!--分页 -->
	<div class="scott mt"><?php echo ($page); ?>
	<div class="clear"></div>
	</div>
 
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
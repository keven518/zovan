<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo ($title); ?>-我的网站</title>
<meta name="keywords" content="<?php echo ($keywords); ?>" />
<meta name="description" content="<?php echo ($description); ?>" />
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.7.2.min.js"></script>
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


	<div class="">
	<h3 class="left_bt">联系我们</h3>
	<div class="xbox left_contactbox">
	  <p>联系地址：昆明北京路<br />
	  电话：0871-66666</p>
	</div>
	</div>

	<div class="mt">
	<h3 class="left_bt">最新文章</h3>
	<div class="xbox left_box" id="abt">
	<ul class="sywz">
	
	<?php
 $_typeid = -1; $_keyword = ""; $_arcid = ""; if($_typeid == -1) $_typeid = I('get.cid', 0, 'intval'); if ($_typeid>0 || substr($_typeid,0,1) == '$') { import('Class.Category', APP_PATH); $ids = Category::getChildsId(getCategory(), $_typeid, true); $where = array('article.status' => 0, 'article.cid'=> array('IN',$ids)); }else { $where = array('article.status' => 0); } if ($_keyword != '') { $where['article.title'] = array('like','%'.$_keyword.'%'); } if (!empty($_arcid)) { $where['article.id'] = array('IN', $_arcid); } if (0 > 0) { $where['_string'] = 'article.flag & 0 = 0 '; } if (0 > 0) { import('Class.Page', APP_PATH); $count = D2('ArcView','article')->where($where)->count(); $thisPage = new Page($count, 0); $ename = I('e', '', 'htmlspecialchars,trim'); if (!empty($ename) && C('URL_ROUTER_ON') == true) { $thisPage->url = ''.$ename. '/p'; } $thisPage->rollPage = 5; $thisPage->setConfig('theme'," %upPage% %linkPage% %downPage% 共%totalPage%页"); $limit = $thisPage->firstRow. ',' .$thisPage->listRows; $page = $thisPage->show(); }else { $limit = "10"; } $_artlist = D2('ArcView','article')->nofield('content')->where($where)->order("id DESC")->limit($limit)->select(); if (empty($_artlist)) { $_artlist = array(); } foreach($_artlist as $autoindex => $artlist): $_jumpflag = ($artlist['flag'] & B_JUMP) == B_JUMP? true : false; $artlist['url'] = getContentUrl($artlist['id'], $artlist['cid'], $artlist['ename'], $_jumpflag, $artlist['jumpurl']); if(16) $artlist['title'] = str2sub($artlist['title'], 16, 0); if(0) $artlist['description'] = str2sub($artlist['description'], 0, 0); ?><li><a href="<?php echo ($artlist["url"]); ?>"><?php echo ($artlist["title"]); ?></a></li><?php endforeach;?>
	</ul>
	</div>
	</div>	
</div>
<div class="right f_r">
	<h3 class="nybt"><i>您当前的位置：<?php
 $_sname = ""; $_typeid = -1; if($_typeid == -1) $_typeid = I('cid', 0, 'intval'); if ($_typeid == 0 && $_sname == '') { $_sname = isset($title) ? $title : ''; } echo getPosition($_typeid, $_sname, "", 0, ""); ?> </i><span><?php echo ($cate["name"]); ?></span></h3>
	<div class="xbox wzzw"> 
<div class="biaoti" align="center"><?php echo ($content["title"]); ?></div>
<div style="border:1px solid #FFE0B4; background:#ffeed5; text-align:center;">发布时间:<?php echo (date('Y-m-d',$content["publishtime"])); ?> 丨 阅读次数:<?php
 if (!empty($id) && !empty($tablename)) { if (C('HTML_CACHE_ON') == true) { echo '<script type="text/javascript" src="'.U(GROUP_NAME. '/Public/click', array('id' => $id, 'tn' => $tablename)).'"></script>'; } else { echo getClick($id, $tablename); } } ?> </div>
	<div class="wzzw lh">
	<?php echo ($content["content"]); ?>
	</div>
 <div class="fenye1" style="text-align:left;">↑上一篇：<?php
 if(empty($content['id']) || empty($content['cid']) || empty($cate['tablename']) ) { echo '无记录'; } else { $_vo= D2('ArcView', $cate['tablename'])->where(array($cate['tablename'].'.status' => 0, 'cid' => $content['cid'], 'id' => array('lt',$content['id'])))->order('id desc')->find(); if ($_vo) { $_jumpflag = ($_vo['flag'] & B_JUMP) == B_JUMP? true : false; $_vo['url'] = getContentUrl($_vo['id'], $_vo['cid'], $_vo['ename'], $_jumpflag, $_vo['jumpurl']); if(0) $_vo['title'] = str2sub($_vo['title'], 0, 0); echo '<a href="'. $_vo['url'] .'">'. $_vo['title'] .'</a>'; } else { echo '第一篇'; } } ?><br/>↓下一篇：<?php
 if(empty($content['id']) || empty($content['cid']) || empty($cate['tablename']) ) { echo '无记录'; } else { $_vo= D2('ArcView',$cate['tablename'])->where(array($cate['tablename'].'.status' => 0, 'cid' => $content['cid'], 'id' => array('gt',$content['id'])))->order('id ASC')->find(); if ($_vo) { $_jumpflag = ($_vo['flag'] & B_JUMP) == B_JUMP? true : false; $_vo['url'] = getContentUrl($_vo['id'], $_vo['cid'], $_vo['ename'], $_jumpflag, $_vo['jumpurl']); if(0) $_vo['title'] = str2sub($_vo['title'], 0, 0); echo '<a href="'. $_vo['url'] .'">'. $_vo['title'] .'</a>'; } else { echo '最后一篇'; } } ?> </div>

    <!--comment -->
    <?php if($commentflag == 1): ?><div class="comment-box">
        <h3>评论(<span class="review-count">0</span>)</h3>
		
        <div class="more-comment">
            后面还有<span id="more_count"></span>条评论，<a href="javascript:get_review();">点击查看>></a>
        </div>
        <form action="<?php echo U(GROUP_NAME.'/Review/add');?>" method="post" class="comment-item" id="reviewForm"  autocomplete="off">
		<a name="reply_" id="reply_"></a>
        	<input type="hidden" name="post_id" value="<?php echo ($content["id"]); ?>"/>
        	<input type="hidden" name="model_id" value="<?php echo ($cate["modelid"]); ?>" />
        	<input type="hidden" name="title" value="<?php echo ($content["title"]); ?>"/>
        	<input type="hidden" name="review_id" value="0" />
        	<span class="avatar"><img src="<?php echo get_avatar(get_cookie('face'),30);?>" alt="" id="my_avatar"></span>
        	<div class="comment-bd" id="review">
        		<div class="comment-textarea">
					<textarea name="content" placeholder="我也来说两句..."></textarea>
				</div>

				<?php if(C('cfg_verify_review') == 1): ?><div class="comment-vcode">
					
					<input type="text" name="vcode" class="inp_small" />
					<img src="/zovan/index.php?g=Home&m=Public&a=verify" id="VCode" onclick="javascript:changeVcode(this);" />
				</div><?php endif; ?>
			</div>
            <div class="comment-ft">
				<input type="submit" class="btn_blue" value="评论&nbsp;[&nbsp;Ctrl+Enter&nbsp;]">
			</div>
        </form>
        
        <div class="login-tip" style="display:none;">
            您可以选择 <a href="<?php echo U(GROUP_NAME. '/Public/login');?>">登录</a> | <a href="<?php echo U(GROUP_NAME. '/Public/register');?>">立即注册</a>
        </div>
    </div>
    <script type="text/javascript" src="__PUBLIC__/js/review.js"></script>
    <script type="text/javascript" language="javascript"> 
        var get_review_url = "<?php echo U(GROUP_NAME.'/Review/getlist');?>";
        var post_review_url = "<?php echo U(GROUP_NAME.'/Review/add');?>";   
		function changeVcode(obj){
			$("#VCode").attr("src",'/zovan/index.php?g=Home&m=Public&a=verify'+ '#'+Math.random());
			return false;
		}
	</script><?php endif; ?>
    <!--comment end-->

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
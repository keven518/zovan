<?php

class PublicAction extends Action {
	
	public function index() {

	}

	public function login() {
		$furl = $_SERVER['HTTP_REFERER'];
		if (IS_POST) {
			$this->loginPost();
			exit();
		}
		$this->furl = $furl;
		$this->title = '用户登录';
		$this->display();
	}


	public function loginPost() {

		if (!IS_POST) exit();

		$furl = I('furl', '','htmlspecialchars,trim');
		if (empty($furl) || strpos($furl, 'register') || strpos($furl, 'login') || strpos($furl, 'logout') || strpos($furl, 'activate') || strpos($furl, 'sendActivate')) {
			$furl = U(GROUP_NAME. '/Member/index');
	
		}

		$email = I('email','','htmlspecialchars,trim');
		$password = I('password','');
		//$verify = I('code','','md5');
	
		/*
		if ($_SESSION['verify'] != $verify) {
			$this->error('验证码不正确');
		}
		*/

		if ($email == '') {
			$this->error('请输入帐号！', '', array('input'=>'email'));//支持ajax,$this->error(info,url,array);
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->error('账号为邮箱地址，格式不正确！', '', array('input'=>'email'));//支持ajax,$this->error(info,url,array);
		}

		if (strlen($password)<4 || strlen($password)>20) {
			$this->error('密码必须是4-20位的字符！', '', array('input'=>'password'));
		}

	
		$user = M('member')->where(array('email' => $email))->find();

		if (!$user || ($user['password'] != get_password($password, $user['encrypt']))) {
			$this->error('账号或密码错误', '', array('input'=>'password'));
		}

		if ($user['islock']) {
			$this->error('用户被锁定！', '', array('input'=>''));
		}
		//更新数据库的参数
		$data = array('id' => $user['id'] ,//保存时会自动为此ID的更新
				'logintime' => time(),
				'loginip' => get_client_ip(),
				'loginnum' => $user['loginnum']+1,

		);
		//更新数据库
		M('member')->save($data);

		//保存Session
		//session(C('USER_AUTH_KEY'), $user['id']);
		//保存到cookie
		set_cookie( array('name' => 'uid', 'value' => $user['id'] ));
		set_cookie( array('name' => 'email', 'value' => $user['email'] ));
		set_cookie( array('name' => 'nickname', 'value' => $user['nickname'] ));
		set_cookie( array('name' => 'logintime', 'value' => date('Y-m-d H:i:s', $user['logintime'])));
		set_cookie( array('name' => 'loginip', 'value' => $user['loginip']));
		set_cookie( array('name' => 'status', 'value' => $user['status']));//激活状态
		set_cookie( array('name' => 'verifytime', 'value' => time()));//激活状态


		//跳转
		//$this->redirect(GROUP_NAME.'/Member/index');
		//redirect(__GROUP__);
		$this->success('登录成功', $furl , array('input'=>''));
	}

		//退出
	public function logout() {

		$furl = $_SERVER['HTTP_REFERER'];
	
		if (empty($furl) || strpos($furl, 'register') || strpos($furl, 'login') || strpos($furl, 'activate') || strpos($furl, 'sendActivate')) {
			$furl = U(GROUP_NAME. '/Public/login');
	
		}

		//session_unset();
		//session_destroy();


		del_cookie(array('name' => 'uid'));
		del_cookie(array('name' => 'email'));
		del_cookie(array('name' => 'nickname'));
		del_cookie(array('name' => 'logintime'));
		del_cookie(array('name' => 'loginip'));
		del_cookie(array('name' => 'status'));


		//$this->redirect(GROUP_NAME.'/Public/login');
		$this->success('安全退出', $furl);
	}



		//自动登录后，js验证，更新积分
	public function loginChk() {		
	}


	//注册
	public function register() {

	}


	//增加点击数
	public function click(){	
		$id = I('id', 0, 'intval');
		$tablename = I('tn', '');
		if (C('HTML_CACHE_ON') == true) {
			echo 'document.write('. getClick($id, $tablename) .')';
		}
		else {
			echo getClick($id, $tablename);
		}
		
	}


	//证码码
	public function verify(){	
		import('ORG.Util.Image');//导入验证码Image类库
		return Image::buildImageVerify(4, 1);
	}

	//online
	public function online(){

		if (C('cfg_online_mode') != 1) {
			return '';
		}

		$_cfg_online_style = C('cfg_online_style');
		$_cfg_online_style = empty($_cfg_online_style) ? 'blue' : $_cfg_online_style;
		$_cfg_online_qq = C('cfg_online_qq');
		$_cfg_online_wangwang = C('cfg_online_wangwang');
		if (empty($_cfg_online_qq)) {
			$_cfg_online_qq = array();
		}else {
			$_cfg_online_qq = explode('|||', $_cfg_online_qq );
		}
		if (empty($_cfg_online_wangwang)) {
			$_cfg_online_wangwang = array();
		}else {
			$_cfg_online_wangwang = explode('|||', $_cfg_online_wangwang );
		}
		$_cfg_online_qq_param = C('cfg_online_qq_param');
		$_cfg_online_wangwang_param = C('cfg_online_wangwang_param');
		//位置
		$_divL = C('cfg_online_h') == 1 ? (-C('cfg_online_h_margin')-0.01) : C('cfg_online_h_margin');//水平
		$_divT = C('cfg_online_v') == 1 ? (-C('cfg_online_v_margin')-0.01) : C('cfg_online_v_margin');
		$_divM = 0;
		if (C('cfg_online_h') == 2 && C('cfg_online_v') == 2) {
			$_divM = 2;
		}elseif (C('cfg_online_h') == 2) {
			$_divM = 1;
		}elseif (C('cfg_online_v') == 2) {
			$_divM = -1;
		}
		//$js_path = str_replace("/", "\/", __ROOT__.'/Data');
		$js_path =  __ROOT__.'/Data';
		

		$str =<<<str
//动态加载
function loadScript(url,callback){ 
   var script = document.createElement("script") 
   script.type = "text/javascript"; 
   if (script.readyState){//IE 
      script.onreadystatechange = function(){ 
         if (script.readyState ==  "loaded" || script.readyState == "complete"){ 
            script.onreadystatechange = null;

            callback(); 
         } 
      }; 
   } else { //Others: Firefox, Safari, Chrome, and Opera 
      script.onload = function(){ 
          callback(); 
      }; 
   } 
   script.src = url; 
   document.body.appendChild(script);

}
function online_show() {
	if(document.getElementById("XYHOnlineView")){
		new scrollx({id:"XYHOnlineView",l:{$_divL},t:{$_divT},f:1,m:{$_divM}});
	}
}
	document.write('<link href="{$js_path}/static/js_plugins/online/{$_cfg_online_style}.css" rel="stylesheet" type="text/css" />');
	document.write('<div id="XYHOnlineView" class="xyh_online_view">');
	document.write('<div class="top_b"></div>');
	document.write('<div class="body">');
	document.write('<dl>');
	document.write('<dd class="title">在线客服</dd>');
	document.write('<dd>');
	document.write('	<span class="ico_zx">在线咨询</span>');
	document.write('</dd>');
str;
	
	foreach($_cfg_online_qq as $autoindex => $_qq):
		$_qq_array = explode('$$$', $_qq);
		$_qq_array[1] = isset($_qq_array[1]) ? $_qq_array[1] : '点击这里给我发消息';
		$str .= 'document.write(\'<dd class="qq">\');';
		$str .= "document.write('".str_replace(array('[客服号]', '[客服说明]',"\r\n","'"), array($_qq_array[0], $_qq_array[1], '', "\'"), $_cfg_online_qq_param)."');";
		$str .= "document.write('</dd>');\n";
	endforeach;

	
	foreach($_cfg_online_wangwang as $autoindex => $_wangwang):
		$_wangwang_array = explode('$$$', $_wangwang);
		$_wangwang_array[1] = isset($_wangwang_array[1]) ? $_wangwang_array[1] : '点击这里给我发消息';
		$str .= 'document.write(\'<dd class="qq">\');';
		$str .= "document.write('".str_replace(array('[客服号]', '[客服说明]',"\r\n","'"), array($_wangwang_array[0], $_wangwang_array[1], '', "\'"), $_cfg_online_wangwang_param)."');";
		$str .= "document.write('</dd>');";
	endforeach;
			
	$str .= "document.write('</dl>');";
	$str .= "document.write('<dl>');";
			 
	if(C('cfg_online_phone') == 1) {	
		$str .= 'document.write(\'<dd class="title bborder">电话咨询</dd>\');';
		$str .= 'document.write(\'<dd><span class="ico_tel">'.C('cfg_phone').'</span></dd>\');';

	}			


	if(C('cfg_online_guestbook') == 1) {

		$str .= 'document.write(\'<dd class="msg noborder"><a href="'.U('Guestbook/index').'" target="_blank">给我们留言</a></dd>\');';
	}
		
		
	$str .= "document.write('</dl>');";
	$str .= "document.write('</div>');";
	$str .= "document.write('</div>');";
	$str .= 'loadScript("'.$js_path.'/static/js_plugins/online/scrollx.js",online_show)';


	echo $str;

	}




}



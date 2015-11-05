<?php
//组成多维数组
//unction nodeForLayer($node, $pid = 0) {
//$access是从数据库读出来的权限数据数组
function nodeForLayer($node, $access = null, $pid = 0) {
	
	if($node == '') return array();
	$arr = array();

	foreach ($node as $v) {
		if (is_array($access)) {
			
			$v['access'] =in_array($v['id'], $access)? 1 : 0;
		}
		if ($v['pid'] == $pid) {
			$v['child'] = nodeForLayer($node, $access, $v['id']);
			$arr[] =$v;
		}
	}

	return $arr;
}

//返回
function flag2Str($flag, $delimiter=' ', $iskey = false, $isarray = false) {
	if (empty($flag)) {
		return $isarray? array(): '';
	}
	$flagStr = array();
	$flagtype = getArrayOfItem('flagtype');//文档属性
	foreach ($flagtype as $k => $v) {
		if ($flag & $k) {
			$flagStr[] = $iskey? $k : $v;
		}
	}
	if ($isarray) {
		return $flagStr;
	} else {
		return implode($delimiter, $flagStr);
	}

}


/**
* 检查栏目权限
* @param $catid 栏目ID
* @param $action 动作
* @param $roleid 角色
* @param $flag 是否为管理组[0会员组,1管理员组]
* @return boolean $value 返回true|false  
*/
function check_category_access($catid, $action, $roleid, $flag = 1) {
	$value = false;
	static $access = null;
	static $access_cid = 0;
	if (!is_array($access) || $access_cid != $catid) {
		$access = M('categoryAccess')->where(array('catid' => $catid))->select();
		if (empty($access)) {
			$access = array();
		}
		$access_cid = $catid;
	}	
	
	foreach ($access as $v) {
		if($v['flag']==$flag && $v['roleid']==$roleid && $v['action']==$action) {
			$value = true;
			break;
		}
	}
	return $value;
}

/**
* 返回有权限的栏目(添加文档或修改文档时)
* @param array $cate 栏目数组
* @param string $action 动作
* @return array   
*/
function get_category_access($cate, $action = 'add') {
	if (empty($cate)) {
		return array();
	}
	//权限检测//超级管理员
	if (!empty($_SESSION[C('ADMIN_AUTH_KEY')])) {
    	return $cate;
    }

    $where = array('flag' => 1, 'roleid' => intval($_SESSION['yang_adm_roleid']));
    if (!empty($action)) {
    	$where['action'] = $action;
    } 
    
	$checkaccess = M('categoryAccess')->distinct(true)->where($where)->getField('catid', true);
    if(empty($checkaccess)) { 
		$checkaccess= array(); 
	}      

	$array = array();
	foreach ($cate as $v) {
		if (in_array($v['id'], $checkaccess) ) {				
			$array[] = $v;
		}
	}

	return $array;
}


?>
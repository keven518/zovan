<?php
class BillAction extends Action{
	//方法：index
	public function index(){
		
		$this->display();
		
		
	}
	
	public function add(){
		if (IS_POST) {
			header("Content-Type: text/html;charset=utf-8"); 
//			print_r($_POST);
//			echo  I('name');
//			exit();
			$data =array(
				'name' => I('name'),
				'num' => I('num'),
				'price' => I('price'),
				'totalprice' => I('totalprice'),
				'category' => I('category'),
				'buytime' => time()
			);
			
			if($id = M('bill')->add($data)) {
				
			}
		}
	}
	
	public function blist(){
		header("Content-Type: text/html;charset=utf-8"); 
		$list = M('bill')->select();
		print_r($list);
		$this->list = $list;
		$this->display();
	}
	
	public function del(){
		header("Content-Type: text/html;charset=utf-8"); 
		$id = I('id',0 , 'intval');
		echo $id;
		if (M('bill')->delete($id)) {
			echo '删除成功';
		}else{
			echo '删除失败';
		}
	}
	
	public function edit(){
		header("Content-Type: text/html;charset=utf-8"); 
		$id = I('id', 0, 'intval');
		if (IS_POST) {
			$this->editPost();
			exit();
		}
		$this->vo = M('bill')->find($id);
		print_r($this->vo);
		$this->display();
	}
	
	public function editPost(){
		$id = I('id', 0, 'intval');
		$data =array(
			'id' => I('id', 0, 'intval'),
			'name' => I('name'),
				'num' => I('num'),
				'price' => I('price'),
				'totalprice' => I('totalprice'),
				'category' => I('category'),
				'buytime' => time()
		);
		if (false !== M('bill')->save($data)) {
			echo '修改成功';
		}else{
			echo '修改失败';
		}
	}
	
}
?>
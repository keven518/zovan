<?php
class BillAction extends Action{
	//方法：index
	public function index(){
		
		echo 'keven';
		
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
}
?>
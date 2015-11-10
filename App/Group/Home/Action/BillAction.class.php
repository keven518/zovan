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
				'buytime' => strtotime(I('buytime'))
			);
			
			if($id = M('bill')->add($data)) {
//				echo $data['buytime'];
				$billdate = M('billdate')->where(array('buydatetime' => $data['buytime']))->find();
				$condition['buytime'] = $data['buytime'];
				$totalprice = M('bill')->where($condition)->sum('totalprice');
				
				if($billdate){
					//echo '有数据，要修改';
//					print_r($billdate);
					$billdate_data =array(
						'totalprice' => $totalprice
					);
					$billdate_where['buydatetime' ] = $data['buytime'];
					if (false !== M('billdate')->where($billdate_where)->save($billdate_data)) {
						echo 'billdate修改成功';
					}else{
						echo 'billdate修改失败';
					}
				}else{
					//echo '无数据，要新增';
					$billdate_data =array(
						'buydatetime' => $data['buytime'],
						'totalprice' => $totalprice,
					);
					
					if (false !== M('billdate')->add($billdate_data)) {
						echo 'billdate添加成功';
					}else{
						echo 'billdate添加失败';
					}
				}
			}
		}
	}
	
	public function blist(){
		header("Content-Type: text/html;charset=utf-8"); 
		$list = M('bill')->select();
//		print_r($list);
		$this->list = $list;
		$this->display();
	}
	
	public function del(){
		header("Content-Type: text/html;charset=utf-8"); 
		$id = I('id',0 , 'intval');
		$kv = M('bill')->find($id);
		$condition['buytime'] = $kv['buytime'];
		
		if (M('bill')->delete($id)) {
			echo '删除成功';
			$totalprice = M('bill')->where($condition)->sum('totalprice');
			echo $id.'<br>'.$totalprice;
			exit;
					$billdate_data =array(
						'totalprice' => $totalprice
					);
					$billdate_where['buydatetime' ] = $data['buytime'];
					if (false !== M('billdate')->where($billdate_where)->save($billdate_data)) {
						echo 'billdate修改成功';
					}else{
						echo 'billdate修改失败';
					}
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
		$this->category = M('bill_category')->select();
//		print_r($this->vo);
//		print_r($this->category);
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
				'buytime' => strtotime(I('buytime'))
		);
		
		if (false !== M('bill')->save($data)) {
			echo '修改成功';
			$condition['buytime'] = $data['buytime'];
			$totalprice = M('bill')->where($condition)->sum('totalprice');
			
					$billdate_data =array(
						'totalprice' => $totalprice
					);
					$billdate_where['buydatetime' ] = $data['buytime'];
					if (false !== M('billdate')->where($billdate_where)->save($billdate_data)) {
						echo 'billdate修改成功';
					}else{
						echo 'billdate修改失败';
					}
		}else{
			echo '修改失败';
		}
	}
	
}
?>
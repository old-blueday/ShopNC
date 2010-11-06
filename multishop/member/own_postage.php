<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想多用户商城 项目的一部分
//
// Copyright (c) 2007 - 2010 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : own_postage.php   FILE_PATH : E:\www\multishop\trunk\member\own_postage.php
 * 运费模板
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @version Mon Mar 15 05:57:10 GMT 2010
 */

require ("../global.inc.php");
class OwnPostage extends memberFrameWork{
	/**
	 * 运费对象
	 *
	 * @var obj
	 */
	var $obj_postage;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $obj_validate;
	
	function main(){
		/**
		 * 创建运费对象
		 */
		if (!is_object($this->obj_postage)){
			require_once ("postage.class.php");
			$this->obj_postage = new PostageClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->obj_validate)){
			require_once("commonvalidate.class.php");
			$this->obj_validate = new CommonValidate();
		}
		/**
		 * 语言包
		 */
		$this->getlang("own_postage");
		/**
		 * 菜单输出
		 */
		$this->memberMenu('seller','postage','postage_tpl');
		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case "list":
				$this->_list();
				break;
			case 'add':
				/**
				 * 菜单输出
				 */
				$this->memberMenu('seller','postage','postage_tpl_add');
				
				$this->_add();
				break;
			case 'save':
				$this->_save();
				break;
			case 'modi':
				$this->_modi();
				break;
			case 'update':
				$this->_update();
				break;
			case 'del':
				$this->_del();
				break;
			case 'sel_postage':
				$this->_sel_postage();
				break;
		}
	}
	
	/**
	 * 运费模板列表
	 */
	function _list(){
		/**
		 * 初始化分页类
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		$this->obj_page->pagebarnum(15);
		$condition['member_id'] = $_SESSION['s_login']['id'];
		$postage_list = $this->obj_postage->listPostage($condition,$this->obj_page);
		$this->obj_page->new_style = true;
		$page_list = $this->obj_page->show('member');
		/**
		 * 处理数据
		 */
		if (is_array($postage_list)){
			foreach ($postage_list as $k => $v){
				$postage_list[$k]['postage_update_time'] = date("Y-m-d H:i:s",$v['postage_update_time']);
			}
		}
		/**
		 * 模板输出
		 */
		$this->output('page_list',$page_list);
		$this->output('postage_list',$postage_list);
		$this->showpage('own_postage.list');
	}
	
	/**
	 * 添加模板
	 */
	function _add(){
		/**
		 * 输出地区 只包括一级
		 */
		$array = Common::getAreaCache('');
		$sel_area = array();
		if (is_array($array)){
			foreach ($array as $k => $v){
				if($v[1] == '0'){
					$sel_area[] = $v;
				}
			}
		}
		/**
		 * 模板输出
		 */
		$this->output('sel_area',$sel_area);
		$this->output('product_sel',$this->_input['product_sel']);
		/**
		 * 在商品添加修改中的操作输出模板
		 */
		if ($this->_input['product_sel'] == '1'){
			$this->showpage('own_postage.add',false);
		}else {
			$this->showpage('own_postage.add');
		}
	}
	
	/**
	 * 保存模板
	 */
	function _save(){
		/**
		 * 验证提交信息
		 */
		$this->obj_validate->validateparam = array(
			array("input"=>$this->_input["postage_title"],"require"=>"true","message"=>$this->_lang['errPostageTitleIsEmpty'])
		);
		$error = $this->obj_validate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			//平邮 
			if($this->_input['postage_ordinary'] == '1'){
				$postage_ordinary = array(
										'default'=>array(
											'default'=>$this->_input['default_ordinary'],
											'default_up'=>$this->_input['default_up_ordinary']
										),
									);
			}
			//快递
			if($this->_input['postage_fast'] == '1'){
				$postage_fast = array(
										'default'=>array(
											'default'=>$this->_input['default_fast'],
											'default_up'=>$this->_input['default_up_fast']
										),
									);
			}
			//ems
			if($this->_input['postage_ems'] == '1'){
				$postage_ems = array(
										'default'=>array(
											'default'=>$this->_input['default_ems'],
											'default_up'=>$this->_input['default_up_ems']
										),
									);
			}
			
			$ordinary_input_array = array();
			$fast_input_array = array();
			$ems_input_array = array();
			foreach ($this->_input as $k => $v){
				//ordinary_area_name
				if($this->_input['postage_ordinary'] == '1' && substr($k,0,18) == 'ordinary_area_name'){
					$num = substr($k,-1);
					/**
					 * 判断是否已存在同地区的运费，如果存在，那么不重新计算
					 */
					$check = $this->check_repeat_postage($postage_ordinary,$v);
					if($check === false){
						$postage_ordinary[] = array($v,$this->_input['ordinary_area_postage_'.$num],$this->_input['ordinary_area_postage_up_'.$num]);
					}
				}
				//fast_area_name
				if($this->_input['postage_fast'] == '1' && substr($k,0,14) == 'fast_area_name'){
					$num = substr($k,-1);
					/**
					 * 判断是否已存在同地区的运费，如果存在，那么不重新计算
					 */
					$check = $this->check_repeat_postage($postage_fast,$v);
					if($check === false){
						$postage_fast[] = array($v,$this->_input['fast_area_postage_'.$num],$this->_input['fast_area_postage_up_'.$num]);
					}
					
				}
				//ems_area_name
				if($this->_input['postage_ems'] == '1' && substr($k,0,13) == 'ems_area_name'){
					$num = substr($k,-1);
					/**
					 * 判断是否已存在同地区的运费，如果存在，那么不重新计算
					 */
					$check = $this->check_repeat_postage($postage_ems,$v);
					if($check === false){
						$postage_ems[] = array($v,$this->_input['ems_area_postage_'.$num],$this->_input['ems_area_postage_up_'.$num]);
					}
				}
			}
			/**
			 * 判断三种类型是否都没有选择
			 */
			if (empty($postage_ordinary) && empty($postage_fast) && empty($postage_ems)){
				$this->redirectPath("error","",$this->_lang['errPostageSelEmpty']);
			}
			/**
			 * 入数据库
			 */
			$value_array = array();
			$value_array['member_id'] = $_SESSION['s_login']['id'];
			$value_array['postage_title'] = $this->_input['postage_title'];
			$value_array['postage_content'] = $this->_input['postage_content'];
			if (!empty($postage_ordinary)){
				$value_array['postage_ordinary'] = serialize($postage_ordinary);
			}
			if (!empty($postage_fast)){
				$value_array['postage_fast'] = serialize($postage_fast);
			}
			if (!empty($postage_ems)){
				$value_array['postage_ems'] = serialize($postage_ems);
			}
			$value_array['postage_update_time'] = time();
			//
			$result = $this->obj_postage->addPostage($value_array);
			/**
			 * 返回到商品添加修改选择运费模板的页面
			 */
			if ($this->_input['product_sel'] == '1'){
				@header('location: ./own_postage.php?action=sel_postage');
			}else {
				if($result === true){
					$this->redirectPath('succ','./member/own_postage.php?action=list',$this->_lang['langPostageAddSucc']);
				}else {
					$this->redirectPath('error','',$this->_lang['errPostageAddFail']);
				}
			}
		}
	}
	
	/**
	 * 编辑
	 */
	function _modi(){
		$postage_array = $this->obj_postage->getOnePostage($this->_input['postage_id']);
		if(empty($postage_array) || ($postage_array['member_id'] != $_SESSION['s_login']['id'])){
			$this->redirectPath('error','',$this->_lang['errPostageModiIdIsIllegal']);
		}
		/**
		 * 输出地区 只包括一级
		 */
		$array = Common::getAreaCache('');
		$sel_area = array();
		if (is_array($array)){
			foreach ($array as $k => $v){
				if($v[1] == '0'){
					$sel_area[] = $v;
				}
			}
		}
		/**
		 * 反序列化
		 */
		if ($postage_array['postage_ordinary'] != ''){
			$postage_array['postage_ordinary'] = unserialize($postage_array['postage_ordinary']);
			if (count($postage_array['postage_ordinary']) > 1){
				foreach ($postage_array['postage_ordinary'] as $k => $v){
					if ($k !== 'default'){
						$tmp = $v[0];
						$tmp_array = explode(',',trim($tmp,','));
						foreach ($tmp_array as $k2 => $v2){
							if (!empty($sel_area)){
								foreach ($sel_area as $k3 => $v3){
									if ($v3[0] == $v2){
										$tmp_area .= $v3[2].',';
									}
								}
							}
						}
						$postage_array['postage_ordinary'][$k]['area_name'] = $tmp_area;
						unset($tmp,$tmp_array,$tmp_area);
					}
				}
			}
		}
		if ($postage_array['postage_fast'] != ''){
			$postage_array['postage_fast'] = unserialize($postage_array['postage_fast']);
			if (count($postage_array['postage_fast']) > 1){
				foreach ($postage_array['postage_fast'] as $k => $v){
					if ($k !== 'default'){
						$tmp = $v[0];
						$tmp_array = explode(',',trim($tmp,','));
						foreach ($tmp_array as $k2 => $v2){
							if (!empty($sel_area)){
								foreach ($sel_area as $k3 => $v3){
									if ($v3[0] == $v2){
										$tmp_area .= $v3[2].',';
									}
								}
							}
						}
						$postage_array['postage_fast'][$k]['area_name'] = $tmp_area;
						unset($tmp,$tmp_array,$tmp_area);
					}
				}
			}
		}
		if ($postage_array['postage_ems'] != ''){
			$postage_array['postage_ems'] = unserialize($postage_array['postage_ems']);
			if (count($postage_array['postage_ems']) > 1){
				foreach ($postage_array['postage_ems'] as $k => $v){
					if ($k !== 'default'){
						$tmp = $v[0];
						$tmp_array = explode(',',trim($tmp,','));
						foreach ($tmp_array as $k2 => $v2){
							if (!empty($sel_area)){
								foreach ($sel_area as $k3 => $v3){
									if ($v3[0] == $v2){
										$tmp_area .= $v3[2].',';
									}
								}
							}
						}
						$postage_array['postage_ems'][$k]['area_name'] = $tmp_area;
						unset($tmp,$tmp_array,$tmp_area);
					}
				}
			}
		}
		/**
		 * 模板输出
		 */
		$this->output('product_sel',$this->_input['product_sel']);
		$this->output('postage_array',$postage_array);
		$this->output('sel_area',$sel_area);
		/**
		 * 在商品添加修改中的操作输出模板
		 */
		if ($this->_input['product_sel'] == '1'){
			$this->showpage('own_postage.modi',false);
		}else {
			$this->showpage('own_postage.modi');
		}
	}
	
	/**
	 * 更新模板
	 */
	function _update(){
		/**
		 * 验证提交信息
		 */
		$this->obj_validate->validateparam = array(
			array("input"=>$this->_input["postage_title"],"require"=>"true","message"=>$this->_lang['errPostageTitleIsEmpty'])
		);
		$error = $this->obj_validate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			//平邮 
			if($this->_input['postage_ordinary'] == '1'){
				$postage_ordinary = array(
										'default'=>array(
											'default'=>$this->_input['default_ordinary'],
											'default_up'=>$this->_input['default_up_ordinary']
										),
									);
			}
			//快递
			if($this->_input['postage_fast'] == '1'){
				$postage_fast = array(
										'default'=>array(
											'default'=>$this->_input['default_fast'],
											'default_up'=>$this->_input['default_up_fast']
										),
									);
			}
			//ems
			if($this->_input['postage_ems'] == '1'){
				$postage_ems = array(
										'default'=>array(
											'default'=>$this->_input['default_ems'],
											'default_up'=>$this->_input['default_up_ems']
										),
									);
			}
			
			$ordinary_input_array = array();
			$fast_input_array = array();
			$ems_input_array = array();
			foreach ($this->_input as $k => $v){
				//ordinary_area_name
				if($this->_input['postage_ordinary'] == '1' && substr($k,0,18) == 'ordinary_area_name'){
					$num = substr($k,-1);
					/**
					 * 判断是否已存在同地区的运费，如果存在，那么不重新计算
					 */
					$check = $this->check_repeat_postage($postage_ordinary,$v);
					if($check === false){
						$postage_ordinary[] = array($v,$this->_input['ordinary_area_postage_'.$num],$this->_input['ordinary_area_postage_up_'.$num]);
					}
				}
				//fast_area_name
				if($this->_input['postage_fast'] == '1' && substr($k,0,14) == 'fast_area_name'){
					$num = substr($k,-1);
					/**
					 * 判断是否已存在同地区的运费，如果存在，那么不重新计算
					 */
					$check = $this->check_repeat_postage($postage_fast,$v);
					if($check === false){
						$postage_fast[] = array($v,$this->_input['fast_area_postage_'.$num],$this->_input['fast_area_postage_up_'.$num]);
					}
				}
				//ems_area_name
				if($this->_input['postage_ems'] == '1' && substr($k,0,13) == 'ems_area_name'){
					$num = substr($k,-1);
					/**
					 * 判断是否已存在同地区的运费，如果存在，那么不重新计算
					 */
					$check = $this->check_repeat_postage($postage_ems,$v);
					if($check === false){
						$postage_ems[] = array($v,$this->_input['ems_area_postage_'.$num],$this->_input['ems_area_postage_up_'.$num]);
					}
				}
			}
			/**
			 * 判断三种类型是否都没有选择
			 */
			if (empty($postage_ordinary) && empty($postage_fast) && empty($postage_ems)){
				$this->redirectPath("error","",$this->_lang['errPostageSelEmpty']);
			}
			/**
			 * 入数据库
			 */
			$value_array = array();
			$value_array['postage_id'] = $this->_input['postage_id'];
			$value_array['member_id'] = $_SESSION['s_login']['id'];
			$value_array['postage_title'] = $this->_input['postage_title'];
			$value_array['postage_content'] = $this->_input['postage_content'];
			if (!empty($postage_ordinary)){
				$value_array['postage_ordinary'] = serialize($postage_ordinary);
			}else {
				$value_array['postage_ordinary'] = '';
			}
			if (!empty($postage_fast)){
				$value_array['postage_fast'] = serialize($postage_fast);
			}else {
				$value_array['postage_fast'] = '';
			}
			if (!empty($postage_ems)){
				$value_array['postage_ems'] = serialize($postage_ems);
			}else {
				$value_array['postage_ems'] = '';
			}
			$value_array['postage_update_time'] = time();
			//
			$result = $this->obj_postage->updatePostage($value_array);
			/**
			 * 返回到商品添加修改选择运费模板的页面
			 */
			if ($this->_input['product_sel'] == '1'){
				@header('location: ./own_postage.php?action=sel_postage');
			}else {
				if($result === true){
					$this->redirectPath('succ','./member/own_postage.php?action=list',$this->_lang['langPostageModiSucc']);
				}else {
					$this->redirectPath('error','',$this->_lang['errPostageModiFail']);
				}
			}
		}
	}
	
	/**
	 * 删除
	 */
	function _del(){
		if (is_array($this->_input['postage_id'])){
			foreach ($this->_input['postage_id'] as $v) {
				$condition = " and member_id='". $_SESSION['s_login']['id'] ."'";
				$result = $this->obj_postage->delPostage($v);
				if ($result !== true) {
					$this->redirectPath("error","",$this->_lang['errPostageDelFail']);
				}
			}
			$this->redirectPath("succ","./member/own_postage.php?action=list",$this->_lang['langPostageDelSucc']);
		}else if (intval($this->_input['postage_id']) > 0){
			/**
			 * 删除
			 */
			$condition = " and member_id='". $_SESSION['s_login']['id'] ."'";
			$result = $this->obj_postage->delPostage(intval($this->_input['postage_id']),$condition);
			/**
			 * 返回到商品添加修改选择运费模板的页面
			 */
			if ($this->_input['product_sel'] == '1'){
				@header('location: ./own_postage.php?action=sel_postage');
			}else {
				if ($result !== true) {
					$this->redirectPath("error","",'error');
				}else {
					$this->redirectPath("succ","./member/own_postage.php?action=list",$this->_lang['langPostageDelSucc']);
				}
			}
		}else {
			$this->redirectPath("error","",$this->_lang['errPostageDelIsEmpty']);
		}
	}
	
	/**
	 * 添加修改商品选择运费
	 */
	function _sel_postage(){
		$condition['member_id'] = $_SESSION['s_login']['id'];
		$postage_list = $this->obj_postage->listPostage($condition,$this->obj_page);
		/**
		 * 处理数据
		 */
		if (is_array($postage_list)){
			foreach ($postage_list as $k => $v){
				$postage_list[$k]['postage_update_time'] = date("Y-m-d H:i:s",$v['postage_update_time']);
				$postage_list[$k]['postage_ordinary'] = $v['postage_ordinary']?unserialize($v['postage_ordinary']):$v['postage_ordinary'];
				$postage_list[$k]['postage_fast'] = $v['postage_fast']?unserialize($v['postage_fast']):$v['postage_fast'];
				$postage_list[$k]['postage_ems'] = $v['postage_ems']?unserialize($v['postage_ems']):$v['postage_ems'];
			}
		}
		/**
		 * 输出地区 只包括一级
		 */
		$array = Common::getAreaCache('');
		$sel_area = array();
		if (is_array($array)){
			foreach ($array as $k => $v){
				if($v[1] == '0'){
					$sel_area[] = $v;
				}
			}
		}
		/**
		 * 模板输出
		 */
		$this->output('sel_area',$sel_area);
		$this->output('postage_list',$postage_list);
		$this->showpage('own_postage.sel',false);
	}

	/**
	 * 检查是否已存在相同内容的运费
	 */
	function check_repeat_postage($postage_list,$area_list){
		if(is_array($postage_list)){
			//数组第一个为地区内容
			foreach($postage_list as $k => $v){
				if($v[0] == $area_list){
					return true;
				}
			}
			return false;
		}else{
			return false;
		}
	}
}
$postage = new OwnPostage();
$postage->main();
unset($postage);
?>
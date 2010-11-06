<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想分销王系统 项目的一部分
//
// Copyright (c) 2007 - 2009 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
* FILE_NAME : admin_goods_class.php D:\root\shopnc6_jh\system\admin_goods_class.php
* 商品分类操作
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:36:16 CST 2009
*/
require ("../shop.global.inc.php");
class ShopGoodsClassIndex extends ShopSystemFrameWork {
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	private $obj_goods;
	/**
	 * 语言包对象
	 *
	 * @var obj
	 */
	private $obj_module_language;
	/**
	 * 商品分类对象
	 *
	 * @var obj
	 */
	private $obj_goods_class;
	/**
	 * 商品类型/属性对象
	 *
	 * @var obj
	 */
	private $obj_goods_type;
	/**
	 * 日志对象
	 *
	 * @var obj
	 */
	private $obj_log;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	private $obj_validate;

	function main(){
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_goods)) {
			require_once("shopGoods.class.php");
			$this->obj_goods = new ShopGoodsClass();
		}
		/**
		 * 创建商品类型对象
		 */
		if (!is_object($this->obj_goods_type)) {
			require_once("shopGoodsType.class.php");
			$this->obj_goods_type = new ShopGoodsTypeClass();
		}
		/**
		 * 创建语言包对象
		 */
		if (!is_object($this->obj_module_language)) {
			require_once("moduleLanguage.class.php");
			$this->obj_module_language = new ModuleLanguageClass();
		}
		/**
		 * 创建商品分类对象
		 */
		if (!is_object($this->obj_goods_class)) {
			require_once("shopGoodsClass.class.php");
			$this->obj_goods_class = new ShopGoodsClassClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->obj_validate)){
			require_once("commonvalidate.class.php");
			$this->obj_validate = new CommonValidate();
		}
		/**
		 * 创建日志对象
		 */
		if (!is_object($this->obj_log)){
			require_once("shopToolLog.class.php");
			$this->obj_log = new ShopToolLogClass();
		}
		/**
		 * 语言包
		 */
		$this->getlang("shop_admin_goods,shop_admin_menu");
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("system/templates");

		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case 'page_goods_class':		//添加商品分类
			$this->addGoodsClass();
			break;
			case 'save':					//保存商品分类
			$this->saveGoodsClass();
			break;
			case 'move':					//转移分类
			$this->moveGoodsClass();
			break;
			case 'del':						//删除分类
			$this->delGoodsClass();
			break;
			case 'list':					//商品分类列表
			$this->listGoodsClass();
			break;
			case 'class_ajax':				//ajax改变状态
			$this->updateClassAjax();
			break;
			default:
			$this->listGoodsClass();
			break;
		}
	}
	/**
	 * 添加商品分类
	 *
	 */
	private function addGoodsClass() {
		$this->checkAdmin('goods_class_add');
		
		$ProductClassArray = $this->obj_goods_class->listClassDetail();
		$class_value = "";
		$state_value = array(1);
		$menu_value = array(0);
		$language_selected	= '';
		$goods_type_id	= '';
		/*商品类型列表*/
		$type_array	= $this->obj_goods_type->getGoodsTypeArray();
		$goods_type_select = array();
		foreach ($type_array as $v) {
			$goods_type_select[$v['goods_type_id']]	= $v['goods_type_name'];
		}

		if ($this->_input['type'] == "sub") {
			$class_value = intval($this->_input['cid']);
		}
		if ($this->_input['type'] == "modify") {
			$class = $this->obj_goods_class->getGoodsClassInfo(array("class_id"=>intval($this->_input['cid'])));
			$class_value = $class['class_top_id'];
			$state_value = array($class['class_state']);
			$menu_value = array($class['class_menu']);
			$language_selected	= $class['class_language'];
			$goods_type_id	= $class['goods_type_id'];
			$this->output("class",$class);
		}
		//分类下拉菜单
		$this->output("txt_class_top_id",Common::showForm_Select2("txt_class_top_id","","",$ProductClassArray,$class_value,$this->_lang['admin_goods_class_select']));
		//是否发布
		$this->output("txt_class_state",Common::Input("txt_class_state","radio",array("1"=>$this->_lang['admin_goods_class_yes'],"0"=>$this->_lang['admin_goods_class_no']),$state_value));
		/*商品类型*/
		$this->output('type_select',Common::Select('txt_goods_type_id',$goods_type_select,$this->_lang['admin_goods_class_select'],$goods_type_id));
		$this->output("language_select",Common::Select('txt_class_language',$language_select,$this->_lang['admin_goods_class_select'],$language_selected));
		$this->showpage('goods_class_add');
	}
	/**
	 * 保存商品分类
	 *
	 */
	private function saveGoodsClass(){
		$this->checkAdmin('goods_class_add');
		
		$input_param['txt_class_top_id']		= intval($this->_input['txt_class_top_id']);    //父级分类id
		$input_param['txt_class_name']			= trim($this->_input['txt_class_name']);        //分类名称
		$input_param['txt_class_state']			= intval($this->_input['txt_class_state']);     //分类状态0、开启1、关闭
		$input_param['txt_class_keywords']		= trim($this->_input['txt_class_keywords']);    //分类关键字
		$input_param['txt_class_description']	= trim($this->_input['txt_class_description']); //分类描述
		$input_param['txt_class_sort']			= intval($this->_input['txt_class_sort']);      //分类排序
		$input_param['txt_class_language']		= intval($this->_input['txt_class_language']);  //分类语言显示
		$input_param['txt_class_url']			= trim($this->_input['txt_class_url']);         //分类指向的url外联
		$input_param['txt_class_menu']			= intval($this->_input['txt_class_menu']);      //是否导航显示
		$input_param['txt_class_language']		= intval($this->_input['txt_class_language']);  //选择语言
		$input_param['txt_goods_type_id']		= intval($this->_input['txt_goods_type_id']);   //商品类型
		$input_param['txt_modify_sub']			= intval($this->_input['modify_sub']);		  	//修改范围
		$input_param['txt_class_attr']			= serialize(array_filter($this->_input['txt_class_attr'],'htmlspecialchars'));	//序列化特殊属性

		/**
		 * 验证注册信息
		 */

		$this->obj_validate->setValidate(array("input"=>$input_param['txt_class_name'],"require"=>"true","message"=>$this->_lang['admin_goods_class_name_is_null']));   //分类名称不能为空
		$error = $this->obj_validate->validate();
		if ($error != "" ){
			//返回错误信息
			$this->adminMessage($error,$this->_configinfo['websit']['site_url']."/system/admin_goods_class.php?action=page_goods_class",1,1000);
		}
		else {
			if ($this->_input['class_id'] != "") {
				$class_id			= intval($this->_input['class_id']);

				//检查修改的分类topid是否是当前分类的下级，如果是返回错误，不是的话，正常进行
				$productClassArray	= $this->obj_goods_class->listClassDetail("");
				$class_top_id		= $input_param['txt_class_top_id'];
				$sub_class			= $this->obj_goods_class->getArrayById($productClassArray,$result,$class_id);
				$sub_class[]		= $class_id;
				if ($sub_class!=null) {
					if (in_array($class_top_id,$sub_class)) {
						$this->adminMessage($this->_lang['admin_goods_class_list_move_error'],$this->refer_url,1,3000);
					}
				}

				$rs = $this->obj_goods_class->modifyGoodsClass($input_param,$class_id);
			}
			else {
				$rs = $this->obj_goods_class->addGoodsClass($input_param);
			}

			if ($rs) {
				$this->obj_goods_class->createGoodsClassArray();

				/*日志保存*/
				$log_array				= array();
				$log_array['log_info']	= $this->_lang['admin_goods_class_save_ok'];
				$this->obj_log->inLog($log_array);

				$this->adminMessage($this->_lang['admin_goods_class_save_ok'],$this->_configinfo['websit']['site_url']."/system/admin_goods_class.php?action=list",1,1000);
			}
			else {
				/*日志保存*/
				$log_array				= array();
				$log_array['log_info']	= $this->_lang['admin_goods_class_save_false'];
				$this->obj_log->inLog($log_array);

				$this->adminMessage($this->_lang['admin_goods_class_save_false'],$this->_configinfo['websit']['site_url']."/system/admin_goods_class.php?action=page_goods_class",1,4000);
			}
		}
	}
	/**
	 * 商品分类列表
	 *
	 */
	private function listGoodsClass() {
		$this->checkAdmin('check_nologin');
		
		$productClassArray = $this->obj_goods_class->listClassDetail("");
		//分类下拉菜单
		$selectClassArray = $this->obj_goods_class->listClassDetail();

		$class_array = array();
		foreach ($productClassArray as $productClass) {
			$goods_class_array = array();
			//得到商品分类信息
			$goods_class_array = $this->obj_goods_class->getGoodsClassInfo(array("class_id"=>$productClass['id']));
			//查出所有子集分类
			$sub_class = $this->obj_goods_class->getArrayById($productClassArray,$result,$productClass['id']);
			$productClass['sub_class'] = @implode(",",$sub_class);
			//查出下一级分类
			$sub_one_class = $this->obj_goods_class->getOneArrayById($productClassArray,$result,$productClass['id']);
			$productClass['sub_one_class'] = @implode(",",$sub_one_class);
			$productClass['class_state'] = $goods_class_array['class_state'];
			$productClass['class_sort'] = $goods_class_array['class_sort'];
			$productClass['class_menu'] = $goods_class_array['class_menu'];

			$goods_array = $this->obj_goods->getGoodsList(array("class_id"=>$productClass['id']),'');

			$productClass['goods_count'] = count($goods_array);
			$productClass['header'] = "";
			for ($i=0;$i<$productClass[4];$i++){
				$productClass['header'] .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			$productClass['class_top_id'] = Common::showForm_Select2("txt_class_top_id".$productClass['id'],"","",$selectClassArray,"");
			$productClass['class_top_id_2'] = Common::showForm_Select2("txt_class_top_id".$productClass['id']."_2","","",$selectClassArray,"");
			$class_array[]=$productClass;
			$i++;
		}
		$this->output("class_array",$class_array);
		$this->showpage('goods_class');
	}
	/**
	 *  移动商品分类中的商品
	 *
	 */
	private function moveGoodsClass(){
		$this->checkAdmin('goods_class_move');
		
		$class_id = $this->_input['id'];
		$class_top_id = $this->_input['txt_class_top_id'.$class_id];
		if ($class_top_id == 0) {
			$this->adminMessage($this->_lang['admin_goods_class_list_select_error'],$this->_configinfo['websit']['site_url']."/system/admin_goods_class.php?action=list",1,1000);
		}
		$productClassArray = $this->obj_goods_class->listClassDetail("");
		//查出所有子集分类
		$sub_class = $this->obj_goods_class->getArrayById($productClassArray,$result,$class_id);

		$sub_class[] = $class_id;
		$sub_class_string = @implode(",",$sub_class);
		$input_param['class_id'] = intval($class_top_id);
		$rs = $this->obj_goods->moveGoods($input_param,array("more_id"=>$sub_class_string));//modifyGoodsClass($input_param,$class_id,"move");
		if ($rs) {
			$this->obj_goods_class->createGoodsClassArray();
			$this->adminMessage($this->_lang['admin_goods_oper_succ'],$this->_configinfo['websit']['site_url']."/system/admin_goods_class.php?action=list",1,1000);
		}
		else {
			$this->adminMessage($this->_lang['admin_goods_oper_fill'],$this->_configinfo['websit']['site_url']."/system/admin_goods_class.php?action=page_goods_class",1,4000);
		}
	}
	/**
	 * 删除商品分类
	 *
	 */
	private function delGoodsClass(){
		$this->checkAdmin('goods_class_move');

		$class_id = intval($this->_input['id']);
		$select_value = intval($this->_input['select']);
		$productClassArray = $this->obj_goods_class->listClassDetail("");
		switch ($select_value) {
			case 1:// 删除当前分类包括当前分类的子分类和商品
			//查出所有子集分类
			$sub_class = $this->obj_goods_class->getArrayById($productClassArray,$result,$class_id);
			$sub_class[] = $class_id;
			$rs = $this->obj_goods_class->delGoodsClass($sub_class,"class_id");
			if ($rs) {
				$rs = $this->obj_goods->delGoods($sub_class,"class_id");
				if ($rs) {
					$this->obj_goods_class->createGoodsClassArray();

					/*日志保存*/
					$log_array				= array();
					$log_array['log_info']	= $this->_lang['admin_goods_class_goods_del_ok'];
					$this->obj_log->inLog($log_array);

					$this->adminMessage($this->_lang['admin_goods_class_goods_del_ok'],$this->_configinfo['websit']['site_url']."/system/admin_goods_class.php?action=list",1,1000);
				}
				else {
					/*日志保存*/
					$log_array				= array();
					$log_array['log_info']	= $this->_lang['admin_goods_class_goods_del_false'];
					$this->obj_log->inLog($log_array);

					$this->adminMessage($this->_lang['admin_goods_class_goods_del_false'],$this->_configinfo['websit']['site_url']."/system/admin_goods_class.php?action=list",1,1000);
				}
			}
			else {
				/*日志保存*/
				$log_array				= array();
				$log_array['log_info']	= $this->_lang['admin_goods_class_goods_del_false'];
				$this->obj_log->inLog($log_array);

				$this->adminMessage($this->_lang['admin_goods_class_goods_del_false'],$this->_configinfo['websit']['site_url']."/system/admin_goods_class.php?action=list",1,1000);
			}

			break;
			case 2://删除当前分类，移动子分类和商品
			
			$class_top_id = $this->_input['txt_class_top_id'.$class_id."_2"];
			if ($class_top_id == 0) {
				$this->adminMessage($this->_lang['admin_goods_class_list_select_error'],$this->_configinfo['websit']['site_url']."/system/admin_goods_class.php?action=list",1,1000);
			}
			$input_param['class_top_id'] = intval($class_top_id);
			$sub_one_class	= $this->obj_goods_class->getArrayById($productClassArray,$result,$class_id);

			/* 检查修改的分类topid是否是当前分类的下级，如果是返回错误，不是的话，正常进行 */
			$sub_one_class[]	= $class_id;
			if ($sub_one_class!=null) {
				if (in_array($class_top_id,$sub_one_class)) {
					$this->adminMessage($this->_lang['admin_goods_class_list_del_error1'],$this->refer_url,1,3000);
				}
			}
			/* 查出下一级分类 */
			$sub_one_class	= array();
			$sub_one_class	= $this->obj_goods_class->getOneArrayById($productClassArray,$result,$class_id);
			$sub_one_class_string = empty($sub_one_class) ? $class_id : @implode(",",$sub_one_class).','.$class_id;
			/* 移动子类 */
			$update_class = $this->obj_goods_class->modifyMoreGoodsClass($input_param,array("more_id"=>$sub_one_class_string));
			/* 移动当前类商品 */
			$update_goods = $this->obj_goods->modifyGoods($class_top_id,$class_id,"class_id","class_id");
			/* 删除当前类 */
			$input['class_id'] = $class_id;
			$del_goods_class = $this->obj_goods_class->delGoodsClass($input,"class_id");
			if ($del_goods_class) {
				$this->obj_goods_class->createGoodsClassArray();
				$this->adminMessage($this->_lang['admin_goods_oper_succ'],$this->_configinfo['websit']['site_url']."/system/admin_goods_class.php?action=list",1,1000);
			}
			break;
			case 3://删除当前分类和子分类，只移动商品
			$class_top_id = $this->_input['txt_class_top_id'.$class_id."_2"];
			if ($class_top_id == 0) {
				$this->adminMessage($this->_lang['admin_goods_class_list_select_error'],$this->_configinfo['websit']['site_url']."/system/admin_goods_class.php?action=list",1,1000);
			}

			//查出所有子集分类
			$sub_class = $this->obj_goods_class->getArrayById($productClassArray,$result,$class_id);
			$sub_class[] = $class_id;

			/* 检查修改的分类topid是否是当前分类的下级，如果是返回错误，不是的话，正常进行 */
			if ($sub_class!=null) {
				if (in_array($class_top_id,$sub_class)) {
					$this->adminMessage($this->_lang['admin_goods_class_list_del_error'],$this->refer_url,1,3000);
				}
			}	
			$sub_class_string = @implode(",",$sub_class);
			$rs = $this->obj_goods_class->delGoodsClass($sub_class,"class_id");
			if ($rs) {

				$input_param['class_id'] = $class_top_id;
				$this->obj_goods->moveGoods($input_param,array("more_id"=>$sub_class_string));
				$this->obj_goods_class->createGoodsClassArray();
				$this->adminMessage($this->_lang['admin_goods_oper_succ'],$this->_configinfo['websit']['site_url']."/system/admin_goods_class.php?action=list",1,1000);

			}
			else {
				$this->adminMessage($this->_lang['admin_goods_oper_fill'],$this->_configinfo['websit']['site_url']."/system/admin_goods_class.php?action=list",1,4000);
			}
			break;
		}
	}
	private function updateClassAjax() {
		$this->checkAdmin('goods_class_add');
		
		if(!in_array($this->_input['ajax_type'],array('class_state')) and intval($this->_input['class_id'])<= 0 ) {
			return '';
		}
		$goods_id	= intval($this->_input['class_id']);
		$array	= array('ajax_type'=>trim($this->_input['ajax_type']),'class_id'=>intval($this->_input['class_id']),'old_state'=>$this->_input['old_state']);
		$img_state = $this->obj_goods_class->ajaxClassUpdate($array);
		echo '<a onclick="nc_state_update(\''.$class_id.'\',\''.trim($this->_input['ajax_type']).'\',\''.$img_state.'\',\''.trim($this->_input['css_id']).'\')"><img src="templates/images/icon_'.$img_state.'.gif" alt="'.$this->_lang['admin_goods_class_click_update'].'" /></a>';
	}
}
$goods_class = new ShopGoodsClassIndex();
$goods_class->main();
unset($goods_class);
?>
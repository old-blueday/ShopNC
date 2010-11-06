<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想多用户商城 项目的一部分
//
// Copyright (c) 2007 - 2009 www.shopnc.net 
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : credits_act.manage.php
 * ....积分活动
 *
 * @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Sat Jun 06 15:41:21 CST 2009
 */

require_once("../../global.inc.php");

class SysCreditsActClass extends SystemFrameWork {
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	/**
	 * 积分活动对象
	 *
	 * @var obj
	 */
	var $obj_credits_act;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $obj_validate;
	/**
	 * 上传对象
	 *
	 * @var obj
	 */
	var $obj_upload;
	/**
	 * 水印对象
	 *
	 * @var obj
	 */
	var $obj_gd;
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $obj_member;
	/**
	 * 应用内容
	 *
	 * @var obj
	 */
	var $default_app_array;
	/**
	 * 应用对象
	 *
	 * @var obj
	 */
	var $obj_app_class;
	
	function SysCreditsActClass(){
		$this->__construct();
	}
	function __construct(){
		//初始化信息
		$this->default_app_array = $this->constructAppModule('credits_act','system','system');
		/**
		 * 模板输出
		 */
		$this->output('app_module',$this->default_app_array);
	}
	
	function main(){
		/**
		 * 创建分页对象
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		/**
		 * 创建积分活动对象
		 */
		if (!is_object($this->obj_credits_act)){
			require_once("credits_act.class.php");
			$this->obj_credits_act = new CreditsActClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->obj_validate)){
			require_once("commonvalidate.class.php");
			$this->obj_validate = new CommonValidate();
		}
		/**
		 * 创建上传对象
		 */
		if (!is_object($this->obj_upload)){
			require_once("uploadfile.class.php");
			$this->obj_upload = new UploadFile();
			$this->obj_upload->error_msg_type = 1;
			$this->obj_upload->allow_type = explode(',',$this->_configinfo['file']['allowuploadimagetype']);
		}
		/**
		 * 创建水印对象
		 */
		if ($this->_configinfo['gdimage']['wm_image_sign'] == 1 && file_exists(BasePath.'/'.$this->_configinfo['gdimage']['wm_image_name'])) {
			if (!is_object($this->obj_gd)){
				require_once ("gdimage.class.php");
				$this->obj_gd = new GDImage();
			}
			$this->obj_gd->wm_image_transition = $this->_configinfo['gdimage']['wm_image_transition'];//透明度
			$this->obj_gd->wm_image_pos = $this->_configinfo['gdimage']['wm_image_pos'];//位置
			$this->obj_gd->wm_image_name = BasePath.'/'.$this->_configinfo['gdimage']['wm_image_name'];//水印图片
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->obj_member)){
			require_once("member.class.php");
			$this->obj_member = new MemberClass();
		}
		/**
		 * 创建应用对象
		 */
		if (!is_object($this->obj_app_class)){
			require_once("app_module.class.php");
			$this->obj_app_class = new AppModuleClass();
		}
		
		switch($this->_input['action']){
			case "ajax_list":
				$this->_ajax_list();
				break;
			case 'add':
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
			case 'msg_list':
				$this->_msg_list();
				break;
			case 'msg_modi_page':
				$this->_msg_modi_page();
				break;
			case 'msg_update':
				$this->_msg_update();
				break;
			case 'msg_re_page':
				$this->_msg_re_page();
				break;
			case 'msg_re':
				$this->_msg_re();
				break;
			case 'msg_del':
				$this->_msg_del();
				break;
			case 'apply_list':
				$this->_apply_list();
				break;
			case 'apply_audit':
				$this->_apply_audit();
				break;
			case 'apply_audit_update':
				$this->_apply_audit_update();
				break;
			case 'manage_modi':
				$this->_manage_modi();
				break;
			case 'manage_update':
				$this->_manage_update();
				break;
			case 'setup':
				$this->_setup();
				break;
			case 'setup_save':
				$this->_setup_save();
				break;
			case 'unsetup':
				$this->_unsetup();
				break;
			case 'unsetup_save':
				$this->_unsetup_save();
				break;
		}
	}
	
	/**
	 * 列表
	 */
	function _ajax_list(){
		//过滤过期活动
		$this->obj_credits_act->updateCreditsActEndTime();
		
		$condition['order_by'] = 'ca_end_time desc';
		$this->obj_page->pagebarnum(12);
		$this->obj_page->nowindex = $this->_input['curpage']?$this->_input['curpage']:1;
		$act_list = $this->obj_credits_act->getCreditsActList($condition,$this->obj_page);
		$page_list = $this->obj_page->show(2);
		if (is_array($act_list)){
			foreach ($act_list as $k => $v){
				$act_list[$k]['ca_end_time'] = date('Y-m-d',$v['ca_end_time']);
			}
		}
		/**
		 * 页面输出
		 */
		$this->output("curpage", $this->obj_page->nowindex);
		$this->output('page_list',$page_list);
		$this->output('act_list',$act_list);
		$this->showpage('sys_credits_act.list');
	}
	
	/**
	 * 新增活动
	 */
	function _add(){
		/**
		 * 页面输出
		 */
		$this->output("curpage", $this->_input['curpage']?$this->_input['curpage']:1);
		$this->showpage('sys_credits_act.add');
	}
	
	/**
	 * 保存活动
	 */
	function _save(){
		$this->obj_validate->setValidate(array("input"=>$this->_input['ca_title'],"require"=>"true","message"=>$this->_lang['errSysCATitleIsEmpty']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['ca_end_time'],"require"=>"true","message"=>$this->_lang['errSysCAEntTimeIsEmpty']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['ca_content'],"require"=>"true","message"=>$this->_lang['errSysCAContentIsEmpty']));
		$error = $this->obj_validate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error,1);
		}else{
			//检查图片类别，数量，积分，名称
			$this->_check_param();
			//入库
			$line = explode('-',$this->_input['ca_end_time']);
			$line = mktime(23,59,59,$line[1],$line[2],$line[0]);
			$now_time = time();
			$value_array = array();
			$value_array['ca_title'] = $this->_input['ca_title'];
			$value_array['ca_content'] = $this->_input['ca_content'];
			$value_array['ca_add_time'] = $now_time;
			$value_array['ca_end_time'] = $line;
			$result = $this->obj_credits_act->addCreditsAct($value_array);
			if ($result === true){
				$condition['ca_add_time'] = $now_time;
				$condition['ca_end_time'] = $line;
				$condition['ca_member_id'] = '0';
				$act_list = $this->obj_credits_act->getCreditsActList($condition,$obj_page);
				if ($act_list[0]['ca_id'] != ''){
					if (is_array($this->_input['product_name'])){
						foreach ($this->_input['product_name'] as $k => $v) {
							//上传图片
							$filename = $this->_upload_goods_pic('product_pic_'.$k);
							//入库
							$goods_array = array();
							$goods_array['ca_id'] = $act_list[0]['ca_id'];
							$goods_array['cag_name'] = $v;
							$goods_array['cag_pic'] = $filename["getfilename"];
							$goods_array['cag_num'] = intval($this->_input['product_num'][$k]);
							$goods_array['cag_credits'] = intval($this->_input['product_credits'][$k]);
							$this->obj_credits_act->addCreditsActGoods($goods_array);
							unset($goods_array);
						}
					}
				}
				//记录操作日志
				SystemPowerClass::addSysLog($this->_lang['langSysCALogAdd']);
				$this->redirectPath("error","",$this->_lang['langSysCAAddSucc'],1);
			}else {
				$this->redirectPath("error","",$this->_lang['errSysCAAddFail'],1);
			}
		}
	}
	
	/**
	 * 检测上传图片的类型是否正确
	 */
	function _check_param(){
		//验证文件类型
		if (is_array($this->_input['product_name'])){
			foreach ($this->_input['product_name'] as $k => $v) {
				//名称
				if ($v == ''){
					$this->redirectPath("error","",$this->_lang['errSysCAGoodsNameIsEmpty'],1);
				}
				//数量
				if (!is_numeric($this->_input['product_num'][$k]) || intval($this->_input['product_num'][$k]) <= 0){
					$this->redirectPath("error","",$this->_lang['errSysCAGoodsNumMustBeNumber'],1);
				}
				//积分
				if (!is_numeric($this->_input['product_credits'][$k]) || intval($this->_input['product_credits'][$k]) <= 0){
					$this->redirectPath("error","",$this->_lang['errSysCAGoodsCreditsMustBeNumber'],1);
				}
				//图片
				if (isset($_FILES['product_pic_'.$k]['name']) && $_FILES['product_pic_'.$k]['name'] != ''){
					$pic_type = explode('.',$_FILES['product_pic_'.$k]['name']);
					if (!in_array($pic_type[count($pic_type)-1],explode(',',$this->_configinfo['file']['allowuploadimagetype']))){
						$this->redirectPath("error","",$this->_lang['errSysCAGoodsPicTypeIsWrong'].$this->_configinfo['file']['allowuploadimagetype'],1);
					}
				}
			}
		}
		return true;
	}
	
	/**
	 * 修改
	 */
	function _modi(){
		$this->obj_validate->setValidate(array("input"=>$this->_input['id'],"require"=>"true","validator"=>"Number","message"=>$this->_lang['langSysCIDErr']));
		$error = $this->obj_validate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error,1);
		}else{
			$act_row = $this->obj_credits_act->getCreditsActRow($this->_input['id']);
			if (empty($act_row)){
				$this->redirectPath("error","",$this->_lang['langSysCIDErr'],1);
			}
			$act_row['ca_end_time'] = date('Y-m-d',$act_row['ca_end_time']);
			//商品
			$condition['ca_id'] = $this->_input['id'];
			$act_goods_list = $this->obj_credits_act->getCreditsActGoodsList($condition,$page);
			/**
			 * 页面输出
			 */
			$this->output("curpage", $this->_input['curpage']);
			$this->output('act_row',$act_row);
			$this->output('act_goods_list',$act_goods_list);
			$this->showpage('sys_credits_act.modi');
		}
	}
	
	/**
	 * 更新活动信息
	 */
	function _update(){
		$this->obj_validate->setValidate(array("input"=>$this->_input['ca_id'],"require"=>"true","validator"=>"Number","message"=>$this->_lang['langSysCIDErr']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['ca_title'],"require"=>"true","message"=>$this->_lang['errSysCATitleIsEmpty']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['ca_end_time'],"require"=>"true","message"=>$this->_lang['errSysCAEntTimeIsEmpty']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['ca_content'],"require"=>"true","message"=>$this->_lang['errSysCAContentIsEmpty']));
		$error = $this->obj_validate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error,1);
		}else{
			//检查图片类别，数量，积分，名称
			$this->_check_param();
			//入库
			$line = explode('-',$this->_input['ca_end_time']);
			$line = mktime(23,59,59,$line[1],$line[2],$line[0]);
			$value_array = array();
			$value_array['ca_id'] = $this->_input['ca_id'];
			$value_array['ca_title'] = $this->_input['ca_title'];
			$value_array['ca_content'] = $this->_input['ca_content'];
			$value_array['ca_state'] = $line>time()?'0':'1';
			$value_array['ca_end_time'] = $line;
			$result = $this->obj_credits_act->updateCreditsAct($value_array);
			if ($result === true){
				if (is_array($this->_input['product_name'])){
					foreach ($this->_input['product_name'] as $k => $v) {
						if (!empty($this->_input['del_cag_id'][$k])){//删除
							$result = $this->obj_credits_act->delCreditsActGoods($this->_input['del_cag_id'][$k]);
							if ($result !== true){
								$this->redirectPath("error","",$this->_lang['errSysCADelGoodsFail'],1);
							}else {
								unset($result);
							}
						}else {
							//上传图片
							$filename = $this->_upload_goods_pic('product_pic_'.$k);
							//
							$goods_array = array();
							$goods_array['ca_id'] = $this->_input['ca_id'];
							$goods_array['cag_name'] = $v;
							if (!empty($filename["getfilename"])){
								$goods_array['cag_pic'] = $filename["getfilename"];
							}
							$goods_array['cag_num'] = intval($this->_input['product_num'][$k]);
							$goods_array['cag_credits'] = intval($this->_input['product_credits'][$k]);
							if ($this->_input['cag_id'][$k] != ''){
								$goods_array['cag_id'] = $this->_input['cag_id'][$k];
								//当有新图片上传，则删除以前的图片
								if ($goods_array['cag_pic'] != ''){
									$act_googds_row = $this->obj_credits_act->getCreditsActGoodsRow($this->_input['cag_id']);
									if (file_exists(BasePath.'/'.$act_googds_row['cag_pic'])){
										@unlink(BasePath.'/'.$act_googds_row['cag_pic']);
									}
								}
								//更新
								$this->obj_credits_act->updateCreditsActGoods($goods_array);
							}else {
								//添加
								$this->obj_credits_act->addCreditsActGoods($goods_array);
							}
							unset($goods_array);
						}
					}
				}
				//记录操作日志
				SystemPowerClass::addSysLog($this->_lang['langSysCALogUpdate']);
				$this->redirectPath("error","",$this->_lang['langSysCAUpdateSucc'],1);
			}else {
				$this->redirectPath("error","",$this->_lang['errSysCAUpdateFail'],1);
			}
		}
	}
	
	/**
	 * 上传商品图片
	 */
	function _upload_goods_pic($pic_name){
		if (isset($_FILES[$pic_name]['name']) && $_FILES[$pic_name]['name'] != ''){
			//上传商品图片
			$filename = $this->obj_upload->upfile($pic_name);
			if ($filename != false){
				//加水印
				if ($this->_configinfo['gdimage']['wm_image_sign'] == 1 && file_exists(BasePath.'/'.$this->_configinfo['gdimage']['wm_image_name'])) {
					//图片名
					$this->obj_gd->save_file = BasePath.'/'.$filename["getfilename"];
					$this->obj_gd->create(BasePath.'/'.$filename["getfilename"]);
				}
			}
			
			return $filename;
		}else {
			return false;
		}
	}
	
	/**
	 * 删除活动
	 */
	function _del(){
		if (is_array($this->_input['ca_id'])){
			foreach ($this->_input['ca_id'] as $v) {
				$value_array = array();
				$value_array['ca_id'] = $v;
				$value_array['ca_del'] = '1';
				$result = $this->obj_credits_act->updateCreditsAct($value_array);
				if ($result !== true) {
					$this->redirectPath("error","",$this->_lang['errSysCADelFail'],1);
				}
			}
			//记录操作日志
			SystemPowerClass::addSysLog($this->_lang['langSysCALogDel']);
			$this->redirectPath("error","",$this->_lang['langSysCADelSucc'],1);
		}else {
			$this->redirectPath("error","",$this->_lang['errSysCADelIsEmpty'],1);
		}
	}
	
	/**
	 * 活动留言管理
	 */
	function _msg_list(){
		$this->obj_validate->setValidate(array("input"=>$this->_input['id'],"require"=>"true","validator"=>"Number","message"=>$this->_lang['langSysCIDErr']));
		$error = $this->obj_validate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error,1);
		}else{
			//留言列表
			$condition_msg['ca_id'] = $this->_input['id'];
			$this->obj_page->pagebarnum(12);
			$this->obj_page->nowindex = $this->_input['curpage']?$this->_input['curpage']:1;
			$msg_list = $this->obj_credits_act->getCreditsActMsgList($condition_msg,$this->obj_page);
			$page_list = $this->obj_page->show(2);
			if (is_array($msg_list)){
				foreach ($msg_list as $k => $v){
					$msg_list[$k]['cam_time'] = date('Y-m-d',$v['cam_time']);
				}
			}
			/**
			 * 页面输出
			 */
			$this->output('ca_id',$this->_input['id']);
			$this->output("curpage",$this->obj_page->nowindex);
			$this->output('page_list',$page_list);
			$this->output('msg_list',$msg_list);
			$this->showpage('sys_credits_act.msg_list');
		}
	}
	/**
	 * 修改留言信息页面
	 */
	function _msg_modi_page(){
		$msg_arr = $this->obj_credits_act->getCreditsActMsg($this->_input['id']);
		/**
		 * 页面输出
		 */
		$this->output('id',$this->_input['id']);
		$this->output('msg_arr',$msg_arr);
		$this->showpage('sys_credits_act.msg_modi');
	}
	/**
	 * 修改留言信息
	 */
	function _msg_update(){
		$this->obj_validate->setValidate(array("input"=>$this->_input['id'],"require"=>"true","validator"=>"Number","message"=>$this->_lang['langSysCIDErr']));
		$error = $this->obj_validate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error,1);
		}else{
			//更新
			$value_array = array();
			$value_array['cam_id'] = $this->_input['id'];
			$value_array['cam_content'] = $this->_input['cam_change_content'];
			$result = $this->obj_credits_act->updateCreditsActMsg($value_array);
			if ($result === true){
				$this->redirectPath("error","",$this->_lang['langSysCAMsgModiSucc'],1);
			}else {
				$this->redirectPath("error","",$this->_lang['errSysCAMsgModiFail'],1);
			}
		}
	}
	/**
	 * 回复留言信息页面
	 */
	function _msg_re_page(){
		$msg_arr = $this->obj_credits_act->getCreditsActMsg($this->_input['id']);
		/**
		 * 页面输出
		 */
		$this->output('id',$this->_input['id']);
		$this->output('msg_arr',$msg_arr);
		$this->showpage('sys_credits_act.msg_re');
	}
	/**
	 * 回复留言信息
	 */
	function _msg_re(){
		$this->obj_validate->setValidate(array("input"=>$this->_input['id'],"require"=>"true","validator"=>"Number","message"=>$this->_lang['langSysCIDErr']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['cam_re_content'],"require"=>"true","message"=>$this->_lang['errSysCAMsgReContentIsEmpty']));
		$error = $this->obj_validate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error,1);
		}else{
			//更新
			$value_array = array();
			$value_array['cam_id'] = $this->_input['id'];
			$value_array['cam_re'] = $this->_input['cam_re_content'];
			$result = $this->obj_credits_act->updateCreditsActMsg($value_array);
			if ($result === true){
				$this->redirectPath("error","",$this->_lang['langSysCAMsgReSucc'],1);
			}else {
				$this->redirectPath("error","",$this->_lang['errSysCAMsgReFail'],1);
			}
		}
	}
	
	/**
	 * 删除留言
	 */
	function _msg_del(){
		if (is_array($this->_input['cam_id'])){
			foreach ($this->_input['cam_id'] as $v) {
				$result = $this->obj_credits_act->delCreditsMsg($v);
				if ($result !== true) {
					$this->redirectPath("error","",$this->_lang['errSysCAMsgDelFail'],1);
				}
			}
			//记录操作日志
			SystemPowerClass::addSysLog($this->_lang['langSysCAMsgLogDel']);
			$this->redirectPath("error","",$this->_lang['langSysCAMsgDelSucc'],1);
		}else {
			$this->redirectPath("error","",$this->_lang['errSysCAMsgDelIsEmpty'],1);
		}
	}
	
	/**
	 * 申请列表
	 */
	function _apply_list(){
		$this->obj_validate->setValidate(array("input"=>$this->_input['id'],"require"=>"true","validator"=>"Number","message"=>$this->_lang['langSysCIDErr']));
		$error = $this->obj_validate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error,1);
		}else{
			//申请列表
			$condition_apply['ca_id'] = $this->_input['id'];
			$this->obj_page->pagebarnum(12);
			$this->obj_page->nowindex = $this->_input['curpage']?$this->_input['curpage']:1;
			$apply_list = $this->obj_credits_act->getCreditsActApplyList($condition_apply,$this->obj_page);
			$page_list = $this->obj_page->show(2);
			if (is_array($apply_list)){
				foreach ($apply_list as $k => $v){
					//申请时间
					$apply_list[$k]['caa_time'] = date('Y-m-d',$v['caa_time']);
					//状态
					switch ($v['caa_state']){
						case '0'://申请中
							$apply_list[$k]['state'] = $this->_lang['langSysCAApplyStateZero'];
							break;
						case '1'://已通过
							$apply_list[$k]['state'] = $this->_lang['langSysCAApplyStateOne'];
							break;
						case '2'://拒绝
							$apply_list[$k]['state'] = $this->_lang['langSysCAApplyStateTwo'];
							break;
					}
				}
			}
			/**
			 * 页面输出
			 */
			$this->output('ca_id',$this->_input['id']);
			$this->output("curpage", $this->obj_page->nowindex);
			$this->output('page_list',$page_list);
			$this->output('apply_list',$apply_list);
			$this->showpage('sys_credits_act.apply_list');
		}
	}
	
	/**
	 * 申请审核操作
	 */
	function _apply_audit(){
		$this->obj_validate->setValidate(array("input"=>$this->_input['id'],"require"=>"true","validator"=>"Number","message"=>$this->_lang['langSysCIDErr']));
		$error = $this->obj_validate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error,1);
		}else{
			$act_apply_row = $this->obj_credits_act->getCreditsActApplyRow($this->_input['id']);
			$act_apply_row['total_credits'] = $act_apply_row['caa_credits']*$act_apply_row['caa_num'];
			/**
			 * 页面输出
			 */
			$this->output('act_apply_row',$act_apply_row);
			$this->showpage('sys_credits_act.apply_audit');
		}
	}
	
	/**
	 * 保存审核操作
	 */
	function _apply_audit_update(){
		$this->obj_validate->setValidate(array("input"=>$this->_input['caa_id'],"require"=>"true","validator"=>"Number","message"=>$this->_lang['langSysCIDErr']));
		$error = $this->obj_validate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error,1);
		}else{
			//更新
			$value_array = array();
			$value_array['caa_id'] = $this->_input['caa_id'];
			$value_array['caa_state'] = $this->_input['caa_state'];
			$result = $this->obj_credits_act->updateCreditsActApply($value_array);
			if ($result === true){
				//如果是拒绝，则恢复商品数量，退还用户积分，记录日志
				if ($this->_input['caa_state'] == 2){
					$act_apply_row = $this->obj_credits_act->getCreditsActApplyRow($this->_input['caa_id']);
					//返还会员积分
					$value_array = array();
					$value_array['extcredits_exp'] = 0;
					$value_array['extcredits_points'] = $act_apply_row['caa_credits'];
					$this->obj_member->modifyMember($value_array,$act_apply_row['caa_member_id'],'credits');
					unset($value_array);
					//写入日志
					$value_array = array();
					$value_array['cl_member_id'] = $act_apply_row['caa_member_id'];
					$value_array['cl_time'] = time();
					$value_array['cl_type'] = 'credits_convert';
					$value_array['cl_content'] = $this->_lang['langSysCAApplyLog'];
					$value_array['cl_exp'] = 0;
					$value_array['cl_points'] = $act_apply_row['caa_credits'];
					CreditsClass::addCreditsLog($value_array);
					unset($value_array);
					//恢复兑换商品数量
					$act_goods_row = $this->obj_credits_act->getCreditsActGoodsRow($act_apply_row['cag_id']);
					$value_array = array();
					$value_array['cag_id'] = $act_apply_row['cag_id'];
					$value_array['cag_num'] = $act_goods_row['cag_num']+$act_apply_row['caa_num'];
					$this->obj_credits_act->updateCreditsActGoods($value_array);
					unset($value_array);
				}
				$this->redirectPath("error","",$this->_lang['langSysCAApplyAuditSucc'],1);
			}else {
				$this->redirectPath("error","",$this->_lang['errSysCAApplyAuditFail'],1);
			}
		}
	}

	/**
	 * 修改
	 */
	function _manage_modi(){
		/**
		 * 页面输出
		 */
		$this->output('app_array',$this->default_app_array);
		$this->showpage('sys_credits_act.manage_modi');
	}
	
	/**
	 * 保存修改
	 */
	function _manage_update(){
		/**
		 * 验证提交的数据
		 */
		$this->obj_validate->setValidate(array("input"=>$this->_input['app_module_id'],"require"=>"true","validator"=>"Number","message"=>$this->_lang['langSysCIDErr']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['app_module_name'],"require"=>"true","message"=>$this->_lang['errSysAppManageNameIsEmpty']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['app_module_sort'],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errSysAppManageSortNotNumber']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['app_module_path'],"require"=>"true","message"=>$this->_lang['errSysAppManagePathIsEmpty']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['app_module_path'],"require"=>"true","validator"=>"NoChinese","message"=>$this->_lang['errSysAppManagePathIsIllegal']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['app_module_sys_path'],"require"=>"true","message"=>$this->_lang['errSysAppManageSysPathIsEmpty']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['app_module_sys_path'],"require"=>"true","validator"=>"NoChinese","message"=>$this->_lang['errSysAppManageSysPathIsIllegal']));
		$error = $this->obj_validate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error,1);
		}else{
			//更新
			$value_array = array();
			$value_array['app_module_id'] = $this->_input['app_module_id'];
			$value_array['app_module_name'] = $this->_input['app_module_name'];
			$value_array['app_module_sort'] = $this->_input['app_module_sort'];
			$value_array['app_module_path'] = $this->_input['app_module_path'];
			$value_array['app_module_sys_path'] = $this->_input['app_module_sys_path'];
			$value_array['app_module_state'] = $this->_input['app_module_state'];
			$result = $this->obj_app_class->updateAppModule($value_array);
			if ($result !== true){
				$this->redirectPath("error","",$this->_lang['errSysAppManageUpdateIsFail'],1);
			}else {
				//修改文件夹名
				if ($this->default_app_array['app_module_sys_path'] != $this->_input['app_module_sys_path']){
					if (!rename(BasePath.'/app/'.$this->default_app_array['app_module_path'].'/'.$this->default_app_array['app_module_sys_path'],BasePath.'/app/'.$this->default_app_array['app_module_path'].'/'.$this->_input['app_module_sys_path'])){
						$this->redirectPath("error","",$this->_lang['errSysAppManageSysPathRenameIsFail'],1);
					}
				}
				if ($this->default_app_array['app_module_path'] != $this->_input['app_module_path']){
					if (!rename(BasePath.'/app/'.$this->default_app_array['app_module_path'],BasePath.'/app/'.$this->_input['app_module_path'])){
						$this->redirectPath("error","",$this->_lang['errSysAppManagePathRenameIsFail'],1);
					}
				}
				//更新应用缓存文件
				$this->obj_app_class->restartAppModule();				
				$this->redirectPath("error","",$this->_lang['langSysAppManageUpdateIsSucc'],1);
			}
		}
	}
	
	/**
	 * 安装
	 */
	function _setup(){
		/**
		 * 页面输出
		 */
		$this->output('app_array',$this->default_app_array);
		$this->showpage('sys_credits_act.setup');
	}
	
	/**
	 * 保存安装
	 */
	function _setup_save(){
		/**
		 * 验证提交的数据
		 */
		$this->obj_validate->setValidate(array("input"=>$this->_input['app_module_name'],"require"=>"true","message"=>$this->_lang['errSysAppManageNameIsEmpty']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['app_module_sort'],"require"=>"true","validator"=>"Number","message"=>$this->_lang['errSysAppManageSortNotNumber']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['app_module_path'],"require"=>"true","message"=>$this->_lang['errSysAppManagePathIsEmpty']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['app_module_path'],"require"=>"true","validator"=>"NoChinese","message"=>$this->_lang['errSysAppManagePathIsIllegal']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['app_module_sys_path'],"require"=>"true","message"=>$this->_lang['errSysAppManageSysPathIsEmpty']));
		$this->obj_validate->setValidate(array("input"=>$this->_input['app_module_sys_path'],"require"=>"true","validator"=>"NoChinese","message"=>$this->_lang['errSysAppManageSysPathIsIllegal']));
		$error = $this->obj_validate->validate();
		if ($error != ""){
			$this->redirectPath("error","",$error,1);
		}else{
			//第一次安装
			if ($this->default_app_array['app_module_first_install'] == '0'){
				//安装数据库
				$database_result = $this->obj_app_class->setupAppModuleDatabase($this->default_app_array['app_module_path']);
				if ($database_result !== true){
					$this->redirectPath("error","",$this->_lang['errSysAppManageSqlIsEmpty'],1);
				}
			}
			//更新
			$value_array = array();
			$value_array['app_module_id'] = $this->default_app_array['app_module_id'];
			$value_array['app_module_name'] = $this->_input['app_module_name'];
			$value_array['app_module_sort'] = $this->_input['app_module_sort'];
			$value_array['app_module_path'] = $this->_input['app_module_path'];
			$value_array['app_module_sys_path'] = $this->_input['app_module_sys_path'];
			$value_array['app_module_state'] = $this->_input['app_module_state'];
			$value_array['app_module_install'] = '1';
			$value_array['app_module_first_install'] = '1';
			$result = $this->obj_app_class->updateAppModule($value_array);
			if ($result !== true){
				$this->redirectPath("error","",$this->_lang['errSysAppManageSetupIsFail'],1);
			}else {
				//修改文件夹名
				if ($this->default_app_array['app_module_sys_path'] != $this->_input['app_module_sys_path']){
					if (!rename(BasePath.'/app/'.$this->default_app_array['app_module_path'].'/'.$this->default_app_array['app_module_sys_path'],BasePath.'/app/'.$this->default_app_array['app_module_path'].'/'.$this->_input['app_module_sys_path'])){
						$this->redirectPath("error","",$this->_lang['errSysAppManageSysPathRenameIsFail'],1);
					}
				}
				if ($this->default_app_array['app_module_path'] != $this->_input['app_module_path']){
					if (!rename(BasePath.'/app/'.$this->default_app_array['app_module_path'],BasePath.'/app/'.$this->_input['app_module_path'])){
						$this->redirectPath("error","",$this->_lang['errSysAppManagePathRenameIsFail'],1);
					}
				}
				//更新应用缓存文件
				$this->obj_app_class->restartAppModule();				
				$this->redirectPath("error","../system/app_module.manage.php?action=list",$this->_lang['langSysAppManageSetupIsSucc'],1);
			}
		}
	}
	
	/**
	 * 卸载
	 */
	function _unsetup(){
		/**
		 * 页面输出
		 */
		$this->output('app_array',$this->default_app_array);
		$this->showpage('sys_credits_act.unsetup');
	}
	
	/**
	 * 卸载保存
	 */
	function _unsetup_save(){
		//更新
		$value_array = array();
		$value_array['app_module_id'] = $this->default_app_array['app_module_id'];
		$value_array['app_module_state'] = '1';
		$value_array['app_module_install'] = '0';
		$result = $this->obj_app_class->updateAppModule($value_array);
		if ($result !== true){
			$this->redirectPath("error","",$this->_lang['errSysAppManageUnsetupNotExistOne']. BasePath.'/app/'.$this->default_app_array['app_module_path'] .$this->_lang['errSysAppManageUnsetupNotExistTwo'],1);
		}else {
			//更新应用缓存文件
			$this->obj_app_class->restartAppModule();			
			$this->redirectPath("error","../system/app_module.manage.php?action=list",$this->_lang['langSysAppManageUnsetupIsSucc'],1);
		}
	}
}
$credits_act = new SysCreditsActClass();
$credits_act->main();
unset($credits_act);
?>
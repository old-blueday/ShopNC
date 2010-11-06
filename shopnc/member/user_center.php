<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想单用户商城 项目的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : user_center.php   FILE_PATH : \shopnc6\home\user_center.php
 * ....会员中心表现层页面
 *
 * @copyright Copyright (c) 2007 - 2008 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Fir Jun 20 9:47:46 CST 2008
 */

require ("../global.inc.php");

class ShowUserCenter extends CommonFrameWork{
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	private $obj_user;
	/**
	 * 会员收货地址对象
	 */
	private $obj_user_other;
	/**
	 * 商品收藏对象
	 *
	 * @var obj
	 */
	private $obj_collection;
	/**
	 * 商品评论对象
	 *
	 * @var obj
	 */
	private $obj_comment;
	/**
	 * 问题类别对象
	 *
	 * @var obj
	 */
	private $obj_ask_cate;
	/**
	 * 问题对象
	 *
	 * @var obj
	 */
	private $obj_ask;
	/**
	 * 我的订单对象
	 *
	 * @var obj
	 */
	private $my_order;
	/**
	 * 支付对象
	 *
	 * @var obj
	 */
	private $obj_module_pay;
	/**
	 * uc对象
	 *
	 * @var obj
	 */
	private $objucenter;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	private $objvalidate;

	function main(){
		/**
		* 语言包
		*/
		$this->getlang("user_center_my_order_view,header_footer,user_center_collection,user_center_index,user_center_menu,user_center_shopping_address_list,user_center_modify_userinfo,user_center_shopping_address,user_center_comment,user_center_change_pw,user_center_ask,user_center_order_list");

		/**
		 * 如果session超时则返回首页
		 */
		if ($_SESSION['userinfo']['user_id'] == "") {
			$this->showMessage($this->_lang['user_center_no_login'],"user.php?action=login_page",1,1000);
			exit();
		}
		/**
		 * 创建会员对象
		 */

		if (!is_object($this->obj_user)){
			require_once("users.class.php");
			$this->obj_user = new UsersClass();
		}

		/**
		 * 创建会员收货地址对象
		 */
		if (!is_object($this->obj_user_other)) {
			require_once("usersOther.class.php");
			$this->obj_user_other = new UsersOtherClass();
		}
		/**
		 * 创建商品收藏对象
		 */
		if (!is_object($this->obj_collection)) {
			require_once("collection.class.php");
			$this->obj_collection = new CollectionClass();
		}

		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}
		/**
		 * 创建评论对象
		 */
		if (!is_object($this->obj_comment)) {
			require_once("goodsComments.class.php");
			$this->obj_comment = new GoodsCommentsClass();
		}
		/**
		 * 创建问题类别对象
		 */
		if (!is_object($this->obj_ask_cate)) {
			require_once("askCate.class.php");
			$this->obj_ask_cate = new AskCateClass();
		}
		/**
		 * 创建问题对象
		 */
		if (!is_object($this->obj_ask)) {
			require_once("ask.class.php");
			$this->obj_ask = new AskClass();
		}
		/**
		 * 创建ucenter会员对象
		 */
		if($this->_configinfo['interface']['open_passport'] == '1' && $this->_configinfo['interface']['open_ucenter'] == '1'){
			if (!is_object($this->objucenter)){
				require_once ("ucenter.class.php");
				$this->objucenter = new UcenterClass();
			}
		}
		/**
		 * 创建我的订单对象
		 */
		if (!is_object($this->my_order)) {
			require_once("myOrder.class.php");
			$this->my_order = new MyOrderClass();
		}
		/**
		 * 创建支付对象
		 */
		if(!is_object($this->obj_module_pay)) {
			require_once("modulePay.class.php");
			$this->obj_module_pay = new ModulePayClass();
		}
		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case 'modify_userinfo':			// 修改会员信息页面
			$this->modifyUserInfo();
			break;
			case 'update_userinfo':			//修改会员信息
			$this->updateUserInfo();
			break;
			case 'consignee_address_manage'://收货地址管理
			$flag = $this->obj_user_other->checkUserOtherExist(array("user_uid"=>$_SESSION['userinfo']['user_id']));
			if ($flag) {
				$this->shoppingAddressList();
			}
			else {
				header("location:". $this->_configinfo['websit']['site_url'] ."/member/user_center.php?action=shopping_add");
				exit;
			}
			break;
			case 'shopping_add':			//收货地址页面

			$this->shoppingAddressPage();
			break;
			case 'shopping_save':			//保存收货地址
			$this->saveShoppingAddress();
			case 'setDefaultAddress':		//设置默认地址
			$this->setDefaultAddress();
			break;
			case 'delAddress': 				//删除收货地址
			$this->delShoppingAddress();
			break;
			case 'add_collection':			//添加收藏
			$this->addCollection();
			break;
			case 'collection':				//收藏
			$this->shoppingCollection();
			break;
			case 'del_collection':			//删除收藏
			$this->delCollection();
			break;
			case 'message':					//留言
			$this->shoppingMessage();
			break;
			case 'del_message':				//删除留言
			$this->delMessage();
			break;
			case 'online':					//在线客服
			$this->shoppingOline();
			break;
			case 'add_ask':    				//提交问题
			$this->addAsk();
			break;
			case 'del_ask': 				//删除问题
			$this->delAsk();
			break;
			case 'change_pw':				//修改密码页面
			$this->changePW();
			break;
			case 'change_password':			//修改密码
			$this->changePassword();
			break;
			case 'my_order':				//我的订单
			$this->myOrder();
			break;
			case 'my_order_view':			//订单查看
			$this->myOrderView();
			break;
			case 'del_my_order':			//删除订单
			$this->delMyOrder();
			break;
			default:						//中心首页
			$this->index();
			break;
		}

	}
	/**
	 * 显示中心首页
	 *
	 */
	private function index(){

		$user_id = $_SESSION['userinfo']['user_id'];
		//获取用户基本信息
		$userinfo = $this->obj_user->getUserInfo(array("user_id"=>$user_id),"user_sex,user_true_name,user_email,user_phone,user_mobilephone,user_otherphone,user_qq,user_msn,user_register_time,user_login_time");
		$userinfo_array['true_name']     = $userinfo['user_true_name']==""?$this->_lang['user_center_index_unset']:$userinfo['user_true_name'];		//会员真实姓名
		$userinfo_array['sex']           = $userinfo['user_sex']==0?$this->_lang['user_center_index_boy']:$this->_lang['user_center_index_girl'];	//会员性别
		$userinfo_array['email']         = $userinfo['user_email']==""?$this->_lang['user_center_index_unset']:$userinfo['user_email'];				//会员邮箱
		$userinfo_array['phone']         = $userinfo['user_phone']==""?$this->_lang['user_center_index_unset']:$userinfo['user_phone'];				//电话，一般指座机
		$userinfo_array['mobilephone']   = $userinfo['user_mobilephone']==""?$this->_lang['user_center_index_unset']:$userinfo['user_mobilephone']; //移动电话
		$userinfo_array['otherphone']    = $userinfo['user_otherphone']==""?$this->_lang['user_center_index_unset']:$userinfo['user_otherphone'];	//其他电话
		$userinfo_array['qq']            = $userinfo['user_qq']==""?$this->_lang['user_center_index_unset']:$userinfo['user_qq'];					//会员qq号
		$userinfo_array['msn']           = $userinfo['user_msn']==""?$this->_lang['user_center_index_unset']:$userinfo['user_msn'];					//会员msn号
		$userinfo_array['register_time'] = date("Y-m-d H:i:s",$userinfo['user_register_time']);	                                                    //注册时间
		$userinfo_array['login_time']    = date("Y-m-d H:i:s",$userinfo['user_login_time']);                                                        //登录时间
		$this->output("userinfo_array",$userinfo_array);
		/*获取订单信息*/
		$obj_page = '';
		$conditon_array = array('user_id'=>$user_id);
		$my_shop_order = $this->my_order->myOrderList($conditon_array,'','*',5,'order_id desc');
		$this->output('my_order',$my_shop_order);

		$this->showpage("user_center_index");
	}
	/**
	 * 修改用户信息页面
	 *
	 */
	private function modifyUserInfo(){
		$userinfo = $this->obj_user->getUserInfo(array("user_id"=>$_SESSION['userinfo']['user_id']));
		$this->output("userinfo",$userinfo);

		/*动态的级联菜单，顶级菜单*/
		include('moduleRegion.class.php');
		$region	= new ModuleRegionClass();
		if(intval($userinfo['user_country']) == 0) {
			$top_region	= $region->regionList(array('area_top_id'=>0));
			$this->output('top_region',$top_region);
		} else {
			//会员信息里已经有了的国家
			$country_array	= $region->regionList(array('area_top_id'=>0),'area_id,area_name');
			$country_select	= Common::Select('select0',$country_array,$this->_lang['modify_userinfo_select'],$userinfo['user_country'],'',array('area_id','area_name'));
			$this->output('country_select',$country_select);
		}
		if(intval($userinfo['user_province']) != 0) {
			$province_select	= $region->outSelectArea($userinfo['user_province'],'select1',$this->_lang['modify_userinfo_select']);
			/*			$province_info	= $region->getAreaInfo(array('area_id'=>$userinfo['user_province']));
			$province_array	= $region->regionList(array('area_top_id'=>$province_info['area_top_id']),'area_id,area_name');
			$province_select	= Common::Select('select1',$province_array,$this->_lang['modify_userinfo_select'],$userinfo['user_province'],'',array('area_id','area_name'));*/
			$this->output('province_select',$province_select);
		}
		if(intval($userinfo['user_city']) != 0) {
			$city_select		= $region->outSelectArea($userinfo['user_city'],'select2',$this->_lang['modify_userinfo_select']);
			$this->output('city_select',$city_select);
		}
		if(intval($userinfo['user_county']) != 0) {
			$county_select		= $region->outSelectArea($userinfo['user_county'],'select3',$this->_lang['modify_userinfo_select']);
			$this->output('county_select',$county_select);
		}
		$this->showpage("user_center_modify_userinfo");
	}
	/**
	 * 修改用户信息
	 *
	 */
	private function updateUserInfo(){
		/**
		 * 验证注册信息
		 */

		$this->objvalidate->setValidate(array("input"=>$this->_input['txt_user_email'],"require"=>"true","validator"=>"Email","message"=>$this->_lang['modify_userinfo_email_error']));   //邮件格式非法
		$this->objvalidate->setValidate(array("input"=>$this->_input['txt_user_zip'],"validator"=>"Zip","message"=>$this->_lang['modify_userinfo_zip_error']));   //邮编格式错误
		$this->objvalidate->setValidate(array("input"=>$this->_input['txt_user_phone'],"validator"=>"Phone","message"=>$this->_lang['modify_userinfo_phone_error']));    //宅电格式错误
		$this->objvalidate->setValidate(array("input"=>$this->_input['txt_user_mobilephone'],"validator"=>"Mobile","message"=>$this->_lang['modify_userinfo_mobilphone_error']));   //手机格式错误

		$error = $this->objvalidate->validate();
		if ($error != "" ){
			//返回错误信息
			$this->showMessage($error,$this->_configinfo['websit']['site_url']."/member/user_center.php?action=modify_userinfo",1,2000);
		}
		else {
			/**整合UC后修改密码**/
			if($this->_configinfo['interface']['open_passport'] == '1' && $this->_configinfo['interface']['open_ucenter'] == '1'){
				$result_edit_ucuser = $this->objucenter->edit_user(array('login_name'=>$_SESSION['userinfo']['user_name'],'email'=>trim($_POST['txt_user_email'])));
				if($result_edit_ucuser == false){
					$this->redirectPath("error","",$this->objucenter->error);
				}
			}

			$user_info = $this->obj_user->modifyUser($this->_input,$_SESSION['userinfo']['user_id']);
			if ($user_info) {
				$this->showMessage($this->_lang['modify_userinfo_modify_succ'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=modify_userinfo",1,2000);
			}
			else{
				$this->showMessage($this->_lang['modify_userinfo_modify_fall'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=modify_userinfo",1,2000);
			}
		}
	}
	/**
	 * 收货地址添加页面
	 *
	 * @param string $parmer add:添加的地址 modify:修改地址
	 */
	private function shoppingAddressPage(){
		if ($this->_input['parmer'] == "modify") {
			$this->output("flag","modify");
			$this->output("other_id",$this->_input['other_id']);
			$address_info = $this->obj_user_other->getUserOtherInfo(array("other_id"=>$this->_input['other_id']));
			$this->output("address_info",$address_info);
		}
		else {
			$this->output("flag","add");
		}
		/*动态的级联菜单，顶级菜单*/
		include('moduleRegion.class.php');
		$region	= new ModuleRegionClass();
		if(intval($address_info['other_country']) == 0) {
			$top_region	= $region->regionList(array('area_top_id'=>0));
			$this->output('top_region',$top_region);
		} else {
			//会员信息里已经有了的国家
			$country_array	= $region->regionList(array('area_top_id'=>0),'area_id,area_name');
			$country_select	= Common::Select('select0',$country_array,$this->_lang['modify_userinfo_select'],$address_info['other_country'],'',array('area_id','area_name'));
			$this->output('country_select',$country_select);
		}
		if(intval($address_info['other_province']) != 0) {
			$province_select	= $region->outSelectArea($address_info['other_province'],'select1',$this->_lang['modify_userinfo_select']);
			/*			$province_info	= $region->getAreaInfo(array('area_id'=>$address_info['other_province']));
			$province_array	= $region->regionList(array('area_top_id'=>$province_info['area_top_id']),'area_id,area_name');
			$province_select	= Common::Select('select1',$province_array,$this->_lang['modify_userinfo_select'],$address_info['other_province'],'',array('area_id','area_name'));*/
			$this->output('province_select',$province_select);
		}
		if(intval($address_info['other_city']) != 0) {
			$city_select	= $region->outSelectArea($address_info['other_city'],'select2',$this->_lang['modify_userinfo_select']);
			$this->output('city_select',$city_select);
		}
		if(intval($address_info['other_county']) != 0) {
			$county_select	= $region->outSelectArea($address_info['other_county'],'select3',$this->_lang['modify_userinfo_select']);
			$this->output('county_select',$county_select);
		}

		$this->showpage("user_center_shopping_address");
	}

	/**
	 * 保存收货地址
	 *
	 */
	private function saveShoppingAddress(){
		$input_param['txt_user_uid']          = $_SESSION['userinfo']['user_id'];	   //会员id
		$input_param['txt_other_true_name']   = $this->_input['txt_other_true_name'];  //收货人真是姓名
		$input_param['txt_other_email']       = $this->_input['txt_other_email'];	   //收货人email
		$input_param['txt_other_country']     = $this->_input['select0'];   			//收货人国家
		$input_param['txt_other_province']    = $this->_input['select1'];   			//收货人省
		$input_param['txt_other_city']        = $this->_input['select2'];	   			//收货人所在市
		$input_param['txt_other_county']      = $this->_input['select3'];	   			//收货人所在县
		$input_param['txt_other_address']     = $this->_input['txt_other_address'];	   //收货人具体地区
		$input_param['txt_other_zip']         = $this->_input['txt_other_zip'];	       //收货人邮编
		$input_param['txt_other_phone']       = $this->_input['txt_other_phone'];      //收货人固定电话
		$input_param['txt_other_mobilephone'] = $this->_input['txt_other_mobilephone'];//收货人移动电话
		$input_param['txt_other_otherphone']  = $this->_input['txt_other_otherphone']; //收货人其它电话

		$this->objvalidate->setValidate(array("input"=>$input_param['txt_other_true_name'],"require"=>"true","message"=>$this->_lang['shopping_address_true_name_is_null']));   //真实姓名不能为空
		$this->objvalidate->setValidate(array("input"=>$input_param['txt_other_email'],"require"=>"true","validator"=>"Email","message"=>$this->_lang['shopping_address_email_error']));   //邮编格式错误
		//$this->objvalidate->setValidate(array("input"=>$input_param['txt_other_province'],"require"=>"true","message"=>$this->_lang['shopping_address_province_null']));    //所在省不能为空
		//$this->objvalidate->setValidate(array("input"=>$input_param['txt_other_city'],"require"=>"true","message"=>$this->_lang['shopping_address_city_null']));   //所在市不能为空
		$this->objvalidate->setValidate(array("input"=>$input_param['txt_other_address'],"require"=>"true","message"=>$this->_lang['shopping_address_address_is_null']));   //具体地址不能为空
		$this->objvalidate->setValidate(array("input"=>$input_param['txt_other_zip'],"require"=>"true","validator"=>"Zip","message"=>$this->_lang['shopping_address_zip_error']));   //邮编格式错误
		$this->objvalidate->setValidate(array("input"=>$input_param['txt_other_mobilephone'],"require"=>"true","validator"=>"Mobile","message"=>$this->_lang['shopping_address_mobilphone_error']));   //手机格式错误

		$error = $this->objvalidate->validate();

		if ($this->_input['flag'] == "modify") {
			$other_id = "parmer=modify&other_id=".$this->_input['other_id'];
		}
		else {
			$other_id ="";
		}

		if ($error != "" ){
			//返回错误信息
			$this->showMessage($error,$this->_configinfo['websit']['site_url']."/member/user_center.php?action=shopping_add".$other_id,1,2000);
		}
		else {
			if ($this->_input['flag'] == "add") {
				$flag = $this->obj_user_other->checkUserOtherExist(array("user_uid"=>$_SESSION['userinfo']['user_id'],"other_flag"=>"yes"));
				if ($flag) {
					$input_param['txt_other_flag'] = "no";
				}
				else {
					$input_param['txt_other_flag'] = "yes";
				}

				$result = $this->obj_user_other->addOtherUser($input_param);
				if ($result) {
					$this->showMessage($this->_lang['shopping_address_succ'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=consignee_address_manage",1,2000);
				}
				else {
					$this->showMessage($this->_lang['shopping_address_fall'],$this->_configinfo['websit']['site_url'] ."/member/user_center.php?action=shopping_add".$other_id,1,2000);
				}
			}
			if ($this->_input['flag'] == "modify" ) {
				$result = $this->obj_user_other->modifyUserOther($input_param,$this->_input['other_id']);
				if ($result) {
					$this->showMessage($this->_lang['shopping_address_succ'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=consignee_address_manage",1,2000);
				}
				else {
					$this->showMessage($this->_lang['shopping_address_fall'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=shopping_add".$other_id,1,2000);
				}
			}
		}
	}
	/**
	 * 收货地址列表
	 *
	 */
	private function shoppingAddressList(){
		/*默认的收货地址*/
		$default_address_info = $this->obj_user_other->getUserOtherInfo(array("user_uid"=>$_SESSION['userinfo']['user_id'],"other_flag"=>"yes"));
		$this->output("default_address_info",$default_address_info);

		$address_info_array = $this->obj_user_other->getUserList(array("user_uid"=>$_SESSION['userinfo']['user_id'],"other_flag"=>"no"));
		$this->output("address_info_array",$address_info_array);
		$this->showpage("user_center_shopping_address_list");
	}
	/**
	 * 设置默认收货地址
	 *
	 */
	private function setDefaultAddress(){
		$other_id = $this->_input['other_id'];
		$this->obj_user_other->setDefaultAddress($_SESSION['userinfo']['user_id'],$other_id);
		header("location:".$this->_configinfo['websit']['site_url']."/member/user_center.php?action=consignee_address_manage");
		exit();
	}
	/**
	 * 删除收货地址
	 *
	 */
	private function delShoppingAddress(){
		$other_id = $this->_input['other_id'];
		$result = $this->obj_user_other->delUserOther($other_id);
		if ($result) {
			$this->showMessage($this->_lang['shopping_address_succ'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=consignee_address_manage",1,2000);
		}
		else {
			$this->showMessage($this->_lang['shopping_address_fall'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=shopping_add".$other_id,1,2000);
		}
	}
	/**
	 * 添加商品收藏
	 *
	 */
	private function addCollection(){
		$input_param = array();
		$input_param['goods_id'] = intval($this->_input['goods_id']);
		$input_param['user_id'] = intval($_SESSION['userinfo']['user_id']);
		$collection_array = $this->obj_collection->getCollection(array('goods_id'=>$input_param['goods_id'],'user_id'=>$input_param['user_id']));
		if ($collection_array == false) {
			if ($input_param['goods_id'] == 0 || $input_param['user_id'] == 0) {
				$this->showMessage($this->_lang['favorite_error'],$_SERVER['HTTP_REFERER'],1,2000);
			}
			else {
				$result = $this->obj_collection->addCollection($input_param);
				if ($result) {
					$this->showMessage($this->_lang['favorite_succ'],$_SERVER['HTTP_REFERER'],1,2000);
				}
				else{
					$this->showMessage($this->_lang['favorite_error'],$_SERVER['HTTP_REFERER'],1,2000);
				}
			}
		}
		else {
			$this->showMessage($this->_lang['favorite_succ'],$_SERVER['HTTP_REFERER'],1,2000);
		}

	}
	/**
	 * 我的收藏
	 *
	 */
	private function shoppingCollection() {
		/*创建分页对象*/
		require_once("commonpage.class.php");
		$obj_page = new CommonPage();
		$obj_page->pagebarnum(10);
		$conditon_array = array('user_id'=>$_SESSION['userinfo']['user_id']);
		$collection_array = $this->obj_collection->getCollectionList($conditon_array,$obj_page);
		$show_page = $obj_page->show(1);
		$this->output('collection_array',$collection_array);
		$this->output('show_page',$show_page);
		$this->showpage('user_center_collection');
	}
	/**
	 * 删除商品收藏
	 *
	 */
	private function delCollection(){
		$input_param['collection_id'] = intval($this->_input['collection_id']);
		$result = $this->obj_collection->delCollection($input_param);
		if ($result) {
			$this->showMessage($this->_lang['favorite_del_succ'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=collection",1,2000);
		}
		else {
			$this->showMessage($this->_lang['favorite_del_error'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=collection",1,2000);
		}
	}
	/**
	 * 我的留言
	 *
	 */
	private function shoppingMessage() {
		require_once("commonpage.class.php");
		$obj_page = new CommonPage();
		$obj_page->pagebarnum(5);
		$conditon_array = array('user_id'=>$_SESSION['userinfo']['user_id']);
		$comment_array = $this->obj_comment->getGoodsCommentList($conditon_array,$obj_page);
		$show_page = $obj_page->show(1);
		$this->output('comment_array',$comment_array);
		$this->output('show_page',$show_page);
		$this->showpage('user_center_comment');
	}
	/**
	 * 删除留言
	 *
	 */
	private function delMessage(){
		$input_param = $this->_input['cid'];
		$result = $this->obj_comment->delCommentClass($input_param,'comment_id');
		if ($result) {
			$this->showMessage($this->_lang['comment_del_succ'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=message",1,2000);
		}
		else {
			$this->showMessage($this->_lang['comment_del_error'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=message",1,2000);
		}
	}
	/**
	 * 客服中心
	 *
	 */
	private function shoppingOline() {
		/*问题类别*/
		//创建分页对象
		require_once("commonpage.class.php");
		$obj_page = new CommonPage();
		$obj_page->pagebarnum(10);
		$conditon_array = array('user_id'=>$_SESSION['userinfo']['user_id']);
		$ask_array = $this->obj_ask->getAskList($conditon_array,$obj_page);
		$show_page = $obj_page->show(1);

		$this->output('show_page',$show_page);
		$this->output('ask_array',$ask_array);
		unset($obj_page);

		$obj_page = '';
		$conditon_array = array();
		$ask_cate_array = $this->obj_ask_cate->getAskCateList(array('if_issue'=>1),$obj_page,'ac_id,cate_name');
		$cate_array =array();
		foreach ($ask_cate_array as $cate) {
			$cate_array[$cate['ac_id']] = $cate['cate_name'];
		}
		$this->output("ask_cate_array",Common::Select('ask_cate',$cate_array));
		$this->showpage('user_center_ask');
	}
	/**
	 * 提交问题
	 *
	 */
	private function addAsk(){
		$input_param = array();
		$input_param['user_id'] = $_SESSION['userinfo']['user_id'];           //用户id
		$input_param['ac_id'] = intval($this->_input['ask_cate']);             //问题类别id
		$input_param['user_name'] = $_SESSION['userinfo']['user_name'];         //用户名
		$input_param['ask_subject'] = trim($this->_input['ask_subject']); //留言主题
		$input_param['ask_body'] = trim($this->_input['ask_body']);    //留言内容
		$ask_cate_array = $this->obj_ask_cate->getAskCate(array('ac_id'=>$input_param['ac_id']));
		if ($ask_cate_array['if_marked'] == 1) {
			$input_param['ask_reply']   = $ask_cate_array['reply_body'];   //问题回复
			$input_param['if_reply']    = 1;    //是否回复
		}
		else {
			$input_param['ask_reply']   = "";   //问题回复
			$input_param['if_reply']    = 0;    //是否回复
		}
		$result = $this->obj_ask->addAsk($input_param);
		if ($result) {
			$this->showMessage($this->_lang['ask_submit_succ'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=online",1,2000);
		}
		else {
			$this->showMessage($this->_lang['ask_submit_error'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=online",1,2000);
		}
	}

	private function delAsk(){
		$input_param['ask_id'] = $this->_input['ask_id'];
		$result = $this->obj_ask->delAsk($input_param);
		if ($result) {
			$this->showMessage($this->_lang['ask_del_succ'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=online",1,1000);
		}
		else {
			$this->showMessage($this->_lang['ask_del_error'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=online",1,1000);
		}
	}
	/**
	 * 我的订单显示
	 *
	 */
	function myOrder() {
		//创建分页对象
		require_once("commonpage.class.php");
		$obj_page = new CommonPage();
		$obj_page->pagebarnum(5);
		$conditon_array = array('user_id'=>$_SESSION['userinfo']['user_id']);
		$my_shop_order = $this->my_order->myOrderList($conditon_array,$obj_page,'*',0,'order_id desc');

		$show_page = $obj_page->show(1);
		$this->output('show_page',$show_page);
		$this->output('my_order',$my_shop_order);

		$this->showpage('user_center_order');
	}
	/**
	 * 单个订单查看
	 *
	 */
	function myOrderView() {
		include_once("order.class.php");
		$goods_order = new OrderClass();
		/*订单产品*/
		$order_goods	= $goods_order->showGoodsOrder(array('detail_order_id'=>intval($this->_input['order_id'])));
		$this->output('order_goods',$order_goods);
		/*订单信息*/
		$order_array	= $goods_order->getOrderList(array('order_id'=>intval($this->_input['order_id'])),'');

		$order_state[1]		= $this->_lang['my_order_be_confirmed'];			//已确定
		$order_state[0]		= "<font color='red'>".$this->_lang['my_order_unconfirmed']."</font>";			//未确定
		$order_state1[1]	= $this->_lang['my_order_have_paid'];			//已付款
		$order_state1[0]	= "<font color='red'>".$this->_lang['my_order_not_paid']."</font>";				//未付款
		$order_state2[1]	= $this->_lang['my_order_yes_send'];				//已发货
		$order_state2[0]	= "<font color='red'>".$this->_lang['my_order_no_send']."</font>";				//未发货
		$order_state3[1]	= $this->_lang['my_order_already_filled'];		//已归档
		$order_state3[0]	= "<font color='red'>".$this->_lang['my_order_no_fill']."</font>";				//为归档
		$order_array[0]['order_state_txt']	= $order_state[$order_array[0]['order_state']];
		$order_array[0]['order_state1_txt']	= $order_state1[$order_array[0]['order_state1']];
		$order_array[0]['order_state2_txt']	= $order_state2[$order_array[0]['order_state2']];
		$order_array[0]['order_state3_txt']	= $order_state3[$order_array[0]['order_state3']];

		$this->output('order_array',$order_array[0]);

		/*调出支付系统的相关内容*/
		if($order_array[0]['order_state1'] == 0) {
			$pay_type	= $this->obj_module_pay->getPayInfo(array('pay_id'=>$order_array[0]['pay_id']));
			if(file_exists(BasePath."/api/payarea/".$pay_type['pay_area_directory']."/".$pay_type['pay_code'].".php")) {
				include_once(BasePath."/api/payarea/".$pay_type['pay_area_directory']."/".$pay_type['pay_code'].".php");
				$pay_class_name	= $pay_type['pay_code'].'PayClass';
				$out_pay_type	= new $pay_class_name();
				$order_array[0]['price_count'] = $order_array['0']['order_price'];
				$this->output('form_code',Common::nc_change_charset($out_pay_type->outForm($order_array[0],$pay_type,$this->_configinfo['websit']['site_url']),$this->_charset));
			}
		}
		
		$this->showpage('my_order_view');
	}
	/**
	 * 删除订单
	 *
	 */
	function delMyOrder() {
		include_once("order.class.php");
		$obj_goods_order = new OrderClass();
		$error = $obj_goods_order->deletetOrder(intval($this->_input['order_id']));
		if($error) {
			/*发送邮件*/
			if($this->_configinfo['websit']['del_goods_mail'] == '1' and $_SESSION['userinfo']['user_id'] != '') {
				include_once("system.class.php");
				$email_template	= new SystemClass();
				$user_email_template	= $email_template->getEmailTemplate(array('mail_template_name'=>"'del_goods_mail'"));
				$order_array			= array('user_name'		=> $_SESSION['userinfo']['user_name'],
				'shop_name'		=> $this->_configinfo['websit']['site_name'],
				'order_sn'		=> trim($this->_input['order_sn']),
				'send_date'		=> date("Y-m-d H:i:s"));
				$email_body				= Common::replaceMailContent($order_array,$user_email_template['mail_template_body']);

				/*邮件发送*/
				Common::shopnc_send_mail($_SESSION['userinfo']['user_email'],$this->_lang['user_center_list_order_del'],$email_body);
			}

			$this->showMessage($this->_lang['user_center_list_order_cancel_ok'],$_SERVER['HTTP_REFERER'],1,2000);
		} else {
			$this->showMessage($this->_lang['user_center_list_order_cancel_no'],$_SERVER['HTTP_REFERER'],1,2000);
		}
	}
	/**
	 * 修改密码页面
	 *
	 */
	private function changePW(){
		$this->showpage('user_center_change_pw');
	}
	/**
	 *  修改密码
	 *
	 */
	private function changePassword(){
		$old_pwd = trim($this->_input['old_password']);
		$new_pwd = trim($this->_input['new_password']);
		$re_new_pwd = trim($this->_input['re_new_password']);
		$user_id = $_SESSION['userinfo']['user_id'];
		$condition = array('user_password'=>substr(md5($old_pwd),0,16),'user_id'=>$user_id);
		$user_array = $this->obj_user->getUserInfo($condition);
		if ($user_array == null) {
			$this->showMessage($this->_lang['pw_old_error'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=change_pw",1,2000);
		}
		else {
			if ($new_pwd == $re_new_pwd) {
				/**整合UC后修改密码**/
				if($this->_configinfo['interface']['open_passport'] == '1' && $this->_configinfo['interface']['open_ucenter'] == '1'){
					$result_edit_ucuser = $this->objucenter->edit_user(array('login_name'=>$_SESSION['userinfo']['user_name'],'old_password'=>$old_pwd,'password'=>$new_pwd));
					if($result_edit_ucuser == false){
						$this->redirectPath("error","",$this->objucenter->error);
					}
				}

				$input_param['txt_user_password'] = $new_pwd;
				$result = $this->obj_user->modifyUser($input_param,$user_id,'pwd');
				if ($result) {
					$this->showMessage($this->_lang['pw_succ'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=change_pw",1,2000);
				}
				else {
					$this->showMessage($this->_lang['pw_error'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=change_pw",1,2000);
				}
			}
			else {
				$this->showMessage($this->_lang['pw_config_error'],$this->_configinfo['websit']['site_url']."/member/user_center.php?action=change_pw",1,2000);
			}
		}
	}
}
$user_center = new ShowUserCenter();
$user_center->main();
unset($user_center);
?>
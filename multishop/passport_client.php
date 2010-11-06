<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 网城创想多用户商城 项目的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : passport_client.php   FILE_PATH : passport_client.php
 * ....通行证客户端程序
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Mon Sep 11 17:17:13 CST 2008
 */
require ("global.inc.php");

class PassportClient extends BaseInitialize{
	/**
	 * 初始化
	 */
	function PassportClient(){
		$this->_initialize();
	}

	function main(){
		/**
		 * 语言包
		 */
		require_once("framework.core.php");
		$obj_framework = new FrameWork;
		$obj_framework->setFrameWork($errorlevel=$errorlevel,$contenttype=$contenttype);
		$obj_framework->getlang("passport");
		/**
		 * 创建会员对象
		 */
		require_once('member.class.php');
		$obj_member = new MemberClass();
		
		if($this->_input['forward']!=""){
			$forward = html_entity_decode($this->_input['forward']);
		}
		
		if($this->_configinfo[api][open_passport] != '1'){
			$obj_framework->redirectPath("error",$forward,$obj_framework->_lang['langPassportNotOpen']);
		}
		if(md5($this->_input['action'].$this->_input['userdb'].$this->_input['forward'].$this->_configinfo[api][passport_key]) != $this->_input['verify']){
			$obj_framework->redirectPath("error",$forward,$obj_framework->_lang['langPassportNotAllowed']);
		}
		/**
		 * 参数处理
		 */
		$action	= $this->_input['action'];
		if ($this->_input['action'] == "quit"){
			$action	= "logout";
		}

		if($action == 'login'){
			global $db_hash;
			$db_hash = $this->_configinfo[api][passport_key];
			require_once('api.class.php');
			$userdb = $this->_input['userdb'];
			parse_str(Api::phpwindStrCode($userdb,'DECODE'),$userdb);
			if(!$userdb['time'] || !$userdb['username'] || !$userdb['password']){
				$obj_framework->redirectPath("error",$forward,$obj_framework->_lang['langPassportLackParam']);
			}
			if(time()-$userdb['time']>3600){
				$obj_framework->redirectPath("error",$forward,$obj_framework->_lang['langPassportOvertime']);
			}

			$member_field = array('password','email');

			$sql='';
			foreach($member_field as $key=>$val){
				$sql .= ','.$val;
			}

			$rs_array = $obj_member->checkMemberExist(array("member_name"=>$userdb[username]),3);
			if($rs_array){
				$member_array = array();
				foreach($userdb as $key=>$val){
					if(in_array($key,$member_field) && $rs_array[$key] != $val){
						$member_array[$key] = $val;
					}elseif($key == 'time'){
						$member_array['last_login_time'] = $val;
					}

				}
				if(count($member_array) > 0){
					$update_rs = $obj_member->modifyMember($member_array,$rs_array['member_id'],'passport');
					if($update_rs == false){
						$obj_framework->redirectPath("error",$forward,$obj_framework->_lang['langPassportParamIsWrong']);
					}
				}
				/**
				 * 判断是否被锁定
				 */
				if ($rs_array['member_state'] == 0) {
					$obj_framework->redirectPath("error",$forward,$obj_framework->_lang['langPassportUserIsLocked']);//该用户被锁定，无法登录!
				}
				/**
				 * 判断是否是删除状态
				 */
				if ($rs_array['member_state'] == 2) {
					$obj_framework->redirectPath("error",$forward,$obj_framework->_lang['langPassportUserIsDeleted']);
				}

			}else{
				//检查是否存在删除状态的相同会员名的信息，有则删除
				$check_id = $obj_member->checkMemberExist(array("member_name"=>$userdb[username],'member_state'=>'2'),2);
				if ($check_id != ''){
					$input['id'] = $check_id;/*通过ID删除*/
					$obj_member->delMember($input);
				}
				//会员信息入数据库
				foreach($userdb as $key=>$val){
					if($key == 'username'){
						$input_array['txtloginname']  = $val;
					}elseif($key == 'password'){
						$input_array['passportPassword'] = $val;
					}elseif($key == 'email'){
						$input_array['txtemail'] = $val;
					}

				}
				$add_member_rs = $obj_member->addMember($input_array);
				if($add_member_rs == false){
					$obj_framework->redirectPath("error",$forward,$obj_framework->_lang['langPassportUserAddedFaild']);
				}
				/*取出会员信息*/
				$rs_array = $obj_member->checkMemberExist(array("member_name"=>$userdb[username]),3);
			}


			/**
		     * 创建商铺对象
		     */
			if (!is_object($obj_shop)){
				require_once("shop.class.php");
				$obj_shop = new ShopClass();
			}
			$shop_array = $obj_shop->getOneShopByMemeberId($rs_array['member_id'],'1','*');
			if ($shop_array['shop_id'] > 0){
				$_SESSION["s_shop"]['id'] = $shop_array['shop_id'];
				$_SESSION["s_shop"]['audit_state'] = $shop_array['audit_state'];
				$_SESSION["s_shop"]['if_del'] = $shop_array['if_del'];
				$this->shopid = $_SESSION["s_shop"]['id'];
			}
			$_SESSION["s_login"]['login'] = 1;	//登陆标志
			$_SESSION["s_login"]['id'] = $rs_array['member_id'];       //会员ID
			$_SESSION["s_login"]['name'] = $rs_array['login_name'];    //登陆名称
			$_SESSION["s_login"]['type'] = $rs_array['member_type'];  //会员类型
			$_SESSION["s_login"]['ppt_uid'] = $userdb[uid];  //passport服务器端会员id

			//更新最后登录时间
			$obj_member->modifyMember($input_param,$_SESSION["s_login"]['id'],"last_login_time");
			
			//设置cookie信息
			setcookie("c_login_name",$member_array['login_name'],time()+$this->cookie_expire_time,'/',$this->_configinfo['cookie']['cookiedomain']);
			//sessionID
			setcookie("c_session_id",session_id(),time()+$this->cookie_expire_time,'/',$this->_configinfo['cookie']['cookiedomain']);

		}elseif($action == 'logout'){
			$this->_dologout();
		}
		/**
		 * 页面跳转
		 */
		$obj_framework->redirectPath("refer",$forward);
	}
	/**
	 * 退出
	 */
	function _dologout(){
		setcookie("c_login_name","");
		setcookie("sys_sid","");
		$_SESSION["s_login"] = array();
		$_SESSION["s_shop"] = array();
		session_unregister("s_login");
		session_unregister("s_shop");
	}

}
$passport_client = new PassportClient();
$passport_client->main();

?>

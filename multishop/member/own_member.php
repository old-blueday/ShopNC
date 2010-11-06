<?php
/////////////////////////////////////////////////////////////////////////////
// 此文件是 ShopNC多用户商城 的一部分
//
// Copyright (c) 2007 - 2010 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
 * FILE_NAME : own_member.php   FILE_PATH : \multishop\member\own_member.php
 * ....会员管理会员资料
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @package
 * @subpackage
 * @version Sat Aug 11 10:58:41 CST 2007
 */

require ("../global.inc.php");
class OwnMemberManage extends memberFrameWork{
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $objmember;
	/**
	 * uc整合对象
	 *
	 * @var obj
	 */
	var $objucenter;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;
	/**
	 * 地区对象
	 *
	 * @var obj
	 */
	var $obj_area;

	function main(){
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->objmember)){
			require_once ("member.class.php");
			$this->objmember = new MemberClass();
		}
		/**
		 * 创建ucenter会员对象
		 */
		if (!is_object($this->objucenter)){
			require_once ("ucenter.class.php");
			$this->objucenter = new ucenterClass();
		}
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}

		/**
		 * 语言包
		 */
		$this->getlang("member");

		/**
		 * 菜单输出
		 */
		if ( $this->_input['action'] == 'personal_certify' ) {
			$this->memberMenu('seller','my_seller','personal_certify');
		} else {
			$this->memberMenu('account','basic_set','info_password');
		}

		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case "modifysave":
				$this->_modifyBaseInfo();
				break;
			case "email":
				$this->output('InfoSelectorTarget',Common::getTargetMenu("member"));
				$this->_getMemberEmail();
				break;
            case "feed":
                $this->_feedGet();
                break;
            case "feedsave":
                $this->_feedSave();
                break;
			case "emailsave":
				$this->_saveMemberEmail();
				break;
			case "password":
				$this->_changeMemberPassword();
				break;
			case "passwordsave":
				$this->_saveMemberPassword();
				break;
			case "personal_certify":
				$this->_personal_certify();
				break;
			case "personal_certify_save":
				$this->_personal_certify_save();
				break;
			case "delpicture":
				$this->_del_picture();
				break;
			default:
				$this->output('InfoSelectorTarget',Common::getTargetMenu("member"));
				$this->_getBaseInfo();
				break;
		}

	}

	/**
	 * 删除会员头像
	 *
	 */
	function _del_picture() {
		//获取会员信息
		$condition['id'] = $_SESSION['s_login']['id'];
		$member_array = $this->objmember->getMemberInfo($condition,'picture','more');
		//删除图片
		if (file_exists(BasePath . '/' . $member_array['picture'])){
			unlink(BasePath . '/' . $member_array['picture']);
		}
		//删除数据库图片
		$value_array = array();
		$value_array['member_id'] = $_SESSION['s_login']['id'];
		$value_array['picture'] = '';
		$result = $this->objmember->updateMember($value_array);
		if ( $result ) {
			$this->redirectPath("succ","member/own_member.php",$this->_lang['langNEditPictureDelSucc']);
		} else {
			$this->redirectPath("error","",$this->_lang['langNEditPictureDelFale']);
		}
	}

	/**
	 * 得到会员的基本信息
	 *
	 */
	function _getBaseInfo(){
		/**
		 * 得到会员资料
		 */
		$condition['id'] = $_SESSION['s_login']['id'];
		$member_array = $this->objmember->getMemberInfo($condition,'*','more');
		/**
		 * 性别单选框
		 * 默认选中男性
		 */
		if ($member_array['gender']==""){
			$member_array['gender'] = "m";
		}
		//地区内容
		$array = Common::getAreaCache('');
		$area_array = array();
		if (is_array($array)){
			foreach ($array as $k => $v){
				if ($v[1] == '0'){
					$v['area_id'] = $v[0];
					$v['area_parent_id'] = $v[1];
					$v['area_name'] = $v[2];
					$v['is_parent'] = $v[5];//1是父ID，0不是
					$area_array[] = $v;
				}
			}
		}
		unset($array);
		//取已选择的地区内容
		$sel_area = array();
		if (!empty($member_array) && $member_array['area_id'] !=''){
			//取地区内容
			if (!is_object($this->obj_area)){
				require_once ("area.class.php");
				$this->obj_area = new AreaClass();
			}
			$sel_area = $this->obj_area->getAreaPathList($member_array['area_id']);
		}
	

		$this->output('member_array',$member_array);
		$this->output('allowuploadimagetype',$this->_fileconfig['allowuploadimagetype']);
		$this->output('allowuploadmaxsize',round($this->_fileconfig['allowuploadmaxsize']/1024,2));
		$this->output("gender" , Common::showForm_Radio("rdoGender","",$this->_b_config['gender'],$member_array['gender']));
		$this->showpage("own_member.modi");
	}

	/**
	 * 修改会员基本资料
	 *
	 */
	function _modifyBaseInfo(){
		if(isset($_FILES['memberPhoto']['name']) and $_FILES['memberPhoto']['name'] != ''){
			require_once("uploadfile.class.php");
			$upload = new UploadFile();
			$upload->allow_type = explode(',',$this->_fileconfig['allowuploadimagetype']);
			$upload->max_size = $this->_fileconfig['allowuploadmaxsize'];
			$upload->ifresize = false;
			$filename = $upload->upfile("memberPhoto");
			$this->_input["picture"] = $filename["getfilename"];//上传图片
			unset($upload);
		}
		$this->objmember->modifyMember($this->_input,$_SESSION['s_login']['id']);
		$this->redirectPath("succ","member/own_member.php",$this->_lang['langMInfoAmendOk']);
	}
	/**
	 * 会员修改邮箱
	 *
	 */
	function _getMemberEmail(){

		/**
		 * 通行证设置多用户为客户端，替换修改密码地址
		 */
		if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '1'){
			$this->output('passport_client', '1');
			$this->output('passport_url', $this->_configinfo['api']['passport_url']);
		}else{
			/**
			 * 得到会员资料
			 */
			$condition['id'] = $_SESSION['s_login']['id'];
			$member_array = $this->objmember->getMemberInfo($condition);

			$this->output('member_array',$member_array);
			$this->output('passport_client', '0');
		}

		$this->showpage("own_member.email");
	}

	/**
	 * 修改邮箱，保存到数据库中
	 *
	 */
	function _saveMemberEmail(){
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}
		/**
		 * 验证提交的表单
		 */
		$this->objvalidate->setValidate(array("input"=>$this->_input['txtemail'],"require"=>"true","validator"=>"Email","message"=>$this->_lang['errMEmail_Wrong']));    //请输入正确格式的email!

		$error = $this->objvalidate->validate();
		if($error != ""){
			$this->redirectPath("error","",$error);
		}else{
			/**整合UC后修改email**/
			if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '2'){
				$result_uc_email = $this->objucenter->edit_user(array('login_name'=>$_SESSION["s_login"]['name'],'email'=>$this->_input['txtemail']));
				if($result_uc_email == false){
					$this->redirectPath("error","",$this->objucenter->error);
				}
			}
			$result = $this->objmember->modifyMember($this->_input,$_SESSION['s_login']['id'],"email");
			if ($result == true){
				$this->redirectPath("succ","member/own_member.php?action=email",$this->_lang['langMEmailInfoAmendOk']);
			}else {
				$this->redirectPath("succ","member/own_member.php?action=email",$this->_lang['errMEmailExist']);
			}
		}
	}

    /**
     * 获取用户feed推送配置
     */
    function _feedGet() {
        $this->output('feed',$_SESSION['s_login']['feed']);
        $this->showpage('own_member.feed');
    }
    /**
     * 保存用户feed推送配置
     */
    function _feedSave() {
        $_SESSION['s_login']['feed'] = $this->_input['feed'];

        $feedSettingData = serialize((array)$this->_input['feed']);
        $rs = $this->objmember->modifyMember(array('feedsetting'=>$feedSettingData),$_SESSION['s_login']['id'],'feedsetting');

        if($rs) {
            $this->redirectPath('succ','member/own_member.php?action=feed',$this->_lang['langMUserFeedModifySucc']);
        } else {
            $this->redirectPath('succ','member/own_member.php?action=feed',$this->_lang['langMUserFeedModifyFail']);
        }
    }


	function _changeMemberPassword(){
		/**
		 * 通行证设置多用户为客户端，替换修改密码地址
		 */
		if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '1'){
			$this->output('passport_client', '1');
			$this->output('passport_url', $this->_configinfo['api']['passport_url']);
		}else{
			$this->output('passport_client', '0');
		}
		$this->output('InfoSelectorTarget',Common::getTargetMenu("member"));
		$this->output('ses_login_name',$_SESSION['s_login']['name']);
		$this->showpage("own_member.password");
	}

	/**
	 * 修改密码，保存到数据库中
	 *
	 */
	function _saveMemberPassword(){
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}
		/**
		 * 验证注册信息
		 */
		$this->objvalidate->setValidate(array("input"=>$this->_input['txtoldpassword'],"require"=>"true","message"=>$this->_lang['alertEnterPassword']));
		$this->objvalidate->setValidate(array("input"=>$this->_input['txtPassword'],"require"=>"true","validator"=>"Length","min"=>6,"max"=>16,"message"=>$this->_lang['alertEnterPassword']));    //密码由6-16个字符组成，请使用英文字母加数字或符号的组合密码，不能单独使用英文字母、数字或符号作为您的密码。
		$this->objvalidate->setValidate(array("input"=>$this->_input['txtPassword'],"require"=>"true","validator"=>"Compare","operator"=>"==","to"=>$this->_input['txtrePassword'],"message"=>$this->_lang['errMRePassword_Wrong']));   //两次输入的密码不相同!
		$error = $this->objvalidate->validate();
		if ($error != "" ){
			$this->redirectPath("error","",$error);
		}else{
			$condition['id'] = $_SESSION['s_login']['id'];
			$member_array = $this->objmember->checkMemberExist($condition,'3');
			if(md5(trim($this->_input['txtoldpassword'])) == trim($member_array['password'])){
				/**整合UC后修改密码**/
				if($this->_configinfo['api']['open_passport'] == '1' && $this->_configinfo['api']['passport_type'] == '2'){
					$result_edit_ucuser = $this->objucenter->edit_user(array('login_name'=>$_SESSION["s_login"]['name'],'old_password'=>$this->_input['txtoldpassword'],'password'=>$this->_input['txtPassword']));
					if($result_edit_ucuser == false){
						$this->redirectPath("error","",$this->objucenter->error);
					}
				}
				$this->objmember->modifyMember($this->_input,$_SESSION['s_login']['id'],"password");
				/**
		         * 创建网站邮件发送内容信息对象
		         */
				require_once("sendsitemail.class.php");
				$obj_send_site_mail = new SendSiteMail();
				//邮件内容参数
				$default_array = array(
					'website'=>$this->_configinfo['websit']['site_title'],
					'site_url'=>$this->_configinfo['websit']['site_url'],
					'username'=>$member_array['login_name'],
					'newpass'=>$this->_input['txtPassword']
				);
				//取后台设定的模板内容
				$obj_send_site_mail->smtpconfig = $this->_configinfo;
				$obj_send_site_mail->SendMail('modipass',$default_array,$member_array['email']);

				$this->redirectPath("succ","member/own_member.php?action=password",$this->_lang['langMPasswordAmendOk']);
			}else{
				$this->redirectPath("error","",$this->_lang['errMPassword']);
			}
		}
	}

	/**
	 * 个人实名认证
	 */
	function _personal_certify(){
		//判断个人实名认证状态
		//得到会员资料
		$condition['id'] = $_SESSION['s_login']['id'];
		$member_array = $this->objmember->getMemberInfo($condition,'*','more');
		//未认证和系统拒绝认证状态可以继续，其他返回信息
		switch ($member_array['personal_certify']){
			case '0'://未认证
				break;
			case '1'://认证中
				$this->redirectPath("error","",$this->_lang['langMPersonalCertifying']);
				break;
			case '2'://通过认证
				$this->redirectPath("error","",$this->_lang['langMPersonalCertifyed']);
				break;
			case '3'://拒绝认证
				break;
		}
		/**
		 * 页面输出
		 */
		$this->output('member_array',$member_array);
		$this->output('personal_certify',$member_array['personal_certify']);
		$this->output('personal_certify_deny_reason',$member_array['personal_certify_deny_reason']);
		$this->output('allowuploadimagetype',$this->_configinfo['file']['allowuploadimagetype']);
		$this->showpage("own_member.personal_certify");
	}

	/**
	 * 保存个人实名认证
	 */
	function _personal_certify_save(){
		//上传图片
		require_once('uploadfile.class.php');
		$upload = new UploadFile();
		$upload->allow_type = explode(',',$this->_fileconfig['allowuploadimagetype']);
		$resize_width = 428;
		$resize_height = 270;
		//正面
		$filename = $upload->upfile('identity_card_copy_up');
		if ($filename != ''){
			//缩略图
			include_once ('resizeImage.class.php');
			new resizeImage($filename['filename'],$resize_width,$resize_height,'0','.');

			$this->_input['identity_card_copy_up'] = $filename["getfilename"];
		}else {
			$this->redirectPath("error","",$this->_lang['errMPersonalCertifyCardUpIsWrong'].$this->_configinfo['file']['allowuploadimagetype']);
		}
		unset($filename);
		//背面
		$filename = $upload->upfile('identity_card_copy_back');
		if ($filename != ''){
			//缩略图
			include_once ('resizeImage.class.php');
			new resizeImage($filename['filename'],$resize_width,$resize_height,'0','.');

			$this->_input['identity_card_copy_back'] = $filename["getfilename"];
		}else {
			$this->redirectPath("error","",$this->_lang['errMPersonalCertifyCardBackIsWrong'].$this->_configinfo['file']['allowuploadimagetype']);
		}
		unset($filename);
		//更新会员资料
		$array = array();
		$array['personal_certify'] = 1;//认证中
		$array['personal_certify_identitycard_up'] = $this->_input['identity_card_copy_up'];
		$array['personal_certify_identitycard_back'] = $this->_input['identity_card_copy_back'];
		$result = $this->objmember->modifyMember($array,$_SESSION['s_login']['id'],"personal_certify");
		if ($result === true){
			//实名认证
			CreditsClass::saveCreditsLog('member_certify',$_SESSION["s_login"]['id'],false);

			$this->redirectPath("succ","member/own_main.php",$this->_lang['langMPersonalCertifySubmitIsSucc']);
		}else {
			$this->redirectPath("error","",$this->_lang['errMPersonalCertifySubmitIsFail']);
		}
	}

}
$member = new OwnMemberManage();
$member->main();
unset($member);
?>

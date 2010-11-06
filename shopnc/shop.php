<?php
/////////////////////////////////////////////////////////////////////////////
// 这个文件是 shopnc单用户 项目的一部分
//
// Copyright (c) 2007 - 2008 www.shopnc.net
//
// 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件，
// 或者访问 http://www.shopnc.net/ 获得详细信息。
/////////////////////////////////////////////////////////////////////////////

/**
* FILE_NAME : shop.php D:\binzi\shiyan_shopnc6\shop.php
* 商家处理，投票查看
*
* @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
* @author 网城创想单用户商城开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Tue Mar 03 09:40:21 CST 2009
*/
require ("global.inc.php");
class ShowShop extends CommonFrameWork {
	/**
	 * 供应商对象
	 *
	 * @var obj
	 */
	private $obj_admin_provider;
	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	private $objvalidate;
	/**
	 * 投票对象
	 *
	 * @var obj
	 */
	private $obj_vote;
	function main(){
		/**
		 * 创建供应商对象
		 */
		if (!is_object($this->obj_admin_provider)) {
			require_once("provider.class.php");
			$this->obj_admin_provider = new ProviderClass();
		}
		/**
		 * 创建投票对象
		 */
		if(!is_object($this->obj_vote)) {
			require_once("vote.class.php");
			$this->obj_vote = new VoteClass();
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
		$this->getlang("index,header_footer,shop");

		/**
		 * 执行操作
		 */
		switch($this->_input['action']){
			case 'shop_register':		//商家入驻
			$this->shopRegister();
			break;
			case 'check_shop':			//检查商家是否已被使用
			$this->checkShop();
			break;
			case 'check_code':			//检查验证码
			$this->checkCode();
			break;
			case 'shop_save':			//商家保存
			$this->shopSave();
			break;
			case 'web_map':				//网站地图
			$this->showWebMap();
			break;
			default:
				$this->viewVote();
		}
	}
	/**
	 * 商家入驻页面
	 *
	 */
	private function shopRegister() {
		/*添加验证信息*/
		include("seride.php");
		$Seride = new Seride();
		$this->output('seride_form',$Seride->seride_form());
		
		$this->showpage('shop_register');
	}
	/**
	 * 商家保存
	 *
	 */
	private function shopSave() {
		/**
		 * 验证信息
		 */
        include("seride.php");
        $Seride = new Seride();
        $Seride->seride_check($this->_charset);
        
		$input_param['txt_provider_pname']		= $this->_input['reg_user'];		//供应商名称
		$input_param['txt_provider_name']       = $this->_input['reg_user'];		//供应商帐号
		$input_param['txt_provider_passwd']		= $this->_input['reg_pass'];		//供应商密码
		$input_param['txt_provider_email']		= $this->_input['reg_mail'];		//电子邮件
		$input_param['txt_provider_state']		= 0;								//供应商状态

		/*商家信息验证*/
		$this->objvalidate->setValidate(array("input"=>$input_param['txt_provider_pname'],	"require"=>"true","message"=>$this->_lang['shop_user_null']));
		$this->objvalidate->setValidate(array("input"=>$input_param['txt_provider_passwd'],	"require"=>"true","validator"=>"Compare","operator"=>"==","to"=>$this->_input['reg_rpass'],"message"=>$this->_lang['shop_email_null']));
		$this->objvalidate->setValidate(array("input"=>$input_param['txt_provider_email'],	"require"=>"true","validator"=>"Email","message"=>$this->_lang['email_error']));
		/*判断验证码是否开启*/
		if($this->_viewinfo['websit']['view_provider_validate'] == '1') {
			$this->objvalidate->setValidate(array("input"=>strtoupper($this->_input['reg_code']),"require"=>"true","validator"=>"Compare","operator"=>"==","to"=>strtoupper($_SESSION['seccode']),"message"=>$this->_lang['shop_code_error']));  //您输入的验证码不对!
		}
		$error = $this->objvalidate->validate();
		if ($error != "" ){
			//返回错误信息
			$this->showMessage($error,$this->_configinfo['websit']['site_url']."/shop.php?action=shop_register",1,2000);
		}

		$rs = $this->obj_admin_provider->addProvider($input_param);
		if($rs) {
			$this->showMessage($this->_lang['shop_save_ok'],$this->_configinfo['websit']['site_url']."/index.php",1,2000);
		} else {
			$this->showMessage($this->_lang['shop_save_no'],$_SERVER['HTTP_REFERER'],1,2000);
		}
	}
	/**
	 * 检查商家是否存在
	 *
	 */
	private function checkShop() {
		$provider_array = $this->obj_admin_provider->getProviderInfo(array('provider_name'=>"'".$this->_input['username']."'"));
		if(count($provider_array) > 0) {
			echo 1;
			exit;
		}
		echo 0;
	}
	/**
	 * 验证码校验
	 *
	 */
	private function checkCode() {
		if (strtoupper($this->_input['checkcode']) == strtoupper($_SESSION['seccode'])){
			echo  0;
		}else {
			echo  1;
		}
	}
	/**
	 * 查看投票内容
	 *
	 */
	private function viewVote() {
		$vote_id		= intval($this->_input['vote_id']);
		if($vote_id == 0) {
			header("Location:index.php");
			exit();
		}

		/*投票操作*/
		if(!empty($this->_input['txt_option_id'])) {
			/* 检查是否是可以非会员投票 */
			$vote_array[1]	= $this->obj_vote->getVote($vote_id);
			if($vote_array[1]['0']['vote_member'] == 1) {
				if($_SESSION['userinfo']['user_id'] == '') {
					$this->showMessage($this->_lang['vote_view_membervote'],$this->refer_url,1);
				}
			}

			if (is_array($this->_input['txt_option_id'])) {
				foreach ($this->_input['txt_option_id'] as $value) {
					if(intval($value) != 0) {
						$this->obj_vote->addOption(intval($value));
					}
				}
			}
			else {
				if(intval($this->_input['txt_option_id']) != 0) {
					$this->obj_vote->addOption(intval($this->_input['txt_option_id']));
				}
			}
		}

		if($vote_id != 0) {
			$vote_array[1]	= $this->obj_vote->getVote($vote_id);
			$vote_array[0]	= array('title'=>$vote_array[1][0]['vote_title'],'vote_id'=>$vote_array[1][0]['vote_id']);
			$this->output('vote_array',$vote_array);
			/*投票总数*/
			$vote_option_num = $this->obj_vote->getVoteSum($vote_id);
			$this->output('vote_option_num',$vote_option_num[0][0]);
		}
		$this->showpage('vote_view');
	}
	/**
	 * 网站地图
	 *
	 */
	private function showWebMap() {
		/*获得一级分类*/
		include(BasePath."/share/goods_class_show.php");
		$array	= array();
		$i	= 0;
		foreach ($node_cache as $k => $v) {
			if($v[1] == 0) {
				$array[$i]['class_id']		= $v[0];
				$array[$i]['class_top_id']	= $v[1];
				$array[$i]['class_name']	= $v[2];
				$array[$i]['key_id']		= $k;
				$array[$i]['key']			= $i;
				$i++;
			}
		}
		$class_array	= $array;
		/*获得其他下级分类*/
		$sub_class		= array();
		foreach ($class_array as $x) {
			$k	= 0;
			for($j=($x['key_id']+1);$j<count($node_cache);$j++) {
				if($x['class_top_id'] == 0) {
					if($node_cache[$j][1] == 0) break;
					$sub_class[$k]['class_id'] = $node_cache[$j][0];
					$sub_class[$k]['class_name'] = $node_cache[$j][2];
				}
				$k++;
			}
			$class_array[$x['key']]['sub_class'] = $sub_class;
			unset($sub_class);
		}
		$this->output('class_array',$class_array);
		$this->showpage('map');
	}
}
$shop = new ShowShop();
$shop->main();
unset($shop);
?>
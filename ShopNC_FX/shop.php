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
* FILE_NAME : shop.php D:\root\shopnc6_jh\shop.php
* 商家处理，投票查看
*
* @copyright Copyright (c) 2007 - 2009 www.shopnc.net 
* @author 网城创想分销王系统开发团队 php_netproject@yahoo.com.cn
* @package 
* @subpackage 
* @version Sat Jul 04 10:49:42 CST 2009
*/
require ("global.inc.php");
class ShowShop extends CommonFrameWork {
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
			/*case 'shop_register':		//商家入驻
			$this->shopRegister();
			break;*/
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
		include(BasePath."/share/".NC_SHOP_DIR."goods_class_show.php");
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
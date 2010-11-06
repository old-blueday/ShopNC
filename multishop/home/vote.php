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
 * FILE_NAME : vote.php   FILE_PATH : E:\www\multishop\home\vote.php
 * 投票管理
 *
 * @copyright Copyright (c) 2007 - 2007 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Wed Feb 13 14:01:51 CST 2008
 */

require ("../global.inc.php");

class VoteIndex extends CommonFrameWork{
	/**
	 * 投票对象
	 *
	 * @var obj
	 */
	var $obj_vote;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	
	function main(){
		/**
		 * 创建商铺对象
		 */
		if (!is_object($this->obj_vote)){
			require_once("vote.class.php");
			$this->obj_vote = new VoteClass();
		}
		/**
		 * 初始化分页类
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		
		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");

		/**
		 * 语言包
		 */
		$this->getlang("vote");

		switch ($this->_input['action']){
			case "vote":
				$this->_vote();
				break;
			case "list":
				$this->_list();
				break;
			case "show":
				$this->_show();
				break;
			case "view":
				$this->_view();
				break;
			default:
				exit;
		}

	}

	/**
	 * 投票操作
	 *
	 */
	function _vote(){
		$vote_array = $this->obj_vote->getOneVote($this->_input['vote_id']);
		//判断是否关闭
		if($vote_array['vote_close'] == '1'){
			$this->_show_message('1',$this->_lang['errVoteIsClose']);
		}
		/*取cookie*/
		$str = $this->getCookies('c_vote');
		/*判断是否只允许会员投票*/
		if ($this->_input['vote_member'] == '1') {
			if ($_SESSION['s_login'] == '') {
				$this->_show_message('1',$this->_lang['errVotePollLogin']);
			}
		}
		/*判断是否可以重复投票*/
		if ($this->_input['vote_refresh'] == '0') {
			if (strstr($str,'|'.$this->_input['vote_id'].'|')) {
				$this->_show_message('1',$this->_lang['errVotePoll']);
			}
		}
		/*判断选项是否为空*/
		if ($this->_input['vote_check'] == ''){
			$this->_show_message('1',$this->_lang['errVoteNotNull']);
		}else {
			$line = '|';
			foreach ($this->_input['vote_option'] as $k => $v){
				$line .= $v.'|';
				if (is_array($this->_input['vote_check'])) {
					if (in_array($k,$this->_input['vote_check'])) {/*如果选项选中*/
						$line .= $this->_input['vote_num'][$k]+1;
					}else {
						$line .= $this->_input['vote_num'][$k];
					}
				}else if ($this->_input['vote_check'] != '') {
					if ($k == $this->_input['vote_check']) {/*如果选项选中*/
						$line .= $this->_input['vote_num'][$k]+1;
					}else {
						$line .= $this->_input['vote_num'][$k];
					}
				}
				$line .= '|';
			}
		}
		//更新记录
		$input_param = array();
		$input_param['vote_id'] = $this->_input['vote_id'];
		$input_param['vote_content'] = $line;
		$this->obj_vote->modiVote($input_param);
		
		//写入cookie中，用于判断是否重复投票
		if ($str != '' && !strstr($str,'|'.$this->_input['vote_id'].'|')) {
			$str .= $this->_input['vote_id'].'|';
			$this->setCookies("c_vote", $str);
		}else if ($str == '') {
			$this->setCookies("c_vote", '|'.$this->_input['vote_id'].'|');
		}
		$url = "../home/vote.php?action=view&vote_id=".$this->_input['vote_id'];
		$this->_show_message($this->_input['type'],$this->_lang['langVotePollSucceed'],$url);
	}
	
	/**
	 * 投票主题列表
	 */
	function _list(){
		
		/*更新投票列表，关闭过期投票*/
		$this->obj_vote->updateVoteOutTimeSetClose();
		
		$this->obj_page->pagebarnum(15);
		$condition['order'] = 'desc';
		$condition['show_date'] = time();
		$vote_array = $this->obj_vote->listVote($condition,$this->obj_page);
		$page_list = $this->obj_page->show(1);
		/**
		 * 页面输出
		 */
		$this->output('page_list',$page_list);
		$this->output('vote_array',$vote_array);
		$this->showpage("vote.list");
	}
	
	/**
	 * 投票显示
	 */
	function _show(){
		$vote_array = $this->obj_vote->getOneVote($this->_input['vote_id']);
		if (is_array($vote_array)){
			$line = @explode('|',trim($vote_array['vote_content'],'|'));
			$i = 0;
			foreach ($line as $k2 => $v2){
				if ($k2%2 == 0) {
					$vote_array['content'][$i]['option'] = $v2;
				}else {
					$vote_array['content'][$i]['num'] = $v2;
					$i++;
				}
			}
		}
		$array[0] = $vote_array;
		/**
		 * 页面输出
		 */
		$this->output('type',$this->_input['type']);
		$this->output('vote_array',$array);
		$this->showpage("vote.show");
	}
	
	/**
	 * 提示信息输出方式
	 */
	function _show_message($type,$msg,$url=''){
		if ($type == '1') {
			echo "<script> alert('$msg');window.close(); </script>";
		}else{
			$this->redirectPath("error","$url","$msg");
		}
		exit;
	}
	
	/**
	 * 投票显示信息
	 */
	function _view(){
		$vote_array = $this->obj_vote->getOneVote($this->_input['vote_id']);
		if (is_array($vote_array)){
			$line = @explode('|',trim($vote_array['vote_content'],'|'));
			$i = 0;
			foreach ($line as $k2 => $v2){
				if ($k2%2 == 0) {
					$vote_array['content'][$i]['option'] = $v2;
				}else {
					$vote_array['content'][$i]['num'] = $v2;
					$num += $v2;
					$i++;
				}
			}
		}
		if ($num == '') {
			$num = 1;
		}
		/**
		 * 页面输出
		 */
		$this->output('num',$num);
		$this->output('vote_array',$vote_array);
		$this->showpage('vote.view');
	}	
}
$vote_index = new VoteIndex();
$vote_index->main();
unset($vote_index);
?>
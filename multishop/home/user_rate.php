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
 * FILE_NAME : user_rate.php
 * ....信誉分显示
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net 
 * @author ShopNC Develop Team 
 * @package 
 * @subpackage 
 * @version Fri Oct 19 13:36:46 CST 2007
 */

require_once("../global.inc.php");

class StoreRate extends CommonFrameWork{
	/**
	 * 评价对象
	 *
	 * @var obj
	 */
	var $obj_score;
	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $objmember;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;
	/**
	 * 商品对象
	 *
	 * @var obj
	 */
	var $obj_product;
	/**
	 * 地区信息
	 *
	 * @var obj
	 */
	var $obj_area;
	/**
	 * 商店信息
	 *
	 * @var obj
	 */
	var $obj_shop;
	/**
	 * 投诉举报
	 *
	 * @var obj
	 */
	var $obj_complaint;

	function main(){
		/**
		 * 创建评价对象
		 */
		if (!is_object($this->obj_score)){
			require_once("score.class.php");
			$this->obj_score = new ScoreClass();
		}
		/**
		 * 创建会员对象
		 */
		if (!is_object($this->objmember)){
			require_once ("member.class.php");
			$this->objmember = new MemberClass();
		}
		/**
		 * 创建商品对象
		 */
		if (!is_object($this->obj_product)){
			require_once("product.class.php");
			$this->obj_product = new ProductClass();
		}
		/**
		 * 创建分页对象
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}
		/**
		 * 实例化地区类
		 */
		if (!is_object($this->obj_area)){
			require_once("area.class.php");
			$this->obj_area = new AreaClass();
		}
		/**
		 * 实例化商店类
		 */
		if (!is_object($this->obj_shop)){
			require_once("shop.class.php");
			$this->obj_shop = new ShopClass();
		}
		/**
		 * 实例化投诉举报类
		 */
		if (!is_object($this->obj_complaint)){
			require_once("complaint.class.php");
			$this->obj_complaint = new Complaint();
		}

		/**
		 * 设置模板路径
		 */
		$this->setsubtemplates("home");

		/**
		 * 语言包
		 */
		$this->getlang("store,store_rate");

		/**
		 * 得到会员资料
		 */
		$condition['id'] = $this->_input['userid'];
		$member_array = $this->objmember->getMemberInfo($condition,"*","more");

		if(empty($member_array)){
			$this->redirectPath('error','',$this->_lang['langCUserIdIsInvalid']);
		}


		$member_array['sms_username']	= urlencode($member_array['login_name']);	//将传递的用户名称用urlencode加密，这里用了和信息发送的键名相同，可以修改为其他。

		//卖家评价数字统计
		$sel_condition['grade_member_id'] = $this->_input['userid'];
		$sel_condition['genre'] = 's';
		$sell_score = $this->obj_score->getScore($sel_condition,$page);
		//统计卖家信用
		$sell_sta = $this->obj_score->getCountUserScore($sell_score);
		//买家评价数字统计
		$buy_condition['grade_member_id'] = $this->_input['userid'];
		$buy_condition['genre'] = 'b';
		$buy_score = $this->obj_score->getScore($buy_condition,$page);
		//统计买家信用
		$buy_sta = $this->obj_score->getCountUserScore($buy_score);
		//得到会员等级
		$buy_score_level = $this->objmember->creditLevel($member_array['buy_score']);
		$sell_score_level = $this->objmember->creditLevel($member_array['sale_score']);
		$condition_list['score'] = $this->_input['score'];//评价等级
		$condition_list['time'] = $this->_input['time'];//评价时间
		switch ($this->_input['time']) {
			case 'week'://最近1周
			$time = $this->_lang['langSRateLatelyOneWeek'];
			break;
			case 'month'://最近1个月
			$time = $this->_lang['langSRateLatelyOneMonth'];
			break;
			case 'six_month'://最近6个月
			$time = $this->_lang['langSRateLatelySixMonth'];
			break;
			case 'former_six_month'://6个月前
			$time = $this->_lang['langSRateSixMonthFormer'];
			break;
		}
		switch ($this->_input['score']) {
			case '1':
				$score_type = $this->_lang['langSRateReputably'];
				break;
			case '0':
				$score_type = $this->_lang['langSRateMiddlingAppraise'];
				break;
			case '-1':
				$score_type = $this->_lang['langSRateLowAppraise'];
				break;
			default:
				$score_type = $this->_lang['langSetComment'];
		}
		if ($this->_input['genre'] == 's') {
			$genre_type = $this->_lang['langStoreBuyer'];
		} else {
			$genre_type = $this->_lang['langStoreSeller'];
		}
		//评价列表
		$this->obj_page->pagebarnum(15);
		if ($this->_input['genre'] !== '' && $this->_input['genre'] !== 'set'){//评价类型
			$condition_list['genre'] = $this->_input['genre'];
			$condition_list['grade_member_id'] = $this->_input['userid'];//被评价人
		}else if ($this->_input['genre'] == 'set'){//给他人的评价
			$condition_list['member_id'] = $this->_input['userid'];//评价人
		}else {
			$condition_list['grade_member_id'] = $this->_input['userid'];//被评价人
		}
		$condition_list['order_by'] = 'score.pubtime desc'; //按照时间降序
		$score_array = $this->obj_score->getScore($condition_list,$this->obj_page);
		if (is_array($score_array)){
			foreach ($score_array as $k => $v){
				$score_array[$k]['pubtime'] = @date("Y-m-d H:i",$v['pubtime']);
			}
		}
		$score_array = $this->obj_product->checkProductIfHtml($score_array,$this->_configinfo['productinfo']['ifhtml']);
		$pagelist = $this->obj_page->show(2);      //分页显示

		//取店铺内容
		if ($member_array['member_type'] == '1'){//有店铺
			$shop_array = $this->obj_shop->getOneShopByMemeberId($member_array['member_id'],1);
			//取店铺地区
			if ($shop_array['shop_area_id'] !=''){
				$sel_area = $this->obj_area->getAreaPathList($shop_array['shop_area_id']);
			}
		}
		
		//取投诉举报类型
		$complaint_type = $this->_b_config['complaint_report_type'];
		
		//取店主被举报记录
		$condition_report['send_receive'] = 'receive';
		$condition_report['member_id'] = $this->_input['userid'];
		$condition_report['class'] = 'report';
		$report_list = $this->obj_complaint->getComplaintList($condition_report,$obj_page);

		//整理举报
		if (is_array($report_list)) {
			foreach ($report_list as $k_l => $v_l){
				if (!empty($report)) {
					foreach ($report as $k_r => $v_r){
						if ($v_r['type'] == $v_l['c_r_type']) {
							$report[$k_r]['num']++;
							continue 2;
						}
					}
				}
				$report[count($report)]['type'] = $v_l['c_r_type'];  //举报类型
				$report[count($report)-1]['num'] = 1;  //被举报次数
				if (is_array($complaint_type)) {
					foreach ($complaint_type as $k_t => $v_t){
						if ($k_t == $v_l['c_r_type']) {
							$report[count($report)-1]['type_name'] = $v_t;  //举报类型名称
						}
					}
				}
			}
			unset($condition_report,$report_list,$complaint_type);
		}

		/**
		 * 页面输出
		 */
		
		$this->output('title_message',$this->_lang['langStoreCredit'].'-');
		$this->output('sale_count',@array_sum($sell_sta));//卖家数量统计
		$this->output('buy_count',@array_sum($buy_sta));//买家数量统计
		$this->output('score_array',$score_array);//评价列表
		$this->output('pagelist',$pagelist);//输出消息分页
		$this->output('genre',$this->_input['genre']);//评价条件-买家或卖家
		$this->output('score',$this->_input['score']);//评价条件-评价等级，好评-中评-差评
		$this->output('frame_shop_info',$member_array);//会员资料
		$this->output('sell_sta',$sell_sta);//卖家信誉统计
		$this->output('buy_sta',$buy_sta);//买家信誉统计
		$this->output('buy_score_level',$buy_score_level);//买家等级
		$this->output('sell_score_level',$sell_score_level);//卖家等级
		$this->output('time',$time);//选择时间
		$this->output('score_type',$score_type);//评价类型
		$this->output('genre_type',$genre_type);//买、卖家
		$this->output('sel_area',$sel_area);
		$this->output('report',$report);//举报统计
		$this->showpage("user_rate");
	}
}
$rate = new StoreRate();
$rate->main();
unset($rate);
?>
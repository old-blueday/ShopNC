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
 * FILE_NAME : own_message.php   FILE_PATH : \multishop\member\own_message.php
 * ....短消息管理
 *
 * @copyright Copyright (c) 2007 - 2010 www.shopnc.net
 * @author ShopNC Develop Team
 * @package
 * @subpackage
 * @version Sat Sep 22 11:02:30 CST 2007
 */

require ("../global.inc.php");
class OwnMessageManage extends memberFrameWork{
	/**
	 * 短消息对象
	 *
	 * @var obj
	 */
	var $obj_message;

	/**
	 * 验证对象
	 *
	 * @var obj
	 */
	var $objvalidate;
	/**
	 * 分页对象
	 *
	 * @var obj
	 */
	var $obj_page;

	/**
	 * 会员对象
	 *
	 * @var obj
	 */
	var $objmember;

    /**
     * UCenter 对象
     *
     * @var obj
     */
    var $objuc;

    /**
     * 好友选择框对象
     *
     * @var obj
     */
    var $obj_selectfriend;

	function main(){

		/**
		 * 语言包
		 */
		$this->getlang("shop");

		/**
		 * 菜单输出
		 */
		$navi_curr = $this->_input['action'] == 'add' ? 'site_message_send' : 'site_message_manage';
		$this->memberMenu('account','site_message',$navi_curr);
		/**
		 * 创建短消息对象
		 */
		if (!is_object($this->obj_message)){
			require_once("message.class.php");
			$this->obj_message = new MessageClass();
		}

        /**
         * 如果开启UC整合功能则自动在URL操作前增加`uc_`前缀
         *
         */
        if($this->_configinfo['api']['open_passport'] == 1 && $this->_configinfo['api']['passport_type'] == 2 and 1==2 ) {
            $this->_input['action'] = 'uc_'.$this->_input['action'];

            // 默认操作
            $defaultAction = '_ucMessageNewpm';

            /**
             * 创建Uc对象
             */
            if(!is_object($this->objuc)) {
                require_once 'ucenter.class.php';
                $this->objuc = new ucenterClass();
            }

            /**
             * 创建好友选择对象
             */
            if(!is_object($this->obj_selectfriend)) {
                require_once 'selectfriend.class.php';
                $this->obj_selectfriend = new SelectFriend();
            }
        } else {
            // 如果在没有开启UC整合情况下强行通过URL传递uc_xxx操作则删除前缀
            if(substr($this->_input['action'],0,3) == 'uc_') {
                $this->_input['action'] = substr($this->_input['action'],3);
            }

            // 默认操作
            $defaultAction = '_messageNewpm';
        }

        /**
         * 根据参数调用相应的操作方法
         */
        switch($this->_input['action']) {
        case 'uc_add':// 发送信息
            $this->_ucMessageAdd();
        break;
        case 'add':
            $this->_messageAdd();
        break;

        case 'uc_save':// 发送信息保存
            $this->_ucMessageSave();
        break;
        case 'save':
            $this->_saveMessage();
        break;

        case 'uc_show':// 显示信息
            $this->_ucMessageShow();
        break;
        case 'show':
            $this->_messageShow();
        break;

        case 'uc_reply':// 信息回复
            $this->_ucMessageReply();
        break;
        case 're':
            $this->_reMessage();
        break;

        case 'uc_del':// 信息删除
            $this->_ucMessageDel();
        break;
        case 'del':
            $this->_delMessage();
        break;

        case 'uc_private'://私人信息
            $this->_ucMessagePrivate();
        break;

        case 'clean':// 信息清空
            $this->_clean_message();
        break;

        case 'uc_newpm':// (未读信息)
            $this->_ucMessageNewpm();
        break;

        /*case 'uc_sendbox':// 发件箱
            $this->output('InfoSelectorTarget',Common::getTargetMenu("uc_message"));
            $this->_ucMessageSendbox();
        break;
        case 'sendbox':
            $this->output('InfoSelectorTarget',Common::getTargetMenu("message"));
            $this->_messageSendbox();
        break;*/

        case 'uc_system'://系统消息
            $this->_ucMessageSystem();
        break;

        case 'uc_common'://公共消息
            $this->_ucMessageCommon();
        break;

        case 'send'://
            //选项卡：收件箱；发件箱
            $this->output('InfoSelectorTarget',Common::getTargetMenu("message"));
            $this->_getList("send");
        break;
        case 'derived':
            $this->_derived_message();
        break;

        case 'uc_ucenter':
            $this->_uc_ucenter();
        break;
        default://默认操作
            $this->$defaultAction();
        break;
        }
	}
    /**
     * 测试方法
     */
    function __call($method,$args) {
        echo "method <b>{$method}</b> not exists.";
    }

    /**
     * 显示消息
     */
    function _ucMessageShow() {
        $pmid = empty($this->_input['pmid'])?0:floatval($this->_input['pmid']);
        $touid = empty($this->_input['touid'])?0:intval($this->_input['touid']);
        $daterange = empty($this->_input['daterange'])?1:intval($this->_input['daterange']);

        if($touid) {
            $message_array = $this->objuc->pm_view($_SESSION['s_login']['id'],0,$touid,$daterange);
        } elseif($pmid) {
            $message_array = $this->objuc->pm_view($_SESSION['s_login']['id'],intval($this->_input['pmid']));
        }
        //如果短消息不存在
        if(empty($message_array)) $this->redirectPath('error','',$this->_lang['langMsgNotExists']);

        $this->output('pmid',empty($message_array) ? 0 : $message_array['0']['pmid']);
        $this->output('message_array',$message_array);
        $this->output('isreply','on');
        $this->showpage('uc_own_message.show');
    }
    function _messageShow() {
        $this->_getMessage();
    }



	/**
     * Uc Ucenter
     */
	function _uc_ucenter() {
		if(1 === intval($this->_input['isajax']) && is_object($this->objuc)) {
			//获取数据分类
			$type_id = intval($this->_input['typeId']);
			$type_id = $type_id?(in_array($type_id,array(1,2)) ? $type_id :1):1;

			//获取分页设置
			$pagesize = 12;
			$page = abs(intval($this->_input['p']));
			if($page <= 0) {
				$page = 1;
			}
			require_once('json.class.php');
			$obj_json = new Services_JSON();
			//判断操作
			$act = in_array($this->_input['act'],array('getcount','getlist')) ? $this->_input['act'] : 'getlist';

			//获取分类(群组\好友)
			switch($type_id) {
				case 2:
					switch($act) {
						case 'getcount':
							echo $this->objuc->nc_getgroup($_SESSION['s_login']['id'],'user',true);
							exit();
							break;

						default:
							$datas = $this->objuc->nc_getgroup($_SESSION['s_login']['id'],'user');
							$uchome = $this->objuc->nc_getapp_by_type('DISCUZX');
							$data = array();
							foreach ((array)$datas as $key=>$val) {
								$array = array();
								$array['id'] = $val['fid'];
								$array['name'] = Common::nc_change_charset($val['name'],'gbk_to_utf8');
								$array['pic'] = empty($val['pic']) ? $uchome['url'].'/static/image/common/groupicon.gif' : $uchome['url'].'/data/attachment/group/'.$val['pic'];
								$data[] = $array;
							}
							break;
					}
					break;

				default:
					switch($act) {
						case 'getcount':
							echo $this->objuc->friend_totalnum($_SESSION['s_login']['id'],0);
							exit();
							break;

						default:
							$datas = $this->objuc->friend_list($_SESSION['s_login']['id'],$page,$pagesize);
							$data = array();
							foreach ((array)$datas as $key=>$val) {
								$array = array();
								$array['id'] = $val['friendid'];
								$array['name'] = Common::nc_change_charset($val['username'],'gbk_to_utf8');
								$array['pic'] = UC_API."/avatar.php?uid=$val[friendid]&type=small";
								$data[] = $array;
							}
							break;
					}
					break;
			}
			//echo json_encode($data);
			echo $obj_json->encode($data);
		} else {
			echo $obj_json->encode(array());
		}
	}

    /**
     * 发送消息
     */
	function _messageAdd(){
        $message_array = array();
		$message_array['member_name'] = $this->_input['username'];   //接收人
		$this->output('message_array',$message_array);    //输出留言信息
		$this->showpage('own_message.add');    //显示
	}
	function _ucMessageAdd(){
        $isuser = 0;
        $content = '';
        $username = '';

        //如果给指定会员发送短消息
        if(trim($this->_input['username'])) {
            $isuser = 1;
            $this->output('username',urldecode($this->_input['username']));
        } else {
            //如果推荐商品
            if(trim($this->_input['product_recommend'])) {
                $pr = trim($this->_input['product_recommend']);
                if(!class_exists('ProductClass')) {
                    require_once 'product.class.php';
                }
                $obj_product = new ProductClass();
                $product_array = $obj_product->getProductRow($pr);
                if(!empty($product_array)) {
                    $content = $this->_lang['langMessageSharingContent'].$this->_configinfo['websit']['site_url']."/home/product.php?action=view&pid={$pr}<br/><a href='".$this->_configinfo['websit']['site_url']."/home/product.php?action=view&pid={$pr}' target='_blank'>{$product_array['p_name']}</a>";
                }
            }
        }

        //防止恶意提交
        $_SESSION['token'] = sha1(uniqid());
        $this->output('content',$content);
        $this->output('isuser',$isuser);
        $this->output('token',$_SESSION['token']);
		$this->showpage('uc_own_message.add');    //显示
	}

    /**
     * 保存信息
     */
    function _ucMessageSave() {

        $this->_messageSaveValidate();

        $inputName = 'txtReceive_name';
        if(!empty($this->_input['hiddensave']))$inputName='hiddensave';

        // 群发
        $inputReceiveNames = array_unique(array_filter(explode(',',$this->_input[$inputName])));

        if(intval($this->_input['sendtype']) != 1) {
            $users = array();
            foreach ($inputReceiveNames as $val) {
                foreach((array)$this->objuc->nc_getgroup($val,'group') as $item) $users[]=$item['uid'];
            }

            $inputReceiveNames = $users;
        }

        $send_rs = 0;
        foreach ($inputReceiveNames as $k=>$sendObject) {
            //如果是給自己發送
            if($_SESSION['s_login']['id']!=$sendObject) {
                $send_rs = $this->objuc->send_to_pm($_SESSION['s_login']['id'],$sendObject,$this->_input['txtTitle'],$this->_input['txtContent'],1,0,($inputName=='hiddensave' ? 0 : 1));
            }
        }

        if($send_rs > 0) {
            $this->redirectPath("succ",'',$this->_lang['langShopSucSendOk']);
        } else {
            $lang = array(0=>'langMsgSendFail',-1=>'langMsgSendExpired',-2=>'langMsgSendTooFast',-3=>'langMsgSendNoFriend',-4=>'langMsgSendOff');
            $this->redirectPath("error","",$this->_lang[$lang[$send_rs]]);
        }
    }
    /**
     * 数据验证
     */
    function _messageSaveValidate() {
        /**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}

		/**
		 * 验证信息
		 */
        if(is_object($this->objuc)) {
            $input_name = 'hiddensave';
            if(empty($this->_input['hiddensave'])) $input_name = 'txtReceive_name';
        } else{
            $input_name = 'txtReceive_name';
        }

		$this->objvalidate->setValidate(array("input"=>$this->_input[$input_name],"require"=>"true","validator"=>"Compare","operator"=>"!=","to"=>$_SESSION['s_login']['name'],"message"=>$this->_lang['errShopEnterReceiveMan']));    //请填写接受人名称
		$this->objvalidate->setValidate(array("input"=>$this->_input['txtTitle'],"require"=>"true","message"=>$this->_lang['errShopEnterTitle']));    //请填写标题
		$this->objvalidate->setValidate(array("input"=>$this->_input['txtContent'],"require"=>"true","message"=>$this->_lang['errShopEnterContent']));   //请填写内容
		$error = $this->objvalidate->validate();

		if ($error != "" ){
			//发生错误处理
			$this->redirectPath("error","",$error);
            exit;
		}
    }

    /**
     * 信息回复
     */
    function _ucMessageReply() {
        $this->_messageReplyValidate();

        $sendResult = $this->objuc->send_to_pm($_SESSION['s_login']['id'],0,$this->_input['txtContent'],$this->_input['txtContent'],1,$this->_input['pmid']);

        if($sendResult > 0) {
            $this->redirectPath("succ",'',$this->_lang['langShopSucSendOk']);
        } else {
            $lang = array(0=>'langMsgSendFail',-1=>'langMsgSendExpired',-2=>'langMsgSendTooFast',-3=>'langMsgSendNoFriend',-4=>'langMsgSendOff');
            $this->redirectPath("error","",$this->_lang[$lang[$sendResult]]);
        }
    }
    function _messageReplyValidate() {
        if(!is_object($this->objvalidate)) {
            require_once 'commonvalidate.class.php';
            $this->objvalidate = new CommonValidate();
        }
        /**
         * 验证信息
         */
        $this->objvalidate->setValidate(array('input'=>$this->_input['txtContent'],'require'=>'true','message'=>$this->_lang['errShopEnterContent']));
        $this->objvalidate->setvalidate(array('input'=>$this->_input['pmid'],'require'=>'true','message'=>$this->_lang['langMsgNotExists']));
        $error = $this->objvalidate->validate();
        if($error != '') {
            $this->redirectPath('error','',$error);
            exit;
        }
    }

    /**
     * 收件箱
     */
    function _ucMessageNewpm() {
        $this->_ucgetList('inbox','newpm');
        $this->showpage('uc_own_message.list');     //显示
    }
    function _messageNewpm() {
        $this->_getList('receive');
    }

    /**
     * 私人消息
     */
    function _ucMessagePrivate() {
        $this->_ucgetList('inbox','privatepm');
        $this->showpage('uc_own_message.private');
    }

    /**
     * 删除消息
     */
    function _ucMessageDel() {
        $this->_messageDelValidate();

        $pmids = (array)$this->_input['messageid'];

        $delResult = $this->objuc->pm_delete($_SESSION['s_login']['id'],$pmids);

        if(intval($delResult) > 0) {
            $this->redirectPath('error','',$this->_lang['langShopSucDeleMessageOk']);
        } else {
            $this->redirectPath('error','',$this->_lang['langMsgDeleteFaild']);
        }
    }
    function _messageDelValidate() {
        if(!is_object($this->objvalidate)) {
            require_once 'commonvalidate.class.php';
            $this->objvalidate = new CommonValidate();
        }

        $this->objvalidate->setValidate(array('input'=>$this->_input['messageid'],'require'=>'true','message'=>$this->_lang['langMsgNotExists']));

        $error = $this->objvalidate->validate();
        if($error != '') {
            $this->redirectPath('error','',$error);
        }
    }

    /**
     * 公共消息
     */
    function _ucMessageCommon() {
        $this->_ucgetList('inbox','announcepm');
        $this->showpage('uc_own_message.common');
    }

    /**
     * 系统消息
     */
    function _ucMessageSystem() {
        $this->_ucgetList('inbox','systempm');
        $this->showpage('uc_own_message.system');
    }

	/**
	 * 得到收件箱列表
	 *
	 * @param string $genre receive收件列表，send保存的发件列表
	 */
	function _getList($genre){
		/**
		 * 创建分页对象
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}

		$this->obj_page->pagebarnum(20);    //每页20条记录

		//得到登录会员短消息列表
		$condition['genre'] = $genre;
		$condition['member_name'] = $_SESSION['s_login']['name'];
		$condition['order'] = 2;
		$message_array = $this->obj_message->getMessage($condition,$this->obj_page);
		$this->obj_page->new_style = true;
		$pagelist = $this->obj_page->show('member');      //分页显示
		//处理人名称的显示
		if (is_array($message_array)){
			foreach ($message_array as $k=>$v){
				if ($genre == "send"){
					$message_array[$k]['send_name'] = $v['receive_name'];
				}else{
					$message_array[$k]['send_name'] = $v['member_name'];
				}
				$message_array[$k]['send_time'] = @date("Y-m-d H:i",$v['send_time']);
			}
		}

		/*统计信箱信件数量*/
		$condition_num['genre'] = $genre;/*收件 发件 类别*/
		$condition_num['member_name'] = $_SESSION['s_login']['name'];/*用户名*/
		$condition_num['isallowdel'] = 1;/*是否允许删除，1为允许*/
		$condition_num['no_message_id'] = 0;/*排除系统信件*/
		$count = $this->_get_message_num($condition_num);

		/**
		 * 页面输出
		 */
		$this->output('message_genre',$genre);   //输出列表类型
		$this->output('message_array',$message_array);   //输出短消息列表
		$this->output('message_pagelist',$pagelist);      //输出短消息分页
		$this->output('message_num',$count['count']);   //信息数量
		$this->output('message_percent',$count['percent']);   //信息数量
		$this->output('action',$this->_input['action']); //执行动作
		$this->showpage('own_message.list');     //显示
	}
	function _ucgetList($genre,$filter=''){
		/**
		 * 创建分页对象
		 */
		if (!is_object($this->obj_page)){
			require_once("commonpage.class.php");
			$this->obj_page = new CommonPage();
		}

		$this->obj_page->pagebarnum(20);    //每页20条记录

		//得到登录会员短消息列表
        $message_array = $this->objuc->pm_list($_SESSION['s_login']['id'],$this->obj_page->nowindex,20,$genre,$filter,100);
        $this->obj_page->setPage(array('total'=>$message_array['count']));
		$this->obj_page->new_style = true;
		$pagelist = $this->obj_page->show('member');      //分页显示
		//处理人名称的显示
		if (is_array($message_array['data'])){
			foreach ($message_array['data'] as $k=>$v){
				$message_array['data'][$k]['send_time'] = @date("Y-m-d H:i",$v['dateline']);
			}
		}

		/**
		 * 页面输出
		 */
		$this->output('message_genre',$genre);   //输出列表类型
		$this->output('message_array',$message_array['data']);   //输出短消息列表
		$this->output('message_pagelist',$pagelist);      //输出短消息分页
		$this->output('message_num',$message_array['count']);   //信息数量
		$this->output('message_percent',intval($message_array['count']/2));   //信息数量
		$this->output('action',$this->_input['action']); //执行动作
	}

	/**
	 * 发送短消息
	 *
	 */
	function _saveMessage(){
		/**
		 * 创建验证对象
		 */
		if (!is_object($this->objvalidate)){
			require_once("commonvalidate.class.php");
			$this->objvalidate = new CommonValidate();
		}

		/**
		 * 创建会员对象
		 */
		if (!is_object($this->objmember)){
			require_once ("member.class.php");
			$this->objmember = new MemberClass();
		}

		/**
		 * 验证信息
		 */

		$this->objvalidate->setValidate(array("input"=>$this->_input['txtReceive_name'],"require"=>"true","validator"=>"Compare","operator"=>"!=","to"=>$_SESSION['s_login']['name'],"message"=>$this->_lang['errShopEnterReceiveMan']));    //请填写接受人名称
		$this->objvalidate->setValidate(array("input"=>$this->_input['txtTitle'],"require"=>"true","message"=>$this->_lang['errShopEnterTitle']));    //请填写标题
		$this->objvalidate->setValidate(array("input"=>$this->_input['txtContent'],"require"=>"true","message"=>$this->_lang['errShopEnterContent']));   //请填写内容
		$error = $this->objvalidate->validate();

		if ($error != "" ){
			//发生错误处理
			$this->redirectPath("error","",$error);
		}else{
			//验证接受短消息的人是否存在
			if ($this->objmember->checkMemberExist(array("member_name"=>$this->_input['txtReceive_name'])) == true){
				//检查接收短信息人的信箱是否已满
				$condition_num['genre'] = 'receive';/*收件 类别*/
				$condition_num['member_name'] = $this->_input['txtReceive_name'];/*用户名*/
				$condition_num['isallowdel'] = 1;/*是否允许删除，1为允许*/
				$condition_num['no_message_id'] = 0;/*排除系统信件*/
				$count = $this->_get_message_num($condition_num);
				if ($count['count'] == 200){
					$this->redirectPath("error","",$this->_lang['errShopReceiveIsFull']);
				}
				//新增一条站内短消息
				$this->_input['member_name'] = $_SESSION['s_login']['name'];
				$this->_input['txtContent'] = Common::replacebr($this->_input['txtContent']);
				$this->obj_message->addMessage($this->_input);

				//发送消息成功，跳转到成功页面
				$this->redirectPath("succ","member/own_message.php",$this->_lang['langShopSucSendOk']);   //您已经成功给对方发送了短消息！
			}else{
				//发生错误处理
				$this->redirectPath("error","",$this->_lang['errShopReceiveNotExist']);   //您发送的会员不存在
			}
		}
	}

	/**
	 * 得到一条短消息
	 *
	 */
	function _getMessage(){

		//得到会员接受到的某条信息
		$condition['genre'] = $this->_input['genre'];
		$condition['member_name'] = $_SESSION['s_login']['name'];
		$condition['message_id'] = $this->_input['messageid'];
		$message_array = $this->obj_message->getOneMessage($condition);
		$message_array['send_time'] = @date("Y-m-d H:i",$message_array['send_time']);

		/*判断如果是系统短信，关联系统短信内容*/
		if ($message_array['member_name'] == '0' && is_numeric($message_array['content'])){
			$condition = "";
			$condition['message_system_id'] = $message_array['content'];
			$system_content = $this->obj_message->getOneMessage($condition,'content','message_system');
			$message_array['content'] = $system_content['content'];
		}

		/*判断是否未读，如果未读则状态变成已读*/
		if ($message_array['isnew'] == '0'){
			$update_array = array();
			$update_array['isnew'] = 1;
			$this->obj_message->updateMessageState($message_array['message_id'],$update_array);
		}

		$this->output('message_array',$message_array);   //输出留言信息
		$this->output('message_genre',$this->_input['genre']);    //留言类型

		$this->showpage('own_message.show');   //显示
	}

	/**
	 * 回复短消息
	 *
	 */
	function _reMessage(){
		//得到会员接受到的某条信息
		$condition['genre'] = "receive";
		$condition['member_name'] = $_SESSION['s_login']['name'];
		$condition['message_id'] = $this->_input['messageid'];
		$message_array = $this->obj_message->getOneMessage($condition);
		$this->output('message_array',$message_array);    //输出留言信息
		$this->showpage('own_message.add');  //显示
	}


	/**
	 * 删除短消息
	 *
	 */
	function _delMessage(){
		//删除会员接受或发送的某条留言
		if ($this->_input['messageid'] != ""){

			$condition['genre'] = $this->_input['genre'];
			$condition['send_name'] = $_SESSION['s_login']['name'];
			if ($this->_input['genre'] == 'receive'){
				$this->obj_message->delMessage($this->_input['messageid']);
			}elseif ($this->_input['genre'] == 'send'){
				$update_array = array();
				$update_array['issave'] = 0;
				if (is_array($this->_input['messageid'])){
					foreach ($this->_input['messageid'] as $v){
						$this->obj_message->updateMessageState($v,$update_array);
					}
				}else {
					$this->obj_message->updateMessageState($this->_input['messageid'],$update_array);
				}
			}
			$this->redirectPath("succ","member/own_message.php",$this->_lang['langShopSucDeleMessageOk']);//您已经成功删除了短消息
		}else{
			//如果没有删除的内容则返回上一页
			$this->redirectPath("refer");
		}
	}

	/**
	 * 清空收件箱
	 */
	function _clean_message(){

		$genre = $this->_input['genre'];/*收件箱或发件箱*/
		if ($genre == 'receive'){
			$condition['isallowdel'] = 1;
			$condition['genre'] = 'receive';
			$condition['member_name'] = $_SESSION['s_login']['name'];
			$condition['order'] = 2;
			$message_array = $this->obj_message->getMessage($condition,$this->obj_page,'message_id');
			/*清空*/
			if (is_array($message_array)){
				foreach ($message_array as $v){
					$this->obj_message->delMessage($v['message_id']);
				}
			}
		}elseif ($genre == 'send'){
			$condition['isallowdel'] = 1;
			$condition['genre'] = 'send';
			$condition['member_name'] = $_SESSION['s_login']['name'];
			$condition['order'] = 2;
			$message_array = $this->obj_message->getMessage($condition,$this->obj_page,'message_id');
			/*清空*/
			if (is_array($message_array)){
				$update_array = array();
				$update_array['issave'] = 0;
				foreach ($message_array as $v){
					$this->obj_message->updateMessageState($v['message_id'],$update_array);
				}
			}
		}
		$this->redirectPath("succ","member/own_message.php",$this->_lang['langShopSucDeleMessageOk']);//您已经成功删除了短消息
	}

	/**
	 * 导出短信息
	 */
	function _derived_message(){
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=message.htm");
		//这里的filename为显示在WEB客户端的文件名。
		header("Content-Description: PHP5 Generated Data");

		//得到登录会员短消息列表
		$condition['genre'] = $this->_input['genre'];
		$condition['member_name'] = $_SESSION['s_login']['name'];
		$condition['order'] = 2;
		$message_array = $this->obj_message->getMessage($condition,$this->obj_page,'*');
		//处理人名称的显示
		if (is_array($message_array)){
			foreach ($message_array as $k=>$v){
				if ($genre == "send"){
					$message_array[$k]['send_name'] = $v['receive_name'];
				}else{
					$message_array[$k]['send_name'] = $v['member_name'];
				}
				$message_array[$k]['send_time'] = @date("Y-m-d H:i",$v['send_time']);
			}
		}
		$this->output('genre',$this->_input['genre']);   //输出短消息列表
		$this->output('message_array',$message_array);   //输出短消息列表
		$this->showpage('own_message.derived',false);     //显示
	}

	/**
	 * 统计信箱信件数量
	 */
	function _get_message_num($condition){

		$array = $this->obj_message->getMessage($condition,$this->obj_page,'*');
		/*计算信件数量比例*/
		if ($condition['genre'] == 'send'){
			$result['percent'] = intval(count($array));
		}else if ($condition['genre'] == 'receive'){
			$result['percent'] = intval(count($array)/2);
		}
		$result['count'] = count($array);
		return $result;
	}


}
$message = new OwnMessageManage();
$message->main();
unset($message);
?>
<?php 
require_once("../global.inc.php");
class HelpIndex extends CommonFrameWork{
	function main(){
		/**
		 * 设置模版路径
		 */
		$this->setsubtemplates('home');
		
		$result=$GLOBALS['db']->GetAllRow('shop_help', 'h_id,h_title,h_content,h_parent_id', 'where h_parent_id=0 and h_id<>1 order by h_seq_num');
		$aData=array();
		foreach ($result as $row){
			$aTemp=array();
			$aTemp['h_id']=$row['h_id'];
			$aTemp['h_title']=$row['h_title'];
			$aTemp['h_content']=$row['h_content'];
			$aTemp['h_parent_id']=$row['h_parent_id'];
			$aTemp['son']=array();
			$result1=$GLOBALS['db']->GetAllRow('shop_help', 'h_id,h_title,h_parent_id', "where h_parent_id={$row['h_id']} order by h_seq_num");
			foreach ($result1 as $row1){
				$aTemp1=array();
				$aTemp1['h_id']=$row1['h_id'];
				$aTemp1['h_title']=$row1['h_title'];
				$aTemp1['h_parent_id']=$row1['h_parent_id'];
				$aTemp['son'][]=$aTemp1;
				unset($aTemp1);
			}
			$aData[]=$aTemp;
			unset($aTemp, $result1);
		}
		unset($result);
		
		if(!isset($this->_input['keyword'])){
			$h_id=isset($_GET['h_id'])?$_GET['h_id']:1;
			$result2=$GLOBALS['db']->GetOneRow($h_id, 'shop_help', 'h_id', 'h_content');
			$h_content=$result2['h_content'];
			unset($result2);
		}
		/**
		 * 帮助搜索列表
		 */
		if (!empty($this->_input['q'])) {
			$q = $this->_input['q'];
			$result3 = $GLOBALS['db']->GetAllRow('shop_help', 'h_id,h_title', "where h_title like '%{$q}%' and h_parent_id>0 order by h_id");
			$h_content = '<div class="main-content"><div class="inner"><ul class="path"><li>帮助中心首页</li></ul></div><!-- end of inner --><div class="text"><h4>共搜索到&nbsp;'.count($result3).'&nbsp;条结果</h4>';
			foreach ($result3 as $k=>$v) {
				$h_content .= "<p><a href='?h_id={$result3[$k]['h_id']}'>{$result3[$k]['h_title']}</a></p>";
			}
			$h_content .= '</div></div>';
		}
		$this->output('h_content', $h_content);
		$this->output('aData', $aData);
		$this->showpage('help_index');
	}
}
$help_index = new HelpIndex();
$help_index->main();
unset($help_index);
?>
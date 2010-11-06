<?php
/**
 * 跳转到支付宝付款确认页面
 */
@header("Location: alipayto.php?predeposit_r_id=".$_GET['predeposit_r_id']);
?>
<?php
/*
 * ipn_error.php
 *
 * PHP Toolkit for PayPal v0.51
 * http://www.paypal.com/pdn
 *
 * Copyright (c) 2004 PayPal Inc
 *
 * Released under Common Public License 1.0
 * http://opensource.org/licenses/cpl.php
 *
 */

// this is an include file - no functionality when
// called directly

if(isset($paypal['business']))
{
//log error to file or database

}
else
{
	die('This page is not directly accessible');
}


?>
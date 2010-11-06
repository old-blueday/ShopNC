<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
 /**
 * Smarty {head} block plugin
 *
 * Filename: block_head.php<br>
 * Type:     block<br>
 * Name:     head<br>
 * Date:     April 28, 2006<br>
 * Purpose:  move all content in headblocks to the header of the html document
 *
 * Examples:<br>
 * <pre>
 * {head}
 *    <style type="text/css">
 *       h1{font-family:fantasy;}
 *    </style>
 * {/head}
 * </pre>
 * @author Mathias Baert <mathias@motionmill.com>
 * @version  0.1
 * @param array
 * @param string
 * @param Smarty
 * @param boolean
 * @return string
 */
function smarty_block_foot($params, $content, & $smarty, & $repeat)
{
    if ( empty($content))
    {
        return;
    }
    return '@@@SMARTY:FOOT:BEGIN@@@'.trim($content).'@@@SMARTY:FOOT:END@@@';
}
?>

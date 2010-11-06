<?php
/**
 * outputfilter adds content of {head}-blocks to document<head>
 * @param string
 * @param Smarty
 * @return string
 */
function smarty_outputfilter_move_to_foot($tpl_output, & $smarty)
{
    $matches = array ();
    preg_match_all('!@@@SMARTY:FOOT:BEGIN@@@(.*?)@@@SMARTY:FOOT:END@@@!is', $tpl_output, $matches);
    $tpl_output = preg_replace("!@@@SMARTY:FOOT:BEGIN@@@(.*?)@@@SMARTY:FOOT:END@@@!is", '', $tpl_output);
    return str_replace('</body>', implode("\n", array_unique($matches[1]))."\n".'</body>', $tpl_output);
}
?>

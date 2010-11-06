<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-3">
					<p><?php echo $lang['langScoreAddExplain']; ?></p>
				</div>
				<div class="clear-9"></div>			
				<div class="nav">
					<ul>			
						<li class="nav-bg"><b></b><span><p><?php echo $output['page_title'];?></p></span></li>
					</ul>
				</div>
				<form action="own_score.php?action=save" method="POST">
				<input type="hidden" name="genre" value="<?php echo $output['product_array']['genre']; ?>">
				<input type="hidden" name="orderid" value="<?php echo $output['orderid']; ?>">
				<div class="cr-right">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td class="cr-1"><?php echo $lang['langScoreCorrelationBaby']; ?>:</td>
							<td class="cr-2"><?php echo $output['product_array']['p_name']; ?>&nbsp;&nbsp;[<a href="<?php echo SITE_URL; ?>/member/own_order.php?action=show&sp_code=<?php echo $output['product_array']['sp_code']; ?>"><?php echo $lang['langScoreCircumstance']; ?></a>]</td>
						</tr>
						<tr>
							<td class="cr-1"><?php echo $lang['langScore']; ?>:</td>
							<td class="cr-2"><?php echo $output['rdoScore']; ?></td>
						</tr>	
						<tr>
							<td class="cr-1"><?php echo $lang['langScoreCommentOn']; ?>:</td>
							<td class="cr-2"><textarea cols="60" rows="5" name="content"></textarea></td>
						</tr>																		
					</table>
				</div>
				<div class="an-1">
					<span class="buttom-comm">
						<input type="submit" class='submit' name="" value="<?php echo $lang['langScore']; ?>" onclick="history.back()" />
					</span>			
				</div>				
				</form>
			</div>
		</div>
	</div>
</div>
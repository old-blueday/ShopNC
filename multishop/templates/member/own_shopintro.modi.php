<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<div class="y-middle">
				<div class="io-1"><p><?php echo $lang['langShopIntro'];?></p>
				</div>
				<div class="clear-9"></div>
				<div class="bg-sj bg-wu"></div>
				<div class="clear-9"></div>
				<div class="nav">
					<ul>
						<li class="nav-bg"><b></b><span><p><?php echo $lang['langShopIntro']; ?></p></span></li>
					</ul>
				</div>
				<div class="cr-right">
					<h3 id="formTitie"><?php echo $lang['langRAddAddress']; ?></h3>
					<form id="formmodiintro" action="own_shop.php?action=saveintro" method="post">
					<table width="100%" class="cr-r-td" border="0" cellpadding="0">
						<tr>
							<td>
								<?php
									print_r($this->_tpl_vars);
									include_once('../classes/resource/editor/editor.class.php');
									$editor=new editor('txtShopIntro');
									$editor->Value=$output['shop_intro'];
									$editor->BasePath='../classes/resource/editor';
									$editor->Height=460;
									$editor->Width=621;
									$editor->AutoSave=false;
									$editor->Create();
								?>					
							</td>
						</tr>
					</table>
					<div class="an-1">
						<span class="buttom-comm"><input name="che" id="che" value="<?php echo $lang['langCsave']; ?>" type="submit" /></span>			
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
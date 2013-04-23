<?php $this->load->view('header');?>

<script src="js/common.js" type="text/javascript"></script>
<div class="container">

	<div class="note">
		<p class="i">{lang creditexchange_tips}</p>
	</div>

	<!--{if $status}-->
		<div class="{if $status > 0}correctmsg{else}errormsg{/if}"><p>{if $status == 1}{lang creditexchange_updated}{elseif $status == -1}{lang creditexchange_invalid}{/if}</p></div>
	<!--{/if}-->
	<div class="hastabmenu">
		<ul class="tabmenu">
			<li class="tabcurrent"><a href="#" class="tabcurrent">{lang creditexchange_update}</a></li>
		</ul>
		<div class="tabcontentcur">
			<form id="creditform" action="admin.php?m=credit&a=ls&addexchange=yes" method="post">
			<input type="hidden" name="formhash" value="{FORMHASH}">
			<table class="dbtb">
				<tr>
					<td class="tbtitle">{lang creditexchange_fromto}:</td>
					<td>
						<select onchange="switchcredit('src', this.value)" name="appsrc">
							<option>{lang creditexchange_select}</option>$appselect
						</select><span id="src"></span>
						&nbsp;&gt;&nbsp;
						<select onchange="switchcredit('desc', this.value)" name="appdesc">
							<option>{lang creditexchange_select}</option>$appselect
						</select><span id="desc"></span>
					</td>
				</tr>
				<tr>
					<td class="tbtitle">{lang creditexchange_ratio}:</td>
					<td>
						<input name="ratiosrc" size="3" value="$ratiosrc" class="txt" style="margin-right:0" />
						&nbsp;:&nbsp;
						<input name="ratiodesc" size="3" value="$ratiodesc" class="txt" />
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="submit" value="{lang submit}" class="btn" /> &nbsp;
						<input type="button" value="{lang creditexchange_syncappcredits}" class="btn" onclick="location.href='admin.php?m=credit&a=sync&sid=$sid'" />
					</td>
				</tr>
			</table>
			<div style="display: none">
			<script type="text/javascript">
			var credit = new Array();
			<!--{loop $creditselect $select}-->$select<!--{/loop}-->
			<!--{if $appsrc}-->
				setselect($('creditform').appsrc, $appsrc);
				switchcredit('src', $appsrc);
			<!--{/if}-->
			<!--{if $appdesc}-->
				setselect($('creditform').appdesc, $appdesc);
				switchcredit('desc', $appdesc);
			<!--{/if}-->
			<!--{if $creditsrc}-->
				setselect($('creditform').creditsrc, $creditsrc);
			<!--{/if}-->
			<!--{if $creditdesc}-->
				setselect($('creditform').creditdesc, $creditdesc);
			<!--{/if}-->
			</script>
			</div>
			</form>
		</div>
	</div>
	<br />
	<h3>{lang creditexchange}</h3>
	<div class="mainbox">
		<!--{if $creditexchange}-->
			<form action="admin.php?m=credit&a=ls&delexchange=yes" method="post">
			<input type="hidden" name="formhash" value="{FORMHASH}">
			<table class="datalist fixwidth" onmouseover="addMouseEvent(this);">
				<tr>
					<th><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /><label for="chkall">{lang badword_delete}</label></th>
					<th style="padding-right: 11px; text-align: right">{lang creditexchange_fromto}</th>
					<th></th>
					<th style="text-align: center">{lang creditexchange_ratio}</th>
				</tr>
				<!--{loop $creditexchange $key $exchange}-->
					<tr>
						<td class="option"><input type="checkbox" name="delete[]" value="$key" class="checkbox" /></td>
						<td align="right">$exchange[appsrc] $exchange[creditsrc]</td>
						<td>&nbsp;&gt;&nbsp;$exchange[appdesc] $exchange[creditdesc]</td>
						<td align="center">$exchange[ratiosrc] : $exchange[ratiodesc]</td>
					</tr>
				<!--{/loop}-->
				<tr class="nobg">
					<td><input type="submit" value="{lang submit}" class="btn" /></td>
				</tr>
			</table>
			</form>
		<!--{else}-->
			<div class="note">
				<p class="i">{lang list_empty}</p>
			</div>
		<!--{/if}-->
</div>

<?php $this->load->view('footer');?>
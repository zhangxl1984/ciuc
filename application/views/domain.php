<?php $this->load->view('header');?>

<script src="js/common.js" type="text/javascript"></script>
<div class="container">
	<!--{if $status}-->
		<div class="{if $status > 0}correctmsg{else}errormsg{/if}"><p>{if $status == 2}{lang domain_list_updated}{elseif $status == 1}{lang domain_add_succeed}{/if}</p></div>
	<!--{/if}-->
	<div class="hastabmenu">
		<ul class="tabmenu">
			<li class="tabcurrent"><a href="#" class="tabcurrent">{lang domain_add}</a></li>
		</ul>
		<div class="tabcontentcur">
			<form action="admin.php?m=domain&a=ls" method="post">
			<input type="hidden" name="formhash" value="{FORMHASH}">
			<table>
				<tr>
					<td>{lang domain}:</td>
					<td><input type="text" name="domainnew" class="txt" /></td>
					<td>{lang ip}:</td>
					<td><input type="text" name="ipnew" class="txt" /></td>
					<td><input type="submit" value="{lang submit}"  class="btn" /></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<h3>{lang domain_list}</h3>
	<div class="mainbox">
		<!--{if $domainlist}-->
			<form action="admin.php?m=domain&a=ls" method="post">
				<input type="hidden" name="formhash" value="{FORMHASH}">
				<table class="datalist fixwidth">
					<tr>
						<th width="10%"><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /><label for="chkall">{lang delete}</label></th>
						<th width="60%">{lang domain}</th>
						<th width="30%">{lang ip}</th>
					</tr>
					<!--{loop $domainlist $domain}-->
					<tr>
						<td><input type="checkbox" name="delete[]" value="$domain[id]" class="checkbox" /></td>
						<td><input type="text" name="domain[{$domain[id]}]" value="$domain[domain]" title="{lang shortcut_tips}" class="txtnobd" onblur="this.className='txtnobd'" onfocus="this.className='txt'" style="text-align:left;" /></td>
						<td><input type="text" name="ip[{$domain[id]}]" value="$domain[ip]" title="{lang shortcut_tips}" class="txtnobd" onblur="this.className='txtnobd'" onfocus="this.className='txt'" style="text-align:left;" /></td>
					</tr>
					<!--{/loop}-->
					<tr class="nobg">
						<td><input type="submit" value="{lang submit}" class="btn" /></td>
						<td class="tdpage" colspan="2">$multipage</td>
					</tr>
				</table>
			</form>
		<!--{else}-->
			<div class="note">
				<p class="i">{lang list_empty}</p>
			</div>
		<!--{/if}-->
	</div>
</div>

<?php $this->load->view('footer');?>
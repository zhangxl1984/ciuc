<?php $this->load->view('header');?>

<!--{if $a == 'ls'}-->

	<script src="js/common.js" type="text/javascript"></script>
	<script src="js/calendar.js" type="text/javascript"></script>
	<script type="text/javascript">
		function switchbtn(btn) {
			$('addadmindiv').className = btn == 'addadmin' ? 'tabcontentcur' : '' ;
			$('editpwdiv').className = btn == 'addadmin' ? '' : 'tabcontentcur';

			$('addadmin').className = btn == 'addadmin' ? 'tabcurrent' : '';
			$('editpw').className = btn == 'addadmin' ? '' : 'tabcurrent';

			$('addadmindiv').style.display = btn == 'addadmin' ? '' : 'none';
			$('editpwdiv').style.display = btn == 'addadmin' ? 'none' : '';
		}
		function chkeditpw(theform) {
			if(theform.oldpw.value == '') {
				alert('{lang admin_pw_oldpw}');
				theform.oldpw.focus();
				return false;
			}
			if(theform.newpw.value == '') {
				alert('{lang admin_pw_newpw}');
				theform.newpw.focus();
				return false;
			}
			if(theform.newpw2.value == '') {
				alert('{lang admin_pw_newpw2}');
				theform.newpw2.focus();
				return false;
			}
			if(theform.newpw.value != theform.newpw2.value) {
				alert('{lang admin_pw_incorrect}');
				theform.newpw2.focus();
				return false;
			}
			if(theform.newpw.value.length < 6 && !confirm('{lang admin_pw_too_short}')) {
				theform.newpw.focus();
				return false;
			}
			return true;
		}
	</script>

	<div class="container">
		<!--{if $status}-->
			<div class="{if $status > 0}correctmsg{else}errormsg{/if}">
				<p>
				{if $status == 1} {lang admin_add_succeed}
				{elseif $status == -1} {lang admin_add_succeed}
				{elseif $status == -2} {lang admin_failed}
				{elseif $status == -3}{lang admin_user_nonexistance}
				{elseif $status == -4} {lang admin_config_unwritable}
				{elseif $status == -5} {lang admin_founder_pw_incorrect}
				{elseif $status == -6} {lang admin_pw_incorrect}
				{elseif $status == 2} {lang admin_founder_pw_modified}
				{/if}
				</p>
			</div>
		<!--{/if}-->
		<div class="hastabmenu" style="height:175px;">
			<ul class="tabmenu">
				<li id="addadmin" class="tabcurrent"><a href="#" onclick="switchbtn('addadmin');">{lang admin_add_admin}</a></li>
				<!--{if $user['isfounder']}--><li id="editpw"><a href="#" onclick="switchbtn('editpw');">{lang admin_modify_founder_pw}</a></li><!--{/if}-->
			</ul>
			<div id="addadmindiv" class="tabcontentcur">
				<form action="admin.php?m=admin&a=ls" method="post">
				<input type="hidden" name="formhash" value="{FORMHASH}">
				<table class="dbtb">
					<tr>
						<td class="tbtitle">{lang user_name}:</td>
						<td><input type="text" name="addname" class="txt" /></td>
					</tr>
					<tr>
						<td valign="top" class="tbtitle">{lang admin_privilege}:</td>
						<td>
							<ul class="dblist">
								<li><input type="checkbox" name="allowadminsetting" value="1" class="checkbox" checked="checked" />{lang admin_allow_setting}</li>
								<li><input type="checkbox" name="allowadminapp" value="1" class="checkbox" />{lang admin_allow_app}</li>
								<li><input type="checkbox" name="allowadminuser" value="1" class="checkbox" />{lang admin_allow_user}</li>
								<li><input type="checkbox" name="allowadminbadword" value="1" class="checkbox" checked="checked" />{lang admin_allow_badwords}</li>
								<li><input type="checkbox" name="allowadmintag" value="1" class="checkbox" checked="checked" />{lang admin_allow_tag}</li>
								<li><input type="checkbox" name="allowadminpm" value="1" class="checkbox" checked="checked" />{lang admin_allow_pm}</li>
								<li><input type="checkbox" name="allowadmincredits" value="1" class="checkbox" checked="checked" />{lang admin_allow_credits}</li>
								<li><input type="checkbox" name="allowadmindomain" value="1" class="checkbox" checked="checked" />{lang admin_allow_hosts}</li>
								<li><input type="checkbox" name="allowadmindb" value="1" class="checkbox" />{lang admin_allow_database}</li>
								<li><input type="checkbox" name="allowadminnote" value="1" class="checkbox" checked="checked" />{lang admin_allow_note}</li>
								<li><input type="checkbox" name="allowadmincache" value="1" class="checkbox" checked="checked" />{lang admin_allow_cache}</li>
								<li><input type="checkbox" name="allowadminlog" value="1" class="checkbox" checked="checked" />{lang admin_allow_log}</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type="submit" name="addadmin" value="{lang submit}" class="btn" />
						</td>
					</tr>
				</table>
				</form>
			</div>
			<!--{if $user['isfounder']}-->
			<div id="editpwdiv" class="tabcontent" style="display:none;">
				<form action="admin.php?m=admin&a=ls" onsubmit="return chkeditpw(this)" method="post">
				<input type="hidden" name="formhash" value="{FORMHASH}">
				<table class="dbtb" style="height:123px;">
					<tr>
						<td class="tbtitle">{lang oldpw}:</td>
						<td><input type="password" name="oldpw" class="txt" /></td>
					</tr>
					<tr>
						<td class="tbtitle">{lang newpw}:</td>
						<td><input type="password" name="newpw" class="txt" /></td>
					</tr>
					<tr>
						<td class="tbtitle">{lang repeatpw}:</td>
						<td><input type="password" name="newpw2" class="txt" /></td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type="submit" name="editpwsubmit" value="{lang submit}" class="btn" />
						</td>
					</tr>
				</table>
				</form>
			</div>
			<!--{/if}-->
		</div>
		<h3>{lang admin_list}</h3>
		<div class="mainbox">
			<!--{if $userlist}-->
				<form action="admin.php?m=admin&a=ls" onsubmit="return confirm('{lang confirm_delete}');" method="post">
				<input type="hidden" name="formhash" value="{FORMHASH}">
				<table class="datalist fixwidth" onmouseover="addMouseEvent(this);">
					<tr>
						<th><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" value="1" class="checkbox" /><label for="chkall">{lang delete}</label></th>
						<th>{lang user_name}</th>
						<th>{lang email}</th>
						<th>{lang user_regdate}</th>
						<th>{lang user_regip}</th>
						<th>{lang profile}</th>
						<th>{lang privilege}</th>
					</tr>
					<!--{loop $userlist $user}-->
						<tr>
							<td class="option"><input type="checkbox" name="delete[]" value="$user[uid]" value="1" class="checkbox" /></td>
							<td class="username">$user[username]</td>
							<td>$user[email]</td>
							<td class="date">$user[regdate]</td>
							<td class="ip">$user[regip]</td>
							<td class="ip"><a href="admin.php?m=user&a=edit&uid=$user[uid]&fromadmin=yes">{lang profile}</a></td>
							<td class="ip"><a href="admin.php?m=admin&a=edit&uid=$user[uid]">{lang privilege}</a></td>
						</tr>
					<!--{/loop}-->
					<tr class="nobg">
						<td><input type="submit" value="{lang submit}" class="btn" /></td>
						<td class="tdpage" colspan="4">$multipage</td>
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
	<!--{if $_POST['editpwsubmit']}-->
		<script type="text/javascript">
		switchbtn('editpw');
		</script>
	<!--{else}-->
		<script type="text/javascript">
		switchbtn('addadmin');
		</script>
	<!--{/if}-->

<!--{else}-->
	<div class="container">
		<h3 class="marginbot">{lang admin_edit_priv}<a href="admin.php?m=admin&a=ls" class="sgbtn">{lang admin_return_admin_ls}</a></h3>
		<!--{if $status == 1}-->
			<div class="correctmsg"><p>{lang admin_priv_modified_successfully}</p></div>
		<!--{elseif $status == -1}-->
			<div class="correctmsg"><p>{lang admin_priv_modified_failed}</p></div>
		<!--{else}-->
			<div class="note">{lang admin_modification_notice}</div>
		<!--{/if}-->
		<div class="mainbox">
			<form action="admin.php?m=admin&a=edit&uid=$uid" method="post">
			<input type="hidden" name="formhash" value="{FORMHASH}">
				<table class="opt">
					<tr>
						<th>{lang admin_admin} $admin[username]:</th>
					</tr>
					<tr>
						<td>
							<ul>
								<li><input type="checkbox" name="allowadminsetting" value="1" class="checkbox" {if $admin[allowadminsetting]} checked="checked" {/if}/>{lang admin_allow_setting}</li>
								<li><input type="checkbox" name="allowadminapp" value="1" class="checkbox" {if $admin[allowadminapp]} checked="checked" {/if}/>{lang admin_allow_app}</li>
								<li><input type="checkbox" name="allowadminuser" value="1" class="checkbox" {if $admin[allowadminuser]} checked="checked" {/if}/>{lang admin_allow_user}</li>
								<li><input type="checkbox" name="allowadminbadword" value="1" class="checkbox" {if $admin[allowadminbadword]} checked="checked" {/if}/>{lang admin_allow_badwords}</li>
								<li><input type="checkbox" name="allowadmintag" value="1" class="checkbox" {if $admin[allowadmintag]} checked="checked" {/if}/>{lang admin_allow_tag}</li>
								<li><input type="checkbox" name="allowadminpm" value="1" class="checkbox" {if $admin[allowadminpm]} checked="checked" {/if}/>{lang admin_allow_pm}</li>
								<li><input type="checkbox" name="allowadmincredits" value="1" class="checkbox" {if $admin[allowadmincredits]} checked="checked" {/if}/>{lang admin_allow_credits}</li>
								<li><input type="checkbox" name="allowadmindomain" value="1" class="checkbox" {if $admin[allowadmindomain]} checked="checked" {/if}/>{lang admin_allow_hosts}</li>
								<li><input type="checkbox" name="allowadmindb" value="1" class="checkbox" {if $admin[allowadmindb]} checked="checked" {/if}/>{lang admin_allow_database}</li>
								<li><input type="checkbox" name="allowadminnote" value="1" class="checkbox" {if $admin[allowadminnote]} checked="checked" {/if}/>{lang admin_allow_note}</li>
								<li><input type="checkbox" name="allowadmincache" value="1" class="checkbox" {if $admin[allowadmincache]} checked="checked" {/if}/>{lang admin_allow_cache}</li>
								<li><input type="checkbox" name="allowadminlog" value="1" class="checkbox" {if $admin[allowadminlog]} checked="checked" {/if}/>{lang admin_allow_log}</li>
							</ul>
						</td>
					</tr>
				</table>
				<div class="opt"><input type="submit" name="submit" value=" {lang submit} " class="btn" tabindex="3" /></div>
			</form>
		</div>
	</div>

<!--{/if}-->

<?php $this->load->view('footer');?>
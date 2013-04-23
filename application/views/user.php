<?php $this->load->view('header');?>

<script src="js/common.js" type="text/javascript"></script>
<script src="js/calendar.js" type="text/javascript"></script>

<!--{if $a == 'ls'}-->

	<script type="text/javascript">
		function switchbtn(btn) {
			$('srchuserdiv').style.display = btn == 'srch' ? '' : 'none';
			$('srchuserdiv').className = btn == 'srch' ? 'tabcontentcur' : '' ;
			$('srchuserbtn').className = btn == 'srch' ? 'tabcurrent' : '';
			$('adduserdiv').style.display = btn == 'srch' ? 'none' : '';
			$('adduserdiv').className = btn == 'srch' ? '' : 'tabcontentcur';
			$('adduserbtn').className = btn == 'srch' ? '' : 'tabcurrent';
		}
	</script>

	<div class="container">
		<!--{if $status}-->
			<div class="{if $status > 0}correctmsg{else}errormsg{/if}"><p>{if $status < 0}<em>{lang user_add_failed}:</em> {/if}{if $status == 2}{lang user_delete_succeed}{elseif $status == 1}{lang user_add_succeed}{elseif $status == -1}{lang user_add_username_ignore}{elseif $status == -2}{lang user_add_username_badwords}{elseif $status == -3}{lang user_add_username_exists}{elseif $status == -4}{lang user_add_email_formatinvalid}{elseif $status == -5}{lang user_add_email_ignore}{elseif $status == -6}{lang user_add_email_exists}{/if}</p></div>
		<!--{/if}-->
		<div class="hastabmenu">
			<ul class="tabmenu">
				<li id="srchuserbtn" class="tabcurrent"><a href="#" onclick="switchbtn('srch')">{lang user_search}</a></li>
				<li id="adduserbtn"><a href="#" onclick="switchbtn('add')">{lang user_add}</a></li>
			</ul>
			<div id="adduserdiv" class="tabcontent" style="display:none;">
				<form action="admin.php?m=user&a=ls&adduser=yes" method="post">
				<input type="hidden" name="formhash" value="{FORMHASH}">
				<table width="100%">
					<tr>
						<td>{lang user_name}:</td>
						<td><input type="text" name="addname" class="txt" /></td>
						<td>{lang user_password}:</td>
						<td><input type="text" name="addpassword" class="txt" /></td>
						<td>{lang email}:</td>
						<td><input type="text" name="addemail" class="txt" /></td>
						<td><input type="submit" value="{lang submit}"  class="btn" /></td>
					</tr>
				</table>
				</form>
			</div>
			<div id="srchuserdiv" class="tabcontentcur">
				<form action="admin.php?m=user&a=ls" method="post">
				<input type="hidden" name="formhash" value="{FORMHASH}">
				<table width="100%">
					<tr>
						<td>{lang user_name}:</td>
						<td><input type="text" name="srchname" value="$srchname" class="txt" /></td>
						<td>UID:</td>
						<td><input type="text" name="srchuid" value="$srchuid" class="txt" /></td>
						<td>{lang email}:</td>
						<td><input type="text" name="srchemail" value="$srchemail" class="txt" /></td>
						<td rowspan="2"><input type="submit" value="{lang submit}" class="btn" /></td>
					</tr>
					<tr>
						<td>{lang user_regdate}:</td>
						<td colspan="3"><input type="text" name="srchregdatestart" onclick="showcalendar();" value="$srchregdatestart" class="txt" /> {lang to} <input type="text" name="srchregdateend" onclick="showcalendar();" value="$srchregdateend" class="txt" /></td>
						<td>{lang user_regip}:</td>
						<td><input type="text" name="srchregip" value="$srchregip" class="txt" /></td>
					</tr>
				</table>
				</form>
			</div>
		</div>

		<!--{if $adduser}--><script type="text/javascript">switchbtn('add');</script><!--{/if}-->
<br />
		<h3>{lang user_list}</h3>
		<div class="mainbox">
			<!--{if $userlist}-->
				<form action="admin.php?m=user&a=ls&srchname=$srchname&srchregdate=$srchregdate" onsubmit="return confirm('{lang user_delete_confirm}');" method="post">
				<input type="hidden" name="formhash" value="{FORMHASH}">
				<table class="datalist fixwidth" onmouseover="addMouseEvent(this);">
					<tr>
						<th><input type="checkbox" name="chkall" id="chkall" onclick="checkall('delete[]')" class="checkbox" /><label for="chkall">{lang delete}</label></th>
						<th>{lang user_name}</th>
						<th>{lang email}</th>
						<th>{lang user_regdate}</th>
						<th>{lang user_regip}</th>
						<th>{lang edit}</th>
					</tr>
					<!--{loop $userlist $user}-->
						<tr>
							<td class="option"><input type="checkbox" name="delete[]" value="$user[uid]" class="checkbox" /></td>
							<td>$user[smallavatar] <strong>$user[username]</strong></td>
							<td>$user[email]</td>
							<td>$user[regdate]</td>
							<td>$user[regip]</td>
							<td><a href="admin.php?m=user&a=edit&uid=$user[uid]">{lang edit}</a></td>
						</tr>
					<!--{/loop}-->
					<tr class="nobg">
						<td><input type="submit" value="{lang submit}" class="btn" /></td>
						<td class="tdpage" colspan="6">$multipage</td>
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

<!--{else}-->

	<div class="container">
		<h3 class="marginbot">{lang user_edit_profile}
			{if getgpc('fromadmin')}
				<a href="admin.php?m=admin&a=ls" class="sgbtn">{lang admin_return_admin_ls}</a>
			{else}
				<a href="admin.php?m=user&a=ls" class="sgbtn">{lang admin_return_user_ls}</a>
			{/if}
		</h3>
		<!--{if $status == 1}-->
			<div class="correctmsg"><p>{lang user_edit_profile_sucessfully}</p></div>
		<!--{elseif $status == -1}-->
			<div class="correctmsg"><p>{lang user_edit_profile_failed}</p></div>
		<!--{else}-->
			<div class="note"><p class="i">{lang user_keep_blank}</p></div>
		<!--{/if}-->
		<div class="mainbox">
			<form action="admin.php?m=user&a=edit&uid=$uid" method="post">
			<input type="hidden" name="formhash" value="{FORMHASH}">
				<table class="opt">
					<tr>
						<th>{lang user_avatar}: <input name="delavatar" class="checkbox" type="checkbox" value="1" /> {lang delete_avatar}</th>
					</tr>
					<tr>
						<th>{lang user_avatar_virtual}:</th>
					</tr>
					<tr>
						<td>$user[bigavatar]</td>
					</tr>
					<tr>
						<th>{lang user_avatar_real}:</th>
					</tr>
					<tr>
						<td>$user[bigavatarreal]</td>
					</tr>
					<tr>
						<th>{lang login_username}:</th>
					</tr>
					<tr>
						<td>
							<input type="text" name="newusername" value="$user[username]" class="txt" />
							<input type="hidden" name="username" value="$user[username]" class="txt" />
						</td>
					</tr>
					<tr>
						<th>{lang login_password}:</th>
					</tr>
					<tr>
						<td>
							<input type="text" name="password" value="" class="txt" />
						</td>
					</tr>
					<tr>
						<th>{lang login_secques}: <input type="checkbox" class="checkbox" name="rmrecques" value="1" /> {lang login_remove_secques}</th>
					</tr>
					<tr>
						<th>Email:</th>
					</tr>
					<tr>
						<td>
							<input type="text" name="email" value="$user[email]" class="txt" />
						</td>
					</tr>
				</table>
				<div class="opt"><input type="submit" name="submit" value=" {lang submit} " class="btn" tabindex="3" /></div>
			</form>
		</div>
	</div>
<!--{/if}-->
<?php $this->load->view('footer');?>
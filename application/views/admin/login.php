<?php $this->load->view('header')?>
<script type="text/javascript">
function $(id) {
	return document.getElementById(id);
}
</script>

<div class="container">
	<form action="<?php $this->config->base_url('admin/user/login');?>"
		method="post" id="loginform" <?php if($this->input->get_post('iframe')):?>target="_self"
		<?php else:?>target="_top"<?php endif;?>
		<input type="hidden" name="formhash" value="<?php echo formhash();?>" />
		<input type="hidden" name="seccodehidden" value="$seccodeinit" /> <input
			type="hidden" name="iframe" value="{$iframe}" />
		<table class="mainbox">
			<tr>
				<td class="loginbox">
					<h1>UCenter</h1>
					<p>
						<?php echo $this->lang->line('login_tips')?>
					</p>
				</td>
				<td class="login">
					<!--{if $errorcode == UC_LOGIN_ERROR_FOUNDER_PW}-->
					<div class="errormsg loginmsg">
						<p>
							<?php echo $this->lang->line('login_founder_incorrect')?>
						</p>
					</div> <!--{elseif $errorcode == UC_LOGIN_ERROR_ADMIN_PW}-->
					<div class="errormsg loginmsg">
						<p>
							<?php echo $this->lang->line('login_incorrect')?>
						</p>
					</div> <!--{elseif $errorcode == UC_LOGIN_ERROR_ADMIN_NOT_EXISTS}-->
					<div class="errormsg loginmsg">
						<p>
							<?php echo $this->lang->line('login_admin_noexists')?>
						</p>
					</div> <!--{elseif $errorcode == UC_LOGIN_ERROR_SECCODE}-->
					<div class="errormsg loginmsg">
						<p>
							<?php echo $this->lang->line('login_seccode_error')?>
						</p>
					</div> <!--{elseif $errorcode == UC_LOGIN_ERROR_FAILEDLOGIN}-->
					<div class="errormsg loginmsg">
						<p>
							<?php echo $this->lang->line('login_failedlogin')?>
						</p>
					</div> <!--{/if}-->
					<p>
						<input type="radio" name="isfounder" value="1" class="radio"
							{if (isset($_POST['isfounder']) && $isfounder) || !isset($_POST['isfounder'])}checked="checked"
							{/if} onclick="$('username').value='UCenter Administrator'; $('username').readOnly = true; $('username').disabled = true; $('password').focus();"
							id="founder" /><label for="founder"><?php echo $this->lang->line('founder')?>
						</label> <input type="radio" name="isfounder" value="0"
							class="radio"
							{if (isset($_POST['isfounder']) && !$isfounder)}checked="checked"
							{/if} onclick="$('username').value=''; $('username').readOnly = false; $('username').disabled = false; $('username').focus();"
							id="admin" /><label for="admin"><?php echo $this->lang->line('admin_admin')?>
						</label>
					</p>
					<p id="usernamediv">
						<?php echo $this->lang->line('login_username')?>
						:<input type="text" name="username" class="txt" tabindex="1"
							id="username" value="$username" />
					</p>
					<p>
						<?php echo $this->lang->line('login_password')?>
						:<input type="password" name="password" class="txt" tabindex="2"
							id="password" value="$password" />
					</p>
					<p>
						<?php echo $this->lang->line('login_seccode')?>
						:<input type="text" name="seccode" class="txt" tabindex="2"
							id="seccode" value="" style="margin-right: 5px; width: 85px;" /><img
							width="70" height="21"
							src="admin.php?m=seccode&seccodeauth=$seccodeinit&{eval echo rand();}" />
					</p>
					<p class="loginbtn">
						<input type="submit" name="submit"
							value="<?php echo $this->lang->line('login_submit')?>"
							class="btn" tabindex="3" />
					</p>
				</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript">
{if (isset($_POST['isfounder']) && $isfounder) || !isset($_POST['isfounder'])}
	$('username').value='UCenter Administrator';
	$('username').disabled = true;
	$('username').readOnly = true;
	$('password').focus();
{else}
	$('username').readOnly = false;
	$('username').readOnly = false;
	$('username').focus();
{/if}
</script>
<div class="footer">
	Powered by UCenter
	<?php echo SOFT_VERSION;?>
	&copy; 2001 - 2008 <a href="http://www.comsenz.com/" target="_blank">Comsenz</a>
	Inc.
</div>
<?php $this->load->view('footer')?>
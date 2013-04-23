<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo UC_CHARSET;?>" />
<title>UCenter Administrator's Control Panel</title>
<style type="text/css">
/* common */
*{ word-wrap:break-word; outline:none; }
body{ width:159px; background:#F2F9FD url(images/bg_repx_h.gif) right top no-repeat; color:#666; font:12px "Lucida Grande", Verdana, Lucida, Helvetica, Arial, "����" ,sans-serif; }
body, ul{ margin:0; padding:0; }
a{ color:#2366A8; text-decoration:none; }
	a:hover { text-decoration:underline; }
.menu{ position:relative; z-index:20; }
	.menu ul{ position:absolute; top:10px; right:-1px !important; right:-2px; list-style:none; width:150px; background:#F2F9FD url(images/bg_repx_h.gif) right -20px no-repeat; }
		.menu li{ margin:3px 0; *margin:1px 0; height:auto !important; height:24px; overflow:hidden; font-size:14px; font-weight:700; }
		.menu li a{ display:block; margin-right:2px; padding:3px 0 2px 30px; *padding:4px 0 2px 30px; border:1px solid #F2F9FD; background:url(images/bg_repno.gif) no-repeat 10px -40px; color:#666; }
			.menu li a:hover{ text-decoration:none; margin-right:0; border:1px solid #B5CFD9; border-right:1px solid #FFF; background:#FFF; }
		.menu li a.tabon{ text-decoration:none; margin-right:0; border:1px solid #B5CFD9; border-right:1px solid #FFF; background:#FFF url(images/bg_repy.gif) repeat-y; color:#2366A8; }
.footer{ position:absolute; z-index:10; right:13px; bottom:0; padding:5px 0; line-height:150%; background:url(images/bg_repx.gif) 0 -199px repeat-x; font-family:Arial, sans-serif; font-size:10px; }
</style>
<meta content="Comsenz Inc." name="Copyright" />
</head>
<body>
<div class="menu">
	<ul id="leftmenu">
		<li><a href="<?php echo $this->config->base_url('index/main');?>" target="main" class="tabon"><?php echo $this->lang->line('menu_index');?></a></li>
		<?php if($user['isfounder'] || $user['allowadminsetting']):?><li><a href="<?php echo $this->config->base_url('setting/ls');?>" target="main"><?php echo $this->lang->line('menu_basic_setting');?></a></li><?php endif;?>
		<?php if($user['isfounder'] || $user['allowadminsetting']):?><li><a href="<?php echo $this->config->base_url('setting/register');?>" target="main"><?php echo $this->lang->line('menu_register_setting');?></a></li><?php endif;?>
		<?php if($user['isfounder'] || $user['allowadminsetting']):?><li><a href="<?php echo $this->config->base_url('setting/mail');?>" target="main"><?php echo $this->lang->line('menu_mail_setting');?></a></li><?php endif;?>
		<?php if($user['isfounder'] || $user['allowadminapp']):?><li><a href="<?php echo $this->config->base_url('app/ls');?>" target="main"><?php echo $this->lang->line('menu_application');?></a></li><?php endif;?>
		<?php if($user['isfounder'] || $user['allowadminuser']):?><li><a href="<?php echo $this->config->base_url('user/ls');?>" target="main"><?php echo $this->lang->line('menu_manager_user');?></a></li><?php endif;?>
		<?php if($user['isfounder']):?><li><a href="<?php echo $this->config->base_url('admin/ls');?>" target="main"><?php echo $this->lang->line('menu_admin_user');?></a></li><?php endif;?>
		<?php if($user['isfounder'] || $user['allowadminpm']):?><li><a href="<?php echo $this->config->base_url('pm/ls');?>" target="main"><?php echo $this->lang->line('menu_pm');?></a></li><?php endif;?>
		<?php if($user['isfounder'] || $user['allowadmincredits']):?><li><a href="<?php echo $this->config->base_url('credit/ls');?>" target="main"><?php echo $this->lang->line('menu_credit_exchange');?></a></li><?php endif;?>
		<?php if($user['isfounder'] || $user['allowadminbadword']):?><li><a href="<?php echo $this->config->base_url('badword/ls');?>" target="main"><?php echo $this->lang->line('menu_censor_word');?></a></li><?php endif;?>
		<?php if($user['isfounder'] || $user['allowadmindomain']):?><li><a href="<?php echo $this->config->base_url('domain/ls');?>" target="main"><?php echo $this->lang->line('menu_domain_list');?></a></li><?php endif;?>
		<?php if($user['isfounder'] || $user['allowadmindb']):?><li><a href="<?php echo $this->config->base_url('db/ls');?>" target="main"><?php echo $this->lang->line('menu_db');?></a></li><?php endif;?>
		<?php if($user['isfounder']):?><li><a href="<?php echo $this->config->base_url('feed/ls');?>" target="main"><?php echo $this->lang->line('menu_data_list');?></a></li><?php endif;?>
		<?php if($user['isfounder'] || $user['allowadmincache']):?><li><a href="<?php echo $this->config->base_url('cache/update');?>" target="main"><?php echo $this->lang->line('menu_update_cache');?></a></li><?php endif;?>
		<?php if($user['isfounder']):?><li><a href="<?php echo $this->config->base_url('plugin/filecheck');?>" target="main"><?php echo $this->lang->line('plugin');?></a></li><?php endif;?>
	</ul>
</div>
<div class="footer">Powered by UCenter {UC_SERVER_VERSION}<br />&copy; 2001 - 2008 <a href="http://www.comsenz.com/" target="_blank">Comsenz</a> Inc.</div>
<script type="text/javascript">
	function cleartabon() {
		if(lastmenu) {
			lastmenu.className = '';
		}
		for(var i = 0; i < menus.length; i++) {
			var menu = menus[i];
			if(menu.className == 'tabon') {
				lastmenu = menu;
			}
		}
	}
	var menus = document.getElementById('leftmenu').getElementsByTagName('a');
	var lastmenu = '';
	for(var i = 0; i < menus.length; i++) {
		var menu = menus[i];
		menu.onclick = function() {
			setTimeout('cleartabon()', 1);
			this.className = 'tabon';
			this.blur();
		}
	}

	cleartabon();
</script>

<?php $this->load->view('footer');?>
<?php if(UC_DEBUG):?>
	<style type="text/css">
	#debuginfo {width: 60%;margin-left: 2em;}
	fieldset {margin-top: 2em; display: block;}
	</style>
	<div style="text-align: left;" id="debuginfo">
		Processed in <span id="debug_time"></span> s
		<fieldset>
			<legend><b>GET:</b></legend>
			<!--{eval echo '<pre>'.print_r($_GET, TRUE).'</pre>';}-->
		</fieldset>
		<fieldset>
			<legend><b>POST:</b></legend>
			<!--{eval echo '<pre>'.print_r($_POST, TRUE).'</pre>';}-->
		</fieldset>
		<fieldset>
			<legend><b>COOKIE:</b></legend>
			<!--{eval echo '<pre>'.print_r($_COOKIE, TRUE).'</pre>';}-->
		</fieldset>
		<fieldset>
			<legend><b>SQL:</b> $dbquerynum</legend>
			<!--{loop $dbhistories $dbhistory}-->
				 <li>$dbhistory</li>
			<!--{/loop}-->
		</fieldset>
		<fieldset>
			<legend><b>Include:</b> {eval echo count(get_included_files());}</legend>
			<!--{eval echo '<pre>'.print_r(get_included_files(), TRUE).'</pre>';}-->
		</fieldset>
	</div>
<?php endif;?>

</body>
</html>
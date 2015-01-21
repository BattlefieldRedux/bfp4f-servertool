<?php
/**
 * BattlefieldTools.com BFP4F ServerTool
 * Version 0.7.2
 *
 * Copyright (C) 2014 <Danny Li> a.k.a. SharpBunny
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>. 
 */
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Servertool by SharpBunny</title>
		
		<meta charset="utf8" />
		
		<link rel="icon" type="image/png" href="panel/img/favicon.png" />
		
		<link rel="stylesheet" href="panel/css/bootstrap.min.css" />
		<link rel="stylesheet" href="panel/css/font-awesome.min.css" />
		<link rel="stylesheet" href="panel/css/default.css" />
		
		<script src="panel/js/jquery-1.9.1.min.js"></script>
		<script src="panel/js/bootstrap.min.js"></script>
		<script src="panel/js/custom.js"></script>
	</head>
	
	<body style="margin-top:0">
		
		<div class="container">
			
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					
					<div class="center">
						<img src="panel/img/battlefieldtools-logo.png" alt="BattlefieldTools.com" class="f1" />
					</div>
					<h2 class="center f3">
						WebCon for BFH v0.1<br />
						<small>GPL v3.0. LICENSE</small>
					</h2>
					<hr />
					
					<div class="f5">
					
<?php
if(@ini_get('short_open_tag') != 'On' && @ini_get('short_open_tag') != '1') {
	echo '<div class="alert alert-danger"><i class="fa fa-times fa-block"></i> <b>ERROR</b> Please enable set short_open_tags = On in your php.ini file!</div>';
}
if(!function_exists('fsockopen')) {
	echo '<div class="alert alert-danger"><i class="fa fa-times fa-block"></i> <b>ERROR</b> fsockopen() is not enabled or installed!</div>';
}
if(!function_exists('mcrypt_encrypt') || !function_exists('mcrypt_create_iv') || !function_exists('mcrypt_get_iv_size')) {
	echo '<div class="alert alert-danger"><i class="fa fa-times fa-block"></i> <b>ERROR</b> mcrypt is not enabled or installed!</div>';
}
?>
					
						<p>Thank you for using my free servertool. I've put a lot of time and effort in this project, but of course it's not perfect and there are always things that can be improved / added. Please post all the bugs and your own suggestions in <a href="http://battlefield.play4free.com/en/forum/showthread.php?tid=137006" target="_blank">the forum thread</a>.</p>
						
						<p><b>Current version:</b> v0.1</p>
						
						<hr />
						
						<div class="row">
							<div class="col-md-6 col-md-offset-3">
								<a href="panel/" class="btn btn-success btn-lg btn-block">Continue to the panel <i class="fa fa-arrow-right"></i></a>
							</div>
						</div>
						
					

			
			<footer class="row">
				<div class="col-md-12">
					<hr />		
					<p class="text-muted"><a href="http://battlefieldtools.com" target="_blank"><i class="fa fa-wrench"></i> Official Thread</a> &middot; <a href="http://www.bfh-cbl.org" target="_blank"><i class="fa fa-file-text"></i> BFH-CBL.org</a> <span class="pull-right">Modified by toolchain</span> </p>
				</div>
			</footer>
			
		</div>
		
		
	</body>
</html>
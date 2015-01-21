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
 
require_once('../core/init.php');

$user->checkLogin(true);

// Check his rights
if($userInfo['rights_superadmin'] == 'no') {
	header('Location: ' . HOME_URL . 'panel/accessDenied.php');
	die();
}

$pageTitle = $lang['tool_set'];
include(CORE_DIR . '/cp_header.php');

$status = '';

// If form is posted
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['lang']) && isset($_POST['df']) && isset($_POST['df_full']) && isset($_POST['notifier']) && isset($_POST['notify_email']) && isset($_POST['limiters']) && isset($_POST['igcmds']) && isset($_POST['tmsgs']) && isset($_POST['public_watcher']) && isset($_POST['minusone'])) {
	
	sleep(2);
	
	$errors = array();
	
	// Clean the post variables
	foreach ($_POST as $key => $value) {
		$_POST[$key] = trim($value);	
	}
	
	// Some checks
	
	// Check if the language exists
	if(!file_exists(CORE_DIR . '/lang/' . $_POST['lang'] . '.php')) {
		$errors[] = replace($lang['tool_set_err1'], array('%lang%' => strtoupper($_POST['lang'])));
	}
	// Check notifier
	if($_POST['notifier'] != 'true' && $_POST['notifier'] != 'false') {
		$errors[] = $lang['tool_set_err3'];
	}
	// Check notify_email
	if($_POST['notifier'] == 'true') {
		if(!filter_var($_POST['notify_email'], FILTER_VALIDATE_EMAIL)) {
			$errors[] = $lang['tool_set_err4'];
		}
	}
	// Check limiters
	if($_POST['limiters'] != 'false') {
		$_POST['limiters'] = 'true';
	}
	// Check igcmds
	if($_POST['igcmds'] != 'false') {
		$_POST['igcmds'] = 'true';
	}
	// Check tmsgs
	if($_POST['tmsgs'] != 'false') {
		$_POST['tmsgs'] = 'true';
	}
	// Check public_watcher
	if($_POST['public_watcher'] != 'false') {
		$_POST['public_watcher'] = 'true';
	}
	// Check minusone
	if($_POST['minusone'] != 'false') {
		$_POST['minusone'] = 'true';
	}
	}
	
	// Check errors and stuff
	if(count($errors) == 0) {
				
		if(updateSetting('cp_default_lang', $_POST['lang']) &&
			updateSetting('cp_date_format', $_POST['df']) &&
			updateSetting('cp_date_format_full', $_POST['df_full']) &&
			updateSetting('notify', $_POST['notifier']) &&
			updateSetting('notify_email', $_POST['notify_email']) &&
			updateSetting('tool_limiters', $_POST['limiters']) &&
			updateSetting('tool_igcmds', $_POST['igcmds']) &&
			updateSetting('tool_tmsg', $_POST['tmsgs']) &&
			updateSetting('tool_watcher', $_POST['public_watcher']) &&
			updateSetting('tool_minusone', $_POST['minusone'])) {
			$status = '<div class="alert alert-success alert-block"><h4><i class="fa fa-check"></i> ' . $lang['word_ok'] . '</h4><p>' . $lang['msg_settings_saved'] . '</p></div>';
			$log->insertActionLog($userInfo['user_id'], 'Settings edited');
			
			// Reload settings
			fetchSettings();
		} else {
			$status = '<div class="alert alert-danger alert-block"><h4><i class="fa fa-times"></i> ' . $lang['word_error'] . '</h4><p>' . $result['message'] . '</p></div>';
		}
		
	} else {
		$status = '<div class="alert alert-danger alert-block"><h4><i class="fa fa-times"></i> ' . $lang['word_error'] . '</h4><p>' . $lang['msg_error'] . '</p><ul><li>' . implode('</li><li>', $errors) . '</li></ul></div>';
	}
	

?>
			
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					
					<h2><i class="fa fa-wrench"></i> <?=$lang['tool_set']?> <small><?=$lang['tool_set_desc']?></small></h2>
					<br />
					
					<ul class="nav nav-tabs">
						<li class="active"><a href="#controlpanel" data-toggle="tab"><i class="fa fa-home"></i> <?=$lang['word_cp_full']?></a></li>
						<li><a href="#notifier" data-toggle="tab"><i class="fa fa-exclamation-circle"></i> <?=$lang['tool_set_notifier']?></a></li>
						<li><a href="#tool" data-toggle="tab"><i class="fa fa-wrench"></i> WebCon for BFH</a></li>
					</ul>
					
					<br /><br />
					
					<form action="<?=HOME_URL?>panel/settings.php" method="post" class="form-horizontal">
						
						<?=$status?>
						
						<div class="tab-content">
							
							<div class="tab-pane fade in active" id="controlpanel">
								<div class="form-group">
									<label class="col-sm-3 control-label"><i class="fa fa-flag"></i> <?=$lang['tool_set_deflang']?></label>
		 							<div class="col-sm-9">
										<select name="lang" class="selectpicker show-tick" data-width="100%" required>
<?php
foreach(glob(CORE_DIR . '/lang/*.php') as $b) {
?>
											<option value="<?=basename($b, '.php')?>"<?=(($settings['cp_default_lang'] == basename($b, '.php')) ? ' selected' : '')?>><?=strtoupper(basename($b, '.php'))?></option>
<?php
}
?>
										</select>
		
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label"><i class="fa fa-clock-o"></i> <?=$lang['tool_set_df']?></label>
		 							<div class="col-sm-9">
										<input type="text" name="df" class="form-control" value="<?=$settings['cp_date_format']?>" required />
										<span class="help-block">
											<small><?=$lang['tool_set_help1']?></small>
										</span>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label"><i class="fa fa-clock-o"></i> <?=$lang['tool_set_fdf']?></label>
		 							<div class="col-sm-9">
										<input type="text" name="df_full" class="form-control" value="<?=$settings['cp_date_format_full']?>" required />
										<span class="help-block">
											<small><?=$lang['tool_set_help1']?></small>
										</span>
									</div>
								</div>
							
							</div>
							
							<div class="tab-pane fade" id="notifier">
								<div class="form-group">
									<label class="col-sm-3 control-label"><i class="fa fa-exclamation-circle"></i> <?=$lang['tool_set_notifier']?></label>
									<div class="col-sm-9">
										<select name="notifier" class="selectpicker show-tick" data-width="100%" required>
											<option value="false" data-icon="fa fa-times"><?=$lang['word_disabled']?></option>
											<option value="true" data-icon="fa fa-check"<?=(($settings['notify'] == 'true') ? ' selected' : '')?>><?=$lang['word_enabled']?></option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label"><i class="fa fa-envelope"></i> <?=$lang['tool_set_notify_email']?></label>
									<div class="col-sm-9">
										<input type="email" name="notify_email" class="form-control" value="<?=$settings['notify_email']?>" required />
									</div>
								</div>
							</div>
							
							<div class="tab-pane fade" id="tool">
								<div class="form-group">
									<label class="control-label col-sm-3"><i class="fa fa-cog"></i> <?=$lang['tool_set_lim']?></label>
									<div class="col-sm-9">
										<select name="limiters" class="selectpicker show-tick" data-width="100%" required>
											<option value="false" data-icon="fa fa-times"><?=$lang['word_disabled']?></option>
											<option value="true" data-icon="fa fa-check"<?=(($settings['tool_limiters'] == 'true') ? ' selected' : '')?>><?=$lang['word_enabled']?></option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3"><i class="fa fa-bullhorn"></i> <?=$lang['tool_igcmds']?></label>
									<div class="col-sm-9">
										<select name="igcmds" class="selectpicker show-tick" data-width="100%" required>
											<option value="false" data-icon="fa fa-times"><?=$lang['word_disabled']?></option>
											<option value="true" data-icon="fa fa-check"<?=(($settings['tool_igcmds'] == 'true') ? ' selected' : '')?>><?=$lang['word_enabled']?></option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3"><i class="fa fa-comments"></i> <?=$lang['tool_tmsg']?></label>
									<div class="col-sm-9">
										<select name="tmsgs" class="selectpicker show-tick" data-width="100%" required>
											<option value="false" data-icon="fa fa-times"><?=$lang['word_disabled']?></option>
											<option value="true" data-icon="fa fa-check"<?=(($settings['tool_tmsg'] == 'true') ? ' selected' : '')?>><?=$lang['word_enabled']?></option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3"><i class="fa fa-eye"></i> <?=$lang['tool_watcher']?></label>
									<div class="col-sm-9">
										<select name="public_watcher" class="selectpicker show-tick" data-width="100%" required>
											<option value="false" data-icon="fa fa-times"><?=$lang['word_disabled']?></option>
											<option value="true" data-icon="fa fa-check"<?=(($settings['tool_watcher'] == 'true') ? ' selected' : '')?>><?=$lang['word_enabled']?></option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3"><i class="fa fa-minus"></i> <?=$lang['tool_minusone']?></label>
									<div class="col-sm-9">
										<select name="minusone" class="selectpicker show-tick" data-width="100%" required>
											<option value="false" data-icon="fa fa-times"><?=$lang['word_disabled']?></option>
											<option value="true" data-icon="fa fa-check"<?=(($settings['tool_minusone'] == 'true') ? ' selected' : '')?>><?=$lang['word_enabled']?></option>
										</select>
									</div>
								</div>
						
						<br />
						
						<div class="form-group">
							<div class="col-sm-4 col-sm-offset-8">
								<button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i> <?=$lang['btn_save']?></button>
							</div>
						</div>
						
					</form>
					
				</div>
			</div>
			
<?php include(CORE_DIR . '/cp_footer.php'); ?>

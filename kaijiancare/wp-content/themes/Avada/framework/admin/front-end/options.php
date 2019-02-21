<div class="wrap" id="of_container">

	<div id="of-popup-save" class="of-save-popup">
		<div class="of-save-save"><?php _e('Options Updated', 'Avada'); ?></div>
	</div>
	
	<div id="of-popup-reset" class="of-save-popup">
		<div class="of-save-reset"><?php _e('Options Reset', 'Avada'); ?></div>
	</div>
	
	<div id="of-popup-fail" class="of-save-popup">
		<div class="of-fail-wrapper">
			<div class="of-save-fail"><?php _e('Error!', 'Avada'); ?></div><div class="of-fail-msg">Error Message</div>
		</div>
	</div>
	<span style="display: none;" id="hooks"><?php echo json_encode(of_get_header_classes_array()); ?></span>
	<input type="hidden" id="reset" value="<?php if(isset($_REQUEST['reset'])) echo esc_attr( $_REQUEST['reset'] ); ?>" />
	<input type="hidden" id="security" name="security" value="<?php echo wp_create_nonce('of_ajax_nonce'); ?>" />
	
	<h1 class="screen-reader-text"><?php _e( 'Theme Options', 'Avada' ); ?></h1>
	<form id="of_form" method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" enctype="multipart/form-data" >
		
		<div class="updated error importer-notice importer-notice-1" style="display: none;"><p><strong><?php echo sprintf(__('Seems like an error has occured. Please double check the imported data. If incorrect, please use %s and try again', 'Avada'), '<a href="'.admin_url( 'plugin-install.php?tab=plugin-information&amp;plugin=wordpress-reset&amp;TB_iframe=true&amp;width=830&amp;height=472' ).'" class="thickbox" title="'.__('Reset WordPress plugin', 'Avada').'">'.__('Reset WordPress plugin', 'Avada').'</a>'); ?> </strong></p></div>

		<div class="updated importer-notice importer-notice-2" style="display: none;"><p><strong><?php echo sprintf(__('Demo data successfully imported. Now, please install and run %s plugin once.', 'Avada'), '<a href="'.admin_url( 'plugin-install.php?tab=plugin-information&amp;plugin=regenerate-thumbnails&amp;TB_iframe=true&amp;width=830&amp;height=472' ).'" class="thickbox" title="'.__('Regenerate Thumbnails', 'Avada').'">'.__('Regenerate Thumbnails', 'Avada').'</a>'); ?></strong></p></div>

		<div class="updated error importer-notice importer-notice-3" style="display: none;"><p><strong><?php _e('Sorry but your import failed. Most likely, it cannot work with your webhost. You will have to ask your webhost to increase your PHP max_execution_time (or any other webserver timeout to at least 300 secs) and memory_limit (to at least 196M) temporarily.', 'Avada'); ?></strong></p></div>

		<div id="header">
		
			<div class="logo">
				<h2><?php echo THEMENAME; ?></h2>
				<span><?php echo ('v'. THEMEVERSION); ?></span>
			</div>
			
			<?php // Avada Edit 
			$theme_fusion_url = 'https://theme-fusion.com/';
			?>
			<div class="docs">
				<a href="<?php echo $theme_fusion_url . 'support/documentation/avada-documentation/'; ?>" target="_blank"><?php _e('Online Documentation', 'Avada'); ?></a><span class="link_sep">|</span><a href="<?php echo $theme_fusion_url . 'support/'; ?>" target="_blank"><?php _e('Support Center', 'Avada'); ?></a>
			</div>
			<?php // End Avada Edit ?>
		
			<div id="js-warning"><?php _e('Warning- This options panel will not work properly without javascript!', 'Avada'); ?></div>
			<div class="icon-option"></div>
			<div class="clear"></div>
		
		</div>

		<div id="info_bar">
		
			<a>
				<div id="expand_options" class="expand"><?php _e('Expand', 'Avada'); ?></div>
			</a>
						
			<img style="display:none" src="<?php echo ADMIN_DIR; ?>assets/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="<?php _e('Working...', 'Avada'); ?>" />

			<button id="of_save" type="button" class="button-primary">
				<?php _e('Save All Changes', 'Avada');?>
			</button>
			
		</div><!--.info_bar--> 	
		
		<div id="main">
		
			<div id="of-nav">
				<ul>
				  <?php echo $options_machine->Menu ?>
				</ul>
			</div>

			<div id="content">
		  		<?php echo $options_machine->Inputs /* Settings */ ?>
		  	</div>
		  	
			<div class="clear"></div>
			
		</div>
		
		<div class="save_bar"> 
		
			<img style="display:none" src="<?php echo ADMIN_DIR; ?>assets/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="<?php _e('Working...', 'Avada'); ?>" />
			<button id ="of_save" type="button" class="button-primary"><?php _e('Save All Changes', 'Avada');?></button>			
			<button id ="of_reset" type="button" class="button submit-button reset-button" ><?php _e('Options Reset', 'Avada');?></button>
			<img style="display:none" src="<?php echo ADMIN_DIR; ?>assets/images/loading-bottom.gif" class="ajax-reset-loading-img ajax-loading-img-bottom" alt="<?php _e('Working...', 'Avada'); ?>" />
			
		</div><!--.save_bar--> 
 
	</form>
	
	<div style="clear:both;"></div>
	<?php // Avada Edit (killed SMOF notice) ?>

</div><!--wrap-->
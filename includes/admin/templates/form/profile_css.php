<div class="um-admin-metabox">

	<p>
		<label><?php _e('Custom CSS','ultimatemember'); ?> <?php $this->tooltip( __('Enter custom css that will be applied to this form only','ultimatemember'), 'e'); ?></label>
		<textarea name="_um_profile_custom_css" id="_um_profile_custom_css" class="tall"><?php echo UM()->query()->get_meta_value('_um_profile_custom_css', null, 'na' ); ?></textarea>
	</p><div class="um-admin-clear"></div>

</div>
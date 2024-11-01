<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
<h2><?php _e('Sticky Notes', 'wb-sticky-notes'); ?></h2>
<form method="post">
<?php
if (function_exists('wp_nonce_field'))
{
    wp_nonce_field(WB_STN_SETTINGS);
}
if(isset($_GET['wb-suss']))
{
	echo '<div class="updated"><p>'. __('Settings Updated.', 'wb-sticky-notes').'</p></div>';
}
?>
<table class="wb_stn_form-table">
	<tr>
		<td>
			<label><?php _e('Enable sticky notes', 'wb-sticky-notes'); ?></label>
		</td>
		<td>
			<div class="wb_stn_radio_field_main">
				<input type="radio" name="wb_stn[enable]" value="1" <?php echo $the_settings['enable']==1 ? 'checked' : '';?> /> <?php _e('Enable', 'wb-sticky-notes'); ?>
			</div>
			<div class="wb_stn_radio_field_main">
				<input type="radio" name="wb_stn[enable]" value="0" <?php echo $the_settings['enable']==0 ? 'checked' : '';?> /> <?php _e('Disable', 'wb-sticky-notes'); ?>
			</div>
		</td>
	</tr>
	<tr>
		<td><label><?php _e('User roles to uses sticky notes', 'wb-sticky-notes'); ?></label></td>
		<td>
			<?php
			foreach(get_editable_roles() as $role_name => $role_info)
			{
				if('subscriber'===$role_name || 'customer'===$role_name) {
					continue;
				}
			?>
				<div class="wb_stn_font_preview_small_main">
					<div class="wb_stn_radio_field">
						<input type="checkbox" name="wb_stn[role_name][]" id="wb_stn_role_name_<?php echo esc_attr($role_name);?>" value="<?php echo esc_attr($role_name);?>" <?php echo in_array($role_name, $the_settings['role_name']) ? 'checked' : '';?> <?php echo esc_attr('administrator' === $role_name ? 'disabled' : ''); ?>>
						<label style="width:auto; font-weight:normal; <?php echo esc_attr('administrator' === $role_name ? 'opacity:.7; cursor:default; ' : ''); ?>" for="wb_stn_role_name_<?php echo esc_attr($role_name);?>"><?php echo $role_info['name'];?></label>
					</div>
				</div>
				<?php
			}
			?>
		</td>
	</tr>
	<tr>
		<td width="150"><label><?php _e('Default theme', 'wb-sticky-notes'); ?></label></td>
		<td>
			<?php
			foreach(Wb_Sticky_Notes::$themes as $colork=>$color)
			{
				?>
				<div class="wb_stn_preview_small_main">
					<div class="wb_stn_radio_field">
						<input type="radio" name="wb_stn[theme]" value="<?php echo esc_attr($colork);?>" <?php echo $the_settings['theme']==$colork ? 'checked' : '';?> >
					</div>
					<div class="wb_stn_preview_small wb_stn_<?php echo esc_attr($color);?>">
						<div class="wb_stn_note_hd"></div>	
						<div class="wb_stn_note_body"></div>	
					</div>
				</div>
				<?php
			}
			?>
		</td>
	</tr>
	<tr>
		<td><label><?php _e('Default font', 'wb-sticky-notes'); ?></label></td>
		<td>
			<?php
			foreach(Wb_Sticky_Notes::$fonts as $fontk=>$font)
			{
			?>
				<div class="wb_stn_font_preview_small_main">
					<div class="wb_stn_radio_field">
						<input type="radio" name="wb_stn[font_family]" value="<?php echo esc_attr($fontk);?>" <?php echo $the_settings['font_family']==$fontk ? 'checked' : '';?> >
					</div>
					<div class="wb_stn_font_preview_small wb_stn_font_<?php echo esc_attr($font);?>">
						Sample text
					</div>
				</div>
				<?php
			}
			?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<input type="submit" class="button button-primary" name="wb_stn_update_settings" value="<?php _e('Save', 'wb-sticky-notes'); ?>">
		</td>
	</tr>
</table>
</form>
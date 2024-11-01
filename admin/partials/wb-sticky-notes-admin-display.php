<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wordpress.org/plugins/wb-sticky-notes
 * @since      1.0.0
 *
 * @package    Wb_Sticky_Notes
 * @subpackage Wb_Sticky_Notes/admin/partials
 */ 
?>
<div class="wrap">
	<?php 
	if('archives' === $tab)
	{
		require_once plugin_dir_path( __FILE__ ).'_archives_page.php';
	}else
	{
		require_once plugin_dir_path( __FILE__ ).'_settings_page.php';
	}
	?>
	<div style="float:left; margin-top:25px; width:100%;">
		<div style="float:left; font-weight:bold; font-size:18px; width:100%;"><?php _e('Our free plugins', 'wb-sticky-notes'); ?></div>
			<div style="float:left; width:99%; margin-left:1%; margin-top:15px; border:solid 1px #ccc; background:#fff; padding:15px; box-sizing:border-box;">
				<div style="float:left; margin-bottom:0px; width:100%;">
					<div style="float:left; font-weight:bold; font-size:18px; width:100%;">
						<a href="https://webbuilder143.com/woocommerce-custom-product-tabs/" target="_blank" style="text-decoration:none;"><?php _e('Custom Product Tabs For WooCommerce', 'wb-sticky-notes'); ?></a>
					</div>
					<div style="float:left; font-size:13px; width:100%;">
						<ul style="list-style:none;">
							<li>
								<span style="color:green;" class="dashicons dashicons-yes-alt"></span> <?php _e('Add unlimited number of custom product tabs to WooCommerce products.', 'wb-sticky-notes');?>
							</li>
							<li>
								<span style="color:green;" class="dashicons dashicons-yes-alt"></span> <?php _e('Use Global tab option to add Product tabs to Product by Category/Tags.', 'wb-sticky-notes');?>
							</li>
							<li>
								<span style="color:green;" class="dashicons dashicons-yes-alt"></span> <?php _e('Tab position re-arrange option.', 'wb-sticky-notes');?>
							</li>
							<li>
								<span style="color:green;" class="dashicons dashicons-yes-alt"></span> <?php _e('Shortcode support in tab content.', 'wb-sticky-notes');?>
							</li>
							<li>
								<span style="color:green;" class="dashicons dashicons-yes-alt"></span> <?php _e('Filters for developers to alter tab content and position.', 'wb-sticky-notes');?>
							</li>
						</ul>
						<a href="https://wordpress.org/plugins/wb-custom-product-tabs-for-woocommerce/" target="_blank" class="button button-primary"><?php _e('Get the plugin now', 'wb-sticky-notes');?></a>
					</div>
				</div>
			</div>

			<div style="float:left; width:99%; margin-left:1%; margin-top:15px; border:solid 1px #ccc; background:#fff; padding:15px; box-sizing:border-box;">
				<div style="float:left; margin-bottom:0px; width:100%;">
					<div style="float:left; font-weight:bold; font-size:18px; width:100%;">
						<a href="https://webbuilder143.com/mail-logger-for-wordpress/" target="_blank" style="text-decoration:none;"><?php _e('Email logger for WordPress', 'wb-sticky-notes'); ?></a>
					</div>
					<div style="float:left; font-size:13px; width:100%;">
						<ul style="list-style:none;">
							<li>
								<span style="color:green;" class="dashicons dashicons-yes-alt"></span> <?php _e('Save all WordPress emails in the dashboard', 'wb-sticky-notes');?>
							</li>
							<li>
								<span style="color:green;" class="dashicons dashicons-yes-alt"></span> <?php _e('Check email sender, receiver, attachments, send status, send time etc from the dashboard.', 'wb-sticky-notes');?>
							</li>
							<li>
								<span style="color:green;" class="dashicons dashicons-yes-alt"></span> <?php _e('Read all sent/failed emails from WP dashboard.', 'wb-sticky-notes');?>
							</li>
						</ul>
						<a href="https://wordpress.org/plugins/wb-mail-logger/" target="_blank" class="button button-primary"><?php _e('Get the plugin now', 'wb-sticky-notes');?></a>
					</div>
				</div>
			</div>
	</div>
</div>
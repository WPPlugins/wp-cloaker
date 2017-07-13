<?php
if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions to access this page.');
}

?>
<style>
  .leftcol{
    width:75%;
    float: left;
  }
  .rightcol{
    float: right;
    width:25% 
  }
  .rightcol h3{
    line-height:30px; 
  }
  .rightcol img{
    max-width:100%;
  }
  .full{
    display: block;
    width:100%;
    text-align: center;
  }
  .warning{
    border-left:5px solid #e6db55;
  }
  .wp-core-ui .notice.is-dismissible{
    width:68%;
  }
</style>
<div class="wrap">
	<img class="wp-cloaker-logo" src="<?php echo  plugins_url( 'images/wp-cloaker-logo.png', __FILE__ ) ?>" alt="WP Cloaker Logo" />
	<h2><?php echo __('WP Cloaker Default Settings');?></h2>
    <div class="leftcol">
    <?php settings_errors(); ?>
    <div class="notice warning is-dismissible">
        <p><?php _e( 'You may need to ', 'wp-cloaker' ); ?>
            <a href="<?php echo admin_url('options-permalink.php'); ?>">re-save the site permalinks</a>, after updating link prefix setting.
        </p>
    </div>
    <form method="POST" action="options.php" enctype="multipart/form-data">
    	<?php settings_fields( 'wp_cloaker_settings_group' ); ?>
        <?php do_settings_sections( 'wp_cloaker_link_settings' ); ?>
        <?php submit_button(); ?>
    </form></div>
    <div class="rightcol">
        <h3>Do you have a WordPress project and need help with?</h3><br>
        <a href="http://www.upwork.com/o/profiles/users/_~01e511055546161ddc/" target="_blank" class="hireus">
        	<img src="<?php echo plugin_dir_url(__FILE__).'images/hire-us.png' ?>" />
        </a>
        <p style="text-align:center"><strong>Hourly rate: $22.22</strong></p><br>
        <a class="full" href="http://www.wwgate.net" target="_blank">Developed by WWGate</a>
    </div>
</div>
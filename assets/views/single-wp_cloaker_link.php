<?php
$linkOptions = get_post_meta($post->ID);
$link = $linkOptions['wp_cloaker_link'][0];

$cusOptions = $linkOptions['wp_cloaker_link_custom_options'][0];
if($cusOptions){
	$redirect = $linkOptions['wp_cloaker_link_redirection'][0];
}else{
	$redirect = esc_attr( get_option( 'wp_cloaker_link_redirection','301' ) );
}

require_once(wp_cloaker_path.'classes/class-wp-cloaker-clicks.php');
$clicks = new WP_Cloaker_Clicks();
if(get_option('wp_cloaker_link_collect_data','yes') == 'yes'){
	//save visitor information
	$clicks->getIPInfo($post->ID);
}else{
	//save click
	$clicks->count_click($post->ID);
}

switch($redirect){
	case '301':
		header("Location: $link",true,301); 
		break;
	case '302':
		header("Location: $link",true,302); 
		break;
	case '303':
		header("Location: $link",true,303); 
		break;
	case '307':
		header("Location: $link",true,307); 
		break;
	case 'js':
		?><script>window.location.replace("<?php echo $link ?>");</script>'<?php ;
		break;
}
exit;
?>


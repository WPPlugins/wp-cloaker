<?php

class WP_Cloaker_Clicks{

	function __construct() {
		// actions to register table name to $wpdb global
		add_action( 'init', array($this,'wp_cloaker_register_clicks_table'), 1 );
		add_action( 'switch_blog', array($this,'wp_cloaker_register_clicks_table') );
		//update link meta data on edit
	}

	// register table name to $wpdb global
	public function wp_cloaker_register_clicks_table() {
		global $wpdb;
		$wpdb->wp_cloaker_clicks_table = "{$wpdb->prefix}cloaker_clicks";
	}	
	
	// create wp_cloaker_clicks_table
	public function wp_cloaker_create_clicks_table(){
		global $wpdb;
		global $charset_collate;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$this->wp_cloaker_register_clicks_table();
		$create_table_sql = "CREATE TABLE IF NOT EXISTS {$wpdb->wp_cloaker_clicks_table}(
			click_id bigint(20) unsigned NOT NULL auto_increment,
			link_id bigint(20) unsigned NOT NULL default '0',
			click_date datetime NOT NULL default '0000-00-00 00:00:00',
			click_ip varchar(20) NOT NULL default '127.0.0.1',
			click_country varchar(50),
			click_country_code varchar(5),
			click_region_code varchar(50),
			click_latitude varchar(20),
			click_longitude varchar(20),
			click_timezone varchar(50),
			click_city varchar(100),
			PRIMARY KEY  (click_id),
			KEY link (link_id)
		) $charset_collate";
		dbDelta($create_table_sql);

		$v = get_option('wp_cloaker_version','1.0.4');
		if( version_compare($v,'1.0.6') < 0 ){
			global $wpdb;
			$click_count_tbl = "{$wpdb->prefix}cloaker_clicks_count";
			//drop click_count table
			$sql = "DROP TABLE IF EXISTS {$click_count_tbl}";
			$wpdb->query($sql);
		}
		update_option( 'wp_cloaker_version', '1.1.1');
	}
	//return wp_cloaker_clicks_table columns
	public function wp_cloaker_clicks_table_columns(){
		return array(
			'link_id'=> '%d',
			'click_date'=>'%s',
			'click_ip'=>'%s',
			'click_country'=>'%s',
			'click_country_code'=>'%s',
			'click_region_code'=>'%s',
			'click_latitude'=>'%s',
			'click_longitude'=>'%s',
			'click_timezone'=>'%s',
			'click_city'=>'%s'
		);
	}
	
	/*
	* insert click data to the database
	*@param $data array An array of key => value pairs to be inserted
	*@return int The ID of the created click row. Or WP_Error or false on failure.
	*/
	public function wp_cloaker_insert_click($data){
		
		global $wpdb;
		
		//get columns names
		$columns = $this->wp_cloaker_clicks_table_columns();
		//convert array keys to lower case
		$data = array_change_key_case ( $data );
		//White list columns by removing data keys not a column name
    	$data = array_intersect_key($data, $columns);
		//Reorder $columns to match the order of columns given in $data
    	$data_keys = array_keys($data);
    	$columns = array_merge(array_flip($data_keys), $columns);
		//insert data into database
		$wpdb->insert($wpdb->wp_cloaker_clicks_table, $data,$columns);
		$wpdb->insert_id;
	}
	
	/*
	* get GEO information from visitor IP address
	* @return non, but it pass IP data to other function.
	*/
	public function getIPInfo($ID){
		
		$ip = $this->getUserIP();
		// initialize curl session
		$ch = curl_init("http://freegeoip.net/json/$ip");
		// set option to return the value into variable instread of printing it
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$ip_obj =curl_exec($ch);
		curl_close($ch);
		$this->prepareIPData($ip_obj,$ID);
	}
	/*
	* get visitor real IP address
	*@return IP address
	*/
	public function getUserIP()
	{
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];
	
		if(filter_var($client, FILTER_VALIDATE_IP))
		{
			$ip = $client;
		}
		elseif(filter_var($forward, FILTER_VALIDATE_IP))
		{
			$ip = $forward;
		}
		else
		{
			$ip = $remote;
		}
		return $ip;
	}
	/*
	* prepare ip data to be saved
	*@return array of data
	*/
	public function prepareIPData($json,$ID){
		$json = json_decode($json);
		$IPObj = array(
			'link_id'=> $ID,
			'click_date'=>date("Y-m-d H:i:s"),
			'click_ip'=>($json->ip)?$json->ip:'not available',
			'click_country'=>($json->country_name)?$json->country_name:'not available',
			'click_country_code'=>$json->country_code,
			'click_region_code'=>($json->region_code)?$json->region_code:'not available',
			'click_city'=>($json->city)?$json->city :'city not available' ,
			'click_zip'=>($json->zip_code)?$json->zip_code:'not available',
			'click_latitude'=>($json->latitude)?$json->latitude:'not available',
			'click_longitude'=>($json->longitude)?$json->longitude:'not available',
			'click_timezone'=>($json->time_zone)?$json->time_zone:'not available',
		);
		//insert the data to the db
		$this->wp_cloaker_insert_click($IPObj);
	}
	/*
	* prepare ip data to be saved
	*@return array of data
	*/
	public function count_click($ID){
		$obj = array(
			'link_id'=>		$ID,
			'click_date'=>	date("Y-m-d H:i:s"),
			'click_ip'=>	'not available'
		);

		//insert the data to the db
		$this->wp_cloaker_insert_click($obj);
	}
	/*
	* get  clicks count by post ID
	* return clicks count
	*/
	public function getClickCountByPostID($ID){
		global $wpdb;
		$sql = "SELECT count(1) FROM {$wpdb->wp_cloaker_clicks_table} where link_id=$ID";
		return $wpdb->get_var($sql);
	}
	/*
	* get  clicks count by Cat ID
	* return clicks count
	*/
	public function getClickCountByCatID($ID){
		global $wpdb;
		// get cat posts ids 
		$post_ids = get_posts(array(
				'post_type'			=> 'wp_cloaker_link',
		    'numberposts'   => -1, // get all posts.
		    'tax_query'     => array(
		        array(
		            'taxonomy'  => 'wp_cloaker_link_category',
		            'field'     => 'id',
		            'terms'     => $ID,
		        ),
		    ),
		    'fields'        => 'ids', // Only get post IDs
		));
		$ids = implode(',',$post_ids);
		$sql = "SELECT COUNT(1) as total FROM {$wpdb->wp_cloaker_clicks_table} where link_id IN ($ids)";
		$sum = $wpdb->get_var($sql);
		return $sum;
	}
	/*
	* get clicks details by link ID
	* return array of rows
	*/
	public function getClicksDetailsByID($ID,$start,$end){
		global $wpdb;
		$sql = "SELECT * FROM {$wpdb->wp_cloaker_clicks_table} where link_id=$ID ORDER BY click_date DESC LIMIT $start, 10";
		$result = $wpdb->get_results($sql);
		return $result;	
	}
	/*
	* get clicks details total rows
	*  return single value
	*/
	public function getClicksDetailsTotalBYID($ID){
		global $wpdb;
		$sql = "SELECT count(1) FROM {$wpdb->wp_cloaker_clicks_table} where link_id=$ID";
		$result = $wpdb->get_var($sql);
		return $result;	
	}
	/*
	* get clicks count by link id
	* return single value
	*/
	public function getClicksCountBYID($ID){
		global $wpdb;
		$sql = "SELECT count(1) FROM {$wpdb->wp_cloaker_clicks_table} where link_id=$ID";
		$result = $wpdb->get_var($sql);
		return $result;	
	}

	/*
	* delete clicks count by ID
	*/
	public function delete_clicks_count($id){
		global $wpdb;
		$wpdb->query("DELETE FROM {$wpdb->wp_cloaker_clicks_table} where link_id=$id");
	}
	
}
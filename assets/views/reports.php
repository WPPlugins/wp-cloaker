<?php
if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions to access this page.');
}
require_once(wp_cloaker_path .'classes/class-wp-cloaker-reports.php');

$wp_cloaker_reports = new WP_Cloaker_Reports();
$wp_cloaker_clicks = new WP_Cloaker_Clicks();
$month = $cat = $country = $link = null;
if(!empty( $_GET['wp_cloaker_link_click_months'] ) ){
  $month = $_GET['wp_cloaker_link_click_months'];
}
if(!empty( $_GET['wp_cloaker_link_category'] ) ){
  $cat = $_GET['wp_cloaker_link_category'];
}
if(!empty( $_GET['wp_cloaker_link_country'] ) ){
  $country = $_GET['wp_cloaker_link_country'];
}
if(!empty( $_GET['wp_cloaker_link'] ) ){
  $link = $_GET['wp_cloaker_link'];
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
  label{
    width:50%;
    display: inline-block;
    margin-bottom: 15px;
  }
  label span{
    display: inline-block;
    width: 30%;
    font-weight: bold;
  }
  label select{
    width: 50%;
  }
  .button.button-primary{
    float: right;
    margin-right: 10%;
  }
</style>
<div class="wrap">
  <img class="wp-cloaker-logo" src="<?php echo  plugins_url( 'images/wp-cloaker-logo.png', __FILE__ ) ?>" alt="WP Cloaker Logo" />
  <h2><?php echo __('WP Cloaker Reports');?></h2>
  <div class="leftcol">
    <form method="GET" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
      <input type="hidden" name="post_type" value="wp_cloaker_link" />
      <input type="hidden" name="page" value="wp_cloaker_link_reports" />
      <?php $wp_cloaker_reports->wp_cloaker_reports_filters($month,$cat,$country,$link); ?>
    </form>
    <?php //echo '<pre>';var_dump($wp_cloaker_reports->get_clicks_report());echo '</pre>';?>
    <!-- gchart-->
    <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawBackgroundColor);

function drawBackgroundColor() {
      var data = new google.visualization.DataTable();
      data.addColumn('date', 'X');
      data.addColumn('number', 'Clicks');

      data.addRows([
        <?php 
          $total_clicks = 0;
          $clicks_obj = $wp_cloaker_reports->get_clicks_report( $month, $cat, $country, $link );
          
          foreach ($clicks_obj as $key => $obj) {
            echo '[new Date("'.$obj->date.'"),'.$obj->clicks.'],';
            $total_clicks += (int)$obj->clicks; 
          }
        ?>
        
      ]);

      var options = {
        backgroundColor: 'transparent',
        interpolateNulls: false,
        height: 400,
        hAxis: {
          title: 'Date'
        },
        vAxis: {
          title: 'Clicks'
        },
        chartArea: 
        {
            left: 'auto',
            top: 'auto'
        },
        
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_container'));
      chart.draw(data, options);
    }
    </script>
    <!--end gchart-->
    <div class="total-clicks">
      <h4>Total: <?php echo $total_clicks; ?> clicks</h4>
    </div>
    <div id="chart_container" style="width:800px;"></div>
    </div>
    <div class="rightcol">
        <h3>Do you have a WordPress project and need help with?</h3><br>
        <a href="https://www.upwork.com/users/~01cdee61686dcfce3c" target="_blank" class="hireus">
          <img src="<?php echo plugin_dir_url(__FILE__).'images/hire-us.png' ?>" />
        </a>
        <p style="text-align:center"><strong>Hourly rate: $22.22</strong></p><br>
        <a class="full" href="http://www.wwgate.net" target="_blank">Developed by WWGate</a>
    </div>
</div>


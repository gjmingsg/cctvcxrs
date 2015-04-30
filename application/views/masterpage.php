<?php
	require_once("menu.inc.php");
?>
<!DOCTYPE html public "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="Keywords" content="" />
	<meta name="Description" content="" />
	<title><?php echo $title;?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/base.css';?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/style.css';?>" />

	<script type="text/javascript" language="javascript" src="<?php echo base_url().'js/jquery.js';?>"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url().'js/jquery.tableui.js';?>"></script>
	<style type="text/css">
		body {
font: normal 12px auto "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
color: #4f6b72;
}
	</style>
</head>
<body>

<div id="wrapper">
	<div id="header">
		<div id="top_info">
		<h1 class="fl red">代理商管理系统</h1>
		<div class="fr">
			<span>
				<strong > 
					<span><?php echo $this->session->userdata('username');?>，欢迎你,账号余额</span> 

					<span class="red" id="import_notice">
						<?php echo anchor('user/rechargehistory',$this->transaction_model->getbalance($this->session->userdata('userid'))."元"); ?>
					</span>
					
				</strong>
			| <span><?php echo anchor('user/changepwd/'.$this->session->userdata('userid'), '修改密码', 'title="修改密码"'); ?>
			| <span><?php echo anchor('auth/logout/'.$this->session->userdata('userid'), '退出', 'title="退出"'); ?>
			</span>

		</div>
		<div class="clear"></div>
		</div><!--end: top_info -->
		
		<div id="menu">
			<div class="tabArea fullwidth">
				<ul class="tabList">
				<?php
					if($this->uri->segment(2)=='')
						$cur_uri=$this->uri->segment(1);
					else
						$cur_uri=$this->uri->segment(1)."/".$this->uri->segment(2);
					
					
					
					$cur_top_menu = array();
					foreach($top_menu as $key=>$value)
					{
						$keys = array_keys($value);
						if(in_array($cur_uri, $value))
						{
							echo "<li><a class='current' href=".$base_url.$value[$keys[0]].">".$key."</a></li>";
							$cur_top_menu = $value;
						}	
						else				
							echo "<li><a href=".$base_url.$value[$keys[0]].">".$key."</a></li>";
					}
				?>
				
				</ul>
			<div class="clear"></div>
			</div>
			<div id="menu_level2"> 
				<ul id="menu_level2_list">
				<?php
					foreach($cur_top_menu as $key=>$value)
					{
						if($value==$cur_uri)			
							echo "<li><a class='current' href=".$base_url.$value.">".$key."</a></li>";
						else
							echo "<li><a href=".$base_url.$value.">".$key."</a></li>";
					}
				?>
					
				</ul>			
			</div>
		</div><!--end: menu -->
	</div><!--end: header -->

	<div id="container">
	
			<?php  
					$data['base_url'] = $base_url;
					if (isset($row))
					{
						$data['row'] = $row;
					}
					$this->load->view($include,$data);
			?>

	</div><!--end: container -->

	<div id="footer">
		<div id="friendLink">
		</div><!--end: friendLink -->
	</div><!--end: footer -->
</div><!--end: wrapper -->

</body>
</html>

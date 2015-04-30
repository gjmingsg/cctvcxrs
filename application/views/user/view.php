
<div>
	<h1>查看用户</h1>
	 
	<table  border="0" cellpadding="3" cellspacing="0" >
		<tr>
			<th width="20%">用户账号：</th>
			<td>
			<?php echo form_label($item->LoginId);?>
			</td>
		</tr>
		<tr>
			<th>用户姓名：</th>
			<td>
			<?php echo form_label( $item->UserName);?>
			</td>
		</tr>
		<tr>
			<th>身份证：</th>
			<td>
				<div>
					<?php echo $item->IDCard;?>
				</div>
			</td>
		</tr>
		<tr>
			<th>电话：</th>
			<td>
				<div>
					<?php echo $item->Phone;?>
				</div>
			</td>
		</tr>
		<tr>
			<th>邮箱：</th>
			<td>
				<div>
					<?php echo $item->Email;?>
				</div>
			</td>
		</tr>
		<tr>
			<th>添加时间：</th>
			<td>
				<div>
					<?php echo $item->CreateTime;?>
				</div>
			</td>
		</tr>
		<?php if($item->UserType==1)
			echo "<tr><th>折扣：</th><td>".$item->Discount."</td></tr>";
		?>
		<tr>		
			<td colspan="2">
				<div class="fr">
					<?php echo form_button('name','返回','id="back"'); ?>
				</div>
			</td>
		</tr>
		
	</table>
	<h1>充值历史</h1>
	<?php 
		$this->table->set_heading(array('充值金额(元)', '充值时间'));
		$tmpl = array ( 'table_open'  => '<table border="0" cellpadding="3" cellspacing="0"  class="fullwidth table_solid">' );
		$this->table->set_template($tmpl); 
		echo $this->table->generate($row); 
		?>
</div>

<script type="text/javascript">
$('#back').click(function(){
			window.location='<?php 
			if ($this->session->userdata("usertype")==0)
				echo site_url("user/index"); 
			else
				echo site_url("user/listagent");
			?>';
		});
</script>
 

<div>
	<h1><?php echo $title;?></h1>
	 
	<table  border="0" cellpadding="3" cellspacing="0" >
		<tr>
			<th width="20%">公司名称：</th>
			<td>
			<?php echo form_label($item->Company);?>
			</td>
		</tr>
		<tr>
			<th>法人/销售代表：</th>
			<td>
			<?php echo form_label( $item->UserName);?>
			</td>
		</tr>
		<tr>
			<th>职务：</th>
			<td>
				<div>
					<?php echo $item->Position;?>
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
			<th>通讯地址：</th>
			<td>
				<div>
					<?php echo $item->Address;?>
				</div>
			</td>
		</tr>
		<tr>		
			<td colspan="2">
				<div class="fr">
					<?php echo form_button('name','返回','id="back"'); ?>
				</div>
			</td>
		</tr>
		
	</table>

	<h1>购买记录</h1>
	<?php 
		$this->table->set_heading(array('购买时间', '数量','金额','产品','审批状态','审批结果'));
		$tmpl = array ( 'table_open'  => '<table border="0" cellpadding="3" cellspacing="0"  class="fullwidth table_solid">' );
		$this->table->set_template($tmpl); 
		echo $this->table->generate($row); 
		?>
</div>

<script type="text/javascript">
$('#back').click(function(){
			window.location='<?php echo site_url("customer/index") ?>';
		});
</script>
 
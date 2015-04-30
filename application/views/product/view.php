
<div>
	<h1>查看产品</h1>
	 
	<table  border="0" cellpadding="3" cellspacing="0" >
		<tr>
			<th width="20%">产品名称：</th>
			<td>
			<?php echo form_label($item->ProductName);?>
			</td>
		</tr>
		<tr>
			<th>产品价格：</th>
			<td>
			<?php echo form_label( $item->Price);?>
			</td>
		</tr>
		<tr>
			<th>产品描述：</th>
			<td>
				<div>
					<?php echo $item->Description;?>
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
</div>

<script type="text/javascript">
$('#back').click(function(){
			window.location='<?php echo site_url("product/index") ?>';
		});
</script>
 
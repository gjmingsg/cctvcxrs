
<div>
	<h1><?php echo $title;?></h1>
	 <?php echo form_open('product/purchase/'.$item->ProductID, 'id="detailForm"'); ?>
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
			<?php echo form_label($item->Price);?>
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
			<th>购买数量：</th>
			<td>
				<div>
					<?php echo form_input('Amount',set_value('Amount',1),'id="Amount" maxlength="10" class="required"');?>
					<?php echo form_hidden('ProductID',$item->ProductID);?>
					 
				</div>
			</td>
		</tr>
		<tr>
			<th>客户：</th>
			<td>
				<div>
					<?php echo form_dropdown('CustomerID', $row, ' ');?>					
				</div>
			</td>
		</tr>
		<tr>		
			<td colspan="2">
				<div class="fr">
					<?php echo form_submit('submit','保存'); ?>
					<?php echo form_button('name','返回','id="back"'); ?>
				</div>
			</td>
		</tr>
		
	</table>
	<?php form_close()?>
</div>
<div class="error">
	<?php echo validation_errors(); ?>
	<?php if(!empty($err_code_msg))echo $err_code_msg; ?>
</div>
<script src="<?php echo base_url();?>js/jquery.validate.min.js"></script>
<script type="text/javascript">
		$('#back').click(function(){
			window.location='<?php echo site_url("product/index"); ?>';
		});

		var v = $("#detailForm").validate(
			{
				errorClass: "error",
				rules: {
					Amount:{required:true,maxlength:10,minlength:1,digits:true}, 
					CustomerID:{min:0}
				},
				messages: {
					CustomerID:{min:'必须选择客户，不能为空'},
					Amount:{required:"请输入产品价格(元)", maxlength:"请输入1-10个字符", minlength:"请输入1-10个字符",digits:'必须输入整数'}
				}
			}
		);
</script>
 
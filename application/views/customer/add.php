
<div>
	<h1><?php echo $title;?></h1>
	<?php echo form_open('customer/add', 'id="detailForm"'); ?>
	<table  border="0" cellpadding="3" cellspacing="0" >
		<tr>
			<th width="20%">公司名称：</th>
			<td>
			<?php echo form_input('Company',set_value('Company'),'id="Company" maxlength="200" class="required"');?>
			</td>
		</tr>
		<tr>
			<th>法人/销售代表：</th>
			<td>
			<?php echo form_input('UserName',set_value('UserName'),'id="Price" maxlength="20" class="required"');?>
			</td>
		</tr>
		<tr>
			<th>职务：</th>
			<td>
			<?php echo form_input('Position',set_value('Position'),'id="Price" maxlength="20" class="required"');?>
			</td>
		</tr>
		<tr>
			<th>电话：</th>
			<td>
			<?php echo form_input('Phone',set_value('Phone'),'id="Phone" maxlength="20" class="required"');?>
			</td>
		</tr>
		<tr>
			<th>邮箱：</th>
			<td>
			<?php echo form_input('Email',set_value('Email'),'id="Email" maxlength="25" class="required"');?>
			</td>
		</tr>
		<tr>
			<th>通讯地址：</th>
			<td>
			<?php echo form_textarea('Address',set_value('Address'),'id="Address"  style="width:700px;height:200px;"');?>
			</td>
		</tr>
		<tr>		
			<td colspan="2">
				<div class="fr">
					<?php echo form_submit('submit','保存'); ?>
					<?php echo form_button('back','返回','id="back"'); ?>
				</div>
			</td>
		</tr>
		
	</table>
	<?php echo form_close(); ?>
</div>

<div class="error">
	<?php echo validation_errors(); ?>
	<?php if(!empty($err_code_msg))echo $err_code_msg; ?>
</div>

<script src="<?php echo base_url();?>js/jquery.validate.min.js"></script>
 
<script type="text/javascript">
	 
		$('#back').click(function(){
			window.location='<?php echo site_url("product/index") ?>';
		});
		var v = $("#detailForm").validate(
			{
				errorClass: "error",
				rules: {
					Company:{required:true,maxlength:200,minlength:2},
					UserName:{required:true,maxlength:20,minlength:1},
					Email:{email:true,maxlength:25}
				},
				messages: {
					Company:{required:"请输入公司名称", maxlength:"请输入2-200个字符", minlength:"请输入2-200个字符"},
					UserName:{required:"请输入法人/销售代表", maxlength:"请输入2-20个字符", minlength:"请输入2-20个字符"},
					Email:{email:"必须输入正确格式的电子邮件", maxlength:"请输入少于25个字符"}
				}
			}
		);
</script>
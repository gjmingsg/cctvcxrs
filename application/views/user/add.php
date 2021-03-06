
<div>
	<h1><?php echo $title;?></h1>
	<?php echo form_open('user/'.$type, 'id="detailForm"'); ?>
	<table  border="0" cellpadding="3" cellspacing="0" >
		<tr>
			<th>用户姓名：</th>
			<td>
			<?php echo form_input('UserName',set_value('UserName'),'id="UserName" maxlength="25" class="required"');?>
			</td>
		</tr>
		<tr>
			<th width="20%">用户账号：</th>
			<td>
			<?php echo form_input('LoginId',set_value('LoginId'),'id="LoginId" maxlength="25" class="required"');?>
			</td>
		</tr>
		
		<tr>
			<th>密码：</th>
			<td>
			<?php echo form_password('Password',set_value('Password'),'id="Password" maxlength="25" class="required"');?>
			</td>
		</tr>
		<tr>
			<th>邮箱：</th>
			<td>
			<?php echo form_input('Email',set_value('Email'),'id="Email" maxlength="25"');?>
			</td>
		</tr>
		<tr>
			<th>电话：</th>
			<td>
			<?php echo form_input('Phone',set_value('Phone'),'id="Phone" maxlength="25"');?>
			</td>
		</tr>
		<tr>
			<th>身份证：</th>
			<td>
			<?php echo form_input('IDCard',set_value('IDCard'),'id="IDCard" maxlength="25" class="required"');?>
			</td>
		</tr>
		<?php if($type=='addagent')
			echo "<tr><th>折扣：</th><td>".
			form_input('Discount',set_value('Discount',1),'id="Discount" maxlength="5" class="required"').
			"</td></tr>";
		?>

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
			window.location='<?php echo site_url("user/index") ?>';
		});
		var v = $("#detailForm").validate(
			{
				errorClass: "error",
				rules: {
					LoginId:{required:true,maxlength:15,minlength:2},
					UserName:{required:true,maxlength:15,minlength:1},
					Password:{required:true,maxlength:15,minlength:2},
					IDCard:{maxlength:25},
					Email:{email:true,maxlength:25}
				},
				messages: {
					LoginId:{required:"请输入用户账号", maxlength:"请输入2-15个字符", minlength:"请输入2-15个字符"},
					UserName:{required:"请输入用户姓名", maxlength:"请输入2-15个字符", minlength:"请输入2-15个字符"},
					Password:{required:"请输入密码", maxlength:"请输入2-15个字符", minlength:"请输入2-15个字符"},
					IDCard:{ maxlength:"请输入少于25个字符"},
					Email:{email:"必须输入正确格式的电子邮件", maxlength:"请输入少于25个字符"}
				}
			}
		);
</script>
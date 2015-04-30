
<div>
	<h1><?php echo $title; ?></h1>
	<?php echo form_open('user/changepwd/'.$UserID, 'id="detailForm"'); ?>
	<table  border="0" cellpadding="3" cellspacing="0" >
		<tr>
			<th width="20%">新密码：</th>
			<td>
			<?php echo form_password('Password',set_value('Password'),'id="Password" maxlength="15" class="required"');?>
			</td>
		</tr>
		<tr>
			<th>重输密码：</th>
			<td>
			<?php echo form_password('rePassword',set_value('rePassword'),'id="rePassword" maxlength="15" class="required"');?>
			<?php echo form_hidden('UserID',set_value('UserID',$UserID));?>
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
			window.location='<?php echo site_url("user/index") ?>';
		});

		var v = $("#detailForm").validate(
			{
				errorClass: "error",
				rules: {
					Password:{required:true,maxlength:15,minlength:2},
					rePassword:{required:true,maxlength:15,minlength:2,equalTo:'#Password'}
				},
				messages: {
					Password:{required:"请输入密码", maxlength:"请输入2-15个字符", minlength:"请输入2-15个字符"},
					rePassword:{required:"请输入重输密码", maxlength:"请输入2-15个字符", minlength:"请输入2-15个字符",equalTo:'输入值必须和密码相同'}
				}
			}
		);
</script>
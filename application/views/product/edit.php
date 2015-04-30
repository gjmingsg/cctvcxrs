<link rel="stylesheet" href="<?echo base_url();?>js/editor/themes/default/default.css" />
<link rel="stylesheet" href="<?echo base_url();?>js/editor/plugins/code/prettify.css" />
<div>
	<h1>编辑产品</h1>
	<?php echo form_open('product/edit', 'id="detailForm"'); ?>
	<table  border="0" cellpadding="3" cellspacing="0" >
		<tr>
			<th width="20%">产品名称：</th>
			<td>
			<?php echo form_input('ProductName',$item->ProductName,'id="ProductName" maxlength="15" class="required"');?>
			<?php echo form_hidden('ProductID',$item->ProductID);?>
			</td>
		</tr>
		<tr>
			<th>产品价格：</th>
			<td>
			<?php echo form_input('Price',$item->Price,'id="Price" maxlength="15" class="required"');?>
			</td>
		</tr>
		<tr>
			<th>产品描述：</th>
			<td>
			<?php echo form_textarea('Description',$item->Description,'id="Description"  style="width:700px;height:200px;visibility:hidden;"');?>
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
<script src="<?php echo base_url();?>js/editor/kindeditor.js"></script>
<script src="<?php echo base_url();?>js/editor/lang/zh_CN.js"></script>
<script src="<?php echo base_url();?>js/editor/plugins/code/prettify.js"></script>
<script type="text/javascript">
	KindEditor.ready(function(K) {
			var editor1 = K.create('textarea[name="Description"]', {
				cssPath : '<?php echo base_url();?>js/editor/plugins/code/prettify.css',
				uploadJson : '<?php echo base_url();?>js/editor/php/upload_json.php',
				fileManagerJson : '<?php echo base_url();?>js/editor/php/file_manager_json.php',
				allowFileManager : true,
				afterCreate : function() {
					var self = this;
					K.ctrl(document, 13, function() {
						self.sync();
						K('form[name=Description]')[0].submit();
					});
					K.ctrl(self.edit.doc, 13, function() {
						self.sync();
						K('form[name=Description]')[0].submit();
					});
				}
			});
			prettyPrint();
		});
		
		$('#back').click(function(){
					window.location='<?php echo site_url("product/index") ?>';
			});

		var v = $("#detailForm").validate(
			{
				errorClass: "error",
				rules: {
					ProductName:{required:true,maxlength:215,minlength:2},
					Price:{required:true,maxlength:10,minlength:1,number:true} 
				},
				messages: {
					ProductName:{required:"请输入产品名称", maxlength:"请输入2-215个字符", minlength:"请输入2-215个字符"},
					Price:{required:"请输入产品价格(元)", maxlength:"请输入1-10个字符", minlength:"请输入1-10个字符",number:'必须输入合法的数字'}
				}
			});
</script>
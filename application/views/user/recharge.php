<div>
	<h1><?php echo $title;?></h1>
	<?php echo form_open('user/recharge/'.$UserID, 'id="detailForm"'); ?>
	<table  border="0" cellpadding="3" cellspacing="0" >
		<tr>
			<th width="20%">充值金额(元)：</th>
			<td>
			<?php echo form_input('Money',set_value('Money'),'id="Money" maxlength="15" class="required"');?>
			<?php echo form_hidden('UserID',$UserID,'id="UserID"');?>
			</td>
		</tr>
		<tr>
			<td colspan='2'>
				<div class="fr">
					<?php echo form_submit('submit','保存'); ?>
					<?php echo form_button('back','返回','id="back"'); ?>
				</div>
			</td>
		</tr>
	</table>
	<?php echo form_close();?>

	<h1>充值历史</h1>
	<?php 
		$this->table->set_heading(array('充值金额(元)', '充值时间'));
		$tmpl = array ( 'table_open'  => '<table border="0" cellpadding="3" cellspacing="0"  class="fullwidth table_solid">' );
		$this->table->set_template($tmpl); 
		echo $this->table->generate($row); 
		?>
</div>


<script src="<?php echo base_url();?>js/jquery.validate.min.js"></script>

<script type="text/javascript">
		
		$().ready(function(){
			$(".table_solid").tableUI();
			$('#back').click(function(){
				window.location='<?php echo site_url("user/index"); ?>';
			});

			var v = $("#detailForm").validate(
			{
				errorClass: "error",
				rules: {
					Money:{required:true,maxlength:15,minlength:1,number:true}
				},
				messages: {
					Money:{required:"请输入充值金额", maxlength:"请输入1-15个字符", minlength:"请输入1-15个字符",number:'必须输入合法的数字'}
				}
			});
		})
</script>
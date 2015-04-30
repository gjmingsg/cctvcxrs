
<div>
	<h1><?php echo $title;?></h1>
	 <?php echo form_open('transaction/approval/'.$item->TransID, 'id="detailForm"'); ?>
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
			<th>订购数量：</th>
			<td>
				<div>
					<?php echo $item->Amount;?>
				</div>
			</td>
		</tr>
		<tr>
			<th>订购时间：</th>
			<td>
				<div>
					<?php echo $item->CreateTime;?>
				</div>
			</td>
		</tr>
		<tr>
			<th>审批结果：</th>
			<td>
				<div>
					<?php 
						$TStatus = array('' =>'请选择' ,'通过'=>'通过','不通过'=>'不通过' );
						echo form_dropdown('TStatus', $TStatus, '');?>
					<?php echo form_hidden('ProductID',$item->ProductID);?>
					<?php echo form_hidden('UserID',$item->UserID);?>
					<?php echo form_hidden('TransID',$item->TransID);?>
				</div>
			</td>
		</tr>
		<tr>
			<th>审批意见：</th>
			<td>
				<div>
					<?php echo form_textarea('ApprovalText',set_value('ApprovalText'),'id="ApprovalText"  style="width:700px;height:200px;"');?>
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
	<?php form_close();?>
</div>
<script src="<?php echo base_url();?>js/jquery.validate.min.js"></script>
<script type="text/javascript">
$('#back').click(function(){
			window.location='<?php echo site_url("transaction/approvallist"); ?>';
		});
		 
</script>
 
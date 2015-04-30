
<div>
	<h1><?php echo $title;?></h1>
	 
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
			<th>购买数量：</th>
			<td>
				<div>
					<?php echo $item->Amount;?>
				</div>
			</td>
		</tr>
		<tr>
			<th>购买时间：</th>
			<td>
				<div>
					<?php echo $item->CreateTime;?>
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
			window.location='<?php 
			if ($this->session->userdata("usertype")==2)
				echo site_url("transaction/thirdlist") ;
			elseif($this->session->userdata("usertype")==1)
				echo site_url("transaction/owntrans") ;
			else
				echo site_url("transaction/index") ;
			?>';
		});
</script>
 
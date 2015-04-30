
<h1><?php echo $title;?></h1>
<div class="block"> 
	
	<div class="fr" id="search"> 
	    
		<?php echo form_open('transaction/'. $this->uri->segment(2), 'id="searchForm"'); ?>
			
			<?php 
			///如果是代理商，则不需要列出代理商查询条件
			if($this->session->userdata('usertype')!=1){
				echo "代理商：";
				echo form_dropdown('txtSearch3', $options, ' ');
			}?>

	    	交易时间：
	    	<input type="text" id="txtSearch1" name="txtSearch1"  onfocus="WdatePicker({isShowWeek:true})"/>
	    	至
	    	<input type="text" id="txtSearch2" name="txtSearch2"  onfocus="WdatePicker({isShowWeek:true})"/>
			<?php echo form_submit('submit','搜索'); ?>
		<?php echo form_close(); ?>
	</div>
	<div class="clear"></div>
</div><!--end: block -->

<div class="block"> 
<table border="0" cellpadding="3" cellspacing="0"  class="fullwidth table_solid">
<thead>
    <tr>
        <th style='width:120px'>操作</th>
        <th>交易人</th>
        <th>单价(元)</th>
        <th>交易类型</th>
        <th>购买</th>
        <th>客户</th>
        <th>审批状态</th>
        <th>交易时间</th>
    </tr>
</thead>
<tbody>
	<?php foreach ($row as $item): ?>
	 	<tr>
	 		<td>
	 		<?php 
	 			if($item['TransType']=='购买'){
	 				echo anchor("transaction/view/".$item["TransID"], '查看', 'class="btn4"');
	 			}
	 			if($this->uri->segment(2)=='approvallist'){
	 				echo anchor("transaction/approval/".$item["TransID"], '审批', 'class="btn8"');
	 			}
	 			if($item['TStatus']=='未审核'){
	 				echo anchor("transaction/del/".$item["TransID"], '删除', 'class="btn3"');	
	 			}
	 		?>
	 		</td>
	 		<td>
	 			<?php echo $item['UserName'] ?>
	 		</td>
	 		<td>
	 			<?php echo $item['Money'] ?>
	 		</td>
	 		<td>
	 			<?php echo $item['TransType'] ?>
	 		</td>
	 		<td>
	 			<?php echo $item['ProductName'] ?>
	 		</td>
	 		<td>
	 			<?php 
	 			if(isset($item['CustomerID']))
	 				echo anchor("customer/view/".$item['CustomerID'],$item['CustomerName'] );?>
	 		</td>
	 		<td>
	 			<span <?php if($item['TStatus']=='通过')
	 				echo 'class="btn10"';
	 			elseif ($item['TStatus']=='不通过')
	 				echo'class="btn11"';?>>
	 				<?php echo $item['TStatus'];?>
	 			</span>
	 		</td>
	 		<td>
	 			<?php echo $item['CreateTime'] ?>
	 		</td>
    	</tr>
	<?php endforeach ?>

</tbody>
</table>
</div><!--end: block -->



<div class="block"> 
    
	<div class="fr"> 
	    <div class="page_list">
			<?php echo $this->pagination->create_links();?>
        </div>
    </div>
    <div class="clear"></div>
</div>
<script type="text/javascript" src='<?php echo base_url()?>/js/datepicker/WdatePicker.js'></script>
<script type="text/javascript">
	function add() {
		window.location = '<?php echo site_url("transaction/add");?>';
	}
	$().ready(function(){
		$(".table_solid").tableUI();
	})
</script>
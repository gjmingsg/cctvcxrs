<div class="block"> 
	<div class="fl"> 
	<?php
			$CI = &get_instance(); 
	 		$usertype = $CI->session->userdata("usertype");
	 		if($usertype==0)
	 		{
	?>
		<button onclick="return window.location = '<?php echo site_url("product/add");?>';">添加</button>
	<?php }?>
	</div>
	<div class="fr" id="search"> 
		<?php 
			echo form_open('product/index', 'id="searchForm"');
			echo "服务名称：";
			echo form_input('txtSearch',set_value('txtSearch'),'id="txtSearch"');
			echo form_submit('submit','搜索'); 
			echo form_close(); 
		 ?>
	</div>
	<div class="clear"></div>
</div><!--end: block -->

<div class="block"> 
<table border="0" cellpadding="3" cellspacing="0"  class="fullwidth table_solid">
<thead>
    <tr>
        <th style='width:200px'>操作</th>
        <th>产品服务名称</th>
        <th>价格(元)</th>
    </tr>
</thead>
<tbody>
	<?php foreach ($row as $item): ?>
	 	<tr>
	 		<td>
	 			<?php 
	 				echo anchor("product/view/".$item["ProductID"], '查看', 'title="查看" class="btn4"');
	 				$CI = &get_instance(); 
	 				$usertype = $CI->session->userdata("usertype");
	 				if($usertype==0)
	 				{
	 					echo anchor("product/edit/".$item["ProductID"], '修改', 'title="修改" class="btn2"');
	 					echo anchor("product/del/".$item["ProductID"], '删除', 'title="删除" class="btn3"');
	 				}
	 				if($usertype==1){
	 					echo anchor("product/purchase/".$item["ProductID"], '订购', 'title="订购" class="btn5"');
	 				}
	 			?>
	 		</td>
	 		<td>
	 			<?php echo $item['ProductName'] ?>
	 		</td>
	 		<td>
	 			<?php echo $item['Price'] ?>
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
<script type="text/javascript">
	$().ready(function(){
		$(".table_solid").tableUI();
	})
</script>
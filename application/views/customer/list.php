<div class="block"> 
	<div class="fl"> 
		<?php 
		if ($this->session->userdata('usertype')==1)
	 	{
			echo form_button("add",'添加','onclick="add()"');
		}
		?>
	</div>
	<div class="fr" id="search"> 
		<?php 
			echo form_open('customer/index', 'id="searchForm"');
			echo "客户名称：";
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
        <th>客户名称</th>
        <th>公司名称</th>
        <th>职务</th>
        <th>电话</th>
        <th>邮箱</th>
    </tr>
</thead>
<tbody>
	<?php foreach ($row as $item): ?>
	 	<tr>
	 		<td>
	 			<?php 
	 				echo anchor("customer/view/".$item["CustomerID"], '查看', 'title="查看" class="btn4"');
	 				echo anchor("customer/edit/".$item["CustomerID"], '修改', 'title="修改" class="btn2"');
	 				echo anchor("customer/del/".$item["CustomerID"], '删除', 'title="删除" class="btn3"'); 
	 			?>
	 		</td>
	 		<td>
	 			<?php echo $item['UserName'] ?>
	 		</td>
	 		<td>
	 			<?php echo $item['Company'] ?>
	 		</td>
	 		<td>
	 			<?php echo $item['Position'] ?>
	 		</td>
	 		<td>
	 			<?php echo $item['Phone'] ?>
	 		</td>
	 		<td>
	 			<?php echo $item['Email'] ?>
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
	function add() {
		window.location = '<?php echo site_url("customer/add");?>';
	}
	$().ready(function(){
		$(".table_solid").tableUI();
	})
</script>
<div class="block"> 
	<div class="fl"> 
	<?php 
		if ($this->session->userdata('usertype')==0)
	 	{
			echo form_button("add",'添加','onclick="return add();"');
		}
	?>
		
	</div>
	<div class="fr" id="search"> 
		<?php echo form_open('user/'.$this->uri->segment(2), 'id="searchForm"'); ?>
	    	姓名：<input type="text" id="txtSearch" name="txtSearch" />
			<?php echo form_submit('submit','搜索'); ?>
		<?php echo form_close(); ?>
	</div>
	<div class="clear"></div>
</div><!--end: block -->

<div class="block"> 
<table border="0" cellpadding="3" cellspacing="0"  class="fullwidth table_solid">
<thead>
    <tr>
        <th style='width:300px'>操作</th>
        <th>登录账号</th>
        <th>姓名</th>
        <th>账号余额</th>
        <th>电话</th>
        <th>添加时间</th>
        <?php 
		if($this->uri->segment(2)=='listagent'){
        	echo "<th>折扣</th>	";
        }
        ?>
    </tr>
</thead>
<tbody>
	<?php foreach ($row as $item): ?>
	 	<tr>
	 		<td>
	 			<?php 
	 			$UserType = $this->session->userdata('usertype');
	 			if ($UserType==0)
	 			{
	 				echo anchor("user/view/".$item["UserID"], '查看', 'class="btn4"');
	 				echo anchor("user/changepwd/".$item["UserID"], '重置密码', 'class="btn6"');
	 				echo anchor("user/edit/".$item["UserID"], '修改', 'class="btn2"');
	 				echo anchor("user/recharge/".$item["UserID"], '充值', 'class="btn7"');
	 				echo anchor("user/del/".$item["UserID"], '删除', 'class="btn3"');
	 				if($this->uri->segment(2)=='listthird'){
	 					echo anchor("user/setagent/".$item["UserID"], '设定代理商', 'class="btn9"');
	 				}
	 			}
	 			elseif ($UserType==1) {
	 				echo anchor("user/view/".$item["UserID"], '查看', 'class="btn4"');
	 			}elseif ($UserType==2) {
	 				echo anchor("user/view/".$item["UserID"], '查看', 'class="btn4"'); 
	 			}
	 			?>
	 		</td>
	 		<td>
	 			<?php echo $item['LoginId'] ?>
	 		</td>
	 		<td>
	 			<?php echo $item['UserName'] ?>
	 		</td>
	 		<td>
	 			<?php echo $item['Balance'] ?>
	 		</td>
	 		<td>
	 			<?php echo $item['Phone'] ?>
	 		</td>
	 		 <td>
	 			<?php echo $item['CreateTime'] ?>
	 		</td>
 			<?php if($this->uri->segment(2)=='listagent'){
        		echo "<td>".$item['Discount']."</td>";
        	}?>
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
		window.location = '<?php echo site_url("user/".$type);?>';
	}
	$().ready(function(){
		$(".table_solid").tableUI();
	})
</script>
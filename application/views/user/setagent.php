<div class="block">
	<h1><?php echo $title;?></h1>
	<?php echo form_open('user/savesetagent/'.$UserID, 'id="detailForm"'); ?>
	<table border="0" cellpadding="3" cellspacing="0" >
		<tr>
			<td>
				<?php echo form_multiselect('lbLeft',$row,'','id="lbLeft" style="width:250px; height:300px; overflow:auto;"');?>
			</td>
			<td>
			<button name="right" type="button" id="right" value="选择">选择</button>
			<br />
			<button name="left" type="button" id="left" value="退选">退选</button>
			<br />
			<button name="rightAll" type="button" id="rightAll" value="全选">全选</button>
			<br />
			<button name="leftAll" type="button" id="leftAll" value="取消">取消</button>
			</td>
			<td>
				<?php echo form_multiselect('lbRight',$selected,'','id="lbRight" style=" width:250px; height:300px; overflow:auto;"');
					  echo form_hidden('selected', '','id="selected"');
				?>
			</td>
		</tr>
		<tr>
			<td colspan='3'>
				<div class="fr">
					<?php echo form_submit('submit','保存','onclick="resethf()"'); ?>
					<?php echo form_button('back','返回','id="back"'); ?>
				</div>
			</td>
		</tr>
	</table>
	<?php echo form_close(); ?>
</div>

<script type="text/javascript">
	function resethf() {
        var hf = $('input[name="selected"]');
        hf.val("");
        
        $('select[name="lbRight"] option').each(function (index, dom) {
            hf.val(hf.val()+$(dom).val() + ";") ;
        });
        
        return true;
    }
    $(document).ready(function () {
	    $('#back').click(function(){
				window.location='<?php echo site_url("user/listthird"); ?>';
		});

        $('select[name="lbLeft"]').dblclick(function () {
            $('select[name="lbLeft"] option:selected').appendTo("#lbRight");
        });
        $('select[name="lbRight"]').dblclick(function () {
            $('select[name="lbRight"] option:selected').appendTo("#lbLeft");
        });

        $('#left').click(function () {
            $('select[name="lbRight"] option:selected').appendTo("#lbLeft");
        });
        $('#right').click(function () {
            $('select[name="lbLeft"] option:selected').appendTo("#lbRight");
        });
        $('#leftAll').click(function () {
            $('select[name="lbRight"] option').appendTo("#lbLeft");
        });
        $('#rightAll').click(function () {
            $('select[name="lbLeft"] option').appendTo("#lbRight");
        });
    });
</script>
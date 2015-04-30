<div>
	<h1>充值历史</h1>
	<?php 
		$this->table->set_heading(array('充值金额(元)', '充值时间'));
		$tmpl = array ( 'table_open'  => '<table border="0" cellpadding="3" cellspacing="0"  class="fullwidth table_solid">' );
		$this->table->set_template($tmpl); 
		echo $this->table->generate($row); 
		?>

		<div class="fr">
			<?php echo form_button('back','返回','id="back"'); ?>
		</div>
</div>


<script src="<?php echo base_url();?>js/jquery.validate.min.js"></script>

<script type="text/javascript">
		
		$().ready(function(){
			$(".table_solid").tableUI();
			$('#back').click(function(){
				window.location='<?php echo site_url("default_page/index"); ?>';
			});
		})
</script>
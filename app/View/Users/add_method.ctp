<div class="row">
	<div class="col-lg-12">
    	<h1 class="page-header">
    		<?php echo __("Add New Method User") ?>
    	</h1>
    </div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-green">
			<div class="panel-heading">
            	<?php //echo __("Basic Information")?>
            </div>
			<div class="panel-body">
				 	<?php echo $this->Form->create('MethodUser', array(
                        'role' => 'form'
                    )); ?>
					<div class="form-group">
							 <label><?php echo __("Method")?></label> 
							 <?php
								 $options = $method_list;
								 echo	$this->Form->select('method_id',$options,array(
										'empty' => false, 
										'class' => 'form-control',
										'div'=>false,
										'required'=>'required'
									));
						   ?>
					</div>
					<div class="form-group">
						<label><?php echo __("Level")?></label> 
						<?php
								$options = $this->Ppg->getMethodUserLevels();
								echo	$this->Form->select('level',$options,array(
									'empty' => false, 
									'class' => 'form-control',
									'div'=>false,
									'required'=>'required'
								));
						?>
					</div>

					<button type="submit" class="btn btn-default"><?php echo __("Save")?></button>
				 <?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
<?php if($this->Session->read('Auth.User.type') == 'payment_admin'):?>
	<script type="text/javascript">
		$(document).ready(function(){
			var storeId = $("#MethodUserMethodId").val();
			pgwMethod.setMethodUserLevelHtml(storeId);
			$("#MethodUserMethodId").select2() .on("change", function(e) {
				var methodId = e.val;
				pgwMethod.setMethodUserLevelHtml(methodId);
		     });
		})
	</script>
	<?php endif;?>
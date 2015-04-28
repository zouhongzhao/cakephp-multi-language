<div class="row">
	<div class="col-lg-12">
    	<h1 class="page-header">
    		<?php echo __("Add New Store User") ?>
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
				 	<?php echo $this->Form->create('StoreUser', array(
                        'role' => 'form'
                    )); ?>
					<div class="form-group">
							 <label><?php echo __("Store")?></label> 
							 <?php
								 $options = $store_list;
								 echo	$this->Form->select('store_id',$options,array(
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
								$options = $this->Ppg->getStoreUserLevels();
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
	<?php if($this->Session->read('Auth.User.type') == 'store_admin'):?>
	<script type="text/javascript">
		$(document).ready(function(){
			var storeId = $("#StoreUserStoreId").val();
			pgwStore.setStoreUserLevelHtml(storeId);
			$("#StoreUserStoreId").select2() .on("change", function(e) {
				var storeId = e.val;
				pgwStore.setStoreUserLevelHtml(storeId);
		     });
		})
	</script>
	<?php endif;?>
<div class="row">
	<div class="col-lg-12">
    	<h1 class="page-header">
    		<?php echo __("Edit Method User") ?>
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
						<?php if(isset($method_user)):?>
							 <?php
										echo	$this->Form->hidden('user_id',array(
											'empty' => false, 
											'class' => 'form-control',
											'div'=>false
										));
							?>
						<?php else:?>
							 <label><?php echo __("User")?></label> 
							 <?php
								 //$options = $user_list;
								 if(isset($existUser)){
									 	$existIds = array_keys($existUser) ;
									 	foreach ($user_list as $id=>$name){
											if(in_array($id, $existIds)){
												unset($user_list[$id]);
// 												$options[$id] = array(
// 																					'name' => $name,
// 																					'value' => $id,
// 																					'disabled' => TRUE
// 																				);
											}else{
// 												$options[$id] = $name;
											}
										}
									 }
									echo	$this->Form->select('user_id',$user_list,array(
										'empty' => false, 
										'class' => 'form-control',
										'div'=>false,
										'required'=>'required'
									));
						   ?>
						<?php endif;?>
					
					</div>
					<div class="form-group">
						<label><?php echo __("Level")?></label> 
						<?php
								if(isset($currentUserLevel)){
									$options = $this->Ppg->showStoreUserLevel($currentUserLevel);
								}else{
									$options = $this->Ppg->getStoreUserLevels();
								}
								
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
		})
	</script>
	<?php endif;?>
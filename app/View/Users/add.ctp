<div class="row">
	<div class="col-lg-12">
    	<h1 class="page-header">
    	<?php echo __("Add new admin user") ?>
    	</h1>
    </div>
</div>
<div class="row">
				 	<?php echo $this->Form->create('User', array(
                        'role' => 'form'
                    )); ?>
	<div class="col-lg-12">
		<div class="panel panel-green">
			<div class="panel-heading">
            	<?php echo __("Basic Information")?>
            </div>
			<div class="panel-body">
					<div class="form-group">
					 <?php
                        echo $this->Form->input('username', array(
                            'label' => __("Username").'('. __("Email").')',
                            'class' => 'form-control',
							'div'=>false,
							'required'=>'required',
							'placeholder'=> __("Username")
                        ));?>
					</div>
					<div class="form-group">
					 <?php
                        echo $this->Form->input('password', array(
                            'label' => __("Password"),
                            'class' => 'form-control',
							'div'=>false,
							'required'=>'required',
							'placeholder'=> __("Password")
                        ));?>
					</div>
					<div class="form-group">
					<label><?php echo __("Password Confirm")?></label> 
					 <?php
                        echo $this->Form->password('password_confirm', array(
                            'class' => 'form-control',
							'div'=>false,
							'required'=>'required',
							'placeholder'=> __("Password Confirm")
                        ));?>
					</div>
					<div class="form-group">
					<label><?php echo __("Type")?></label> 
						 <?php
							$options = $this->Ppg->getUserTypes();
							echo	$this->Form->select('type',$options,array(
									'empty' => false,
									'class' => 'form-control',
									'div'=>false,
									'required'=>'required',
	// 								'value'=>isset($settingData['contact']['country'])?$settingData['contact']['country']:''
							));
						?>
					</div>
					<div class="form-group">
					<label><?php echo __("Level")?></label> 
						 <?php
							$options = $this->Ppg->getLevels();
							echo	$this->Form->select('level',$options,array(
									'empty' => false,
									'class' => 'form-control',
									'div'=>false,
									'required'=>'required',
	// 								'value'=>isset($settingData['contact']['country'])?$settingData['contact']['country']:''
							));
						?>
					</div>
					<div class="form-group">
					<label><?php echo __("Status")?></label> 
						 <?php
							$options = $this->Ppg->getStatus();
							echo	$this->Form->select('status',$options,array(
									'empty' => false,
									'class' => 'form-control',
									'div'=>false,
									'required'=>'required',
	// 								'value'=>isset($settingData['contact']['country'])?$settingData['contact']['country']:''
							));
						?>
					</div>
					
			</div>
		</div>
	</div>
	<?php if($this->Session->read('Auth.User.type') != 'payment_admin'):?>
	<div class="col-lg-6">
		<div class="panel panel-green">
			<div class="panel-heading">
            	<?php echo __("Add store privilege")?>
            </div>
			<div class="panel-body">
					<?php foreach ((array)$storeLevels as $id=>$level):?>
						<div class="form-group">
							 <label for="inputEmail3" class="col-sm-10 control-label form-control" style="width:auto"><?php echo $storeList[$id]?></label>
							 <div class="col-sm-3">
							 <?php 
							$levels = $this->Ppg->showStoreUserLevel($level);
							 ?>
							 <select id="StoreUserStore"  class="form-control" name="data[StoreUser][store][<?php echo $id?>]">
							 	<option value="" selected><?php echo __("None")?></option>
							 	<?php foreach ((array)$levels as $lid=>$label):?>
							 		<option value="<?php echo $lid?>"><?php echo $label?></option>
							 	<?php endforeach;?>
								</select>
							</div>
						</div>
					<?php endforeach;?>
			</div>
		</div>
	</div>
	<?php endif;?>
	<?php if($this->Session->read('Auth.User.type') != 'store_admin'):?>
	<div class="col-lg-6">
		<div class="panel panel-green">
			<div class="panel-heading">
            	<?php echo __("Add payment method privilege")?>
            </div>
			<div class="panel-body">
				<?php foreach ((array)$methodLevels as $id=>$level):?>
						<div class="form-group">
							 <label for="inputEmail3" class="col-sm-10 control-label form-control" style="width:auto"><?php echo $methodList[$id]?></label>
							 <div class="col-sm-3">
							 <?php 
							$levels = $this->Ppg->showMethodUserLevel($level);
							 ?>
							 <select id="MethodUserMethod"  class="form-control" name="data[MethodUser][method][<?php echo $id?>]">
							 	<option value="" selected><?php echo __("None")?></option>
							 	<?php foreach ((array)$levels as $lid=>$label):?>
							 		<option value="<?php echo $lid?>"><?php echo $label?></option>
							 	<?php endforeach;?>
								</select>
							</div>
						</div>
					<?php endforeach;?>
			</div>
		</div>
	</div>
	<?php endif;?>
	<div class="col-lg-12">
			<button type="submit" class="pull-right btn btn-outline btn-primary btn-lg store_method_save"><?php echo __("Save")?></button>
	</div>
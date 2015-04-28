<?php 
$settingData = array();
if(!empty($settings)){
	foreach ($settings as $setting){
		$settingData[$setting['group']][$setting['name']] = $setting['value'];
	}
}
$dobArray = array();
if(isset($settingData['basic']['dob'])){
	$dobArray = unserialize($settingData['basic']['dob']);
}
?>
<div class="row">
	<?php echo $this->element('errors', array('errors' => $this->validationErrors['User'])); ?>
	<div class="col-lg-6">
		<div class="panel panel-green">
			<div class="panel-heading">
            	<?php echo __("Basic Information")?>
            </div>
			<div class="panel-body">
				 	<?php echo $this->Form->create('User', array(
                        'role' => 'form'
                    )); ?>
					<div class="form-group">
					 <?php
                        echo $this->Form->input('Profile.basic.firstname', array(
                            'label' => __('Firstname'),
                            'class' => 'form-control',
							'div'=>false,
							'required'=>'required',
							'placeholder'=> __("Firstname"),
							'value'=>isset($settingData['basic']['firstname'])?$settingData['basic']['firstname']:''
                        ));?>
					
					</div>
					<div class="form-group">
					 <?php
                        echo $this->Form->input('Profile.basic.lastname', array(
                            'label' => __('Lastname'),
                            'class' => 'form-control',
							'div'=>false,
							'required'=>'required',
							'placeholder'=> __("Lastname"),
							'value'=>isset($settingData['basic']['lastname'])?$settingData['basic']['lastname']:''
                        ));?>
					</div>
					<div class="form-group">
					<label><?php echo __("Gender")?></label>
					<?php 
					$options = array('1' => 'Male', '2' => 'Female');
					$attributes = array('legend' => false,'value'=>isset($settingData['basic']['gender'])?$settingData['basic']['gender']:'');
					echo $this->Form->radio('Profile.basic.gender', $options, $attributes);
					?>
					</div>
					<div class="form-group">
						<label><?php echo __("Date of Birth")?></label> 
						<?php 
						echo $this->Form->year('Profile.basic.dob', date('Y') - 100, date('Y') - 13, array(
																																											'empty' => "YEAR",
																																											'required'=>'required',
																																											'value'=>isset($dobArray['year'])?$dobArray['year']:''
																																										));
						echo $this->Form->month('Profile.basic.dob', array(
																														'empty' => "MONTH",
																														'required'=>'required',
																														'value'=>isset($dobArray['month'])?$dobArray['month']:''
																													));
						echo $this->Form->day('Profile.basic.dob', array(
																													'empty' => 'DAY',
																													'required'=>'required',
																													'value'=>isset($dobArray['day'])?$dobArray['day']:''
																												));
						?>
					</div>
					<button type="submit" class="btn btn-default"><?php echo __("Save")?></button>
				 <?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="panel panel-green">
			<div class="panel-heading">
            	<?php echo __("Contact Information")?>
            </div>
			<div class="panel-body">
				<?php echo $this->Form->create('User', array(
                        'role' => 'form'
                    )); ?>
					<div class="form-group">
					 <?php
                        echo $this->Form->textarea('Profile.contact.address', array(
                            'label' => __('Street Address'),
                            'class' => 'form-control',
							'div'=>false,
							'required'=>'required',
							'placeholder'=> __("Street Address"),
							'value'=>isset($settingData['contact']['address'])?$settingData['contact']['address']:''
                        ));?>
					</div>
					<div class="form-group">
					 <?php
                        echo $this->Form->input('Profile.contact.postcode', array(
                            'label' => __('Postcode'),
                            'class' => 'form-control',
							'div'=>false,
							'required'=>'required',
							'placeholder'=> __("Postcode"),
							'value'=>isset($settingData['contact']['postcode'])?$settingData['contact']['postcode']:''
                        ));?>
					</div>
					<div class="form-group">
					 <?php
                        echo $this->Form->input('Profile.contact.city', array(
                            'label' => __('City'),
                            'class' => 'form-control',
							'div'=>false,
							'required'=>'required',
							'placeholder'=> __("City"),
							'value'=>isset($settingData['contact']['city'])?$settingData['contact']['city']:''
                        ));?>
					</div>
					<div class="form-group">
						<label><?php echo __("Country")?></label> 
						<?php
								echo	$this->Form->select('Profile.contact.country',$this->Ppg->getList(),array(
									'empty' => false, 
									'class' => 'form-control',
									'div'=>false,
									'required'=>'required',
									'value'=>isset($settingData['contact']['country'])?$settingData['contact']['country']:''
								));
					?>
					</div>
					<button type="submit" class="btn btn-default"><?php echo __("Save")?></button>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="panel panel-green">
			<div class="panel-heading">
            	<?php echo __("Change Login E-mail")?>
            </div>
			<div class="panel-body">
			
				<?php echo $this->Form->create('User', array(
                        'role' => 'form'
                    )); ?>
					<div class="form-group">
					 <?php
                        echo $this->Form->input('username', array(
                            'label' => __('New E-mail Address'),
                            'class' => 'form-control',
							'div'=>false,
							'required'=>'required',
							'value'=>'',
							'placeholder'=> __("New E-mail Address")
                        ));?>
					</div>
					<button type="submit" class="btn btn-default"><?php echo __("Save")?></button>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="panel panel-green">
			<div class="panel-heading">
            	<?php echo __("Change Password")?>
            </div>
			<div class="panel-body">
				<?php echo $this->Form->create('User', array(
                        'role' => 'form'
                    )); ?>
					<div class="form-group">
					<label><?php echo __('Current Password')?></label>
					<?php
                        echo $this->Form->password('old_password', array(
                            'label' => __('Current Password'),
                            'class' => 'form-control',
							'div'=>false,
							'required'=>'required'
                        ));?>
					</div>
					<div class="form-group">
					<label><?php echo __('New Password')?></label>
					<?php
                        echo $this->Form->password('new_password', array(
                            'label' => __('New Password'),
                            'class' => 'form-control',
							'div'=>false,
							'required'=>'required'
                        ));?>
					</div>
					<div class="form-group">
					<label><?php echo __('New Password Confirm')?></label>
					<?php
                        echo $this->Form->password('new_password_confirm', array(
                            'label' => __('New Password Confirm'),
                            'class' => 'form-control',
							'div'=>false,
							'required'=>'required'
                        ));?>
					</div>
					<button type="submit" class="btn btn-default"><?php echo __("Save")?></button>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
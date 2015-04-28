<div class="row">
	<div class="col-lg-12">
    	<h1 class="page-header"><?php echo __("Edit admin user") ?></h1>
    </div>
</div>
<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-green">
			<div class="panel-heading">
            	<?php echo __("Edit Account ")?>
            </div>
			<div class="panel-body">
				 	<?php echo $this->Form->create('User', array(
                        'role' => 'form'
                    )); ?>
					<div class="form-group">
					<label><?php echo __("Level")?></label> 
					 <?php
						$options = $this->Ppg->showLevel($this->Session->read('Auth.User.level'));
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
							$options = $this->Ppg->showStatus();
							echo	$this->Form->select('status',$options,array(
									'empty' => false,
									'class' => 'form-control',
									'div'=>false,
									'required'=>'required',
	// 								'value'=>isset($settingData['contact']['country'])?$settingData['contact']['country']:''
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
            	<?php echo __("Reset Password")?>
            </div>
			<div class="panel-body">
			
				<?php echo $this->Form->create('User', array(
                        'role' => 'form'
                    )); ?>
					<div class="form-group">
					<input type="hidden"  value="1"  name="data[User][reset_password]">
					 <button type="submit" class="btn btn-outline btn-primary btn-lg"><?php echo __("Reset Password")?></button>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
	<?php if($this->Session->read('Auth.User.type') != 'payment_admin'):?>
	<div class="col-lg-12">
		<div class="panel panel-green">
			<div class="panel-heading clearfix">
			      <h4 class="panel-title pull-left" style="padding-top: 7.5px;"><?php echo __("Store Information")?></h4>
			      <div class="btn-group pull-right">
			      	<?php
								echo $this->Html->link(
									 __('Add to New Store'),	
									array(
										'controller' => 'users',
										'action' => 'add_store',
										$this->request->data['User']['id'],
										'full_base' => true
									),
									array(
										'escape' => false,
										'class' => 'btn btn-default btn-sm'	
									)
								);
							?>
			      </div>
			    </div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover"
						id="dataTables-users">
						<thead>
							<tr>
								<th><?php echo __("Store ID")?></th>
								<th><?php echo __("Name")?></th>
								<th><?php echo __("Level")?></th>
								<th><?php echo __("Actions")?></th>
							</tr>
						</thead>
						<tbody>
                            <?php foreach ($store_users as $user):?>
                            		<tr>
										<td><?php echo $user["store_id"] ?></td>
										<td><?php echo $store_ids[$user["store_id"]] ?></td>
										<td><?php echo $user["level"] ?></td>
										<td>
											<?php 
												echo $this->Html->link ( __ ( "Edit" ), array (
// 																															'controller' => 'storeUsers',
																															'action' => 'edit_store',
																															$user["store_id"],
																															$user["user_id"]
																															) );
											?> | <?php
												echo $this->Html->link ( __ ( "Delete" ), array (
// 																																	'controller' => 'storeUsers',
																																	'action' => 'delete_store',
																																	$user["store_id"],
																																	$user["user_id"]
																																	), array (), __ ( "Are you sure to delete this store user ?" ) );
											?>
							    			
							    		</td>
									</tr>

					 		<?php endforeach; ?>
                    	</tbody>
					</table>
				</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<?php endif;?>
	
	<?php if($this->Session->read('Auth.User.type') != 'store_admin'):?>
	<div class="col-lg-12">
		<div class="panel panel-green">
			<div class="panel-heading clearfix">
			      <h4 class="panel-title pull-left" style="padding-top: 7.5px;"><?php echo __("Method Information")?></h4>
			      <div class="btn-group pull-right">
			      	<?php
								echo $this->Html->link(
									 __('Add to New Method'),	
									array(
										'controller' => 'users',
										'action' => 'add_method',
										$this->request->data['User']['id'],
										'full_base' => true
									),
									array(
										'escape' => false,
										'class' => 'btn btn-default btn-sm'	
									)
								);
							?>
			      </div>
			    </div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover"
						id="dataTables-users">
						<thead>
							<tr>
								<th><?php echo __("Method ID")?></th>
								<th><?php echo __("Name")?></th>
								<th><?php echo __("Level")?></th>
								<th><?php echo __("Actions")?></th>
							</tr>
						</thead>
						<tbody>
                            <?php foreach ($method_users as $user):?>
                            		<tr>
										<td><?php echo $user["method_id"] ?></td>
										<td><?php echo $method_ids[$user["method_id"]] ?></td>
										<td><?php echo $user["level"] ?></td>
										<td>
											<?php 
												echo $this->Html->link ( __ ( "Edit" ), array (
// 																															'controller' => 'storeUsers',
																															'action' => 'edit_method',
																															$user["method_id"],
																															$user["user_id"]
																															) );
											?> | <?php
												echo $this->Html->link ( __ ( "Delete" ), array (
// 																																	'controller' => 'storeUsers',
																																	'action' => 'delete_method',
																																	$user["method_id"],
																																	$user["user_id"]
																																	), array (), __ ( "Are you sure to delete this method user ?" ) );
											?>
							    			
							    		</td>
									</tr>

					 		<?php endforeach; ?>
                    	</tbody>
					</table>
				</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
	<?php endif;?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-green">
			<div class="panel-heading clearfix">
			      <h4 class="panel-title pull-left" style="padding-top: 7.5px;"><?php echo __("Users List")?></h4>
			       <?php if($this->Ppg->checkUserRight() == 5):?>
			       	<div class="btn-group pull-right">
				      	<?php
									echo $this->Html->link(
										 __('Create New User'),	
										array(
											'controller' => 'users',
											'action' => 'add',
											'full_base' => true
										),
										array(
											'escape' => false,
											'class' => 'btn btn-default btn-sm'	
										)
									);
								?>
				      </div>
			       <?php endif;?>
			    </div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover"
						id="dataTables-users">
						<thead>
							<tr>
								<th><?php echo __("ID")?></th>
								<th><?php echo __("Payment Methods")?></th>
								<th><?php echo __("Stores")?></th>
								<th><?php echo __("Username")?></th>
								<th><?php echo __("Level")?></th>
								<th><?php echo __("Status")?></th>
								<th><?php echo __("Actions")?></th>
							</tr>
						</thead>
						<tbody>
                            <?php foreach ($data as $user): ?>
                            	<?php 
                            		$storeInfo = array();
                            		$methodInfo = array();
                            		foreach ((array)$user['StoreUser'] as $store){
										array_push($storeInfo, $store_ids[$store['store_id']]);
									}
									foreach ((array)$user['MethodUser'] as $method){
										array_push($methodInfo, $method_ids[$method['method_id']]);
									}
                            	?>
                            	<tr>
										<td><?php echo $user["User"]["id"] ?></td>
										<td><?php echo implode(' | ', $methodInfo)?></td>
										<td><?php echo implode(' | ', $storeInfo)?></td>
										<td><?php echo $user["User"]["username"] ?></td>
										<td><?php echo $this->Ppg->getLevels($user["User"]["level"]) ?></td>
										<td><?php echo $this->Ppg->getStatus($user["User"]["status"]) ?></td>
										<td>
										<?php if($this->Session->read('Auth.User.level') >= $user["User"]["level"]):?>
											<?php 
												echo $this->Html->link ( __ ( "Edit" ), array (
																															'action' => 'edit',
																															$user ["User"] ["id"] 
																															) );
											?> | <?php
												echo $this->Html->link ( __ ( "Delete" ), array (
																																	'action' => 'delete',
																																	$user ["User"] ["id"] 
																																	), array (), __ ( "Are you sure to delete this admin user ?" ) );
											?>
										<?php endif;?>
							    			
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
</div>
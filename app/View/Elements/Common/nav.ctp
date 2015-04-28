<?php if($this->Session->read('Auth.User')): ?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/"><?php echo __("Pointix Payment Gateway Admin Panel") ?></a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>
                <?php 
					echo $this->Html->link(
						'<i class="fa fa-user fa-fw"></i>' . __('User Profile'),	
						array(
							'controller' => 'users',
							'action' => 'profile',
							'full_base' => true
						),
						array('escape' => false)
					);
				?>
                </li>
                <li><a href="#"><i class="fa fa-gear fa-fw"></i><?php echo __("Settings") ?></a>
                </li>
                <li class="divider"></li>
                <li>
                <?php 
					echo $this->Html->link(
						'<i class="fa fa-sign-out fa-fw"></i>' . __('Logout'),	
						array(
							'controller' => 'users',
							'action' => 'logout',
							'full_base' => true
						),
						array('escape' => false)
					);
				?>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
            	<li>
            	<div class="row">
					  <div class="col-lg-6 pull-left">
					  <h5>
					<?php echo __("Interface Locale")?>:
					</h5>
					  </div><!-- /.col-lg-6 -->
					  <div class="col-lg-6 pull-left">
					  <select name="locale"  class="form-control" id="interface_locale" class="" title="Interface Language" >
					  	<?php foreach ($this->Session->read('Languages') as $row):?>
					  			<option value="<?php echo $row['code_locale']?>"  <?php echo $this->Session->read('Config.language') == $row['code_locale']?'selected':''?>><?php echo $row['name']?></option>
					  	<?php endforeach;?>
						</select>
					  </div><!-- /.col-lg-6 -->
					</div><!-- /.row -->
            	</li>
                
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" placeholder="<?php echo __("Search...") ?>">
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                    </div>
                    <!-- /input-group -->
                </li>

                <li>
                 <?php 
					echo $this->Html->link(
						'<i class="fa fa-dashboard fa-fw"></i>' . __('Dashboard'),	
						array(
							'controller' => 'dashboard',
							'action' => 'home',
							'full_base' => true
						),
						array('escape' => false)
					);
				?>
                </li>
                <?php if($this->Ppg->checkUserRight()):?>
	                <li>
	                 <?php
						echo $this->Html->link(
							'<i class="fa fa-dashboard fa-fw"></i>' . __('Users Management'),	
							array(
								'controller' => 'users',
								'action' => 'index',
								'full_base' => true
							),
							array('escape' => false)
						);
					?>
	                </li>
                <?php endif;?>
				<?php if($this->Session->read('Auth.User.type') != 'payment_admin'):?>
	                <li>
	                 <?php
						echo $this->Html->link(
							'<i class="fa fa-dashboard fa-fw"></i>' . __('Store Management'),	
							array(
								'controller' => 'stores',
								'action' => 'index',
								'full_base' => true
							),
							array('escape' => false)
						);
					?>
	                </li>
                <?php endif;?>
                
                 <?php if($this->Session->read('Auth.User.type') == 'super_admin'):?>
	                <li>
	                 <?php
						echo $this->Html->link(
							'<i class="fa fa-dashboard fa-fw"></i>' . __('Currency Management'),	
							array(
								'controller' => 'currencies',
								'action' => 'index',
								'full_base' => true
							),
							array('escape' => false)
						);
					?>
	                </li>
                <?php endif;?>
               
                   <?php if($this->Session->read('Auth.User.type') != 'store_admin'):?>
	                <li>
	                 <?php
						echo $this->Html->link(
							'<i class="fa fa-dashboard fa-fw"></i>' . __('Method Management'),	
							array(
								'controller' => 'methods',
								'action' => 'index',
								'full_base' => true
							),
							array('escape' => false)
						);
					?>
	                </li>
                <?php endif;?>
                 <?php if($this->Session->read('Auth.User.type') != 'payment_admin'):?>
                <li>
	                 <?php
						echo $this->Html->link(
							'<i class="fa fa-dashboard fa-fw"></i>' . __('Orders Management'),	
							array(
								'controller' => 'orders',
								'action' => 'index',
								'full_base' => true
							),
							array('escape' => false)
						);
					?>
	                </li>
	               <?php endif;?>
	     		 <?php if($this->Session->read('Auth.User.level') == 5):?>
	                <li>
	                 <?php
						echo $this->Html->link(
							'<i class="fa fa-dashboard fa-fw"></i>' . __('Errors Management'),	
							array(
								'controller' => 'errors',
								'action' => 'index',
								'full_base' => true
							),
							array('escape' => false)
						);
					?>
	                </li>
                <?php endif;?>
                <!-- 
                                 <?php if($this->Session->read('Auth.User.level') == 5):?>
	                <li>
	                 <?php
						echo $this->Html->link(
							'<i class="fa fa-dashboard fa-fw"></i>' . __('Phases Management'),	
							array(
								'controller' => 'phases',
								'action' => 'index',
								'full_base' => true
							),
							array('escape' => false)
						);
					?>
	                </li>
                <?php endif;?>
                 -->

                <!--<li>
                    <a href="#"><i class="fa fa-sitemap fa-fw"></i><?php echo __("Users Management") ?><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="#">Second Level Item</a>
                        </li>
                        <li>
                            <a href="#">Second Level Item</a>
                        </li>
                        <li>
                            <a href="#">Third Level <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a href="#">Third Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level Item</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>-->
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
<?php endif; ?>

<script type="text/javascript">
$(document).ready(function(){
	$("#side-menu").on('change','#interface_locale',function(){
		var value = $(this).val(),
				url = '<?php echo $this->Html->url(array("controller"=>"dashboard","action"=> "changeLanguage")); ?>';
// 		console.log(value);
		url = url + '/'+value;
// 		console.log(url);
		window.location.href = url;
		return false;
	})
})
</script>



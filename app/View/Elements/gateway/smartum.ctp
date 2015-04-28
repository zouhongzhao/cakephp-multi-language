<div class="dialog smartum-method-form">
		<div class="content">
			<div class="modal-header">
				<h4 class="modal-title smartum-title" id="pointPaymentModalLabel"><?php echo __("Smartum")?></h4>
			</div>
            
			<div class="modal-body">
			   <div class="login-form">
                    <div class="panel-heading">
                    	<h4>Kirjaudu sisään</h4>
                    </div>
                    <div class="panel-body">
                        <form role="form" class="form-horizontal">
                            
                                <div class="form-group">                                   
                                    <label for="ff_username" class="col-sm-3 control-label">Käyttäjätunnus:</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control username" id="ff_username" placeholder="Username  (123456)" name="username" autofocus="">
                                    </div>
                                </div>
                                <div class="form-group">                                   
                                    <label for="ff_password" class="col-sm-3 control-label">Käyttäjätunnus:</label>
                                    <div class="col-sm-9">
                                      <input type="password" class="form-control password" id="ff_password" placeholder="Password (demodemo)" name="password" value="">
                                    </div>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-primary btn-block login-form-submit"><?php echo __("Kirjaudu")?></button>
                        </form>
            		</div>
			   </div>
               
			   <div style="display: none" class="show-point-price-box">
               		<div class="panel-heading">
                    	<h4>Valitse käytettävien pisteiden määrä</h4>
                        <p>Smartum -tililläsi on yhteensä <strong class="hasPointValue"></strong> pistettä. </p>
                        <p>Ostoksesta on maksamatta <strong class="cashAmountValue"></strong>.</p>
                        <p>Valitse kuinka monta pistettä haluat käyttää käyttämällä pisteliukuria.</p>
                        
                    </div>
                    
                    <div class="price-box panel-body" style="padding-top: 0px;">
                        <form class="form-horizontal form-pricing" role="form">
                        <div class="row" style="display: none;">         
                        	<div class="col-md-10" style="text-align: left;">
                            Käytetään: <input value="" id="ppam" class="point-price-amount" style="width: 150px;"/> pistettä
                            </div> 
                        </div>
        
			          <div class="price-slider">
			            <div class="col-sm-12">
                        <div id="point-slider"></div>
                         <?php
						  /*
			              <div id="slider2" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
			              		<div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" style="width: 0%;"></div>
			              		<a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 0%;">
			              			<label><span class="glyphicon glyphicon-chevron-left"></span>0<?php echo $symbol?><span class="glyphicon glyphicon-chevron-right"></span></label>
			              		</a>
			              	</div>
							*/
						?>
			            </div>
			          </div>
                      
                        <div class="row" style="padding-top: 32px; padding-left: 10px;">         
                        	<div class="col-md-10" style="text-align: left;">
                            Käytetään: <p class="price lead" id="total-label"></p>
                            </div> 
                        </div>

			          <div class="form-group">
			            <div class="col-sm-12 proceed">
			              <button class="submit btn btn-primary btn-lg btn-block">Jatka &raquo;</button>
			            </div>
			          </div>
			        </form>
			      </div>
			   </div>
			  <div style="display: none" class="show-checkout-price-box">
			   		
			   </div>
			   <input type="hidden" id="choose-total-due" class="form-control" value="0">
			   <input type="hidden" class="pointx-cash-amount" value="" />
				<input type="hidden" class="pointx-points-amount" value="" />
				<input type="hidden" class="pointx-points-order-id" value="" />
				<input type="hidden" class="pointx-points-method_id" value="" />
				<input type="hidden" class="pointx-points-exchange_rate" value="" />
			</div>
			<div class="modal-footer">
				<?php if($storeMethod['show_cancel']):?>
					<button type="button" class="btn btn-default cancel-payment-checkout" data-dismiss="modal"><?php echo __("Cancel")?></button>
				<?php endif;?>
				<button type="button" class="btn btn-primary point-submit-checkout" style="display: none"><?php echo __("Vahvista maksu")?></button>
			</div>
		</div>
</div>
<script type="text/javascript">
// $(document).ready(function($){
	/*** smartum api***/
// 	if(jQuery.inArray( 'smartum', currentMethods) !== -1){
		var smartum = {
//							sessionId:null,
						userId:null,
						roleId:null,
						emoney:null,
						chooseType:null,
						orderMethodData:null,
						checkLogin:function(username,passwd){
							$(".phase_payment_infomation").showLoading();
							//username = username || 'company-1-company-beneficiary@mailinator.com';
							//passwd = passwd || 'sagapo';
							$.ajax( {
					            dataType: "html",
					            type: "POST",
//						            async:false, 
					            evalScripts: true,
								 url: ' <?php echo $this->Html->url(array("controller"=>"smartum","action"=> "ajaxCheckLogin")); ?>',
								  data: {
									  		username:username,
									  		password:passwd,
									  		buyerName:buyerName,
									  		api:'http://core.dev.smartum.fi/api/login',
											url:'http://core.dev.smartum.fi/api/users/current'
									  		},
								  success : function(data, textStatus, xmLHttpRequest){
									  data = $.trim( data );
									  var data = $.parseJSON(data);
									  if(data.status == 1){
										  console.log(data);
								  			console.log(data.data);
								  			var info = data.data,
								  					num = 0,
								  					customerId = 0,
								  					html = '<select class="smartum_select_role">';
								  		   if(info.customers !== undefined){
									  			 smartum.userId = info.id;
												$.each(info.customers,function(i,item){
														$.each(item.roles,function(i2,item2){
															if(item2.role == 'ROLE_COMPANY_BENEFICIARY' && item2.isActive == 1){
																num ++;
																customerId = item.id;
																html += '<option value="'+item.id+'">'+item.name+'</option>';
																return false;
															}
														})
												});
									  	   }
									  	   html += '</select>';
									  	   
									  		 $(".login-form").hide();
											 if(num == 1){
												  smartum.getScoreInfo(customerId);
												  smartum.roleId = customerId;
												 //smartum.getUserRole(customerId);
										  	 }else{
										  		 $(".phase_payment_infomation .smartum .modal-body").append(html);
											  	 $(".phase_payment_infomation .smartum").on("change", ".smartum_select_role", function(){
														var value = $(this).val();
														 smartum.getUserRole(value);
												  })
												  $(".phase_payment_infomation").hideLoading();
											 }
//										  	   console.log(num);
											 loginDone = 1;
											 var data = {
									             		'order_id':$(".pointx-points-order-id").val(),
									             		'method_id':$(".pointx-points-method_id").val(),
									             		'total':0,
									             		'exchange_rate': $(".pointx-points-exchange_rate").val(),
									             		'status':0
									             	};
											pgw.orderMethodsAjax(data);
											 $(".phase_payment_infomation").hideLoading();
									  }else{
										  $(".phase_payment_infomation").hideLoading();
										  $(".login-form .username").focus();
										  console.log(data.data);
										  return false;
									  }
									 
								  },
								  error : function(xhr, ajaxOptions, thrownError) {
									  console.log(xhr.getAllResponseHeaders);
  									console.log(thrownError);
  									$(".phase_payment_infomation").hideLoading();
//									    credentials = null;
								  }
							});
							return false;
						},
//							getUserInfo:function(){

//							},
						getUserRole:function(customerId,role){
							$(".phase_payment_infomation").showLoading();
							role = role || 'ROLE_COMPANY_BENEFICIARY';
							$.ajax( {
					            dataType: "html",
					            type: "POST",
//						            async:false, 
					            evalScripts: true,
								 url: ' <?php echo $this->Html->url(array("controller"=>"smartum","action"=> "ajaxChangeRole")); ?>',
								  data: {
									  		customerId:customerId,
									  		role:role,
									  		url:'http://core.dev.smartum.fi/api/change_role',
									  		},
								  success : function(data, textStatus, xmLHttpRequest){
									  smartum.roleId = customerId;
									  smartum.getScoreInfo(customerId);
//										  data = $.trim( data );
//										  var data = $.parseJSON(data);
//										  console.log(data);
								  },
								  error : function(xhr, ajaxOptions, thrownError) {
									  console.log(xhr.getAllResponseHeaders);
  									console.log(thrownError);0
								    credentials = null;
								  }
							});
						},
						getScoreInfo:function(customerId){
							console.log(smartum.userId);
							$(".phase_payment_infomation").showLoading();
							$.ajax( {
					            dataType: "html",
					            type: "POST",
//						            async:false, 
					            evalScripts: true,
								 url: ' <?php echo $this->Html->url(array("controller"=>"smartum","action"=> "ajaxGetScoreInfo")); ?>',
								  data: {
									  		method:'smartum',
									  		allowItemMethods:allowItemMethods,
									  		extraInfo:extraInfo,
									  		url:'http://core.dev.smartum.fi/api/companies/'+customerId+'/users/'+smartum.userId+'/accounts/company_beneficiary',
									  		},
								  success : function(data, textStatus, xmLHttpRequest){
//										  return false;
									  data = $.trim( data );
									  var data = $.parseJSON(data),
							 		   html="<div class='select_emoney_div'><h1>Please select the EMONEY type you want to use to pay this order:</h1>";
									  console.log(data);
									  if(data.status == 1){
											var info = data.data;
											smartum.emoney = info;
											console.log(info);
											if(info.type == 2){
												$.each(info.accounts,function(i,item){
													html += '<p class="'+item.code+'">'+item.label+': You can use maximum '+item.value+symbol+' <button type="button" data="'+item.code+'" class="btn btn-default choose_emoney">Choose</button></p>';
												})
												html += '</div>';
												$(".phase_payment_infomation .smartum .modal-body").append(html);
												$(".phase_payment_infomation .smartum .smartum_select_role").remove();
											  	$(".phase_payment_infomation .smartum").on("click", ".choose_emoney", function(){
														var type = $(this).attr('data');
														 smartum.chooseMoney(type);
														 return false;
												 })
											}else if(info.type == 1){
												$.each(info.accounts,function(i,item){
													smartum.chooseMoney(item.code);
													return false;
//														html += '<p>'+item.label+': You can use maximum '+symbol+item.value+'</p>';
												})
//													html += '</div>';
											}
									   }
									  $(".phase_payment_infomation").hideLoading();
									  return false;
//										  $(".show-point-price-box").show();
								  },
								  error : function(xhr, ajaxOptions, thrownError) {
									  $(".phase_payment_infomation").hideLoading();
									  console.log(xhr.getAllResponseHeaders);
  									console.log(thrownError);
								    credentials = null;
								  }
							});
						},
						chooseMoney:function(type){
							smartum.chooseType=type;
							$(".phase_payment_infomation .smartum .select_emoney_div").hide();
							var account = smartum.emoney.accounts[type],
									priceBoxObj =$(".show-point-price-box");
							console.log(type);
							console.log(smartum.emoney);
							console.log(account);
//								return false;
							var totalPoints = account['value'];
							priceBoxObj.find(".hasPointValue").html(totalPoints);
							$(".pointx-points-amount").val(totalPoints);
							var pointsAmount = $(".pointx-points-amount").val(),
									rateRange = $(".pointx-points-exchange_rate").val(),
//										cashAmount = parseInt(pointsAmount*rateRange),
									cashAmount = pointsAmount;
//								console.log(pointsAmount);
//								console.log(rateRange);
//								console.log(cashAmount);
//								return false;
							priceBoxObj.find(".cashAmountValue").html(cashAmount+ ' ' +symbol);
							$(".pointx-cash-amount").val(cashAmount);
					          $("#point-slider").slider({
					              range: "min",
					              animate: true,
					              value: cashAmount,
					              min: 0.1,
					              max: cashAmount,
					              step: 0.1,
					              change: function (event, ui){ smartum.updateSlider(2,ui.value);; }
					          });
						  		var slideText = cashAmount + '<?php echo $symbol?> / '+ totalPoints + 'p';
						  		$("#choose-total-due").val(cashAmount+'/'+totalPoints);
						  		$("#total-label").html(slideText);
						  		
					          $(".point-price-amount").val('');
							$(".show-point-price-box").show();
						},
						setVenuesMoney:function(data){
							$(".phase_payment_infomation").showLoading();
							var apiExtFileds = $("#pointix_smartum .api_ext_fields").val(),
									apiExtFileds = $.parseJSON(apiExtFileds),
									amount = parseInt(data.total * 100),
									extra_info = {},
									account = smartum.emoney.accounts[smartum.chooseType];
							console.log(smartum.chooseType);
							console.log(account);
							console.log(account.type);
//								return false;
							extra_info.smartum={};
							extra_info.smartum[account.label] = amount;
							extra_info = JSON.stringify(extra_info);
//								console.log(extra_info);
							smartum.orderMethodData=data;
							$.ajax( {
					            dataType: "html",
					            type: "POST",
//						            async:false, 
					            evalScripts: true,
								 url: ' <?php echo $this->Html->url(array("controller"=>"smartum","action"=> "ajaxSetVenuesMoney")); ?>',
								  data: {
									  		extra_info:extra_info,
									  		order_methods_id:data.id,
									  		role_id:smartum.roleId,
									  		amount:amount,//1500
									  		type:account.type,//'CULTURE_EMONEY',
									  		message:'order_methods_id:'+data.id,
									  		url:'http://core.dev.smartum.fi/api/venues/'+apiExtFileds.venueId+'/emoney',
									  		},
								  success : function(data, textStatus, xmLHttpRequest){
									  data = $.trim( data );
									  var data = $.parseJSON(data);
									  if(data.status == 1){
											  apiPayDone = 1;
	 										  pgw.orderMethodsAjax(smartum.orderMethodData);
	 										  $(".phase_payment_infomation").hideLoading();
	 										  location.reload(true);
										}else{
//												alert(data.data);
										}
										return false;
								  },
								  error : function(xhr, ajaxOptions, thrownError) {
									  console.log(xhr.getAllResponseHeaders);
  									console.log(thrownError);0
								    credentials = null;
								  }
							});
						},
						updateSlider:function(slider,val) {
							var points = val;
							var slideText = val + '<?php echo $symbol?> / '+ points + 'p';
							$(".point-price-amount").val(val);
							$("#choose-total-due").val(val+'/'+points);
							$("#total-label").html(slideText);
					       $('#point-slider a').html('<label><span class="glyphicon glyphicon-chevron-left"></span> '+val+'<?php echo $symbol?> <span class="glyphicon glyphicon-chevron-right"></span></label>');
					    },
					    cancel:function(){
					    	smartum.userId = null;
					    	smartum.emoney = null;
					    	smartum.chooseType = null;
					    	smartum.orderMethodData = null;
					    	smartum.roleId = null;
					    	$(".phase_payment_infomation .smartum .select_emoney_div").remove();
					    	if( $( "#point-slider" ).slider()){
					    		$("#point-slider").slider('destroy');
						    }
						}
				};
// 	}
	
// })
</script>
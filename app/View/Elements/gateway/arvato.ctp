<?php 
if(isset($buyerSsn) && !empty($buyerSsn)){
	if(!$this->Gateway->checkSSN($buyerSsn)){
		$buyerSsn = '';
	}
}
// print_r($params);
$customerInfo = array(
		"Address" => array('required'=>true,'value'=>"Mäkikaivontie 12 B 22"),//$params['BUYER_ADDRESS']
		"CountryCode" => array('required'=>true,'value'=>"FI"),//$params['BUYER_COUNTRY']
		"CurrencyCode" =>array('required'=>true,'value'=>"EUR"),//$params['BUYER_ADDRESS']
		"CustNo" => array('required'=>true,'value'=>"00001"),//$params['']
		"CustomerCategory" =>array('required'=>true,'value'=>"Person"),//$params['']
		"DirectPhone" => array('required'=>false,'value'=>""),//$params['']
		"DistributionBy" => array('required'=>true,'value'=>"Company"),//$params['']
		"DistributionType" =>array('required'=>true,'value'=>"Paper"),//$params['']
		"Email" =>array('required'=>false,'value'=>""),//$params['BUYER_EMAIL']
		"Fax" => array('required'=>false,'value'=>""),//$params['']
		"FirstName" => array('required'=>true,'value'=>"Dagmar"),//$params['BUYER_FIRSTNAME']
		"LastName" => array('required'=>true,'value'=>"Nikula"),//$params['BUYER_LASTNAME']
		"MobilePhone" => array('required'=>false,'value'=>""),//$params['']
		"Organization_PersonalNo" => array('required'=>true,'value'=>"010868-998U"),//$params['']
		"Phone" => array('required'=>false,'value'=>""),//$params['']
		"PostalCode" => array('required'=>true,'value'=>"65100"),//$params['BUYER_POSTCODE']
		"PostalPlace" => array('required'=>true,'value'=>"VAASA"),//$params['']
		"SocialTitle" => array('required'=>true,'value'=>"Mr"),//$params['']
		"StatCodeAlphaNumeric" => array('required'=>false,'value'=>""),//$params['']
		"Title" => array('required'=>false,'value'=>""),//$params['']
)
?>
<div class="dialog arvato-method-form">
		<div class="content">
			<div class="modal-header">
				<h4 class="modal-title" id="cashFreeModalLabel"><?php echo __("Amount you want to pay")?></h4>
			</div>
			<div class="modal-body">
			<p><?php echo __("Amount you want to pay")?>: <span class="pointix_arvato_amount"><?php echo $totalDue?></span> <?php echo $symbol?></p>
			<form class="form-horizontal arvato-method-form" >
				<?php foreach ($customerInfo as $key=>$item):?>
				<div class="form-group <?php echo $item['required']?'required':''?>">
				    <label for="arvato-<?php echo $key?>" class="col-sm-3 control-label"><?php echo __($key)?></label>
				    <div class="col-sm-7">
				      <input class="form-control" id="arvato-<?php echo $key?>"  name="<?php echo __($key)?>" placeholder="<?php echo __($key)?>" value="<?php echo $item['value']?>" <?php echo $item['value']?'readonly':''?>>
				    </div>
				</div>
				<?php endforeach;?>
			  <div class="form-group">
   				 <div class="col-sm-offset-2 col-sm-10">
	      			<button type="button" class="btn btn-default edit-form"><?php echo __("Edit")?></button>
	    		</div>
	 		</div>	
			</form>
			
			</div>
			<div class="modal-footer">
				<?php if($storeMethod['show_cancel']):?>
					<button type="button" class="btn btn-default cancel-payment-checkout" data-dismiss="modal"><?php echo __("Cancel")?></button>
				<?php endif;?>
				<button type="button" class="btn btn-primary submit"><?php echo __("Yes")?></button>
			</div>
		</div>
</div>
<script type="text/javascript">
/*** arvato api***/
var arvato = {
		containerId:null,
		data:null,
		init:function(data){
			this.data = data;
			this.containerId = $(".phase_payment_infomation .method_id_"+data.method_id);
			this.containerId.show();
			this.containerId.find(".submit").text('<?php echo __("Pay Now")?>');
		
// 			$(".arvato-method-form").serializeArray().map(function(x){form[x.name] = x.value;});
			return false;
			//pgw.orderMethodsAjax(data);
			console.log(data);
			return true;
		},
		submit:function(data){
// 			var form = $(".arvato-method-form").serializeArray();
// 			console.log(form);
// 			return false;
			var ssnObj = this.containerId.find(".pointix_cash_ssn_input");
			if($.trim(ssnObj.val()) == ''){
				ssnObj.focus();
				//return false;
			}
			var order_method_id = $("#order_method_hidden_id").val();
			data = this.data;
			data['order_method_id'] = order_method_id;
			data['store_id'] = storeId;
			var form = {};
			$(".arvato-method-form").serializeArray().map(function(x){form[x.name] = x.value;});
			data['form'] = form;
// 			console.log(data);
// 			return false;
			$.ajax( {
	            dataType: "html",
	            type: "POST",
//		            async:false, 
	            evalScripts: true,
				 url: ' <?php echo $this->Html->url(array("controller"=>"arvato","action"=> "ajaxPayNow")); ?>',
				  data: data,
				  success : function(data, textStatus, xmLHttpRequest){
					  return false;
					  data = $.trim( data );
					  var data = $.parseJSON(data);
					  if(data.status == 1){
							  apiPayDone = 1;
								  pgw.orderMethodsAjax(smartum.orderMethodData);
								  $(".phase_payment_infomation").hideLoading();
								  location.reload(true);
						}else{
//								alert(data.data);
						}
						return false;
				  },
				  error : function(xhr, ajaxOptions, thrownError) {
					  console.log(xhr.getAllResponseHeaders);
						console.log(thrownError);0
				    credentials = null;
				  }
			});
			console.log(data);
		}
}
$(document).ready(function(){
	$(".arvato-method-form").on('click','.edit-form',function(){
			$('.arvato-method-form :input:visible').each(function(){
				$(this).removeAttr('readonly');
			})
			return false;
	})
})
</script>
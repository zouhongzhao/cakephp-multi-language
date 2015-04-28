<div class="dialog spankki-method-form">
		<div class="content">
			<div class="modal-header">
				<h4 class="modal-title" id="cashFreeModalLabel"><?php echo __("Amount you want to pay")?></h4>
			</div>
			<div class="modal-body">
			<p><?php echo __("Amount you want to pay")?>: <input type="text" onkeyup="clearNoNum(this)" class="pointix_cash_amount_input" name="data[Gateway][amount]"> <?php echo $symbol?></p>
			</div>
			<div class="modal-footer">
				<?php if($storeMethod['show_cancel']):?>
					<button type="button" class="btn btn-default cancel-payment-checkout" data-dismiss="modal"><?php echo __("Cancel")?></button>
				<?php endif;?>
				<button type="button" class="btn btn-primary submit"><?php echo __("Yes")?></button>
			</div>
		</div>
</div>
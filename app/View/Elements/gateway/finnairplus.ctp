<div class="dialog finnairplus-method-form">
		<div class="content">
			<div class="modal-header">
				<h4 class="modal-title finnair-title" id="pointPaymentModalLabel"><?php echo __("Maksu Finnair Plus -pisteillä")?></h4>
			</div>
            
			<div class="modal-body">
			   <div class="login-form">
                    <div class="panel-heading">
                    	<h4>Kirjaudu sisään</h4>
                        <p>Sisäänkirjautuminen tapahtuu käyttäjätunnuksellasi (Finnair Plus -jäsennumerosi) ja salasanallasi. Jos liityit jäseneksi verkkopalvelussamme, olet saanut ne sähköpostiisi heti liittymisen jälkeen.</p>
                        <p>
                        Kirjoita numero ilman AY-etuliitettä ja välejä.
                        </p>
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
                        <p>Finnair Plus -tililläsi on yhteensä <strong>127.500</strong> pistettä. </p>
                        <p>Ostoksesta on maksamatta <strong><?php echo __("%.2f %s",$totalDue,$symbol)?></strong>.</p>
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
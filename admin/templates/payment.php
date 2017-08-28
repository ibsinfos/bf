<?php
$group_option = "payment";
$option = BX_Option::get_instance();
$payment = $option->get_group_option($group_option);
$paypal = (object)$payment['paypal'];

$t = (object) BX_Option::get_instance()->get_option('payment','paypal');

?>
<div class="section box-section" id="<?php echo $group_option;?>">
	<h2 class="section-title">Currency Options </h2>
	<div class="form-group row">
		<div class="col-md-3"> <span>Select currency</span> 		</div>
		<div class="col-md-9">
        	<select name="woocommerce_currency" id="woocommerce_currency" style="min-width: 350px;" class="wc-enhanced-select enhanced" tabindex="-1" title="Currency">
        	<?php
        	$list = list_currency();
        	foreach ($list as $cur => $value) {
        		echo "<option value='".$cur."'>".$value."</option>";
        	}
        	?>
			</select>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-md-3">     		<span>Currency Position</span>       		</div>
		<div class="col-md-9">
			<select name="woocommerce_currency_pos" id="woocommerce_currency_pos" style="min-width: 350px; " class="wc-enhanced-select enhanced" tabindex="-1" title="Currency Position">
				<option value="left" selected="selected">Left ($99.99)</option>
				<option value="right">Right (99.99$)</option>
				<option value="left_space">Left with space ($ 99.99)</option>
				<option value="right_space">Right with space (99.99 $)</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-3">     		<span>Thousand Separator</span>       		</div>
		<div class="col-md-9"> <input name="woocommerce_price_thousand_sep" id="woocommerce_price_thousand_sep" type="text" style="width:50px;" value="," class="" placeholder="" />   </div>
	</div>
	<div class="form-group row">
		<div class="col-md-3">     		<span>Decimal Separator</span>       		</div>
		<div class="col-md-9"><input name="woocommerce_price_decimal_sep" id="woocommerce_price_decimal_sep" type="text" style="width:50px;" value="." class="" placeholder="">       		</div>
	</div>

</div>

<div class="section box-section" id="<?php echo $group_option;?>">
	<h2 class="section-title">Package plan</h2>
    <div class="sub-section" id="package_plan">
    	<div class="row">
        	<div class="col-md-3">
            	<h4> List package plan </h4>
            </div>
            <div class="col-md-9">
                <?php
                    $args = array(
                        'post_type' => '_package',
                        'meta_key' => 'type',
                        'meta_value' => 'buy_credit'
                    );
                    $the_query = new WP_Query($args);

                    // The Loop
                    if ( $the_query->have_posts() ) {
                        echo '<table class="widefat" id="list_package">';
                        $i = 1; ?>
	                    <thead>
		  					<tr>
								<th class="page-name"><?php _e( 'STT', 'boxtheme' ); ?></th>
		  						<th class="page-name"><?php _e( 'SKU', 'boxtheme' ); ?></th>
		  						<th class="page-name"><?php _e( 'Detail', 'boxtheme' ); ?></th>
		  						<th class="page-name">&nbsp;</th>
		  					</tr>
	   					</thead> <?php
                        while ( $the_query->have_posts() ) {
                            $the_query->the_post();
                            $price = get_post_meta(get_the_ID(),'price', true);
                            //echo $price;
                            $sku = get_post_meta(get_the_ID(),'sku', true);

                            echo '<tr class="block">';
                            echo '<td class="col-md-1">'.$i.'</td>';
                            echo '<td class="col-md-1">'.$sku.'</td>';
                            echo '<td class="col-md-8">';
                            echo get_the_content();
                            echo '</td>';
                            echo '<td class="col-sm-1 align-center">
                            	<span class="swap-btn-act" id="'.get_the_ID().'"><span attr="'.get_the_ID().'" class="btn-act btn-delete 	glyphicon glyphicon-trash"></span> &nbsp; <span  class=" btn-act	glyphicon glyphicon-edit"></span></span>';

                            echo '</td>';
                            echo '</tr>';
                            $i ++;
                        }
                        echo '</table>';

                        /* Restore original Post Data */
                        wp_reset_postdata();
                    } else {
                    	echo '<div class="form-group">';
                        _e('List package plan is empty','boxtheme');
                        echo '</div>';
                    }
                    ?>
                </div>
            </div> <!-- .row !-->
            <div class="row">
                <div class="col-md-3"><h4 class="form-heading"><?php _e('Insert new package','boxtheme');?> </h4>
                </div>
                <div class="col-md-9">
                    <form class="frm-add-package row">

                      	<div class="full">
	                        <div class="col-sm-6 one-line">
	                            <input type="text" class="form-control" required name="sku" placeholder="<?php _e('SKU');?>"><small>SKU</small>
	                        </div>
	                        <div class="col-sm-6 one-line">
	                            <input type="text" class="form-control" required name="price" placeholder="<?php _e('Price');?>"  ><small>$</small>
	                        </div>
	                        <div class="col-sm-12 one-line">
	                        	<textarea id="post_content" name="post_content" class=""> <?php _e('Description of new package','boxtheme');?></textarea>
	                        </div>

	                        <div class="col-sm-10 one-line">
	                        </div>
	                        <div class="col-sm-2 align-right one-line">
	                        	<button class="btn">Create</button>
	                        </div>
	                   	</div>
                    </form>
               </div>
            </div>
    </div>
</div>

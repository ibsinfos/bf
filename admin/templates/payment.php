<?php
$group_option = "payment";
$option = BX_Option::get_instance();
$payment = $option->get_group_option($group_option);
$paypal = (object)$payment['paypal'];
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
                    $list_package = array();
                    $the_query = new WP_Query($args);

                    // The Loop
                    if ( $the_query->have_posts() ) {
                        echo '<div class="widefat " id="list_package">';
                        $i = 1; ?>
	                    <div class=" form-group heading-line">

								<div class="col-md-1 page-name"><?php _e( 'STT', 'boxtheme' ); ?></div>
		  						<div class=" col-md-2 page-name"><?php _e( 'SKU', 'boxtheme' ); ?></div>
		  						<div class="col-md-7 page-name"><?php _e( 'Name', 'boxtheme' ); ?></div>
		  						<div class="col-md-2 page-name">&nbsp;</div>

	   					</div> <?php

                        while ( $the_query->have_posts() ) {
                            $the_query->the_post();
                            $class = "item-le";
                            if($i% 2 == 0)
                            	$class = "item-chan";
                            $price = get_post_meta(get_the_ID(),'price', true);
                            //echo $price;
                            $sku = get_post_meta(get_the_ID(),'sku', true);

                            echo '<div class="block  row-item '.$class.'">';
                            echo '<div class="col-md-1">'.$i.'</div>';
                            echo '<div class="col-md-2">'.$sku.'</div>';
                            echo '<div class="col-md-7">';
                            echo get_the_title();
                            echo '</div>';
                            echo '<div class="col-md-2 align-center">
                            	<span class="btn-act-wrap" id="'.get_the_ID().'"><span attr="'.get_the_ID().'" class="btn-act btn-delete 	glyphicon glyphicon-trash"></span> &nbsp; <span  class=" btn-act btn-edit-package	glyphicon glyphicon-edit"></span></span>';

                            echo '</div>';
                            echo '</div>';
                            $post->price = $price;
                            $post->sku = $sku;
                            $list_package[$post->ID] = $post;
                            $i ++;
                        }
                        echo '</div>';

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
                <div class="col-md-3"><h4 class="form-heading"><?php _e('Insert new package','boxtheme');?> </h4></div>
                <div class="col-md-9">
                    <form class="frm-add-package row">

                      	<div class="full">
                      		<div class="col-sm-4 one-line">
	                            <input type="text" class="form-control" id="post_title" required name="post_title" placeholder="<?php _e('Name');?>">&nbsp; <i>Package name</i>
	                        </div>
	                        <div class="col-sm-4 one-line">
	                            <input type="text" class="form-control" required name="sku" placeholder="<?php _e('SKU');?>">&nbsp; <i>SKU code</i>
	                        </div>
	                        <div class="col-sm-4 one-line">
	                            <input type="number" class="form-control" required name="price" placeholder="<?php _e('Price');?>"  >&nbsp;<i>Price of this package</i>
	                        </div>
	                        <div class="col-sm-12 one-line">
	                        	<textarea id="post_content" name="post_content" class="" placeholder="<?php _e('Description of new package','boxtheme');?>"></textarea>
	                        </div>

	                        <div class="col-sm-10 one-line">
	                         <input type="hidden" name="ID" id="ID" value="0" />
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
<script type="text/template" id="json_list_package"><?php   echo json_encode($list_package); ?></script>
<script type="text/html" id="tmpl-frm_edit_package">
	<form class="frm-add-package row">

      	<div class="full">
			<div class="col-sm-12 one-line">
      			<h3><?php _e('Edit package plan','boxtheme');?></h3>
      		</div>
      		<div class="col-sm-4 one-line">
                <input type="text" class="form-control" required name="post_title" value="{{{data.post_title}}}" placeholder="<?php _e('Name');?>">&nbsp; <i>Package name</i>
            </div>
            <div class="col-sm-4 one-line">
                <input type="text" class="form-control" required="" name="sku" placeholder="SKU" value="{{{data.sku}}}"><small>SKU</small>
            </div>
            <div class="col-sm-4 one-line">
                <input type="number" class="form-control" required="" name="price" placeholder="Price" value="{{{data.price}}}"><small>$</small>
            </div>
            <div class="col-sm-12 one-line">
            	<textarea id="post_content" name="post_content" class="">{{{data.post_content}}}</textarea>
            </div>
            <input type="hidden" name="ID" id="ID" value="{{{data.ID}}}" />
            <div class="col-sm-10 one-line">
            </div>
            <div class="col-sm-2 align-right one-line">
            	<button class="btn"><?php _e('Update','boxtheme');?></button>
            </div>
       	</div>
    </form>
</script>
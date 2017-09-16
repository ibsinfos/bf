<?php

function box_price($price,$echo = true){
	echo get_box_price($price);
}
function get_box_price($price) {

	$currency =  BX_Option::get_instance()->get_currency_code();
	$decimals = 2;

	number_format( $price, $decimals, $currency->price_decimal_sep, $currency->price_thousand_sep );

	$symbol = box_get_currency_symbol($currency->code);

	$string = $price.'<span class="currency-icon">('.$symbol.') </span>';

	return  $string;
}

/**
 * this function get the float number only withouth currency  symbol
 * This is a cool function
 * @author danng
 * @version 1.0
 * @return  [type] [description]
 */
function box_get_price($price, $setting  = array() ){

	$currency =  BX_Option::get_instance()->get_currency_code();
	$decimals = 2;
	$currency =  BX_Option::get_instance()->get_currency_code();
	return number_format( $price, $decimals, $currency->price_decimal_sep, $currency->price_thousand_sep );
}

/** this function will be return float number with the symbol */

function box_get_price_format( $setting = array() ){
	$currency =  BX_Option::get_instance()->get_currency_code();
	$decimals = 2;

	$currency = (object) $general->currency;
	if( !empty( $currency->code ) )
		$code = $currency->code;

	$symbol = box_get_currency_symbol($code);

	$string = $price.'<span class="currency-icon">('.$symbol.') </span>';

	return  $string;
}

function bx_list_start($score){ ?>
	<start class="rating-score clear block core-<?php echo $score;?>">
		<span class="glyphicon glyphicon-star"></span>
		<span class="glyphicon glyphicon-star"></span>
		<span class="glyphicon glyphicon-star"></span>
		<span class="glyphicon glyphicon-star"></span>
		<span class="glyphicon glyphicon-star"></span>
	</start>
	<?php
}
if( !function_exists('box_get_static_link')):

	function box_get_static_link($page_args, $create = false){

		$slug = $page_args;
		if( is_array($page_args) ){
			$slug = $page_args['page_template'];
		}
		$name = "page-{$slug}-link";
		$link = wp_cache_get($name, 'static_link');

		if ( false !== $link ) {
			return $link;
		}
		$page = get_pages( array(
			            'meta_key' 		=> '_wp_page_template',
			            'meta_value' 	=> 'page-' . $slug . '.php',
			            'numberposts' 	=> 1,
			            'post_status' => 'publish',
			            //'hierarchical' 	=> 0,
			        ));
		$id = 0;
		if( empty($page) ){
			$args  = array(
				'post_title' => $slug,
				'post_type' => 'page',
				'post_status' => 'publish',
			);
			$id = wp_insert_post($args);
			update_post_meta($id,'_wp_page_template','page-' . $slug . '.php' );
		} else {
			$page = array_shift($page);
	        $id = $page->ID;
		}
		$link = get_permalink($id);
		wp_cache_set( $name, $link, 'static_link');
	    return $link;
	}
endif;

function box_editor_settings() {
	return apply_filters( 'box_editor_settings', array(
		'quicktags'     => true,
		'media_buttons' => false,
		'wpautop'       => true,

		//'tabindex'    =>  '2',
		'teeny'         => true,
		'tinymce'       => array(
			'height'                            => 150,
			'editor_class'                      => 'input-item',
			'autoresize_min_height'             => 150,
			'autoresize_max_height'             => 550,
			'theme_advanced_buttons1'           => 'bold,|,italic,|,underline,|,bullist,numlist,|,link,unlink,|,wp_fullscreen',
			'theme_advanced_buttons2'           => '',
			'theme_advanced_buttons3'           => '',
			'theme_advanced_statusbar_location' => 'none',
			'theme_advanced_resizing'           => true,
			'paste_auto_cleanup_on_paste'       => true,
			'setup'                             => "function(ed){
                ed.onChange.add(function(ed, l) {
                    var content = ed.getContent();
                    if(ed.isDirty() || content === '' ){
                        ed.save();
                        jQuery(ed.getElement()).blur(); // trigger change event for textarea
                    }

                });

                // We set a tabindex value to the iframe instead of the initial textarea
                ed.onInit.add(function() {
                    var editorId = ed.editorId,
                        textarea = jQuery('#'+editorId);
                    jQuery('#'+editorId+'_ifr').attr('tabindex', textarea.attr('tabindex'));
                    textarea.attr('tabindex', null);
                });
            }"
		)
	) );
}
function box_get_currency_symbol($code){
	$symbols = array('AED' => '&#x62f;.&#x625;',
		'AFN' => '&#x60b;',
		'ALL' => 'L',
		'AMD' => 'AMD',
		'ANG' => '&fnof;',
		'AOA' => 'Kz',
		'ARS' => '&#36;',
		'AUD' => '&#36;',
		'AWG' => '&fnof;',
		'AZN' => 'AZN',
		'BAM' => 'KM',
		'BBD' => '&#36;',
		'BDT' => '&#2547;&nbsp;',
		'BGN' => '&#1083;&#1074;.',
		'BHD' => '.&#x62f;.&#x628;',
		'BIF' => 'Fr',
		'BMD' => '&#36;',
		'BND' => '&#36;',
		'BOB' => 'Bs.',
		'BRL' => '&#82;&#36;',
		'BSD' => '&#36;',
		'BTC' => '&#3647;',
		'BTN' => 'Nu.',
		'BWP' => 'P',
		'BYR' => 'Br',
		'BZD' => '&#36;',
		'CAD' => '&#36;',
		'CDF' => 'Fr',
		'CHF' => '&#67;&#72;&#70;',
		'CLP' => '&#36;',
		'CNY' => '&yen;',
		'COP' => '&#36;',
		'CRC' => '&#x20a1;',
		'CUC' => '&#36;',
		'CUP' => '&#36;',
		'CVE' => '&#36;',
		'CZK' => '&#75;&#269;',
		'DJF' => 'Fr',
		'DKK' => 'DKK',
		'DOP' => 'RD&#36;',
		'DZD' => '&#x62f;.&#x62c;',
		'EGP' => 'EGP',
		'ERN' => 'Nfk',
		'ETB' => 'Br',
		'EUR' => '&euro;',
		'FJD' => '&#36;',
		'FKP' => '&pound;',
		'GBP' => '&pound;',
		'GEL' => '&#x10da;',
		'GGP' => '&pound;',
		'GHS' => '&#x20b5;',
		'GIP' => '&pound;',
		'GMD' => 'D',
		'GNF' => 'Fr',
		'GTQ' => 'Q',
		'GYD' => '&#36;',
		'HKD' => '&#36;',
		'HNL' => 'L',
		'HRK' => 'Kn',
		'HTG' => 'G',
		'HUF' => '&#70;&#116;',
		'IDR' => 'Rp',
		'ILS' => '&#8362;',
		'IMP' => '&pound;',
		'INR' => '&#8377;',
		'IQD' => '&#x639;.&#x62f;',
		'IRR' => '&#xfdfc;',
		'ISK' => 'Kr.',
		'JEP' => '&pound;',
		'JMD' => '&#36;',
		'JOD' => '&#x62f;.&#x627;',
		'JPY' => '&yen;',
		'KES' => 'KSh',
		'KGS' => '&#x43b;&#x432;',
		'KHR' => '&#x17db;',
		'KMF' => 'Fr',
		'KPW' => '&#x20a9;',
		'KRW' => '&#8361;',
		'KWD' => '&#x62f;.&#x643;',
		'KYD' => '&#36;',
		'KZT' => 'KZT',
		'LAK' => '&#8365;',
		'LBP' => '&#x644;.&#x644;',
		'LKR' => '&#xdbb;&#xdd4;',
		'LRD' => '&#36;',
		'LSL' => 'L',
		'LYD' => '&#x644;.&#x62f;',
		'MAD' => '&#x62f;. &#x645;.',
		'MAD' => '&#x62f;.&#x645;.',
		'MDL' => 'L',
		'MGA' => 'Ar',
		'MKD' => '&#x434;&#x435;&#x43d;',
		'MMK' => 'Ks',
		'MNT' => '&#x20ae;',
		'MOP' => 'P',
		'MRO' => 'UM',
		'MUR' => '&#x20a8;',
		'MVR' => '.&#x783;',
		'MWK' => 'MK',
		'MXN' => '&#36;',
		'MYR' => '&#82;&#77;',
		'MZN' => 'MT',
		'NAD' => '&#36;',
		'NGN' => '&#8358;',
		'NIO' => 'C&#36;',
		'NOK' => '&#107;&#114;',
		'NPR' => '&#8360;',
		'NZD' => '&#36;',
		'OMR' => '&#x631;.&#x639;.',
		'PAB' => 'B/.',
		'PEN' => 'S/.',
		'PGK' => 'K',
		'PHP' => '&#8369;',
		'PKR' => '&#8360;',
		'PLN' => '&#122;&#322;',
		'PRB' => '&#x440;.',
		'PYG' => '&#8370;',
		'QAR' => '&#x631;.&#x642;',
		'RMB' => '&yen;',
		'RON' => 'lei',
		'RSD' => '&#x434;&#x438;&#x43d;.',
		'RUB' => '&#8381;',
		'RWF' => 'Fr',
		'SAR' => '&#x631;.&#x633;',
		'SBD' => '&#36;',
		'SCR' => '&#x20a8;',
		'SDG' => '&#x62c;.&#x633;.',
		'SEK' => '&#107;&#114;',
		'SGD' => '&#36;',
		'SHP' => '&pound;',
		'SLL' => 'Le',
		'SOS' => 'Sh',
		'SRD' => '&#36;',
		'SSP' => '&pound;',
		'STD' => 'Db',
		'SYP' => '&#x644;.&#x633;',
		'SZL' => 'L',
		'THB' => '&#3647;',
		'TJS' => '&#x405;&#x41c;',
		'TMT' => 'm',
		'TND' => '&#x62f;.&#x62a;',
		'TOP' => 'T&#36;',
		'TRY' => '&#8378;',
		'TTD' => '&#36;',
		'TWD' => '&#78;&#84;&#36;',
		'TZS' => 'Sh',
		'UAH' => '&#8372;',
		'UGX' => 'UGX',
		'USD' => '&#36;',
		'UYU' => '&#36;',
		'UZS' => 'UZS',
		'VEF' => 'Bs F',
		'VND' => '&#8363;',
		'VUV' => 'Vt',
		'WST' => 'T',
		'XAF' => 'Fr',
		'XCD' => '&#36;',
		'XOF' => 'Fr',
		'XPF' => 'Fr',
		'YER' => '&#xfdfc;',
		'ZAR' => '&#82;',
		'ZMW' => 'ZK',
	);
	$currency_symbol = isset( $symbols[ $code ] ) ? $symbols[ $code ] : '';
	return $currency_symbol;
}
function list_currency(){
	return array(
		'AED' => 'United Arab Emirates dirham (د.إ)',
		'AFN' => 'Afghan afghani (؋)',
		'ALL' => 'Albanian lek (L)',
		'AMD' => 'Armenian dram (AMD)',
		'ANG' => 'Netherlands Antillean guilder (ƒ)',
		'AOA' => 'Angolan kwanza (Kz)',
		'ARS' => 'Argentine peso ($)',
		'AUD' => 'Australian dollar ($)',
		'AWG' => 'Aruban florin (ƒ)',
		'AZN' => 'Azerbaijani manat (AZN)',
		'BAM' => 'Bosnia and Herzegovina convertible mark (KM)',
		'BBD' => 'Barbadian dollar ($)',
		'BDT' => 'Bangladeshi taka (৳&nbsp;)',
		'BGN' => 'Bulgarian lev (лв.)',
		'BHD' => 'Bahraini dinar (.د.ب)',
		'BIF' => 'Burundian franc (Fr)',
		'BMD' => 'Bermudian dollar ($)',
		'BND' => 'Brunei dollar ($)',
		'BOB' => 'Bolivian boliviano (Bs.)',
		'BRL' => 'Brazilian real (R$)',
		'BSD' => 'Bahamian dollar ($)',
		'BTC' => 'Bitcoin (฿)',
		'BTN' => 'Bhutanese ngultrum (Nu.)',
		'BWP' => 'Botswana pula (P)',
		'BYR' => 'Belarusian ruble (Br)',
		'BZD' => 'Belize dollar ($)',
		'CAD' => 'Canadian dollar ($)',
		'CDF' => 'Congolese franc (Fr)',
		'CHF' => 'Swiss franc (CHF)',
		'CLP' => 'Chilean peso ($)',
		'CNY' => 'Chinese yuan (¥)',
		'COP' => 'Colombian peso ($)',
		'CRC' => 'Costa Rican colón (₡)',
		'CUC' => 'Cuban convertible peso ($)',
		'CUP' => 'Cuban peso ($)',
		'CVE' => 'Cape Verdean escudo ($)',
		'CZK' => 'Czech koruna (Kč)',
		'DJF' => 'Djiboutian franc (Fr)',
		'DKK' => 'Danish krone (DKK)',
		'DOP' => 'Dominican peso (RD$)',
		'DZD' => 'Algerian dinar (د.ج)',
		'EGP' => 'Egyptian pound (EGP)',
		'ERN' => 'Eritrean nakfa (Nfk)',
		'ETB' => 'Ethiopian birr (Br)',
		'EUR' => 'Euro (€)',
		'FJD' => 'Fijian dollar ($)',
		'FKP' => 'Falkland Islands pound (£)',
		'GBP' => 'Pound sterling (£)',
		'GEL' => 'Georgian lari (ლ)',
		'GGP' => 'Guernsey pound (£)',
		'GHS' => 'Ghana cedi (₵)',
		'GIP' => 'Gibraltar pound (£)',
		'GMD' => 'Gambian dalasi (D)',
		'GNF' => 'Guinean franc (Fr)',
		'GTQ' => 'Guatemalan quetzal (Q)',
		'GYD' => 'Guyanese dollar ($)',
		'HKD' => 'Hong Kong dollar ($)',
		'HNL' => 'Honduran lempira (L)',
		'HRK' => 'Croatian kuna (Kn)',
		'HTG' => 'Haitian gourde (G)',
		'HUF' => 'Hungarian forint (Ft)',
		'IDR' => 'Indonesian rupiah (Rp)',
		'ILS' => 'Israeli new shekel (₪)',
		'IMP' => 'Manx pound (£)',
		'INR' => 'Indian rupee (₹)',
		'IQD' => 'Iraqi dinar (ع.د)',
		'IRR' => 'Iranian rial (﷼)',
		'ISK' => 'Icelandic króna (kr.)',
		'JEP' => 'Jersey pound (£)',
		'JMD' => 'Jamaican dollar ($)',
		'JOD' => 'Jordanian dinar (د.ا)',
		'JPY' => 'Japanese yen (¥)',
		'KES' => 'Kenyan shilling (KSh)',
		'KGS' => 'Kyrgyzstani som (сом)',
		'KHR' => 'Cambodian riel (៛)',
		'KMF' => 'Comorian franc (Fr)',
		'KPW' => 'North Korean won (₩)',
		'KRW' => 'South Korean won (₩)',
		'KWD' => 'Kuwaiti dinar (د.ك)',
		'KYD' => 'Cayman Islands dollar ($)',
		'KZT' => 'Kazakhstani tenge (KZT)',
		'LAK' => 'Lao kip (₭)',
		'LBP' => 'Lebanese pound (ل.ل)',
		'LKR' => 'Sri Lankan rupee (රු)',
		'LRD' => 'Liberian dollar ($)',
		'LSL' => 'Lesotho loti (L)',
		'LYD' => 'Libyan dinar (ل.د)',
		'MAD' => 'Moroccan dirham (د.م.)',
		'MDL' => 'Moldovan leu (L)',
		'MGA' => 'Malagasy ariary (Ar)',
		'MKD' => 'Macedonian denar (ден)',
		'MMK' => 'Burmese kyat (Ks)',
		'MNT' => 'Mongolian tögrög (₮)',
		'MOP' => 'Macanese pataca (P)',
		'MRO' => 'Mauritanian ouguiya (UM)',
		'MUR' => 'Mauritian rupee (₨)',
		'MVR' => 'Maldivian rufiyaa (.ރ)',
		'MWK' => 'Malawian kwacha (MK)',
		'MXN' => 'Mexican peso ($)',
		'MYR' => 'Malaysian ringgit (RM)',
		'MZN' => 'Mozambican metical (MT)',
		'NAD' => 'Namibian dollar ($)',
		'NGN' => 'Nigerian naira (₦)',
		'NIO' => 'Nicaraguan córdoba (C$)',
		'NOK' => 'Norwegian krone (kr)',
		'NPR' => 'Nepalese rupee (₨)',
		'NZD' => 'New Zealand dollar ($)',
		'OMR' => 'Omani rial (ر.ع.)',
		'PAB' => 'Panamanian balboa (B/.)',
		'PEN' => 'Peruvian nuevo sol (S/.)',
		'PGK' => 'Papua New Guinean kina (K)',
		'PHP' => 'Philippine peso (₱)',
		'PKR' => 'Pakistani rupee (₨)',
		'PLN' => 'Polish złoty (zł)',
		'PRB' => 'Transnistrian ruble (р.)',
		'PYG' => 'Paraguayan guaraní (₲)',
		'QAR' => 'Qatari riyal (ر.ق)',
		'RON' => 'Romanian leu (lei)',
		'RSD' => 'Serbian dinar (дин.)',
		'RUB' => 'Russian ruble (₽)',
		'RWF' => 'Rwandan franc (Fr)',
		'SAR' => 'Saudi riyal (ر.س)',
		'SBD' => 'Solomon Islands dollar ($)',
		'SCR' => 'Seychellois rupee (₨)',
		'SDG' => 'Sudanese pound (ج.س.)',
		'SEK' => 'Swedish krona (kr)',
		'SGD' => 'Singapore dollar ($)',
		'SHP' => 'Saint Helena pound (£)',
		'SLL' => 'Sierra Leonean leone (Le)',
		'SOS' => 'Somali shilling (Sh)',
		'SRD' => 'Surinamese dollar ($)',
		'SSP' => 'South Sudanese pound (£)',
		'STD' => 'São Tomé and Príncipe dobra (Db)',
		'SYP' => 'Syrian pound (ل.س)',
		'SZL' => 'Swazi lilangeni (L)',
		'THB' => 'Thai baht (฿)',
		'TJS' => 'Tajikistani somoni (ЅМ)',
		'TMT' => 'Turkmenistan manat (m)',
		'TND' => 'Tunisian dinar (د.ت)',
		'TOP' => 'Tongan paʻanga (T$)',
		'TRY' => 'Turkish lira (₺)',
		'TTD' => 'Trinidad and Tobago dollar ($)',
		'TWD' => 'New Taiwan dollar (NT$)',
		'TZS' => 'Tanzanian shilling (Sh)',
		'UAH' => 'Ukrainian hryvnia (₴)',
		'UGX' => 'Ugandan shilling (UGX)',
		'USD' => 'United States dollar ($)',
		'UYU' => 'Uruguayan peso ($)',
		'UZS' => 'Uzbekistani som (UZS)',
		'VEF' => 'Venezuelan bolívar (Bs F)',
		'VND' => 'Vietnamese đồng (₫)',
		'VUV' => 'Vanuatu vatu (Vt)',
		'WST' => 'Samoan tālā (T)',
		'XAF' => 'Central African CFA franc (Fr)',
		'XCD' => 'East Caribbean dollar ($)',
		'XOF' => 'West African CFA franc (Fr)',
		'XPF' => 'CFP franc (Fr)',
		'YER' => 'Yemeni rial (﷼)',
		'ZAR' => 'South African rand (R)',
		'ZMW' => 'Zambian kwacha (ZK)',
	);
}
add_filter('getimagesize_mimes_to_exts','bx_allow_upload_extend');
function bx_allow_upload_extend($args){

	$add = array('doc|docx' => 'application/msword' ,
		'pdf' 			=> 'application/pdf',
		'zip' 			=> 'multipart/x-zip',
		'mp3|m4a|m4b'  => 'audio/mpeg',
		'wav'          => 'audio/wav',
		'wma'          => 'audio/x-ms-wma',
		'wmv'          => 'video/x-ms-wmv',
		'wmx'          => 'video/x-ms-wmx',
		'wm'           => 'video/x-ms-wm',
		'avi'          => 'video/avi',
		'divx'         => 'video/divx',
		'flv'          => 'video/x-flv',
		'mov|qt'       => 'video/quicktime',
		'mpeg|mpg|mpe' => 'video/mpeg',
		'mp4|m4v'      => 'video/mp4'
		);
	return array_merge($args, $add);
}
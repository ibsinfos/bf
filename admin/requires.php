<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function bx_swap_button($group, $name, $is_active, $multipe = true){
	$checked  = '';
	$multi =  'multi = "1" ';
	if( $is_active ) $checked = 'checked';
	if( !$multipe ) $multi = 'multi = "0" ';
	echo '<input type="checkbox" class="auto-save" '.$multi.' name="'.$name.'" value="'.$is_active.'" '.$checked.' data-toggle="toggle">';

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

function list_email(){
	return array(
		'new_register' => array(
			'receiver' => 'register',
			'subject' =>	'New register',
			'name' =>	'New register',
			'content' =>	'Has new register'
		),
		'new_job' => array(
			'receiver' => 'admin',
			'subject' =>	'The job %s has been posted',
			'content' =>	'The job %s has been posted'
		),
		'new_bidding' => array(
			'receiver' => 'employer',
			'subject' =>	'New bidding in your project %s',
			'content' =>	'Has new bidding'
		),
		'new_message' => array(
			'receiver' => 'receiver',
			'subject' =>	'Have a new message for you',
			'content' =>	'Hi, Have new message for you.'
		),
		'assign_job' => array(
			'receiver' => 'freelancer',
			'subject' =>	'Your bidding is choosen for project %s',
			'content' =>	'Congart, Your bidding is choosen'
		),
	);
}


	require_once dirname(__FILE__) . '/admin.php';
	require_once dirname(__FILE__) . '/credit.php';
	require_once dirname(__FILE__) . '/ajax_register.php';
	if( class_exists( 'BX_Admin') )
 		new BX_Admin();
 	if( class_exists( 'BX_Credit_Setting') )
 		new BX_Credit_Setting();
?>
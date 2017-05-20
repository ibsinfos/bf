<?php
	define( 'LOG_FILE', WP_CONTENT_DIR.'/ipn.log');
	define( 'PROJECT','project');
	define( 'BID','bid');
	define( 'FREELANCER','freelancer');
	define( 'EMPLOYER','employer');
	define( 'PROFILE', 'profile' );
	define( 'ORDER', '_order');

	//Profile meta
	define( 'HOUR_RATE', 'hour_rate' );
	define( 'PROJECTS_WORKED', 'projects_worked' );

	define( 'COUNTRY','country');



	// meta field of project
	define( 'BUDGET', '_budget');
	define( 'AWARDED', 'awarded' ); // project status
	define( 'DONE', 'done' ); // project status
	define( 'CLOSE', 'close' ); // project status
	// publish => awarded => done =>close.

	define( 'DISPUTED', 'disputed' ); // project status
	define( 'WINNER_ID', '_winner_id');// freelancer ID of this project.
	//meta field of Bid
	define( 'BID_ID_WIN', 'bid_id_win');
	define( 'BID_PRICE','_bid_price');
	define( 'BID_DEALINE','_dealine');
	// comment meta
	define( 'RATING_SCORE','rating_score'); // rating score of employer for this biding.

	// define mate name of review  content;
	define('REVIEW_MSG','review_msg');
	//USER meta
	define('EMPLOYER_TYPE','employer_type');
	define( 'INDIVIDUAL','individual');
	define( 'COMPANY','company');
	define( 'SPENT', 'spent');
	define( 'EARNED', 'earned' );
	define( 'EARNED_TXT', 'earned_txt' );

?>
<h3>Proposals</h3>
<ul class="none-style">
	<?php
	global $role;
	$page_link =bx_get_static_link('history');
	if($role == FREELANCER ){ ?>
		<li><a href="<?php echo add_query_arg('status','publish',$page_link); ?>">Projet bidding</a> </li>
		<li><a href="<?php echo add_query_arg('status','awarded',$page_link); ?>">Projects working</a></li>
		<li><a href="<?php echo add_query_arg('status','done',$page_link); ?>">Projects done </a></li>
		<li><a href="<?php echo add_query_arg('status','disputed',$page_link); ?>">Pprojects disputed </a></li>
	<?php } else { ?>
		<li><a href="<?php echo add_query_arg('status','publish',$page_link); ?>">Projects active </a> </li>
		<li><a href="<?php echo add_query_arg('status','done',$page_link); ?>">Projects done</a></li>
		<li><a href="<?php echo add_query_arg('status','awarded',$page_link); ?>">Projects are working</a></li>
		<li><a href="<?php echo add_query_arg('status','disputing',$page_link); ?>">Projects disputing </a></li>
		<li><a href="<?php echo add_query_arg('status','disputed',$page_link); ?>">Projects disputed </a></li>
	<?php } ?>
	<li><a href="<?php echo home_url('buy-credit');?>">Buy Credit </a></li>
</ul>
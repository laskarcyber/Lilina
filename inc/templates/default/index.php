<?php
/**
 * Default template for Lilina
 * @author Ryan McCue <cubegames@gmail.com>
 * @author Panayotis Vryonis <panayotis@vrypan.net>
 */
/**
*/
header('Content-Type: text/html; charset=utf-8');
global $settings, $showtime; //Just in case ;)
/**
 * @todo Remove this
 */
$nothing = array(); // For blank parameters
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/1">
<title><?php template_sitename();?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo template_file_load('style.css'); ?>" media="screen"/>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script language="JavaScript" type="text/javascript" src="<?php template_siteurl(); ?>inc/js/jquery-1.2.1.pack.js"></script>
<?php
if(file_exists(template_file_load('custom.js'))) {
	echo '<script language="JavaScript" type="text/javascript" src="' . template_file_load('custom.js')  . '"></script>';
}
else {
	echo '<script language="JavaScript" type="text/javascript" src="' . template_siteurl(true) . 'inc/js/engine.js"></script>';
}
?>
<?php
template_header();
?>
</head>
<body id="river-<?php echo $showtime; ?>" class="river-page">
<div id="navigation">
  	<a href="<?php template_siteurl();?>">
	<img src="<?php echo template_file_load('logo-small.png');?>" alt="<?php template_sitename();?>" title="<?php template_sitename();?>" />
	</a>
	<?php 
	if(template_synd_links())
		echo ' | ';
	?>
	<a id="expandall" href="javascript:void(0);"><img src="<?php echo template_file_load('arrow_out.png');?>" alt="<?php _e('Show All Items'); ?>" /> <?php _e('Expand'); ?></a> |
	<a id="collapseall" href="javascript:void(0);"><img src="<?php echo template_file_load('arrow_in.png'); ?>" alt="<?php _e('Hide All Items'); ?>" /> <?php _e('Collapse'); ?></a> |
	<a id="removedates" href="javascript:void(0);"><img src="<?php echo template_file_load('arrow_in.png'); ?>" alt="<?php _e('Remove dates'); ?>" /> <?php _e('Remove date markers'); ?></a>
	|
	<a href="opml.php">OPML</a>
	|
	<a href="#sources">List of sources</a>
</div>

<div style="text-align: right; padding-top: 0em; padding-right: 2em;" id="times">
	<p style="font-size: 0.8em;">Show posts from the last:</p>
	<ul>
	<?php
	template_times();
	?>
	</ul>
</div>

<div id="main">
<?php
$notfirst = false;
while(has_items()) {
	the_item();
	if(date_equals()) {
		if($notfirst) {
			//Close both feed and date
			echo '		</div>';
			echo '	</div>', "\n";
		}
?>
	<h1 title="<?php _e('Click to expand/collapse date');?>">News stories from <?php the_date('l d F, Y')?></h1>
	<div id="date<?php the_date('dmY')?>">
		<div class="feed feed-<?php get_the_feed_id(); ?>">
<?php
	}
	elseif(feed_equals()) {
		global $item_number;
		if($item_number != 0) {
			echo '		</div>';
		}
		echo '		<div class="feed feed-', get_the_feed_id(), '">';
	}
?>
			<div class="item c2" id="IITEM-<?php the_id(); ?>">
				<img src="<?php echo $item['icon'];?>" alt="<?php _e('Favicon');?>" title="<?php _e('Favicon');?>" style="width:16px; height:16px;" />
				<span class="time"><?php the_date('format=H:i'); ?></span>
				<span class="title" id="TITLE<?php the_id(); ?>" title="<?php _e('Click to expand/collapse item');?>"><?php the_title(); ?></span>
				<span class="source"><a href="<?php the_feed_url(); ?>">&#187; <?php the_feed_name();?> <img src="<?php echo template_file_load('application_double.png'); ?>" alt="<?php _e('Visit off-site link'); ?>" /></a></span>
				<div class="excerpt" id="ICONT<?php the_id(); ?>">
					<?php the_content(); ?>
					<?php if( has_enclosure() ){
						echo '<hr />', the_enclosure();
					} ?>
				</div>
				<?php do_action('river_entry'); ?>
			</div><?php
	//Feed closed above
//Date closed above
$notfirst = true;
}
if(!has_feeds()) {
?>
	<div style="border:1px solid #e7dc2b;background: #fff888;margin:15px;padding:10px;">You haven't added any feeds yet. Add them from <a href="admin.php">your admin panel</a></div>
<?php
}
else {
?>
	<div style="border:1px solid #e7dc2b;background: #fff888;margin:15px;padding:10px;">No items available from in the last <?php echo ($showtime/3600); ?> hour(s). Try <a href="index.php?hours=-1" id="viewallitems">viewing all items</a></div>
	<div style="border:1px solid #e7dc2b;background: #fff888;margin:15px;padding:10px;display:none;">Now loading all available items - If they don't load within 20 seconds, click <a href="index.php?hours=-1">here</a><br /><img src="<?php echo template_file_load('loading.gif'); ?>" alt="Loading..." /></div>
<?php
}
?>
	</div>
</div>
</div>

<div id="sources">
	<strong>Sources:</strong>
	<ul><?php/*
		if(has_feeds()) {
			foreach(get_feeds() as $feed) { ?>
		<li>
			<a href="<?php echo $feed['link']; ?>"><img src="<?php echo $feed['icon']; ?>" style="height:16px" alt="icon" />
			<?php echo $feed['name']; ?></a>
			[<a href="<?php echo $feed['feed']; ?>"><?php _e('Feed');?></a>]
			<a href="javascript:void(0);" class="hide_feed"><span class="feed-<?php echo md5(htmlspecialchars($feed['link'])); ?>">(<?php _e('Hide items from this channel'); ?>)</span></a>
		</li><?php
			}
		}
		else {
			//Already handled above; if there are no feeds, then there should be no items...
		}
		?>
	</ul><?php
	echo $feed->error();*/
	?></div>
<div id="footer">
<?php template_footer(); ?>
</div>
</body>
</html>
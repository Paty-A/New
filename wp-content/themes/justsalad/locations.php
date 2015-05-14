<?php
/**
 * Template Name: Locations and Maps
 *
 * This is the template that displays all locations pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Ten_Five 
 * @since Twenty Ten Five 1.0
 */

get_header(); ?>

		<div id="container">
            <section id="content" role="main">

<?php
$dr = explode(".", $_SERVER['SERVER_NAME']);
	if($dr[0]=="hk" && !isset($_POST['r'])) {
		$_POST['r']=2;
	}
	else if($dr[0]=="sg" && !isset($_POST['r'])) {
		$_POST['r']=3;
	}
	else if($dr[0]=="dubai" && !isset($_POST['r'])) {
		$_POST['r']=5;
	}

?>	             

<div id="location-switcher">
	<div id="location-block">
    	Current Region:
           <span><? if($_POST['r']==2) { echo "Hong Kong"; } else if($_POST['r']==3) { echo "Singapore"; } 
           	else if($_POST['r']==5) { echo "UAE"; } else if($_POST['r']==4) { echo "New Jersey"; } else if ($_POST['r']==6) { echo "Chicago"; }
           	else { echo "New York"; }?></span>
    
    </div>
<? 
	
if(!isset($_POST['r']) || $_POST['r']==1) {?>
    <form role='search' method="post" id="zipform" action="#">
        <label for="z">Search by ZIP Code:</label>
        <input type="text" value="" name="z" id="z" />
        <input type="submit" id="zipsubmit" value="Go!" />
    </form>
<? }
	
	
?>
   <form role='search' method="post" id="regionform" action="/<?=$post->post_name?>/">
        <label for="r">Change Region:</label>
        <select type="text" value="" name="r" id="r" onchange='this.form.submit()'>
            <option value="1" <? if($_POST['r']==1 || !isset($_POST['r'])) { echo "selected"; }?>>New York</option>
			<option value="4" <? if($_POST['r']==4) { echo "selected"; }?>>New Jersey</option>
			<option value="6" <? if($_POST['r']==6) { echo "selected"; }?>>Chicago</option>
			<option value="2" <? if($_POST['r']==2) { echo "selected"; }?>>Hong Kong</option>
			<option value="5" <? if($_POST['r']==5) { echo "selected"; }?>>UAE</option>
        </select>
        <input type="hidden" id="regionsubmit" value="Submit" />
    </form>
</div>
<div class="clear"></div>
<div class="location-infoC">
	<ul>
<?
	$lettervar = "A";
if($_POST['r']) { $region = $_POST['r']; }
else { $region = 1;}

 $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/markers.xml');
 $count=0;
 for($i=0; $i<count($xml); $i++) {
	 if($xml->marker[$i]->region==$region) {
		 	if(!isset($startpoint)) { $startpoint = array((float)$xml->marker[$i]->lat, (float)$xml->marker[$i]->lng); }
	?>
 <li><div class="letter"><?=$lettervar?></div>
            <h3><a class="loclink" href="#<?=$count?>"><?=$xml->marker[$i]->name?> <img id="expand-<?=$count?>" class="hide-lg expand" src="/wp-content/themes/justsalad/images/plus.png" alt="Touch to expand" /></a></h3>
           
<div class="locationInfo" id="location-<?=$count?>">
 <div class="fleft">
            <?=$xml->marker[$i]->address?><br />
			<? if($xml->marker[$i]->address2!="") {echo $xml->marker[$i]->address2."<br />"; } ?>
            <?=$xml->marker[$i]->details?>
        
                <h4>Hours:</h4>
                <?=$xml->marker[$i]->hours?><br />
                <?=$xml->marker[$i]->hours2?>
        
                <h4>Phone:</h4>
                <?=$xml->marker[$i]->phone?>
            </div>    
                <div id="buttons">
<?php if($xml->marker[$i]->phone!="") {echo "<a href='tel:".$xml->marker[$i]->phone."' class='button hide-lg'>Call</a>"; } ?>
                    <? if(get_the_ID()==30) {?>
                    <a href="<? if($xml->marker[$i]->order!="") { echo $xml->marker[$i]->order; } else { echo "https://www.orderjustsalad.com/"; }?>" target="_blank" class=""><img src="/wp-content/themes/justsalad/images/ORDER_BUTTON_RED.png" alt="Order Online" /></a>
                    <? }
					else { 
					  
						if(stristr($_SERVER['HTTP_USER_AGENT'], 'iPhone')) { ?>
 <a href="http://maps.google.com/?saddr=Current%20Location&daddr=Just%20Salad%20<?=urlencode($xml->marker[$i]->address)?>%20<?=$xml->marker[$i]->zip?>" target="_blank" class="button hide-lg cright">Map</a>
 
<?	}
						else if(stristr($_SERVER['HTTP_USER_AGENT'], 'Android')) {
?>
                   					<a href="geo:0,0?q=Just%20Salad%20<?=urlencode($xml->marker[$i]->address)?>%20<?=$xml->marker[$i]->zip?>" target="_blank" class="button hide-lg cright">Map</a>
                    
                   <? }
					else {?>
						<a href="http://maps.google.com/?q=Just%20Salad%20<?=urlencode($xml->marker[$i]->address)?>%20<?=$xml->marker[$i]->zip?>" target="_blank" class="button hide-lg cright">Map</a>
<? }
?>
					<a href="<? if($xml->marker[$i]->menu!="") {echo $xml->marker[$i]->menu; } else { echo "/menu/"; } ?>" class="button hide-sm">Menu</a>
					<a href="<? if($xml->marker[$i]->menu!="") {echo $xml->marker[$i]->menu; } else { echo "/menu-2/"; } ?>" class="button hide-lg">Menu</a>
                    <?php if($xml->marker[$i]->order!="") { ?>
<a href="<? echo $xml->marker[$i]->order;?>" target="_blank" class="button">Order Online</a>
<?php }?>
                    <? }?>
                </div>
				<div class="hide-lg">
					<h4>Delivery Range:</h4>
					<?=$xml->marker[$i]->range?>
				</div>
				
                <? if(get_the_ID()!=30 && $xml->marker[$i]->url!="") {?>
                <a class="hide-small" href="<?=$xml->marker[$i]->url?>"><strong>Store Bios and Photos</strong></a>
                <? }?>
</div>
		</li>
<?  
$lettervar++;
$count++;
	 }
}
?>


	    
	</ul>    
    <!--<a href="" class="arrow-forward">Next</a>//-->
</div>


<div style="width:454px; float:left;">
			
                <div id="map"></div>    
				
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

					<h1 class="offscreen"><?php the_title(); ?></h1>

					<?php the_content(); ?>
                    <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>

                    <?php comments_template( '', true ); ?>

				<?php endwhile; ?>
        
</div>              
			</section><!-- #content -->
			<?php get_sidebar('right'); ?>
			</div>
		</div><!-- #container -->
        
        <? 

if(isset($_GET['loc'])) { $locate=$_GET['loc']; } else { $locate=-1; }
	if(isset($_POST['z']) && $_POST['z']!="") { $zloc = $_POST['z']; } else { $zloc = -1; }
	if(isset($_POST['r']) && $_POST['r']!="") { $postRegion = $_POST['r']; } else { $postRegion = 1; }

	echo '
<script type="text/javascript">
jQuery(document).ready(function() {
  jQuery(".locationInfo").hide();
  
  chash = self.document.location.hash.substring(1);
  
  //jQuery("#location-"+chash).show();
  jQuery("#expand-"+chash).attr("src", "/wp-content/themes/justsalad/images/minus.png");

  jQuery("#map").css({
		height: 456,
		width: 454
	});

	var defaultLatLng = new google.maps.LatLng('.$startpoint[0].','.$startpoint[1].');
  	MYMAP.init("#map", defaultLatLng, 12);

	if(chash!="") {
		MYMAP.placeMarkers("/wp-content/uploads/markers.xml", chash, '.$zloc.', '.$postRegion.');
	}
	else {
		MYMAP.placeMarkers("/wp-content/uploads/markers.xml", -1, '.$zloc.', '.$postRegion.');
	}
		
	jQuery("a.loclink").click(function() {
			jQuery(".locationInfo").slideUp();
			var locatejs = this.hash.slice(1);
			jQuery(".expand").attr("src", "/wp-content/themes/justsalad/images/plus.png");

			if(locatejs!=chash) {
				jQuery("#location-"+locatejs).slideDown();
				jQuery("#expand-"+locatejs).attr("src", "/wp-content/themes/justsalad/images/minus.png");
			}
			for( j=0;j<MYMAP.infoBubbles.length; j++ ) {
				 	MYMAP.infoBubbles[j].close(MYMAP.map, MYMAP.markers[j]);
			}
			MYMAP.placeMarkers("/wp-content/uploads/markers.xml", locatejs, -1, '.$postRegion.');
			MYMAP.map.setCenter(MYMAP.markers[locatejs].position);
			MYMAP.map.panBy(-20,-70);

  
		});

});
</script><? ';
?>

<?php get_footer(); ?>

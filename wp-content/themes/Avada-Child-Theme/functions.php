<?php

function theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'avada-stylesheet' ),time() );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

add_action('avada_before_additional_post_content','add_register_button_event_details_page');

function add_register_button_event_details_page(){
	if(is_single() && in_category('5')){
		if(get_field('register_button_url')){
			//echo '<div class="register_button_url"><a href="'.get_field('register_button_url').'" target="_blank">Register</a></div>';
		}
	}
}

add_action('avada_after_main_container','add_section_before_footer');

function add_section_before_footer(){
	?>
<div class="footer_top_area">

	<div class="container_row">
		<?php dynamic_sidebar('avada-custom-sidebar-footertop'); ?>
	</div>
	
	
	<div class="container_row">
		<div class="seperator">
			
		</div>
	</div>
</div>
  <?php
}


add_action('fusion_sharing_box_tagline','post_details_social_tag');

function post_details_social_tag(){
	the_category();
}

add_action('avada_after_additional_post_content','event_post_details');

function event_post_details(){
	if(in_category('5')){
	?>
<style> 
.single .fusion-sharing-box {
    border-bottom: 0px solid #e9e9e9;
}
.single .fusion-sharing-box h4 {
    display: none;
}
.event_detailss h2 {
    color: #000!important;
}
.single .fusion-sharing-box .fusion-social-networks {
    text-align: left;
}	
</style>
<div class="row event_page_details">
	<div class="col-md-4">
		<div class="event_detailss">
			<h4>
				Event Details
			</h4>
			<h2>
				<?php the_title(); ?>
			</h2>
			<div class="deails_center">
				<p>
					<span>Date:</span> <strong><?php the_field('add_event_data');  ?></strong>
				</p>
				<p>
					<span>Time:</span>  <strong><?php the_field('add_event_tile');  ?></strong>
				</p>
				<p>
					<span>Location:</span> <strong><?php 
						
						$address = get_field('event_address_place');
						if($address){
							echo $address;
						}else{
							echo "Solano Avenue<br>Berkeley, CA 94707";
						}
						 
					?>
					</strong>
				</p>				
			</div>
			<div class="add_to_calander">
				<a href="http://www.google.com/calendar/event?action=TEMPLATE&text" target="_blank" rel="nofollow">+ Add to Calendar</a>
				
			
				
			
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<?php
		$location = get_field('add_event_location');
		if($location){
				echo '<div class="res_map_warper">'.$location .'</div>';		
			}else{
						echo "<img src='http://pwmhosting.ca/nbwn/wp-content/uploads/2019/11/map.png' alt=''/>";
					}?>
	</div>	
</div>
     <?php
		
	}
	
}



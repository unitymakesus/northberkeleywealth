<?php
/**
 * Titlebar template.
 *
 * @author     ThemeFusion
 * @copyright  (c) Copyright by ThemeFusion
 * @link       http://theme-fusion.com
 * @package    Avada
 * @subpackage Core
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>




<div class="fusion-page-title-bar fusion-page-title-bar-<?php echo esc_attr( $content_type ); ?> fusion-page-title-bar-<?php echo esc_attr( $alignment ); ?>">
	<div class="fusion-page-title-row">
		<div class="fusion-page-title-wrapper">
			<div class="fusion-page-title-captions">
			
			
				<?php if ( 'center' === $alignment ) : // Render secondary content on center layout. ?>
					<?php if ( 'none' !== fusion_get_option( 'page_title_bar_bs', 'page_title_breadcrumbs_search_bar', $post_id ) ) : ?>
						<div class="fusion-page-title-secondary">
							<?php echo $secondary_content; // WPCS: XSS ok. ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>
				
				
				
				<?php if ( $title ) : ?>
					<?php // Add entry-title for rich snippets. ?>
					<?php $entry_title_class = ( Avada()->settings->get( 'disable_date_rich_snippet_pages' ) && Avada()->settings->get( 'disable_rich_snippet_title' ) ) ? 'entry-title' : ''; ?>
					<?php
				global $post;
				$postIDs = array('782','239','248','250','252','258','260','273','770','780');
				if(in_array($post->ID,$postIDs)): ?>
					<h2 class="<?php echo esc_attr( $entry_title_class ); ?>"><?php echo $title; // WPCS: XSS ok. ?></h2>
					<?php else: ?>
					<h1 class="<?php echo esc_attr( $entry_title_class ); ?>"><?php echo $title; // WPCS: XSS ok. ?></h1>
					<?php endif; ?>
					<?php if(is_single()):
						if(in_category('5')):
					?>
						<div class="post_meta_tile">
						
							<div class="post_date"><span class="date_icon"></span><?php the_field('add_event_data'); ?></div>
							<div class="post_author"><span class="time_icon"></span><?php the_field('add_event_tile');  ?> </div>
							
						</div>
					<?php else:
					if(!in_category('20')):
					?>
						<div class="post_meta_tile">
						
							<div class="post_date"><span class="date_icon"></span><?php echo get_the_date(); ?></div>
							<div class="post_author"><span class="author_icon"></span>
								<?php the_author_meta('display_name', get_post_field( 'post_author', $post_id )); 
								
								?> </div>
							<div class="post_category"><span class="cate_icon"></span><?php the_category(); ?></div>
						</div>
					<?php endif; endif; endif; ?>
					
					<?php if ( $subtitle ) : ?>
						<h3><?php echo $subtitle; // WPCS: XSS ok. ?></h3>
					<?php endif; ?>
				<?php endif; ?>

				

			</div>

			

		</div>
	</div>
</div>

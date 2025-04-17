<?php
/*
Plugin Name: CAI Custom Event Slideshow
Description: Crea uno shortcode per mostrare uno slideshow degli eventi tribe_events con il campo 'show_in_slideshow' impostato su true
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// registra gli script slick e custom per il plugin
function cai_custom_event_slideshow_enqueue_scripts()
{
    wp_enqueue_script('slick-js', plugin_dir_url(__FILE__) . 'js/slick.min.js', array('jquery'), '1.0', true);
    wp_enqueue_script('custom-js', plugin_dir_url(__FILE__) . 'js/custom.js', array('jquery', 'slick-js'), '1.0', true);
    wp_enqueue_style('slick-css', plugin_dir_url(__FILE__) . 'css/slick.css');
    wp_enqueue_style('slick-theme', plugin_dir_url(__FILE__) . 'css/slick-theme.css');
    wp_enqueue_style('custom-css', plugin_dir_url(__FILE__) . 'css/custom.css');
}
add_action('wp_enqueue_scripts', 'cai_custom_event_slideshow_enqueue_scripts');


function cai_custom_event_slideshow_shortcode()
{
    ob_start();
?>
    <div class="event-slideshow">
        <?php
        $args = array(
    'post_type' => 'tribe_events',
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => '_EventStartDate',
            'value' => date('Y-m-d'),
            'compare' => '>=',
            'type' => 'DATE'
        ),
        array(
            'key' => 'show_in_slideshow',
            'value' => '1',
            'compare' => '='
        )
    ),
    'orderby' => '_EventStartDate',
    'order' => 'ASC'
);
        $events = new WP_Query($args);
        while ($events->have_posts()) : $events->the_post();
            $event_image = get_the_post_thumbnail_url();
            $event_title = get_the_title();
	    $event_date = tribe_get_start_date(null, true, 'd/m/Y');
	    $data_pubblicazione = get_the_date('Y-m-d H:i:s');
            $data_aggiornamento = get_the_modified_date('Y-m-d H:i:s');
            if( !tribe_event_is_all_day() ){
                $event_date = $event_date . ' alle ore ' . tribe_get_start_date(null, true, 'H:i');
            } 
        ?>
            <div class="event-slide" style="background-image: url(<?php echo $event_image; ?>)">
                <div class="event-info">
                    <h2 class="event-title"><a href="<?php echo get_permalink(); ?>"><?php echo $event_title; ?></a></h2>
		    <?php		    
		   if ($data_pubblicazione < $data_aggiornamento) {
        	      echo '<span class="updated-star">⭐ Aggiornato il '. get_the_modified_date('d/m/Y') . ' alle ' . get_the_modified_date('H:i') . '</span>';
		   } ?>
		    <p class="event-date">Evento previsto per il <?php echo $event_date; ?></p>
                </div>
            </div>
        <?php endwhile;
        wp_reset_postdata(); ?>
    </div>
<?php
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('cai_custom_event_slideshow', 'cai_custom_event_slideshow_shortcode');

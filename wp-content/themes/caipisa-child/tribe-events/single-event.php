<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */


if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = get_the_ID();

?>

<div id="tribe-events-content" class="tribe-events-single">

	<p class="tribe-events-back">
		<a href="<?php echo esc_url( tribe_get_events_link() ); ?>"> <?php printf( '&laquo; ' . esc_html_x( 'All %s', '%s Events plural label', 'the-events-calendar' ), $events_label_plural ); ?></a>
	</p>

	<!-- Notices -->
	<?php tribe_the_notices() ?>

	<?php the_title( '<h1 class="tribe-events-single-event-title">', '</h1>' ); ?>

	<div class="tribe-events-schedule tribe-clearfix">
		<?php echo tribe_events_event_schedule_details( $event_id, '<h2>', '</h2>' ); ?>
		<?php if ( tribe_get_cost() ) : ?>
			<span class="tribe-events-cost"><?php echo tribe_get_cost( null, true ) ?></span>
		<?php endif; ?>
	</div>

	<!-- Event header -->
	<div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
		<!-- Navigation -->
		<nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?>">
			<ul class="tribe-events-sub-nav">
				<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
				<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
			</ul>
			<!-- .tribe-events-sub-nav -->
		</nav>
	</div>
	<!-- #tribe-events-header -->

	<?php while ( have_posts() ) :  the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<!-- Event featured image, but exclude link -->
			<?php echo tribe_event_featured_image( $event_id, 'full', false ); ?>

			<!-- view advanced custom field -->	

			<?php if (has_tag("programma-soci")): ?>
  			<div id="dettaglio-escursioni">
   			<h2>Informazioni sull'escursione</h2>
   			<strong>Classificazione</strong>: <?php $c = get_post_meta(get_the_ID(), "classificazione", true); echo !empty($c[0]) ? $c[0] : "-"; ?><br />
			<strong>Dislivello</strong>: <?php $dislivello = get_post_meta(get_the_ID(), "dislivello", true); echo !empty($dislivello) ? $dislivello . " m" : "-"; ?><br />
			<strong>Tempo di percorrenza</strong>: <?php $tempo = get_post_meta(get_the_ID(), "tempo_di_percorrenza", true); echo !empty($tempo) ? $tempo . " ore" : "-"; ?><br />
			<strong>Mezzo di trasporto</strong>: <?php $mezzo = get_post_meta(get_the_ID(), "mezzo_di_trasporto", true); echo !empty($mezzo) ? $mezzo : "-"; ?><br />
			<strong>Accompagnatore/i</strong>: <?php $accompagnatori = get_post_meta(get_the_ID(), "capi_gita", true); echo !empty($accompagnatori) ? $accompagnatori : "-"; ?><br />
			<strong>Contatti</strong>: <?php $contatti = get_post_meta(get_the_ID(), "email_capo_gita", true); echo !empty($contatti) ? $contatti : "-"; ?><br />
			<strong>Attrezzatura</strong>: <?php $attrezzatura = get_post_meta(get_the_ID(), "attrezzatura", true); echo !empty($attrezzatura) ? $attrezzatura : "-"; ?><br />
			<strong>Documenti Utili</strong>: <?php $documenti = get_post_meta(get_the_ID(), "documentiutili", true); echo !empty($documenti) ? $documenti : "-"; ?><br />
   			</div>               
			<br />
   			<?php endif; ?>

			<!-- Event content -->

			<p>
			<h2><b>Descrizione</b></h2>

			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
			<div class="tribe-events-single-event-description tribe-events-content">
				<?php the_content(); ?>
			</div>
			</p>

			

			


			<!-- .tribe-events-single-event-description -->
			<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>
			

			<!-- Event meta -->
			<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
			<?php tribe_get_template_part( 'modules/meta' ); ?>
			<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
		</div> <!-- #post-x -->
		<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
	<?php endwhile; ?>

	<!-- Event footer -->
	<div id="tribe-events-footer">
		<!-- Navigation -->
		<nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?>">
			<ul class="tribe-events-sub-nav">
				<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
				<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
			</ul>
			<!-- .tribe-events-sub-nav -->
		</nav>
	</div>
	<!-- #tribe-events-footer -->

</div><!-- #tribe-events-content -->



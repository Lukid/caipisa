
<?php
/**
>> code from old.caipisa.it for single-corso custom post type

 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ultra
 * @since ultra 0.9
 * @license GPL 2.0
 */
get_header(); ?>
		

	<?php if ( get_the_title( 'page_title' ) ) : ?>
		<header class="entry-header">
			<div class="container">
				<h1 class="entry-title"><?php echo get_the_title(); ?></h1>
                                <?php // ultra_breadcrumb(); ?>
			</div><!-- .container -->
		</header><!-- .entry-header -->
	<?php endif; ?>

	<?php while ( have_posts() ) : the_post(); ?>

	<div class="container course-container">

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php echo get_the_post_thumbnail(get_the_ID(),'large'); ?>
<p></p>
<div class="corso_content">
<h2>Descrizione del corso</h2>
	<?php the_content(); ?>
</div>

<div id="corso_mainfo">
		
<div>
	<h5>Direttore:</h5><span><strong><?php echo get_post_meta(get_the_ID(),"direttore_del_corso",true) ; ?></strong></span>
	<?php if (!empty(get_post_meta(get_the_ID(),"segretario_del_corso",true))){ ?> 
		<h5>Segretario:</h5><span><?php echo get_post_meta(get_the_ID(),"segretario_del_corso",true) ; ?></span>
	<?php } ?>
	<h5>Contatti:</h5><span><?php echo get_post_meta(get_the_ID(),"indirizzo_email_del_corso",true); ?></a></span>
	<h5>Altri contatti:</h5><span><?php echo get_post_meta(get_the_ID(),"altri_contatti",true) ; ?></span>
	<h5>Materiale del corso:</h5>
		<span>
  		<?php if (get_field('locandina')):?>&nbsp;&nbsp;<a href="<?php the_field('locandina'); ?>" target="_blank">Locandina</a><br /><?php endif; ?>
  		<?php if (get_field('brochure')):?>&nbsp;&nbsp;<a href="<?php the_field('brochure'); ?>" target="_blank">Brochure</a><br /><?php endif; ?>
  		<?php if (get_field('regolamento')):?>&nbsp;&nbsp;<a href="<?php the_field('regolamento'); ?>" target="_blank">Regolamento</a><br /><?php endif; ?>
  		<?php if (get_field('modulo_iscrizione')):?>&nbsp;&nbsp;<a href="<?php the_field('modulo_iscrizione'); ?>" target="_blank">Modulo di iscrizione</a><br /><?php endif; ?>
		<?php if (get_field('questionario')):?>&nbsp;&nbsp;<a href="<?php the_field('questionario'); ?>" target="_blank">Questionario</a><br /><?php endif; ?>
		</span>
</div>
</div>


<div id="corso_programma">
<h2>PROGRAMMA E DATE</h2>

<?php if(get_field('data_apertura_iscrizioni')): ?>
<h3>Apertura iscrizioni: <?php the_field('data_apertura_iscrizioni');?></h3>
<?php endif; ?>

<?php 

   $ps = get_field('data_di_presentazione_del_corso');
   if ($ps) {
       $p = $ps[0];
       ?><h3>Presentazione del corso: <?php echo date('d/m/Y',strtotime(get_field('_EventStartDate',$p->ID))); ?> 
             <?php if (get_field('_EventVenueID',$p->ID)) { echo ' presso: '.get_the_title(get_field('_EventVenueID',$p->ID));} ?>
        </h3><?php 
    }
?> 

<?php 

 $ls = get_field('lezioni_teoriche');
   if ($ls){
   ?><h3>Lezioni Teoriche</h3><?php
       foreach($ls as $l) {
       echo date('d/m/Y',strtotime(get_field('_EventStartDate',$l->ID)));
  		echo " ore ";
       echo date('H:i',strtotime(get_field('_EventStartDate',$l->ID)));
       echo ' @ <a href="'.get_permalink($l->ID).'">'.get_the_title($l->ID).'</a>'; 
       if (get_field('_EventVenueID',$l->ID)) { echo ' - presso: '.get_the_title(get_field('_EventVenueID',$l->ID));}
       echo '<br />';
    }}
?> 
<p>
<?php 

 $ls = get_field('field_589769e8fd19b');
   if ($ls) {
   ?><h3>Lezioni Pratiche</h3><?php
       foreach($ls as $l) {
		   $start_date = date('d/m/Y',strtotime(get_field('_EventStartDate',$l->ID)));
		   $end_date = date('d/m/Y',strtotime(get_field('_EventEndDate',$l->ID)));
		   if( $start_date == $end_date ){
				echo $start_date;
		   } else {
				echo 'Dal '.$start_date;
				echo ' al '.$end_date;
		   } 
			
			echo ' @ <a href="'.get_permalink($l->ID).'">'.get_the_title($l->ID).'</a>'; 
			if (get_field('_EventVenueID',$l->ID)) { echo ' - presso: '.get_the_title(get_field('_EventVenueID',$l->ID));}
			echo '<br />';
    }}
?> 
<p></p>
</div>

</article><!-- #post-## -->

			<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?> 
	<?php get_footer();	?>

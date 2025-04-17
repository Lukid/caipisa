<?php
header('Content-Type: application/rss+xml; charset=' . get_option('blog_charset'), true);
echo '<?xml version="1.0" encoding="' . get_option('blog_charset') . '"?' . '>';

/**
 * Define some basic feed properties
 */
$title       = 'CAI Custom Feed for Newsletter';
$description = 'This is my custom feed that includes posts and events with the "newsletter" field set to true, ordered by their publishing or event date.';
$language    = get_bloginfo('language');
/**
 * Custom query to retrieve posts and events that match the criteria
 */

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
            'key' => 'show_in_newsletter',
            'value' => '1',
            'compare' => '='
        )
    ),
    'orderby' => '_EventStartDate',
    'order' => 'ASC'
);

$query = new WP_Query($args);

/**
 * Start the feed
 */
?>
<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/" <?php do_action('rss2_ns'); ?>>

    <channel>
        <title><?php echo $title; ?></title>
        <atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
        <link><?php bloginfo_rss('url') ?></link>
        <description><?php echo $description; ?></description>
        <lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>
        <language><?php echo $language; ?></language>
        <image>
          <url>https://www.caipisa.it/wp-content/uploads/2021/02/logo-cai_pisa.png</url>
          <title>CAI Custom Feed for Newsletter</title>
          <link>https://www.caipisa.it/</link>
        </image>
        <sy:updatePeriod><?php echo apply_filters('rss_update_period', 'hourly'); ?></sy:updatePeriod>
        <sy:updateFrequency><?php echo apply_filters('rss_update_frequency', '1'); ?></sy:updateFrequency>
        <?php do_action('rss2_head'); ?>
        <?php
        while ($query->have_posts()) : $query->the_post();
          $timestamp = tribe_get_start_date(get_the_ID(), true, 'U');
	      $date = date('D, d M Y H:i:s O', $timestamp);    
		?>
            <item>
                <title><?php the_title_rss(); ?></title>
                <link><?php the_permalink_rss(); ?></link>
                <pubDate><?php echo $date; ?></pubDate>
                <dc:creator><?php the_author(); ?></dc:creator>
                <guid isPermaLink="true"><?php the_permalink_rss(); ?></guid>
                <description><?php echo get_the_excerpt(); ?></description>
                <content:encoded>
                    <![CDATA[
                        <?php if (has_post_thumbnail()) {
                            $thumbnail_id = get_post_thumbnail_id();
                            $thumbnail = wp_get_attachment_image_src($thumbnail_id, 'medium');
                            echo '<img src="' . $thumbnail[0] . '" />';
                        } ?>
                        <?php echo get_the_excerpt(); ?>
                    ]]>
                </content:encoded>
                <?php rss_enclosure(); ?>
                <?php do_action('rss2_item'); ?>
            </item>
        <?php endwhile; ?>
    </channel>
</rss>
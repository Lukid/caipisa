===  Post grid and filter ultimate ===
Tags: post grid, post, post filter, post category filter, custom post grid, grid display, grid, content grid, filter, post designs, grid designs, wponlinesupport
Contributors: wponlinesupport, anoopranawat, pratik-jain, piyushpatel123, ridhimashukla, patelketan
Requires at least: 4.0
Tested up to: 6.7
Stable tag: 1.7.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A quick, easy way to display WordPress post in grid view and post grid with filter. Also work with Gutenberg shortcode block. 

== Description ==

✅ Now that you have your website ready then why don’t you **download** and try out this Post Grid and Filter to give it better functionality.

**Download Now** It is proven that post filters have been a powerful tool to present your content in a very neat manner with the help of fancy sliders and customized designs.

[FREE DEMO](https://demo.essentialplugin.com/post-grid-and-filter-ultimate-demo/?utm_source=WP&utm_medium=Post-Grid-and-Filter&utm_campaign=Read-Me) | [PRO DEMO](https://demo.essentialplugin.com/prodemo/post-grid-and-filter-with-popup-pro-demo/?utm_source=WP&utm_medium=Post-Grid-and-Filter&utm_campaign=Read-Me)

Your customer might like the professional and fancy vibe of your site with Post Filter

**✅ This plugin displays your custom posts using :**

* Post Grid (2 designs)
* Post Filter (2 designs)

When you want to makeover your WordPress website theme with something extraordinary and creative, you must consider the Post Grid and Filter plugin.

Help your website get a filter-wise display to show the custom posts. Not just eye appealing, it is also loved by visitors as they find it quite easy to locate custom posts. 

Easy way to display WordPress post in grid view and post grid with filter. Display anywhere via shortcode. lots more shortcode parameters give you extend as your needs.

**Also added Gutenberg block support.**

= ✅ Here is the plugin shortcode example =

**post Grid** 

<code>[pgaf_post_grid]</code>

**Post Fiter** 

<code>[pgaf_post_filter]</code>

**To display only Post Grid 4 post:**

<code>[pgaf_post_grid limit="4"]</code>
Where limit define the number of posts to display.

**If you want to display post grid by category then use this short code:** 

<code>[pgaf_post_grid cat_id="category_ID"]</code>
You can use same parameter with post grid shortcode.

**✅ We have given 2 designs. For designs use the following shortcode:**

<code>[pgaf_post_grid design="design-1"]</code> 
Where designs are : design-1, design-2. You can use same parameter with filter shortcode.

= ✅ Here is Template code =
<code><?php echo do_shortcode('[pgaf_post_grid]'); ?></code>
<code><?php echo do_shortcode('[pgaf_post_filter]'); ?></code>

= ✅ Use Following Post Grid parameters with shortcode =
<code>[pgaf_post_grid]</code>

* **limit** : [pgaf_post_grid limit="10"] (Display latest 10 posts and then pagination).
* **cat_id** : [pgaf_post_grid cat_id="category_id"] (Display posts categories wise).
* **include_cat_child** : [pgaf_post_grid include_cat_child="false"] (Include cat child or not. Values are "true" or "false").
* **design** : [pgaf_post_grid design="design-1"] (Select the design to display. there are 2 designs ie design-1 and design-2 ).
* **grid** : [pgaf_post_grid grid="2"](Display post in Grid formats).
* **order** :  [pgaf_post_grid order="DESC"] (Post order ie DESC or ASC).
* **orderby** : [pgaf_post_grid orderby="date"] (Order by post ie ID, author, title, date, name, rand etc).
* **image_fit** : [pgaf_post_grid image_fit="true"] (Fit the post image in wrap. Values are "true" or "false").
* **media_size** : [pgaf_post_grid media_size="large"] (Set the featured image size to diplay in post Values are thumbnail, medium, large, full).
* **image_height** : [pgaf_post_grid image_height="300"] (Set featured image height).
* **show_date** : [pgaf_post_grid show_date="false"] (Display post date OR not. By default value is "true". Options are "ture OR false")
* **show_author** : [pgaf_post_grid show_author="true"] (Display post author. Values are "true" or "false").
* **show_content** : [pgaf_post_grid show_content="true"] (Display post Short content OR not. By default value is "true". Options are "ture OR false").
* **show_read_more** : [pgaf_post_grid show_read_more="true"] (Display Read more button or not. Options are "ture OR false")
* **show_category_name** : [pgaf_post_grid show_category_name="true"] (Display post category name OR not. By default value is "True". Options are "ture OR false").
* **content_words_limit** : [pgaf_post_grid content_words_limit="30"] (Control post short content Words limt. By default limit is 20 words).
* **content_tail** : [pgaf_post_grid content_tail="..."] (Set content tail).
* **pagination** : [pgaf_post_grid pagination="true"] (Set content tail).
* **pagination_type** : [pgaf_post_grid pagination_type="numeric"] (values are "prev-next" and "numeric").
* **show_comments** : [pgaf_post_grid show_comments="true"] (Options are "ture OR false").
* **extra_class** : [pgaf_post_grid extra_class=""] (Enter extra CSS class for design customization ).

= ✅ Use Following Post Filter parameters with shortcode =
<code>[pgaf_post_filter]</code>

* **cat_id** : [pgaf_post_filter cat_id="category_id"] (Display posts categories wise).
* **include_cat_child** : [pgaf_post_filter include_cat_child="false"] (Include cat child or not. Values are "true" or "false").
* **design** : [pgaf_post_filter design="design-1"] (Select the design to display. there are 2 designs ie design-1 and design-2 ).
* **grid** : [pgaf_post_filter grid="2"](Display post in Grid formats).
* **order** :  [pgaf_post_filter order="DESC"] (Post order ie DESC or ASC).
* **orderby** : [pgaf_post_filter orderby="date"] (Order by post ie ID, author, title, date, name, rand etc).
* **image_fit** : [pgaf_post_filter image_fit="true"] (Fit the post image in wrap. Values are "true" or "false").
* **media_size** : [pgaf_post_filter media_size="large"] (Set the featured image size to diplay in post Values are thumbnail, medium, large, full).
* **image_height** : [pgaf_post_filter image_height="300"] (Set featured image height).
* **show_date** : [pgaf_post_filter show_date="false"] (Display post date OR not. By default value is "true". Options are "ture OR false")
* **show_author** : [pgaf_post_filter show_author="true"] (Display post author. Values are "true" or "false").
* **show_content** : [pgaf_post_filter show_content="true"] (Display post Short content OR not. By default value is "true". Options are "ture OR false").
* **show_read_more** : [pgaf_post_filter show_read_more="true"] (Display Read more button or not. Options are "ture OR false")
* **show_category_name** : [pgaf_post_filter show_category_name="true"] (Display post category name OR not. By default value is "True". Options are "ture OR false").
* **content_words_limit** : [pgaf_post_filter content_words_limit="30"] (Control post short content Words limt. By default limit is 20 words).
* **exclude_cat** : [pgaf_post_filter exclude_cat=''].
* **content_tail** : [pgaf_post_filter content_tail="..."] (Set content tail).
* **show_comments** : [pgaf_post_filter show_comments="true"] (Options are "ture OR false").
* **cat_orderby** : [pgaf_post_filter cat_orderby="name"]
* **all_filter_text** : [pgaf_post_filter all_filter_text="All"]
* **extra_class** : [pgaf_post_filter extra_class=""] (Enter extra CSS class for design customization ).

✅ **Checkout demo for better understanding**

[FREE DEMO](https://demo.essentialplugin.com/post-grid-and-filter-ultimate-demo/?utm_source=WP&utm_medium=Post-Grid-and-Filter&utm_campaign=Read-Me) | [PRO DEMO](https://demo.essentialplugin.com/prodemo/post-grid-and-filter-with-popup-pro-demo/?utm_source=WP&utm_medium=Post-Grid-and-Filter&utm_campaign=Read-Me)

✅ **Essential Plugin Bundle Deal**

[Annual or Lifetime Bundle Deal](https://www.essentialplugin.com/pricing/?utm_source=WP&utm_medium=Post-Grid-and-Filter&utm_campaign=Read-Me)

= ✅ Features include: =
* Added Gutenberg block support.
* Post Grid
* Post Filter
* Easy to add.
* Also work with Gutenberg shortcode block. 
* Elementor, Beaver and SiteOrigin Page Builder Native Support (New).
* Divi Page Builder Native Support (New).
* Fusion Page Builder (Avada) Native Support (New).
* Given 2 designs.
* Media size i.e.  thumbnail, medium, medium_large, large and full
* Responsive.
* You can create multiple post slider with different options at single page or post.
* Fully responsive. Scales with its container.
* 100% Multi Language.

= Privacy & Policy =
* We have also opt-in e-mail selection, once you download the plugin , so that we can inform you and nurture you about products and its features.

== Installation ==

1. Upload the 'post-grid-and-filter-ultimate' folder to the '/wp-content/plugins/' directory.
2. Activate the "Post grid and filter ultimate" list plugin through the 'Plugins' menu in WordPress.
3. Add a new page and add shortcode.

== Screenshots ==

1. Post grid view.
2. Post grid filter view.

== Changelog ==

= 1.7.1 (11, Nov 2024) =
* [*] Check compatibility to WordPress version 6.7

= 1.7 (27, Nov 2023) =
* [*] Updated analytics SDK.
* [*] Check compatibility with WordPress version 6.4.1

= 1.6 (28, Aug 2023) =
* [*] Tested up to: 6.3

= 1.5.3 (7, Aug 2023) =
* [*] Fixed all security related issues.

= 1.5.2 (05, June 2023) =
* [-] Removed some unwanted code and files.

= 1.5.1 (02, June 2023) =
* [*] Tested up to: 6.2.2
* [*] Fix - Fixed one deprecated warning in Gutenberg block from WordPress 5.7

= 1.5 (10, April 2023) =
* [*] Tested up to: 6.2
* [*] Update - Improve escaping functions for better security.
* [*] Update - Update optin screen.

= 1.4.5 (11, Feb 2022) =
* [-] Removed some unwanted code and files.

= 1.4.4 (16, Nov 2021) =
* [*] Fix - Resolve Gutenberg WP-Editor script related issue. 
* [*] Update - Add some text and links in Readme file.

= 1.4.3 (20, Sep 2021) =
* [*] Tested up to: 5.8.1
* [*] Updated Demo Link.

= 1.4.2 (20, Aug 2021) =
* [*] Updated all external links
* [*] Tweak - Code optimization and performance improvements.
* [*] Fixed - Blocks Initializer Issue.
* [*] Updated language file and json.

= 1.4.1 (2, June 2021) =
* [*] Tested up to: 5.7.2
* [*] Added - https link in our analytics code to avoid browser security warning.

= 1.4 (28, jan 2021) =
* [+] New - Added native shortcode support for Elementor, SiteOrigin and Beaver builder.
* [+] New - Added Divi page builder native support.
* [+] New - Added Fusion page builder native support.
* [*] Tweak - Code optimization and performance improvements.

= 1.3 (29, Oct 2020) =
* [*] Update - Regular plugin maintenance. Updated readme file.
* [+] New - Click to copy the shortcode.
* [+] Added - Added our other Popular Plugins under Post Grid And Filter --> Install Popular Plugins From WPOS. This will help you to save your time during creating a website.
* [*] Tested up to latest version of WordPress.

= 1.2 (27, August 2020) =
* [+] New - Added Gutenberg block support. Now use plugin easily with Gutenberg!
* [+] New - Added 'align' and 'extra_class' parameter for slider shortcode. Now both slider shortcode are support twenty-ninteent and twenty-twenty theme gutenberg block align and additional class feature.
* [+] New - Add new JavaScript Filterize method for post filter shortcode.
* [*] Tweak - Code optimization and performance improvements.
* [*] Template File - Main design file has been updated. If you have override template file then verify with latest copy.

= 1.1.5 (14, July 2020) =
* [*] Follow WordPress Detailed Plugin Guidelines for Offload Media and Analytics Code.

= 1.1.4 (31, Dec 2019) =
* [*] Replaced wp_reset_query() with wp_reset_postdata() in both shortcodes.
* [*] Fixed image (icon) shadow issue.
* [-] Removed hire us tab from Post Grid And Filter menu.

= 1.1.3 (07, March 2019) =
* [*] Added Opt-in functionality.

= 1.1.2 (10-7-2017) =
* Fixed pagination issue

= 1.1.1 (10-7-2017) =
* Fixed missing variable issue
* Fixed some undefined function issue

= 1.1 (3-7-2017) =
* Fixed post filter issue
* Added how it work section

= 1.0 =
* Initial release.
=== RSS Enhancements for The Events Calendar ===
Contributors: room34
Donate link: http://room34.com/donation
Tags: The Events Calendar, RSS, feeds
Requires at least: 4.0
Tested up to: 6.0.3
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Customize the RSS feed in Modern Tribe's The Events Calendar plugin with date range, featured image and venue details.

== Description ==

This plugin is an add-on for Modern Tribe's The Events Calendar plugin. It modifies the RSS feed output, allowing you to specify a date range (rather than a fixed number of items), and adds the featured image and venue details into the feed.

It was created specifically to fill a need for a more highly customized display of event details in a MailChimp RSS Campaign, but may be of use for other purposes as well! To learn more about the details of the plugin and how to use it with MailChimp, see our blog post on the work that led to the plugin's creation:

[http://blog.room34.com/archives/5778](http://blog.room34.com/archives/5778)

== Installation ==

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

= 1.2.0 - 2022.10.27 =
* Added a workaround to a change in The Events Calendar 6.0.2. that appears to break the (end_date)[https://theeventscalendar.com/knowledgebase/k/crafting-custom-event-queries/#date-params] custom query. This change in 6.0.2 was causing the **Days Out** setting to be ignored.
* Changed hook for `r34ecre_rss_pre_get_posts()` to `tribe_events_parse_query` as a more reliable way to ensure it only runs on The Events Calendar queries. (This change was also needed to fix the **Days Out** issue.)
* Added logic to check if options are already set; fixes issue of resetting all options to defaults if plugin is deactivated and reactivated.
* Updated "Tested up to" to 6.0.3.

= 1.1.0 - 2021.03.23 =
* Added Image Size option.
* Added activation hook to set default options.
* Additional minor refactoring.
* Updated "Tested up to" to 5.7.

= 1.0.0.1 - 2016.12.12 =
* Updated "Tested up to" to 4.7.

= 1.0.0 - 2016.11.10 =
Initial release in WordPress Plugin Directory.

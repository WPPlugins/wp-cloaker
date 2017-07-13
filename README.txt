=== WP Cloaker ===
Contributors: WWGate
Donate link: http://www.wwgate.net/wp-cloaker-shorten-and-track-your-links/
Tags: : link cloaker, affiliate link, affiliate link management, affiliate link manager, affiliate link redirect, affiliate links, affiliate marketing, link cloak, link cloaking, link redirect, manage affiliate links, click counting, visitor information, 301 redirect, 302 redirect, link masking
Requires at least: 4.0.0
Tested up to: 4.8
Stable tag: 1.4.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP Cloaker gives you the ability to shorten your affiliate ugly links and keep track of how many clicks on each link.


== Description ==
**WP Cloaker** gives you the ability to shorten your affiliate ugly links and keep track of how many clicks on each link.
It store some information about the visitor who clicks the link like (IP address, Country, Date and Time, etc.) to help you understand your visitor better.
From the reports page you can generate reports and filter by Link Title, Month/Year, Link category OR country.

Features of **WP Cloaker** plugin:

1. Hide, shorten your links. 
2. Custom redirection type: 301,302,303,307 and Javascript redirection.
3. Categorize your links. 
4. Custom permalink prefix e.g: (go,out,visit, etc.).
5. Custom permalinks e.g : www.yoursite.com/visit/link-category-slug/link-slug. 
6. Track links clicks, each time a visitor click on any link, the plugin will store the visitor information like (IP address, click date/time, Country, etc..). 
7. Generate clicks reports with some options to filter the report.
8. Option to disable collecting data on link redirection ( it will make redirection much faster by counting just clicks/hits without any user data).
9. Top 10 links dashboard widget.
10. added option to exclude category slug from permalink.


If you have any question or features request, please don't hesitiate to contact us at support[@]wwgate.net

== Installation ==

1. Upload the wp-cloaker/ folder to the /wp-content/plugins/ directory. 
2. Activate the plugin through the 'Plugins' menu in WordPress. 
3. Visit the new 'WP Cloaker' menu and click 'Add New' to add a new link. 


== Screenshots ==

1. WP Cloaker setting page.
2. WP Cloaker reports page.
3. WP Cloaker links page.
4. WP Cloaker single link page.
5. WP Cloaker categories page.
6. Add link to a post from add new/edit post page.


== Frequently Asked Questions ==
= 1. How do I change the link's permalink structure? =
Go to setting page and change Link Prefix field, by default "visit".

= 2. How do I change the link's redirection type? =
Go to setting page and choose link redirection type you want, by default "301 redirection".

= 3. Can I set custom redirection type for one link? =
Yes, go to add new link, then check custom "Activate custom link option" and choose the redirection type you need.

= 4. Where can I find the visitor information ? =
Go to the link edit page.

= 5. Can I generate reports for links click? =
Yes, you can generate clicks reports from "Reports" page and you can filter results by Month/Year , links Category and visitor country.

= 6. Is there a way to find the link I want from add new/edit post page? =
Yes, click on insert/edit link icon,  then click on "Or link to existing content" and choose the link you want.
Check screenshot No. 6

== Changelog ==

= 1.0.0 =
Initial release.

= 1.0.1 =
1. Using [freegeoip](http://freegeoip.net/ "freegeoip") API to gather IP address information.
2. Fix: offset error if the link not assigned to a category.

= 1.0.2 =
1. New structure to the plugin files and folders.
2. Fix: update category clicks count when link category changes.
3. Add clicks reports page with month/year, link category and country filters using [google charts API](https://developers.google.com/chart/interactive/docs/gallery/linechart).
4. add new "Redirect To" column to links page.

= 1.0.3 =
added new filter to reports page, you can generate report by Link title.


= 1.0.4 =
add warning message to settings page

= 1.0.5 =
1. delete wp_cloaker_version option when uninstall.
2. wp_cloaker_clicks_count table deleted.
4. added option to disable collecting data on redirection.

= 1.0.6 =
bug: fix click details error.

= 1.1.0 =
1. Count clicks/Hits if "No" is selected for "Collect user data on redirection" option.
2. Top 10 links dashboard widget

= 1.1.1 =
1. Code improvments.

= 1.2.0 =
Bug: fix commenet not appearing in single template

= 1.3.0 =
1. add option to exclude category slug from the link permalink
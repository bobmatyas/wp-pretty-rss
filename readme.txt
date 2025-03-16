=== Pretty RSS Feeds ===
Contributors: lastsplash, brookedot
Tags: rss, feed, feeds
Requires at least: 6.0
Tested up to: 6.7.2
Requires PHP: 8.0
Stable tag: 2.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Transforms the in-browser view of feeds to make them user-friendly.

== Description ==

This plugin improves the default in-browser view of feeds to make them user-friendly. It makes it easier for human readers and adds a link to [Aboutfeeds.com](https://aboutfeeds.com/) to introduce new users to feeds.

The plugin uses `pretty-feed.xsl` to transform the feeds. 

== Installation ==

Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How does this work? =

It adds a stylesheet to apply a visual transformation to the default feed view. The stylesheet adjusts the default in-browser feed view to provide information about what a feed is and how they work.

= Are there any limitations? =

From the developer of the `pretty-feed` stylesheet:

> Styling the feed *prevents* the browser from automatically opening a newsreader application. This is a trade off, but it's a benefit to new users who won't have a newsreader installed, and they are saved from seeing or downloaded obscure XML content. For existing newsreader users, they will know to copy-and-paste the feed URL, and they get the benefit of an in-browser feed preview.

== Screenshots ==

1. An example of the styled feed after installing this plugin
2. An example of how the feed is rendered without this plugin
3. The settings for the feed display, found under Settings > Reading.

== Credits ==

* The XSL file is based on [pretty-rss v3](https://github.com/genmon/aboutfeeds/blob/main/tools/pretty-feed-v3.xsl) by Matt Webb.
* Darek Kay has [a great article on styling feeds](https://darekkay.com/blog/rss-styling/) using this method on their blog.
* CSS insperation from [Dave Rupert's feed](https://daverupert.com/atom.xml).
* This plugins uses the [ArrayToXML](https://github.com/spatie/array-to-xml) class by Spatie

== Changelog ==

= 2.0.0 =
* Added basic style options Under Settings > Reading
* Changed the default styles and added an external stylesheet
* Refactored the codebase

= 1.0.0 =
* Initial release
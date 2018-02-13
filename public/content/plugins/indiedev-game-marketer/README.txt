=== IndieDev Game Marketer ===
Contributors: blacklodgegames 
Donate link: https://blacklodgegames.com
Tags: game,games,indiedev,gamedev,development,marketing,steam,promo,promotion,press,presskit,press kit
Requires at least: 4.0.0
Tested up to: 4.8.0
Stable tag: 1.0.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Promote indie games for all platforms using the power & familiarity of Wordpress.

== Description ==

[youtube https://www.youtube.com/watch?v=fqj8lsjzLmw]

Creating a good game is hard, but that's only half the battle. If you don't market your game, no one will play it! 
Indiedev Game Marketer is an open source Wordpress plugin, forever free and forever without a premium version to buy. 
Why? Because making a good game is hard, but making a good marketing campaign is even harder. It is my hope that this 
plugin will help developers more affectively market their games, without increasing the cost of marketing. 

Are you an indie game developer, publisher, or marketer who is using Wordpress? If so, this open source 
Wordpress plugin is designed to make marketing video games easier.

*   Fill out the forms, upload your game's promotional media, and make presskits for your games.
*   Write, and publish,Press Releases from within the Wordpress admin panel.
*   Automate posting your screenshots onto Twitter on #screenshotsaturday as well as other daily #indiedev #gamedev hashtags
*   Open your game's Steam Greenlight page in the Steam client to bypass Steam Guard
*   Uses native Wordpress shortcodes, custom post types, and custom taxonomy so that you can easily integrate content from this plugin into your themes and other plugins.
*   No PRO version to buy, now or ever.  This is a true open source project licensed under the GPL 2 license
*   i18n compatible for translations to different languages.

== Installation ==

1. Upload `indiedev-game-marketer.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Click on the Settings button, or in the admin menu, click on IndieDev Game Marketer
1. Follow the Configuration guide here to continue: https://blacklodgegames.com/indiedev-game-marketer-wp-plugin-for-wordpress/

== Frequently Asked Questions ==

= Ask us some questions! =

After we get enough, I'll update the FAQ with the most frequently asked questions.

== Screenshots ==

1. Promote indie games for all platforms using the power & familiarity of Wordpress.

== Changelog ==

= 1.0.7 =
* 8th beta release
* Changed: 4.8.0 support & minor texts edit regarding Greenlight (which was recently retired.)

= 1.0.6 =
* 7th beta release
* Fixed: Patched an issue where TinyMCE buttons were not functioning due to this plugin

= 1.0.5 =
* 6th beta release
* Fixed: Patched an incompatibility between WooCommerce and IndieDev Game Marketer
* Fixed: Disabled all IndieDev Game Marketer CSS and JS in the admin panel unless on the actual settings page
* Fixed: Attempted to solve an issue regarding /admin/class-indiedev-game-marketer-admin.php on line 1679 - Changed array initialization.
* Fixed: Removed externally hosted css file (google cdn) and instead included it with the plugin to reduce external domain calls


= 1.0.4 =
* 5th beta release
* Fixed: Patched a regression that caused multisite to fail on 1.0.3

= 1.0.3 =
* 4th beta release.
* Added: Each game platform can now have a URL associated with it.  On the presskit, each platform with a provided URL will be hyperlinked to that URL.
* Fixed: Patched a problem where settings only created usable links when using the complete syntax, i.e. "http://" must preface the URL.  You can omit or include the http or https without consequence.
* Fixed: Now you can enter the Company Facebook and Twitter URL settings in most manners and still get a usable link on presskits and in shortcodes.
* Fixed: Patched an issue where Greenlight URLs were not loading into the Edit Game form, causing them to be lost after editing games.
* Fixed: Corrected an issue where the Game Engine wasn't saving and also wasn't displaying on the presskit even when saved.
* Fixed: In Chrome on presskits, using the default CSS, multiple columns were spilling over.  The CSS was updated and now seems to properly work on Chrome.

= 1.0.2 =
* 3rd beta release.
* Updated: There is now a .pot file in the /languages/ directory for i18n translations.

= 1.0.1 =
* 2nd beta release.
* Fixed: Added support for WordPress MultiSite installations, including Network Activation
* Added: Upgrading functionality added, including database versioning.
* Fixed: Removed several warnings
* Updated: readme.txt cleaned up a bit more

= 1.0.0 =
* Initial beta release.

== Upgrade Notice ==

= 1.0 =
None

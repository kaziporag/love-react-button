=== Love React Button ===
Contributors: kazirabiul  
Donate link: https://kazirabiul.com  
Tags: like button, reactions, heart, shortcode, elementor, ajax  
Requires at least: 5.0  
Tested up to: 6.5.3  
Requires PHP: 7.4  
Stable tag: 1.0.0  
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html  

Adds a lightweight, circular heart-and-count “Love React” button to any post, page, or custom post type.  
Zero dependencies beyond jQuery, works instantly via the `[love_react]` shortcode, and includes an optional Elementor widget for drag-and-drop use.

== Description ==

Love React Button lets visitors “💗 love” your content with a single click and shows the total count beside a heart icon.  
* **Blazing-fast AJAX** — no page reloads.  
* **Cookie-based throttling** — stops duplicate votes from the same browser.  
* **Elementor-ready** — (widget auto-registers when Elementor is active).  
* **Customisable** — drop in your own SVG or style the `.love-react-btn` class.  
* **Developer-friendly** — clean OOP‐ready code, nonces, escaping, and hooks.

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/` or install directly from **Plugins ▷ Add New**.  
2. Activate **Love React Button** through the *Plugins* menu.  
3. Insert `[love_react]` anywhere in the editor **or** drag the *Love React* widget into an Elementor section.  
4. (Optional) Pass a specific post ID&mdash;`[love_react id="123"]`.

== Usage ==

* **Default (current loop post)**  
  `[love_react]`
* **Specific post/page**  
  `[love_react id="42"]`
* Style with CSS:  
  `.love-react-btn { /* your rules */ }`

== Frequently Asked Questions ==

= Does it work with caching plugins? =  
Yes. The counter is updated via `admin-ajax.php`, so full-page caching won’t interfere.

= Can a user unlike a post? =  
Not in v1.0.0&mdash;the click is “love once per browser”. Toggle support is on the roadmap.

= Where are counts stored? =  
In the post meta key `_love_react_count`.

== Screenshots ==

1. Default circular heart button with counter.  
2. Elementor widget in the editor (optional).  
3. Example placement under a blog post title.

== Changelog ==

= 1.0.0 – 27 May 2025 =  
* Initial release: shortcode, AJAX handler, cookie lock, asset enqueue, and Elementor widget loader.

== Upgrade Notice ==

= 1.0.0 =  
First public release. Simply install and activate.
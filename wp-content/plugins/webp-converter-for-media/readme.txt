=== WebP Converter for Media ===
Contributors: mateuszgbiorczyk
Donate link: https://ko-fi.com/gbiorczyk/
Tags: webp, images, performance, compress, optimize
Requires at least: 5.0
Tested up to: 5.3
Requires PHP: 7.0
Stable tag: trunk
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Speed up your website by serving WebP images instead of standard formats JPEG, PNG and GIF.

== Description ==

Speed up your website by serving WebP images. By replacing files in standard JPEG, PNG and GIF formats with WebP format, you can save over a half of the page weight without losing quality.

When installing a plugin you do not have to do anything more. Your current images will be converted into a new format. Users will automatically receive new, much lighter images than the original ones.

As of today, nearly 80% of users use browsers that support the WebP format. The loading time of your website depends to a large extent on its weight. Now you can speed up it in a few seconds without much effort!

This will be a profit both for your users who will not have to download so much data, but also for a server that will be less loaded. Remember that a better optimized website also affects your Google ranking.

#### How does this work?

- By adding images to your media library, they are automatically converted and saved in a separate directory.
- If you have just installed the plugin, you can convert all existing images with one click.
- Images are converted using PHP `GD` or `Imagick` extension *(you can modify the compression level)*.
- When the browser tries to download an image file, the server verifies if it supports `image/webp` files and if the file exists.
- If everything is OK, instead of the original image, the browser will receive its equivalent in WebP format.
- **The plugin does not change image URLs, so there are no problems with saving the HTML code of website to the cache and time of its generation does not increase.** It does not matter if the image display as an `img` HTML tag or you use `background-image`. It works always!
- Image URLs are modified using the module `mod_rewrite` on the server, i.e. the same, and thanks to this we can use friendly links in WordPress. Additionally, the MIME type of the sent file is modified to `image/webp`.
- The final result is that your users download less than half of the data, and the website itself loads faster!

#### WebP images are the future!

Raise your website to a new level now! Install the plugin and enjoy the website that loads faster. Surely you and your users will appreciate it.

#### Please also read the FAQ below. Thank you for being with us!

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/webp-converter-for-media/` directory, or install plugin through the WordPress plugins screen directly.
2. Activate plugin through `Plugins` screen in WordPress Admin Panel.
3. Use `Settings -> Settings -> WebP Converter` screen to configure the plugin.
4. Click on the button `Regenerate All`.
5. Check if everything works fine.

That's all! Your website is already loading faster!

== Frequently Asked Questions ==

= What are the requirements of the plugin? =

Practically every hosting meets these requirements. You must use PHP at least 7.0 and have the `GD` or `Imagick` extension installed. **The extension must support `WebP format` *(you can check it using `phpinfo()` function)*.**

An example of the correct server configuration can be found [here](https://gbiorczyk.pl/webp-converter/serverinfo.png).

These are native PHP extensions, used among others by WordPress to generate thumbnails. Your server must also have the modules `mod_mime`, `mod_rewrite` and `mod_expires` enabled.

If your configuration is different, please contact your server administrator. He is the most competent to solve such problems. Due to the huge amount of possible server environments, we are not able to help you with its configuration. Surely the server administrator will be able to do it best.

Also REST API must be enabled and work without additional restrictions.

= Configuration for Nginx =

Please edit the configuration file:

`/etc/nginx/mime.types`

and add this code:

`types {`
`  # ...

  image/webp webp;
}`

Then please find your configuration file in the path *(default is default file)*:

`/etc/nginx/sites-available/`

and add below code in this file:

`server {`
`  # ...

  location ~ (?<root>.+)/uploads/(?<path>.+)\.(?<ext>jp?g|png|gif)$ {
    if ($http_accept !~* "image/webp") {
      break;
    }
    add_header Vary Accept;
    expires 365d;
    try_files $root/uploads-webpc/$path.$ext.webp $uri =404;
  }
}`

= How can I convert existing images after installing? =

In the WordPress admin panel, on the `Settings -> WebP Converter` subpage there is a module that allows you to process all your images.

It uses the WordPress REST API by downloading addresses of all images and converting all files gradually.

This process may take few or more than ten minutes depending on the number of files.

= What are the restrictions? =

The size of the image is a limited. Its resolution cannot be bigger than `8192 x 8192px`. This is due to the limitations of the PHP library.

Please remember that **Safari and Internet Explorer do not support the WebP format**. Therefore, using these browsers you will receive original images.

You can find more about WebP support by browsers [here](https://caniuse.com/#feat=webp).

= Where are the converted images stored? =

All WebP images are stored in the `/wp-content/uploads-webpc/` directory. Inside the directory there is the same structure as in the original `uploads` directory. The files have original extensions in the name along with the new `.webp`.

In case the location of the original file is as follows: `/wp-content/uploads/2019/06/example.jpg` then its converted version will be in the following location: `/wp-content/uploads-webpc/2019/06/example.jpg.webp`.

Original images are not changed.

= How to change path to uploads? =

This is possible using two filters. You can change the path of the default uploads directory and directory in which WebP files will be stored.

Remember that this is the relative path of the domain. You can not change the domain there.

Here is an example using default paths:

`add_filter('webpc_uploads_path', function($path) {
  return 'wp-content/uploads';
});`

`add_filter('webpc_uploads_webp', function($path) {
  return 'wp-content/uploads-webpc';
});`

Filter `webpc_uploads_path` modifies the default path to the original uploads files. And filter `webpc_uploads_webp` changes the path where WebP files will be saved.

Then go to `Settings -> WebP Converter` in the admin panel and click the `Save Changes` button. Also remember to regenerate all images using the `Regenerate All` button.

= How to check if plugin works? =

When you have installed plugin and converted all images, follow these steps:

1. Run `Google Chrome` and enable `Dev Tools` *(F12)*.
2. Go to the `Network` tab and select filtering for `Img` *(Images)*.
3. Refresh your website page.
4. Check list of loaded images. Note `Type` column.
5. If value of `webp` is there, then everything works fine.
6. Remember that this plugin does not change URLs. This means that e.g. link will have path to .jpg file, but `.jpg.webp file will be loaded instead of original .jpg`.
7. In addition, you can check weight of website before and after using plugin. The difference will be huge!
8. More information: [here](https://gbiorczyk.pl/webp-converter/check-devtools.png)

Please remember that if the converted image in WebP format is larger than the original, the browser will use the original file. Therefore, you can also see files other than WebP on the list.

= Can I enable browser caching for WebP images? =

Yes of course. The plugin allows this by using the module `mod_expires`. Thanks to this, we can even speed up page loading time for returning users because they do not need to re-download files from the server.

If you do not want to use this functionality, you can turn it off at any time.

= Does the plugin support CDN? =

Unfortunately not. This is due to the logic of the plugin's operation. Plugins that enable integration with the CDN servers modify the HTML of the website, changing URLs for media files. This plugin does not modify URLs. Replacing URLs in the HTML code is not an optimal solution.

The main problem when changing URLs is cache. When we modify the image URL for WebP supporting browser, then use the browser without WebP support, it will still have the URL address of an image in .webp format, because it will be in the cache.

While in the case of the `img` tag you can solve this problem, in the case of `background-image` it is possible. We wanted full support so that all images added to the media library would be supported - no matter how they are displayed on the website.

Therefore in this plugin for browsers supporting the WebP format, only the source of the file is replaced by using the `mod_rewrite` module on the server. The URL for image remains the same. This solves the whole problem, but it is impossible to do when the files are stored on the CDN server.

If you are using a CDN server, find one that automatically converts images to WebP format and properly sends the correct image format to the browser.

= Does the plugin work in Multisite Network? =

Yes, with one exception. In this mode it is not possible to automatically generate the contents of .htaccess file.

Please manually paste the following code **at the beginning of .htaccess file**:

`# BEGIN WebP Converter`
`<IfModule mod_mime.c>
  AddType image/webp .webp
</IfModule>
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteCond %{HTTP_ACCEPT} image/webp
  RewriteCond %{DOCUMENT_ROOT}/wp-content/uploads-webpc/$1.jpg.webp -f
  RewriteRule wp-content/uploads/(.+)\.jpg$ wp-content/uploads-webpc/$1.jpg.webp [T=image/webp]
  RewriteCond %{HTTP_ACCEPT} image/webp
  RewriteCond %{DOCUMENT_ROOT}/wp-content/uploads-webpc/$1.jpeg.webp -f
  RewriteRule wp-content/uploads/(.+)\.jpeg$ wp-content/uploads-webpc/$1.jpeg.webp [T=image/webp]
  RewriteCond %{HTTP_ACCEPT} image/webp
  RewriteCond %{DOCUMENT_ROOT}/wp-content/uploads-webpc/$1.png.webp -f
  RewriteRule wp-content/uploads/(.+)\.png$ wp-content/uploads-webpc/$1.png.webp [T=image/webp]
</IfModule>
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType image/webp "access plus 1 year"
</IfModule>`
`# END WebP Converter`

= How to get technical support? =

We are happy to help you with any problem. Contact us about this matter.

Please always adding your thread, read plugin FAQ and other threads in support forum first. Perhaps someone had a similar problem and it has been resolved.

This will save time repeating the same issues many times and solving the same problems.

If you do not find anything and you still have a problem, then contact us. So that we can better help you need additional information.

When adding a thread, follow these steps and reply to each of them:

**1.** Does your server meet the technical requirements described in the FAQ?

**2.** Do you use CDN? If so, please see the question **"Does the plugin support CDN?"** in plugin FAQ.

**3.** Do you use other plugins to optimize images? Please disable them and check this plugin without them. Remember not to combine several optimization plugins because they can be mutually exclusive.

**4.** Check if in `/wp-content/uploads-webpc/` directory are all files that should be converted.

If not, please enable `WP_DEBUG_LOG` in your `wp-config.php` *(more about debugging: [https://codex.wordpress.org/WP_DEBUG](https://codex.wordpress.org/WP_DEBUG))*. That's what you should have in this file:

`define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);`

Then follow these steps:

> 1. Go to administration panel and go to plugin settings page.
2. Run Google Chrome and enable Dev Tools *(F12)*.
3. Go to the Network tab and select filtering for `XHR` *(XHR and Fetch)*.
4. Click button `Regenerate All` on the plugin settings page *(do not close the console during this time)*.
5. Go to Dev Tools and find request that is marked in red. Click on them and go to `Preview` tab.
6. Take screenshot of all information presented there.
7. Please check also if you have any errors in `/wp-content/debug.log`?

Send a screenshot from console if an error occurred while converting images. Of you have errors in `/wp-content/debug.log` send their?

**5.** URL of your website. If your site is not publicly available, add it to test environment.

**6.** Configuration of your server *(link to it can be found on the settings page of plugin in the **"We are waiting for your message"** section)* - please take a screenshot of the ENTIRE page and send it to me.

Directly URL: `/wp-admin/options-general.php?page=webpc_admin_page&action=server`

**7.** Content of your `.htaccess` file.

**8.** What plugin version are you using? If it is not the latest then update and check everything again. Please also provide the version of WordPress and the list of plugins you use.

Please remember to include the answers for all 8 questions by adding a thread. It is much easier and accelerate the solution of your problem.

And most importantly - **do not leave the thread unanswered**. If you add a thread, follow when you get a reply. Then let us know if we have helped you or not. This helps us improve technical support.

= Is the plugin completely free? =

Yes. The plugin is completely free.

However, working on plugins and technical support requires many hours of work. If you want to appreciate it, you can [provide us a coffee](https://ko-fi.com/gbiorczyk/). Thanks everyone!

Thank you for all the ratings and reviews.

If you are satisfied with this plugin, please recommend it to your friends. Every new person using our plugin is valuable to us.

This is all very important to us and allows us to do even better things for you!

== Screenshots ==

1. Screenshot of the options panel
2. Screenshot when regenerating images

== Changelog ==

= 1.0.9 (2020-01-03) =
* `[Added]` Limit of maximum image resolution limit using `GD` library

= 1.0.8 (2019-12-19) =
* `[Fixed]` File deletion for custom paths with converted WebP files
* `[Changed]` Rules management in .htaccess file when activating/deactivating plugin
* `[Added]` Error detection system in server configuration
* `[Added]` Blocking image conversion when `GD` or `Imagick` libraries are unavailable

= 1.0.7 (2019-12-17) =
* `[Changed]` Rewrite rules in .htaccess file
* `[Added]` Custom path support for original uploads files
* `[Added]` Custom path support for saving converted WebP files
* `[Added]` Filter `webpc_uploads_path` to change path for original uploads files
* `[Added]` Filter `webpc_uploads_webp` to change path for saving converted WebP files

= 1.0.6 (2019-11-06) =
* `[Changed]` Way of generating file path _(without `ABSPATH`)_
* `[Added]` Automatic deletion of converted files larger than original

= 1.0.5 (2019-09-16) =
* `[Added]` Information on available FAQ

= 1.0.4 (2019-07-11) =
* `[Changed]` Limits of maximum execution time

= 1.0.3 (2019-06-26) =
* `[Added]` Additional security rules

= 1.0.2 (2019-06-25) =
* `[Changed]` Error messages
* `[Added]` Tab in Settings page about server configuration

= 1.0.1 (2019-06-23) =
* `[Changed]` Securing access to REST API
* `[Added]` Error handler for undefined `GD` extension

= 1.0.0 (2019-06-16) =
* The first stable release

== Upgrade Notice ==

None.
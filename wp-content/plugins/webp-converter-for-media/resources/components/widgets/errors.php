<?php if ($errors = apply_filters('webpc_server_errors', [])) : ?>
  <div class="webpPage__widget">
    <h3 class="webpPage__widgetTitle webpPage__widgetTitle--error">
      <?= __('Server configuration error', 'webp-converter'); ?>
    </h3>
    <div class="webpContent">
      <?php if (in_array('path_uploads', $errors)) : ?>
        <p>
          <?= sprintf(
            __('The path for uploads files does not exist. Please use the %s filter to set the correct path. The default path is: %s.', 'webp-converter'),
            '<strong>webpc_uploads_path</strong>',
            '<strong>' . ABSPATH . 'wp-content/uploads/</strong>'
          ); ?>
        </p>
      <?php endif; ?>
      <?php if (in_array('path_webp', $errors)) : ?>
        <p>
          <?= sprintf(
            __('The path for saving converted WebP files does not exist and cannot be created. Please check your server configuration and try again. The default path is: %s.', 'webp-converter'),
            '<strong>' . ABSPATH . 'wp-content/uploads-webpc/</strong>'
          ); ?>
        </p>
      <?php endif; ?>
      <?php if (in_array('rest_api', $errors)) : ?>
        <p>
          <?= sprintf(
            __('The REST API on your website is not available. Please verify this and try again. Pay special attention to the filters: %s, %s and %s.', 'webp-converter'),
            '<a href="https://developer.wordpress.org/reference/hooks/rest_enabled/" target="_blank">rest_enabled</a>',
            '<a href="https://developer.wordpress.org/reference/hooks/rest_jsonp_enabled/" target="_blank">rest_jsonp_enabled</a>',
            '<a href="https://developer.wordpress.org/reference/hooks/rest_authentication_errors/" target="_blank">rest_authentication_errors</a>'
          ); ?>
        </p>
      <?php endif; ?>
      <?php if (in_array('methods', $errors)) : ?>
        <p>
          <?= sprintf(
            __('On your server is not installed %sGD%s or %sImagick%s library, or installed extension does not support WebP format. Please check your server configuration and try again.', 'webp-converter'),
            '<strong>', '</strong>', '<strong>', '</strong>'
          ); ?>
        </p>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>
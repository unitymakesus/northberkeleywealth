<?php
  $apiPaths      = apply_filters('webpc_rest_api_paths', '');
  $apiRegenerate = apply_filters('webpc_rest_api_regenerate', '');
?>
<div class="webpPage__widget">
  <h3 class="webpPage__widgetTitle">
    <?= __('Regenerate images', 'webp-converter'); ?>
  </h3>
  <div class="webpLoader webpContent"
    data-api-paths="<?= $apiPaths; ?>" data-api-regenerate="<?= $apiRegenerate; ?>">
    <div class="webpPage__widgetRow">
      <p>
        <?= __('Convert all existing images with just one click! This tool uses the WordPress REST API by downloading addresses of all images and converting all files gradually. This is a process that may take a few or more than ten minutes depending on the number of files. During this process, please do not close your browser window.', 'webp-converter'); ?>
      </p>
      <div class="webpLoader__status" hidden>
        <div class="webpLoader__bar">
          <div class="webpLoader__barProgress" data-percent="0">
            <div class="webpLoader__barCount"></div>
          </div>
          <div class="webpLoader__size">
            <?= sprintf(
              __('Saving the weight of your images: %s', 'webp-converter'),
              '<span class="webpLoader__sizeProgress">0 kB</span>'
            ); ?>
          </div>
        </div>
        <div class="webpLoader__success" hidden>
          <?= __('The process was completed successfully. Your images have been converted!', 'webp-converter'); ?>
        </div>
        <div class="webpLoader__errors" hidden>
          <div class="webpLoader__errorsTitle"><?= __('List of errors', 'webp-converter'); ?></div>
          <div class="webpLoader__errorsContent">
            <div class="webpLoader__errorsContentList"></div>
            <div class="webpLoader__errorsContentMessage" hidden>
              <?= __('An error occurred while connecting to REST API. Please try again.', 'webp-converter'); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="webpPage__widgetRow">
      <button type="button" target="_blank"
        class="webpLoader__button webpButton webpButton--green"
        <?= (apply_filters('webpc_server_errors', [])) ? 'disabled' : ''; ?>>
        <?= __('Regenerate All', 'webp-converter'); ?>
      </button>
    </div>
  </div>
</div>
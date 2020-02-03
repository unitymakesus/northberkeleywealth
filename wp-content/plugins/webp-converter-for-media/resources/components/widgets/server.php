<?php
  $pageUrl = menu_page_url('webpc_admin_page', false);
  $info    = apply_filters('webpc_server_info', '');
?>
<div class="webpPage__widget">
  <h3 class="webpPage__widgetTitle webpPage__widgetTitle--second">
    <?= __('Your server configuration', 'webp-converter'); ?>
  </h3>
  <div class="webpContent">
    <div class="webpPage__widgetRow">
      <a href="<?= $pageUrl; ?>" class="webpLoader__button webpButton webpButton--blue">
        <?= __('Back to settings', 'webp-converter'); ?>
      </a>
    </div>
    <div class="webpPage__widgetRow">
      <div class="webpServerInfo"><?= $info; ?></div>
    </div>
    <div class="webpPage__widgetRow">
      <a href="<?= $pageUrl; ?>" class="webpLoader__button webpButton webpButton--blue">
        <?= __('Back to settings', 'webp-converter'); ?>
      </a>
    </div>
  </div>
</div>
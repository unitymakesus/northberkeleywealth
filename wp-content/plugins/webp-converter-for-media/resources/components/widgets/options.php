<div class="webpPage__widget">
  <h3 class="webpPage__widgetTitle">
    <?= __('Settings', 'webp-converter'); ?>
  </h3>
  <div class="webpContent">
    <?php foreach ($options as $index => $option) : ?>
      <div class="webpPage__widgetRow">
        <h4><?= $option['label']; ?></h4>
        <?php include WEBPC_PATH . '/resources/components/fields/' . $option['type'] . '.php'; ?>
      </div>
    <?php endforeach; ?>
    <div class="webpPage__widgetRow">
      <button type="submit" name="webpc_save"
        class="webpButton webpButton--green"><?= __('Save Changes', 'webp-converter'); ?></button>
    </div>
    <div class="webpPage__widgetRow">
      <p>
        <?= sprintf(
          __('If you have a problem %scheck our FAQ%s first. If you did not find help there, please %scheck support forum%s for any similar problem or contact us.', 'webp-converter'),
          '<a href="https://wordpress.org/plugins/webp-converter-for-media/#faq" target="_blank">',
          '</a>',
          '<a href="https://wordpress.org/support/plugin/webp-converter-for-media/" target="_blank">',
          '</a>'
        ); ?>
      </p>
    </div>
  </div>
</div>
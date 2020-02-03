<?php
  $infoUrl = menu_page_url('webpc_admin_page', false) . '&action=server';
?>
<div class="webpPage__widget">
  <h3 class="webpPage__widgetTitle webpPage__widgetTitle--second">
    <?= __('We are waiting for your message', 'webp-converter'); ?>
  </h3>
  <div class="webpContent">
    <p>
      <?= __('Do you have a technical problem? Please contact us. We will be happy to help you. Or maybe you have an idea for a new feature? Please let us know about it by filling the support form. We will try to add it!', 'webp-converter'); ?>
    </p>
    <p>
      <?= sprintf(
        __('Please %scheck our FAQ%s before adding a thread with technical problem. If you do not find help there, %scheck support forum%s for similar problems. Please remember to attach %sserver configuration%s in your message, e.g. as a screenshot.', 'webp-converter'),
        '<a href="https://wordpress.org/plugins/webp-converter-for-media/#faq" target="_blank">',
        '</a>',
        '<a href="https://wordpress.org/support/plugin/webp-converter-for-media/" target="_blank">',
        '</a>',
        '<a href="' . $infoUrl . '">',
        '</a>'
      ); ?>
    </p>
    <p>
      <a href="https://wordpress.org/support/plugin/webp-converter-for-media/" target="_blank" class="webpButton webpButton--blue">
        <?= __('Get help', 'webp-converter'); ?>
      </a>
    </p>
    <p>
      <?= __('Do you like our plugin? Could you rate him? Please let us know what you think about our plugin. It is important that we can develop this tool. Thank you for all the ratings, reviews and donates.', 'webp-converter'); ?>
    </p>
    <p>
      <a href="https://wordpress.org/support/plugin/webp-converter-for-media/reviews/#new-post" target="_blank" class="webpButton webpButton--blue">
        <?= __('Add review', 'webp-converter'); ?>
      </a>
    </p>
  </div>
</div>
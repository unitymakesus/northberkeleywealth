<?php

  namespace WebpConverter\Admin;

  class Activation
  {
    public function __construct()
    {
      register_activation_hook(WEBPC_FILE, [$this, 'disablePluginForOldPhp']);
      register_activation_hook(WEBPC_FILE, [$this, 'addDefaultOptions']);
      register_activation_hook(WEBPC_FILE, [$this, 'refreshRewriteRules']);
    }

    /* ---
      Functions
    --- */

    public function disablePluginForOldPhp()
    {
      if (version_compare(PHP_VERSION, '5.6.12', '>=')) return;

      deactivate_plugins(basename(WEBPC_FILE));
      wp_die(sprintf(
        __('%sWebP Converter for Media%s plugin requires a minimum PHP %s version. Sorry about that!', 'webp-converter'),
        '<strong>',
        '</strong>',
        $this->version
      ));
    }

    public function addDefaultOptions()
    {
      if (get_option('webpc_notice_hidden', false) === false) {
        add_option('webpc_notice_hidden', strtotime('+ 1 week'));
      }
    }

    public function refreshRewriteRules()
    {
      flush_rewrite_rules(true);
    }
  }
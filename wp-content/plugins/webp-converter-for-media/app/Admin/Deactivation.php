<?php

  namespace WebpConverter\Admin;

  class Deactivation
  {
    public function __construct()
    {
      register_deactivation_hook(WEBPC_FILE, [$this, 'refreshRewriteRules']);
    }

    /* ---
      Functions
    --- */

    public function refreshRewriteRules()
    {
      flush_rewrite_rules(true);
    }
  }
<?php

  namespace WebpConverter\Settings;

  class Paths
  {
    private $source = 'wp-content/uploads', $output = 'wp-content/uploads-webpc';

    public function __construct()
    {
      add_filter('webpc_uploads_path', [$this, 'getSourcePath'], 0);
      add_filter('webpc_uploads_webp', [$this, 'getOutputPath'], 0);
      add_filter('webpc_uploads_path', [$this, 'parsePath'], 100);
      add_filter('webpc_uploads_webp', [$this, 'parsePath'], 100);
    }

    /* ---
      Functions
    --- */

    public function getSourcePath($value)
    {
      return $this->source;
    }

    public function getOutputPath($value)
    {
      return $this->output;
    }

    public function parsePath($value)
    {
      return trim($value, '\/');
    }
  }
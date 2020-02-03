<?php

  namespace WebpConverter\Settings;

  class Errors
  {
    public function __construct()
    {
      add_filter('webpc_server_errors', [$this, 'getServerErrors']);
    }

    /* ---
      Functions
    --- */

    public function getServerErrors()
    {
      $list = [
        'path_uploads' => ($this->ifUploadsPathExists() !== true),
        'path_webp'    => ($this->ifWebpPathExists() !== true),
        'rest_api'     => ($this->ifRestApiEnabled() !== true),
        'methods'      => ($this->ifMethodsAvailable() !== true),
      ];
      return array_keys(array_filter($list));
    }

    private function ifUploadsPathExists()
    {
      $path = ABSPATH . apply_filters('webpc_uploads_path', '');
      return (is_dir($path) && ($path !== ABSPATH));
    }

    private function ifWebpPathExists()
    {
      $path = ABSPATH . apply_filters('webpc_uploads_webp', '');
      return ((is_dir($path) || is_writable(dirname($path))) && ($path !== ABSPATH));
    }

    private function ifRestApiEnabled()
    {
      return ((apply_filters('rest_enabled', true) === true)
        && (apply_filters('rest_jsonp_enabled', true) === true)
        && (apply_filters('rest_authentication_errors', true) === true));
    }

    private function ifMethodsAvailable()
    {
      $config  = apply_filters('webpc_get_values', []);
      $methods = apply_filters('webpc_get_methods', []);
      return (isset($config['method']) && in_array($config['method'], $methods));
    }
  }
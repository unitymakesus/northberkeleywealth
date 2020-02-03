<?php

  namespace WebpConverter\Admin;

  class Uninstall
  {
    public function __construct()
    {
      register_uninstall_hook(WEBPC_FILE, ['WebpConverter\Admin\Uninstall', 'removePluginSettings']);
    }

    /* ---
      Functions
    --- */

    public static function removePluginSettings()
    {
      delete_option('webpc_settings');
      delete_option('webpc_notice_hidden');

      self::removeWebpFiles();
    }

    public static function removeWebpFiles()
    {
      $path    = ABSPATH . apply_filters('webpc_uploads_webp', 'wp-content/uploads-webpc');
      $paths   = self::getPathsFromLocation($path);
      $paths[] = $path;
      self::removeFiles($paths);
    }

    private static function getPathsFromLocation($path, $paths = [])
    {
      if (!file_exists($path)) return $paths;
      $path .= '/';
      $files = glob($path . '*');
      foreach ($files as $file) {
        if (is_dir($file)) $paths = self::getPathsFromLocation($file, $paths);
        $paths[] = $file;
      }
      return $paths;
    }

    private static function removeFiles($paths)
    {
      if (!$paths) return;
      foreach ($paths as $path) {
        if (!is_writable($path) || !is_writable(dirname($path))) continue;
        if (is_file($path) && (pathinfo($path, PATHINFO_EXTENSION) === 'webp')) unlink($path);
        else if (is_dir($path)) rmdir($path);
      }
    }
  }
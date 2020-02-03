<?php

  namespace WebpConverter\Media;
  use WebpConverter\Convert as Convert;

  class Upload
  {
    public function __construct()
    {
      add_filter('wp_update_attachment_metadata', [$this, 'initAttachmentConvert'], 10, 2);
    }

    /* ---
      Functions
    --- */

    public function initAttachmentConvert($data, $attachmentId)
    {
      if (!$data || !isset($data['file']) || !isset($data['sizes'])) return $data;
      $path  = $this->getAttachmentDirectory($data['file']);
      $sizes = [];

      $sizes['_source'] = $path . basename($data['file']);
      foreach ($data['sizes'] as $key => $size) {
        $url = $path . $size['file'];
        if (in_array($url, $sizes)) continue;
        $sizes[$key] = $url;
      }

      $sizes = apply_filters('webpc_attachment_paths', $sizes, $attachmentId);
      $this->convertSizes($sizes);
      return $data;
    }

    private function getAttachmentDirectory($path)
    {
      $upload = wp_upload_dir();
      $source = rtrim($upload['basedir'], '/\\') . '/' . rtrim(dirname($path), '/\\') . '/';
      $source = str_replace('\\', '/', $source);
      return $source;
    }

    private function convertSizes($paths)
    {
      $settings = apply_filters('webpc_get_values', []);

      if ($settings['method'] === 'gd') $convert = new Convert\Gd();
      else if ($settings['method'] === 'imagick') $convert = new Convert\Imagick();
      if (!isset($convert)) return false;

      foreach ($paths as $path) {
        if (!in_array(pathinfo($path, PATHINFO_EXTENSION), $settings['extensions'])) continue;

        $response = $convert->convertImage($path, $settings['quality']);
        if (!$response['success']) $this->addErrorToLog($response['message']);
      }
    }

    private function addErrorToLog($message)
    {
      error_log(sprintf(
        'WebP Converter: %s',
        $message
      ));
    }
  }
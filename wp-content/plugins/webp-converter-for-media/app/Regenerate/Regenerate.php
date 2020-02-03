<?php

  namespace WebpConverter\Regenerate;
  use WebpConverter\Convert as Convert;

  class Regenerate
  {
    /* ---
      Functions
    --- */

    public function convertImages($paths)
    {
      $settings   = apply_filters('webpc_get_values', []);
      $errors     = [];
      $sizeBefore = 0;
      $sizeAfter  = 0;

      if ($settings['method'] === 'gd') $convert = new Convert\Gd();
      else if ($settings['method'] === 'imagick') $convert = new Convert\Imagick();
      if (!isset($convert)) return false;

      foreach ($paths as $path) {
        $response = $convert->convertImage($path, $settings['quality']);
        if ($response['success'] && !$this->checkFileSize($response['data'])) continue;

        if ($response['success'] !== true) {
          $errors[] = $response['message'];
        } else {
          $sizeBefore += $response['data']['size']['before'];
          $sizeAfter  += $response['data']['size']['after'];
        }
      }

      return [
        'errors' => $errors,
        'size'   => [
          'before' => $sizeBefore,
          'after'  => $sizeAfter,
        ],
      ];
    }

    private function checkFileSize($data)
    {
      if ($data['size']['after'] < $data['size']['before']) return true;
      unlink($data['path']);
      return false;
    }
  }
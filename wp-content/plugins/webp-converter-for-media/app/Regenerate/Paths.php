<?php

  namespace WebpConverter\Regenerate;

  class Paths
  {
    /* ---
      Functions
    --- */

    public function getPaths()
    {
      $sizes = get_intermediate_image_sizes();
      $posts = get_posts([
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'fields'         => 'ids',
      ]);

      $list = $this->parseImages($posts, $sizes);
      wp_send_json_success($list);
    }

    private function parseImages($posts, $sizes)
    {
      $settings = apply_filters('webpc_get_values', []);
      $upload   = wp_upload_dir();
      $list     = [];
      if (!$posts) return $list;

      foreach ($posts as $postId) {
        $metadata = wp_get_attachment_metadata($postId);
        if (!isset($metadata['file'])
          || !in_array(pathinfo($metadata['file'], PATHINFO_EXTENSION), $settings['extensions'])) continue;

        $paths = $this->parseImageSizes($postId, $metadata['file'], $sizes, $upload);
        $paths = apply_filters('webpc_attachment_paths', $paths, $postId);

        if (!$paths) continue;
        $list[] = $paths;
      }

      $list = array_filter($list);
      return $list;
    }

    private function parseImageSizes($postId, $path, $sizes, $upload)
    {
      $list = [];
      $list['_source'] = str_replace('\\', '/', implode('/', [$upload['basedir'], $path]));
      foreach ($sizes as $size) {
        $src = wp_get_attachment_image_src($postId, $size);
        $url = str_replace($upload['baseurl'], $upload['basedir'], $src[0]);
        $url = str_replace('\\', '/', $url);

        if (in_array($url, $list)) continue;
        $list[$size] = $url;
      }
      return $list;
    }
  }
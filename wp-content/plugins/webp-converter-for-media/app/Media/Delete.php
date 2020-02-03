<?php

  namespace WebpConverter\Media;
  use WebpConverter\Convert as Convert;

  class Delete
  {
    public function __construct()
    {
      add_filter('wp_delete_file', [$this, 'deleteAttachmentFile']);
    }

    /* ---
      Functions
    --- */

    public function deleteAttachmentFile($path)
    {
      $directory = new Convert\Directory();
      $source    = $directory->getPath($path);
      if (is_writable($source) && (pathinfo($source, PATHINFO_EXTENSION) === 'webp')) unlink($source);
      return $path;
    }
  }
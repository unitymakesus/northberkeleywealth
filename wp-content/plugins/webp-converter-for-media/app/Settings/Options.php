<?php

  namespace WebpConverter\Settings;

  class Options
  {
    public function __construct()
    {
      add_filter('webpc_get_options',     [$this, 'getOptions']);
      add_filter('webpc_option_disabled', [$this, 'setDisabledValues'], 10, 2);
    }

    /* ---
      Functions
    --- */

    public function getOptions()
    {
      return [
        [
          'name'     => 'extensions',
          'type'     => 'checkbox',
          'label'    => __('List of supported files extensions', 'webp-converter'),
          'info'     => '',
          'values'   => [
            'jpg'  => '.jpg',
            'jpeg' => '.jpeg',
            'png'  => '.png',
            'gif'  => '.gif',
          ],
          'disabled' => apply_filters('webpc_option_disabled', [], 'extensions'),
        ],
        [
          'name'     => 'method',
          'type'     => 'radio',
          'label'    => __('Conversion method', 'webp-converter'),
          'info'     => __('The configuration for advanced users.', 'webp-converter'),
          'values'   => [
            'gd'      => sprintf(__('%s (recommended)', 'webp-converter'), 'GD'),
            'imagick' => 'Imagick',
          ],
          'disabled' => apply_filters('webpc_option_disabled', [], 'method'),
        ],
        [
          'name'     => 'features',
          'type'     => 'checkbox',
          'label'    => __('Extra features', 'webp-converter'),
          'info'     => __('The options allow you to enable new functionalities that will additionally speed up your website.', 'webp-converter'),
          'values'   => [
            'mod_expires' => 'Browser Caching for .webp files (saving images in browser cache memory)',
          ],
          'disabled' => apply_filters('webpc_option_disabled', [], 'features'),
        ],
        [
          'name'   => 'quality',
          'type'   => 'quality',
          'label'  => __('Images quality', 'webp-converter'),
          'info'   => __('Adjust the quality of the images being converted. Remember that higher quality also means larger file sizes. The recommended value is 85%.', 'webp-converter'),
          'values' => [
            '75'  => '75%',
            '80'  => '80%',
            '85'  => '85%',
            '90'  => '90%',
            '95'  => '95%',
            '100' => '100%',
          ],
          'disabled' => apply_filters('webpc_option_disabled', [], 'quality'),
        ],
      ];
    }

    public function setDisabledValues($list, $name)
    {
      switch ($name) {
        case 'method':
          $methods = apply_filters('webpc_get_methods', []);
          if (!in_array('gd', $methods)) $list[] = 'gd';
          if (!in_array('imagick', $methods)) $list[] = 'imagick';
      }
      return $list;
    }
  }
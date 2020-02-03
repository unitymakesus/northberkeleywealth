<?php

  namespace WebpConverter\Media;

  class Htaccess
  {
    public function __construct()
    {
      add_filter('mod_rewrite_rules', [$this, 'addRewriteRules']);
    }

    /* ---
      Functions
    --- */

    public function addRewriteRules($rules)
    {
      if (isset($_GET['plugin']) && ($_GET['plugin'] === 'webp-converter-for-media/webp-converter-for-media.php')
        && isset($_GET['action']) && ($_GET['action'] === 'deactivate')) return $rules;

      $values = apply_filters('webpc_get_values', []);
      $rows   = [];

      $rows[] = $this->getModMimeRules($values);
      $rows[] = $this->getModRewriteRules($values);
      $rows[] = $this->getModExpiresRules($values);

      $rows    = array_filter($rows);
      $content = $this->addCommentsToRules($rows);
      return $content . $rules;
    }

    private function getModMimeRules($settings)
    {
      $content = '';
      if (!$settings['extensions']) return $content;

      $content .= '<IfModule mod_mime.c>' . PHP_EOL;
      $content .= '  AddType image/webp .webp' . PHP_EOL;
      $content .= '</IfModule>';

      $content = apply_filters('webpc_htaccess_mod_mime', $content);
      return $content;
    }

    private function getModRewriteRules($settings)
    {
      $content = '';
      if (!$settings['extensions']) return $content;

      $pathSource = apply_filters('webpc_uploads_path', '');
      $pathOutput = apply_filters('webpc_uploads_webp', '');

      $content .= '<IfModule mod_rewrite.c>' . PHP_EOL;
      $content .= '  RewriteEngine On' . PHP_EOL;
      foreach ($settings['extensions'] as $ext) {
        $content .= '  RewriteCond %{HTTP_ACCEPT} image/webp' . PHP_EOL;
        $content .= "  RewriteCond %{DOCUMENT_ROOT}/${pathOutput}/$1.${ext}.webp -f" . PHP_EOL;
        $content .= "  RewriteRule ${pathSource}/(.+)\.${ext}$ ${pathOutput}/$1.${ext}.webp [T=image/webp]" . PHP_EOL;
      }
      $content .= '</IfModule>';

      $content = apply_filters('webpc_htaccess_mod_rewrite', $content);
      return $content;
    }

    private function getModExpiresRules($settings)
    {
      $content = '';
      if (!in_array('mod_expires', $settings['features'])) return $content;

      $content .= '<IfModule mod_expires.c>' . PHP_EOL;
      $content .= '  ExpiresActive On' . PHP_EOL;
      $content .= '  ExpiresByType image/webp "access plus 1 year"' . PHP_EOL;
      $content .= '</IfModule>';

      $content = apply_filters('webpc_htaccess_mod_expires', $content);
      return $content;
    }

    private function addCommentsToRules($rules)
    {
      $content = '';
      if (!$rules) return $content;

      $rows   = [];
      $rows[] = PHP_EOL;
      $rows[] = '# BEGIN WebP Converter';
      $rows   = array_merge($rows, $rules);
      $rows[] = '# END WebP Converter';
      $rows[] = PHP_EOL;

      $content = implode(PHP_EOL, $rows);
      $content = apply_filters('webpc_htaccess_rules', $content);
      return $content;
    }
  }
<?php

  namespace WebpConverter\Regenerate;
  use WebpConverter\Convert as Convert;

  class Endpoints
  {
    public $namespace = 'webp-converter/v1';

    public function __construct()
    {
      add_action('rest_api_init',             [$this, 'restApiEndpoints']);
      add_filter('webpc_rest_api_paths',      [$this, 'showApiPathsUrl']); 
      add_filter('webpc_rest_api_regenerate', [$this, 'showApiRegenerateUrl']); 
    }

    /* ---
      Functions
    --- */

    public function restApiEndpoints()
    {
      register_rest_route(
        $this->namespace,
        'paths',
        [
          'methods'  => \WP_REST_Server::ALLMETHODS,
          'permission_callback' => function() {
            return (isset($_REQUEST['_wpnonce']) && wp_verify_nonce($_REQUEST['_wpnonce'], 'wp_rest')
              && current_user_can('manage_options'));
          },
          'callback' => [$this, 'getPaths'],
          'args'     => [],
        ]
      );

      register_rest_route(
        $this->namespace,
        'regenerate',
        [
          'methods'  => \WP_REST_Server::ALLMETHODS,
          'permission_callback' => function() {
            return (isset($_REQUEST['_wpnonce']) && wp_verify_nonce($_REQUEST['_wpnonce'], 'wp_rest')
              && current_user_can('manage_options'));
          },
          'callback' => [$this, 'convertImages'],
          'args'     => [
            'paths' => [
              'description'       => 'Array of file paths (server paths)',
              'required'          => true,
              'default'           => [],
              'validate_callback' => function($value, $request, $param) {
                return is_array($value) && $value;
              }
            ],
          ],
        ]
      );
    }

    public function getPaths($request)
    {
      $api  = new Paths();
      $data = $api->getPaths();
      if ($data !== false) return new \WP_REST_Response($data, 200);
      else return new \WP_Error('webpc_rest_api_error', null, ['status' => 405]);
    }

    public function convertImages($request)
    {
      $params = $request->get_params();
      $api    = new Regenerate();
      $data   = $api->convertImages($params['paths']);
      if ($data !== false) return new \WP_REST_Response($data, 200);
      else return new \WP_Error('webpc_rest_api_error', null, ['status' => 405]);
    }

    public function showApiPathsUrl()
    {
      $nonce = wp_create_nonce('wp_rest');
      $url   = get_rest_url(null, $this->namespace . '/paths?_wpnonce=' . $nonce);
      return $url;
    }

    public function showApiRegenerateUrl()
    {
      $nonce = wp_create_nonce('wp_rest');
      $url   = get_rest_url(null, $this->namespace . '/regenerate?_wpnonce=' . $nonce);
      return $url;
    }
  }
<?php if ( ! defined('ABSPATH')) exit('No direct script access allowed');

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://philsbury.uk
 * @since      2.0.0
 *
 * @package    Age_Gate
 * @subpackage Age_Gate/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Age_Gate
 * @subpackage Age_Gate/public
 * @author     Phil Baker
 */
class Age_Gate_Public_JS extends Age_Gate_Public {

  private $js;

  public function __construct()
  {
    parent::__construct();
    $this->js = $this->settings['advanced']['use_js'];
  }

  public function ajax_setup()
  {
    if(!$this->js) return false;

    $page_type = $this->_screen_type();
		$this->type = $page_type;

    $this->id = $this->_get_id($this->type);
    $meta = $this->_get_meta($this->id, $this->type);

    // See if there's a translated header
    //
    //
    if(self::$language && self::$language->current['language_code'] !== self::$language->default['language_code']){
      $title_text = $this->_get_translated_setting('appearance', 'custom_title', self::$language->current['language_code']);
    } else {
      $title_text = $this->settings['appearance']['custom_title'];
    }

      // html_entity_decode($string)

      $title_text = wp_specialchars_decode($title_text, 'ENT_QUOTES');

    // use localize script to output AG settings
    $params = array(
      'ajaxurl' => ('rest' === $this->settings['advanced']['endpoint'] ? get_rest_url( null, '/age-gate/v1/') : admin_url( 'admin-ajax.php' ) ),
      'settings' => array(
        'age' => (int) $meta->age,
        'type' => $meta->restrictions->restriction_type,
        'bypass' => $meta->bypass,
        'restrict' => $meta->restrict,
        'title' => ($this->settings['appearance']['switch_title']) ? sprintf($title_text, $meta->age) . ' - ' . get_bloginfo( 'name' ) : false,
        'current_title' => trim(wp_title('', false)),
        'screen' => $this->_screen_type(),
        'ignore_logged' => (int) $this->settings['restrictions']['ignore_logged'],
        'rechallenge' => (int) $this->settings['restrictions']['rechallenge'],
        'has_filter' => has_filter('age_gate_restricted'),
        'viewport' => $this->settings['appearance']['device_width'],
        'anon' => $this->settings['advanced']['anonymous_age_gate'],
        'transition' => $this->settings['appearance']['transition']
      ),
      'misc' => [
        'i' => $this->id,
        't' => $this->type,
        'qs' => $this->settings['advanced']['filter_qs']
      ],
      'errors' => array(
        'invalid' => __($this->settings['messages']['invalid_input_msg']),
        'failed' => __($this->settings['messages']['under_age_msg']),
        'generic' => __($this->settings['messages']['generic_error_msg']),
        'cookies' => __($this->settings['messages']['cookie_message'])
      )
    );

    $user_params = [];
    $user_params = apply_filters('age_gate_js_params', $user_params);

    if($user_params){
      $params['extra'] = $user_params;
    }

    // add inheritance to the params
    if($this->settings['restrictions']['inherit_category'] && $this->settings['advanced']['inherit_taxonomies']){
      $params['settings'] = array_merge($params['settings'], $this->_get_category_info());
    }

    if($this->settings['advanced']['custom_bots']){
      $params['bots'] = $this->settings['advanced']['custom_bots'];
    }

    // Print the script to our page
    wp_localize_script( $this->plugin_name, 'age_gate_params', $params );
  }

  /**
   * Get the info for inheritance
   * @return mixed [description]
   */
  private function _get_category_info()
  {
    $inherit = [
      'inherit' => true
    ];
    sort($this->settings['advanced']['inherit_taxonomies']);
    switch($this->settings['restrictions']['restriction_type']){
      case 'selected':
        $inherit['restrict'] = ( wp_get_post_terms($this->id, $this->settings['advanced']['inherit_taxonomies'], ['meta_key' => '_age_gate-restrict']) ? true : false);
        break;
      default:
        $inherit['bypass'] = ( wp_get_post_terms($this->id, $this->settings['advanced']['inherit_taxonomies'], ['meta_key' => '_age_gate-bypass']) ? true : false);
        break;
    }
    return $inherit;
  }

  /**
   * Output the HTML for the agegate
   * @return void
   */
  public function render_age_gate()
  {
    if(!$this->js) return false;

    ob_start();
    include_once AGE_GATE_PATH . 'public/class-age-gate-public-output.php';
    $ag = ob_get_contents();
    ob_end_clean();

    echo '<script type="text/template" id="tmpl-age-gate">';
    echo preg_replace('~>\s*\n\s*<~', '><',$ag);
    echo '</script>';
  }

  public function register_rest_endpoints()
	{
    if(!$this->js || 'rest' !== $this->settings['advanced']['endpoint']) return false;
		register_rest_route( 'age-gate/v1', '/check', array(
      'methods' => 'GET',
      'callback' => array($this, 'age_gate_rest')

    ) );

    // rest route for filter
    register_rest_route( 'age-gate/v1', '/filter', array(
      'methods' => 'GET',
      'callback' => array($this, 'age_gate_filters_rest')

    ) );


	}

  public function age_gate_filters_rest()
  {
    return $this->age_gate_filters($this->validation->sanitize($_GET), true);
  }

  /**
   * Call the validation from the REST api
   * @return [type] [description]
   * @since 2.1.0
   */
  public function age_gate_rest()
  {
    return $this->handle_ajax_form_submission($this->validation->sanitize($_GET), true);
  }

  public function handle_ajax_form_submission($post = false, $return = false)
  {
    if(!$this->js) return false;
    if(!$post){
      $post = $this->validation->sanitize($_POST);
    }

    $post['age_gate']['age'] = $this->_decode_age($post['age_gate']['age']);

    if('buttons' === $this->settings['restrictions']['input_type']){
      $response = $this->_handle_button_submission($post);

    } else {
      $response = $this->_handle_input_submission($post);
      // else it's inputs of some kind
    }

    $response['set_cookie'] = apply_filters('age_gate_set_cookie', true);

    if($return){
      return $response;
    }

    header("Content-type:application/json");
    echo json_encode($response);
    wp_die();
  }

  private function _handle_input_submission($data)
  {

    $redirect = $data['_wp_http_referer'];

    $form_data = $this->flatten($data);

    $is_valid = $this->_validate($form_data);

    if ($is_valid !== true) {

      $status = 'failed';
      do_action("age_gate_form_{$status}", $this->_hook_data($form_data), $this->_filter_errors($is_valid));

      return [
        'status' => 'error',
        'messages' => $this->_filter_errors($is_valid),
        'redirect' => false
      ];
    }

    // inputs are valid - check their age
    $user_age = $this->_calc_age($data['age_gate']);

    if($this->_test_user_age($user_age, $data['age_gate']['age'])){

      $response = [
        'status' => 'success',
        'age' => $user_age,
        'remember' => ((int) !isset($data['age_gate']['remember']) ? false : $this->settings['restrictions']['remember_days']),
        'timescale' => $this->settings['restrictions']['remember_timescale']
      ];

      if(!isset($data['age_gate']['remember'])){
        $response['remember'] = apply_filters('age_gate_cookie_length', $response['remember']);
        $response['timescale'] = apply_filters('age_gate_cookie_timescale', ($this->settings['restrictions']['remember_timescale'] ? $this->settings['restrictions']['remember_timescale'] : 'days'));
      }

      $status = 'success';

    } else {

      $status = 'failed';
      $errors = [];
      if(isset($data['lang'])){
        $errors['age_gate_failed'] = $this->_get_translated_setting('messages', 'under_age_msg', $data['lang']);
        $redirect_url = $this->_get_translated_setting('restrictions', 'fail_link', $data['lang']);
      } else {
        $errors['age_gate_failed'] = $this->settings['messages']['under_age_msg'];
        $redirect_url = $this->settings['restrictions']['fail_link'];
      }

      do_action("age_gate_form_{$status}", $this->_hook_data($form_data), $errors);

      return [
        'status' => 'error',
        'messages' => $errors,
        'redirect' => ($redirect_url ? $redirect_url : false)
      ];

    }

    do_action("age_gate_form_{$status}", $this->_hook_data($form_data));
    return $response;

  }
  private function _handle_button_submission($data)
  {
    $redirect = $data['_wp_http_referer'];
    $form_data = $this->flatten($data);

    if(!$form_data['confirm_action']){

      $status = 'failed';

      $errors = [];
      if(isset($data['lang'])){
        $errors['buttons'] = $this->_get_translated_setting('messages', 'under_age_msg', $data['lang']);
        $redirect_url = $this->_get_translated_setting('restrictions', 'fail_link', $data['lang']);
      } else {
        $errors['buttons'] = $this->settings['messages']['under_age_msg'];
        $redirect_url = $this->settings['restrictions']['fail_link'];
      }

      $response = [
        'status' => 'error',
        'messages' => $errors,
        'redirect' => ($redirect_url ? $redirect_url : false)
      ];

      do_action("age_gate_form_{$status}", $this->_hook_data($form_data), $errors);

      return $response;

    } else {

      $is_valid = $this->_validate($form_data);

      if ($is_valid !== true) {
        $errors = $this->_filter_errors($is_valid);
        $status = 'failed';
        do_action("age_gate_form_{$status}", $this->_hook_data($form_data), $errors);

        $response = [
          'status' => 'error',
          'messages' => $errors,
          'redirect' => false
        ];

        return $response;

      } else {
        // success
        $status = 'success';
        do_action("age_gate_form_{$status}", $this->_hook_data($form_data));

        $response = [
          'status' => 'success',
          'age' => $data['age_gate']['age'],
          'remember' => ((int) !isset($data['age_gate']['remember']) ? false : $this->settings['restrictions']['remember_days']),
          'timescale' => $this->settings['restrictions']['remember_timescale']
        ];

        if(!isset($data['age_gate']['remember'])){
          $response['remember'] = apply_filters('age_gate_cookie_length', $response['remember']);
          $response['timescale'] = apply_filters('age_gate_cookie_timescale', ($this->settings['restrictions']['remember_timescale'] ? $this->settings['restrictions']['remember_timescale'] : 'days'));
        }

        return $response;
      }

    }


    // echo $data['age_gate']['confirm'];

    // if('true' !== $data['age_gate']['confirm']){
    //
    //   $status = 'failed';
    //
    //   if($this->settings['restrictions']['fail_link']){
    //     $redirect = $this->settings['restrictions']['fail_link'];
    //   } else {
    //     $redirect = false;
    //   }
    //
    //   $response = [
    //     'status' => 'error',
    //     'message' => $this->settings['messages']['under_age_msg'],
    //     'redirect' => $redirect
    //   ];
    //
    // } else {
    //
    //   $response = [
    //     'status' => 'success',
    //     'age' => $data['age_gate']['age'],
    //     'remember' => ((int) !$data['age_gate']['remember'] ? false : $this->settings['restrictions']['remember_days'])
    //   ];
    //   $status = 'success';
    // }
    //
    // do_action("age_gate_form_{$status}", $data);
    //
    //
    //
    // return $response;
  }

  /**
   * [_decode_age description]
   * @param  string $string Double encoded age
   * @return int            The decoded age
   */
  private function _decode_age($age)
  {

    return base64_decode(base64_decode($age));
  }

  /**
   * Test the age against the requirement
   * @param  int $age    Supplied Age
   * @param  int $target Required Age
   * @return bool
   */
  private function _test_user_age($age, $target)
  {
    return $age >= $target;
  }

  private function _validate($post)
  {
    $custom_rules = array();
    $custom_rules = apply_filters('age_gate_validation', $custom_rules);

    $ag_rules = [
      'age_gate_age' => 'required|numeric',
      // 'age_gate_nonce' => 'required|nonce'
    ];

    if($this->settings['restrictions']['input_type'] !== 'buttons'){

      $min_year = 1900;
      $min_year = apply_filters('age_gate_select_years', $min_year);

      $ag_rules = array_merge(
        [
          'age_gate_d' => 'required|numeric|min_len,2|max_len,2|max_numeric,31',
          'age_gate_m' => 'required|numeric|min_len,2|max_len,2|max_numeric,12',
          'age_gate_y' => 'required|numeric|min_len,4|max_len,4|min_numeric,'. $min_year .'|max_numeric,' . date('Y'),
        ],
        $ag_rules
      );
    }

    $validation_rules = array_merge($custom_rules, $ag_rules);


    return $this->validation->is_valid($post, $validation_rules);
  }

  /**
	 * Get the age of the user
	 * @param  mixed $dob Post array
	 * @return int   The int value of the age
	 * @since 		2.0.0
	 */
	private function _calc_age($age)
	{
    if(intval($age['y']) >= date('Y')){
      return 0;
    }

		$dob = intval($age['y']). '-' . str_pad(intval($age['m']), 2, 0, STR_PAD_LEFT) . '-' . str_pad(intval($age['d']), 2, 0, STR_PAD_LEFT);
    $tz = get_option('timezone_string');

    if(empty($tz)){
      $tz = date_default_timezone_get();
    }

    $timezone = new DateTimeZone($tz);

		$from = new DateTime($dob, $timezone);
		$to   = new DateTime('today', $timezone);
		return $from->diff($to)->y;
	}


  private function flatten($array, $prefix = '') {
    $result = array();

    foreach ($array as $key => $value)
    {
        $new_key = $prefix . (empty($prefix) ? '' : '_') . $key;

        if (is_array($value))
        {
          $result = array_merge($result, $this->flatten($value, $new_key));
        }
        else
        {
          $result[$new_key] = $value;
        }
    }

    return $result;
  }


  private function _hook_data($data)
  {
    $data['age_gate_content'] = $data['_wp_http_referer'];
    unset($data['age_gate_nonce']);
    unset($data['action']);
    unset($data['_wp_http_referer']);
    ksort($data);
    return $data;
  }

  /**
   * Function to return filters
   */
  public function age_gate_filters($data = false, $return = false){

    if(!$data){
      $data = $this->validation->sanitize($_POST);
    } else {
      $data = $this->validation->sanitize($data);
    }

    $meta = $this->_get_meta($data['id'], $data['type']);
    $show = (isset($data['show']) ? $data['show'] : true);
    $show = ($show === 'true');

    $resp = [
      'show' => apply_filters('age_gate_restricted', $show, $meta)
    ];

    if($return){
      return $resp;
    }

    header("Content-type:application/json");
    echo json_encode($resp);
    wp_die();
  }

}
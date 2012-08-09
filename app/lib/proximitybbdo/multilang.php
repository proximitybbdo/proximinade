<?php

/**
 * Proximity MultiLang lib
 *
 * Handles translation through yaml files
 * 
 * @package proximitybbdo
 * @namespace proximitybbdo
 */

include_once(dirname(__FILE__) . '/../spyc/spyc.php');

class MultiLang {

  private static $instance = null;

  public $langs = array();
  private $lang = ''; 
  private $default_lang = '';

  private function __construct() {}

  public function __clone() {
    trigger_error( "Cannot clone instance of Singleton pattern ...", E_USER_ERROR );
  }
  public function __wakeup() {
    trigger_error('Cannot deserialize instance of Singleton pattern ...', E_USER_ERROR );
  }

  /**
   * Returns an instance of MultiLang
   */
  public static function get_instance() {
    if( self::$instance == null )
      self::$instance = new MultiLang();

    return self::$instance;
  }

  /**
   * Parse the language files and set the default lang
   */
  public function init($lang_dir, $default_lang = 'nl-BE') {
    $this->default_lang = $default_lang;
    $this->set_lang($default_lang);

    // Parse languages
    foreach (glob($lang_dir . '/*.yml') as $filename) {
      $this->langs[basename($filename, '.yml')] = spyc_load_file($filename);
    }
  }

  public function iso_lang($lang) {
    $iso_langs['nl'] = 'nl-BE';
    $iso_langs['fr'] = 'fr-BE';
    $iso_langs['en'] = 'en-UK';
    $iso_langs['pt'] = 'pt-PT';
    
    if(array_key_exists($lang, $iso_langs) && strlen($iso_langs[$lang]) > 0)
      return $iso_langs[$lang]; 
    else
      return $lang;
  }

  /**
   * 
   */
  public function set_time_locale() { 
    switch($this->lang) { 
    case "nl-BE": 
      $l = setlocale(LC_TIME, "dutch-belgian", "nlb", "nlb-nlb", "nld-nld", "nl_NL");  
      break; 
    case "fr-BE": 
      $l = setlocale(LC_TIME, "french-belgian", "frb", "frb-frb", "fr_BE", "br_FR");  
      break; 
    default:  
      $l = setlocale(LC_TIME, ""); 
      break; 
    } 
  }

  /**
   * Destroy the language array and any other variables
   */
  public function destroy() {
    unset($this->langs);
    $this->langs = array();
    return TRUE;
  }

  /**
   * Change the default language multilang translates against
   *
   * @param string $lang the new language
   */
  public function set_lang($lang) {
    $this->lang = $this->iso_lang($lang);
    $this->set_time_locale();
  }

  /**
   * Return the current language
   *
   * @return string
   */
  public function get_lang() {
    return $this->lang;
  }

  /**
   * Switch back to the default language
   */
  public function set_default_lang() {
    $this->set_lang($this->default_lang);
  }

  /**
   * Gets the responding string for a given key
   *
   * @param string $key the key of the translated string
   * @param string $lang (optional) lang key
   *
   * @return MultiLangKey
   */
  public function _t($key, $lang) {
    return new MultiLangKey($this->langs[$lang][$key]);
  }

  /**
   * Gets the responding string for a given key, but with
   * a dynamic twist
   *
   * @param string $key the key of the translated string
   * @param string $regexp a regular expression update dynamic values
   * @param string $params the params to replace the the regexp matches
   * @param string $lang (optional) lang key
   *
   * @return string
   */
  public function _d($key, $regexp, $params, $lang) {
    $value = $this->langs[$lang][$key];
    $value = preg_replace($regexp, $params, $value);

    return $value;
  }

  /**
   * Get all languages formatted for multi-select regular expression ``nl|fr|en|...``
   */
  public function langs_as_regexp() {
    $lang_names = array();

    foreach ($this->langs as $key => $value) 
      array_push($lang_names, $key);
    
    return "/" . implode('|', $lang_names) . "/";
  }

  /**
   * Get count of languages available
   *
   * @return int
   */
  public function get_lang_count() {
    return count($this->langs);
  }
}

class MultiLangKey extends ArrayObject {
  public $_data = array();

  function __construct($data) {
    $this->_data = $data;

    if(is_array($this->_data))
      parent::__construct($this->_data, ArrayObject::ARRAY_AS_PROPS);
  }

  public function __call($name, array $arguments) {
    if($name == '_t' || $name == 't')
      return call_user_func_array(array($this, '__t'), $arguments);
    else if($name == '_d' || $name == 'd')
      return call_user_func_array(array($this, '__d'), $arguments);
  }

  private function __t($key) {
    return new MultiLangKey($this->_data[$key]);
  }

  private function __d($key, $regexp, $params) {
    $value = $this->_data[$key];
    $value = preg_replace($regexp, $params, $value);

    return $value;
  }

  public function __toString() {
    return (string) $this->_data;
  }
}

/**
 * Gets the responding string for a given key
 *
 * @param string $key the key of the translated string
 * @param string $lang (optional) lang key
 *
 * @return string
 */
function _t($key, $lang = '') {
  $lang = strlen($lang) == '' ? MultiLang::get_instance()->get_lang() : MultiLang::get_instance()->iso_lang($lang);

  $value = MultiLang::get_instance()->_t($key, $lang);

  return $value;
}

/**
 * Gets the responding string for a given key, but with
 * a dynamic twist
 *
 * @param string $key the key of the translated string
 * @param string $regexp a regular expression update dynamic values
 * @param string $params the params to replace the the regexp matches
 * @param string $lang (optional) lang key
 *
 * @return string
 */
function _d($key, $regexp, $params, $lang = '') {
  $lang = strlen($lang) == '' ? MultiLang::get_instance()->get_lang() : MultiLang::get_instance()->iso_lang($lang);

  return MultiLang::get_instance()->_d($key, $regexp, $params, $lang);
}

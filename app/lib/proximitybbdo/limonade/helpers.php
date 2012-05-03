<?php
# ============================================================================ #
/**
 * Proximity Framwork Helpers 
 * 
 * v0.01
 * @package proximitybbdo
 *
 * These functions are generic helpers that can be used throughout the framework
 * They can be called from everywhere since they are loaded from the moment
 * the app starts.
 */
# ============================================================================ #

/**
 * Logs input to the console (if available, won't crash on IE)
 *
 * @param $msg  the input for the log, can be anything from a string to an object
 *              try me :)
 * 
 * The output will not be shown if you have 'verbose' in you config.yaml
 */
function _log($msg) {
  $out = "<script>//<![CDATA[\n";
  $out .= 'if(this.console) {';
  $out .= 'console.log(' . json_encode($msg) . '); }';
  $out .= "\n//]]></script>";

  if(_c('verbose')) 
    echo($out);
}

// Splits the url into parts.
function _url_parts() {
  $parts = explode("/", request_uri());
  
  array_shift($parts); // remove first empty element (blame the explode)
  return $parts;
}

// Returns the name (based on the URL) of the part you request (based on the ``$id``).
function _page($id = 0) {
  $parts = _url_parts();

  // if first part is a lang (we match it with the lang array from MultiLang)
  if(count($parts) > 0 && preg_match(Multilang::getInstance()->langs_as_regexp(), $parts[0]))
    array_shift($parts);

  // if the given index is found in the url
  if(count($parts) > 0 && $id < count($parts))
    return $parts[$id];

  return '';
}

// Returns **active** when the ``$page_name`` argument combined with the given ``$id`` resembles the page.
function _get_active($page_name, $id = 0) {
  if(_page($id) == $page_name)
    return 'active';
  
  return '';
}

function _asset($path) {
  $path = preg_replace("/^\//", "", $path);

  return (BASE_PATH == '/' ? '' : BASE_PATH) . '/' . $path;
}


// ===================================================================
// = removes dashes and turns spaces to dashes and sets to lowercase =
// ===================================================================
// _lowerdash("Your Name-firstname"); => your-namefirstname
// used for imagenames for example name-of-person.jpg
// ===================================================================
function _lowerdash($str){
	$arr_search = array("-", " ");
	$arr_rep = array("", "-");
	$str = strtolower(str_replace($arr_search, $arr_rep, $str));
	return $str;
}

// =====================================
// = Making weird strings url friendly =
// =====================================
// _urlfriendly("ÅndÊò-_Te st") => andeo-te-st
// to create language slugs for exampl!!
// =====================================
function _urlfriendly($str){
	$str_search = "à â ä å ã á Â Ä À Å Ã Á æ Æ ß ç Ç Ð é è ê ë É Ê Ë È ï î ì í Ï Î Ì Í ñ Ñ ö ô ó ò õ Ó Ô Ö Ò Õ Š š ü ù û ü ú Ü Û Ù Ú Ÿ Ý Ÿ ý ÿ Ž ž";
	$str_rep = "a a a a a a a a a a a a a a b c c d e e e e e e e e i i i i i i i i n n o o o o o o o o o o s s u u u u u u u u u y y y y y z z";
	$arr_search = explode(" ", $str_search);
	$arr_rep = explode(" ", $str_rep);
	array_push($arr_search, "-"," ","_");
	array_push($arr_rep, "","-","-");
	$str = strtolower(str_replace($arr_search, $arr_rep, $str));
	return $str;
}

// =========================================================================================
// = scanProjectDir A function that scans a directory of the project and returns its files =
// =========================================================================================
// used for scanning dowload directories 
// @optional = $$dirname
// @optional = $scan_direction 1 or 0
// @optional = $opt_ext for filtering on extension (ex: pdf, mov, etc)
// =========================================================================================
function scanProjectDir($dirname = "", $scan_direction = 1, $opt_ext = ""){
	$dir = $_SERVER["DOCUMENT_ROOT"] . BASE_PATH . $dirname;
	$scaned_files = scandir($dir,$scan_direction);
	$files = array();
	foreach($scaned_files as $file) { 
		if($file !== '.' && $file !== '..'  && $file !== '.DS_Store') {
			$file_to_use = array();
			$file_to_use["filename"] = $file;
			$exploded = explode(".", $file);
			$file_to_use["name"] = $exploded[0];
			$file_to_use["ext"] = $exploded[1];
			if(filesize($_SERVER["DOCUMENT_ROOT"] . BASE_PATH . $dirname . $file) / 1024 > 1024){
				$file_to_use["size"] = round(filesize($_SERVER["DOCUMENT_ROOT"] . BASE_PATH . $dirname . $file)/1024/1024,2)." MB";
			}else{
				$file_to_use["size"] = round(filesize($_SERVER["DOCUMENT_ROOT"] . BASE_PATH . $dirname . $file)/1024)." KB";
			}
			
			if($opt_ext !== ""){
				if($file_to_use["ext"] === $opt_ext){
					array_push($files,$file_to_use);
				}
			}else{
				array_push($files,$file_to_use);
			}
		}
    }
	return $files;
}

// ========================================
// = Constrain string when space is short =
// ========================================
// _costraint("This string is tooooo long for its container.",20) => this string is to...
// @optional = $tail
// ========================================
function _costraint($str, $amount, $tail = "..."){
	if(strlen($str) > $amount){
		$str = substr($str, 0, $amount-3) . $tail;
	}
	return $str;
}

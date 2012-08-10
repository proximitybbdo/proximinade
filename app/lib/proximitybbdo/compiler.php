<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

class Compiler {

	/**
	 * The list of syntax replacements to apply to compiled templates.
	 *
	 * Key/value pairs of regular expressions. The keys are the regexes, and the values are the
	 * resulting expressions along with any capture groups that may have been used in the
	 * corresponding regexes.
	 *
	 * @var array
	 */
	public $_processors = array(
		'/\<\?=\s*\$this->(.+?)\s*;?\s*\?>/msx' => '<?php echo($this->$1); ?>',
		'/\<\?=\s*(\$h\(.+?)\s*;?\s*\?>/msx' => '<?php echo($1); ?>',
		'/\<\?=\s*(.+?)\s*;?\s*\?>/msx' => '<?php echo($1); ?>'
	);

	/**
	 * Compiles a template and writes it to a cache file, which is used for inclusion.
	 *
	 * @param string $file The full path to the template that will be compiled.
	 * @param array $options Options for compilation include:
	 *        - `path`: Path where the compiled template should be written.
	 * @return string The compiled template.
	 */
  public function template($file, array $options = array()) {
    global $root_directory;

		$cache_path = $root_directory . 'tmp/';
    $defaults = array('path' => $cache_path);

		$options += $defaults;

		$stats = stat($file);
    $dir = dirname($file);
    $oname = basename(dirname($dir)) . '_' . basename($dir) . '_' . basename($file, '.php');

		$template = "tpl_{$oname}_{$stats['ino']}_{$stats['mtime']}_{$stats['size']}.php";
    $template = "{$options['path']}/{$template}";

		if(file_exists($template)) {
			return $template;
    }

    if(!file_exists($cache_path)) {
      mkdir($cache_path, 0777);
    }

		$compiled = $this->compile(file_get_contents($file));

		if(is_writable($cache_path) && file_put_contents($template, $compiled) !== false) {
			foreach (glob("{$options['path']}/tpl_{$oname}_*.php") as $expired) {
				if ($expired !== $template) {
					unlink($expired);
				}
      }

			return $template;
    }

    return $file;
	}

	/**
	 * Preprocess the passed `$string` (usually a PHP template) for syntax replacements
	 * using sets of regular expressions.
	 *
	 * @param string $string The string to be preprocessed.
	 * @return string Processed string.
	 */
	public function compile($string) {
    $patterns = $this->_processors;

		return preg_replace(array_keys($patterns), array_values($patterns), $string);
	}
}

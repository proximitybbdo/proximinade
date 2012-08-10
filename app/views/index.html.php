<h1>Welcome to Proximinade!</h1>
<h2>Loosely based on the great <a href="http://www.limonade-php.net/">Limonade PHP</a></h2>

<p>Enough with the babbling, let's get some coding done!</p>

<section>
  <h2>Basic framework security</h2>

  <h3>File access</h3>

  <p>By default the provided <em>.htaccess</em> and <em>web.config</em> will not allow access to files with the following extension:</p>

  <ul>
    <li>php</li>
    <li>yml</li>
    <li>yaml</li>
    <li>inc</li>
  </ul>

  <p>All other files are accessible as well as the <em>index.php</em> file on the root.</p>

</section>

<section>
  <h2>Environment</h2>

  <h3>Base path</h3>
  
  <code>$base_path</code>

  <p><em>Note: Only available in a view / template.</em></p>

  <p class="result"><?php echo($base_path); ?></p>

  <p>If you need the base path in a controller you can use the following constant.</p>

  <code>BASE_PATH</code>

  <p class="result"><?php echo($base_path); ?></p>

  <p><em>Note: the BASE_PATH (or $base_path) is a path, so it ends with a `/`. When creating file paths, be carefull not to have double `//`</em></p>

  <p>You can also fetch assets with the right path with the following function:</p>

  <code>_asset('assets/js/base.js');</code>

  <p class="result"><?php echo _asset('assets/js/base.js'); ?></p>

  <p><em>Note: This is the same result as $base_path, but is easy without the need for string concatenation.</em></p>

  <h3>How to get your current environment?</h3>
  
  <code>option('env');</code>

  <p class="result"><?php echo(option('env')); ?></p>

  <h3>How to change environment</h3>

  <p>In your root directory, create a file with the name 'DEVELOPMENT', 'STAGING' or 'PRODUCTION'</p>
  <p>The files are used to determine the environment, with a sorting priority:</p>

  <code>1. PRODUCTION</code>
  <code>2. STAGING</code>
  <code>3. DEVELOPMENT</code>

  <p>If no file is found, 'DEVELOPMENT' will be the default environment</p>
</section>

<section>
  <h2>Page<a name="page"></a></h2>

  <h3>How to get your current page?</h3>

  <p>NOTE: Test this functionality by browsing to <a href="<?php echo url_for('/home'); ?>#page">/home</a> and <a href="<?php echo url_for('/home/another_page'); ?>#page">/home/another_page</a></p>
  
  <code>_page();</code>

  <p class="result"><?php echo(_page()); ?></p>

  <h3>What about the part behind my base controller?</h3>

  <code>_page(1);</code>

  <p class="result"><?php echo(_page(1)); ?></p>

  <h3>To get all parts</h3>

  <code>_url_parts();</code>

  <p class="result"><?php var_dump(_url_parts()); ?></p>
  
  <h3>Active page (for menu)?</h3>
  
  <p>Check if first controller (ignoring language url part) equals home</p>

  <code>_get_active('home', 0);</code>

  <p class="result"><?php echo(_get_active('home', 0)); ?></p>
</section>

<section>
  <h2>MultiLang</h2>

  <h3>The current language can be fetched through<br>
  Multilang::get_instance()->getLang(), or through the short var $lang</h3>

  <p><em>Note: the short var is set on the before() call, so all changes during the build of a page (as above), will not be reflected. To get the most up to date result, use the longer Multilang::get_instance()->getLang() version.</em></p>

  <code>echo($lang);</code>

  <p><em>Note: Only available in a view / template.</em></p>

  <p class="result"><?php echo($lang); ?></p>

  <code>echo Multilang::get_instance()->get_lang();</code>

  <p class="result"><?php echo(Multilang::get_instance()->get_lang()); ?></p>
  
  <h3>First trying out Multilang with the default language</h3>

  <code>echo _t('title');</code>

  <p class="result"><?php echo _t('title'); ?></p>

  <h3>Then change the lang and output again</h3>

  <code>Multilang::get_instance()->lang('fr-BE');</code>

  <p>or</p>

  <code>Multilang::get_instance()->lang('fr');</code>

  <p>and</p>

  <code>echo _t('title');</code>

  <p class="result"> <?php Multilang::get_instance()->set_lang('fr'); echo _t('title'); ?> </p>

  <h3>Now we use the same _t() function, but with an extra language parameter</h3>

  <code>echo _t('title', 'nl-BE');</code>

  <p>or</p>

  <code>echo _t('title', 'nl');</code>

  <p class="result"> <?php echo _t('title', 'nl-BE'); ?> </p>

  <h3>Switch back to default language</h3>

  <code>Multilang::get_instance()->set_default_lang();</code>

  <?php Multilang::get_instance()->set_default_lang(); ?>

  <h3>Chain it!</h3>

  <p>You can dig into your YAML file to look up objects and arrays.</p>

  <code>echo _t('contact')->t('title');</code>

  <p class="result"><?php echo _t('contact')->t('title'); ?></p>

  <p>The language parameter will still work:</p>

  <code>echo _t('contact', 'fr-BE')->t('title');</code>

  <p class="result"><?php echo _t('contact', 'fr-BE')->t('title'); ?></p>
  <p></p>

  <p>An array behind an object:</p>

  <code>echo _t('contact')->t('sex')->t(0);</code>

  <p class="result"><?php echo _t('contact')->t('sex')->t(0); ?></p>

  <p>or</p>

  <code>$arr = _t('contact')->t('sex');<br />echo $arr[1];</code>

  <p class="result"><?php $arr = _t('contact')->t('sex'); echo $arr[1]; ?></p>

  <h3>There is also an _d() function, that can replace a dynamic value using a regular expression</h3>

  <code>String in yaml: 'Dit is een % titel' <br />echo _d('dynamic', '/%/', 'dynamic coolness');</code>

  <p class="result"><?php echo _d('dynamic', '/%/', 'dynamic coolness'); ?></p>

  <p>Take it further with arrays of regular expressions and replacements. Consider this key:</p>

  <code>the 1 2 3 jumps over the 4 5</code>

  <p>Apply the following code to get a more complex replaced output</p>

  <code>
    _d('dynamic_crazy', array('/1/', '/2/', '/3/', '/4/', '/5/'), array('quick', 'brown', 'fox', 'lazy', 'dog'))
  </code>

  <p>will result in:</p>

  <p class="result">the quick brown fox jumps over the lazy dog</p>

  <p><strong>or</strong></p>

  <code>_d('dynamic_crazy', array('/1/', '/2/', '/3/', '/4/', '/5/'), 'scooby');</code>

  <p>will output:</p>

  <p class="result">the scooby scooby scooby jumps over the scooby scooby</p>

  <p><em>Note: the '/' are needed as the second parameter is a regular expression! And yes this means you can do crazy stuff like `'/^\s*{(\w+)}\s*=/'`</em></p>

  <h3>Multilang domain</h3>

  <p>Consider the following example:</p>

  <code>
    3 languages: nl-BE, fr-BE and nl-NL.<br />
    And we want the following URL setup:
    <ul>
    	<li>http://domain.be/nl-BE</li>
    	<li>http://domain.be/fr-BE</li>
    	<li>http://domain.nl/</li>
    </ul>
  </code>

  <p>By default, the first 2 URLs are ready for you. The last one, where we omit the language part from the URL and replace it with a different domain requires an extra setting in your <em>.htaccess</em>. This should be placed before the existing rules:</p>

  <code>
    # RewriteCond %{HTTP_HOST} ^domain\.nl$ [OR]
    <br />
    # RewriteCond %{HTTP_HOST} ^www\.domain\.nl$
    <br /> <br />
    # Test string is a valid files
    <br />
    # RewriteCond %{SCRIPT_FILENAME} !-f
    <br /> <br />
    # Test string is a valid directory
    <br />
    # RewriteCond %{SCRIPT_FILENAME} !-d
    <br /> <br />
    # RewriteRule (.*) index.php?/nl-NL/$1 [NC,L]
  </code>

  <p>and</p>

  <code class='smaller'>
    &lt;rule name="Limonade nl-NL Root" enabled="true" stopProcessing="true"><br />
    &nbsp;&nbsp;&lt;match url="^$" ignoreCase="false" /><br />
    &nbsp;&nbsp;&lt;conditions logicalGrouping="MatchAll"><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&lt;add input="{REQUEST_FILENAME}" matchType="IsFile" negate="true" ignoreCase="false" /><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&lt;add input="{HTTP_HOST}" pattern="^www\.domain\.nl$" /><br />
    &nbsp;&nbsp;&lt;/conditions><br />
    &nbsp;&nbsp;&lt;action type="Rewrite" url="index.php?uri=/nl-NL/" appendQueryString="true" /><br />
    &lt;/rule><br />
    <br />
    &lt;rule name="Limonade nl-NL Main" enabled="true" stopProcessing="true"><br />
    &nbsp;&nbsp;&lt;match url="^(.*)$" ignoreCase="false" /><br />
    &nbsp;&nbsp;&lt;conditions logicalGrouping="MatchAll"><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&lt;add input="{REQUEST_FILENAME}" matchType="IsDirectory" negate="true" ignoreCase="false" /><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&lt;add input="{REQUEST_FILENAME}" matchType="IsFile" negate="true" ignoreCase="false" /><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&lt;add input="{HTTP_HOST}" pattern="^www\.domain\.nl$" /><br />
    &nbsp;&nbsp;&lt;/conditions><br />
    &nbsp;&nbsp;&lt;action type="Rewrite" url="index.php?uri=/nl-NL/{R:1}" appendQueryString="true" /><br />
    &lt;/rule>
  </code>

</section>

<section>
  <h2>Routes</h2>

  <p>All relevant info can be read here: <a href='https://github.com/sofadesign/limonade/blob/master/README.mkd#routes'>https://github.com/sofadesign/limonade/blob/master/README.mkd#routes</a></p>
</section>

<section>
  <h2>URLS</h2>

  <h3>Generate an URL</h3>

  <code>url_for('home');</code>

  <p>or</p>

  <code>url_for('/home');</code>

  <p class="result"><?php echo url_for('/home'); ?></p>

  <p>It will take the $base_path into account.</p>

  <h3>Redirect</h3>

  <p>In a controller function you can redirect to another route or URL.</p>

  <code>
    redirect_to('/');
  </code>

</section>

<section>
  <h2>MultiLang URLS</h2>

  <h3>The framework is multilang out-of-the-box</h3>

  <p>The framework always work in multilang mode. Calling <em>_url();</em> will always use the default language.</p>

  <p><em>Note: The default lanuage is the language which is listed first in config.yml</em></p>

  <code>echo _url('home');</code>

  <p class="result"><?php echo _url('/home'); ?></p>

  <p>To explicitly generate a url for a language:</p>

  <code>echo _url('home', 'fr-BE');</code>

  <p class="result"><?php echo _url('/home', 'fr-BE'); ?></p>

</section>

<section>
  <h2>Templates</h2>

  <p>We use the <strong>`.html.php`</strong> extension so we can leverage the code highlighting of your IDE / editor.</p>

  <h3>Standard</h3>

  <p>Each route that is being called returns its response = HTML</p>

  <code>
    function home() {<br />
    &nbsp;&nbsp;return '&lt;body>test&lt;/body>';<br />
    }
  </code>

  <p>HTML templates are located in the apps/views directory and are returned like this:</p>

  <code>
    function home() {<br />
    &nbsp;&nbsp;return html('home.html.php');<br />
    }
  </code>

  <p>By default the layout.html.php file is used as layout template. You can however use a custon one:</p>

  <code>
    function home() {<br />
    &nbsp;&nbsp;return html('home.html.php', 'new-layout.html.php');<br />
    }
  </code>

  <h3>Partials</h3>

  <p>For repeating pieces of HTML, you can use partials:</p>

  <code>
    &lt;ul class="gallery"><br />
    &nbsp;&nbsp;&lt;?php<br />
    &nbsp;&nbsp;&nbsp;&nbsp;foreach($items as $id => $item) {<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo partial('partials/_item.html.php', array('item' => $item));<br />
    &nbsp;&nbsp;&nbsp;&nbsp;}<br />
    &nbsp;&nbsp;?&gt;<br />
    &lt;/ul>
  </code>

  <p>The <em>partial</em> function accepts a template name and a named array with variables that can be used in the partial.</p>
  
  <h3>Variables</h3>

  <p>Variables you want to use in a template must be set in your controller function.</p>

  <code>
    function home() {<br />
    &nbsp;&nbsp;set('value', 'test');<br /><br />
    &nbsp;&nbsp;return html('home.html.php', 'new-layout.html.php');<br />
    }
  </code>

  <p>In your template file</p>

  <code>
    &lt;?php<br />
    &nbsp;&nbsp;echo $value;<br />
    ?&gt;
  </code>

</section>

<section>
  <h2>Configuration</h2>

  <h3>Configuration from ./config/config.yml</h3>

  <p>The config.yml file is a configuration file. You have 2 ways to fetch values from the file.</p>

  <code>ProximityApp::$settings['db']['adapter'];</code>
  <p>and</p>
  <code>_c('db', 'adapter');</code>

  <p>Both give you: </p>

  <p class="result"><?php echo(_c('db', 'adapter')); ?></p>
</section>

<section>
  <h2>Errors / Logging / Debugging</h2>

  <h3>Errors</h3>

  <p>All PHP errors are catched and a Proximity error page is shown. You can however provide a custom error page for your application.<br />In the config.yml file you can set the name of the custom html file that is located in your views dir.</p>

  <code>
  errors:<br />
  &nbsp;&nbsp;custom_page: errors.html.php
  </code>  

  <p>By default the html file provides its own layout. If you want to incorporate the error page in your default layout, you can set `custom_layout` to true</p>

  <code>
  errors:<br />
  &nbsp;&nbsp;custom_page: errors.html.php<br />
  &nbsp;&nbsp;custom_layout: true
  </code>  

  <h3>Logging</h3>

  <p>You can use the _log() function to output stuff to your browser's console, converted to a json object. This can be useful if you want do inspect objects, arrays, strings in your app's code.</p>

  <code>_log($_POST)</code>

  <p>or</p>

  <code>_log($whatever_variable)</code>

  <p><em>Note: the config.yml file should have 'verbose: true' to show the debugging.</em></p>

  <code>
  verbose: true
  </code>  

</section>

<section>
  <h2>HTML Helpers</h2>

  <p>Created for your convenience!</p>

  <h3>Dropdown selected</h3>

  <code>_h_option_select($var1, $var2);</code>

  <p>Returns</p>

  <p class="result">selected='selected'</p>

  <p>If the variables are identical.<br />Example:</p>

  <code>
    &lt;select><br />
    &nbsp;&nbsp;&lt;?php foreach(ContactMoment::get_moments() as $id => $s): ?><br />
    &nbsp;&nbsp;&nbsp;&nbsp;&lt;option <strong>&lt;?php _h_option_select($id, $u->dag); ?></strong>>&lt;?php echo $s->name; ?>&lt;/option><br />
    &nbsp;&nbsp;&lt;?php endforeach; ?><br />
    &lt;/select>
  </code>
</section>

<section>
  <h2>Base Data Model</h2>

  <p>The BaseModel class can be used to inherit your model classes from.</p>

  <h3>Construct</h3>

  <p>Example:</p>

  <code>
    class Actie extends BaseModel {<br />
    &nbsp;&nbsp;public $id = -1;<br />
    &nbsp;&nbsp;public $email = '';<br />
    &nbsp;&nbsp;public $user = -1;<br />
    &nbsp;&nbsp;<br />
    &nbsp;&nbsp;public $lang = '';<br />
    &nbsp;&nbsp;public $creation_date = '';<br />
    &nbsp;&nbsp;<br />
    &nbsp;&nbsp;function __construct() { }<br />
    }
  </code>

  <p>If, for example, you have a form which posts data to a controller, you can easily assign all post variables to the class properties like this:</p>

  <code>
    $a = new Actie();<br />
    $a->construct($_POST);<br />
  </code>

  <h3>Finders</h3>

  <p>An easy way to create data models based on database queries, is to create them as static functions, additions, on your data model.<br />Example:</p>

  <code>
    class Actie extends BaseModel {<br />
    &nbsp;&nbsp;public static function find_by_id($id) {<br />
    &nbsp;&nbsp;&nbsp;&nbsp;$db = Actie::_get_db();<br />
    <br />
    &nbsp;&nbsp;&nbsp;&nbsp;if(!$db)<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return NULL;<br />
    <br />
    &nbsp;&nbsp;&nbsp;&nbsp;<em>some database calling code that returns a result</em>
    <br />
    <br />
    &nbsp;&nbsp;&nbsp;&nbsp;$a = new Actie();<br />
    &nbsp;&nbsp;&nbsp;&nbsp;$a->construct($result);<br />
    <br />
    &nbsp;&nbsp;&nbsp;&nbsp;return $a;<br />
    &nbsp;&nbsp;}<br />
    <br />
    &nbsp;&nbsp;public $id = -1;<br />
    &nbsp;&nbsp;public $email = '';<br />
    &nbsp;&nbsp;public $user = -1;<br />
    <br />
    &nbsp;&nbsp;public $lang = '';<br />
    &nbsp;&nbsp;public $creation_date = '';<br />
    <br />
    &nbsp;&nbsp;function __construct() { }<br />
    }
  </code>

  <p>Now you can use this to fetch data:</p>

  <code>$a = Actie::find_by_id(76);</code>

  <p>Will return an object of type `Actie` or NULL.</p>

</section>

<section>
  <h2>Webservice</h2>

  <p>You can call webservice WSDL methods from PHP with the Zend library.</p>
  <p>You start with loading the necessary Zend class in your bootstrap.php.<br />Add the following line after <em>Zend_Loader::loadClass('Zend_Db');</em></p>

  <code>Zend_Loader::loadClass('Zend_Soap_Client');</code>

  <p>Later on you can use the following code to call a method.</p>

  <code>
    $c = new Zend_Soap_Client('http://www.sappipositivity.com/ws/Service.asmx?WSDL');
    <br />
    $r = $c->getDetailByUrl(array('sUrl' => 'How-unexploited-land-can-improve-life'));
  </code>
</section>

<section>
  <h2>CSRF Protection</h2>

  <p>To make sure that we don't face Cross-site-request-forgery, we have a helper function (and underlying Class) to check for csrf tokens.</p>

  <p>The idea is that you provide for each form you want to have protection on a session token in a hidden input. When the POST action happens we check if the token in the form is the same a we currently have in our session object.</p>

  <p>In your controller function</p>

  <code>
    function controller_function() {<br />
    &nbsp;&nbsp;_protect_post();<br />
    } 
  </code>

  <p>This will generate a 500 error when the POST is forged.</p>

  <p>In your HTML form you provide the token.</p>

  <code>
    &lt;form action='/' method='POST'><br />
    &nbsp;&nbsp;&lt;input type='hidden' name='csrf_token' value='&lt;?php echo($_SESSION['_csrf']); ?>' /><br />
    &lt;/form>
  </code>

  <p>or</p>

  <code>
    &lt;form action='/' method='POST'><br />
    &nbsp;&nbsp;&lt;input type='hidden' name='csrf_token' value='&lt;?php echo(CSRF::get_token()); ?>' /><br />
    &lt;/form>
  </code>

  <p>The CSRF class has 3 public methods:</p>

  <code>CSRF::setup();</code>

  <p>Basic setup functions. Generates token and stores it in the session if it isn't already available.</p>

  <code>CSRF::get_token();</code>

  <p>Returns token from session.</p>

  <code>CSRF::verify_request(true | false);</code>

  <p>
    Verifies the incoming request. This function call happens also in our helper function <em>_protect_post();</em>.
    <br />
    <ul>
      <li>It returns <em>true</em> when your request method is GET.</li>
      <li>It returns <em>true</em> when token check is OK.</li>
      <li>It calls <em>halt(500)</em> which generates a server error (500).</li>
      <li>It returns false when <em>halt()</em> isn't available.</li>
      <li>It returns false when you call <em>_protect_post(false)</em> from your controller.</li>
    </ul>
  </p>
</section>

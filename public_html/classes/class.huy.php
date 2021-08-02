<?php

/**
 * This class is used to access a MySQL database
 *
 * @package Huy's
 * @author  Huy
 */

class huy extends MySQLIDatabase {

	protected $_database;
	public function __construct() {
		$this->_database = MySQLIDatabase::GetInstance();
	}

	function getGroupName($id) {
		if (!$id) {
			return;
		}

		$result = $this->_database->Query(APP_TABLES_PREFIX . 'manga_groups', 'name', array('id' => $id));
		return $result[0]['name'];
	}

	// Check if data exist
	function isExist($table, $select = null, $where = null) {
		$result = $this->_database->Query($table, $select, $where);
		return ((count($result) > 0) ? true : false);
	}
	function implodeGenres(array $listGenres) {
		$data = '';
		if (!is_array($listGenres)) {
			return false;
		}

		foreach ($listGenres as $key => $genre) {
			$data .= $this->slug($genre) . ',';
		}
		return rtrim($data, ',');
	}
	function generate_string($strength = 16) {
		$input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$input_length = strlen($input);
		$random_string = '';
		for ($i = 0; $i < $strength; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}
		return $random_string;
	}
	function getAllImages($args = array()) {
		global $bunnyCdn;
		$bunnyCdnStorage = new BunnyCDNStorage($bunnyCdn['folder'], $bunnyCdn['apiAccessKey']);
		// save the start time
		$started = time();

		$defaults = array(
			'urls' => array(), // array containing all the urls to fetch
			'batch' => 2, // fetch this many urls concurrently (don't do more than 200 if using savedir)
			'max_time' => (60 * 6 * 3), // maximum time allowed to complete all requests.  5 minutes
			'max_request_time' => 0, // maximum time an individual request will last before being closed. 2 minutes
			'max_connect_time' => 0, // The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.
			'max_redirs' => 10, // Number of redirects allowed
			'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.122 Safari/537.36;', // user-agent
			'headers' => array('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9', 'Referer: ' . $args['site']), // array of http headers, such as array( 'Cookie: thiscookie', 'Accept-Encoding: none' )
			'savedir' => '',
			'chapter' => '',
			'manga' => '',
		);
		$args = array_merge($defaults, $args);

		$urls = $batch = $user_agent = $headers = $savedir = $manga = $chapter = null;
		$max_time = $max_request_time = $max_connect_time = $max_redirs = null;
		extract($args, EXTR_IF_EXISTS);

		$newArray = [];

		// can't follow redirects when open_basedir is in effect
		if (strlen(ini_get('open_basedir')) > 0) {
			$max_redirs = 0;
		}

		$total_urls = count($urls);

		foreach (array_chunk($urls, $batch, true) as $the_urls) {
			$con = $fps = array();

			$mh = curl_multi_init(); // create a 'multi handle'

			curl_multi_setopt($mh, CURLMOPT_MAXCONNECTS, 20); // maximum amount of simultaneously open connections that libcurl may cache. D10.
			curl_multi_setopt($mh, CURLMOPT_PIPELINING, 1); //  Pipelining as far as possible for this handle. if you add a second request that can use an already existing connection, 2nd request will be "piped"
			$newArray = [];

			foreach ($the_urls as $i => $url) {
				if (preg_match('#^\/\/#is', $url)) {
					$url = 'http:' . $url;
				}

				$url = trim($url);

				$con[$i] = curl_init($url);

				// TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
				curl_setopt($con[$i], CURLOPT_RETURNTRANSFER, 1);

				// binary transfer mode
				curl_setopt($con[$i], CURLOPT_BINARYTRANSFER, 1);

				// TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
				curl_setopt($con[$i], CURLOPT_RETURNTRANSFER, 0);

				curl_setopt($con[$i], CURLOPT_SSL_VERIFYHOST, FALSE);
				curl_setopt($con[$i], CURLOPT_SSL_VERIFYPEER, FALSE);

				// $fileExtension = pathinfo($url, PATHINFO_EXTENSION );
				// if ($fileExtension) {

				// }
				preg_match('#\.(png|jpg|gif|jpeg|webp)#is', strtolower($url), $ext);
				$fileExtension = $ext[1];

				// if (!is_dir($savedir)) {
				// 	mkdir($savedir, 0777, true);
				// }
				$fileTemp = $fileName = $savedir . $this->generate_string(20) . '.' . $fileExtension;

				$fps[$i] = fopen($fileName, 'wb');

				// have curl save the file
				curl_setopt($con[$i], CURLOPT_FILE, $fps[$i]);

				// The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.
				curl_setopt($con[$i], CURLOPT_CONNECTTIMEOUT, $max_connect_time);

				// maximum time in seconds that you allow the libcurl transfer operation to take
				curl_setopt($con[$i], CURLOPT_TIMEOUT, $max_request_time);

				// allow following redirects
				if ($max_redirs > 0) {
					curl_setopt($con[$i], CURLOPT_FOLLOWLOCATION, 1);
				}

				// Number of redirects allowed
				curl_setopt($con[$i], CURLOPT_MAXREDIRS, $max_redirs);

				// TRUE to fail verbosely if the HTTP code returned is greater than or equal to 400. default return the page ignoring the code.
				curl_setopt($con[$i], CURLOPT_FAILONERROR, 0);

				// Do not output verbose information.
				curl_setopt($con[$i], CURLOPT_VERBOSE, 0);

				// A parameter set to 1 tells the library to include the header in the body output.
				curl_setopt($con[$i], CURLOPT_HEADER, 0);

				// TRUE to ignore any cURL function that causes a signal sent to the PHP.
				// curl_setopt( $con[ $i ], CURLOPT_NOSIGNAL, 1 );

				// TRUE to exclude the body from the output. Request method is then set to HEAD.
				// curl_setopt( $con[ $i ], CURLOPT_NOBODY, 1 );

				// A custom request method to use instead of "GET" or "HEAD" when doing a HTTP request.
				// curl_setopt( $con[ $i ], CURLOPT_CUSTOMREQUEST, 'GET' );

				// The User-Agent header
				if (!empty($user_agent)) {
					curl_setopt($con[$i], CURLOPT_USERAGENT, $user_agent);
				}

				// Additional headers to send
				if (count($headers) > 0) {
					curl_setopt($con[$i], CURLOPT_HTTPHEADER, $headers);
				}

				curl_multi_add_handle($mh, $con[$i]); // add the easy handle to the multi handle 'multi stack' $mh

				$newArray[] = $fileName;

			}

			$still_running = null;
			do {
				$status = curl_multi_exec($mh, $still_running);
			} while ($still_running > 0); // Processes each of the handles in the stack.

			foreach ($the_urls as $i => $url) {

				$code = curl_getinfo($con[$i], CURLINFO_HTTP_CODE);
				$rcount = curl_getinfo($con[$i], CURLINFO_REDIRECT_COUNT);
				$size = curl_getinfo($con[$i], CURLINFO_SIZE_DOWNLOAD);

				//if ( $code != 200 || $rcount > $max_redirs || curl_errno( $con[ $i ] ) ) {
				if ($rcount > $max_redirs || curl_errno($con[$i]) || $size <= 0) {
					// sleep( 2 );
					if (is_resource($fps[$i])) {
						fclose($fps[$i]);
					}

				}

				curl_multi_remove_handle($mh, $con[$i]); // remove handle from 'multi stack' $mh
				curl_close($con[$i]); // close the individual handle

			}

			curl_multi_close($mh); // close the multi stack

			// close the save file handlers
			foreach ($fps as $fp) {
				if (is_resource($fp)) {
					fclose($fp);
				}

			}
			$final = null;
			foreach ($newArray as $key => $fileName) {

				$directoryCdn = str_replace(array('../../../', 'uploads', 'temp'), ['', $manga, $chapter], $fileName);

				$upload = $bunnyCdnStorage->uploadFile($fileName, $bunnyCdn['folder'] . '/' . $directoryCdn);
				$final .= 'https://truyentranhaz.b-cdn.net/' . $directoryCdn . chr(13);
				//unlink($fileName);
			}
		}
		return $final;
	}

	function getId($table, $select = null, $where = null) {
		$query = $this->_database->Query($table, $select, $where);
		if (empty($query)) {
			return false;
		}

		$result = array_values($query[0]);
		return $result[0];
	}

	function updateViewsByDay($type, $manga, $dateName, $dateValue, $year) {
		if ($type == '') {
			return false;
		}
		$id = $this->getId(APP_TABLES_PREFIX . 'manga_views', 'id', array('manga' => $manga, 'type' => $type));
		if ($id) {
			// Update views
			if ($this->isExist(APP_TABLES_PREFIX . 'manga_views', 'id', array('id' => $id, $dateName => $dateValue, 'year' => $year))) {
				$this->_database->DirectQuery('UPDATE ' . APP_TABLES_PREFIX . 'manga_views SET views = views + 1 WHERE id = ' . $id);
			} else {
				$this->_database->Update(APP_TABLES_PREFIX . 'manga_views', array('id' => $id), array($dateName => $dateValue, 'year' => $year, 'views' => 1));
			}
		} else {
			$this->_database->Create(APP_TABLES_PREFIX . 'manga_views', array('manga' => $manga, 'type' => $type, $dateName => $dateValue, 'views' => 1, 'year' => $year));
		}
	}
	function updateViews($slug) {
		if ($slug == '') {
			return false;
		}
		$this->_database->DirectQuery('UPDATE ' . APP_TABLES_PREFIX . 'manga_mangas SET views = views + 1 WHERE slug = "' . $slug . '"');
	}
	// Add slashes to whole array element
	function addSlashes($input) {
		if (is_array($input)) {
			return array_map(__FUNCTION__, $input);
		} else {
			return addslashes($input);
		}
	}

	function Trim($input) {
		if (is_array($input)) {
			return array_map(__FUNCTION__, $input);
		} else {
			return trim($input);
		}
	}

	function stripSlashes($input) {
		if (is_array($input)) {
			return array_map(__FUNCTION__, $input);
		} else {
			return stripslashes($input);
		}
	}

	function clearXss($input) {
		if (is_array($input)) {
			return array_map(array($this, 'clearXss'), $input);
		} else {
			$input = preg_replace('#<script.*>.*</script>#imsU', '', $input);
			$input = preg_replace('#<script.*>#imsU', '', $input);
			$input = preg_replace('#</script>#imsU', '', $input);
			return $input;
		}
	}
	function HTMLspecialchars($input) {
		if (is_array($input)) {
			return array_map(__FUNCTION__, $input);
		} else {
			return htmlspecialchars($input);
		}
	}

	function create_dom($url, $follow = 1) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, " Google Mozilla/5.0 (compatible; Googlebot/2.1;)");
		if ($follow == 1) {
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		}
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, "http://www.google.com/bot.html");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
		$result = curl_exec($ch);
		return $result;
	}

	function curl_with_proxy($url) {
		$proxy = '111.65.243.225:80';
		//$proxyauth = 'user:password';
		$ch = @curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		$head[] = "Connection: keep-alive";
		$head[] = "Keep-Alive: 300";
		$head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
		$head[] = "Accept-Language: en-us,en;q=0.5";
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
		curl_setopt($ch, CURLOPT_ENCODING, '');
		curl_setopt($ch, CURLOPT_PROXY, $proxy);
		//curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Expect:',
		));
		$page = curl_exec($ch);
		curl_close($ch);
		return $page;
	}
	function curl($url) {
		$ch = @curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		$head[] = "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3";
		$head[] = "accept-language: vi-VN,vi;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5";
		$head[] = "cache-control: max-age=0";
		$head[] = "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 9999);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 9999);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		$page = curl_exec($ch);
		curl_close($ch);
		return $page;
	}
	function curl_post($url, $data, $referer = '') {
		$curl = curl_init();
		if (isset($referer)) {
			curl_setopt($curl, CURLOPT_REFERER, $referer);
		}
		$header = array();
		$header[] = "Content-type: application/x-www-form-urlencoded";

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_TIMEOUT, 9999999);
		curl_setopt($curl, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0", rand(4, 5)));
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		$html = curl_exec($curl);
		curl_close($curl);
		return $html;
	}
	// utf8 string to unsigned
	function koDau($str) {
		$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
		$str = preg_replace("/(đ)/", 'd', $str);
		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
		$str = preg_replace("/(Đ)/", 'D', $str);
		return $str;
	}
	// Convert string to slug
	function slug($str) {

		$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
		$str = preg_replace("/(đ)/", 'd', $str);
		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
		$str = preg_replace("/(Đ)/", 'D', $str);
		$str = str_replace(" ", "-", $str);
		$str = str_replace("_", "-", $str);
		$str = str_replace(".", "-", $str);
		$str = str_replace(":", "-", $str);
		$str = str_replace("/", "-", $str);
		$str = preg_replace('/[^A-Za-z0-9\-._]/', '', $str); // Removes special chars.
		$str = preg_replace('/-+/', '-', $str);

		$str = strtolower($str);
		return $str;
	}
	function accessManga() {
		if (empty($_SESSION['L'])) {
			if (KEY !== sha1(sha1($this->page()))) {
				return false;
			} else {
				$text = 'aHR0cHM6Ly9kb2NzLmdvb2dsZS5jb20vZG9jdW1lbnQvZC8xcXZZcDJibUU1d1VDOThrQkZ1bEFHY0NNQ3k3Z0FPMzUzNnMzRHd2SHdVcy9wcmV2aWV3';
				$url = base64_decode($text);
				$html = $this->curl($url);
				preg_match('#,"s":"(.*)"},{"ty"#isU', $html, $License);
				$License = stripslashes($License[1]);
				$json = json_decode($License);
				$page = $this->page();
				$manga_key = $json->License->$page->key;
				if ($manga_key === md5(sha1($this->page()))) {
					$_SESSION['L'] = true;
					return true;
				} else {
					return false;
				}
			}
		} else {
			return true;
		}

	}
	// redirect with javascript
	function redirect($url, $delay = "") {
		if ($delay != NULL) {
			echo '<script> setTimeout(\'window.location.href="' . $url . '"\', ' . $delay . ');</script>';
		} else {echo '<script> window.location.href="' . $url . '"; </script>';}
	}

	// substr function for utf8 string
	function utf8Substr($str, $from, $len) {
		return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $from . '}' .
			'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $len . '}).*#s',
			'$1', $str);
	}

	// Get this page URL with port
	function thisPage() {
		$pageURL = 'http';
		if($_SERVER["SERVER_PORT"] != "6161"){
			if (isset( $_SERVER["HTTPS"] ) && strtolower( $_SERVER["HTTPS"] ) == "on") {$pageURL .= "s";}
				$pageURL .= "://";
	 
			if ($_SERVER["SERVER_PORT"] != "80") {
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			} 
			else {
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			}
		} else {
			$pageURL = 'https://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}

	function page() {
		return $_SERVER['HTTP_HOST'];
	}

	// UP x level with URL example: input http://google.com/some/some up one level -> http://google.com/some/
	function upDir($url, $level) {
		if (strpos($url, '.html') || strpos($url, '.php')) {
			preg_match('/(.*).(php|html)(.*)/', $url, $matches);
			$url = $matches[1];
		}
		$url = explode('/', $url);
		$levels = count($url);
		for ($i = 1; $i <= $level; $i++) {
			unset($url[$levels - $i]);
		}
		$url = implode('/', $url);
		return $url;
	}

	// GET THE PAGE URL WITHOUT VARIABLE
	function thisPageNoVari() {
		$thisPage = $this->thisPage();
		$thisPageWithoutVariable = explode("?", $thisPage);
		return $thisPageWithoutVariable[0];
	}

	// DELETE DIR AND FILES
	public static function deleteDir($dirPath) {
		// if (! is_dir($dirPath)) {
		// 	throw new InvalidArgumentException("$dirPath must be a directory");
		// }
		// if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
		// 	$dirPath .= '/';
		// }
		// $files = glob($dirPath . '*', GLOB_MARK);
		// foreach ($files as $file) {
		// 	if (is_dir($file)) {
		// 		self::deleteDir($file);
		// 	} else {
		// 		unlink($file);
		// 	}
		// }
		// rmdir($dirPath);
	}

	// xx AGO
	function ago($time){
		$time = strtotime($time);
		$periods = array('second', 'minutes', 'hours', 'days', 'weeks', 'months', 'years');
		$lengths = array("60","60","24","7","4.35","12","10");
		$now = time();
		$difference     = $now - $time;
		$tense         = 'ago';
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
		$difference = round($difference);
		if($difference != 1) {
			$periods[$j].= $l['ago_period'];
		}
		return "$difference $periods[$j] $tense ";
	}

	function time_elapsed_string($datetime, $full = false) {
		$now = new DateTime;
		$then = new DateTime($datetime);
		$diff = (array) $now->diff($then);

		$diff['w'] = floor($diff['d'] / 7);
		$diff['d'] -= $diff['w'] * 7;

		$string = array(
			'y' => 'years',
			'm' => 'months',
			'w' => 'weeks',
			'd' => 'days',
			'h' => 'hours',
			'i' => 'minutes',
			's' => 'seconds',
		);

		foreach ($string as $k => &$v) {
			if ($diff[$k]) {
				$v = $diff[$k] . ' ' . $v . ($diff[$k] > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) {
			$string = array_slice($string, 0, 1);
		}

		return $string ? implode(', ', $string) . ' ago' : 'Just';
	}

	function Cookie() {
		if ($this->accessManga()) {
			define('MANGA', true);
		} else {
			define('MANGA', true);
		}
	}
/* Cache with gzip */

	// function cache($name){
	// 	if (file_exists(ROOT_DIR.'/caches/'.$name.'.html.gz') && time() - 18000 < filemtime(ROOT_DIR.'/caches/'.$name.'.html.gz')) {
	// 		$file = ROOT_DIR.'/caches/'.$name.'.html.gz';
	// 		$open_file = gzopen($file, "r");
	// 		while(!gzeof($open_file))
	// 		{
	// 			$file_content .= gzgets($open_file, 4096);
	// 		}
	// 		echo $file_content;
	// 		gzclose($open_file);
	// 		return true;
	// 	} else {
	// 		ob_start();
	// 		return false;
	// 	}
	// }
	// function cacheEnd($name){
	// 	$cached = gzopen(ROOT_DIR.'/caches/'.$name.'.html.gz', 'w9');
	// 	gzwrite($cached, ob_get_contents());
	// 	gzclose($cached);
	// 	ob_end_flush();

	// }
	// function cacheClear($name){
	// 	if (file_exists(ROOT_DIR.'/caches/'.$name.'.html.gz')) {
	// 		unlink(ROOT_DIR.'/caches/'.$name.'.html.gz');
	// 	}
	// }
	//
	/*
	Cache sql
*/
	function checkFile($name) {
		if (file_exists(ROOT_DIR . '/caches/' . $name . '.html')) {
			return true;
		} else {
			return false;
		}
	}
	function cacheSqlEnd($name, $data = null) {
		if ($data) {
			if (strstr($name, '/')) {
				$foder = explode('/', $name);
				if (!is_dir(ROOT_DIR . '/caches/' . $foder[0])) {
					mkdir(ROOT_DIR . '/caches/' . $foder[0]);
				}
			}
			$cached = fopen(ROOT_DIR . '/caches/' . $name . '.html', 'w');
			fwrite($cached, $data);
			fclose($cached);
			return true;
		} else {
			$file = ROOT_DIR . '/caches/' . $name . '.html';
			return file_get_contents($file);
		}

	}
/* Cache using html */

	function cache($name) {
		if (file_exists(ROOT_DIR . '/caches/' . $name . '.html') /*&& time() - 18000 < filemtime(ROOT_DIR.'/caches/'.$name.'.html')*/) {
			include ROOT_DIR . '/caches/' . $name . '.html';
			return true;
		} else {
			ob_start();
			return false;
		}
	}
	function cacheEnd($name) {
		if (strstr($name, '/')) {
			$foder = explode('/', $name);
			if (!is_dir(ROOT_DIR . '/caches/' . $foder[0])) {
				mkdir(ROOT_DIR . '/caches/' . $foder[0]);
			}
		}
		$cached = fopen(ROOT_DIR . '/caches/' . $name . '.html', 'w');
		fwrite($cached, ob_get_contents());
		fclose($cached);
		ob_clean();
		ob_end_flush();
	}
	function cacheClear($name) {
		if (file_exists(ROOT_DIR . '/caches/' . $name . '.html')) {
			unlink(ROOT_DIR . '/caches/' . $name . '.html');
		}
	}

}

?>
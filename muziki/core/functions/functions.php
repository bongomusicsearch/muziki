<?php defined('developers') ? : die("akses langsung ke file ini ditangguhkan");

function get_cache_path() {
  return store_dir() . '/cache';
}

function create_cache_json( $file, $content ) {
  if ( ! get_option( 'enable_cache' ) ) {
    return;
  }

  $cache_path = dirname( $file );
  if ( ! is_dir( $cache_path ) ) {
    if ( ! @mkdir( $cache_path, 0755, true ) ) {
      exit( 'Can\'t create cache directory. Please check your folder permission.' );
    }
  }

  if ( false !== ( $f = fopen( $file, 'w' ) ) ) {
    fwrite( $f, json_encode( $content ) );
    fclose( $f );
  }
}

function get_cache_json( $file ) {
  $cache_file = file_get_contents( $file );
  return json_decode( $cache_file, true );
}

function delete_cache_json( $path, $time = 3600 ) {
  $i = 0;
  $cache_folder = $path;

  if ( file_exists( $cache_folder ) ) {
    $it = new RecursiveDirectoryIterator( $cache_folder, RecursiveDirectoryIterator::SKIP_DOTS );
    $files = new RecursiveIteratorIterator( $it, RecursiveIteratorIterator::CHILD_FIRST );
    foreach( $files as $file ) {
      if ( time() - $file->getCTime() >= $time && ! $file->isDir() ) {
        unlink( $file->getRealPath() );
        $i++;
      }
    }
  }
}
/*End Cache.php*/

/*Common.php*/

function read_file_remove_empty_line($file = '3.txt'){
	return file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES | FILE_TEXT);
}

function get_search_query() {
  global $route;

  return urldecode( ucwords( str_replace(
    [ 'don-t', 'can-t', '-' ],
    [ 'don\'t', 'can\'t', ' ' ],
    ( isset( $route['vars'][0] ) ? $route['vars'][0] : null )
  ) ) );
}

function keyword_dir(){
	if (!empty(get_option('keyword_dir'))) {
	    if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/store/' . get_option('keyword_dir')) && is_dir($_SERVER['DOCUMENT_ROOT'] . '/store/' . get_option('keyword_dir')) ){
	        return $_SERVER['DOCUMENT_ROOT'] . '/store/'.get_option('keyword_dir');
	 	}else{
	 	    $kwdir = $_SERVER['DOCUMENT_ROOT'] . '/store/' . get_option('keyword_dir');
	 		@mkdir($kwdir, 0755, true );
	 	}
	}else{
		return $_SERVER['DOCUMENT_ROOT'] . '/store/default/keywords';
    }
}
function store_dir() {
  if ( is_dir( BASE . '/store/' . $_SERVER['HTTP_HOST'] ) ) {
    return BASE . '/store/' . $_SERVER['HTTP_HOST'];
  } else {
    return BASE . '/store/default';
  }
}

function get_badwords() {
	if ( file_exists( store_dir() . '/badwords.txt' ) ) {
		$bad_words = file_get_contents( store_dir() . '/badwords.txt' );
		return array_filter( explode( ',', $bad_words ) );
	} elseif ( file_exists( BASE . '/store/badwords.txt' ) ) {
		$bad_words = file_get_contents( BASE . '/store/badwords.txt' );
		return array_filter( explode( ',', $bad_words ) );
	} else {
		return [];
	}
}

function filter_badwords( $haystack, $needle, $offset = 0 ) {
	if ( is_array( $needle ) && ! empty( $needle ) ) {
		foreach( $needle as $word ) {
			if ( stristr( $haystack, trim( $word ) ) ) {
				return true;
			}
		}
	}

	return false;
}

function badword_redirect() {
	if ( filter_badwords( strtolower( get_search_query() ), get_badwords(), 0 ) ) {
		$exp_title = $static_exp_title = explode( ' ', strtolower( get_search_query() ) );

		if ( count( $exp_title ) > 1 ) {
			foreach( get_badwords() as $key => $value ) {
				$exp_value = explode( ' ', trim( $value ) );
				if ( count( $exp_value ) > 1 ) {
					foreach( $exp_value as $child_value ) {
						if ( ( $key = array_search( $child_value, $exp_title ) ) !== false ) {
							unset( $exp_title[$key] );
						}
					}
				} else {
					if ( ( $key = array_search( $value, $exp_title ) ) !== false ) {
						unset( $exp_title[$key] );
					}
				}
			}

			if ( count( $exp_title ) > 0 ) {
				if ( count( $exp_title ) != count( $static_exp_title ) ) {
					$redirect = search_permalink( implode( $exp_title, '-' ) );
				}
			} else {
				$redirect = site_url();
			}
		} else {
			$redirect = site_url();
		}
	}

	return ( isset( $redirect ) ) ? $redirect : false;
}

function set_recent_user_access( $data, $key, $limit = 25000 ) {
  if ( ! get_option( 'save_recent_searches' ) ) {
    return;
  }

	$get_data = [];
	$recent_data_file = store_dir() . '/searches.json';

	if ( file_exists( $recent_data_file ) ) {
		$json = file_get_contents( $recent_data_file );
		$get_data = json_decode( $json, true );
	}

	$key = search_array( $get_data, $key, $data[$key] );
	if ( $key >= 0 ) {
		unset( $get_data[$key] );
  } if ( count( $get_data ) >= $limit ) {
		array_pop( $get_data );
  }

  if ( count( $get_data ) > 0 ) {
		$update = array_merge( [ $data ], $get_data );
	} else {
		$update = [ $data ];
  }

	if ( file_exists( $recent_data_file ) ) {
		unlink( $recent_data_file );
  }

	$output = json_encode( $update );
	$recent_data_file_update = fopen( $recent_data_file, 'w' );
	fwrite( $recent_data_file_update, $output );
	fclose( $recent_data_file_update );
}

function get_recent_user_access( $limit = 20 ) {
	$recent_data_file = store_dir() . '/searches.json';
	if ( file_exists( $recent_data_file ) ) {
		$json = file_get_contents( $recent_data_file );
		$get_data = json_decode( $json, true );

		if ( $get_data ) {
      foreach( $get_data as $key => $item ) {
  			if ( ( $key + 1 ) > $limit ) {
  				break;
        }

  			$output[] = $item;
  		}
    }
	}

  return ( isset( $output ) ) ? $output : [];
}

function dmca_redirect() {
  $dmca = store_dir() . '/dmca.txt';
  if ( file_exists( $dmca ) ) {
    $urls = array_map( 'trim', file( $dmca ) );
  } else {
    $urls = [];
  }

  if ( in_array( canonical_url(), $urls ) ) {
    redirect( site_url() );
  }
}

function search_array( $array, $key, $value ) {
  if ( $array ) {
    foreach ( $array as $array_key => $subarray ) {
      if ( isset( $subarray[$key] ) && $subarray[$key] == $value ) {
  	    return $array_key;
       }
    }
  }

	return -1;
}

function permalink( $str, $delimiter = '-', $options = [] ) {
	$str = mb_convert_encoding( ( string ) $str, 'UTF-8', mb_list_encodings() );

	$defaults = [
		'delimiter' => $delimiter,
		'limit' => null,
		'lowercase' => true,
		'replacements' => [],
		'transliterate' => false,
	];

	$options = array_merge( $defaults, $options );

	$char_map = [
		// Latin
		'ÃƒÂ€' => 'A', 'ÃƒÂ' => 'A', 'ÃƒÂ‚' => 'A', 'ÃƒÂƒ' => 'A', 'ÃƒÂ„' => 'A', 'ÃƒÂ…' => 'A', 'ÃƒÂ†' => 'AE', 'ÃƒÂ‡' => 'C',
		'ÃƒÂˆ' => 'E', 'ÃƒÂ‰' => 'E', 'ÃƒÂŠ' => 'E', 'ÃƒÂ‹' => 'E', 'ÃƒÂŒ' => 'I', 'ÃƒÂ' => 'I', 'ÃƒÂŽ' => 'I', 'ÃƒÂ' => 'I',
		'ÃƒÂ' => 'D', 'ÃƒÂ‘' => 'N', 'ÃƒÂ’' => 'O', 'ÃƒÂ“' => 'O', 'ÃƒÂ”' => 'O', 'ÃƒÂ•' => 'O', 'ÃƒÂ–' => 'O', 'Ã…Â' => 'O',
		'ÃƒÂ˜' => 'O', 'ÃƒÂ™' => 'U', 'ÃƒÂš' => 'U', 'ÃƒÂ›' => 'U', 'ÃƒÂœ' => 'U', 'Ã…Â°' => 'U', 'ÃƒÂ' => 'Y', 'ÃƒÂž' => 'TH',
		'ÃƒÂŸ' => 'ss',
		'Ãƒ ' => 'a', 'ÃƒÂ¡' => 'a', 'ÃƒÂ¢' => 'a', 'ÃƒÂ£' => 'a', 'ÃƒÂ¤' => 'a', 'ÃƒÂ¥' => 'a', 'ÃƒÂ¦' => 'ae', 'ÃƒÂ§' => 'c',
		'ÃƒÂ¨' => 'e', 'ÃƒÂ©' => 'e', 'ÃƒÂª' => 'e', 'ÃƒÂ«' => 'e', 'ÃƒÂ¬' => 'i', 'ÃƒÂ­' => 'i', 'ÃƒÂ®' => 'i', 'ÃƒÂ¯' => 'i',
		'ÃƒÂ°' => 'd', 'ÃƒÂ±' => 'n', 'ÃƒÂ²' => 'o', 'ÃƒÂ³' => 'o', 'ÃƒÂ´' => 'o', 'ÃƒÂµ' => 'o', 'ÃƒÂ¶' => 'o', 'Ã…Â‘' => 'o',
		'ÃƒÂ¸' => 'o', 'ÃƒÂ¹' => 'u', 'ÃƒÂº' => 'u', 'ÃƒÂ»' => 'u', 'ÃƒÂ¼' => 'u', 'Ã…Â±' => 'u', 'ÃƒÂ½' => 'y', 'ÃƒÂ¾' => 'th',
		'ÃƒÂ¿' => 'y',

		// Latin symbols
		'Ã‚Â©' => '(c)',

		// Greek
		'ÃŽÂ‘' => 'A', 'ÃŽÂ’' => 'B', 'ÃŽÂ“' => 'G', 'ÃŽÂ”' => 'D', 'ÃŽÂ•' => 'E', 'ÃŽÂ–' => 'Z', 'ÃŽÂ—' => 'H', 'ÃŽÂ˜' => '8',
		'ÃŽÂ™' => 'I', 'ÃŽÂš' => 'K', 'ÃŽÂ›' => 'L', 'ÃŽÂœ' => 'M', 'ÃŽÂ' => 'N', 'ÃŽÂž' => '3', 'ÃŽÂŸ' => 'O', 'ÃŽ ' => 'P',
		'ÃŽÂ¡' => 'R', 'ÃŽÂ£' => 'S', 'ÃŽÂ¤' => 'T', 'ÃŽÂ¥' => 'Y', 'ÃŽÂ¦' => 'F', 'ÃŽÂ§' => 'X', 'ÃŽÂ¨' => 'PS', 'ÃŽÂ©' => 'W',
		'ÃŽÂ†' => 'A', 'ÃŽÂˆ' => 'E', 'ÃŽÂŠ' => 'I', 'ÃŽÂŒ' => 'O', 'ÃŽÂŽ' => 'Y', 'ÃŽÂ‰' => 'H', 'ÃŽÂ' => 'W', 'ÃŽÂª' => 'I',
		'ÃŽÂ«' => 'Y',
		'ÃŽÂ±' => 'a', 'ÃŽÂ²' => 'b', 'ÃŽÂ³' => 'g', 'ÃŽÂ´' => 'd', 'ÃŽÂµ' => 'e', 'ÃŽÂ¶' => 'z', 'ÃŽÂ·' => 'h', 'ÃŽÂ¸' => '8',
		'ÃŽÂ¹' => 'i', 'ÃŽÂº' => 'k', 'ÃŽÂ»' => 'l', 'ÃŽÂ¼' => 'm', 'ÃŽÂ½' => 'n', 'ÃŽÂ¾' => '3', 'ÃŽÂ¿' => 'o', 'ÃÂ€' => 'p',
		'ÃÂ' => 'r', 'ÃÂƒ' => 's', 'ÃÂ„' => 't', 'ÃÂ…' => 'y', 'ÃÂ†' => 'f', 'ÃÂ‡' => 'x', 'ÃÂˆ' => 'ps', 'ÃÂ‰' => 'w',
		'ÃŽÂ¬' => 'a', 'ÃŽÂ­' => 'e', 'ÃŽÂ¯' => 'i', 'ÃÂŒ' => 'o', 'ÃÂ' => 'y', 'ÃŽÂ®' => 'h', 'ÃÂŽ' => 'w', 'ÃÂ‚' => 's',
		'ÃÂŠ' => 'i', 'ÃŽÂ°' => 'y', 'ÃÂ‹' => 'y', 'ÃŽÂ' => 'i',

		// Turkish
		'Ã…Âž' => 'S', 'Ã„Â°' => 'I', 'ÃƒÂ‡' => 'C', 'ÃƒÂœ' => 'U', 'ÃƒÂ–' => 'O', 'Ã„Âž' => 'G',
		'Ã…ÂŸ' => 's', 'Ã„Â±' => 'i', 'ÃƒÂ§' => 'c', 'ÃƒÂ¼' => 'u', 'ÃƒÂ¶' => 'o', 'Ã„ÂŸ' => 'g',

		// Russian
		'ÃÂ' => 'A', 'ÃÂ‘' => 'B', 'ÃÂ’' => 'V', 'ÃÂ“' => 'G', 'ÃÂ”' => 'D', 'ÃÂ•' => 'E', 'ÃÂ' => 'Yo', 'ÃÂ–' => 'Zh',
		'ÃÂ—' => 'Z', 'ÃÂ˜' => 'I', 'ÃÂ™' => 'J', 'ÃÂš' => 'K', 'ÃÂ›' => 'L', 'ÃÂœ' => 'M', 'ÃÂ' => 'N', 'ÃÂž' => 'O',
		'ÃÂŸ' => 'P', 'Ã ' => 'R', 'ÃÂ¡' => 'S', 'ÃÂ¢' => 'T', 'ÃÂ£' => 'U', 'ÃÂ¤' => 'F', 'ÃÂ¥' => 'H', 'ÃÂ¦' => 'C',
		'ÃÂ§' => 'Ch', 'ÃÂ¨' => 'Sh', 'ÃÂ©' => 'Sh', 'ÃÂª' => '', 'ÃÂ«' => 'Y', 'ÃÂ¬' => '', 'ÃÂ­' => 'E', 'ÃÂ®' => 'Yu',
		'ÃÂ¯' => 'Ya',
		'ÃÂ°' => 'a', 'ÃÂ±' => 'b', 'ÃÂ²' => 'v', 'ÃÂ³' => 'g', 'ÃÂ´' => 'd', 'ÃÂµ' => 'e', 'Ã‘Â‘' => 'yo', 'ÃÂ¶' => 'zh',
		'ÃÂ·' => 'z', 'ÃÂ¸' => 'i', 'ÃÂ¹' => 'j', 'ÃÂº' => 'k', 'ÃÂ»' => 'l', 'ÃÂ¼' => 'm', 'ÃÂ½' => 'n', 'ÃÂ¾' => 'o',
		'ÃÂ¿' => 'p', 'Ã‘Â€' => 'r', 'Ã‘Â' => 's', 'Ã‘Â‚' => 't', 'Ã‘Âƒ' => 'u', 'Ã‘Â„' => 'f', 'Ã‘Â…' => 'h', 'Ã‘Â†' => 'c',
		'Ã‘Â‡' => 'ch', 'Ã‘Âˆ' => 'sh', 'Ã‘Â‰' => 'sh', 'Ã‘ÂŠ' => '', 'Ã‘Â‹' => 'y', 'Ã‘ÂŒ' => '', 'Ã‘Â' => 'e', 'Ã‘ÂŽ' => 'yu',
		'Ã‘Â' => 'ya',

		// Ukrainian
		'ÃÂ„' => 'Ye', 'ÃÂ†' => 'I', 'ÃÂ‡' => 'Yi', 'Ã’Â' => 'G',
		'Ã‘Â”' => 'ye', 'Ã‘Â–' => 'i', 'Ã‘Â—' => 'yi', 'Ã’Â‘' => 'g',

		// Czech
		'Ã„ÂŒ' => 'C', 'Ã„ÂŽ' => 'D', 'Ã„Âš' => 'E', 'Ã…Â‡' => 'N', 'Ã…Â˜' => 'R', 'Ã… ' => 'S', 'Ã…Â¤' => 'T', 'Ã…Â®' => 'U',
		'Ã…Â½' => 'Z',
		'Ã„Â' => 'c', 'Ã„Â' => 'd', 'Ã„Â›' => 'e', 'Ã…Âˆ' => 'n', 'Ã…Â™' => 'r', 'Ã…Â¡' => 's', 'Ã…Â¥' => 't', 'Ã…Â¯' => 'u',
		'Ã…Â¾' => 'z',

		// Polish
		'Ã„Â„' => 'A', 'Ã„Â†' => 'C', 'Ã„Â˜' => 'e', 'Ã…Â' => 'L', 'Ã…Âƒ' => 'N', 'ÃƒÂ“' => 'o', 'Ã…Âš' => 'S', 'Ã…Â¹' => 'Z',
		'Ã…Â»' => 'Z',
		'Ã„Â…' => 'a', 'Ã„Â‡' => 'c', 'Ã„Â™' => 'e', 'Ã…Â‚' => 'l', 'Ã…Â„' => 'n', 'ÃƒÂ³' => 'o', 'Ã…Â›' => 's', 'Ã…Âº' => 'z',
		'Ã…Â¼' => 'z',

		// Latvian
		'Ã„Â€' => 'A', 'Ã„ÂŒ' => 'C', 'Ã„Â’' => 'E', 'Ã„Â¢' => 'G', 'Ã„Âª' => 'i', 'Ã„Â¶' => 'k', 'Ã„Â»' => 'L', 'Ã…Â…' => 'N',
		'Ã… ' => 'S', 'Ã…Âª' => 'u', 'Ã…Â½' => 'Z',
		'Ã„Â' => 'a', 'Ã„Â' => 'c', 'Ã„Â“' => 'e', 'Ã„Â£' => 'g', 'Ã„Â«' => 'i', 'Ã„Â·' => 'k', 'Ã„Â¼' => 'l', 'Ã…Â†' => 'n',
		'Ã…Â¡' => 's', 'Ã…Â«' => 'u', 'Ã…Â¾' => 'z'
	];

	$str = preg_replace( array_keys( $options['replacements'] ), $options['replacements'], $str );

	if ( $options['transliterate'] ) {
		$str = str_replace( array_keys( $char_map ), $char_map, $str );
	}

	$str = preg_replace( '/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
	$str = preg_replace( '/(' . preg_quote( $options['delimiter'], '/') . '){2,}/', '$1', $str);
	$str = substr( $str, 0, ( $options['limit'] ? $options['limit'] : strlen( $str ) ) );
	$str = trim( $str, $options['delimiter'] );

	return $options['lowercase'] ? strtolower( $str ) : $str;
}

function base64_url_encode( $query ) {
	return rtrim( strtr( base64_encode( $query ), '+/', '-_' ), '=' );
}

function base64_url_decode( $query ) {
	return base64_decode( str_pad( strtr( $query, '-_', '+/' ), strlen( $query ) % 4, '=', STR_PAD_RIGHT ) );
}

function ads_file($size='responsive',$folder_ads='ads'){
	// $list = array("300x600.txt","320x100.txt","336x280.txt","468x60.txt","728x90.txt","970x90.txt","responsive.txt","120x600.txt","160x600.txt","300x250.txt");

	$file_txt = $size.'.txt';
	$file = store_dir().'/'.$folder_ads.'/'.$file_txt;
	$file_ada = file_exists($file);

	//if (in_array($file_txt,$list)) {
		if ($file_ada) {
		return include ($file);
		// return file_get_contents($file);
		}
		else{
			die("File ads $size tidak ditemukan");
		}
	// }else{
	// 	echo "sembarang";
	// }
	
}
function get_ads_size($size='responsive'){

	 switch ($size) {
	 	case '970x90':
	 		ads_file('970x90');
	 		break;
	 	case '728x90':
	 		ads_file('728x90');
	 		break;
	 	case '468x60':
	 		ads_file('468x60');
	 		break;
	 	case '336x280':
	 		ads_file('336x280');
	 		break;
	 	case '320x100':
	 		ads_file('320x100');
	 		break;
	 	case '300x600':
	 		ads_file('300x600');
	 		break;
	 	case '300x250':
	 		ads_file('300x250');
	 		break;
	 	case '160x600':
	 		ads_file('160x600');
	 		break;
	 	case '120x600':
	 		ads_file('120x600');
	 		break;

	 	default:
	 		ads_file('responsive');
	 		break;
	 }
}
// get_ads_size('970x90');
/*End Common.php*/

/*Device.php*/
function is_desktop(){
  $useragent = $_SERVER['HTTP_USER_AGENT'];
  return stripos($useragent,'mobile')===false && stripos($useragent,'tablet')===false && stripos($useragent,'ipad')===false ;
}
 
function is_tablet(){
  $useragent = $_SERVER['HTTP_USER_AGENT'];
  return stripos($useragent,'tablet')!==false || stripos($useragent,'tab')!==false;
}
function is_ipad(){
  $useragent = $_SERVER['HTTP_USER_AGENT'];
  return stripos($useragent,'ipad')!==false;
}
function is_mobile(){
  $useragent = $_SERVER['HTTP_USER_AGENT'];
  return stripos($useragent,'mobile')!==false || stripos($useragent,'nokia')!==false || stripos($useragent,'phone')!==false;
}
 
 
function deviceVAL($mobileVAL='',$desktopVAL='',$tabletVAL='',$ipadVAL=''){
  if(is_desktop()){
    return $desktopVAL;
  } else if(is_tablet()){
    return $tabletVAL;
  } else if(is_ipad()){
    return $ipadVAL!=null?$ipadVAL:$tabletVAL;
  } else if(is_mobile()){
    return $mobileVAL;
  }
}
/*End Device.php*/

/*General.php*/

function substrwords($text, $maxchar, $end='...') {
    if (strlen($text) > $maxchar || $text == '') {
        $words = preg_split('/\s/', $text);      
        $output = '';
        $i      = 0;
        while (1) {
            $length = strlen($output)+strlen($words[$i]);
            if ($length > $maxchar) {
                break;
            } 
            else {
                $output .= " " . $words[$i];
                ++$i;
            }
        }
        $output .= $end;
    } 
    else {
        $output = $text;
    }
    return $output;
}

function photon_cdn($img_url){
  $arr_1o   = array(0,1,2,3);
  $wp       = 'https://i'.$arr_1o[array_rand($arr_1o)].'.wp.com/';
  $wps       = 'https://i'.$arr_1o[array_rand($arr_1o)].'.wp.com/';
  
  if (get_option('photon_cdn')) {
  //  if (empty($img_url)) { return false; }
   return str_replace('http://', $wp , $img_url);
  }else{
    return $img_url;
  }
 
}

function http_https(){
  if (
    isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ||
    ! empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ||
    ! empty( $_SERVER['HTTP_X_FORWARDED_SSL'] ) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on'
  ) {
    $ssl = true;
  } else {
    $ssl = false;
  }

  $protocol = $ssl ? 'https://' : 'http://';
  return $protocol;
}

function domain_name(){
  $site_url = parse_url(canonical_url());
  $host = explode('.',$site_url['host']);

  if (isset($site_url['path'])) {
    $path = $site_url['path'];
  }else{
    $path = '';
  }

  if (count($host) > 2) {
      $domain = $host[1].'.'.$host[2].$path;
     
    }else{
      $domain = $site_url['host'].$path;
    }
    return $domain;  
}

function site_url($link_uri='') {
	if (
    isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ||
    ! empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ||
    ! empty( $_SERVER['HTTP_X_FORWARDED_SSL'] ) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on'
  ) {
		$ssl = true;
	} else {
    $ssl = false;
  }

	$protocol = $ssl ? 'https' : 'http';
	$host = '://' . $_SERVER['HTTP_HOST'];
	$path = PATH;
  $uri = isset($link_uri) ? $link_uri : '';
	$url = $protocol . $host . $path . $uri ;

	return $url;
}

function theme_aktif(){
  return get_option('theme');
}

function theme_url() {
  if (
    isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ||
    ! empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ||
    ! empty( $_SERVER['HTTP_X_FORWARDED_SSL'] ) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on'
  ) {
    $ssl = true;
  } else {
    $ssl = false;
  }

  $protocol = $ssl ? 'https' : 'http';
  $host = '://' . $_SERVER['HTTP_HOST'];
  $path = PATH;
  $url = $protocol . $host . $path . '/includes/themes/' . theme_aktif();

  return $url;
}

function canonical_url() {
  $path = ( PATH == '' ) ? '/' : PATH;
  $parse_uri = parse_url( $_SERVER['REQUEST_URI'] );
  $clean_path = str_replace( PATH, '', $parse_uri['path'] );

  if ( $path == '/' ) {
    $uri = ( $parse_uri['path'] != '/' ) ? '/' . ltrim( $parse_uri['path'], '/' ) : '';
  } else {
    $uri = ( $clean_path != '/' ) ? '/' . str_replace( PATH . '/', '', $parse_uri['path'] ) : '';
  }

	return site_url() . $uri;
}

function redirect( $url = '', $method = '', $time = 1 ) {
  switch( $method ) {
    case 'refresh':
      header( "Refresh:$time; url=$url" );
    break;

    default:
    	header( "Location: $url" );
	    exit;
    break;
  }
}

function uri_has_extension( $uri ) {
	$exp_uri = explode( '/', $uri );
	$last_item = end( $exp_uri );
	$exp_last_item = explode( '.', $last_item, 2 );
	$has_extension = ( count( $exp_last_item ) > 1 ) ? end( $exp_last_item ) : false;

	return $has_extension;
}

function print_error( $message = null ) {
  $html = '<!DOCTYPE html>';
  $html.= '<html>';
  $html.= '<head>';
  $html.= '<title>Error!</title>';
  $html.= '<style type="text/css">';
  $html.= 'body { padding: 0; margin: 0; overflow-y: scroll; line-height: 20px; font: normal 13px/20px "Helvetica Neue", Helvetica, Arial, sans-serif; background: #eee; color: #444; }';
  $html.= 'div { margin: 15px; padding: 10px 15px; border-left: 3px solid #e64b4b; background: #fff; }';
  $html.= '</style>';
  $html.= '</head>';
  $html.= '<body>';
  $html.= '<div><strong>ERROR:</strong> ' . $message . '</div>';
  $html.= '</body>';
  $html.= '</html>';

  exit( $html );
}

function print_array( $array = [], $exit = true ) {
	echo '<pre>';
	print_r( $array );
	( $exit ) ? exit( '<pre>' ) : '</pre>';
}

/*End General.php*/

/*Option.php*/
function get_option( $key = null, $default = null ) {
  // global $config, $site_config;
  global $config, $lang;

  // if ( ! is_null( $key ) && isset( $site_config[$key] ) ) {
  //   return $site_config[$key];
  // } elseif 
  if( ! is_null( $key ) && isset( $config[$key] ) ) {
    return $config[$key];
  } else {
    if ( $default ) {
      return $default;
    }
  }
}
/*End Option.php*/

/*Permalinks.php*/

function single_slug(){
  $slug = str_replace( '/%query%','', get_option( 'search_permalink' ) );
  return ucwords($slug);

}

function download_slug(){
  $slug = str_replace( '/%slug%-%id%','', get_option( 'download_permalink' ) );
  return ucwords($slug);

}

function search_permalink( $query ) {
  $query = permalink( urldecode( $query ) );
  $slug = str_replace( '%query%', $query, get_option( 'search_permalink' ) );
  return site_url() . '/' . $slug;
}

function download_permalink( $title, $id ) {
  $slug = permalink( $title );
  $id = base64_url_encode( $id );
  $full_slug = str_replace( [ '%slug%', '%id%' ], [ $slug, $id ], get_option( 'download_permalink' ) );
  return site_url() . '/' . $full_slug;
}

function file_permalink() {
  return site_url() . '/' . get_option( 'file_permalink' );
}

function sitemap_searches_permalink() {
  return site_url() . '/' . get_option( 'sitemap_searches_permalink' );
}

function sitemap_keywords_permalink($num) {
	  $slug = str_replace( '%num%', $num, get_option( 'sitemap_keywords_permalink' ) );
  return site_url() . '/' . $slug;
}

function sitemap_permalink() {
  return site_url() . '/' . get_option( 'sitemap_permalink' );
}

function disclaimer_permalink() {
  return site_url() . '/' . get_option( 'disclaimer_permalink' );
}

function tos_permalink() {
  return site_url() . '/' . get_option( 'tos_permalink' );
}

/*End Permalinks.php*/

/*Site.php*/
function site_title( $title = null, $sep = ' - ' ) {
  $title = ( ( $title ) ? $title . $sep : '' ) . get_option( 'site_name' );
  return $title;
}

function register_stylesheet( $file ) {
  echo '<link rel="stylesheet" type="text/css" media="screen" href="' . $file . '" />' . "\n";
}

function register_script( $file ) {
  echo '<script type="text/javascript" src="' . $file . '"></script>' . "\n";
}

function register_localize_script( $key, $args ) {
  $output = '<script type="text/javascript">' . "\n";
	$output.= '/* <![CDATA[ */' . "\n";
	$output.= 'var ' . $key . ' = ' . json_encode( $args ) . ';' . "\n";
	$output.= '/* ]]> */' . "\n";
	$output.= '</script>' . "\n";

  echo $output;
}

/*End Site.php*/
function BigFile($filename){
	$file = new SplFileObject($filename);

	// Loop until we reach the end of the file.
	while (!$file->eof()) {
	    // Echo one line from the file.
	    $data[] = $file->fgets();
	    return $data;
	    // echo $file->fgets();
	}

	// Unset the file to call __destruct(), closing the file handle.
	$file = null;
}

function readTheFile($path) {
    $lines = [];
    $handle = fopen($path, "r");

    while(!feof($handle)) {
        $lines[] = trim(fgets($handle));
    }

    fclose($handle);
    return $lines;
}
function iLinesInFile($sFileName) {
  $iLines = 0;
  if ($fh = fopen($sFileName, 'r')) {
  while (!feof($fh)) {
      fgets($fh); // Burn a line so feof will work correctly.
      $iLines++;  // This will increment even for blank lines and even if the very last line is blank.
    } // while.
  }// if.
  return $iLines;
} // iLinesInFile().
function count_line_ignore_empty_line($txt_file){
  if ($file = fopen($txt_file, 'r')) {
    // read the file into an array, strip newlines and ignore empty lines
    $aray_line = file($txt_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES | FILE_TEXT);
    return count($aray_line);   
  }
}

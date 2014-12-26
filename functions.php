<?php //if(!defined("ABSPATH")) die("Restricted Area");

	/**
	 * FROM WORDPRESS 3.9.1
	 * Sanitizes a filename, replacing whitespace with dashes.
	 *
	 * Removes special characters that are illegal in filenames on certain
	 * operating systems and special characters requiring special escaping
	 * to manipulate at the command line. Replaces spaces and consecutive
	 * dashes with a single dash. Trims period, dash and underscore from beginning
	 * and end of filename.
	 *
	 * @since 2.1.0
	 *
	 * @param string $filename The filename to be sanitized
	 * @return string The sanitized filename
	 */
	function sanitize_file_name( $filename ) {
			$filename_raw = $filename;
			$special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", chr(0));
			/**
			 * Filter the list of characters to remove from a filename.
			 *
			 * @since 2.8.0
			 *
			 * @param array  $special_chars Characters to remove.
			 * @param string $filename_raw  Filename as it was passed into sanitize_file_name().
			 */
			$filename = preg_replace( "#\x{00a0}#siu", ' ', $filename );
			$filename = str_replace($special_chars, '', $filename);
			$filename = preg_replace('/[\s-]+/', '-', $filename);
			$filename = trim($filename, '.-_');
			// Split the filename into a base and extension[s]
			$parts = explode('.', $filename);
			// Return if only one extension
			if ( count( $parts ) <= 2 ) {
					/**
					 * Filter a sanitized filename string.
					 *
					 * @since 2.8.0
					 *
					 * @param string $filename	 Sanitized filename.
					 * @param string $filename_raw The filename prior to sanitization.
					 */
					return $filename;
			}
			// Process multiple extensions
			$filename = array_shift($parts);
			$extension = array_pop($parts);
			//$mimes = get_allowed_mime_types();
			/*
			 * Loop over any intermediate extensions. Postfix them with a trailing underscore
			 * if they are a 2 - 5 character long alpha string not in the extension whitelist.
			 */
			/*foreach ( (array) $parts as $part) {
					$filename .= '.' . $part;
					if ( preg_match("/^[a-zA-Z]{2,5}\d?$/", $part) ) {
							$allowed = false;
							foreach ( $mimes as $ext_preg => $mime_match ) {
									$ext_preg = '!^(' . $ext_preg . ')$!i';
									if ( preg_match( $ext_preg, $part ) ) {
											$allowed = true;
											break;
									}
							}
							if ( !$allowed )
									$filename .= '_';
					}
			}*/
			$filename .= '.' . $extension;
			/** This filter is documented in wp-includes/formatting.php */
			return $filename;
	}

	function logTinyPng($data, $operator = "raw"){
		file_put_contents("./tinypng.log", json_encode(array(
			time() => array(
				"filename"	=> $_POST['name'],
				"data"		=> $data,
				"tiny"		=> empty($_POST['tinypng'])?'No':'yes',
				"operator"	=> $operator
				)
			)).PHP_EOL, FILE_APPEND|LOCK_EX);
	}
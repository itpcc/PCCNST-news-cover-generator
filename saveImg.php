<?php
	require_once dirname(__FILE__).'/functions.php';
	# tinyPNG service setting
	$key = "M8F38Emdbes8CpfdCpUdN5yVnhcfAZps";
	//die(var_dump($_POST));

	# we are a PNG image
	header('Content-type: image/png');

	# we are an attachment (eg download), and we have a name
	header('Content-Disposition: attachment; filename="' . sanitize_file_name($_POST['name']) .'"');
	
	#capture, replace any spaces w/ plusses, and decode
	$encoded = $_POST['imgdata'];
	$encoded = str_replace('data:image/png;base64,', '', $encoded);
	$encoded = str_replace(' ', '+', $encoded);
	$decoded = base64_decode($encoded);

	if(!empty($_POST['tinypng']) && $_POST['tinypng']==="Y"){
		//use tinyPNG service
		if(function_exists('curl_version')){
			//use via cURL if enabled
			$request = curl_init();
			curl_setopt_array($request, array(
				CURLOPT_URL => "https://api.tinypng.com/shrink",
				CURLOPT_USERPWD => "api:" . $key,
				CURLOPT_POSTFIELDS => $decoded,
				CURLOPT_BINARYTRANSFER => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HEADER => true,
				/* Uncomment below if you have trouble validating our SSL certificate.
				Download cacert.pem from: http://curl.haxx.se/ca/cacert.pem */
				CURLOPT_CAINFO => __DIR__ . "/cacert.pem",
				CURLOPT_SSL_VERIFYPEER => true
			));

			$response = curl_exec($request);
			logTinyPng($response, 'curl#1');
			if($response === false){
				/* if fail, send original image*/
				echo $decoded;
				logTinyPng("error#1 : ".curl_error($request));
			}
			else if (curl_getinfo($request, CURLINFO_HTTP_CODE) === 201) {
				/* Compression was successful, retrieve output from Location header. */
				$headers = substr($response, 0, curl_getinfo($request, CURLINFO_HEADER_SIZE));
				foreach (explode("\r\n", $headers) as $header) {
					if (substr($header, 0, 10) === "Location: ") {
						$request = curl_init();
						$url = substr($header, 10);
						curl_setopt_array($request, array(
							CURLOPT_URL => $url,
							CURLOPT_RETURNTRANSFER => true,
							/* Uncomment below if you have trouble validating our SSL certificate. */
							CURLOPT_CAINFO => __DIR__ . "/cacert.pem",
							CURLOPT_SSL_VERIFYPEER => true
						));
						$tinyPNGResult = curl_exec($request);
						if($tinyPNGResult===false) {
							echo $decoded;
							logTinyPng("url : '{$url}'".PHP_EOL."error#2 : ".curl_error($request));
							exit();
						}else{
							echo $tinyPNGResult;
							logTinyPng("PASS", "curl");
							exit();
						}
					}
				}
			} else {
				/* if fail, send original image*/
				echo $decoded;
				logTinyPng("raw#1");
			}
		}
		else{
			//use via fopen
			$url = "https://api.tinypng.com/shrink";
			$options = array(
				"http" => array(
					"method" => "POST",
					"header" => array(
						"Content-type: image/png",
						"Authorization: Basic " . base64_encode("api:$key")
					),
					"content" => $decoded
				),
				"ssl" => array(
					/* Uncomment below if you have trouble validating our SSL certificate.
					Download cacert.pem from: http://curl.haxx.se/ca/cacert.pem */
					"cafile" => __DIR__ . "/cacert.pem",
					"verify_peer" => true
				)
			);

			$result = fopen($url, "r", false, stream_context_create($options));
			logTinyPng(stream_get_contents($handle), 'fopen#1');
			if (!empty($result)) {
				/* Compression was successful, retrieve output from Location header. */
				foreach ($http_response_header as $header) {
					if (substr($header, 0, 10) === "Location: ") {
						$tinyPNGResult = fopen(substr($header, 10), "rb", false);
						if (!empty($tinyPNGResult)) fflush($tinyPNGResult);
						else{
							/* if fail, send original image*/
							echo $decoded;
							logTinyPng("error#3",'fopen');
						}
						exit();
					}
				}
				
				/* if fail, send original image*/
				echo $decoded;
				logTinyPng("raw#2");
			} else {
				/* if fail, send original image*/
				echo $decoded;
				logTinyPng("raw#3");
			}
		}
	}
	else{
		#write decoded data
		echo $decoded;
		logTinyPng("raw#4: no tiny => {$_POST['tinypng']}");
	}
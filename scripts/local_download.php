<?php
/*

This code is released under the Simplified BSD License:

Copyright 2004 Razvan Florian. All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are
permitted provided that the following conditions are met:

   1. Redistributions of source code must retain the above copyright notice, this list of
      conditions and the following disclaimer.

   2. Redistributions in binary form must reproduce the above copyright notice, this list
      of conditions and the following disclaimer in the documentation and/or other materials
      provided with the distribution.

THIS SOFTWARE IS PROVIDED BY Razvan Florian ''AS IS'' AND ANY EXPRESS OR IMPLIED
WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND
FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL Razvan Florian OR
CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

The views and conclusions contained in the software and documentation are those of the
authors and should not be interpreted as representing official policies, either expressed
or implied, of Razvan Florian.

http://www.coneural.org/florian/papers/04_byteserving.php

*/

function set_range($range, $filesize, &$first, &$last){
	/*
	Sets the first and last bytes of a range, given a range expressed as a string
	and the size of the file.

	If the end of the range is not specified, or the end of the range is greater
	than the length of the file, $last is set as the end of the file.

	If the begining of the range is not specified, the meaning of the value after
	the dash is "get the last n bytes of the file".

	If $first is greater than $last, the range is not satisfiable, and we should
	return a response with a status of 416 (Requested range not satisfiable).

	Examples:
	$range='0-499', $filesize=1000 => $first=0, $last=499 .
	$range='500-', $filesize=1000 => $first=500, $last=999 .
	$range='500-1200', $filesize=1000 => $first=500, $last=999 .
	$range='-200', $filesize=1000 => $first=800, $last=999 .

	*/
	$dash=strpos($range,'-');
	$first=trim(substr($range,0,$dash));
	$last=trim(substr($range,$dash+1));
	if ($first=='') {
		//suffix byte range: gets last n bytes
		$suffix=$last;
		$last=$filesize-1;
		$first=$filesize-$suffix;
		if($first<0) $first=0;
	} else {
		if ($last=='' || $last>$filesize-1) $last=$filesize-1;
	}
	if($first>$last){
		//unsatisfiable range
		header("Status: 416 Requested range not satisfiable");
		header("Content-Range: */$filesize");
		exit;
	}
}

function buffered_read($file, $bytes, $buffer_size=1024){
	/*
	Outputs up to $bytes from the file $file to standard output, $buffer_size bytes at a time.
	*/
	$bytes_left=$bytes;
	while($bytes_left>0 && !feof($file)){
		if($bytes_left>$buffer_size)
			$bytes_to_read=$buffer_size;
		else
			$bytes_to_read=$bytes_left;
		$bytes_left-=$bytes_to_read;
		$contents=fread($file, $bytes_to_read);
		echo $contents;
		flush();
	}
}

function byteserve($filename){
	/*
	Byteserves the file $filename.

	When there is a request for a single range, the content is transmitted
	with a Content-Range header, and a Content-Length header showing the number
	of bytes actually transferred.

	When there is a request for multiple ranges, these are transmitted as a
	multipart message. The multipart media type used for this purpose is
	"multipart/byteranges".
	*/

	$filesize=filesize($filename);
	$file=fopen($filename,"rb");

	$ranges=NULL;
	if ($_SERVER['REQUEST_METHOD']=='GET' && isset($_SERVER['HTTP_RANGE']) && $range=stristr(trim($_SERVER['HTTP_RANGE']),'bytes=')){
		$range=substr($range,6);
		$boundary='g45d64df96bmdf4sdgh45hf5';//set a random boundary
		$ranges=explode(',',$range);
	}

	if($ranges && count($ranges)){
		header("HTTP/1.1 206 Partial content");
		header("Accept-Ranges: bytes");
		if(count($ranges)>1){
			/*
			More than one range is requested.
			*/

			//compute content length
			$content_length=0;
			foreach ($ranges as $range){
				set_range($range, $filesize, $first, $last);
				$content_length+=strlen("\r\n--$boundary\r\n");
				// $content_length+=strlen("Content-type: application/pdf\r\n");
				$content_length+=strlen("Content-type: application/octet-stream\r\n");
				$content_length+=strlen("Content-range: bytes $first-$last/$filesize\r\n\r\n");
				$content_length+=$last-$first+1;
			}
			$content_length+=strlen("\r\n--$boundary--\r\n");

			//output headers
			header("Content-Length: $content_length");
			//see http://httpd.apache.org/docs/misc/known_client_problems.html for an discussion of x-byteranges vs. byteranges
			header("Content-Type: multipart/x-byteranges; boundary=$boundary");

			//output the content
			foreach ($ranges as $range){
				set_range($range, $filesize, $first, $last);
				echo "\r\n--$boundary\r\n";
				//echo "Content-type: application/pdf\r\n";
				echo "Content-type: application/octet-stream\r\n";
				echo "Content-range: bytes $first-$last/$filesize\r\n\r\n";
				fseek($file,$first);
				buffered_read ($file, $last-$first+1);
			}
			echo "\r\n--$boundary--\r\n";
		} else {
			/*
			A single range is requested.
			*/
			$range=$ranges[0];
			set_range($range, $filesize, $first, $last);
			header("Content-Length: ".($last-$first+1) );
			header("Content-Range: bytes $first-$last/$filesize");
			// header("Content-Type: application/pdf");
			header("Content-Type: application/octet-stream");
			fseek($file,$first);
			buffered_read($file, $last-$first+1);
		}
	} else{
		//no byteserving
		header("Accept-Ranges: bytes");
		header("Content-Length: $filesize");
		// header("Content-Type: application/pdf");
		header("Content-Type: application/octet-stream");
		readfile($filename);
	}
	fclose($file);
}

function serve($filename, $download){
	//Just serves the file without byteserving
	//if $download=true, then the save file dialog appears
	$filesize=filesize($filename);
	header("Content-Length: $filesize");
	// header("Content-Type: application/pdf");
	header("Content-Type: application/octet-stream");
	$filename_parts=pathinfo($filename);
	if($download) header('Content-disposition: attachment; filename='.$filename_parts['basename']);
	readfile($filename);
}

//unset magic quotes; otherwise, file contents will be modified
set_magic_quotes_runtime(0);

//do not send cache limiter header
ini_set('session.cache_limiter','none');

require_once("./functions.php");
require('../../ts-yt-dl-defaults/ts-yt-dl');
login_check(); //check for login and security
$public = $_GET['public'];
$filename=$_GET['filename']; //get partial file path
$dtype=$_GET['dtype']; //dtype of true user wants full download, all other dtype do byte range

//test to see if media request is a public media request
if ($public) {
	$filename="$public_path/$filename";
} else {
	$filename="$data_path/$userid/$filename";
}

//$filename='/myfile.pdf'; //this is the PDF file that will be byteserved
//drop out some debug info when we need it
//file_put_contents('php://stderr', print_r($filename, TRUE));

if ($dtype) {
	serve($filename, "1"); //basic download
} else {
	header("Cache-Control: no-cache,no-store");
	byteserve($filename); //byteserve it!
}
?>

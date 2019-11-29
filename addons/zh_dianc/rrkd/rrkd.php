<?php

	class Rrkd {


	public static function curlPost($url, $post_data = array(), $timeout = 15, $header = array(), $post_File = false) {
		$post_string = null;
		if (is_array ( $post_data ) && ! $post_File) {
			$post_string = http_build_query ( $post_data );
		} else {
			$post_string = $post_data;
			}
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_string );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header ); // 模拟的header头
		$result = curl_exec ( $ch );
		curl_close ( $ch );
		return $result;
} 







}





<?php
function getPlexMovieData($token){
	$pleXml=file_get_contents("http://imontou.ch:32400/library/sections/6/all?X-Plex-Token=" . $token);

	$xml=simplexml_load_string($pleXml);
	$videos=$xml->Video;

	$movieData = array();


	foreach($videos as $video){
		$rating_key=$video['ratingKey']->__toString();
		$ratingtmp=$video['rating'];
		if ($ratingtmp == ""){
			$rating = 0;
		} else {
			$rating=$video['rating']->__toString();
		}
		$file=$video->Media->Part['file']->__toString();

		$cur = array('rating_key'=>$rating_key,'rating'=>$rating,'file'=>$file);

		array_push($movieData, $cur);
		//echo $rating_key . " | " . $rating . " | " . $file . "<br>";
	}

	return $movieData;
}

function getPlexShowData($token){
	$pleXml=file_get_contents("http://imontou.ch:32400/library/sections/3/all?X-Plex-Token=" . $token);

	$xml=simplexml_load_string($pleXml);
	$videos=$xml->Directory;

	$showData = array();


	foreach($videos as $video){
		$rating_key=$video['ratingKey']->__toString();
		$ratingtmp=$video['rating'];
		if ($ratingtmp == ""){
			$rating = 0;
		} else {
			$rating=$video['rating']->__toString();
		}
		//$file=$video->Media->Part['file']->__toString();

		$cur = array('rating_key'=>$rating_key,'rating'=>$rating);

		array_push($showData, $cur);
		//echo $rating_key . " | " . $rating . "<br>";
	}

	return $showData;
}

function getMovieByRatingkey($rating_key, $movieData){
	$arrNumber = array_search($rating_key,array_column($movieData, 'rating_key'));

	return $movieData[$arrNumber];
}

function getShowByRatingkey($rating_key, $showData){
	$arrNumber = array_search($rating_key,array_column($showData, 'rating_key'));

	return $showData[$arrNumber];
}
?>

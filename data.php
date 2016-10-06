<?php
//Get the JSON from PlexPy
//TODO: Add live URL + parameters for different library types
$json=file_get_contents("http://localhost/cleanup/test.json");
$data=json_decode($json, true);
$medias=$data['response']['data']['data'];
$totalFileSize=0;
$totalMediaCount=0;

//Convert epoch timestamp to a human-readable form (29.01.2015)
function readableDate($epoch){
	//Return 'Never' when null was given
	if($epoch==""){
		return "Never";
	}
	
	return date("d.m.y", $epoch);
}

//Convert bytebased filesize to a human-readable form (15 GB)
function readableFileSize($filesize){
	$roundedGB = round($filesize/1024/1024/1024, 2);
	$roundedTB = round($filesize/1024/1024/1024/1024, 2);
	
	if(strlen($roundedGB)>6){
		return $roundedTB . " TB";
	} else {
		return $roundedGB . " GB";
	}
}

//Makes sure a playcount of 0 will be echoed as 0 and not null
function playcount($playcount){
	if($playcount==""){
		return 0;
	} else{
		return $playcount;
	}
}

function varGET($varname, $default){
	if(isset($_GET[$varname])){
		return $_GET[$varname];
	} else {
		return $default;
	}
}

function appendFilters($imdb_rating, $title, $addedAt, $playCount, $lastPlayed, $size){
	//User defined filters
	
	$minRating = varGET('minRating',0);
	$maxRating = varGET('maxRating',10);
	
	$searchString = varGET('searchString',"");
	$minAddedAt = varGET('minAddedAt',0);
	$maxAddedAt = varGET('maxAddedAt',9999999999999);
	$minPlaycount = varGET('minPlaycount',0);
	$maxPlaycount = varGET('maxPlaycount',9999999999999);
	$minLastPlayed = varGET('minLastPlayed',0);
	$maxLastPlayed = varGET('maxLastPlayed',9999999999999);
	$minSize = varGET('minSize',0);
	$maxSize = varGET('maxSize',999999999999999);
	
	//Filter Rating
	if($imdb_rating < $minRating || $imdb_rating > $maxRating){
		return false;
	}
	
	//Filter by String
	if($searchString != ""){
		//Look for occurences in title
		if(strpos(strtolower($title), strtolower($searchString)) === false){
			return false;
		}
	}

	//Filter by Added Date
	if($addedAt < $minAddedAt || $addedAt > $maxAddedAt){
		return false;
	}

	//Filter by last Played Date
	if($lastPlayed < $minLastPlayed || $lastPlayed > $maxLastPlayed){
		return false;
	}

	//Filter by Play Count
	if($playCount < $minPlaycount || $playCount > $maxPlaycount){
		return false;
	}

	//Filter by size
	if($size < $minSize || $size > $maxSize){
		return false;
	}
	
	return true;
}
?>

<table>
	<tr>
		<th>
			Medianame
		</th>
		<th>
			Filesize
		</th>
		<th>
			Added at
		</th>
		<th>
			Last Played
		</th>
		<th>
			Playcount
		</th>
		<th>
			IMdB
		</th>
		<th>
			Remove
		</th>
	</tr>

<?php

foreach($medias as $media){
	//Read json contents to variables
	$title = $media['title'];
	$year = $media['year'];
	$file_size = $media['file_size'];
	$rating_key = $media['rating_key'];
	$section_type = $media['section_type'];
	$media_type = $media['media_type'];
	$grandparent_rating_key = $media['grandparent_rating_key'];
	$last_played = $media['last_played'];
	$section_id = $media['section_id'];
	$play_count = $media['play_count'];
	$added_at = $media['added_at'];
	$parent_media_index = $media['parent_media_index'];
	$imdb_rating = 7.05;
	
	//Append filters	
	if (appendFilters($imdb_rating, $title, $added_at, $play_count, $last_played, $file_size)){
		//Echo variables
		echo "<tr>";
		echo "<td>";
		echo $title;
		echo "</td>";
		echo "<td>";
		echo readableFileSize($file_size);
		echo "</td>";
		echo "<td>";
		echo readableDate($added_at);
		echo "</td>";
		echo "<td>";
		echo readableDate($last_played);
		echo "</td>";
		echo "<td>";
		echo playcount($play_count);
		echo "</td>";
		echo "<td>";
		echo $imdb_rating;
		echo "</td>";
		echo "<td>";
		echo "<input type='checkbox'>";
		echo "</td>";
		echo "</tr>";
		
		//Calculate data for statistics
		$totalFileSize = $totalFileSize + $file_size;
		$totalMediaCount++;
	}
}
?>
</table>
<?php
echo "<br><center>Total Filesize: " . readableFileSize($totalFileSize) . " | Total Mediacount: " . $totalMediaCount . "</center>";
?>
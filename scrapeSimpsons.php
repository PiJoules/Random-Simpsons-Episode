<?php

require_once "simple_html_dom.php";

/**
 * Get all links
 *
 * $seasons = array(
 * 		[0] => array(
 * 			"season" => [season #],
 * 			"link" => [link to simpsons season],
 * 			"episodes" => array(
 * 				[0] => array(
 * 					"episode" => [episode #],
 * 					"link" => [link to episode]
 * 				),
 * 				...
 * 			)
 * 		)
 * 		...
 * )
 */
$seasonLinks = file_get_html("http://projectfreetv.ch/free/the-simpsons/")->find(".cat-item a");
$seasons = array();
foreach ($seasonLinks as $seasonLink) {
	$season = array();

	$season["season"] = getSeasonNumber($seasonLink->plaintext);
	$season["link"] = $seasonLink->href;
	$season["episodes"] = array();

	$episodeLinks = file_get_html($seasonLink->href)->find("tbody tr");
	foreach($episodeLinks as $episodeLink){
		$episodeLink = $episodeLink->find("a", 0);
		$episode = array();

		$episode["episode"] = getEpisodeNumber($episodeLink->plaintext);
		$episode["link"] = $episodeLink->href;

		array_push($season["episodes"], $episode);
	}

	array_push($seasons, $season);
}

echo json_encode($seasons);


/**
 * Misc. functions
 */

/**
 * Get season # from some string
 * @param  string 	$seasonString
 * @return int
 */
function getSeasonNumber($seasonString){
	preg_match("/\d+/", $seasonString, $matches);
	return intval($matches[0]);
}

/**
 * Get episode # from some string
 * @param  string 	$episodeString
 * @return int
 */
function getEpisodeNumber($episodeString){
	preg_match_all("/\d+/", $episodeString, $matches);
	//return json_encode($matches);
	return intval($matches[0][1]); // the first match should be the season #
}

?>

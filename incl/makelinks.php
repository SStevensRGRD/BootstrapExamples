<?php

function makeLinks($str) {
  $reg_exUrl = "/(((http|https|ftp|ftps)\:\/\/)|(www\.))[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\:[0-9]+)?(\/\S*)?/";
//  $reg_exUrl = '/\b(?:(?:https?|ftp|file):\/\/|www\.|ftp\.)[-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$]/i';
  //$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
  $urls = array();
  $urlsToReplace = array();
  if(preg_match_all($reg_exUrl, $str, $urls)) {
    $numOfMatches = count($urls[0]);
    $numOfUrlsToReplace = 0;
    for($i=0; $i<$numOfMatches; $i++) {
      $alreadyAdded = false;
      $numOfUrlsToReplace = count($urlsToReplace);
      for($j=0; $j<$numOfUrlsToReplace; $j++) {
        if($urlsToReplace[$j] == $urls[0][$i]) {
          $alreadyAdded = true;
        }
      }
      if(!$alreadyAdded) {
        array_push($urlsToReplace, $urls[0][$i]);
      }
    }
    $numOfUrlsToReplace = count($urlsToReplace);
    for($i=0; $i<$numOfUrlsToReplace; $i++) {
      $str = str_replace($urlsToReplace[$i], "<a href=\"".$urlsToReplace[$i]. "\" target=\"_blank\">" .$urlsToReplace[$i]."</a> ", $str);
    }
    return $str;
  } else {
    return $str;
  }
}
?>
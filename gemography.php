<?php
/* this piece of code to list the languages used by the 100 trending public repos on GitHub
for every language liat of repos use it and number of repos using this language * */

$url  = 'https://api.github.com/search/repositories?q=2021-3-1&sort=stars&order=desc';
$opts = [

  'http' => [
      
      'method'  => 'GET',
      'header'  => 'User-Agent: MyAgent/1.0',
    ]
];

$context  = stream_context_create($opts);
$result   = file_get_contents($url, false, $context);

// Convert data to array

$data       = json_decode($result, true);

// get items from data array

$items      = isset($data['items']) ? $data['items'] : []; 


// Loop items
$result=array();
$repos_listName=array();
foreach ($items as $item) {
 array_push($repos_listName,$item['name']);
 $language = explode(' ', $item['language'],100);
 array_push($result,$language);
  
}
//enhance language array to contain language name only
$enhanced=array();
foreach($result as $key => $value){
  foreach($value as $bigvalue => $subvalue)
  array_push($enhanced,$subvalue);
}
//count number of repos using language and organize repos name array 
$count_array = array();
$nodes_names=array();
$i=0;
foreach ($enhanced as $value) {
  $count_array[$value]++;
  $nodes_names[$value][]=$repos_listName[$i];
  $i++;
}

foreach($count_array as $key1 => $value1){
foreach($nodes_names as $key2 => $value2 ){
  if($key1 == $key2){
      //herer to push language counter to repos name array
    array_push($value2,$count_array[$key1]);
    //assign array of language repos name and counter to every language name into the count array 
    $count_array[$key1]=$value2;
  } 
}
}

$response=json_encode($set_array);
return $response;
?>


<?php
function getAPI($url)
{ 
  $ch = curl_init(); 
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $output = curl_exec($ch);
  $output =json_decode($output,JSON_UNESCAPED_UNICODE);
  curl_close($ch);
  return $output;
}

$Data=getAPI("http://codedb.csie2.nptu.edu.tw/skw_question/question3.php");

foreach($Data as $i => $key)
{
  echo ($i+1).": ";
  foreach($key as $arr)
  {
    echo $arr;
  }
  echo "<br>";
}

echo "組合共:".($i+1)."組";

?>



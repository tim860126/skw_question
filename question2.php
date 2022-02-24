<?php
header('Content-Type: application/json');
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

$AccountData=getAPI("http://test.sub.sakawa.com.tw/api.php?r=test_account");
$GiftData=getAPI("http://test.sub.sakawa.com.tw/api.php?r=test_gift");
$LogData=getAPI("http://test.sub.sakawa.com.tw/api.php?r=test_gift_log");
$result=array();;
$arr= array();
$n=count($LogData);
$Account=array();

for($i=0;$i<count($LogData);$i++)
{
  $Gift[$GiftData[$i]['level']]=$GiftData[$i]['point'];
}

for($i=0;$i<count($AccountData);$i++)
{
  $Account[$AccountData[$i]['account']]['levelGift']=$Gift[$AccountData[$i]['level']];
  $Account[$AccountData[$i]['account']]['level']=$AccountData[$i]['level'];
  $Account[$AccountData[$i]['account']]['id']=$AccountData[$i]['id'];
}

for($i=0;$i<count($LogData);$i++)
{
  if((int)$Account[$LogData[$i]['account']]['levelGift']!=(int)$LogData[$i]['get_point'])
  {
    $arr['問題資料']="Logid:".$LogData[$i]['id']." account:".$LogData[$i]['account'];
    $arr['發生問題狀況說明']="獲取點數不正確".$LogData[$i]['account']." level:".$Account[$LogData[$i]['account']]['level']."應獲取".$Account[$LogData[$i]['account']]['levelGift']."卻獲取".$LogData[$i]['get_point'];
    $result[]=$arr;
    
  
  //echo $Account[$LogData[$i]['account']]['levelGift'].":".$LogData[$i]['get_point']."</br>";
  }
}

$result=json_encode($result,JSON_UNESCAPED_UNICODE);

echo $result;
?>



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
$arr=array();
$result=array();
$tempnew="0";
$Log=getAPI("http://test.sub.sakawa.com.tw/api.php?r=transfer_log");
$time_1=$Log[0]['createtime'];
$sum=0;
for($i=0;$i<count($Log);$i++)
{
  $orig=$Log[$i]['orig'];
  $add=$Log[$i]['add'];
  $new=$Log[$i]['new'];
  $time_2=$Log[$i]['createtime'];
  $tempadd=(int)$orig+(int)$add;
  $id=$i+1;
  $sum=$sum+(int)$add;
  if($id!=(int)$Log[$i]['insert_id'])
  {
    $arr["問題資料"]="insert_id:".$Log[$i]['insert_id'];
    $arr["發生問題狀況說明"]="insert_id錯誤應為$id";
    $result[]=$arr;
  }
  
  if(strtotime($time_1)>strtotime($time_2))
  { 
    $arr["問題資料"]="insert_id:".$Log[$i]['insert_id'];
    $arr["發生問題狀況說明"]="時間戳錯誤 pre $time_1 next $time_2";
    $result[]=$arr;
  }
  else
  {
    $time_1=$time_2;
  }

  if((int)$new!=$tempadd)
  {
    $arr["問題資料"]="insert_id:".$Log[$i]['insert_id'];
    $arr["發生問題狀況說明"]="加總錯誤orig:$orig add:$add new:$tempadd";    
    $result[]=$arr;
  }

  if($tempnew!=$orig)
  {
    $tempnew=(string)((int)$tempnew+(int)$add);
    $arr["問題資料"]="insert_id:".$Log[$i]['insert_id'];
    $arr["發生問題狀況說明"]="orig與上一筆new不同已先更正為".$tempnew."做後續檢查";
    $result[]=$arr;
  }
  else
    $tempnew=(string)$tempadd;
}

$result=json_encode($result,JSON_UNESCAPED_UNICODE);

echo $result;

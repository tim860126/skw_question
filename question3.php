<?php
header('Content-Type: application/json');
function GCB(&$arr, &$result, $offset=0)
{
    $end=count($arr);

    if ($end== $offset) {
        $result[]=$arr;
        return;
    }

    for ($i = $offset; $i < $end; ++$i) {
        $tmp=$arr[$i];
        $arr[$i]=$arr[$offset];
        $arr[$offset]=$tmp;
        GCB($arr, $result, $offset+1);
        $tmp=$arr[$i];
        $arr[$i]=$arr[$offset];
        $arr[$offset]=$tmp;
    }
}

$arr = array('0','1','2','3','4','5','6','7');
$result=array();
GCB($arr,$result);

$result=json_encode($result,JSON_UNESCAPED_UNICODE);
echo $result;


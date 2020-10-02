<?php
header("content-type:text/html;charset=utf-8")
$output=exec('python search_pdf.py') //system('python test.py') system 有返回结果，exec没有返回结果
$array=explode(',',$output)
foreach($array as $value){
    echo $value."</br>"
}
?>
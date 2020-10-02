<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>pastpaper</title>
<link href="bootstrap.min.css" rel="external nofollow" rel="stylesheet" type="text/css" />
<script src="jquery-3.1.1.min.js"></script>
<script src="bootstrap.min.js"></script>
<style type="text/css">

  #wai{
    width:90%;
    margin:0 auto;
    padding:0px;
    font-size:170%;
  }
  #chuanshu{
    width:400px;
    margin:0 auto;
    padding:0px;}
  .waibtn{
    width:100%;;
  }
  .wjm,.wjbtn{
    width:50%;
    height:100%;
    float:left;
  }
  .item,.btn-primary{
    background-color: lightgray;
  }
  html{
    height: 100%;
  }
  button,input{
   border-width: 0px;
   border-radius: 3px;
   background-color: unset;
   cursor: pointer;
   outline: none;
   font-size:100%;
  }

</style>
</head>

<body style='background-image: url(background.jpg);background-attachment: fixed;background-repeat: no-repeat;background-size: auto 100%;'>
<br/>
<br/>
<br/>

<div id="wai">

<?php
session_start();
//定义目录
$fname = "./papers";//需要显示的目录
if(!empty($_SESSION["fname"]))
{
  $fname = $_SESSION["fname"];
}
$pname = dirname($fname); //取上级目录
echo "you are now in  " , $fname;
if($fname=="./papers")//注意路径的匹配
{
    $download = "不提供下载";
    echo "<script>alert('I am using Raspberry Pi as a server. (slow) It may take a while when you using zip download.');</script>";
    //到达了需要显示的最上层目录就不显示上一层标签了
}else{
    $download = "yes";
    echo "<button style='background-color:white;' type='button' id='prev' class='btn waibtn btn-success' url='{$pname}'>返回上一层</button>";
}
    //遍历目录下的所有文件显示
?>
<table style="width: 100%;">
<tr style="background-color: deepskyblue;"> <th>NO.</th> <th>NAME</th> <th>DOWNLOAD</th> </tr>
<?php
$number = 0;
$arr = glob($fname."/*");
foreach($arr as $v)
{
  $name = basename($v); //从完整路径中取文件名
  $name = iconv("gbk","utf-8",$name);
  //echo $v;
  $number = $number + 1;
  if(is_dir($v)){
      if($number%2==0){
          echo "<tr style='background-color: lightgrey;'> <th>$number</th> <th><button type='button' class='dir' url='{$v}'>{$name}</button></th> <th>";
          if($download=="yes"){
              echo "<a href='zip.php? url={$v}'><input type='button' value='下载'/></a>";
          }else{
              echo $download ;
          }
          echo "</th> </tr>";
      }else{
          echo "<tr style='background-color: lightpink;'> <th>$number</th> <th><button type='button' class='dir' url='{$v}'>{$name}</button></th> <th>";
          if($download=="yes"){
              echo "<a href='zip.php? url={$v}'><input type='button' value='下载'/></a>";
          }else{
              echo $download ;
          }
      echo "</th> </tr>";
      }
    }else{
      //echo $v;
      if($number%2==0){
          echo "<tr style='background-color: lightgrey;'> <th>$number</th> <th><a href='pdf.php? url=$v'><input type='button' value='$name'/></a></th> <th><a href='download.php? url={$v}'><input type='button' value='下载'/></a></th> </tr>";
      }else{
          echo "<tr style='background-color: lightpink;'> <th>$number</th> <th><a href='pdf.php? url=$v'><input type='button' value='$name'/></a></th> <th><a href='download.php? url={$v}'><input type='button' value='下载'></a></th> </tr>";
      }
  }
}
?>

</table>
</div>
</body>
<script type="text/javascript">

$(".dir").click(function(){
    var url = $(this).attr("url");
    $.ajax({
        url:"chuli2.php",
        data:{url:url},
        type:"POST",
        dataType:"TEXT",
        success: function(data){
            window.location.href="index.php" ;
          }
      });
  })
$("#prev").click(function(){
  var url = $(this).attr("url");
  $.ajax({
      url:"chuli2.php",
      data:{url:url},
      type:"POST",
      dataType:"TEXT",
      success: function(data){
          window.location.href="index.php" ;
        }
    });
  })

</script>
</html>

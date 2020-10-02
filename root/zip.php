<?php
    $path = $_GET["url"];//要压缩的文件的绝对路径
    $name = iconv("UTF-8", "GBK", $path);//加这行中文文件夹也ok了
    $filename = basename($name);//生成压缩文件名
    //echo $filename.$name;


    create_zip($path,$filename);
    if(!file_exists('./' . $filename . '.zip')){
        echo "<script>alert('sorry,some thing went wrong,call Jack. (#CREATE ERROR)');</script>";
        die;
    }

    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header('Content-disposition: attachment; filename=' . basename($filename . '.zip')); //文件名
    header("Content-Type: application/zip"); //zip格式的
    header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件
    header('Content-Length: ' . filesize('./' . $filename. '.zip')); //告诉浏览器，文件大小
    @readfile('./' . $filename . '.zip');//下载到本地
    @unlink('./' . $filename . '.zip');//删除服务器上生成的这个压缩文件

    function create_zip($path,$filename){
        $zip = new \ZipArchive();
        if($zip->open($filename.'.zip', \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
            addFileToZip($path, $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
            $zip->close(); //关闭处理的zip文件
        }
    }

    function addFileToZip($path,$zip){
        $path = glob($path."/*");
        foreach($path as $v){
            if(is_dir($v)){
                addFileToZip($v, $zip);
            }else{
                $zip->addFile($v);
            }

        }
        @closedir($path);
    }

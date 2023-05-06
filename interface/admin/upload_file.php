<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$type = isset($_GET['type']) ? purge($_GET['type']) : '';//1图片 2压缩包 3其他
if (($_FILES["file"]["type"] == "image/gif")
    || ($_FILES["file"]["type"] == "image/jpeg")
    || ($_FILES["file"]["type"] == "image/pjpeg")
    || ($_FILES["file"]["type"] == "image/png"))
{
    $size = $G['config']['upload_size']*1000;
    if($_FILES["file"]["size"] > $size){
        json(201,'上传文件大小不能超过'.$size.'kb');
    }
    if ($_FILES["file"]["error"] > 0)
    {
        json(201,"Error: " . $_FILES["file"]["error"]);
    }
    else
    {
        echo "Upload: " . $_FILES["file"]["name"] . "<br />";
        echo "Type: " . $_FILES["file"]["type"] . "<br />";
        echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
        echo "Stored in: " . $_FILES["file"]["tmp_name"];

        if($type==1){ //图片
            $lj = "../upload/images/";
        }elseif($type==2){ //压缩包
            $lj = "../upload/zip/";
        }else{
            $lj = "../upload/other/";
        }

        if (file_exists($lj.$_FILES["file"]["name"]))
        {
            json(201,'此文件已存在，请更换重命名后上传');
        } else{
            if(move_uploaded_file($_FILES["file"]["tmp_name"],$lj.$_FILES["file"]["name"])){
                json(200,$lj.$_FILES["file"]["name"]);
            }else{
                json(201,'上传失败');
            }
        }
    }
}
else
{
    json(201,'不支持此格式文件');
}
?>
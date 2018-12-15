<!DOCTYPE html>
    <?php
    /**
     * Created by PhpStorm.
     * User: Deng
     * Date: 2018/12/14 0014
     * Time: 11:00
     */
    //上传文件类型列表
    $uptype = array(
        'image/jpg',
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/bmp',);

    $max_file_size = 2000000; //上传文件大小限制, 单位BYTE


    $destination_folder="img/"; //上传文件路径，默认本地路径
    ?>

    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>文件上传</title>
    </head>
    <body>



    <form enctype="multipart/form-data" method="post" name="formup">
        <input type="file" name="inputfile">
        <input type="submit" name="upbut" value="上传">
        <p>允许上传的文件类型为: <?php echo implode(",", $uptype); ?>  </p>
    </form>

    <?php
         if ($_SERVER['REQUEST_METHOD']=='POST') {
             //is_uploaded_file判断指定的文件是否是通过 HTTP POST 上传的。
             //第二个参数查看文件的
             echo $_FILES["inputfile"]["tmp_name"];
             if (!is_uploaded_file($_FILES["inputfile"]["tmp_name"])) {
                 echo "图片不存在";
                 exit;
             }
             $file = $_FILES["inputfile"];
             if ($max_file_size < $file["size"]) {
                 echo '上传的图片过大';
                 exit;
             }
             //in_array  搜索数组中是否存在指定的值。
             if (!in_array($file["type"], $uptype)) {
                 echo "文件类型不符" + $file["type"];
                 exit;
             }
             //检查文件或目录是否存在
             if (!file_exists($destination_folder)) {
                 mkdir($destination_folder);
             }
             $filename = $file["tmp_name"];
             $image_size = getimagesize($filename);
             $pinfo = pathinfo($file["name"]);
             $ftype = $pinfo['extension'];
             $destination = $destination_folder . time() . "." . $ftype;
            if (file_exists($destination)&& $overwrite!=true){
                echo "同名文件已经存在了";
                exit;
            }
            if (!move_uploaded_file($filename,$destination)){
                echo "移动文件夹出错";
                exit;
            }
            $pinfo=pathinfo($destination);
            $fname=$pinfo["basename"];
            echo " <font color=red>已经成功上传</font><br>文件名: <font color=blue>".$destination_folder.$fname."</font><br>";


//    $pinfo = pathinfo($destination);
//    $fname = $pinfo["basename"];
//    echo " <font color=red>已经成功上传</font><br>文件名: <font color=blue>".$destination_folder.$fname."</font><br>";
//    echo " 宽度:".$image_size[0];
//    echo " 长度:".$image_size[1];
//    echo "<br> 大小:".$file["size"]." bytes";

         }
    ?>

    </body>
    </html>
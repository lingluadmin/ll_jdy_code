<?php
/**
 * Created by PhpStorm.
 * User: liuqiuhui
 * Date: 16/6/16
 * Time: 下午8:55
 */

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests;

class UploadController extends Controller
{

    public function imgUpload(){

        echo json_encode($_POST);die;

        echo json_encode(['file_infor'=>$_FILES['img']['tmp_name']]);die;
        $upFilePath = "uploads/images/";
        $ok=@move_uploaded_file($_FILES['img']['tmp_name'],$upFilePath);
        if($ok === FALSE){
            echo json_encode(['file_infor'=>'上传失败']);
        }else{
            echo json_encode(['file_infor'=>'上传成功']);
        }

    }

    //Ajax上传图片
    public function ajaxImgUpload()
    {
        $file   = Input::file('file');
        $id     = Input::get('id');
        $allowed_extensions = ["png", "jpg", "gif", "jpeg"];
        if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
            return ['error' => 'You may only upload png, jpg or gif.'];
        }

        $destinationPath = 'uploads/images/';
        $extension = $file->getClientOriginalExtension();
        $fileName = str_random(10).'.'.$extension;
        $file->move($destinationPath, $fileName);
        return Response::json(
            [
                'success' => true,
                'pic' => asset($destinationPath.$fileName),
                'id' => $id
            ]
        );
    }

    public function imgUploads(){

        $file = Input::file('myfile');
        if($file -> isValid()){
            //检验一下上传的文件是否有效.

            $clientName = $file ->  getClientOriginalName();
            $tmpName    = $file ->  getFileName();     //缓存在tmp文件夹中的文件名例如php8933.tmp 这种类型的.
            $realPath   = $file ->  getRealPath();    //这个表示的是缓存在tmp文件夹下的文件的绝对路径

            //例如我的是:G:/xampp/tmp/php5A69.tmp
            //这里要注意,如果我使用接下来的move方法之后, getRealPath() 就找不到文件的路径了.因为文件已经被移走了.
            //所以这里道出了文件上传的原理,将文件上传的某个临时目录中,然后使用Php的函数将文件移动到指定的文件夹.

            $entension = $file -> getClientOriginalExtension();   //上传文件的后缀.
            $mimeTye   = $file -> getMimeType();    //大家对mimeType应该不陌生了. 我得到的结果是 image/jpeg.
            //这里要注意一点,以前我们使用mime_content_type(),在php5.3 之后,开始使用 fileinfo 来获取文件的mime类型.所以要加入 php_fileinfo的php拓展.windows下是 php_fileinfo.dll,在php.ini文件中将 extension=php_fileinfo.dll前面的分号去掉即可.当然要重启服务器.
            ///最后我们使用
            $path = $file -> move('storage/uploads');

            //如果你这样写的话,默认是会放置在 我们 public/storage/uploads/php79DB.tmp
            //貌似不是我们希望的,如果我们希望将其放置在app的storage目录下的uploads目录中,并且需要改名的话..
            $path = $file -> move(app_path().'/storage/uploads',$newName);

            //这里app_path()就是app文件夹所在的路径.$newName 可以是你通过某种算法获得的文件的名称.主要是不能重复产生冲突即可.  比如 $newName = md5(date('ymdhis').$clientName).".".$extension;
            //利用日期和客户端文件名结合 使用md5 算法加密得到结果.不要忘记在后面加上文件原始的拓展名.

        }

    }
}
<?php

 define('IN_ECS',true);

  define('ERR_INVALID_IMAGE',             1);
  define('ERR_NO_GD',                     2);
  define('ERR_IMAGE_NOT_EXISTS',          3);
 define('ERR_DIRECTORY_READONLY',        4);
 define('ERR_UPLOAD_FAILURE',            5);
  define('ERR_INVALID_PARAM',             6);
 define('ERR_INVALID_IMAGE_TYPE',        7);
  define('IMAGE_DIR',        '');
   define('DATA_DIR',        '');
 define('ROOT_PATH',                     'D:/www.benhu.org/');
 
 
  
  function get_waterMark()
  {
   require_once ROOT_PATH.'/data/config.php';
      require_once ROOT_PATH.'/includes/cls_mysql.php';
  $db = new cls_mysql($db_host, $db_user, $db_pass , $db_name, EC_CHARSET,0,1);
  $sql = 'select value from ecs_shop_config where code = "watermark"';
  $watermark = $db->getOne($sql);
  $sql = 'select value from ecs_shop_config where code = "watermark_place"';
   $watermark_place = $db->getOne($sql);
  $sql = 'select value from ecs_shop_config where code = "watermark_alpha"';
   $watermark_alpha = $db->getOne($sql);
   return array('watermark'=>$watermark, 'watermark_place'=>$watermark_place, 'watermark_alpha'=>$watermark_alpha);
  }
  
  function isImage($filename){
 //定义检查的图片类型
     $types = array('.jpg','.png','.gif','.bmp');
	 foreach($types as $val)
	 {
	   if(strpos($filename,$val))
	   {
	    return true;
	   }
	 }
        return false;
   
}
function isGif($filename)
{
   if(strpos($filename,'.gif'))
	   {
	    return true;
	   }
        return false;  
}
function get_orig_fileName($sFilePath, $gif = '')
{
$sExtension = get_extension($sFilePath);

 $orig_fileName = str_replace( $sExtension ,"",$sFilePath  );
						   $orig_fileName = substr($orig_fileName,0,strlen($orig_fileName)-1); 
						   if($gif == 'gif')
						   {
						    $orig_fileName .= '_'.$gif."_orig.jpg";
						   }
						   else
						   {
						    $orig_fileName .= "_orig.".$sExtension;
						}
						   return $orig_fileName;
}					 
					 
function CopyFiles($sFilePath, $ext = '')
{
						 $orig_fileName = get_orig_fileName($sFilePath);
						   if (!copy($sFilePath,$orig_fileName )) {
								echo "failed to copy $sFilePath... ";
								return false;
							}
						
							return true;
}
function CopyWaterMarkFiles($sFilePath, $gif = '')
{
$waterMarkGoodPic = str_replace('_orig','',$sFilePath);
  if (!copy($sFilePath,$waterMarkGoodPic )) {
								echo "failed to copy $sFilePath... ";
                      return false;						
						}
							return $waterMarkGoodPic;
}

function get_extension($file)
{
return substr(strrchr($file, '.'), 1);
}

function renamed_GIF_to_JPG($sFilePath)
{
   $ext = get_extension($sFilePath);
   if($ext != 'gif' || $ext != '.gif')
    return $sFilePath;
	 $newFileName = str_replace('.gif','.jpg',$sFilePath);
	 
	 if(rename($sFilePath,$newFileName))
	 return $newFileName;
	 
	 return $sFilePath;
}
function convert_GIF_to_JPG($sFilePath)
{
 $ext = get_extension($sFilePath);
   if($ext != 'gif' && $ext != '.gif')
    return $sFilePath;
	
	$newFileName = str_replace('.gif','_gif.jpg',$sFilePath);
			     	
					$img = LoadGif($sFilePath);
								if(imagejpeg($img, $newFileName))
								{
								imagedestroy($img);
								unlink($sFilePath);
								return $newFileName;
								}
								else
								{
								imagedestroy($img);
								echo "gif文件:$sFilePath转jpp失败<br/>";
							return $sFilePath;
								}
									return $sFilePath;
}
function back_JPG_to_GIF($sFilePath)
{
 $ext = get_extension($sFilePath);
   if($ext != 'jpg' && $ext != '.jpg')
     return $sFilePath;
	
	$newFileName = str_replace('_gif.jpg','.gif',$sFilePath);
	 
	 if(rename($sFilePath,$newFileName))
	 return $newFileName;
	 
	 return $sFilePath;
}
function LoadGif($imgname)
{


    /* Attempt to open */
    $im = @imagecreatefromgif($imgname);

    /* See if it failed */
    if(!$im)
    {
        /* Create a blank image */
        $im = imagecreatetruecolor (150, 30);
        $bgc = imagecolorallocate ($im, 255, 255, 255);
        $tc = imagecolorallocate ($im, 0, 0, 0);

        imagefilledrectangle ($im, 0, 0, 150, 30, $bgc);

        /* Output an error message */
        imagestring ($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
    }

    return $im;
}




 ?>
<?php
/***********
***由于图片上传过多（商品详情处），ecshop没有提供删除机制。因而自己用代码进行清理
***服务器端采用的是fckeditor插件上传的。
***1.本地上传图片保存的路径是：images/upload/Image
***2.远程图片保存的路径是：images/upload/fckautosave
************/
define ('WEB_ROOT','D:/wamp/www/benhushop1231/');
set_time_limit(0); 

require_once WEB_ROOT.'/includes/my_func.php';
require_once WEB_ROOT.'includes/simple_html_dom.php';
require_once WEB_ROOT.'/data/config.php';
require_once WEB_ROOT.'/includes/cls_mysql.php';

    $db = new cls_mysql($db_host, $db_user, $db_pass , $db_name, EC_CHARSET,0,1);
    $images = getAllImgsInGoodsDescription();

    var_dump($images);

    traverse(WEB_ROOT.'images/upload/Image',false);
    traverse(WEB_ROOT.'images/upload/fckautosave',true);

    function getAllImgsInGoodsDescription()
    {
    	Global $db;
		$sql = "SELECT goods_id,goods_desc FROM ecs_goods WHERE goods_id < 5 ORDER BY goods_id ASC";
		$goods = $db->getAll($sql);

   		 $images = array();

	    foreach ($goods as $key => $good) {
    		$html = str_get_html($good['goods_desc']);
      	    if(empty($good['goods_desc']))
	        {
	       	  continue;
	        }

			foreach($html->find('img') as $element)
			{
				$src = explode('/', $element->src);
			 	$images[] = $src[count($src) - 1];
			}
			$html->clear(); 
			unset($html);	
	    }
	    return $images;
	}
   
	function traverse($path = '.', $flag = false ) 
	{           
        $current_dir = opendir($path);    //opendir()返回一个目录句柄,失败返回false
		
        while(($file = readdir($current_dir)) !== false)   //readdir()返回打开目录句柄中的一个条目
        {    
            $sub_dir = $path . DIRECTORY_SEPARATOR . $file;    //构建子目录路径
            if($file == '.' || $file == '..') 
            {
                continue;
            } 
            else if(is_dir($sub_dir) && $flag)//如果是目录,进行递归
            {    
                traverse($sub_dir,$flag);
            } 
            else //如果是文件,直接输出
            {    
			    $filePath = $path.'/'.$file;
		    	if(!isImage($filePath) || strpos($file,'_orig'))
				{
				    continue;
				}

				Global $images;		
			
				if(!in_array($file, $images))
				{
				    $ext = get_extension($filePath);
					$gif = ($ext == '.gif' || $ext == 'gif') ? 'gif' : ''; 
			   		$origFilePath = $path.'/'.get_orig_fileName($file,$gif);
					deleteFiles($filePath,$origFilePath);  
					echo "$filePath---Deleted<br/>";
					echo "$origFilePath---Deleted<br/>";
				}	
			}
        }
    }

    function deleteFiles()
    {
        $files = func_get_args();     //获取参数，返回参数数组
        foreach($files as $fileName)
        {
        	if(file_exists($fileName))
        	{
    			unlink($fileName);   
        	}	 
        }
               
    }

?>
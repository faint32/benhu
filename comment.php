<?php

/**
 * ECSHOP 提交用户评论
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: comment.php 17217 2011-01-19 06:29:08Z liubo $
*/
define('IN_ECS', true);

require_once(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'includes/cls_json.php');
require_once(ROOT_PATH . 'includes/lib_integral.php');
require_once(ROOT_PATH . 'includes/lib_order.php');

if (empty($_REQUEST['act']))
{
  $type=isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
  $order_id=isset($_REQUEST['order_id']) ? $_REQUEST['order_id'] : '';

  if($type=='' || $order_id=='' )
  {echo "type or order_id  is empty";  exit;}

	if($type=='upload_file')
	{
		$goods_id=isset($_REQUEST['goods_id']) ? $_REQUEST['goods_id'] : ''; 

		$path="uploads/comments/$order_id/$goods_id";   

		my_make_dir("D:/www.benhu.org/uploads/comments/");   // 建文件夹,存放退货凭证 
		my_make_dir("D:/www.benhu.org/uploads/comments/$order_id"); 
		my_make_dir("D:/www.benhu.org/uploads/comments/$order_id/$goods_id");
		  $fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);

		  if ($fn) {
				   $ext=file_extend($fn);
			   $fn = md5($fn.gmtime()).'.'.$ext;
			file_put_contents(
			   "D:/www.benhu.org/$path/$fn",
				file_get_contents('php://input')
			);
			$path = "$path/".$fn;
			echo $path;
	  }
	  $sql = "insert into ".$GLOBALS['ecs']->table('shaidan')."(order_id,goods_id,thumb) values($order_id,$goods_id,'$path')";
	  $flag = $GLOBALS['db']->query($sql);
	  if($flag) 
	  {
	  echo "shaidan pic insert into db success";
	  }
	  else
      {
	  echo " failed to insert shaidan pic";
	  }
	exit();
	}
	else if($type=="comment")
	{
	/*如果已经评论过了*/
	   $comment_id=isCommentOrNot($order_id);
	   if($comment_id)
	   {
		  show_message($content="您已经评论过了", $links = '返回用户中心', $hrefs = 'user.php', $type = 'info', $auto_redirect = true);
		 exit;
	   }

	/*如果还未评论过，将数据写入数据库*/
	  $goods_num = isset($_REQUEST['goods_num']) ? $_REQUEST['goods_num'] : '';
	  $anonymity = ($_REQUEST['anonymity'] == 'on') ? 1 : 0;
	  
	  $user_id = $_SESSION['user_id'];   $user_name = $_SESSION['user_name'];
	  $ip = real_ip();                   $add_time = gmtime();
	  $comments_list = array();
	  
	  $flag=1;
	  for($i = 0; $i < $goods_num; $i++)
	  {
		$goods_id = isset($_REQUEST["goods_id$i"]) ? $_REQUEST["goods_id$i"] : ''; 
		$comment_rate = !empty($_REQUEST["comment_rate$i"]) ? $_REQUEST["comment_rate$i"] : 5; 
		$comment_content = !empty($_REQUEST["comment_content$i"]) ? $_REQUEST["comment_content$i"] : '默认5星好评'; 
	   $sql = "insert into ".$GLOBALS['ecs']->table('comment').
	   "   (comment_type,id_value,user_name,  content,          comment_rank, add_time,ip_address,status,parent_id,user_id,is_anonymity,order_id)".
	   " values(0, $goods_id, '$user_name', '$comment_content', $comment_rate, $add_time, '$ip',    1,      0,    $user_id,  $anonymity, $order_id )";
	   if(!$GLOBALS['db']->query($sql)) 
	   {
	     $flag=0;  // 对当前的物品评论失败
	   }
	   else
	   {
	       user_get_point($_CFG['comment_integral'],$_SESSION['user_id'],1,"评论获取积分",0); //评论成功，获取相应积分
		   
		   
		   $sql = "select count(comment_id) from ".$GLOBALS['ecs']->table('comment')." where comment_type=0 and id_value=$goods_id";		  
		  $cmt_cnt = $GLOBALS['db']->getOne($sql);
		   if($cmt_cnt < 6) // 前5条评论额外获取积分
           {
		      user_get_point($_CFG['top5_integral'],$_SESSION['user_id'],1," 前5条评论额外获取积分",0);
		   }		   
	   }
	  }
	  if($flag) 
	  {
	   $content = '提交评论成功';
	   $hrefs = 'user.php?act=order_list&ctl=5';
	   
	   $order = order_info($order_id);
	   $integral = integral_to_give($order);
	   unfreeze_integral('order',$order['order_sn']);
	  }
	  else {$content = '提交评论失败';$hrefs = 'user.php?act=order_list';}
	 show_message($content, $links = '返回我的订单', $hrefs , $type = 'info', $auto_redirect = true);
	}
} 
else if($_REQUEST['act'] == 'article_comment')
{
	$id_value = intval($_REQUEST['article_id']);
    $content  = trim(compile_str($_REQUEST['comment']));
    $comment_rank = intval($_REQUEST['comment_rate']);
    $add_time = gmtime();

    if(!chechCaptcha())
    {
    	show_message('验证码不正确');
    	exit;
    }
    if(empty($content))
	{
		show_message('评论内容不能为空');
    	exit;
	}	  

    $sql = "INSERT INTO ".$GLOBALS['ecs']->table('comment')." (comment_type, id_value, 	email, user_name, content, comment_rank, add_time, ip_address, status, parent_id, user_id, order_id, is_anonymity) VALUES(1, '$id_value', '', '".$_SESSION['user_name']."', '$content', $comment_rank, $add_time, '".$_SESSION['last_ip']."', 1, 0, '".$_SESSION['user_id']."', '', 0)";
 
    if($GLOBALS['db']->query($sql))
    {
    	  $smarty->assign('redrectUrl',$_SERVER['HTTP_REFERER']);
            $smarty->assign('smalltext','已评论');
            $smarty->assign('content','您成功评论。3秒后将返回上一页，如果未跳转请');       
           $smarty->assign('action', 'pageRedirect');
            $smarty->display('user_passport.dwt');
    }
    else
    {
    	show_message("评论失败", '', '', 'error');
    }
	exit;
}
else if($_REQUEST['act']=='get_shaidanIntegral')
{
	user_get_point($_CFG['comment_shaidan'],$_SESSION['user_id'],1,"晒单获得额外积分",0);
	echo "晒单获得".$_CFG['comment_shaidan']."积分";
	exit;
}
else if($_REQUEST['act']=='ajax_isCommented')
{
	$order_id=isset($_REQUEST['order_id']) ? $_REQUEST['order_id'] : '';
	 $comment_id=isCommentOrNot($order_id);
		   if($comment_id)
		   {
		   echo '1';
		   }
		   else echo '0';
		   die;
}
else if($_REQUEST['act'] == 'gotopage')
{
   $cmt = new stdClass();
   $cmt->id   = !empty($_GET['id'])   ? intval($_GET['id'])   : 0;
   $cmt->type = !empty($_GET['type']) ? intval($_GET['type']) : 0;
   $cmt->page = isset($_GET['page'])   && intval($_GET['page'])  > 0 ? intval($_GET['page'])  : 1;
  
  $result = array('error' => 0, 'message' => '', 'content' => '');
   
   $comments = assign_comment($cmt->id, $cmt->type, $cmt->page);

    $smarty->assign('comment_type', $cmt->type);
    $smarty->assign('id',           $cmt->id);
    $smarty->assign('username',     $_SESSION['user_name']);
    $smarty->assign('email',        $_SESSION['email']);
    $smarty->assign('comments',     $comments['comments']);
    $smarty->assign('pager',        $comments['pager']);
	
	$result['message'] = $_CFG['comment_check'] ? $_LANG['cmt_submit_wait'] : $_LANG['cmt_submit_done'];
    $result['content'] = $smarty->fetch("library/comments_list.lbi");
	die(json_encode($result));
}

function isCommentOrNot($order_id)
{
	$sql = "select comment_id from ".$GLOBALS['ecs']->table('comment')." where order_id=$order_id";
		 $comment_id=$GLOBALS['db']->getOne($sql);
		 return $comment_id;
}

function my_make_dir($path){
	if(!file_exists($path))
	{
	mkdir($path); 
	}
}

//获取文件后缀名
function file_extend($file_name)
{
	$extend =explode("." , $file_name);
	$va=count($extend)-1;
	return $extend[$va];
}

function chechCaptcha()
{
	if (empty($_POST['captche']))
    {
     return false;
    }

    include_once('includes/cls_captcha.php');
    $validator = new captcha();
    $validator->session_word = 'captcha_word';

    if (!$validator->check_word(($_POST['captche'])))
    {
        return false;
    } 
    return true;
}
?>
<?php

/**
 * ECSHOP 会员中心
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: user.php 17217 2011-01-19 06:29:08Z liubo $
*/

/**
 *修改于8月20日
 *    在用户中心欢迎页(当前php页面)($action == 'default')：处
 *        ----增加了vip_name，you_may_favorite ，visit_history，collection_goods，cart_goods
 *        ----注释了next_rank_name 
 *    在这个php页面的底部：
 *        ----增加了函数：insert_history_userCenter(取得用户浏览商品的记录)
 *                        you_may_favorite(取得猜你喜欢的4件商品)
 *
*/
/**
 *修改于8月21日
 *    在用户中心欢迎页 (当前php页面)   ($action == 'comment_list')：处
 *        ----增加了vip_name等
 *        ----注释了next_rank_name 
 *   在这个php页面的底部：
 *        ----增加了一条分支：
 *                elseif ($action == 'you_may_love')
 *                    这条分支的作用是：处理猜你喜欢的ajax请求
 *
*/
/**
 *修改于8月22日
 *    在用户中心欢迎页(当前php页面)
 *        ----增加了 'complain_list'页面，处理用户投诉
 *        ----增加了 'return_goods'页面，处理用户退换货
 *        ----增加了 'delete_complain'，处理删除投诉的ajax请求
*在includes/lib_clips.php 
*	     ----增加了get_complain_list
*/
/**
 *修改于8月25日
 *    在用户中心欢迎页(当前php页面)
 *        ----增加了一条分支：
 *                elseif ($action == 'cancle_back_order')
  *                    这条分支的作用是：取消退货申请ajax调用
 *                elseif ($action == 'sub_return_goods')
 *                     接受用户的退/换货申请 
*/

//var_dump($_SERVER);exit;
define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_order.php');

/* 载入语言文件 */
require_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/user.php');


$user_id = $_SESSION['user_id'];
$action  = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : 'default';
$affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
$smarty->assign('affiliate', $affiliate);
$smarty->assign('script_name', 'user');
$smarty->assign('categories',       get_categories_tree_pro()); // 分类树
$back_act='';


// 不需要登录的操作或自己验证是否登录（如ajax处理）的act
$not_login_arr =
array('login','act_login','act_edit_phone_password','check_SMS_code','judge_usrNm','register','get_phone_password','get_email_password','act_register','act_edit_password','get_password','send_pwd_email','password', 'signin', 'add_tag', 'collect', 'return_to_cart', 'logout', 'email_list', 'validate_email', 'send_hash_mail', 'order_query', 'is_registered', 'check_email','clear_history','qpassword_name', 'get_passwd_question', 'check_answer', 'oath' , 'oath_login' , 'oath' , 'oath_login', 'other_login');

/* 显示页面的action列表 */
$ui_arr = array('security_settings','security_edit_psd','my_integral','comment_goods','my_rank','register','login', 'profile', 'order_list','check_SMS_code','get_phone_password','get_email_password', 'order_detail', 'address_list', 'collection_list',
'message_list','complain_list','return_goods', 'tag_list', 'get_password', 'reset_password', 'booking_list', 'add_booking', 'account_raply',
'account_deposit', 'account_log', 'account_detail', 'act_account', 'pay', 'default', 'bonus', 'group_buy', 'group_buy_detail', 'affiliate', 'comment_list', 'coupons', 'validate_email','track_packages', 'transform_points','qpassword_name', 'get_passwd_question', 'check_answer');
 $smarty->assign('categories',       get_categories_tree_pro()); // 分类树
 user_infomation($smarty,$user_id);  //chen-0917
/* 未登录处理 */
if (empty($_SESSION['user_id']))
{
    if (!in_array($action, $not_login_arr))
    {
        if (in_array($action, $ui_arr))
        {
            /* 如果需要登录,并是显示页面的操作，记录当前操作，用于登录后跳转到相应操作
            if ($action == 'login')
            {
                if (isset($_REQUEST['back_act']))
                {
                    $back_act = trim($_REQUEST['back_act']);
                }
            }
            else
            {}*/
            if (!empty($_SERVER['QUERY_STRING']))
            {
                $back_act = 'user.php?' . strip_tags($_SERVER['QUERY_STRING']);
            }
            $action = 'login';
        }
        else
        {
            //未登录提交数据。非正常途径提交数据！
            die($_LANG['require_login']);
        }
    }
}

/* 如果是显示页面，对页面进行相应赋值 */
if (in_array($action, $ui_arr))
{
    assign_template();
    $position = assign_ur_here(0, $_LANG['user_center']);
    $smarty->assign('page_title', $position['title']); // 页面标题
    $smarty->assign('ur_here',    $position['ur_here']);
    $sql = "SELECT value FROM " . $ecs->table('shop_config') . " WHERE id = 419";
    $row = $db->getRow($sql);
    $car_off = $row['value'];
    $smarty->assign('car_off',       $car_off);
    /* 是否显示积分兑换 */
    if (!empty($_CFG['points_rule']) && unserialize($_CFG['points_rule']))
    {
        $smarty->assign('show_transform_points',     1);
    }
    $smarty->assign('helps',      get_shop_help());        // 网店帮助
    $smarty->assign('data_dir',   DATA_DIR);   // 数据目录
    $smarty->assign('action',     $action);
    $smarty->assign('lang',       $_LANG);
}
	
//用户中心欢迎页 chen-0915
if ($action == 'default')
{
    include_once(ROOT_PATH .'includes/lib_clips.php');
	include_once(ROOT_PATH . 'includes/cls_orders.php');

	
	 $all_order_list = new order_list();
	

	for($i=0; $i < $all_order_list->elem_count; $i++)
	 {
	   $record_count = $db->getOne("SELECT COUNT(*) FROM " .$ecs->table('order_info'). " WHERE user_id = '$user_id'".$all_order_list->where[$i]);
	   $all_order_list->orders[$i] = get_all_orders($user_id, 0, 0,$all_order_list->where[$i],$all_order_list->comment[$i], 1);  
	 } 

	    $smarty->assign("unpaid_orders", $all_order_list->orders[1]);$smarty->assign("unpaid_count", count($all_order_list->orders[1]));
	    $smarty->assign("unrecieved_orders", $all_order_list->orders[3]);$smarty->assign("unrecieved_count", count($all_order_list->orders[3]));
	    $smarty->assign("uncommented_orders", $all_order_list->orders[4]);$smarty->assign("uncommented_count", count($all_order_list->orders[4]));
	
    if ($rank = get_rank_info())
    { 
	  $smarty->assign('rank_name', sprintf($_LANG['your_level'], $rank['rank_name']));
	   //$smarty->assign('vip_name',  $rank['rank_name']);
        /*if (!empty($rank['next_rank_name']))
        {
            $smarty->assign('next_rank_name', sprintf($_LANG['next_level'], $rank['next_rank'] ,$rank['next_rank_name']));
        }*/
    }
	$sql = "select chat_validated,email,mobile_phone from ".$GLOBALS['ecs']->table('users')." where user_id = $user_id";
    $info_validate = $GLOBALS['db']->getRow($sql);
    $smarty->assign('info_validate',$info_validate);
	
$sql = 'SELECT media_type, ad_code, ad_link FROM ' . $ecs->table("ad") . ' WHERE position_id = 14 and enabled = 1 order by ad_id ';
	   $ad = $db->getRow($sql, true);
   $smarty->assign('ad_userCenter', $ad);
	
    $record_count = $db->getOne("SELECT COUNT(*) FROM " .$ecs->table('collect_goods').  " WHERE user_id='$user_id' ORDER BY add_time DESC");
	$smarty->assign('record_count', $record_count);   //收藏的商品的总数
	$cart_goods=get_cart_goods();   //购物车里的数据
	$smarty->assign('you_may_favorite' ,you_may_favorite());//用户浏览记录
	$smarty->assign('visit_history' ,insert_history_userCenter());//用户浏览记录
	$smarty->assign('collection_goods' ,get_collection_goods($user_id));//收藏的商品(取10个)
	$smarty->assign('cart_goods' ,$cart_goods['goods_list']);    //获取购物车里的商品列表
	$smarty->assign('info',        get_user_default($user_id));
    $smarty->assign('user_notice', $_CFG['user_notice']);
    $smarty->assign('prompt',      get_user_prompt($user_id));
    $smarty->display('user_clips.dwt');
}
if($action == 'check_SMS_code')
{
    $mobile_phone = $_REQUEST['mobilePhone'];
    $verify_code = $_REQUEST['verify_code'];          
     $sql = "SELECT user_id from ecs_users where mobile_phone=$mobile_phone";
     $user_id = $db->getOne($sql);  

    $sql = "SELECT short_message from ecs_verified_sms where user_id=$user_id";
    $short_message = $db->getOne($sql);
  
     if($verify_code== $short_message)
     { 
    header("Cache-control:no-cache,no-store,must-revalidate");
        header("Pragma:no-cache");
      header("Expires:0");
     if($_COOKIE['resetpw_success_vph']==$_REQUEST['cookie_value'])
     {
           $smarty->assign('redrectUrl',"user.php");
            $smarty->assign('smalltext','密码已修改，页面失效');
            $smarty->assign('content','密码之前已被修改。3秒后将返回登陆页，请用新密码登陆，如果未返回请');       
           $smarty->assign('action', 'pageRedirect');
            $smarty->display('user_passport.dwt');
        
     }
     else
      {
          $smarty->assign('cookie_value', $_REQUEST['cookie_value']);
          $smarty->assign('uid',    $user_id);
            $smarty->assign('action', 'reset2_password');
            $smarty->display('user_passport.dwt');
       }
    }
    else{
       $user_name=$_REQUEST['mobilePhone'];
       $smarty->assign('redrectUrl',"user.php?act=get_phone_password&user_name=$user_name");
         $smarty->assign('smalltext','验证码有误！');
          $smarty->assign('content','您输入的验证码有误，3秒后自动返回，如果未返回请');
       
       $smarty->assign('action', 'pageRedirect');
      $smarty->display('user_passport.dwt');
       // echo "验证码出错";
       // exit();
    }
}
/* 验证,修改手机号 chen-0912*/
if($action=="about_verify_phone")
{
  $type=!empty($_REQUEST['type'])?$_REQUEST['type']:'verify';
   $sms = !empty($_REQUEST['validator'])?$_REQUEST['validator']:'';
   $phone = !empty($_REQUEST['phone'])?$_REQUEST['phone']:'';
   
   switch($type)
   {
     case 'verify':
	    $sql = "select short_message from ".$GLOBALS['ecs']->table('verified_sms')." where user_id='$user_id' and type=1";
         $short_message = $GLOBALS['db']->getOne($sql);
		 $rec = 0;
		 if($sms == $short_message)
		 {
		   $sql = "select chat_validated from ".$GLOBALS['ecs']->table('users')."  where user_id='$user_id' ";
		   $chat_validated = $GLOBALS['db']->getOne($sql);

		   switch($chat_validated)
		   {
		     case 0:
			   $sql = "update ".$GLOBALS['ecs']->table('users')." set chat_validated = 2 where user_id='$user_id' ";
			 break;
			 case 1:
			  $sql = "update ".$GLOBALS['ecs']->table('users')." set chat_validated = 3 where user_id='$user_id' ";
			 break;
		   }
		   $flag=$GLOBALS['db']->query($sql);
		   if($flag) $rec=1;
		 
		 }
		if(!$rec){

		    $smarty->assign('redrectUrl',"user.php?act=security_edit_psd&type=phone&phone=$phone&validate=0");
            $smarty->assign('smalltext','验证码失败');
            $smarty->assign('content','输入的短信验证码错误或出现未知错误。3秒后将返回原页面，如果未返回请');       
           $smarty->assign('action', 'pageRedirect');
            $smarty->display('user_passport.dwt');
		 }
		 else{
		 require_once(dirname(__FILE__) . '/includes/lib_integral.php'); 
			   $ever_validated = $GLOBALS['db']->getOne("select ever_validated from ".$GLOBALS['ecs']->table('users')." where user_id='$user_id'");
			   if($ever_validated == '0' || $ever_validated == '1')		
     			{
					user_get_point($_CFG['validated_integral'],$user_id,4,'手机验证获得积分',0);
					user_has_got_integral('phone',$user_id,  $ever_validated);
			    }
		  $smarty->assign('redrectUrl',"user.php?act=security_settings");
            $smarty->assign('smalltext','验证成功');
            $smarty->assign('content','您已成功验证手机。3秒后将返回安全设置页，如果未返回请');       
           $smarty->assign('action', 'pageRedirect');
            $smarty->display('user_passport.dwt');
		 }
	    break;
	 case "edit":
	     $sql = "select short_message,new_shot_msg,new_phone from ".$GLOBALS['ecs']->table('verified_sms')." where user_id=$user_id and type=2";
         $row = $GLOBALS['db']->getRow($sql);
		  $rec = 0;
	     if($row['short_message']==$_REQUEST['old_capthcha'] &&  $row['new_shot_msg'] == $_REQUEST['new_capthcha'])
	     {
		     $sql = "update ".$GLOBALS['ecs']->table('users')."  set mobile_phone = ".$row['new_phone']." where user_id=$user_id";
			 $flag=$GLOBALS['db']->query($sql);
		    if($flag) $rec=1;
		 }
	     else
		 {
		 if($row['short_message']!=$_REQUEST['old_capthcha'])
		    $rec = 2;
		 else
		   $rec = 3;
		 }
		 	if(!$rec){
		    $smarty->assign('redrectUrl',"user.php?act=security_edit_psd&type=phone&phone=$phone&validate=3");
            $smarty->assign('smalltext','修改绑定手机失败');
            $smarty->assign('content','输入的短信验证码有误或出现未知错误。3秒后将返回原页面，如果未返回请');       
           $smarty->assign('action', 'pageRedirect');
            $smarty->display('user_passport.dwt');
		 }
		 else{
		  $smarty->assign('redrectUrl',"user.php?act=security_settings");
            $smarty->assign('smalltext','修改成功');
            $smarty->assign('content','您已成功修改绑定手机。3秒后将返回安全设置页，如果未返回请');       
           $smarty->assign('action', 'pageRedirect');
            $smarty->display('user_passport.dwt');
		 }
	 break;
   }
}
/* 显示会员注册界面 */
if ($action == 'register')
{
  // echo "<br>register<br>";
    $smarty->assign('script_name', 'register');
    if ((!isset($back_act)||empty($back_act)) && isset($GLOBALS['_SERVER']['HTTP_REFERER']))
    {
        $back_act = strpos($GLOBALS['_SERVER']['HTTP_REFERER'], 'user.php') ? './index.php' : $GLOBALS['_SERVER']['HTTP_REFERER'];
    }

    /* 取出注册扩展字段 */
    $sql = 'SELECT * FROM ' . $ecs->table('reg_fields') . ' WHERE type < 2 AND display = 1 ORDER BY dis_order, id';
    $extend_info_list = $db->getAll($sql);
    $smarty->assign('extend_info_list', $extend_info_list);

    /* 验证码相关设置 */
    if ((intval($_CFG['captcha']) & CAPTCHA_REGISTER) && gd_version() > 0)
    {
        $smarty->assign('enabled_captcha', 1);
        $smarty->assign('rand',            mt_rand());
    }

    /* 密码提示问题 */
    $smarty->assign('passwd_questions', $_LANG['passwd_questions']);

    /* 增加是否关闭注册 */
    $smarty->assign('shop_reg_closed', $_CFG['shop_reg_closed']);
//    $smarty->assign('back_act', $back_act);
    $smarty->display('user_passport.dwt');
}

/* 注册会员的处理 */
elseif ($action == 'act_register')
{
	 include_once(ROOT_PATH . 'includes/lib_passport.php');
    $flag=0;
    /* 增加是否关闭注册 */
    if ($_CFG['shop_reg_closed'])
    {
        $smarty->assign('action',     'register');
        $smarty->assign('shop_reg_closed', $_CFG['shop_reg_closed']);
        $smarty->display('user_passport.dwt');
    }
    else
    {

        include_once(ROOT_PATH . 'includes/lib_passport.php');
      
         $username = "";
         $password = "";
		     $nickname = "";
		     $type = "";
          if(isset($_POST['email']))
          {
             $username=compile_str(trim($_POST['email']));
          }
          elseif(isset($_POST['phone']))
          {
             $username=compile_str(trim($_POST['phone']));
          }else{echo "location:user.php  error:username(email or phone isn't posted)"; exit();}

          if(isset($_POST['email_psd']))
          {
             $password=compile_str(trim($_POST['email_psd']));
          }
          elseif(isset($_POST['phone_psd']))
          {
             $password=compile_str(trim($_POST['phone_psd']));
          }else{echo "location:user.php  error:password  isn't posted"; exit();}
          
		  if(isset($_POST['email_nick_name']))
          {
             $nickname=compile_str(trim($_POST['email_nick_name']));
          } 
          elseif(isset($_POST['phone_nick_name']))
          {
              $nickname=compile_str(trim($_POST['phone_nick_name']));
          }else{echo "location:user.php  error:昵称没有填写"; exit();}
        /* 验证码检查 */
           if(isset($_POST['type']) && ( $_POST['type'] == 'email' || $_POST['type'] == 'phone')  )
          {
             $type=compile_str(trim($_POST['type']));
          }  else{echo "location:user.php  error:既不是邮箱或也不是手机注册。"; exit();}
		  if($type == 'email') //只有email下才有验证码
         {		
			if ((intval($_CFG['captcha']) & CAPTCHA_REGISTER) && gd_version() > 0)
			{
			   
				if (empty($_POST['captcha']))
				{
					$flag=1;
					$smarty->assign('redrectUrl',"user.php?act=register");
					$smarty->assign('smalltext','注册失败');
					$smarty->assign('content','验证码为空，请填写验证码后再提交。页面将返回注册页，如果未返回请');       
				   $smarty->assign('action', 'pageRedirect');
					$smarty->display('user_passport.dwt'); 
					exit;
				}
				else
				   {
				   
						/* 检查验证码 */
						include_once('includes/cls_captcha.php');

						$validator = new captcha();

						if (!$validator->check_word($_POST['captcha']))
						{ $flag=1;
						   $smarty->assign('redrectUrl',"user.php?act=register");
						$smarty->assign('smalltext','注册失败');
						$smarty->assign('content','验证码不正确，建议点击验证码旁的换一张，来获取新验证码。页面将返回注册页，如果未返回请');       
					   $smarty->assign('action', 'pageRedirect');
						$smarty->display('user_passport.dwt'); 
						   exit;
						}
				   }
			}   
		 }
		 else if($type == 'phone')  //只有手机注册下，才有验证短信
		 {
		   $captcha = compile_str(trim($_POST['captcha']));
		   $sql = "select short_msm from ".$GLOBALS['ecs']->table('verified_register_SMS')." where phone = '$username'";
		   $sent_sms = $GLOBALS['db']->getOne($sql);
		   if($captcha != $sent_sms)
		   {
		            $smarty->assign('redrectUrl',"user.php?act=register");
					$smarty->assign('smalltext','注册失败');
					$smarty->assign('content','输入的短信验证有误!页面将返回注册页，如果未返回请');       
				   $smarty->assign('action', 'pageRedirect');
					$smarty->display('user_passport.dwt'); 
					exit;
		   }
		 }
		 
       if ($flag==0 && register($username, $password) !== false)
        {          
            /* 判断是否需要自动发送注册邮件 */
            /*if($GLOBALS['_CFG']['member_email_validate'] && $GLOBALS['_CFG']['send_verify_email'])
            {
                send_regiter_hash($_SESSION['user_id']);
            }*/
			$emailUserValid = ''; //给未验证邮箱的邮箱注册用户做个标记。登陆时，做判断用。不让其登陆。
			if($type == 'email')
				{
				$emailUserValid = ' , chat_validated = -1 ';
				
               send_regiter_hash($_SESSION['user_id'],'emailUserValid');
			   }				
			$sql = "update ".$GLOBALS['ecs']->table('users')." set nickname = '$nickname' $emailUserValid where user_id = '".$_SESSION['user_id']."'";
			$GLOBALS['db']->query($sql);
		        	
			if($type  == 'email' )
			{
			$user->logout();
			require_once(dirname(__FILE__) . '/includes/lib_passport.php');
			    $smarty->assign('registerEmail',$username);
				$smarty->assign('loginEmail',get_mail_serverAddr($username));
				$smarty->assign('registerPoint',$_CFG['register_points']);
				$smarty->display('email_register_validate.dwt');
			}
			else if($type == 'phone')
			{
				ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

			
			require_once(dirname(__FILE__) . '/includes/lib_integral.php');
			user_get_point($_CFG['validated_integral'],$_SESSION['user_id'],4,'手机验证获得积分',0);
			user_has_got_integral('phone',$_SESSION['user_id']);
			
				$smarty->assign('redrectUrl',"/");
				$smarty->assign('smalltext','注册成功');
				$smarty->assign('content','您已成功注册，页面将跳转到首页。如果未跳转请');       
				$smarty->assign('action', 'pageRedirect');
				$smarty->display('user_passport.dwt'); 
            }			
        }
        else
        {

             $smarty->assign('redrectUrl',"user.php?act=register");
            $smarty->assign('smalltext','注册失败');
            $smarty->assign('content','注册失败，请检查账号和密码是否符合注册要求。页面将返回注册页，如果未返回请');       
           $smarty->assign('action', 'pageRedirect');
            $smarty->display('user_passport.dwt');    
        }
    }
}

//  第三方登录接口
elseif($action == 'oath')
{
    $type = empty($_REQUEST['type']) ?  '' : $_REQUEST['type'];
  
    if($type == "taobao"){
        header("location:includes/website/tb_index.php");exit;
    }
    
    include_once(ROOT_PATH . 'includes/website/jntoo.php');

    $c = &website($type);
    if($c)
    {
        if (empty($_REQUEST['callblock']))
        {
            if (empty($_REQUEST['callblock']) && isset($GLOBALS['_SERVER']['HTTP_REFERER']))
            {
                $back_act = strpos($GLOBALS['_SERVER']['HTTP_REFERER'], 'user.php') ? 'index.php' : $GLOBALS['_SERVER']['HTTP_REFERER'];
            }
            else
            {
                $back_act = 'index.php';
            }
        }
        else
        {
            $back_act = trim($_REQUEST['callblock']);
        }

        if($back_act[4] != ':') $back_act = $ecs->url().$back_act;
        $open = empty($_REQUEST['open']) ? 0 : intval($_REQUEST['open']);

        $url = $c->login($ecs->url().'user.php?act=oath_login&type='.$type.'&callblock='.urlencode($back_act).'&open='.$open);
       
		if(!$url)
        {
            show_message( $c->get_error() , '首页', $ecs->url() , 'error');
        }
        header('Location: '.$url);
    }
    else
    {
        show_message('服务器尚未注册该插件！' , '首页',$ecs->url() , 'error');
    }
}



//  处理第三方登录接口
elseif($action == 'oath_login')
{
    $type = empty($_REQUEST['type']) ?  '' : $_REQUEST['type'];
 
    include_once(ROOT_PATH . 'includes/website/jntoo.php');
    $c = &website($type);
    if($c)
    {
        $access = $c->getAccessToken();
        if(!$access)
        {
            show_message( $c->get_error() , '首页', $ecs->url() , 'error');
        }
        $c->setAccessToken($access);
        $info = $c->getMessage();
	
        if(!$info)
        {
            show_message($c->get_error() , '首页' , $ecs->url() , 'error' , false);
        }
        if(!$info['user_id'])
            show_message($c->get_error() , '首页' , $ecs->url() , 'error' , false);


        $info_user_id = $type .'_'.$info['user_id']; //  加个标识！！！防止 其他的标识 一样  // 以后的ID 标识 将以这种形式 辨认
        $info['name'] = str_replace("'" , "" , $info['name']); // 过滤掉 逗号 不然出错  很难处理   不想去  搞什么编码的了
        if(!$info['user_id'])
            show_message($c->get_error() , '首页' , $ecs->url() , 'error' , false);


        $sql = 'SELECT user_name,password,aite_id FROM '.$ecs->table('users').' WHERE aite_id = \''.$info_user_id.'\' OR aite_id=\''.$info['user_id'].'\'';


        $count = $db->getRow($sql);
        if(!$count)   // 没有当前数据
        {
            if($user->check_user($info['name']))  // 重名处理
            {
                $info['name'] = $info['name'].'_'.$type.(rand(10000,99999));
            }
            $user_pass = $user->compile_password(array('password'=>$info['user_id']));
          $sql = 'INSERT INTO '.$ecs->table('users').'(user_name , password, aite_id , sex , reg_time , user_rank , is_validated) VALUES '.
                    "('$info[name]' , '$user_pass' , '$info_user_id' , '$info[sex]' , '".gmtime()."' ,  0 , '1')" ;//'$info[rank_id]' , '1')" ;
            $db->query($sql);
        }
        else
        {
            $sql = '';
            if($count['aite_id'] == $info['user_id'])
            {
                $sql = 'UPDATE '.$ecs->table('users')." SET aite_id = '$info_user_id' WHERE aite_id = '$count[aite_id]'";
                $db->query($sql);
            }
            if($info['name'] != $count['user_name'])   // 这段可删除
            {
                if($user->check_user($info['name']))  // 重名处理
                {
                    $info['name'] = $info['name'].'_'.$type.(rand()*1000);
                }
                $sql = 'UPDATE '.$ecs->table('users')." SET user_name = '$info[name]' WHERE aite_id = '$info_user_id'";
                $db->query($sql);
            }
        }
        $user->set_session($info['name']);
        $user->set_cookie($info['name']);
        update_user_info();
        recalculate_price();

        if(!empty($_REQUEST['open']))
        {
            die('<script>window.opener.window.location.reload(); window.close();</script>');
        }
        else
        {
            ecs_header('Location: '.$_REQUEST['callblock']);

        }

    }

}

//  处理其它登录接口
elseif($action == 'other_login')
{
    $type = empty($_REQUEST['type']) ?  '' : $_REQUEST['type'];
    session_start();
    $info = $_SESSION['user_info'];

    if(empty($info)){
        show_message("非法访问或请求超时！" , '首页' , $ecs->url() , 'error' , false);
    }
    if(!$info['user_id'])
        show_message("非法访问或访问出错，请联系管理员！", '首页' , $ecs->url() , 'error' , false);


    $info_user_id = $type .'_'.$info['user_id']; //  加个标识！！！防止 其他的标识 一样  // 以后的ID 标识 将以这种形式 辨认
    $info['name'] = str_replace("'" , "" , $info['name']); // 过滤掉 逗号 不然出错  很难处理   不想去  搞什么编码的了


    $sql = 'SELECT user_name,password,aite_id FROM '.$ecs->table('users').' WHERE aite_id = \''.$info_user_id.'\' OR aite_id=\''.$info['user_id'].'\'';

    $count = $db->getRow($sql);
    $login_name = $info['name'];
    if(!$count)   // 没有当前数据
    {
        if($user->check_user($info['name']))  // 重名处理
        {
            $info['name'] = $info['name'].'_'.$type.(rand()*1000);
        }
        $login_name = $info['name'];
        $user_pass = $user->compile_password(array('password'=>$info['user_id']));
        $sql = 'INSERT INTO '.$ecs->table('users').'(user_name , password, aite_id , sex , reg_time , user_rank , is_validated) VALUES '.
                "('$info[name]' , '$user_pass' , '$info_user_id' , '$info[sex]' , '".gmtime()."' , '$info[rank_id]' , '1')" ;
        $db->query($sql);
    }
    else
    {
        $login_name = $count['user_name'];
        $sql = '';
        if($count['aite_id'] == $info['user_id'])
        {
            $sql = 'UPDATE '.$ecs->table('users')." SET aite_id = '$info_user_id' WHERE aite_id = '$count[aite_id]'";
            $db->query($sql);
        }
    }
    
    
    
    $user->set_session($login_name);
    $user->set_cookie($login_name);
    update_user_info();
    recalculate_price();

    $redirect_url =  "http://".$_SERVER["HTTP_HOST"].str_replace("user.php", "index.php", $_SERVER["REQUEST_URI"]);
    header('Location: '.$redirect_url);

}
/* 验证用户注册邮件 chen-0912*/
elseif ($action == 'validate_email')
{
    $hash = empty($_GET['hash']) ? '' : trim($_GET['hash']);
	$type = empty($_GET['type']) ? '' : trim($_GET['type']);
    if ($hash)
    {
        include_once(ROOT_PATH . 'includes/lib_passport.php');
        $id = register_hash('decode', $hash);
        if ($id > 0)
        {
		
			switch($type)
			{
			case "register":
				$sql = "select chat_validated from ".$ecs->table('users')." where user_id = '$id'";
				$chat_validated = $db->getOne($sql);
				switch($chat_validated)
				{
				  case '0':$chat_validated=1; break;
				  case '2':$chat_validated=3; break;
				}
				
				$sql = "UPDATE " . $ecs->table('users') . " SET chat_validated = $chat_validated WHERE user_id='$id'";
				$db->query($sql);
				$sql = 'SELECT user_name, email, ever_validated FROM ' . $ecs->table('users') . " WHERE user_id = '$id'";
				$row = $db->getRow($sql);
				
				require_once(dirname(__FILE__) . '/includes/lib_integral.php');
	           
			   if($row['ever_validated'] == '0' || $row['ever_validated'] == '2')		
     			{
					user_get_point($_CFG['validated_integral'],$id,4,'邮箱验证获得积分',0);
					user_has_got_integral('email',$id,$row['ever_validated']);
			    }
				show_message(sprintf($_LANG['validate_ok'], $row['user_name'], $row['email']),$_LANG['profile_lnk'], 'user.php');
				break;
			case "disbind":
			    $sql = "select chat_validated from ".$ecs->table('users')." where user_id = '$id'";
				$chat_validated = $db->getOne($sql);
				switch($chat_validated)
				{
				  case '1': $chat_validated=0; break;
				  case '3': $chat_validated=2;break;
				}
				$sql = "UPDATE " . $ecs->table('users') . " SET chat_validated = $chat_validated WHERE user_id='$id'";
				$db->query($sql);
				$sql = 'SELECT user_name, email FROM ' . $ecs->table('users') . " WHERE user_id = '$id'";
				$row = $db->getRow($sql);
				show_message(sprintf('您已成功解除邮箱绑定',$row['user_name'],$row['email']),$_LANG['profile_lnk'],'user.php');
			
			break;
			
			case "emailUserValid":
			$sql = "update ".$GLOBALS['ecs']->table('users')." set email=user_name,chat_validated = 1 where user_id='$id'";
			$db->query($sql);
			$_SESSION['user_id'] = $id; 
 
                 $row =  $db->getRow('SELECT user_name, user_rank FROM ' . $ecs->table('users') . " WHERE user_id = '$id'");
			$_SESSION['user_name'] = $row['user_name'];
			$_SESSION['user_rank'] = 1;
			
			
			require_once(dirname(__FILE__) . '/includes/lib_integral.php');
			user_get_point($_CFG['validated_integral'],$id,4,'邮箱验证获得积分',0);
			user_has_got_integral('email',$id);
			
			show_message('邮箱注册成功！',$_LANG['profile_lnk'],'user.php');
			break;
			}
        }
    }
    show_message($_LANG['validate_fail']);
}


/* 验证用户注册用户名是否可以注册 */
elseif ($action == 'is_registered')
{
    include_once(ROOT_PATH . 'includes/lib_passport.php');

    $username = trim($_GET['username']);
    $username = json_str_iconv($username);
   $type = isset($_GET['type']) ? $_GET['type']:'';
   if($type != 'email' && $type != 'phone')
    {
	  die(json_encode('register type isn\'t email or phone'));
	}
    if ($user->check_user($username) || admin_registered($username))
    {
	    
       echo json_encode(array('type'=>$type,'result'=>'false'));
    }
    else
    {
        echo json_encode(array('type'=>$type,'result'=>'true'));
    }
	exit;
}

/* 验证用户邮箱地址是否被注册 */
elseif($action == 'check_email')
{

    $email = trim($_GET['email']);
  //  echo "email==$email";
    if ($user->check_email($email))
    {
        echo 'false';
    }
    else
    {
        echo 'ok';
    }
	exit;
}




/* 用户登录界面 */
elseif ($action == 'login')
{
    $smarty->assign('script_name', 'login');
    if (empty($back_act))
    {
        if (empty($back_act) && isset($GLOBALS['_SERVER']['HTTP_REFERER']))
        {
            $back_act = strpos($GLOBALS['_SERVER']['HTTP_REFERER'], 'user.php') ? './index.php' : $GLOBALS['_SERVER']['HTTP_REFERER'];
        }
        else
        {
            $back_act = 'user.php';
        }

    }


    $captcha = intval($_CFG['captcha']);
    if (($captcha & CAPTCHA_LOGIN) && (!($captcha & CAPTCHA_LOGIN_FAIL) || (($captcha & CAPTCHA_LOGIN_FAIL) && $_SESSION['login_fail'] > 2)) && gd_version() > 0)
    {
        $GLOBALS['smarty']->assign('enabled_captcha', 1);
        $GLOBALS['smarty']->assign('rand', mt_rand());
    }

    $smarty->assign('back_act', $back_act);
    $smarty->display('user_passport.dwt');
}

/* 处理会员的登录 */
elseif ($action == 'act_login')
{   
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $back_act = isset($_POST['back_act']) ? trim($_POST['back_act']) : 'user.php';
 //echo "domain===".$_SERVER[REQUEST_URI]."</br>";
   //      echo $back_act."</br>";
	//	 echo dirname(__FILE__);//."/../";
		//  exit;
    if ($user->login($username, $password,isset($_POST['remember'])))
    {
        update_user_info();	
        recalculate_price();	
		$sql = "select chat_validated from ".$GLOBALS['ecs']->table('users')." where user_id = '" .$_SESSION['user_id']."'";
		$chat_validated = $GLOBALS['db']->getOne($sql);
		if($chat_validated == -1)
		{
		// echo '-1';
		// echo '<br/>userid=='.$_SESSION['user_id'];
		// $user->logout();
		//  echo '<br/>userid=='.$_SESSION['user_id'];
		       $user->logout();
			require_once(dirname(__FILE__) . '/includes/lib_passport.php');
			    $smarty->assign('registerEmail',$username);
				$smarty->assign('loginEmail',get_mail_serverAddr($username));
				$smarty->assign('registerPoint',$_CFG['register_points']);
				$smarty->display('email_hasnot_validate.dwt');
		}
		
		else
		{
	//	var_dump($_REQUEST);
      //    echo $back_act;exit;
//ecs_header("Location:$back_act");//该处作用是直接进入登陆状态不提示 guan-0930
            $smarty->assign('redrectUrl',$back_act);
            $smarty->assign('smalltext','登陆成功');
            $smarty->assign('content','您登陆成功了。3秒后页面将跳转，如果未跳转请');       
           $smarty->assign('action', 'pageRedirect');
            $smarty->display('user_passport.dwt');
			}
    }
    else
    {
         $smarty->assign('redrectUrl',"user.php");
            $smarty->assign('smalltext','登陆失败');
            $smarty->assign('content','请检查用户名或密码是否有误。3秒后将返回到登陆页，如果未返回请');       
           $smarty->assign('action', 'pageRedirect');
            $smarty->display('user_passport.dwt');
    }
}
/*手机，邮箱：验证修改 ajax  chen-0912*/
elseif($action == 'set_user_contact')
{
include_once('includes/lib_passport.php');
$type=$_REQUEST['type'];
$is_validate = $_REQUEST['is_validate'];
$user_id = $_SESSION['user_id'];
$value = $_REQUEST['value'];

  switch($type)
  {
    case 'email':
	   switch($is_validate)
	   {
	   case 0:    //取消邮箱验证
	      {
		    $email_format=get_mail_serverAddr($value);
		    echo json_encode($email_format);
		  }
		  break;
	   case 1:   //邮箱验证
	     {
		 $sql = "select user_id from ".$GLOBALS['ecs']->table('users')." where (email = '$value' and chat_validated <> 0 and chat_validated <> 2 and user_id <> $user_id) or user_id=$user_id";
		
		 $row = $GLOBALS['db']->getRow($sql);
		
			 if(!$row || ($row['user_id']==$user_id  && ($row['chat_validated']==0 ||  $row['chat_validated']==2)))
			 {
			   $sql = "update ".$GLOBALS['ecs']->table('users')." set  email = '$value' where user_id=$user_id";
			   $GLOBALS['db']->query($sql);
			  $email_format=get_mail_serverAddr($value);
			  //echo $value;
			 // echo $email_format;
			  echo json_encode($email_format);
			  }
			  else if($row['user_id']==$user_id  && ($row['chat_validated']==1 ||  $row['chat_validated']==3) )
			  {
			    echo "1";
			  }
		
			  else
			  {
			   // echo json_encode("this email has validated by others");
			   echo "0";
			  }
		  }
	  break;
	  }
	break;
	case 'phone':
	   switch($is_validate)
	   {
	    case 1:
			 $sql = "select user_id from ".$GLOBALS['ecs']->table('users')." where (mobile_phone = '$value' and chat_validated <> 0 and chat_validated <> 1 and user_id <> $user_id) or user_id=$user_id";
		      $row = $GLOBALS['db']->getRow($sql);
			  
			   if(!$row || ($row['user_id']==$user_id  && ($row['chat_validated']==0 ||  $row['chat_validated']==1)))
			 {
			  $sql = "update ".$GLOBALS['ecs']->table('users')." set  mobile_phone = '$value' where user_id=$user_id";
	      $GLOBALS['db']->query($sql);
		
			  }
			  else if($row['user_id']==$user_id  && ($row['chat_validated']==2 ||  $row['chat_validated']==3) )
			  {
			    echo "1";
			  }
		
			  else
			  {
			   // echo json_encode("this email has validated by others");
			   echo "0";
			  }
	     
		 break;
		case 0:
		  break;
		case 2:
		 break;
	   }
	break;
   }
}
/* 处理 ajax 的登录请求 */
elseif ($action == 'signin')
{
  //  var_dump($_POST);
   // exit();

    include_once('includes/cls_json.php');
    $json = new JSON;

    $username = !empty($_POST['username']) ? json_str_iconv(trim($_POST['username'])) : '';
    $password = !empty($_POST['password']) ? trim($_POST['password']) : '';
    $captcha = !empty($_POST['captcha']) ? json_str_iconv(trim($_POST['captcha'])) : '';
    $result   = array('error' => 0, 'content' => '');

    $captcha = intval($_CFG['captcha']);
    if (($captcha & CAPTCHA_LOGIN) && (!($captcha & CAPTCHA_LOGIN_FAIL) || (($captcha & CAPTCHA_LOGIN_FAIL) && $_SESSION['login_fail'] > 2)) && gd_version() > 0)
    {
        if (empty($captcha))
        {
            $result['error']   = 1;
            $result['content'] = $_LANG['invalid_captcha'];
            die($json->encode($result));
        }

        /* 检查验证码 */
        include_once('includes/cls_captcha.php');

        $validator = new captcha();
        $validator->session_word = 'captcha_login';
        if (!$validator->check_word($_POST['captcha']))
        {

            $result['error']   = 1;
            $result['content'] = $_LANG['invalid_captcha'];
            die($json->encode($result));
        }
    }

    if ($user->login($username, $password))
    {
        update_user_info();  //更新用户信息
        recalculate_price(); // 重新计算购物车中的商品价格
        $smarty->assign('user_info', get_user_info());
        $ucdata = empty($user->ucdata)? "" : $user->ucdata;
        $result['ucdata'] = $ucdata;
        $result['content'] = $smarty->fetch('library/member_info.lbi');
    }
    else
    {
        $_SESSION['login_fail']++;
        if ($_SESSION['login_fail'] > 2)
        {
            $smarty->assign('enabled_captcha', 1);
            $result['html'] = $smarty->fetch('library/member_info.lbi');
        }
        $result['error']   = 1;
        $result['content'] = $_LANG['login_failure'];
    }
    die($json->encode($result));
}

/* 退出会员中心 */
elseif ($action == 'logout')
{
    if ((!isset($back_act)|| empty($back_act)) && isset($GLOBALS['_SERVER']['HTTP_REFERER']))
    {
        $back_act = strpos($GLOBALS['_SERVER']['HTTP_REFERER'], 'user.php') ? './index.php' : $GLOBALS['_SERVER']['HTTP_REFERER'];
    }

    $user->logout();
	// ecs_header("Location:index.php");//该处作用是直接退出登陆状态不提示 guan-0930
      $smarty->assign('redrectUrl',"/");
            $smarty->assign('smalltext','成功退出');
            $smarty->assign('content','您成功退出了。3秒后将跳转到首页，如果未跳转请');       
           $smarty->assign('action', 'pageRedirect');
            $smarty->display('user_passport.dwt');
}

/* 个人资料页面 chen-0917 */
elseif ($action == 'profile')
{
  include_once(ROOT_PATH . 'includes/lib_transaction.php');

    $user_info = get_profile($user_id);
//var_dump($user_info);
    /* 取出注册扩展字段 */
    $sql = 'SELECT * FROM ' . $ecs->table('reg_fields') . ' WHERE type < 2 AND display = 1 ORDER BY dis_order, id';
    $extend_info_list = $db->getAll($sql);

    $sql = 'SELECT reg_field_id, content ' .
           'FROM ' . $ecs->table('reg_extend_info') .
           " WHERE user_id = $user_id";
    $extend_info_arr = $db->getAll($sql);

    $temp_arr = array();
    foreach ($extend_info_arr AS $val)
    {
        $temp_arr[$val['reg_field_id']] = $val['content'];
    }

    foreach ($extend_info_list AS $key => $val)
    {
        switch ($val['id'])
        {
            case 1:     $extend_info_list[$key]['content'] = $user_info['msn']; break;
            case 2:     $extend_info_list[$key]['content'] = $user_info['qq']; break;
            case 3:     $extend_info_list[$key]['content'] = $user_info['office_phone']; break;
            case 4:     $extend_info_list[$key]['content'] = $user_info['home_phone']; break;
            case 5:     $extend_info_list[$key]['content'] = $user_info['mobile_phone']; break;
            default:    $extend_info_list[$key]['content'] = empty($temp_arr[$val['id']]) ? '' : $temp_arr[$val['id']] ;
        }
    }
	//默认国内,取得全国的省，市，区 chen 0828
   $province_list=get_regions(1, 1);
    $city_list=get_regions(2, 0);
	 $district_list=get_regions(3, 0);
   $smarty->assign('province_list',    $province_list);
    $smarty->assign('city_list',        $city_list);
    $smarty->assign('district_list',    $district_list);
	
	
    $sql = "select province,city,area from ".$GLOBALS['ecs']->table('users')." where user_id=$user_id"; //获取收货人地址 chen-0912
	
	$addr = $GLOBALS['db']->getRow($sql);
	
	
   assign_validate_info($smarty,$user_id);
   
	$smarty->assign('addr',$addr);
	
    $smarty->assign('extend_info_list', $extend_info_list);

 
	include_once(ROOT_PATH . 'includes/lib_user_info.php');	
	$smarty->assign('is_got_integral',is_got_information_completed_integral($user_id));
	 $smarty->assign('user_information_completed_percent', user_information_completed_percent($user_id));
	 
	    
    $smarty->assign('passwd_questions', $_LANG['passwd_questions']);
    $smarty->assign('profile_integral', $_CFG['register_points']);
    $smarty->assign('profile', $user_info);
    $smarty->display('user_transaction.dwt');
}
/* 修改个人资料的处理 chen-0918*/
elseif ($action == 'act_edit_profile')
{
    include_once(ROOT_PATH . 'includes/lib_transaction.php');
    $nickname = empty($_POST['nickname']) ? '' : compile_str($_POST['nickname']);
    $email = $_POST['email'];
    $mobile_phone = isset($_POST['mobile_phone']) ? compile_str($_POST['mobile_phone']) : '';
    $truename = isset($_POST['truename']) ? compile_str($_POST['truename']) : '';
    $sex = isset($_POST['sex']) ? trim($_POST['sex']) : '';
    $home_phone = isset($_POST['home_phone']) ? compile_str($_POST['home_phone']) : '';
    $province=isset($_POST['province']) ?$_POST['province'] : '';
    $city=isset($_POST['city']) ?$_POST['city'] : '';
    $area=isset($_POST['area']) ? $_POST['area'] : '';
    $qq = isset($_POST['qq']) ? trim($_POST['qq']) : '';
    $msn = isset($_POST['msn']) ? trim($_POST['msn']) : '';
    $bname=isset($_POST['name1'])?$_POST['name1']: '';
    $bday=isset($_POST['baday']) ? $_POST['baday'] : '';
    $bsex=isset($_POST['bsex']) ?$_POST['bsex'] : '';
    $photo=$_FILES['upphoto'];
 

    if (!empty($home_phone) && !preg_match( '/^[\d|\_|\-|\s]+$/', $home_phone) )
    {
         show_message($_LANG['passport_js']['home_phone_invalid']);
    }
    if (!empty($email) &&  !is_email($email))
    {
        show_message($_LANG['msg_email_format']);
    }
    if (!empty($msn) && !is_email($msn))
    {
         show_message($_LANG['passport_js']['msn_invalid']);
    }
    if (!empty($qq) && !preg_match('/^\d+$/', $qq))
    {
         show_message($_LANG['passport_js']['qq_invalid']);
    }
    if (!empty($mobile_phone) && !preg_match('/^[\d-\s]+$/', $mobile_phone))
    {
        show_message($_LANG['passport_js']['mobile_phone_invalid']);
    }

    $sql = "select chat_validated,bday from ".$GLOBALS['ecs']->table('users')." where user_id = '$user_id'";
	$written_val = $GLOBALS['db']->getOne($sql);
	switch($written_val['chat_validated'])
	{
	   case 0:$where = " `email`='$email',mobile_phone='$mobile_phone',"; break;
	   case 1:$where = " mobile_phone='$mobile_phone',"; break;
	   case 2:$where = " `email`='$email',";break;
	   case 3:$where = ""; break;
	   default: break;
	}
	if(!$written_val['bday']) $where .= " bday='$bday', ";
	
    $sql="UPDATE ".$ecs->table('users'). "SET $where sex='$sex',truename='$truename',nickname='$nickname',home_phone='$home_phone',qq='$qq',email='$email',msn='$msn',province='$province',city='$city',area='$area',bname='$bname',bsex='$bsex'  WHERE user_id= '".$user_id."'";
 
    $a=$db->query($sql);

	
	include_once(ROOT_PATH . 'includes/lib_user_info.php');	
	require_once(dirname(__FILE__) . '/includes/lib_integral.php'); 
	$is_got_integral = is_got_information_completed_integral($user_id);
	if($is_got_integral == 0)
	{
	 $completed_percent = user_information_completed_percent($user_id);
	  if($completed_percent >= 80.0)
	  {
	  user_get_point($_CFG['register_points'],$user_id,3,'完善资料获得积分',0);
	  }
	}
	
    if ($a)
    {
        show_message($_LANG['edit_profile_success'], $_LANG['profile_lnk'], 'user.php?act=profile', 'info');
    }
    else
    {
        if ($user->error == ERR_EMAIL_EXISTS)
        {
            $msg = sprintf($_LANG['email_exist'], $profile['email']);
        }
        else
        {
            $msg = $_LANG['edit_profile_failed'];
        }
        show_message($msg, '', '', 'info');
    }
}

/* 密码找回-->修改密码界面 */
elseif ($action == 'get_password')
{
    include_once(ROOT_PATH . 'includes/lib_passport.php');
    $smarty->assign('script_name', 'qpassword');
    if (isset($_GET['code']) && isset($_GET['code'])) //从邮件处获得的act
    {

         $code = trim($_GET['code']);
        $cookie_value = trim($_GET['cookie_value']);
        $uid  = intval($_GET['uid']);

        /* 判断链接的合法性 */
        $user_info = $user->get_profile_by_id($uid);
        if (empty($user_info) || ($user_info && md5($user_info['user_id'] . $_CFG['hash_code'] . $user_info['reg_time']) != $code))
        {
            show_message($_LANG['parm_error'], $_LANG['back_home_lnk'], './', 'info');
        }
       header("Cache-control:no-cache,no-store,must-revalidate");
       header("Pragma:no-cache");
       header("Expires:0");

        if($_COOKIE['resetpw_success_v']==$_REQUEST['cookie_value'])
        {
             $smarty->assign('redrectUrl',"user.php");
            $smarty->assign('smalltext','密码已修改，页面失效');
            $smarty->assign('content','密码之前已被修改。3秒后将返回登陆页，请用新密码登陆，如果未返回请');       
           $smarty->assign('action', 'pageRedirect');
            $smarty->display('user_passport.dwt');
        }
        else
        {
            $smarty->assign('uid',    $uid);
             $smarty->assign('code',   $code);
            $smarty->assign('cookie_value',   $cookie_value);
            $smarty->assign('action', 'reset_password');
            $smarty->display('user_passport.dwt');
        }
    }
    else
    {
        //显示用户名和email表单
        $smarty->display('user_passport.dwt');
    }
}
elseif ($action == 'get_email_password')
{
   include_once(ROOT_PATH . 'includes/lib_passport.php');
    /* $request接受到的user_name就是邮箱地址 */
    //var_dump($_REQUEST);
    $user_name = !empty($_REQUEST['user_name']) ? trim($_REQUEST['user_name']) : ''; 
   
    //用户名和邮件地址是否匹配
   
   $user_info = $user->get_user_info($user_name);
    if ($user_info)
    {
        //生成code
         //$code = md5($user_info[0] . $user_info[1]);
        $code = md5($user_info['user_id'] . $_CFG['hash_code'] . $user_info['reg_time']);
        //发送邮件的函数
        if (send_pwd_email($user_info['user_id'], $user_name, $user_name, $code))
        {
               $emailLink = get_mail_serverAddr($user_name);
               $smarty->assign('emailLink',$emailLink);
                $smarty->assign('emailAddr', $user_name); 
                $smarty->assign('action', 'get_email_password');
               $smarty->display('user_passport.dwt');
         //   show_message($_LANG['send_success'] . $user_name, $_LANG['back_home_lnk'], './', 'info');
        }
        else
        {
            show_message($_LANG['fail_send_password'], $_LANG['back_page_up'], './', 'info');
        }
    }
    else
    {
        //用户名与邮件地址不匹配
        show_message($_LANG['username_no_email'], $_LANG['back_page_up'], '', 'info');
    }
 
}
elseif ($action == 'get_phone_password')  
{
   // include_once(ROOT_PATH . 'includes/sendSMS.php');
   $smarty->assign('phoneNum', $_REQUEST['user_name']);
   $smarty->assign('action', 'get_phone_password');
   $smarty->display('user_passport.dwt');
}
/* 密码找回-->输入用户名界面 */
elseif ($action == 'qpassword_name')
{
    $smarty->assign('script_name', 'qpassword');
    //显示输入要找回密码的账号表单
    $smarty->display('user_passport.dwt');
}

/* 密码找回-->根据注册用户名取得密码提示问题界面 */
elseif ($action == 'get_passwd_question')
{
    $GLOBALS['smarty']->assign('script_name', 'qpassword');

    if (empty($_POST['user_name']))
    {
        show_message($_LANG['no_passwd_question'], $_LANG['back_home_lnk'], './', 'info');
    }
    else
    {
        $user_name = trim($_POST['user_name']);
    }

    //取出会员密码问题和答案
    $sql = 'SELECT user_id, user_name, passwd_question, passwd_answer FROM ' . $ecs->table('users') . " WHERE user_name = '" . $user_name . "'";
    $user_question_arr = $db->getRow($sql);

    //如果没有设置密码问题，给出错误提示
    if (empty($user_question_arr['passwd_answer']))
    {
        show_message($_LANG['no_passwd_question'], $_LANG['back_home_lnk'], './', 'info');
    }

    $_SESSION['temp_user'] = $user_question_arr['user_id'];  //设置临时用户，不具有有效身份
    $_SESSION['temp_user_name'] = $user_question_arr['user_name'];  //设置临时用户，不具有有效身份
    $_SESSION['passwd_answer'] = $user_question_arr['passwd_answer'];   //存储密码问题答案，减少一次数据库访问

    $captcha = intval($_CFG['captcha']);
    if (($captcha & CAPTCHA_LOGIN) && (!($captcha & CAPTCHA_LOGIN_FAIL) || (($captcha & CAPTCHA_LOGIN_FAIL) && $_SESSION['login_fail'] > 2)) && gd_version() > 0)
    {
        $GLOBALS['smarty']->assign('enabled_captcha', 1);
        $GLOBALS['smarty']->assign('rand', mt_rand());
    }

    $smarty->assign('passwd_question', $_LANG['passwd_questions'][$user_question_arr['passwd_question']]);
    $smarty->display('user_passport.dwt');
}

/* 密码找回-->根据提交的密码答案进行相应处理 */
elseif ($action == 'check_answer')
{
    $captcha = intval($_CFG['captcha']);
    if (($captcha & CAPTCHA_LOGIN) && (!($captcha & CAPTCHA_LOGIN_FAIL) || (($captcha & CAPTCHA_LOGIN_FAIL) && $_SESSION['login_fail'] > 2)) && gd_version() > 0)
    {
        if (empty($_POST['captcha']))
        {
            show_message($_LANG['invalid_captcha'], $_LANG['back_retry_answer'], 'user.php?act=qpassword_name', 'error');
        }

        /* 检查验证码 */
        include_once('includes/cls_captcha.php');

        $validator = new captcha();
        $validator->session_word = 'captcha_login';
        if (!$validator->check_word($_POST['captcha']))
        {
            show_message($_LANG['invalid_captcha'], $_LANG['back_retry_answer'], 'user.php?act=qpassword_name', 'error');
        }
    }

    if (empty($_POST['passwd_answer']) || $_POST['passwd_answer'] != $_SESSION['passwd_answer'])
    {
        show_message($_LANG['wrong_passwd_answer'], $_LANG['back_retry_answer'], 'user.php?act=qpassword_name', 'info');
    }
    else
    {
        $_SESSION['user_id'] = $_SESSION['temp_user'];
        $_SESSION['user_name'] = $_SESSION['temp_user_name'];
        unset($_SESSION['temp_user']);
        unset($_SESSION['temp_user_name']);
        $smarty->assign('uid',    $_SESSION['user_id']);
        $smarty->assign('action', 'reset_password');
        $smarty->display('user_passport.dwt');
    }
}

elseif($action == 'judge_usrNm')
{
        /* 验证码检查 */

   $flag=0;   //0为账号正确，1为验证码出错，2为账号出错，3为验证码和账号都错了。
        if ((intval($_CFG['captcha']) & CAPTCHA_REGISTER) && gd_version() > 0)
        {
            if (empty($_REQUEST['captcha']))
            {
             $flag+=1;
            // echo "验证码为空";
           //  exit();
            }

            /* 检查验证码 */
            include_once('includes/cls_captcha.php');

            $validator = new captcha();
            if (!$validator->check_word($_REQUEST['captcha']))
            {
                $flag+=1;
                //echo "验证码错误";
              //  exit();
            }
        }
         $user_name = !empty($_REQUEST['user_name']) ? trim($_REQUEST['user_name']) : '';
         $user_info = $user->get_user_info($user_name);
         if(!$user_info)
         {
             $flag+=2;
            // echo "用户名错误";
               // exit();
         }
     echo $flag;

}
/* 发送密码修改确认邮件 */
elseif ($action == 'send_pwd_email')
{
    include_once(ROOT_PATH . 'includes/lib_passport.php');

    /* 初始化会员用户名和邮件地址 */
    $user_name = !empty($_POST['user_name']) ? trim($_POST['user_name']) : '';
    $email     = !empty($_POST['email'])     ? trim($_POST['email'])     : '';

    //用户名和邮件地址是否匹配
    $user_info = $user->get_user_info($user_name);

    if ($user_info && $user_info['email'] == $email)
    {
        //生成code
         //$code = md5($user_info[0] . $user_info[1]);

        $code = md5($user_info['user_id'] . $_CFG['hash_code'] . $user_info['reg_time']);
        //发送邮件的函数
        if (send_pwd_email($user_info['user_id'], $user_name, $email, $code))
        {
            show_message($_LANG['send_success'] . $email, $_LANG['back_home_lnk'], './', 'info');
        }
        else
        {
            //发送邮件出错
            show_message($_LANG['fail_send_password'], $_LANG['back_page_up'], './', 'info');
        }
    }
    else
    {
        //用户名与邮件地址不匹配
        show_message($_LANG['username_no_email'], $_LANG['back_page_up'], '', 'info');
    }
}

/* 重置新密码 */
elseif ($action == 'reset_password')
{
    //显示重置密码的表单
    $smarty->display('user_passport.dwt');
}

/* 修改会员密码 */
elseif($action == 'act_edit_phone_password')
{
include_once(ROOT_PATH . 'includes/lib_passport.php');
    $user_id=$_REQUEST['uid'];
   $pwd=md5($_REQUEST['new_password']); 
   $sql = "update ecs_users set password='$pwd' where user_id=$user_id"; 
   $flag=$db->query($sql);


   if($flag)
   {
      echo "<br/>".$_REQUEST['cookie_value']."<br/>";
    
   setcookie('resetpw_success_vph',$_REQUEST['cookie_value'],time()+600);
   echo "<br/>_COOKIE==".$_COOKIE['resetpw_success_vph']."<br/>";
   echo "123";

     $user->logout();
            $smarty->assign('action', 'editPwdScs');   
            $smarty->display('user_passport.dwt');
   }
}
elseif ($action == 'act_edit_password')
{
    include_once(ROOT_PATH . 'includes/lib_passport.php');

    $old_password = isset($_POST['old_password']) ? trim($_POST['old_password']) : null;
    $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
    $user_id      = isset($_POST['uid'])  ? intval($_POST['uid']) : $user_id;
    $code         = isset($_POST['code']) ? trim($_POST['code'])  : '';
    $cookie_value         = isset($_POST['cookie_value']) ? trim($_POST['cookie_value'])  : '';

    if (strlen($new_password) < 6)
    {
        show_message($_LANG['passport_js']['password_shorter']);
    }

    $user_info = $user->get_profile_by_id($user_id); //论坛记录
//    var_dump($user_info);
//     echo "<br/>code1==$code<br/>";
//     echo "code2==".md5($user_info['user_id'] . $_CFG['hash_code'] . $user_info['reg_time'])."<br/>";
// exit();
   if (($user_info && (!empty($code) && md5($user_info['user_id'] . $_CFG['hash_code'] . $user_info['reg_time']) == $code)) ||     ($_SESSION['user_id']>0 && $_SESSION['user_id'] == $user_id && $user->check_user($_SESSION['user_name'], $old_password)))
    {
         // echo "here";
   //          exit();
        if ($user->edit_user(array('username'=> (empty($code) ? $_SESSION['user_name'] : $user_info['user_name']), 'old_password'=>$old_password, 'password'=>$new_password), empty($code) ? 0 : 1))
        {
          setcookie('resetpw_success_v',$cookie_value,time()+600);
            $sql="UPDATE ".$ecs->table('users'). "SET `ec_salt`='0' WHERE user_id= '".$user_id."'";
            $db->query($sql);
            $user->logout();
            $smarty->assign('action', 'editPwdScs');
            // echo "success";
            // exit();
            $smarty->display('user_passport.dwt');
            //show_message($_LANG['edit_password_success'], $_LANG['relogin_lnk'], 'user.php?act=login', 'info');
        }
        else
        {
            show_message($_LANG['edit_password_failure'], $_LANG['back_page_up'], '', 'info');
        }
    }
    else
    {
        show_message($_LANG['edit_password_failure'], $_LANG['back_page_up'], '', 'info');
    }

}

/* 添加一个红包 */
elseif ($action == 'act_add_bonus')
{
    include_once(ROOT_PATH . 'includes/lib_transaction.php');

    $bouns_sn = isset($_POST['bonus_sn']) ? intval($_POST['bonus_sn']) : '';

    if (add_bonus($user_id, $bouns_sn))
    {
        show_message($_LANG['add_bonus_sucess'], $_LANG['back_up_page'], 'user.php?act=bonus', 'info');
    }
    else
    {
        $err->show($_LANG['back_up_page'], 'user.php?act=bonus');
    }
}

/* 查看订单列表 chen-0915*/
elseif ($action == 'order_list')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');
	include_once(ROOT_PATH . 'includes/cls_orders.php');

	 $ctl  = isset($_REQUEST['ctl']) ? $_REQUEST['ctl'] : '0';
	 $smarty->assign('ctl',$ctl);
	  $smarty->assign('left',$ctl*130);
	  
	 $all_order_list = new order_list();
	 for($i=0; $i < $all_order_list->elem_count; $i++)
	 {
	   $page = isset($_REQUEST["page$i"]) ? intval($_REQUEST["page$i"]) : 1;
	   switch($all_order_list->comment[$i])
	  {
	    case 0://未评价的订单（待付款，待收货。。。。。。）
		 $record_count = $db->getOne("SELECT COUNT(*) FROM " .$ecs->table('order_info'). " WHERE user_id = '$user_id'".$all_order_list->where[$i]);
		break;
		case 1://已评价的订单
		$sql = "SELECT COUNT(*) FROM " .$ecs->table('order_info'). " as oi inner join ".$ecs->table('comment')." as c on oi.order_id=c.order_id WHERE oi.user_id = '$user_id'".$all_order_list->where[$i];
		$record_count = $db->getOne($sql);
		break;
		case 2://待评价的订单
		$record_count = $db->getOne("SELECT COUNT(*) FROM " .$ecs->table('order_info'). " WHERE user_id = '$user_id'".$all_order_list->where[$i]) - $db->getOne("SELECT COUNT(*) FROM " .$ecs->table('order_info'). " as oi inner join ".$ecs->table('comment')." as c on oi.order_id=c.order_id WHERE oi.user_id = '$user_id'".$all_order_list->where[$i]);;
		break;
	  }
	  /*
	  echo "<pre>";
       print_r($all_order_list->pager);
	   echo "</pre>";
	   */
	   $all_order_list->pager[$i] = get_pager('user.php', array('act' => $action), $record_count, $page, 10,"page$i=","&ctl=$i");
	   $all_order_list->orders[$i] = get_all_orders($user_id, $all_order_list->pager[$i]['size'], $all_order_list->pager[$i]['start'],$all_order_list->where[$i],$all_order_list->comment[$i]);  
	 }
	
	    $smarty->assign("all_pages",   $all_order_list->pager);
	    $smarty->assign("all_orders", $all_order_list->orders);
		$smarty->assign("all_infos", $all_order_list->info);
   
	$smarty->display('user_clips.dwt');
}

/* 查看订单详情 eidt by chen 0901*/
elseif ($action == 'order_detail')
{
    include_once(ROOT_PATH . 'includes/lib_transaction.php');
    include_once(ROOT_PATH . 'includes/lib_payment.php');
    include_once(ROOT_PATH . 'includes/lib_order.php');
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

    /* 订单详情 */
    $order = get_order_detail($order_id, $user_id);
   
    if ($order === false)
    {
        $err->show($_LANG['back_home_lnk'], './');

        exit;
    }

    /* 是否显示添加到购物车 */
    if ($order['extension_code'] != 'group_buy' && $order['extension_code'] != 'exchange_goods')
    {
        $smarty->assign('allow_to_cart', 1);
    }

    /* 订单商品 */
    $goods_list = order_goods($order_id);
    foreach ($goods_list AS $key => $value)
    {
        $goods_list[$key]['market_price'] = price_format($value['market_price'], false);
        $goods_list[$key]['goods_price']  = price_format($value['goods_price'], false);
        $goods_list[$key]['subtotal']     = price_format($value['subtotal'], false);
    }

     /* 设置能否修改使用余额数 */
    if ($order['order_amount'] > 0)
    {
        if ($order['order_status'] == OS_UNCONFIRMED || $order['order_status'] == OS_CONFIRMED)
        {
            $user = user_info($order['user_id']);
            if ($user['user_money'] + $user['credit_line'] > 0)
            {
                $smarty->assign('allow_edit_surplus', 1);
                $smarty->assign('max_surplus', sprintf($_LANG['max_surplus'], $user['user_money']));
            }
        }
    }

    /* 未发货，未付款时允许更换支付方式 */
    if ($order['order_amount'] > 0 && $order['pay_status'] == PS_UNPAYED && $order['shipping_status'] == SS_UNSHIPPED)
    {
        $payment_list = available_payment_list(false, 0, true);

        /* 过滤掉当前支付方式和余额支付方式 */
        if(is_array($payment_list))
        {
            foreach ($payment_list as $key => $payment)
            {
                if ($payment['pay_id'] == $order['pay_id'] || $payment['pay_code'] == 'balance')
                {
                    unset($payment_list[$key]);
                }
            }
        }
        $smarty->assign('payment_list', $payment_list);
    }

    /* 订单 支付 配送 状态语言项 */
    $order['order_status'] = $_LANG['os'][$order['order_status']];
    $order['pay_status'] = $_LANG['ps'][$order['pay_status']];
    $order['shipping_status'] = $_LANG['ss'][$order['shipping_status']];
   
   $country_sql = 'select region_name from '. $ecs->table('region')." where region_id = ".$order['country'];
   $province_sql = 'select region_name from '. $ecs->table('region')." where region_id = ".$order['province'];
   $city_sql = 'select region_name from '. $ecs->table('region')." where region_id = ".$order['city'];
   $district_sql = 'select region_name from '. $ecs->table('region')." where region_id = ".$order['district'];
   $order['country']=$db->getOne($country_sql);
   $order['province']=$db->getOne($province_sql);
   $order['city']=$db->getOne($city_sql);
   $order['district']=$db->getOne($district_sql);
	
	
	$sql = "select express_type,express_company,express_no from ".$GLOBALS['ecs']->table('delivery_order')." where order_id='$order_id'";
	$freightInfo = $GLOBALS['db']->getRow($sql);
		

	$freightInfo['express_name'] = get_express_name($freightInfo['express_type'],$freightInfo['express_company']);
	//$express_info = get_express_info($freightType['express_type'],$freightType['express_company'],$freightType['express_no']);
	//var_dump($order);
	
	$smarty->assign('freightInfo', $freightInfo);
    $smarty->assign('order',      $order);
    $smarty->assign('goods_list', $goods_list);
	
    $smarty->display('user_transaction.dwt');
}

/* 取消订单0901 */
elseif ($action == 'cancel_order')
{
    include_once(ROOT_PATH . 'includes/lib_transaction.php');
    include_once(ROOT_PATH . 'includes/lib_order.php');

    $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

   if (cancel_order($order_id, $user_id))
    {
       ecs_header("Location: user.php?act=order_list");
        exit;
    }
    else
    {
	$redrectUrl="user.php?act=order_list";$smalltext="取消订单失败";$conent='请刷新页面或联系管理员处理';$actionStr='pageRedirect';$tempStr='user_passport.dwt';
	page_jump($smarty,$redrectUrl,$smalltext,$conent,$actionStr,$tempStr);
    }

}

/* 收货地址列表界面*/
elseif ($action == 'address_list')
{
    include_once(ROOT_PATH . 'includes/lib_transaction.php');
    include_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/shopping_flow.php');
    $smarty->assign('lang',  $_LANG);

    /* 取得国家列表、商店所在国家、商店所在国家的省列表 */
    $smarty->assign('country_list',       get_regions());
    $smarty->assign('shop_province_list', get_regions(1, $_CFG['shop_country']));

   /* 获得用户所有的收货人信息 */
    $consignee_list = get_consignee_list($_SESSION['user_id']);
    $nums=count($consignee_list);   //0820-guan  统计收货地址
    if (count($consignee_list) < 5 && $_SESSION['user_id'] > 0)
    {
        /* 如果用户收货人信息的总数小于5 则增加一个新的收货人信息 */
        $consignee_list[] = array('country' => $_CFG['shop_country'], 'email' => isset($_SESSION['email']) ? $_SESSION['email'] : '');
    }

    //取得国家列表，如果有收货人列表，取得省市区列表
    foreach ($consignee_list AS $region_id => $consignee)
    {
        if($consignee['district']){   //获取用户的所有收货人详细地址 0820-guan
            $pro=$consignee['province'];
            $city=$consignee['city'];
            $dis=$consignee['district'];
            $add=$db->getAll("SELECT region_name FROM " .$ecs->table('region'). " WHERE region_id in ($pro,$city,$dis)");
            $a=array(2,25,32,27,33,34,35,28,29,19);//直辖市：北京2，上海25，重庆32，天津27，港澳台33,34,35，西藏28，新疆29，内蒙古19
            $b=array(2,25,32,27);
            if(in_array($pro,$a)){
                if(in_array($pro,$b)){
                    $adds=$add[1]['region_name']."市".$add[2]['region_name'];
                }  else {
                     $adds=$add[0]['region_name'].$add[1]['region_name']."市".$add[2]['region_name'];
                }
            }  else {
                $adds=$add[0]['region_name']."省".$add[1]['region_name']."市".$add[2]['region_name'];
            }
        }
        $consignee_list[$region_id]['add']=$adds; //0822-guan
        $consignee['country']  = isset($consignee['country'])  ? intval($consignee['country'])  : 1;
        $consignee['province'] = isset($consignee['province']) ? intval($consignee['province']) : 0;
        $consignee['city']     = isset($consignee['city'])     ? intval($consignee['city'])     : 0;

        $province_list[$region_id] = get_regions(1, 1);
        $city_list[$region_id]     = get_regions(2, $consignee['province']);
        $district_list[$region_id] = get_regions(3, $consignee['city']);
   
    }
   /*  echo "<pre>";
    print_r($adds);
    echo "</pre>";
    * 
    */
    $smarty->assign('consignee_list', $consignee_list);
   
    /* 获取默认收货ID */
    $address_id  = $db->getOne("SELECT address_id FROM " .$ecs->table('users'). " WHERE user_id='$user_id'");

    //赋值于模板
    $smarty->assign('real_goods_count', 1);
	$smarty->assign('nums', $nums);
    $smarty->assign('shop_country',     $_CFG['shop_country']);
    $smarty->assign('shop_province',    get_regions(1, $_CFG['shop_country']));
    $smarty->assign('province_list',    $province_list);
    $smarty->assign('address',          $address_id);
    $smarty->assign('city_list',        $city_list);
    $smarty->assign('district_list',    $district_list);
    $smarty->assign('currency_format',  $_CFG['currency_format']);
    $smarty->assign('integral_scale',   $_CFG['integral_scale']);
    $smarty->assign('name_of_region',   array($_CFG['name_of_region_1'], $_CFG['name_of_region_2'], $_CFG['name_of_region_3'], $_CFG['name_of_region_4']));

    $smarty->display('user_transaction.dwt');
}
/*修改收货地址传参0821-guan*/
elseif ($action == 'xiugai')
{
    $address_id = intval($_REQUEST['id']);
    $xiugai =$db->getAll("SELECT address_id,province,city,district,address,zipcode,tel,consignee,is_first FROM " .$ecs->table('user_address'). " WHERE address_id='$address_id'");
    echo json_encode($xiugai);
   exit;
   // print_r($xiugai);
}
/* 添加/编辑收货地址的处理 */
elseif ($action == 'act_edit_address')
{
    include_once(ROOT_PATH . 'includes/lib_transaction.php');
    include_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/shopping_flow.php');
    $smarty->assign('lang', $_LANG);

    $address = array(
        'user_id'    => $user_id,
        'address_id' => intval($_POST['address_id']),
        'country'    => isset($_POST['country'])   ? intval($_POST['country'])  : 0,
        'province'   => isset($_POST['province'])  ? intval($_POST['province']) : 0,
        'city'       => isset($_POST['city'])      ? intval($_POST['city'])     : 0,
        'district'   => isset($_POST['district'])  ? intval($_POST['district']) : 0,
        'address'    => isset($_POST['address'])   ? compile_str(trim($_POST['address']))    : '',
        'consignee'  => isset($_POST['consignee']) ? compile_str(trim($_POST['consignee']))  : '',
        'email'      => isset($_POST['email'])     ? compile_str(trim($_POST['email']))      : '',
        'tel'        => isset($_POST['tel'])       ? compile_str(make_semiangle(trim($_POST['tel']))) : '',
        //'mobile'     => isset($_POST['mobile'])    ? compile_str(make_semiangle(trim($_POST['mobile']))) : '',
       // 'best_time'  => isset($_POST['best_time']) ? compile_str(trim($_POST['best_time']))  : '',
       // 'sign_building' => isset($_POST['sign_building']) ? compile_str(trim($_POST['sign_building'])) : '',
        'zipcode'       => isset($_POST['zipcode'])       ? compile_str(make_semiangle(trim($_POST['zipcode']))) : '',
        'is_first'       => isset($_POST['is_first'])  ? intval($_POST['is_first'])  : 1,//0821-guan
        );

  $flag = update_address($address);

    if ($flag == 2)
    {
        show_message('最多只能添加'.ADDRESS_NUM.'条收货地址', $_LANG['address_list_lnk'], 'user.php?act=address_list');
    }
	else if($flag == 1)
	{
	  show_message($_LANG['edit_address_success'], $_LANG['address_list_lnk'], 'user.php?act=address_list');
	}
}

/* 删除收货地址 */
elseif ($action == 'drop_consignee')
{
    include_once('includes/lib_transaction.php');

    $consignee_id = intval($_GET['id']);

    if (drop_consignee($consignee_id))
    {
        ecs_header("Location: user.php?act=address_list\n");
        exit;
    }
    else
    {
        show_message($_LANG['del_address_false']);
    }
}
/* 设为默认地址 0820-guan*/
elseif ($action == 'moren')
{
    include_once('includes/lib_transaction.php');

    $consignee_id = intval($_GET['id']);

    if (moren($consignee_id))
    {
        ecs_header("Location: user.php?act=address_list\n");
        exit;
    }
    else
    {
        show_message('设置默认地址失败！');
    }
}

elseif ($action == 'change_order_address')
{

$order = array(
   'province' => isset($_REQUEST['provinces']) ? intval($_REQUEST['provinces']) : 0,
   'city' =>  isset($_REQUEST['cities']) ? intval($_REQUEST['cities']) : 0,
   'district' => isset($_REQUEST['districts']) ? intval($_REQUEST['districts']) : 0,
   'address' => isset($_REQUEST['address']) ? compile_str(trim($_REQUEST['address']))    : '',     
   'consignee' => isset($_REQUEST['consignee']) ? compile_str(trim($_REQUEST['consignee']))    : '',
   'mobile'  => isset($_REQUEST['phone']) ? compile_str(make_semiangle(trim($_REQUEST['phone'])))    : '',
   'zipcode' => isset($_REQUEST['zip_code']) ? compile_str(make_semiangle(trim($_REQUEST['zip_code'])))    : '',
   'order_sn' => isset($_REQUEST['order_sn']) ? compile_str(make_semiangle(trim($_REQUEST['order_sn'])))    : '',
);
if($_SESSION['user_id'] <=0 || !$_SESSION['user_id'])
{
  echo json_encode(array('result' => 'error','errorInfo' => '您可能长时间没有进行操作，系统自动登出。请重新登录。'));
  die;
}
else
{
$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_info'), $order, 'UPDATE', 'order_sn = ' .$order['order_sn'] . ' AND user_id = ' . $_SESSION['user_id']);
$callbackElemId = isset($_REQUEST['callbackElemId']) ? compile_str(make_semiangle(trim($_REQUEST['callbackElemId'])))    : '';
$hideElemIdList = isset($_REQUEST['hideElemIdList']) ? compile_str(make_semiangle(trim($_REQUEST['hideElemIdList'])))    : '';
$hideElemArr = explode(',',$hideElemIdList);

 $sql = "select region_name from ".$GLOBALS['ecs']->table('region')." where region_id = ".$order['province'];
 $order['province'] = $GLOBALS['db']->getOne($sql);
 $sql = "select region_name from ".$GLOBALS['ecs']->table('region')." where region_id = ".$order['city'];
 $order['city'] = $GLOBALS['db']->getOne($sql);
 $sql = "select region_name from ".$GLOBALS['ecs']->table('region')." where region_id = ".$order['district'];
 $order['district'] = $GLOBALS['db']->getOne($sql);

die(json_encode(array('result'=>'success','successInfo'=>'您已成功修改收货地址','callbackElemId'=>$callbackElemId,'value'=>$order,'hideElemArr' => $hideElemArr)));
}  
  die;
}
/* 显示收藏商品列表 */
elseif ($action == 'collection_list')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');
    $rank = get_rank_info();    // 显示用户信息  chen 0827
	$smarty->assign('info',        get_user_default($user_id)); 	
	$smarty->assign('vip_name',  $rank['rank_name']);   
	
    $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
    $record_count = $db->getOne("SELECT COUNT(*) FROM " .$ecs->table('collect_goods').
                                " WHERE user_id='$user_id' ORDER BY add_time DESC");
							

    $pager = get_pager('user.php', array('act' => $action), $record_count, $page,20); //每页显示20条 chen 0827
    $smarty->assign('pager', $pager);
    $smarty->assign('goods_list', get_collection_goods($user_id, $pager['size'], $pager['start']));
    $smarty->assign('url',        $ecs->url());
    $lang_list = array(
        'UTF8'   => $_LANG['charset']['utf8'],
        'GB2312' => $_LANG['charset']['zh_cn'],
        'BIG5'   => $_LANG['charset']['zh_tw'],
    );
    $smarty->assign('lang_list',  $lang_list);
    $smarty->assign('user_id',  $user_id);
    $smarty->display('user_clips.dwt');
}

/* 删除收藏的商品 */
elseif ($action == 'delete_collection')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    $collection_id = isset($_GET['collection_id']) ? intval($_GET['collection_id']) : 0;

    if ($collection_id > 0)
    {
        $db->query('DELETE FROM ' .$ecs->table('collect_goods'). " WHERE rec_id='$collection_id' AND user_id ='$user_id'" );
    }

    ecs_header("Location: user.php?act=collection_list\n");
    exit;
}

/* 添加关注商品 */
elseif ($action == 'add_to_attention')
{
    $rec_id = (int)$_GET['rec_id'];
    if ($rec_id)
    {
        $db->query('UPDATE ' .$ecs->table('collect_goods'). "SET is_attention = 1 WHERE rec_id='$rec_id' AND user_id ='$user_id'" );
    }
    ecs_header("Location: user.php?act=collection_list\n");
    exit;
}
/* 取消关注商品 */
elseif ($action == 'del_attention')
{
    $rec_id = (int)$_GET['rec_id'];
    if ($rec_id)
    {
        $db->query('UPDATE ' .$ecs->table('collect_goods'). "SET is_attention = 0 WHERE rec_id='$rec_id' AND user_id ='$user_id'" );
    }
    ecs_header("Location: user.php?act=collection_list\n");
    exit;
}
/* 显示留言列表 */
elseif ($action == 'message_list')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

    $order_id = empty($_GET['order_id']) ? 0 : intval($_GET['order_id']);
    $order_info = array();

    /* 获取用户留言的数量 */
    if ($order_id)
    {
        $sql = "SELECT COUNT(*) FROM " .$ecs->table('feedback').
                " WHERE parent_id = 0 AND order_id = '$order_id' AND user_id = '$user_id'";
        $order_info = $db->getRow("SELECT * FROM " . $ecs->table('order_info') . " WHERE order_id = '$order_id' AND user_id = '$user_id'");
        $order_info['url'] = 'user.php?act=order_detail&order_id=' . $order_id;
    }
    else
    {
        $sql = "SELECT COUNT(*) FROM " .$ecs->table('feedback').
           " WHERE parent_id = 0 AND user_id = '$user_id' AND user_name = '" . $_SESSION['user_name'] . "' AND order_id=0";
    }

    $record_count = $db->getOne($sql);
    $act = array('act' => $action);

    if ($order_id != '')
    {
        $act['order_id'] = $order_id;
    }

    $pager = get_pager('user.php', $act, $record_count, $page, 5);

    $smarty->assign('message_list', get_message_list($user_id, $_SESSION['user_name'], $pager['size'], $pager['start'], $order_id));
    $smarty->assign('pager',        $pager);
    $smarty->assign('order_info',   $order_info);
    $smarty->display('user_clips.dwt');
}
/* 显示用户投诉列表 */
elseif ($action == 'complain_list')
{

    include_once(ROOT_PATH . 'includes/lib_clips.php');
	$rank = get_rank_info();
	$smarty->assign('info',        get_user_default($user_id)); 	//用户信息
	$smarty->assign('vip_name',  $rank['rank_name']);   // 用户名

	  
    $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

    /* 获取用户留言的数量 */
    $sql = "SELECT COUNT(*) FROM " .$ecs->table('complain').
           " where user_id = '$user_id'";
    $record_count = $db->getOne($sql);
	
	
    $pager = get_pager('user.php', array('act' => $action), $record_count, $page, 5);
	
    $smarty->assign('complain_list', get_complain_list($user_id, $pager['size'], $pager['start']));
    $smarty->assign('pager',        $pager);
	
    $smarty->display('user_clips.dwt');
}
/* 对购买的商品进行评论 chen-0914 */
elseif ($action == 'comment_goods')
{
 include_once(ROOT_PATH . 'includes/lib_clips.php');
 $arr_id_list=explode(',',$_REQUEST['goods_id_list']);
 $goods_list = array();
 foreach($arr_id_list as $goods_id)
 {
 $sql = "select goods_id,goods_thumb, shop_price, goods_name from ".$ecs->table('goods')." where goods_id = $goods_id";
 $goods = $db->getRow($sql);
    $goods_list[] = $goods;
 }

  $smarty->assign('goods_num',count($arr_id_list));
    $smarty->assign('goods_list',$goods_list);
	$smarty->assign('order_id',$_REQUEST['order_id']);
   $smarty->display('user_clips.dwt');
}
/* 显示评论列表 */
elseif ($action == 'comment_list')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

    /* 获取用户留言的数量 */
    $sql = "SELECT COUNT(*) FROM " .$ecs->table('comment').
           " WHERE parent_id = 0 AND user_id = '$user_id'";
    $record_count = $db->getOne($sql);
    $pager = get_pager('user.php', array('act' => $action), $record_count, $page, 15);

	 $rank = get_rank_info();
	 $smarty->assign('info',        get_user_default($user_id)); 	//用户信息
	  $smarty->assign('vip_name',  $rank['rank_name']);   // 用户名
	  
    $smarty->assign('comment_list', get_comment_list($user_id, $pager['size'], $pager['start']));
    $smarty->assign('pager',        $pager);
	
    $smarty->display('user_clips.dwt');
}
/* 显示购物券列表 */
elseif ($action == 'coupons')
{
    require_once('includes/cls_coupon.php');
   $couponsConditions = coupon::getCouponsConditions();

   $coupons_list = array();
   foreach ($couponsConditions as $key => $con) {
    $coupons_list[$key] = get_coupons_list($user_id, $key, $con);
   }

   $smarty->assign('coupons_list', $coupons_list);
   $smarty->display('user_clips.dwt');
}

/* 显示退货页 */
elseif ($action == 'return_goods')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

    /* 获取用户退款申请的总记录数 */
    $sql = "SELECT COUNT(*) FROM " .$ecs->table('back_order').
           " WHERE is_cancled=0 and user_id=".$user_id;
    $record_count = $db->getOne($sql);
    $pager = get_pager('user.php', array('act' => $action), $record_count, $page, 5);

	$rank = get_rank_info();
	$smarty->assign('info',        get_user_default($user_id)); 	//用户信息
	$smarty->assign('vip_name',  $rank['rank_name']);   // 用户名
	$now=gmtime();
	$smarty->assign('current_time',$now);       
	  
	  $smarty->assign('user_order_list',monthly_order_list($user_id));
	//  $a=monthly_order_list($user_id);
	  //var_dump($a[0]['goods']);
	 // var_dump($a[0]);
	 // echo $user_id;
	 // var_dump($pager);
	// $a= return_goods_history($user_id, $pager['size'], $pager['start']);
	// var_dump($a);
    $smarty->assign('return_goods_history', return_goods_history($user_id, $pager['size'], $pager['start']));
    $smarty->assign('pager',        $pager);
	
    $smarty->display('user_clips.dwt');
}
/* 添加我的留言 */
elseif ($action == 'act_add_message')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    $message = array(
        'user_id'     => $user_id,
        'user_name'   => $_SESSION['user_name'],
        'user_email'  => $_SESSION['email'],
        'msg_type'    => isset($_POST['msg_type']) ? intval($_POST['msg_type'])     : 0,
        'msg_title'   => isset($_POST['msg_title']) ? trim($_POST['msg_title'])     : '',
        'msg_content' => isset($_POST['msg_content']) ? trim($_POST['msg_content']) : '',
        'order_id'=>empty($_POST['order_id']) ? 0 : intval($_POST['order_id']),
        'upload'      => (isset($_FILES['message_img']['error']) && $_FILES['message_img']['error'] == 0) || (!isset($_FILES['message_img']['error']) && isset($_FILES['message_img']['tmp_name']) && $_FILES['message_img']['tmp_name'] != 'none')
         ? $_FILES['message_img'] : array()
     );

    if (add_message($message))
    {
        show_message($_LANG['add_message_success'], $_LANG['message_list_lnk'], 'user.php?act=message_list&order_id=' . $message['order_id'],'info');
    }
    else
    {
        $err->show($_LANG['message_list_lnk'], 'user.php?act=message_list');
    }
}

/* 标签云列表 */
elseif ($action == 'tag_list')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    $good_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $smarty->assign('tags',      get_user_tags($user_id));
    $smarty->assign('tags_from', 'user');
    $smarty->display('user_clips.dwt');
}

/* 删除标签云的处理 */
elseif ($action == 'act_del_tag')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    $tag_words = isset($_GET['tag_words']) ? trim($_GET['tag_words']) : '';
    delete_tag($tag_words, $user_id);

    ecs_header("Location: user.php?act=tag_list\n");
    exit;

}

/* 显示缺货登记列表 */
elseif ($action == 'booking_list')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

    /* 获取缺货登记的数量 */
    $sql = "SELECT COUNT(*) " .
            "FROM " .$ecs->table('booking_goods'). " AS bg, " .
                     $ecs->table('goods') . " AS g " .
            "WHERE bg.goods_id = g.goods_id AND user_id = '$user_id'";
    $record_count = $db->getOne($sql);
    $pager = get_pager('user.php', array('act' => $action), $record_count, $page);

    $smarty->assign('booking_list', get_booking_list($user_id, $pager['size'], $pager['start']));
    $smarty->assign('pager',        $pager);
    $smarty->display('user_clips.dwt');
}
/* 添加缺货登记页面 */
elseif ($action == 'add_booking')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    $goods_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($goods_id == 0)
    {
        show_message($_LANG['no_goods_id'], $_LANG['back_page_up'], '', 'error');
    }

    /* 根据规格属性获取货品规格信息 */
    $goods_attr = '';
    if ($_GET['spec'] != '')
    {
        $goods_attr_id = $_GET['spec'];

        $attr_list = array();
        $sql = "SELECT a.attr_name, g.attr_value " .
                "FROM " . $ecs->table('goods_attr') . " AS g, " .
                    $ecs->table('attribute') . " AS a " .
                "WHERE g.attr_id = a.attr_id " .
                "AND g.goods_attr_id " . db_create_in($goods_attr_id);
        $res = $db->query($sql);
        while ($row = $db->fetchRow($res))
        {
            $attr_list[] = $row['attr_name'] . ': ' . $row['attr_value'];
        }
        $goods_attr = join(chr(13) . chr(10), $attr_list);
    }
    $smarty->assign('goods_attr', $goods_attr);

    $smarty->assign('info', get_goodsinfo($goods_id));
    $smarty->display('user_clips.dwt');

}

/* 添加缺货登记的处理 */
elseif ($action == 'act_add_booking')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    $booking = array(
        'goods_id'     => isset($_POST['id'])      ? intval($_POST['id'])     : 0,
        'goods_amount' => isset($_POST['number'])  ? intval($_POST['number']) : 0,
        'desc'         => isset($_POST['desc'])    ? trim($_POST['desc'])     : '',
        'linkman'      => isset($_POST['linkman']) ? trim($_POST['linkman'])  : '',
        'email'        => isset($_POST['email'])   ? trim($_POST['email'])    : '',
        'tel'          => isset($_POST['tel'])     ? trim($_POST['tel'])      : '',
        'booking_id'   => isset($_POST['rec_id'])  ? intval($_POST['rec_id']) : 0
    );

    // 查看此商品是否已经登记过
    $rec_id = get_booking_rec($user_id, $booking['goods_id']);
    if ($rec_id > 0)
    {
        show_message($_LANG['booking_rec_exist'], $_LANG['back_page_up'], '', 'error');
    }

    if (add_booking($booking))
    {
        show_message($_LANG['booking_success'], $_LANG['back_booking_list'], 'user.php?act=booking_list',
        'info');
    }
    else
    {
        $err->show($_LANG['booking_list_lnk'], 'user.php?act=booking_list');
    }
}

/* 删除缺货登记 */
elseif ($action == 'act_del_booking')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id == 0 || $user_id == 0)
    {
        ecs_header("Location: user.php?act=booking_list\n");
        exit;
    }

    $result = delete_booking($id, $user_id);
    if ($result)
    {
        ecs_header("Location: user.php?act=booking_list\n");
        exit;
    }
}

/* 确认收货 chen-0910*/
elseif ($action == 'affirm_received')
{
    include_once(ROOT_PATH . 'includes/lib_transaction.php');

    $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

   if (affirm_received($order_id, $user_id))
    {
      ecs_header("Location: user.php?act=order_list&ctl=4\n");
       exit;
    }
    else
    {
      //  $err->show($_LANG['order_list_lnk'], 'user.php?act=order_list');
	   $smarty->assign('redrectUrl',"user.php?act=order_list&ctl=3");
            $smarty->assign('smalltext','确认收货失败');
            $smarty->assign('content','确认收货失败。3秒后将返回订单页，如果未返回请');       
           $smarty->assign('action', 'pageRedirect');
            $smarty->display('user_passport.dwt');
    }
}

/* 会员退款申请界面 */
elseif ($action == 'account_raply')
{
    $smarty->display('user_transaction.dwt');
}

/* 会员预付款界面 */
elseif ($action == 'account_deposit')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    $surplus_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $account    = get_surplus_info($surplus_id);

    $smarty->assign('payment', get_online_payment_list(false));
    $smarty->assign('order',   $account);
    $smarty->display('user_transaction.dwt');
}

/* 会员账目明细界面 */
elseif ($action == 'account_detail')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

    $account_type = 'user_money';

    /* 获取记录条数 */
    $sql = "SELECT COUNT(*) FROM " .$ecs->table('account_log').
           " WHERE user_id = '$user_id'" .
           " AND $account_type <> 0 ";
    $record_count = $db->getOne($sql);

    //分页函数
    $pager = get_pager('user.php', array('act' => $action), $record_count, $page);

    //获取剩余余额
    $surplus_amount = get_user_surplus($user_id);
    if (empty($surplus_amount))
    {
        $surplus_amount = 0;
    }

    //获取余额记录
    $account_log = array();
    $sql = "SELECT * FROM " . $ecs->table('account_log') .
           " WHERE user_id = '$user_id'" .
           " AND $account_type <> 0 " .
           " ORDER BY log_id DESC";
    $res = $GLOBALS['db']->selectLimit($sql, $pager['size'], $pager['start']);
    while ($row = $db->fetchRow($res))
    {
        $row['change_time'] = local_date($_CFG['date_format'], $row['change_time']);
        $row['type'] = $row[$account_type] > 0 ? $_LANG['account_inc'] : $_LANG['account_dec'];
        $row['user_money'] = price_format(abs($row['user_money']), false);
        $row['frozen_money'] = price_format(abs($row['frozen_money']), false);
        $row['rank_points'] = abs($row['rank_points']);
        $row['pay_points'] = abs($row['pay_points']);
        $row['short_change_desc'] = sub_str($row['change_desc'], 60);
        $row['amount'] = $row[$account_type];
        $account_log[] = $row;
    }

    //模板赋值
    $smarty->assign('surplus_amount', price_format($surplus_amount, false));
    $smarty->assign('account_log',    $account_log);
    $smarty->assign('pager',          $pager);
    $smarty->display('user_transaction.dwt');
}

/* 会员充值和提现申请记录 */
elseif ($action == 'account_log')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

    /* 获取记录条数 */
    $sql = "SELECT COUNT(*) FROM " .$ecs->table('user_account').
           " WHERE user_id = '$user_id'" .
           " AND process_type " . db_create_in(array(SURPLUS_SAVE, SURPLUS_RETURN));
    $record_count = $db->getOne($sql);

    //分页函数
    $pager = get_pager('user.php', array('act' => $action), $record_count, $page);

    //获取剩余余额
    $surplus_amount = get_user_surplus($user_id);
    if (empty($surplus_amount))
    {
        $surplus_amount = 0;
    }

    //获取余额记录
    $account_log = get_account_log($user_id, $pager['size'], $pager['start']);

    //模板赋值
    $smarty->assign('surplus_amount', price_format($surplus_amount, false));
    $smarty->assign('account_log',    $account_log);
    $smarty->assign('pager',          $pager);
    $smarty->display('user_transaction.dwt');
}

/* 对会员余额申请的处理 */
elseif ($action == 'act_account')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');
    include_once(ROOT_PATH . 'includes/lib_order.php');
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
    if ($amount <= 0)
    {
        show_message($_LANG['amount_gt_zero']);
    }

    /* 变量初始化 */
    $surplus = array(
            'user_id'      => $user_id,
            'rec_id'       => !empty($_POST['rec_id'])      ? intval($_POST['rec_id'])       : 0,
            'process_type' => isset($_POST['surplus_type']) ? intval($_POST['surplus_type']) : 0,
            'payment_id'   => isset($_POST['payment_id'])   ? intval($_POST['payment_id'])   : 0,
            'user_note'    => isset($_POST['user_note'])    ? trim($_POST['user_note'])      : '',
            'amount'       => $amount
    );

    /* 退款申请的处理 */
    if ($surplus['process_type'] == 1)
    {
        /* 判断是否有足够的余额的进行退款的操作 */
        $sur_amount = get_user_surplus($user_id);
        if ($amount > $sur_amount)
        {
            $content = $_LANG['surplus_amount_error'];
            show_message($content, $_LANG['back_page_up'], '', 'info');
        }

        //插入会员账目明细
        $amount = '-'.$amount;
        $surplus['payment'] = '';
        $surplus['rec_id']  = insert_user_account($surplus, $amount);

        /* 如果成功提交 */
        if ($surplus['rec_id'] > 0)
        {
            $content = $_LANG['surplus_appl_submit'];
            show_message($content, $_LANG['back_account_log'], 'user.php?act=account_log', 'info');
        }
        else
        {
            $content = $_LANG['process_false'];
            show_message($content, $_LANG['back_page_up'], '', 'info');
        }
    }
    /* 如果是会员预付款，跳转到下一步，进行线上支付的操作 */
    else
    {
        if ($surplus['payment_id'] <= 0)
        {
            show_message($_LANG['select_payment_pls']);
        }

        include_once(ROOT_PATH .'includes/lib_payment.php');

        //获取支付方式名称
        $payment_info = array();
        $payment_info = payment_info($surplus['payment_id']);
        $surplus['payment'] = $payment_info['pay_name'];

        if ($surplus['rec_id'] > 0)
        {
            //更新会员账目明细
            $surplus['rec_id'] = update_user_account($surplus);
        }
        else
        {
            //插入会员账目明细
            $surplus['rec_id'] = insert_user_account($surplus, $amount);
        }

        //取得支付信息，生成支付代码
        $payment = unserialize_config($payment_info['pay_config']);

        //生成伪订单号, 不足的时候补0
        $order = array();
        $order['order_sn']       = $surplus['rec_id'];
        $order['user_name']      = $_SESSION['user_name'];
        $order['surplus_amount'] = $amount;

        //计算支付手续费用
        $payment_info['pay_fee'] = pay_fee($surplus['payment_id'], $order['surplus_amount'], 0);

        //计算此次预付款需要支付的总金额
        $order['order_amount']   = $amount + $payment_info['pay_fee'];

        //记录支付log
        $order['log_id'] = insert_pay_log($surplus['rec_id'], $order['order_amount'], $type=PAY_SURPLUS, 0);

        /* 调用相应的支付方式文件 */
        include_once(ROOT_PATH . 'includes/modules/payment/' . $payment_info['pay_code'] . '.php');

        /* 取得在线支付方式的支付按钮 */
        $pay_obj = new $payment_info['pay_code'];
        $payment_info['pay_button'] = $pay_obj->get_code($order, $payment);

        /* 模板赋值 */
        $smarty->assign('payment', $payment_info);
        $smarty->assign('pay_fee', price_format($payment_info['pay_fee'], false));
        $smarty->assign('amount',  price_format($amount, false));
		
        $smarty->assign('order',   $order);
        $smarty->display('user_transaction.dwt');
    }
}

/* 删除会员余额 */
elseif ($action == 'cancel')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id == 0 || $user_id == 0)
    {
        ecs_header("Location: user.php?act=account_log\n");
        exit;
    }

    $result = del_user_account($id, $user_id);
    if ($result)
    {
        ecs_header("Location: user.php?act=account_log\n");
        exit;
    }
}

/* 会员通过帐目明细列表进行再付款的操作 */
elseif ($action == 'pay')
{
    include_once(ROOT_PATH . 'includes/lib_clips.php');
    include_once(ROOT_PATH . 'includes/lib_payment.php');
    include_once(ROOT_PATH . 'includes/lib_order.php');

    //变量初始化
    $surplus_id = isset($_GET['id'])  ? intval($_GET['id'])  : 0;
    $payment_id = isset($_GET['pid']) ? intval($_GET['pid']) : 0;

    if ($surplus_id == 0)
    {
        ecs_header("Location: user.php?act=account_log\n");
        exit;
    }

    //如果原来的支付方式已禁用或者已删除, 重新选择支付方式
    if ($payment_id == 0)
    {
        ecs_header("Location: user.php?act=account_deposit&id=".$surplus_id."\n");
        exit;
    }

    //获取单条会员帐目信息
    $order = array();
    $order = get_surplus_info($surplus_id);

    //支付方式的信息
    $payment_info = array();
    $payment_info = payment_info($payment_id);

    /* 如果当前支付方式没有被禁用，进行支付的操作 */
    if (!empty($payment_info))
    {
        //取得支付信息，生成支付代码
        $payment = unserialize_config($payment_info['pay_config']);

        //生成伪订单号
        $order['order_sn'] = $surplus_id;

        //获取需要支付的log_id
        $order['log_id'] = get_paylog_id($surplus_id, $pay_type = PAY_SURPLUS);

        $order['user_name']      = $_SESSION['user_name'];
        $order['surplus_amount'] = $order['amount'];

        //计算支付手续费用
        $payment_info['pay_fee'] = pay_fee($payment_id, $order['surplus_amount'], 0);

        //计算此次预付款需要支付的总金额
        $order['order_amount']   = $order['surplus_amount'] + $payment_info['pay_fee'];

        //如果支付费用改变了，也要相应的更改pay_log表的order_amount
        $order_amount = $db->getOne("SELECT order_amount FROM " .$ecs->table('pay_log')." WHERE log_id = '$order[log_id]'");
        if ($order_amount <> $order['order_amount'])
        {
            $db->query("UPDATE " .$ecs->table('pay_log').
                       " SET order_amount = '$order[order_amount]' WHERE log_id = '$order[log_id]'");
        }

        /* 调用相应的支付方式文件 */
        include_once(ROOT_PATH . 'includes/modules/payment/' . $payment_info['pay_code'] . '.php');

        /* 取得在线支付方式的支付按钮 */
        $pay_obj = new $payment_info['pay_code'];
        $payment_info['pay_button'] = $pay_obj->get_code($order, $payment);

        /* 模板赋值 */
        $smarty->assign('payment', $payment_info);
        $smarty->assign('order',   $order);
        $smarty->assign('pay_fee', price_format($payment_info['pay_fee'], false));
        $smarty->assign('amount',  price_format($order['surplus_amount'], false));
        $smarty->assign('action',  'act_account');
        $smarty->display('user_transaction.dwt');
    }
    /* 重新选择支付方式 */
    else
    {
        include_once(ROOT_PATH . 'includes/lib_clips.php');

        $smarty->assign('payment', get_online_payment_list());
        $smarty->assign('order',   $order);
        $smarty->assign('action',  'account_deposit');
        $smarty->display('user_transaction.dwt');
    }
}

/* 添加标签(ajax) */
elseif ($action == 'add_tag')
{
    include_once('includes/cls_json.php');
    include_once('includes/lib_clips.php');

    $result = array('error' => 0, 'message' => '', 'content' => '');
    $id     = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $tag    = isset($_POST['tag']) ? json_str_iconv(trim($_POST['tag'])) : '';

    if ($user_id == 0)
    {
        /* 用户没有登录 */
        $result['error']   = 1;
        $result['message'] = $_LANG['tag_anonymous'];
    }
    else
    {
        add_tag($id, $tag); // 添加tag
        clear_cache_files('goods'); // 删除缓存

        /* 重新获得该商品的所有缓存 */
        $arr = get_tags($id);

        foreach ($arr AS $row)
        {
            $result['content'][] = array('word' => htmlspecialchars($row['tag_words']), 'count' => $row['tag_count']);
        }
    }

    $json = new JSON;

    echo $json->encode($result);
    exit;
}

/* 添加收藏商品(ajax) */
elseif ($action == 'collect')
{
    include_once(ROOT_PATH .'includes/cls_json.php');
    $json = new JSON();
    $result = array('error' => 0, 'message' => '');
    $goods_id = $_GET['id'];

    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == 0)
    {
        $result['error'] = 1;
        $result['message'] = $_LANG['login_please'];
        die($json->encode($result));
    }
    else
    {
        /* 检查是否已经存在于用户的收藏夹 */
        $sql = "SELECT COUNT(*) FROM " .$GLOBALS['ecs']->table('collect_goods') .
            " WHERE user_id='$_SESSION[user_id]' AND goods_id = '$goods_id'";
        if ($GLOBALS['db']->GetOne($sql) > 0)
        {
            $result['error'] = 1;
            $result['message'] = $GLOBALS['_LANG']['collect_existed'];
            die($json->encode($result));
        }
        else
        {
            $time = gmtime();
            $sql = "INSERT INTO " .$GLOBALS['ecs']->table('collect_goods'). " (user_id, goods_id, add_time)" .
                    "VALUES ('$_SESSION[user_id]', '$goods_id', '$time')";

            if ($GLOBALS['db']->query($sql) === false)
            {
                $result['error'] = 1;
                $result['message'] = $GLOBALS['db']->errorMsg();
                die($json->encode($result));
            }
            else
            {
                $result['error'] = 0;
                $result['message'] = $GLOBALS['_LANG']['collect_success'];
                die($json->encode($result));
            }
        }
    }
}

/* 删除留言 */
elseif ($action == 'del_msg')
{
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $order_id = empty($_GET['order_id']) ? 0 : intval($_GET['order_id']);

    if ($id > 0)
    {
        $sql = 'SELECT user_id, message_img FROM ' .$ecs->table('feedback'). " WHERE msg_id = '$id' LIMIT 1";
        $row = $db->getRow($sql);
        if ($row && $row['user_id'] == $user_id)
        {
            /* 验证通过，删除留言，回复，及相应文件 */
            if ($row['message_img'])
            {
                @unlink(ROOT_PATH . DATA_DIR . '/feedbackimg/'. $row['message_img']);
            }
            $sql = "DELETE FROM " .$ecs->table('feedback'). " WHERE msg_id = '$id' OR parent_id = '$id'";
            $db->query($sql);
        }
    }
    ecs_header("Location: user.php?act=message_list&order_id=$order_id\n");
    exit;
}

/* 删除评论 */
elseif ($action == 'del_cmt')
{
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id > 0)
    {
        $sql = "DELETE FROM " .$ecs->table('comment'). " WHERE comment_id = '$id' AND user_id = '$user_id'";
        $db->query($sql);
    }
    ecs_header("Location: user.php?act=comment_list\n");
    exit;
}

/* 合并订单 */
elseif ($action == 'merge_order')
{
    include_once(ROOT_PATH .'includes/lib_transaction.php');
    include_once(ROOT_PATH .'includes/lib_order.php');
    $from_order = isset($_POST['from_order']) ? trim($_POST['from_order']) : '';
    $to_order   = isset($_POST['to_order']) ? trim($_POST['to_order']) : '';
    if (merge_user_order($from_order, $to_order, $user_id))
    {
        show_message($_LANG['merge_order_success'],$_LANG['order_list_lnk'],'user.php?act=order_list', 'info');
    }
    else
    {
        $err->show($_LANG['order_list_lnk']);
    }
}
/* 将指定订单中商品添加到购物车 */
elseif ($action == 'return_to_cart')
{
    include_once(ROOT_PATH .'includes/cls_json.php');
    include_once(ROOT_PATH .'includes/lib_transaction.php');
    $json = new JSON();

    $result = array('error' => 0, 'message' => '', 'content' => '');
    $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    if ($order_id == 0)
    {
        $result['error']   = 1;
        $result['message'] = $_LANG['order_id_empty'];
        die($json->encode($result));
    }

    if ($user_id == 0)
    {
        /* 用户没有登录 */
        $result['error']   = 1;
        $result['message'] = $_LANG['login_please'];
        die($json->encode($result));
    }

    /* 检查订单是否属于该用户 */
    $order_user = $db->getOne("SELECT user_id FROM " .$ecs->table('order_info'). " WHERE order_id = '$order_id'");
    if (empty($order_user))
    {
        $result['error'] = 1;
        $result['message'] = $_LANG['order_exist'];
        die($json->encode($result));
    }
    else
    {
        if ($order_user != $user_id)
        {
            $result['error'] = 1;
            $result['message'] = $_LANG['no_priv'];
            die($json->encode($result));
        }
    }

    $message = return_to_cart($order_id);

    if ($message === true)
    {
        $result['error'] = 0;
        $result['message'] = $_LANG['return_to_cart_success'];
        die($json->encode($result));
    }
    else
    {
        $result['error'] = 1;
        $result['message'] = $_LANG['order_exist'];
        die($json->encode($result));
    }

}

/* 编辑使用余额支付的处理 */
elseif ($action == 'act_edit_surplus')
{
    /* 检查是否登录 */
    if ($_SESSION['user_id'] <= 0)
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 检查订单号 */
    $order_id = intval($_POST['order_id']);
    if ($order_id <= 0)
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 检查余额 */
    $surplus = floatval($_POST['surplus']);
    if ($surplus <= 0)
    {
        $err->add($_LANG['error_surplus_invalid']);
        $err->show($_LANG['order_detail'], 'user.php?act=order_detail&order_id=' . $order_id);
    }

    include_once(ROOT_PATH . 'includes/lib_order.php');

    /* 取得订单 */
    $order = order_info($order_id);
    if (empty($order))
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 检查订单用户跟当前用户是否一致 */
    if ($_SESSION['user_id'] != $order['user_id'])
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 检查订单是否未付款，检查应付款金额是否大于0 */
    if ($order['pay_status'] != PS_UNPAYED || $order['order_amount'] <= 0)
    {
        $err->add($_LANG['error_order_is_paid']);
        $err->show($_LANG['order_detail'], 'user.php?act=order_detail&order_id=' . $order_id);
    }

    /* 计算应付款金额（减去支付费用） */
    $order['order_amount'] -= $order['pay_fee'];

    /* 余额是否超过了应付款金额，改为应付款金额 */
    if ($surplus > $order['order_amount'])
    {
        $surplus = $order['order_amount'];
    }

    /* 取得用户信息 */
    $user = user_info($_SESSION['user_id']);

    /* 用户帐户余额是否足够 */
    if ($surplus > $user['user_money'] + $user['credit_line'])
    {
        $err->add($_LANG['error_surplus_not_enough']);
        $err->show($_LANG['order_detail'], 'user.php?act=order_detail&order_id=' . $order_id);
    }

    /* 修改订单，重新计算支付费用 */
    $order['surplus'] += $surplus;
    $order['order_amount'] -= $surplus;
    if ($order['order_amount'] > 0)
    {
        $cod_fee = 0;
        if ($order['shipping_id'] > 0)
        {
            $regions  = array($order['country'], $order['province'], $order['city'], $order['district']);
            $shipping = shipping_area_info($order['shipping_id'], $regions);
            if ($shipping['support_cod'] == '1')
            {
                $cod_fee = $shipping['pay_fee'];
            }
        }

        $pay_fee = 0;
        if ($order['pay_id'] > 0)
        {
            $pay_fee = pay_fee($order['pay_id'], $order['order_amount'], $cod_fee);
        }

        $order['pay_fee'] = $pay_fee;
        $order['order_amount'] += $pay_fee;
    }

    /* 如果全部支付，设为已确认、已付款 */
    if ($order['order_amount'] == 0)
    {
        if ($order['order_status'] == OS_UNCONFIRMED)
        {
            $order['order_status'] = OS_CONFIRMED;
            $order['confirm_time'] = gmtime();
        }
        $order['pay_status'] = PS_PAYED;
        $order['pay_time'] = gmtime();
    }
    $order = addslashes_deep($order);
    update_order($order_id, $order);

    /* 更新用户余额 */
    $change_desc = sprintf($_LANG['pay_order_by_surplus'], $order['order_sn']);
    log_account_change($user['user_id'], (-1) * $surplus, 0, 0, 0, $change_desc);

    /* 跳转 */
    ecs_header('Location: user.php?act=order_detail&order_id=' . $order_id . "\n");
    exit;
}

/* 编辑使用余额支付的处理 */
elseif ($action == 'act_edit_payment')
{
    /* 检查是否登录 */
    if ($_SESSION['user_id'] <= 0)
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 检查支付方式 */
    $pay_id = intval($_POST['pay_id']);
    if ($pay_id <= 0)
    {
        ecs_header("Location: ./\n");
        exit;
    }

    include_once(ROOT_PATH . 'includes/lib_order.php');
    $payment_info = payment_info($pay_id);
    if (empty($payment_info))
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 检查订单号 */
    $order_id = intval($_POST['order_id']);
    if ($order_id <= 0)
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 取得订单 */
    $order = order_info($order_id);
    if (empty($order))
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 检查订单用户跟当前用户是否一致 */
    if ($_SESSION['user_id'] != $order['user_id'])
    {
        ecs_header("Location: ./\n");
        exit;
    }

    /* 检查订单是否未付款和未发货 以及订单金额是否为0 和支付id是否为改变*/
    if ($order['pay_status'] != PS_UNPAYED || $order['shipping_status'] != SS_UNSHIPPED || $order['goods_amount'] <= 0 || $order['pay_id'] == $pay_id)
    {
        ecs_header("Location: user.php?act=order_detail&order_id=$order_id\n");
        exit;
    }

    $order_amount = $order['order_amount'] - $order['pay_fee'];
    $pay_fee = pay_fee($pay_id, $order_amount);
    $order_amount += $pay_fee;

    $sql = "UPDATE " . $ecs->table('order_info') .
           " SET pay_id='$pay_id', pay_name='$payment_info[pay_name]', pay_fee='$pay_fee', order_amount='$order_amount'".
           " WHERE order_id = '$order_id'";
    $db->query($sql);

    /* 跳转 */
    ecs_header("Location: user.php?act=order_detail&order_id=$order_id\n");
    exit;
}

/* 保存订单详情收货地址 */
elseif ($action == 'save_order_address')
{
    include_once(ROOT_PATH .'includes/lib_transaction.php');
    
    $address = array(
        'consignee' => isset($_POST['consignee']) ? compile_str(trim($_POST['consignee']))  : '',
        'email'     => isset($_POST['email'])     ? compile_str(trim($_POST['email']))      : '',
        'address'   => isset($_POST['address'])   ? compile_str(trim($_POST['address']))    : '',
        'zipcode'   => isset($_POST['zipcode'])   ? compile_str(make_semiangle(trim($_POST['zipcode']))) : '',
        'tel'       => isset($_POST['tel'])       ? compile_str(trim($_POST['tel']))        : '',
        'mobile'    => isset($_POST['mobile'])    ? compile_str(trim($_POST['mobile']))     : '',
        'sign_building' => isset($_POST['sign_building']) ? compile_str(trim($_POST['sign_building'])) : '',
        'best_time' => isset($_POST['best_time']) ? compile_str(trim($_POST['best_time']))  : '',
        'order_id'  => isset($_POST['order_id'])  ? intval($_POST['order_id']) : 0
        );
    if (save_order_address($address, $user_id))
    {
        ecs_header('Location: user.php?act=order_detail&order_id=' .$address['order_id']. "\n");
        exit;
    }
    else
    {
        $err->show($_LANG['order_list_lnk'], 'user.php?act=order_list');
    }
}

/* 我的红包列表 */
elseif ($action == 'bonus')
{
    include_once(ROOT_PATH .'includes/lib_transaction.php');

    $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
    $record_count = $db->getOne("SELECT COUNT(*) FROM " .$ecs->table('user_bonus'). " WHERE user_id = '$user_id'");

    $pager = get_pager('user.php', array('act' => $action), $record_count, $page);
    $bonus = get_user_bouns_list($user_id, $pager['size'], $pager['start']);

    $smarty->assign('pager', $pager);
    $smarty->assign('bonus', $bonus);
    $smarty->display('user_transaction.dwt');
}

/* 我的团购列表 */
elseif ($action == 'group_buy')
{
    include_once(ROOT_PATH .'includes/lib_transaction.php');

    //待议
    $smarty->display('user_transaction.dwt');
}

/* 团购订单详情 */
elseif ($action == 'group_buy_detail')
{
    include_once(ROOT_PATH .'includes/lib_transaction.php');

    //待议
    $smarty->display('user_transaction.dwt');
}

// 用户推荐页面
elseif ($action == 'affiliate')
{
    $goodsid = intval(isset($_REQUEST['goodsid']) ? $_REQUEST['goodsid'] : 0);
    if(empty($goodsid))
    {
        //我的推荐页面

        $page       = !empty($_REQUEST['page'])  && intval($_REQUEST['page'])  > 0 ? intval($_REQUEST['page'])  : 1;
        $size       = !empty($_CFG['page_size']) && intval($_CFG['page_size']) > 0 ? intval($_CFG['page_size']) : 10;

        empty($affiliate) && $affiliate = array();

        if(empty($affiliate['config']['separate_by']))
        {
            //推荐注册分成
            $affdb = array();
            $num = count($affiliate['item']);
            $up_uid = "'$user_id'";
            $all_uid = "'$user_id'";
            for ($i = 1 ; $i <=$num ;$i++)
            {
                $count = 0;
                if ($up_uid)
                {
                    $sql = "SELECT user_id FROM " . $ecs->table('users') . " WHERE parent_id IN($up_uid)";
                    $query = $db->query($sql);
                    $up_uid = '';
                    while ($rt = $db->fetch_array($query))
                    {
                        $up_uid .= $up_uid ? ",'$rt[user_id]'" : "'$rt[user_id]'";
                        if($i < $num)
                        {
                            $all_uid .= ", '$rt[user_id]'";
                        }
                        $count++;
                    }
                }
                $affdb[$i]['num'] = $count;
                $affdb[$i]['point'] = $affiliate['item'][$i-1]['level_point'];
                $affdb[$i]['money'] = $affiliate['item'][$i-1]['level_money'];
            }
            $smarty->assign('affdb', $affdb);

            $sqlcount = "SELECT count(*) FROM " . $ecs->table('order_info') . " o".
        " LEFT JOIN".$ecs->table('users')." u ON o.user_id = u.user_id".
        " LEFT JOIN " . $ecs->table('affiliate_log') . " a ON o.order_id = a.order_id" .
        " WHERE o.user_id > 0 AND (u.parent_id IN ($all_uid) AND o.is_separate = 0 OR a.user_id = '$user_id' AND o.is_separate > 0)";

            $sql = "SELECT o.*, a.log_id, a.user_id as suid,  a.user_name as auser, a.money, a.point, a.separate_type FROM " . $ecs->table('order_info') . " o".
                    " LEFT JOIN".$ecs->table('users')." u ON o.user_id = u.user_id".
                    " LEFT JOIN " . $ecs->table('affiliate_log') . " a ON o.order_id = a.order_id" .
        " WHERE o.user_id > 0 AND (u.parent_id IN ($all_uid) AND o.is_separate = 0 OR a.user_id = '$user_id' AND o.is_separate > 0)".
                    " ORDER BY order_id DESC" ;

            /*
                SQL解释：

                订单、用户、分成记录关联
                一个订单可能有多个分成记录

                1、订单有效 o.user_id > 0
                2、满足以下之一：
                    a.直接下线的未分成订单 u.parent_id IN ($all_uid) AND o.is_separate = 0
                        其中$all_uid为该ID及其下线(不包含最后一层下线)
                    b.全部已分成订单 a.user_id = '$user_id' AND o.is_separate > 0

            */

            $affiliate_intro = nl2br(sprintf($_LANG['affiliate_intro'][$affiliate['config']['separate_by']], $affiliate['config']['expire'], $_LANG['expire_unit'][$affiliate['config']['expire_unit']], $affiliate['config']['level_register_all'], $affiliate['config']['level_register_up'], $affiliate['config']['level_money_all'], $affiliate['config']['level_point_all']));
        }
        else
        {
            //推荐订单分成
            $sqlcount = "SELECT count(*) FROM " . $ecs->table('order_info') . " o".
                    " LEFT JOIN".$ecs->table('users')." u ON o.user_id = u.user_id".
                    " LEFT JOIN " . $ecs->table('affiliate_log') . " a ON o.order_id = a.order_id" .
                    " WHERE o.user_id > 0 AND (o.parent_id = '$user_id' AND o.is_separate = 0 OR a.user_id = '$user_id' AND o.is_separate > 0)";


            $sql = "SELECT o.*, a.log_id,a.user_id as suid, a.user_name as auser, a.money, a.point, a.separate_type,u.parent_id as up FROM " . $ecs->table('order_info') . " o".
                    " LEFT JOIN".$ecs->table('users')." u ON o.user_id = u.user_id".
                    " LEFT JOIN " . $ecs->table('affiliate_log') . " a ON o.order_id = a.order_id" .
                    " WHERE o.user_id > 0 AND (o.parent_id = '$user_id' AND o.is_separate = 0 OR a.user_id = '$user_id' AND o.is_separate > 0)" .
                    " ORDER BY order_id DESC" ;

            /*
                SQL解释：

                订单、用户、分成记录关联
                一个订单可能有多个分成记录

                1、订单有效 o.user_id > 0
                2、满足以下之一：
                    a.订单下线的未分成订单 o.parent_id = '$user_id' AND o.is_separate = 0
                    b.全部已分成订单 a.user_id = '$user_id' AND o.is_separate > 0

            */

            $affiliate_intro = nl2br(sprintf($_LANG['affiliate_intro'][$affiliate['config']['separate_by']], $affiliate['config']['expire'], $_LANG['expire_unit'][$affiliate['config']['expire_unit']], $affiliate['config']['level_money_all'], $affiliate['config']['level_point_all']));

        }

        $count = $db->getOne($sqlcount);

        $max_page = ($count> 0) ? ceil($count / $size) : 1;
        if ($page > $max_page)
        {
            $page = $max_page;
        }

        $res = $db->SelectLimit($sql, $size, ($page - 1) * $size);
        $logdb = array();
        while ($rt = $GLOBALS['db']->fetchRow($res))
        {
            if(!empty($rt['suid']))
            {
                //在affiliate_log有记录
                if($rt['separate_type'] == -1 || $rt['separate_type'] == -2)
                {
                    //已被撤销
                    $rt['is_separate'] = 3;
                }
            }
            $rt['order_sn'] = substr($rt['order_sn'], 0, strlen($rt['order_sn']) - 5) . "***" . substr($rt['order_sn'], -2, 2);
            $logdb[] = $rt;
        }

        $url_format = "user.php?act=affiliate&page=";

        $pager = array(
                    'page'  => $page,
                    'size'  => $size,
                    'sort'  => '',
                    'order' => '',
                    'record_count' => $count,
                    'page_count'   => $max_page,
                    'page_first'   => $url_format. '1',
                    'page_prev'    => $page > 1 ? $url_format.($page - 1) : "javascript:;",
                    'page_next'    => $page < $max_page ? $url_format.($page + 1) : "javascript:;",
                    'page_last'    => $url_format. $max_page,
                    'array'        => array()
                );
        for ($i = 1; $i <= $max_page; $i++)
        {
            $pager['array'][$i] = $i;
        }

        $smarty->assign('url_format', $url_format);
        $smarty->assign('pager', $pager);


        $smarty->assign('affiliate_intro', $affiliate_intro);
        $smarty->assign('affiliate_type', $affiliate['config']['separate_by']);

        $smarty->assign('logdb', $logdb);
    }
    else
    {
        //单个商品推荐
        $smarty->assign('userid', $user_id);
        $smarty->assign('goodsid', $goodsid);

        $types = array(1,2,3,4,5);
        $smarty->assign('types', $types);

        $goods = get_goods_info($goodsid);
        $shopurl = $ecs->url();
        $goods['goods_img'] = (strpos($goods['goods_img'], 'http://') === false && strpos($goods['goods_img'], 'https://') === false) ? $shopurl . $goods['goods_img'] : $goods['goods_img'];
        $goods['goods_thumb'] = (strpos($goods['goods_thumb'], 'http://') === false && strpos($goods['goods_thumb'], 'https://') === false) ? $shopurl . $goods['goods_thumb'] : $goods['goods_thumb'];
        $goods['shop_price'] = price_format($goods['shop_price']);

        $smarty->assign('goods', $goods);
    }

    $smarty->assign('shopname', $_CFG['shop_name']);
    $smarty->assign('userid', $user_id);
    $smarty->assign('shopurl', $ecs->url());
    $smarty->assign('logosrc', 'themes/' . $_CFG['template'] . '/images/logo.gif');

    $smarty->display('user_clips.dwt');
}

//首页邮件订阅ajax操做和验证操作
elseif ($action =='email_list')
{
    $job = $_GET['job'];

    if($job == 'add' || $job == 'del')
    {
        if(isset($_SESSION['last_email_query']))
        {
            if(time() - $_SESSION['last_email_query'] <= 30)
            {
                die($_LANG['order_query_toofast']);
            }
        }
        $_SESSION['last_email_query'] = time();
    }

    $email = trim($_GET['email']);
    $email = htmlspecialchars($email);

    if (!is_email($email))
    {
        $info = sprintf($_LANG['email_invalid'], $email);
        die($info);
    }
    $ck = $db->getRow("SELECT * FROM " . $ecs->table('email_list') . " WHERE email = '$email'");
    if ($job == 'add')
    {
        if (empty($ck))
        {
            $hash = substr(md5(time()), 1, 10);
            $sql = "INSERT INTO " . $ecs->table('email_list') . " (email, stat, hash) VALUES ('$email', 0, '$hash')";
            $db->query($sql);
            $info = $_LANG['email_check'];
            $url = $ecs->url() . "user.php?act=email_list&job=add_check&hash=$hash&email=$email";
            send_mail('', $email, $_LANG['check_mail'], sprintf($_LANG['check_mail_content'], $email, $_CFG['shop_name'], $url, $url, $_CFG['shop_name'], local_date('Y-m-d')), 1);
        }
        elseif ($ck['stat'] == 1)
        {
            $info = sprintf($_LANG['email_alreadyin_list'], $email);
        }
        else
        {
            $hash = substr(md5(time()),1 , 10);
            $sql = "UPDATE " . $ecs->table('email_list') . "SET hash = '$hash' WHERE email = '$email'";
            $db->query($sql);
            $info = $_LANG['email_re_check'];
            $url = $ecs->url() . "user.php?act=email_list&job=add_check&hash=$hash&email=$email";
            send_mail('', $email, $_LANG['check_mail'], sprintf($_LANG['check_mail_content'], $email, $_CFG['shop_name'], $url, $url, $_CFG['shop_name'], local_date('Y-m-d')), 1);
        }
        die($info);
    }
    elseif ($job == 'del')
    {
        if (empty($ck))
        {
            $info = sprintf($_LANG['email_notin_list'], $email);
        }
        elseif ($ck['stat'] == 1)
        {
            $hash = substr(md5(time()),1,10);
            $sql = "UPDATE " . $ecs->table('email_list') . "SET hash = '$hash' WHERE email = '$email'";
            $db->query($sql);
            $info = $_LANG['email_check'];
            $url = $ecs->url() . "user.php?act=email_list&job=del_check&hash=$hash&email=$email";
            send_mail('', $email, $_LANG['check_mail'], sprintf($_LANG['check_mail_content'], $email, $_CFG['shop_name'], $url, $url, $_CFG['shop_name'], local_date('Y-m-d')), 1);
        }
        else
        {
            $info = $_LANG['email_not_alive'];
        }
        die($info);
    }
    elseif ($job == 'add_check')
    {
        if (empty($ck))
        {
            $info = sprintf($_LANG['email_notin_list'], $email);
        }
        elseif ($ck['stat'] == 1)
        {
            $info = $_LANG['email_checked'];
        }
        else
        {
            if ($_GET['hash'] == $ck['hash'])
            {
                $sql = "UPDATE " . $ecs->table('email_list') . "SET stat = 1 WHERE email = '$email'";
                $db->query($sql);
                $info = $_LANG['email_checked'];
            }
            else
            {
                $info = $_LANG['hash_wrong'];
            }
        }
        show_message($info, $_LANG['back_home_lnk'], 'index.php');
    }
    elseif ($job == 'del_check')
    {
        if (empty($ck))
        {
            $info = sprintf($_LANG['email_invalid'], $email);
        }
        elseif ($ck['stat'] == 1)
        {
            if ($_GET['hash'] == $ck['hash'])
            {
                $sql = "DELETE FROM " . $ecs->table('email_list') . "WHERE email = '$email'";
                $db->query($sql);
                $info = $_LANG['email_canceled'];
            }
            else
            {
                $info = $_LANG['hash_wrong'];
            }
        }
        else
        {
            $info = $_LANG['email_not_alive'];
        }
        show_message($info, $_LANG['back_home_lnk'], 'index.php');
    }
}

/* ajax 发送验证邮件 
  增加$type chen-0912
*/
elseif ($action == 'send_hash_mail')
{
    include_once(ROOT_PATH .'includes/cls_json.php');
    include_once(ROOT_PATH .'includes/lib_passport.php');
    $json = new JSON();

    $result = array('error' => 0, 'message' => '', 'content' => '');

    if ($user_id == 0)
    {
        /* 用户没有登录 */
        $result['error']   = 1;
        $result['message'] = $_LANG['login_please'];
        die($json->encode($result));
    }

	$validate=$_REQUEST['is_validate'];
	$type="register";
	if($validate==0) $type="disbind";
	else if($validate == 'emailUser_register_email') $type = 'emailUser_register_email';
	
    if (send_regiter_hash($user_id,$type))
    {
        $result['message'] = $_LANG['validate_mail_ok'];
        die($json->encode($result));
    }
    else
    {
        $result['error'] = 1;
        $result['message'] = $GLOBALS['err']->last_message();
    }

    die($json->encode($result));
}
else if ($action == 'track_packages')
{
    include_once(ROOT_PATH . 'includes/lib_transaction.php');
    include_once(ROOT_PATH .'includes/lib_order.php');

    $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;

    $orders = array();

    $sql = "SELECT order_id,order_sn,invoice_no,shipping_id FROM " .$ecs->table('order_info').
            " WHERE user_id = '$user_id' AND shipping_status = '" . SS_SHIPPED . "'";
    $res = $db->query($sql);
    $record_count = 0;
    while ($item = $db->fetch_array($res))
    {
        $shipping   = get_shipping_object($item['shipping_id']);

        if (method_exists ($shipping, 'query'))
        {
            $query_link = $shipping->query($item['invoice_no']);
        }
        else
        {
            $query_link = $item['invoice_no'];
        }

        if ($query_link != $item['invoice_no'])
        {
            $item['query_link'] = $query_link;
            $orders[]  = $item;
            $record_count += 1;
        }
    }
    $pager  = get_pager('user.php', array('act' => $action), $record_count, $page);
    $smarty->assign('pager',  $pager);
    $smarty->assign('orders', $orders);
    $smarty->display('user_transaction.dwt');
}
else if ($action == 'order_query')
{
    $_GET['order_sn'] = trim(substr($_GET['order_sn'], 1));
    $order_sn = empty($_GET['order_sn']) ? '' : addslashes($_GET['order_sn']);
    include_once(ROOT_PATH .'includes/cls_json.php');
    $json = new JSON();

    $result = array('error'=>0, 'message'=>'', 'content'=>'');

    if(isset($_SESSION['last_order_query']))
    {
        if(time() - $_SESSION['last_order_query'] <= 10)
        {
            $result['error'] = 1;
            $result['message'] = $_LANG['order_query_toofast'];
            die($json->encode($result));
        }
    }
    $_SESSION['last_order_query'] = time();

    if (empty($order_sn))
    {
        $result['error'] = 1;
        $result['message'] = $_LANG['invalid_order_sn'];
        die($json->encode($result));
    }

    $sql = "SELECT order_id, order_status, shipping_status, pay_status, ".
           " shipping_time, shipping_id, invoice_no, user_id ".
           " FROM " . $ecs->table('order_info').
           " WHERE order_sn = '$order_sn' LIMIT 1";

    $row = $db->getRow($sql);
    if (empty($row))
    {
        $result['error'] = 1;
        $result['message'] = $_LANG['invalid_order_sn'];
        die($json->encode($result));
    }

    $order_query = array();
    $order_query['order_sn'] = $order_sn;
    $order_query['order_id'] = $row['order_id'];
    $order_query['order_status'] = $_LANG['os'][$row['order_status']] . ',' . $_LANG['ps'][$row['pay_status']] . ',' . $_LANG['ss'][$row['shipping_status']];

    if ($row['invoice_no'] && $row['shipping_id'] > 0)
    {
        $sql = "SELECT shipping_code FROM " . $ecs->table('shipping') . " WHERE shipping_id = '$row[shipping_id]'";
        $shipping_code = $db->getOne($sql);
        $plugin = ROOT_PATH . 'includes/modules/shipping/' . $shipping_code . '.php';
        if (file_exists($plugin))
        {
            include_once($plugin);
            $shipping = new $shipping_code;
            $order_query['invoice_no'] = $shipping->query((string)$row['invoice_no']);
        }
        else
        {
            $order_query['invoice_no'] = (string)$row['invoice_no'];
        }
    }

    $order_query['user_id'] = $row['user_id'];
    /* 如果是匿名用户显示发货时间 */
    if ($row['user_id'] == 0 && $row['shipping_time'] > 0)
    {
        $order_query['shipping_date'] = local_date($GLOBALS['_CFG']['date_format'], $row['shipping_time']);
    }
    $smarty->assign('order_query',    $order_query);
    $result['content'] = $smarty->fetch('library/order_query.lbi');
    die($json->encode($result));
}
elseif ($action == 'transform_points')
{
    $rule = array();
    if (!empty($_CFG['points_rule']))
    {
        $rule = unserialize($_CFG['points_rule']);
    }
    $cfg = array();
    if (!empty($_CFG['integrate_config']))
    {
        $cfg = unserialize($_CFG['integrate_config']);
        $_LANG['exchange_points'][0] = empty($cfg['uc_lang']['credits'][0][0])? $_LANG['exchange_points'][0] : $cfg['uc_lang']['credits'][0][0];
        $_LANG['exchange_points'][1] = empty($cfg['uc_lang']['credits'][1][0])? $_LANG['exchange_points'][1] : $cfg['uc_lang']['credits'][1][0];
    }
    $sql = "SELECT user_id, user_name, pay_points, rank_points FROM " . $ecs->table('users')  . " WHERE user_id='$user_id'";
    $row = $db->getRow($sql);
    if ($_CFG['integrate_code'] == 'ucenter')
    {
        $exchange_type = 'ucenter';
        $to_credits_options = array();
        $out_exchange_allow = array();
        foreach ($rule as $credit)
        {
            $out_exchange_allow[$credit['appiddesc'] . '|' . $credit['creditdesc'] . '|' . $credit['creditsrc']] = $credit['ratio'];
            if (!array_key_exists($credit['appiddesc']. '|' .$credit['creditdesc'], $to_credits_options))
            {
                $to_credits_options[$credit['appiddesc']. '|' .$credit['creditdesc']] = $credit['title'];
            }
        }
        $smarty->assign('selected_org', $rule[0]['creditsrc']);
        $smarty->assign('selected_dst', $rule[0]['appiddesc']. '|' .$rule[0]['creditdesc']);
        $smarty->assign('descreditunit', $rule[0]['unit']);
        $smarty->assign('orgcredittitle', $_LANG['exchange_points'][$rule[0]['creditsrc']]);
        $smarty->assign('descredittitle', $rule[0]['title']);
        $smarty->assign('descreditamount', round((1 / $rule[0]['ratio']), 2));
        $smarty->assign('to_credits_options', $to_credits_options);
        $smarty->assign('out_exchange_allow', $out_exchange_allow);
    }
    else
    {
        $exchange_type = 'other';

        $bbs_points_name = $user->get_points_name();
        $total_bbs_points = $user->get_points($row['user_name']);

        /* 论坛积分 */
        $bbs_points = array();
        foreach ($bbs_points_name as $key=>$val)
        {
            $bbs_points[$key] = array('title'=>$_LANG['bbs'] . $val['title'], 'value'=>$total_bbs_points[$key]);
        }

        /* 兑换规则 */
        $rule_list = array();
        foreach ($rule as $key=>$val)
        {
            $rule_key = substr($key, 0, 1);
            $bbs_key = substr($key, 1);
            $rule_list[$key]['rate'] = $val;
            switch ($rule_key)
            {
                case TO_P :
                    $rule_list[$key]['from'] = $_LANG['bbs'] . $bbs_points_name[$bbs_key]['title'];
                    $rule_list[$key]['to'] = $_LANG['pay_points'];
                    break;
                case TO_R :
                    $rule_list[$key]['from'] = $_LANG['bbs'] . $bbs_points_name[$bbs_key]['title'];
                    $rule_list[$key]['to'] = $_LANG['rank_points'];
                    break;
                case FROM_P :
                    $rule_list[$key]['from'] = $_LANG['pay_points'];$_LANG['bbs'] . $bbs_points_name[$bbs_key]['title'];
                    $rule_list[$key]['to'] =$_LANG['bbs'] . $bbs_points_name[$bbs_key]['title'];
                    break;
                case FROM_R :
                    $rule_list[$key]['from'] = $_LANG['rank_points'];
                    $rule_list[$key]['to'] = $_LANG['bbs'] . $bbs_points_name[$bbs_key]['title'];
                    break;
            }
        }
        $smarty->assign('bbs_points', $bbs_points);
        $smarty->assign('rule_list',  $rule_list);
    }
    $smarty->assign('shop_points', $row);
    $smarty->assign('exchange_type',     $exchange_type);
    $smarty->assign('action',     $action);
    $smarty->assign('lang',       $_LANG);
    $smarty->display('user_transaction.dwt');
}
elseif ($action == 'act_transform_points')
{
    $rule_index = empty($_POST['rule_index']) ? '' : trim($_POST['rule_index']);
    $num = empty($_POST['num']) ? 0 : intval($_POST['num']);


    if ($num <= 0 || $num != floor($num))
    {
        show_message($_LANG['invalid_points'], $_LANG['transform_points'], 'user.php?act=transform_points');
    }

    $num = floor($num); //格式化为整数

    $bbs_key = substr($rule_index, 1);
    $rule_key = substr($rule_index, 0, 1);

    $max_num = 0;

    /* 取出用户数据 */
    $sql = "SELECT user_name, user_id, pay_points, rank_points FROM " . $ecs->table('users') . " WHERE user_id='$user_id'";
    $row = $db->getRow($sql);
    $bbs_points = $user->get_points($row['user_name']);
    $points_name = $user->get_points_name();

    $rule = array();
    if ($_CFG['points_rule'])
    {
        $rule = unserialize($_CFG['points_rule']);
    }
    list($from, $to) = explode(':', $rule[$rule_index]);

    $max_points = 0;
    switch ($rule_key)
    {
        case TO_P :
            $max_points = $bbs_points[$bbs_key];
            break;
        case TO_R :
            $max_points = $bbs_points[$bbs_key];
            break;
        case FROM_P :
            $max_points = $row['pay_points'];
            break;
        case FROM_R :
            $max_points = $row['rank_points'];
    }

    /* 检查积分是否超过最大值 */
    if ($max_points <=0 || $num > $max_points)
    {
        show_message($_LANG['overflow_points'], $_LANG['transform_points'], 'user.php?act=transform_points' );
    }

    switch ($rule_key)
    {
        case TO_P :
            $result_points = floor($num * $to / $from);
            $user->set_points($row['user_name'], array($bbs_key=>0 - $num)); //调整论坛积分
            log_account_change($row['user_id'], 0, 0, 0, $result_points, $_LANG['transform_points'], ACT_OTHER);
            show_message(sprintf($_LANG['to_pay_points'],  $num, $points_name[$bbs_key]['title'], $result_points), $_LANG['transform_points'], 'user.php?act=transform_points');

        case TO_R :
            $result_points = floor($num * $to / $from);
            $user->set_points($row['user_name'], array($bbs_key=>0 - $num)); //调整论坛积分
            log_account_change($row['user_id'], 0, 0, $result_points, 0, $_LANG['transform_points'], ACT_OTHER);
            show_message(sprintf($_LANG['to_rank_points'], $num, $points_name[$bbs_key]['title'], $result_points), $_LANG['transform_points'], 'user.php?act=transform_points');

        case FROM_P :
            $result_points = floor($num * $to / $from);
            log_account_change($row['user_id'], 0, 0, 0, 0-$num, $_LANG['transform_points'], ACT_OTHER); //调整商城积分
            $user->set_points($row['user_name'], array($bbs_key=>$result_points)); //调整论坛积分
            show_message(sprintf($_LANG['from_pay_points'], $num, $result_points,  $points_name[$bbs_key]['title']), $_LANG['transform_points'], 'user.php?act=transform_points');

        case FROM_R :
            $result_points = floor($num * $to / $from);
            log_account_change($row['user_id'], 0, 0, 0-$num, 0, $_LANG['transform_points'], ACT_OTHER); //调整商城积分
            $user->set_points($row['user_name'], array($bbs_key=>$result_points)); //调整论坛积分
            show_message(sprintf($_LANG['from_rank_points'], $num, $result_points, $points_name[$bbs_key]['title']), $_LANG['transform_points'], 'user.php?act=transform_points');
    }
}
elseif ($action == 'act_transform_ucenter_points')
{
    $rule = array();
    if ($_CFG['points_rule'])
    {
        $rule = unserialize($_CFG['points_rule']);
    }
    $shop_points = array(0 => 'rank_points', 1 => 'pay_points');
    $sql = "SELECT user_id, user_name, pay_points, rank_points FROM " . $ecs->table('users')  . " WHERE user_id='$user_id'";
    $row = $db->getRow($sql);
    $exchange_amount = intval($_POST['amount']);
    $fromcredits = intval($_POST['fromcredits']);
    $tocredits = trim($_POST['tocredits']);
    $cfg = unserialize($_CFG['integrate_config']);
    if (!empty($cfg))
    {
        $_LANG['exchange_points'][0] = empty($cfg['uc_lang']['credits'][0][0])? $_LANG['exchange_points'][0] : $cfg['uc_lang']['credits'][0][0];
        $_LANG['exchange_points'][1] = empty($cfg['uc_lang']['credits'][1][0])? $_LANG['exchange_points'][1] : $cfg['uc_lang']['credits'][1][0];
    }
    list($appiddesc, $creditdesc) = explode('|', $tocredits);
    $ratio = 0;

    if ($exchange_amount <= 0)
    {
        show_message($_LANG['invalid_points'], $_LANG['transform_points'], 'user.php?act=transform_points');
    }
    if ($exchange_amount > $row[$shop_points[$fromcredits]])
    {
        show_message($_LANG['overflow_points'], $_LANG['transform_points'], 'user.php?act=transform_points');
    }
    foreach ($rule as $credit)
    {
        if ($credit['appiddesc'] == $appiddesc && $credit['creditdesc'] == $creditdesc && $credit['creditsrc'] == $fromcredits)
        {
            $ratio = $credit['ratio'];
            break;
        }
    }
    if ($ratio == 0)
    {
        show_message($_LANG['exchange_deny'], $_LANG['transform_points'], 'user.php?act=transform_points');
    }
    $netamount = floor($exchange_amount / $ratio);
    include_once(ROOT_PATH . './includes/lib_uc.php');
    $result = exchange_points($row['user_id'], $fromcredits, $creditdesc, $appiddesc, $netamount);
    if ($result === true)
    {
        $sql = "UPDATE " . $ecs->table('users') . " SET {$shop_points[$fromcredits]}={$shop_points[$fromcredits]}-'$exchange_amount' WHERE user_id='{$row['user_id']}'";
        $db->query($sql);
        $sql = "INSERT INTO " . $ecs->table('account_log') . "(user_id, {$shop_points[$fromcredits]}, change_time, change_desc, change_type)" . " VALUES ('{$row['user_id']}', '-$exchange_amount', '". gmtime() ."', '" . $cfg['uc_lang']['exchange'] . "', '98')";
        $db->query($sql);
        show_message(sprintf($_LANG['exchange_success'], $exchange_amount, $_LANG['exchange_points'][$fromcredits], $netamount, $credit['title']), $_LANG['transform_points'], 'user.php?act=transform_points');
    }
    else
    {
        show_message($_LANG['exchange_error_1'], $_LANG['transform_points'], 'user.php?act=transform_points');
    }
}
/*chen-0917 修改上传代码*/
elseif ($action == 'up_load')
{
	
$order_id=$_REQUEST['order_id'];

   $fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);
 
   $ext=file_extend($fn);
 
  $dir = get_websit_dir();

if($order_id == 'personal_pic') //存放个人图片
{
$user_id=$_SESSION['user_id'];
 createdir($dir."uploads/user_pic");

 if($fn)
 {
$sql = "update ".$GLOBALS['ecs']->table('users')." set personal_pic = 'uploads/user_pic/$user_id.".$ext."' where user_id = $user_id";
 $flag=$GLOBALS['db']->query($sql);
 if($flag) echo "图片路径插入数据库成功"; else echo "图片路径插入数据库失败";
 file_put_contents(
	   $dir."uploads/user_pic/$user_id.".$ext,
        file_get_contents('php://input')
    );
	}
}
else
{
$rand_num=$_REQUEST['rand_num'];

$path=$order_id;   //  建文件夹,存放退货凭证

createdir($dir."uploads/return_goods"); 
createdir($dir."uploads/return_goods/".$path); 
  if ($fn) 
  {	  
	   $fn = md5($fn.gmtime()).'.'.$ext;
    file_put_contents(
	   $dir."uploads/return_goods/$path/".$rand_num.'_'.$fn,
        file_get_contents('php://input')
    );
   
	 $str = "/uploads/return_goods/$path/".$rand_num.'_'.$fn;
	$sql = "insert into ".$GLOBALS['ecs']->table('back_order_pic')."(order_id,pic_url) values('$order_id','$str')";
   $GLOBALS['db']->query($sql);
	echo  $dir.$str;
  }
}
     exit();
}
/* 接受用户的退/换货申请  */
elseif ($action == 'sub_return_goods')
{

	$user_id= !empty($_SESSION['user_id'])? $_SESSION['user_id']:0;
	$order_id= !empty($_REQUEST['wanted_return_order'])? $_REQUEST['wanted_return_order']:0;   
	$back_reason=!empty($_REQUEST['back_reason'])? $_REQUEST['back_reason']:0; 
	$back_type=!empty($_REQUEST['back_type'])? $_REQUEST['back_type']:0;  
	$rand_num=!empty($_REQUEST['current_time'])? $_REQUEST['current_time']:0;     
	$pro_descrip=!empty( $_REQUEST['pro_descrip'])? $_REQUEST['pro_descrip']:'';  
	$return_money=!empty($_REQUEST['return_money'])? $_REQUEST['return_money']:0;   
	$return_principle= !empty($_REQUEST['return_principle'])? $_REQUEST['return_principle']:null;  
	

	$redrectUrl="user.php?act=return_goods";$smalltext='提交申请失败！';$tempStr='user_passport.dwt';
	if($order_id==0)
	{
	$conent='请先选择好要申请退款的订单号！';$actionStr= 'pageRedirect';
	 page_jump($smarty,$redrectUrl,$smalltext,$conent,$actionStr,$tempStr);
	}
	else if($back_reason == 0)
	{
	$conent='您没有选择退货理由，请选择一个退货理由！';$actionStr= 'pageRedirect';
	 page_jump($smarty,$redrectUrl,$smalltext,$conent,$actionStr,$tempStr);
	}
	else if($back_type == 0)
	{
	$conent='您没有选择退货类型，请到申请类型处选择！';$actionStr= 'pageRedirect';
	 page_jump($smarty,$redrectUrl,$smalltext,$conent,$actionStr,$tempStr);
	}
	else if($return_principle == null)
	{
	$conent='您没有阅读退换货原则，请阅读后同意此原则！';$actionStr= 'pageRedirect';
	 page_jump($smarty,$redrectUrl,$smalltext,$conent,$actionStr,$tempStr);
	}
	else 
	{
	$now=gmtime();
	$order = order_info($order_id);
	$sql = "select delivery_sn,update_time from ".$GLOBALS['ecs']->table('delivery_order')."where order_id=$order_id";
	$delivery_order=$GLOBALS['db']->getRow($sql);
	foreach($order as $key=>$val)
	{
	  $order["$key"]= (!$order["$key"])? 'XXXX':$order["$key"];
	}
   $sql = "INSERT INTO " . $ecs->table('back_order') . "(tel, mobile, email,country,  province, city, district, delivery_sn,return_time,order_id,order_sn,return_money,add_time,consignee,update_time,back_reason,back_type,pro_descrip,user_id)" ." VALUES ('".$order['tel']."','".$order['mobile']."','".$order['email']."','".$order['country']."','".$order['province']."','".$order['city']."','".$order['district']."','".$delivery_order['delivery_sn']."',$now, $order_id,".$order['order_sn'].",$return_money,".$order['add_time'].",'".$order['consignee']."','".$delivery_order['update_time']."', '$back_reason', '$back_type', '".$pro_descrip."','$user_id')";
	  $db->query($sql);
	// save_back_order_pic($order_id,$rand_num);//将退货凭证的图片地址保存到数据库

	$smalltext='成功提交申请！';$conent='您的退/换货申请已经成功提交。管理员会马上进行处理。';$actionStr= 'pageRedirect';
	 page_jump($smarty,$redrectUrl,$smalltext,$conent,$actionStr,$tempStr);				
	}
}

/* 个人中心，我的等级 chen 0905 */
else if($action == 'my_rank')
{
include_once(ROOT_PATH . 'includes/lib_clips.php');


$smarty->display('user_clips.dwt');
}
//安全设置 chen-0911
else if($action == 'security_settings')
{
include_once(ROOT_PATH . 'includes/lib_clips.php');
 
    $sql = "select personal_pic from ".$GLOBALS['ecs']->table('users')." where user_id=$user_id";
	$personal_pic = $GLOBALS['db']->getOne($sql);

     $sql = "select chat_validated,email,mobile_phone from ".$GLOBALS['ecs']->table('users')." where user_id = $user_id";
   
   $smarty->assign('personal_pic',$personal_pic);
   $info_validate = $GLOBALS['db']->getRow($sql);
//var_dump($info_validate);
$smarty->assign('info_validate',$info_validate);
$smarty->display('user_clips.dwt');
}
//安全设置,修改密码 chen-0911
else if($action == 'security_edit_psd')
{
 
  $type = !empty($_REQUEST['type'])? $_REQUEST['type']:"pwd";
  $chat_validated  = !empty($_REQUEST['validate'])? $_REQUEST['validate']:"0";
  switch($type)
  {
    case "pwd":
        $edit = !empty($_REQUEST['edit'])? $_REQUEST['edit']:0;     //1：修改密码，0：修改密码展示界面
		if($edit==1)
		{
			$old_pwd = $_REQUEST['old_pwd'];
			$new_pwd = $_REQUEST['new_pwd'];
			$sql = "select password,ec_salt from ".$GLOBALS['ecs']->table('users')." where user_id=$user_id";
			$row = $db->getRow($sql);
			
			$old_pwd=md5($old_pwd); 
			if($row['ec_salt'])
			{
			$old_pwd=md5($old_pwd.$row['ec_salt']);
			}
			if($old_pwd != $row['password'])
			{
				$smarty->assign('redrectUrl',"user.php?act=security_edit_psd");
				$smarty->assign('smalltext','密码修改不成功');
				$smarty->assign('content','旧密码错误！如果忘了，可到<b>登陆页申请找回密码</b>。如果未返回请');       
				$smarty->assign('action', 'pageRedirect');
				$smarty->display('user_passport.dwt');
			}
			else
			{
			$new_pwd = md5($new_pwd); 
			if($row['ec_salt'])
			{
			$new_pwd=md5($new_pwd.$row['ec_salt']);
			}
			   $sql = "update ".$GLOBALS['ecs']->table('users')." set password='$new_pwd' where user_id=$user_id";
			   $flag=$db->query($sql);
			  
			  if(!$flag)
			   {
				 $smarty->assign('redrectUrl',"user.php?act=security_edit_psd");
				$smarty->assign('smalltext','密码修改不成功');
				$smarty->assign('content','数据库修改密码时出现错误。页面将返回修改密码页，如果未返回请');       
				$smarty->assign('action', 'pageRedirect');
				$smarty->display('user_passport.dwt');
			   }
			   else
			   {
				 $user->logout();
				$smarty->assign('redrectUrl',"user.php");
				$smarty->assign('smalltext','密码修改成功');
				$smarty->assign('content','修改成功。请用新密码登陆，页面将返回登陆页。如果未返回请');       
				$smarty->assign('action', 'pageRedirect');
				$smarty->display('user_passport.dwt');
			   }
			}
		}
		else
		{
			include_once(ROOT_PATH . 'includes/lib_clips.php');
			
			$smarty->assign('type','edit_pwd');
		}
	    break;
    case "email":
	    $email = !empty($_REQUEST['email'])? $_REQUEST['email']:"";
		if($chat_validated==0 || $chat_validated==2)  // 邮箱未验证，需要验证
		{
		   include_once(ROOT_PATH . 'includes/lib_clips.php');
			
			$smarty->assign('email',$email);
			$smarty->assign('type','validate_email');
		}
		if($chat_validated==1 || $chat_validated==3)  // 邮箱已验证，修改验证邮箱
		{
		    include_once(ROOT_PATH . 'includes/lib_clips.php');
			
			$smarty->assign('email',$email);
			$smarty->assign('type','edit_email');
		}
	break;
	case "phone":   
     	$phone = !empty($_REQUEST['phone'])? $_REQUEST['phone']:"";
		if($chat_validated==0 || $chat_validated==1)  // 手机未验证，需要验证
		{
		    include_once(ROOT_PATH . 'includes/lib_clips.php');
			
			
			$smarty->assign('phone',$phone);
			$smarty->assign('type','validate_phone');
		}
		if($chat_validated==2 || $chat_validated==3)  // 手机已验证，修改验证手机
		{
		    include_once(ROOT_PATH . 'includes/lib_clips.php');
			
			
			$smarty->assign('phone',$phone);
			$smarty->assign('type','edit_phone');
		}
	break;
  }
 $smarty->assign('user_id',$user_id); 
 $smarty->display('user_clips.dwt');
}
//我的积分 chen-0909
else if($action == 'my_integral')
{
include_once(ROOT_PATH . 'includes/lib_clips.php');
include_once(ROOT_PATH . 'includes/lib_integral.php');
$user_id=$_SESSION['user_id'];
user_infomation($smarty,$user_id);  

  //$integral_records = get_all_integral_records($user_id);
 
//$smarty->assign('integral_records',$integral_records);
    $ctl  = isset($_REQUEST['ctl']) ? $_REQUEST['ctl'] : '0';
	 $smarty->assign('ctl',$ctl);
	 
	 $integralCondition = array();
	 $integralCondition [] = array($user_id,' 1 ',' is_frozen=0 ');
	 $integralCondition [] = array($user_id,'type = 0',' is_frozen=0 ');
	 $integralCondition [] = array($user_id,'type = 1',' is_frozen=0 ');
	 $integralCondition [] = array($user_id,'type = 5', ' is_frozen=0 ');
     $integralCondition [] = array($user_id, ' 1 ', ' is_frozen=1 ');
	 
	 $integral_records_list = array();
       $all_pages = array();
	 for($i = 0; $i < 5; $i++)
	 {
	  $page = isset($_REQUEST["page$i"]) ? intval($_REQUEST["page$i"]) : 0;
	  
	  $record_count = get_integral_records_count($integralCondition[$i][0],$integralCondition[$i][1],$integralCondition[$i][2]);
	 $all_pages[$i] = get_pager('user.php', array('act' => $action), $record_count, $page, 10,"page$i=","&ctl=$i",'#tab');
	 
	 $integral_records_list[$i] = get_integral_records($integralCondition[$i][0],$integralCondition[$i][1],$integralCondition[$i][2],$all_pages[$i]['size'], $all_pages[$i]['start']);
	  
	 }

  	
$smarty->assign('integral_records_list',$integral_records_list);
$smarty->assign('all_pages',$all_pages);

$smarty->assign('frozen_integral',get_frozen_integral($user_id));
$smarty->display('user_clips.dwt');
}

/* 接受用户的投诉/建议 chen 0902 */
elseif ($action == 'user_complain')
{
$order_id=$_REQUEST['order_id'];
$type=$_REQUEST['type'];
$content=$_REQUEST['content'];
$captcha=$_REQUEST['captcha'];
$now = gmtime();

include_once('includes/cls_captcha.php');
$validator = new captcha($_SESSION['captcha_word']);
   if (!$validator->check_word(($_POST['captcha'])))
    {
        show_message($_LANG['invalid_captcha']);
    }
	$sql = "insert into ". $GLOBALS['ecs']->table('complain')."(user_id,content,time,order_id,type) values($user_id,'$content',$now,$order_id,$type)";
    $flag=$GLOBALS['db']->query($sql);
	if($flag)
	{
	   show_message('已成功提交!可在个人中心页-->客户服务-->我的投诉/建议处查看');
	}
	else{
	   show_message('提交失败');
	}
}
/* 清除商品浏览历史 */
elseif ($action == 'clear_history')
{
    setcookie('ECS[history]',   '', 1);
}
/* 删除投诉ajax调用 */
elseif ($action == 'delete_complain')
{
  $id = $_REQUEST['id'];
 $sql = "update ". $GLOBALS['ecs']->table('complain')." set is_del = 1 where id=$id";
 $flag=$GLOBALS['db']->query($sql);
 
 $arr=array();
 $arr[0]=$id;
if($flag) $arr[1]= 1;
else $arr[1] =0;
 echo json_encode($arr);
}
/* 删除收藏物品ajax调用 chen 0827*/
else if($action == 'del_collected')
{
  $rec_id_list=$_REQUEST['rec_id_list'];
  $type=$_REQUEST['type'];
   $sql = 'delete from '. $GLOBALS['ecs']->table('collect_goods').' where rec_id '. db_create_in($rec_id_list); 
  
  $flag=$GLOBALS['db']->query($sql);
   
  if($flag)
  {
	  $arr=array();
	  $arr['type']=$type;
	 $arr['id_list']=$rec_id_list;

	 echo json_encode($arr);
  }
   else 
  {
     echo "failed";
  }
}
/* 取消退货申请ajax调用 */
elseif ($action == 'cancle_back_order')
{
  $id = $_REQUEST['id'];
 $sql = "update ". $GLOBALS['ecs']->table('back_order')." set is_cancled = 1 where back_id=$id";
 $flag=$GLOBALS['db']->query($sql);
 
 $arr=array();
 $arr[0]=$id;
if($flag) $arr[1]= 1;
else $arr[1] =0;
 echo json_encode($arr);
}
/* 猜你喜欢ajax调用 */
elseif ($action == 'you_may_love')
{
$arr=you_may_favorite();
 echo json_encode($arr);
}
/* 删除订单ajax调用,将订单标记为已删除 chen 0904*/
else if($action == 'delete_order')
{
   $order_id=$_REQUEST['order_id'];
   $sql="update ".$GLOBALS['ecs']->table('order_info')." set is_delete = 1 where order_id=$order_id";
  
   $flag=$GLOBALS['db']->query($sql);
   if($flag)
   {
     echo $order_id;
   }
   else echo "failed";
}
/**
 * 个人中心主页猜你喜欢
 *
 * @access  public
 * @return  string
 */
 function you_may_favorite()
 {
 $where = db_create_in($_COOKIE['ECS']['history'], 'goods_id');
 $sql   = 'SELECT cat_id FROM ' . $GLOBALS['ecs']->table('goods') ." WHERE $where ";
 $query = $GLOBALS['db']->query($sql);
   $arr=array();
   $i=0; //计数
   while ($row = $GLOBALS['db']->fetch_array($query))
   {
		$arr[$i]=$row['cat_id'];
		$i++;
    }
	$i=rand(0,$i-1);
	$cat_id=$arr[$i];
	
	$sql = 'SELECT goods_name,goods_id,shop_price,goods_thumb FROM ' . $GLOBALS['ecs']->table('goods') ." WHERE cat_id=$cat_id order by rand() limit 4";
	if(count($arr)==0)
      $sql= 'SELECT goods_name,goods_id,shop_price,goods_thumb FROM ' . $GLOBALS['ecs']->table('goods') ." order by rand() limit 4";
	  
	$i=0;$arr=array();
	 $query = $GLOBALS['db']->query($sql);
	  while ($row = $GLOBALS['db']->fetch_array($query))
   {
		$arr[$i]=$row;
		$i++;
    }
	return $arr;
 }
/**
 * 个人中心主页调用浏览历史
 *
 * @access  public
 * @return  string
 */
function insert_history_userCenter()
{
    $str = '';
    if (!empty($_COOKIE['ECS']['history']))
    {
        $where = db_create_in($_COOKIE['ECS']['history'], 'goods_id');
        $sql   = 'SELECT goods_id, goods_name, goods_thumb, shop_price, market_price FROM ' . $GLOBALS['ecs']->table('goods') .
                " WHERE $where AND is_on_sale = 1 AND is_alone_sale = 1 AND is_delete = 0";
        $query = $GLOBALS['db']->query($sql);
        $res = array();
		 $i=0; // 循环计数器
        while ($row = $GLOBALS['db']->fetch_array($query))
        {
            $goods['goods_id'] = $row['goods_id'];
            $goods['goods_name'] = $row['goods_name'];
            $goods['short_name'] = $GLOBALS['_CFG']['goods_name_length'] > 0 ? sub_str($row['goods_name'], $GLOBALS['_CFG']['goods_name_length']) : $row['goods_name'];
            $goods['goods_thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
            $goods['shop_price'] = price_format($row['shop_price']);
			$goods['market_price'] = price_format($row['market_price']);
            $goods['url'] = build_uri('goods', array('gid'=>$row['goods_id']), $row['goods_name']);
			
			if($i%3 == 0)
			{
			 $str.= '<li class="item_2">';
			}
			$str.='<dl>
			<dt><a href="'.$goods['url'].'"><img src="'.$goods['goods_thumb'].'" /></a></dt>
				<dd class="name"><a href="'.$goods['url'].'">'.$goods['goods_name'].'</a></dd>
				<dd class="price"><span>¥'.$goods['shop_price'].'</span><b>¥'.$goods['market_price'].'</b></dd>
			</dl>';
		  if($i%3 == 2)
		  {
			  $str.= '</li>';
		  }
         $i++;
	   }
       
    }
    return $str;
}
/**
 * 创建文件夹
 *
 * @access  public
 * para: 
 *       path-文件夹路径
 *       chomd-权限   
 */
function createFolder( $path ,$chmod = 777 ){
    if (!file_exists($path)){
        createFolder(dirname( $path ));
        @mkdir($path);
        @chmod($path,$chmod);
   
	}

}
function createdir($path)
{
 if (!file_exists($path)){
        mkdir($path);
	}
}
/**
 * 保存凭证图片地址到数据库
 *
 * @access  public
 * para: 
 *       order_id-凭证对应的订单号，对应一个文件夹
 *       rand_num-标识:用户最新一次申请退货   
 */
function save_back_order_pic($order_id,$rand_num) 
{
    $handler = opendir("uploads/$order_id");
	 $pic_list=array();    //将本次提交的凭证图片，存到数组。
	while( ($filename = readdir($handler)) !== false ) 
	{
		 // 3、目录下都会有两个文件，名字为’.'和‘..’，不要对他们进行操作
		  if($filename != "." && $filename != "..")
		  {
			  if(substr($filename,0,10)==$rand_num)
			  {
			  $pic_list[]= "uploads/$order_id/".$filename;
			  }
		  }
	}
	closedir($handler);
	foreach($pic_list as $key=>$value)
	{
	   $sql   = 'insert into ' . $GLOBALS['ecs']->table('back_order_pic') .
                '(order_id,pic_url) values("'.$order_id.'","'.$value.'")';
				//echo $sql;
        $query = $GLOBALS['db']->query($sql);
    }
       
}
function page_jump($smarty,$redrectUrl,$smalltext,$conent,$actionStr,$tempStr)
{
            $smarty->assign('redrectUrl',$redrectUrl);
            $smarty->assign('smalltext',$smalltext);
            $smarty->assign('content',$conent);       
           $smarty->assign('action',$actionStr);
            $smarty->display($tempStr); 
}
function file_extend($file_name)
{
$extend =explode("." , $file_name);
$va=count($extend)-1;
return $extend[$va];
}
/*个人中心页，显示用户等级，头像 chen-0917*/
function user_infomation($smarty,$user_id='')
{
	//var_dump($_SESSION);
 include_once(ROOT_PATH .'includes/lib_clips.php');
    $rank = get_rank_info();
	$vip_name = $rank['rank_name'];
	
	$sql = "select personal_pic from ".$GLOBALS['ecs']->table('users')." where user_id=$user_id";
	$personal_pic = $GLOBALS['db']->getOne($sql);
	
	$smarty->assign('personal_pic',$personal_pic);
	$smarty->assign('info',        get_user_default($user_id)); 	//用户信息

	$progress_bar='';
	$vip_pic = '';
	switch($vip_name)
	{
	  case 'VIP0':$progress_bar='a';$vip_pic ='vip_s0.png';break;
	  case 'VIP1':$progress_bar='b';$vip_pic ='vip_s1.png';break;
	  case 'VIP2':$progress_bar='c';$vip_pic ='vip_s2.png';break;
	  case 'VIP3':$progress_bar='d';$vip_pic ='vip_s3.png';break;
	  case 'VIP4':$progress_bar='e';$vip_pic ='vip_s4.png';break;
	  default:$progress_bar='e';$vip_pic ='vip_s0.png';break;
	}
	//$vip_name = str_replace('VIP','VIP.',$vip_name);
	$smarty->assign('vip_pic',$vip_pic);
		$smarty->assign('vip_name',$vip_name);   // 用户名
	$smarty->assign('progress_bar',$progress_bar);   // 用户名
}
//取出用户的手机号，邮箱地址。已经它们的验证信息  chen-0917
function assign_validate_info($smarty,$user_id='')
{
	$sql = "select chat_validated,email,mobile_phone from ".$GLOBALS['ecs']->table('users')." where user_id = $user_id";
    $info_validate = $GLOBALS['db']->getRow($sql);
    $smarty->assign('info_validate',$info_validate);
}
function get_websit_dir()
{
     $dir='';
   switch($_SERVER['HTTP_HOST'])
   {
      case 'www.benhu.com':$dir='d:/www.benhu.org/';break;
	  case 'localhost':$dir='';break;
	  default: $dir='';break;
   }
   return $dir;
}
?>
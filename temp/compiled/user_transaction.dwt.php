<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>

<link rel="shortcut icon" href="favicon.ico" />
<link href="style/css/style.css" rel="stylesheet" type="text/css" />
<link href="style/home/css/home.css" rel="stylesheet" type="text/css" />
<link href="style/home/css/other.css" rel="stylesheet" type="text/css" />
<link href="style/home/css/order_detail.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/left_nav_2.js"></script>
<script type="text/javascript" src="style/home/js/curvycorners.src.js"></script>
<script type="text/javascript" src="style/home/js/lrtk.js"></script>
<script type="text/javascript" src="style/js/ele_autoCenter.js"></script>

<?php echo $this->smarty_insert_scripts(array('files'=>'common.js,user.js,region.js')); ?>
<script type="text/javascript">
//上传个人图片 chen-0917
var xhr;
function upload_pic(file,upload_url)
{
if (window.XMLHttpRequest)
  {// code for all new browsers
   xhr = new XMLHttpRequest();
  }
else if (window.ActiveXObject)
  {// code for IE5 and IE6
   xhr=new ActiveXObject("Microsoft.XMLHTTP");
  }
 
    xhr.open("POST", upload_url, true);
　　xhr.setRequestHeader('X_FILENAME', file.name);
    xhr.onreadystatechange = validate
　　xhr.send(file);
}
//提交个人信息前的js验证
function before_validate()
{
	if(new_userEdit())
	{
		var upload_url='user.php?act=up_load&order_id=personal_pic';
		 if("undefined" != typeof personal_profile)  upload_pic(personal_profile,upload_url);
		else document.getElementById('theForm').submit();
	 }
}


function validate(){
  if(xhr.readyState==4)
   {
      if(xhr.status==200)
      {
      document.getElementById('theForm').submit();
     }
  }
}
function saveadd(){
    document.getElementById('theForm').submit();
}

function xiugai(id){
    
   Ajax.call( 'user.php', 'act=xiugai&id=' + id, xiu_callback , 'GET', 'json', true, true );
}

function xiu_callback(result){
    $("#selProvinces_1").val(result[0]['province']);
   $("#selProvinces_1").attr("onchange","region.changed(this, 2, 'selCities_1',"+result[0]['city']+")");
    $("#selCities_1").attr("onchange","region.changed(this,3, 'selDistricts_1',"+result[0]['district']+")");
   $('#selProvinces_1').trigger("onchange");
   

    $("#address").val(result[0]['address']);
    $("#zipcode").val(result[0]['zipcode']);
    $("#consignee").val(result[0]['consignee']);
    $("#tel").val(result[0]['tel']);
    $("#address_id").val(result[0]['address_id']);
    if(result[0]['is_first']==1){
        $("#is_first").prop('checked',true);
    }else{
        $("#is_first").prop('checked',false);
    }
}
function clearAll(){
    $("#is_first").prop('checked',false);
    $("#selProvinces_1").val(0);
    $("#selCities_1").val(0);
    $("#selDistricts_1").val(0);
    $("#address").val('');
    $("#zipcode").val('');
    $("#consignee").val('');
    $("#tel").val('');
    $("#gai").val('');
    $("#address_id").val('');
}

//如果用户填写了所在地，则页面将自动读取所在地信息 chen-0912
$(document).ready(function(){
 var pro  = "<?php echo $this->_var['addr']['province']; ?>";
 var city = "<?php echo $this->_var['addr']['city']; ?>";
 var area = "<?php echo $this->_var['addr']['area']; ?>";
 pro = pro ? pro : 0;
 city = city ? city : 0;
 area = area ? area : 0;
  var flag='1';
  if(flag)
  { 
   $("#selProvinces_1").val(pro);
   $("#selProvinces_1").attr("onchange","region.changed(this, 2, 'selCities_1',"+city+")");
   $("#selCities_1").attr("onchange","region.changed(this,3, 'selDistricts_1',"+area+")");
   $('#selProvinces_1').trigger("onchange");
  }

});

//chen-0917
$(document).ready(function(){
var person_img = document.getElementById("person_img"); 
var profile = document.getElementById("profile"); 
 
if(typeof FileReader==='undefined'){ 
    person_img.innerHTML = "抱歉，你的浏览器不支持 FileReader"; 
    profile.setAttribute('disabled','disabled'); 
}else{ 
    profile.addEventListener('change',readFile,false); 
} 
function readFile(){ 
      personal_profile = this.files[0]; 
    if(!/image\/\w+/.test(personal_profile.type)){ 
        alert("文件必须为图片！"); 
        return false; 
    } 
    if (personal_profile.size > 3*1024*1024 || personal_profile.size < 10*1024) {
					alert('您这张"'+ personal_profile.name +'"图片大小不符合要求');	
					return false;
				}
    var reader = new FileReader(); 
    reader.readAsDataURL(personal_profile); 
    reader.onload = function(e){ 
        person_img.innerHTML = '<img src="'+this.result+'" alt=""/>' 
    } 
}
 
});
</script>
<script>
				  function check_format(comeFlag)
				  {
				   var checkArr = new Array();
				   var errInfoArr = new Array();
				   
				   checkArr['provinces'] = $('#selProvinces_1').val() == 0 ? '': $('#selProvinces_1').val();
				   checkArr['cities'] = $('#selCities_1').val() == 0 ? '': $('#selCities_1').val();
				   checkArr['districts'] = $('#selDistricts_1').val() == 0 ? '': $('#selDistricts_1').val();
				   checkArr['address'] = $('#address').val();   
				   checkArr['consignee'] = $('#consignee').val();
				   checkArr['phone'] = $('#tel').val();
				   
				   
				   errInfoArr['provinces'] = '您没有选择所在地区';
				   errInfoArr['cities'] = '您没有选择所在地区';
				   errInfoArr['districts'] = '您没有选择所在地区';
				   errInfoArr['address'] = '详细地址不能为空';
				   errInfoArr['consignee'] = '收货人姓名不能为空';
				   errInfoArr['phone'] = '手机号码不能为空';
				   //errInfoArr['order_sn'] = '订单编号不能为空';
				   
				  var keyFlag = checkArrEpt(checkArr,errInfoArr);
				   if(keyFlag != 1) 
				   {
				   alert(errInfoArr[keyFlag]);
				   return ;
				   }
				   else
				   {
				      keyFlag = checkArrFormat(checkArr);
					   if(keyFlag != 1) 
					   {
					     alert(keyFlag);
					     return ;
					   }
				   }
				     if(comeFlag =='address_list' || comeFlag == 'checkout')
					 {
					 saveadd();
					
					 return ;
					 }
					//*
					checkArr['order_sn'] = '<?php echo $this->_var['order']['order_sn']; ?>';
					 checkArr['zip_code'] = $('#zipcode').val() == 0 ? '': $('#zipcode').val();
					 checkArr['callbackElemId'] = 'orderInfoAddr';
					 checkArr['hideElemIdList'] = 'theForm';
					 var act = $('#act').val();
					 
					 var url = 'user.php';
					 formAjaxSubmit(url,act,checkArr);
					 //*/
					// elem_hide('theForm');
				  }
				</script>
</head>
<body>
<?php echo $this->fetch('library/page_header.lbi'); ?>
<?php echo $this->fetch('library/category_tree.lbi'); ?>

<div class="home">

	<?php echo $this->fetch('library/user_left.lbi'); ?>
  
    
   
  
      <?php if ($this->_var['action'] == 'profile'): ?>
        <?php echo $this->smarty_insert_scripts(array('files'=>'WdatePicker.js')); ?>
       
        <div class="orders">
       	  <div class="other_title">
            	<h3>个人资料</h3>
          </div>
          <form name="formEdit" action="user.php" method="post"  id="theForm">
          <div class="datum">
          	<dl class="datum_l">
            	<dt id="person_img"><img <?php if ($this->_var['personal_pic']): ?>src="<?php echo $this->_var['personal_pic']; ?>"<?php else: ?>src="themes/yihaodian/images/nonehead.jpg"<?php endif; ?>/></dt>
                <dd class="datum_l_a">
                    <!-- <input type="file"  name="profile"  id="profile" value="编辑头像"> -->
                  <input type="button" value="编辑头像" id="head_portrait" />
                </dd>
                <dd class="datum_l_b">提示：上传的照片大于10K小于3M，不小于 120*120 像素，支持 jpg、jpeg、gif、bmp、png等常见图片文件。</dd>
              <?php if ($this->_var['is_got_integral'] == '0'): ?>               

			   <br/>               
			   <div style="background: #fe7ba3;">
					<span class="tishi">   当前资料完善度：<font color="red"><?php echo $this->_var['user_information_completed_percent']; ?>%</font> <br>ps：资料已完善达80%时，可获得<?php echo $this->_var['profile_integral']; ?>积分
					 </span>
			   </div>
			  <?php endif; ?>
			</dl>
            <table class="datum_2" width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="145" align="right">用户名：</td>
    <td width="207"><?php echo $this->_var['profile']['user_name']; ?></td>
    <td width="348">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">昵称：</td>
    <td>
      <input class="datum_2_a" type="text" name="nickname" id="nickname" value="<?php echo $this->_var['profile']['nickname']; ?>"/></td>
    <td class="tishi">昵称长度不得超过40个汉字</td>
  </tr>
  <tr>
    <td align="right">邮箱：</td>
    <td><input name="email" type="text" value="<?php echo $this->_var['profile']['email']; ?>" class="datum_2_a" <?php if ($this->_var['info_validate']['chat_validated'] == '1' || $this->_var['info_validate']['chat_validated'] == '3'): ?>readonly<?php endif; ?>/></td>
    <td>  <?php if ($this->_var['info_validate']['chat_validated'] == '0' || $this->_var['info_validate']['chat_validated'] == '2'): ?><a href="user.php?act=security_edit_psd&type=email&email=&validate=0" class="home_m_2_button">立即绑定</a><?php else: ?><a href="javascript:void(0)" class="home_m_2_button">已绑定</a><?php endif; ?>  </td>
  </tr>
  <tr>
    <td align="right">手机：</td>
    <td><input name="mobile_phone" type="text" value="<?php echo $this->_var['profile']['mobile_phone']; ?>" class="datum_2_a" <?php if ($this->_var['info_validate']['chat_validated'] == '2' || $this->_var['info_validate']['chat_validated'] == '3'): ?>readonly<?php endif; ?>></td>
    <td><?php if ($this->_var['info_validate']['chat_validated'] == '0' || $this->_var['info_validate']['chat_validated'] == '1'): ?><a href="user.php?act=security_edit_psd&type=phone&phone=18768103573&validate=0" class="home_m_2_button">立即绑定</a><?php else: ?><a href="javascript:void(0)" class="home_m_2_button">已绑定</a><?php endif; ?> </td>
  </tr>
  <tr>
    <td align="right">会员等级：</td>
    <td><?php echo $this->_var['profile']['rank_name']; ?></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td align="right">真实姓名：</td>
    <td><input class="datum_2_a" type="text" name="truename" value="<?php echo $this->_var['profile']['truename']; ?>" id="truename" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">姓别：</td>
    <td><input type="radio" name="sex" value="1" <?php if ($this->_var['profile']['sex'] == 1): ?>checked="checked"<?php endif; ?>/>
      <label for="radio">男
        <input type="radio" name="sex" value="2" <?php if ($this->_var['profile']['sex'] == 2): ?>checked="checked"<?php endif; ?>/>
        女
      </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td width="151" align="right"><b>*</b>所在地区：</td>
	<td width="549"><label for="select5"></label>
	<span class="select_a">
								<select name="country" id="selCountries_1" onchange="region.changed(this, 1, 'selProvinces_1')" style="display:none;">
									<option value="1" selected>中国</option>
								</select>
								<select name="province" id="selProvinces_1" onchange="region.changed(this, 2, 'selCities_1')">
									<option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['1']; ?></option>
									<?php $_from = $this->_var['province_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
									<option value="<?php echo $this->_var['province']['region_id']; ?>" ><?php echo $this->_var['province']['region_name']; ?></option>
									<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
								</select>
						 </span>
						  <span class="select_a">
								<select name="city" id="selCities_1" onchange="region.changed(this, 3, 'selDistricts_1')">
									<option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['2']; ?></option>
									<?php $_from = $this->_var['city_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'city');if (count($_from)):
    foreach ($_from AS $this->_var['city']):
?>
									<option value="<?php echo $this->_var['city']['region_id']; ?>" ><?php echo $this->_var['city']['region_name']; ?></option>
									<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
								</select>
						   </span>
						   <span class="select_a">
								<select name="district" id="selDistricts_1" >    
									<option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['3']; ?></option>
									<?php $_from = $this->_var['district_list'][$this->_var['sn']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'district');if (count($_from)):
    foreach ($_from AS $this->_var['district']):
?>
									<option value="<?php echo $this->_var['district']['region_id']; ?>" ><?php echo $this->_var['district']['region_name']; ?></option>
									<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
								</select>
						   </span>
						</td>
				  </tr>
  <tr>
    <td align="right">固定电话</td>
    <td><input class="datum_2_a" type="text" name="home_phone" value="<?php echo $this->_var['profile']['home_phone']; ?>" id="textfield6" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">QQ：</td>
    <td><input class="datum_2_a" type="text" name="qq" value="<?php echo $this->_var['profile']['qq']; ?>" id="qq" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">MSN：</td>
    <td><input class="datum_2_a" type="text" name="msn" value="<?php echo $this->_var['profile']['msn']; ?>"  id="msn" /></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td align="right">宝宝生日/<br>预产期：</td>
    <td>
		<?php if ($this->_var['profile']['bday']): ?>
		<input class="datum_2_a" type="text" name="baday" value="<?php echo $this->_var['profile']['bday']; ?>"  readonly="readonly"/>
		<?php else: ?>
		  <input class="datum_2_a Wdate" type="text" name="baday"  onClick="WdatePicker()"> 
		<?php endif; ?>
	</td>
    <td align="center" class="tishi" style="margin-left:-30px;"><span style="size:12px;">填写宝宝生日/预产期信息后，宝宝生日时将会收到生日惊喜哦！
<br/>ps：宝宝资料只允许填写一次，不可修改！</span></td>
  </tr>
  
  <tr>
    <td align="right">宝宝小名：</td>
    <td><input class="datum_2_a" type="text" name="name1" value="<?php echo $this->_var['profile']['bname']; ?>"  id="baname"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">宝宝性别：</td>
    <td><input type="radio" name="bsex" value="1" <?php if ($this->_var['profile']['bsex'] == 1): ?>checked="checked"<?php endif; ?>/>
      <label for="radio3">男
        <input type="radio" name="bsex" value="2" <?php if ($this->_var['profile']['bsex'] == 2): ?>checked="checked"<?php endif; ?>/>
        女</label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><a href="javascript:before_validate()" class="other_botton">保存资料</a><input name="act" type="hidden" value="act_edit_profile" /></td>
    <td>&nbsp;</td>
  </tr>
            </table>

          </div>
           </form>
        </div>
        
 <?php echo $this->fetch('library/head_portrait.lbi'); ?>
      <?php endif; ?>  
    

    <?php if ($this->_var['action'] == 'address_list'): ?>
    
            <?php echo $this->smarty_insert_scripts(array('files'=>'utils.js,transport.js,region.js,shopping_flow.js')); ?>
            <script type="text/javascript">
              region.isAdmin = false;
              <?php $_from = $this->_var['lang']['flow_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
              var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
              <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
              
              onload = function() {
                if (!document.all)
                {
                  document.forms['theForm'].reset();
                }
              }
              
			  
			  function cngnListSetDefault(address_id)
			  {
				  Ajax.call( 'user.php?act=moren', 'id=' + address_id, cngnListSetDefault_callback , 'GET', 'TEXT', true, true );
			  }
			  function cngnListSetDefault(result)
			  {
			    if(result == -1)
				alert('设置默认地址失败');
			    else
				{
				$('.cngnListSetDefault').show();
				$('.cngnListDefault').hide();
				$('#cngnListSetDefault'+result).hide();
				$('#cngnListDefault'+result).show();
				}
			  }
            </script>
        <div class="orders">
       	  <div class="other_title">
            	<h3>收货地址</h3>
          </div>
<?php if (! $this->_var['consignee_list']): ?>
          <table class="address_2" width="900" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="100" align="center">暂无收货地址</td>
            </tr>
            <tr>
              <td><a href="#xiugai" class="other_botton">新增收货地址</a></td>
            </tr>
          </table>
<?php else: ?>
    <?php $_from = $this->_var['consignee_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('sn', 'consignee');$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from AS $this->_var['sn'] => $this->_var['consignee']):
        $this->_foreach['loop']['iteration']++;
?>
    <form action="user.php" method="post" name="theForm" onsubmit="return checkConsignee(this)">
        <?php if ($this->_var['consignee']['address_id']): ?>
            <div class="address_1">
            	<p><b><?php echo htmlspecialchars($this->_var['consignee']['add']); ?><?php echo htmlspecialchars($this->_var['consignee']['address']); ?></b>
              <span>邮编：<?php echo htmlspecialchars($this->_var['consignee']['zipcode']); ?></span><span><?php echo htmlspecialchars($this->_var['consignee']['consignee']); ?>（收）</span><span><?php echo htmlspecialchars($this->_var['consignee']['tel']); ?></span></p>
                <div class="caozuo">
                	<div class="delete">
						<a href="#" onclick="if (confirm('<?php echo $this->_var['lang']['confirm_drop_address']; ?>'))location.href='user.php?act=drop_consignee&id=<?php echo $this->_var['consignee']['address_id']; ?>'"></a>
					</div>
                    <span class="caozuo_1 caozuo_2 cngnListDefault" style="display:none" id='cngnListDefault<?php echo $this->_var['consignee']['address_id']; ?>'>默认收货地址</span>
                    <a  style="cursor:pointer;" class="caozuo_1 cngnListSetDefault" id='cngnListSetDefault<?php echo $this->_var['consignee']['address_id']; ?>' onclick="if (confirm('确实要设置为默认地址吗？')) cngnListSetDefault('<?php echo $this->_var['consignee']['address_id']; ?>')">设为默认收货地址</a>
                    <a class="caozuo_1" href="#xiugai" onclick="xiugai(<?php echo $this->_var['consignee']['address_id']; ?>)">修改本地址</a>
                </div>
           </div>
        <?php endif; ?>
             <input type="hidden" name="act" value="act_edit_address" />
             <input name="address_id" type="hidden" value="<?php echo $this->_var['consignee']['address_id']; ?>" />
        </form>
     <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php endif; ?>
            <table class="address_2" width="900" border="0" cellpadding="0" cellspacing="0" id="xiugai">
                <tr>
                  <td width="199"><a href="#xiugai" class="other_botton">新增收货地址</a></td>
                  <td width="701" align="right">您已创建<?php echo $this->_var['nums']; ?>个地址，最多可创建10个地址！</td>
                </tr>
            </table>

<form action="user.php" method="post" name="theForm" onsubmit="return checkAdd()" id="theForm">
            <table class="newaddress" width="700" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="151" align="right"><b>*</b>所在地区：</td>
                <td width="549"><label for="select5"></label>
                  <span class="select_a">
                        <select name="country" id="selCountries_1" onchange="region.changed(this, 1, 'selProvinces_1')" style="display:none;">
                      <option value="1" selected>中国</option>
                    </select>
                        <select name="province" id="selProvinces_1" onchange="region.changed(this, 2, 'selCities_1')">
                            <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['1']; ?></option>
                            <?php $_from = $this->_var['province_list'][$this->_var['sn']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
                            <option value="<?php echo $this->_var['province']['region_id']; ?>" ><?php echo $this->_var['province']['region_name']; ?></option>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </select>
                 </span>
                  <span class="select_a">
                        <select name="city" id="selCities_1" onchange="region.changed(this, 3, 'selDistricts_1')">
                            <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['2']; ?></option>
                            <?php $_from = $this->_var['city_list'][$this->_var['sn']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'city');if (count($_from)):
    foreach ($_from AS $this->_var['city']):
?>
                            <option value="<?php echo $this->_var['city']['region_id']; ?>" ><?php echo $this->_var['city']['region_name']; ?></option>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </select>
                   </span>
                   <span class="select_a">
                        <select name="district" id="selDistricts_1" >    
                            <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['3']; ?></option>
                            <?php $_from = $this->_var['district_list'][$this->_var['sn']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'district');if (count($_from)):
    foreach ($_from AS $this->_var['district']):
?>
                            <option value="<?php echo $this->_var['district']['region_id']; ?>" ><?php echo $this->_var['district']['region_name']; ?></option>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </select>
                   </span>
                </td>
              </tr>
              <tr>
                <td align="right"><b>*</b>详细地址：</td>
                <td><label for="textfield2"></label>
                  <span class="select_b"><input type="text" name="address" id="address" value="<?php echo htmlspecialchars($this->_var['consignee']['address']); ?>" /></span></td>
              </tr>
              <tr>
                <td align="right">邮编：</td>
                <td><span class="select_b"><input type="text" name="zipcode" id="zipcode" value="<?php echo htmlspecialchars($this->_var['consignee']['zipcode']); ?>" /></span></td>
              </tr>
              <tr>
                <td align="right"><b>*</b>收货人姓名：</td>
                <td><span class="select_b"><input type="text" name="consignee" id="consignee" value="<?php echo htmlspecialchars($this->_var['consignee']['consignee']); ?>"/></span></td>
              </tr>
              <tr>
                <td align="right"><b>*</b>手机：</td>
                <td><span class="select_b"><input type="text" name="tel" id="tel" value="<?php echo htmlspecialchars($this->_var['consignee']['tel']); ?>" /></span></td>
              </tr>
              <tr>
                <td align="right"><input type="checkbox" name="is_first" id="is_first" value="1"/>
                  <label for="checkbox2"></label></td>
                <td>设为默认收货地址</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>
                    <a class="select_c" href="javascript:check_format('address_list')">保存收货地址</a>
                    <a class="select_d" href="#xiugai" onclick="clearAll()" id="clearAll">取消</a>
                    <input type="hidden" value="act_edit_address" name="act">
                    <input type="hidden" value="" name="address_id" id="address_id">
                </td>
              </tr>
            </table>
 </form>
        </div>
         <?php endif; ?>
         
	 
		<?php if ($this->_var['action'] == 'order_detail'): ?>
		<div class="orders">
		    <div class="other_title">
				<h3>订单信息</h3>
			</div>
			<table class="dingdanxinxi" width="900" border="0" cellspacing="0" cellpadding="0">
			    <tr>
    <td><div class="allorders_main_a">
	<?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'good');$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from AS $this->_var['good']):
        $this->_foreach['loop']['iteration']++;
?>
		<?php if (($this->_foreach['loop']['iteration'] - 1)): ?>
		<br/>
		<?php endif; ?>
		     
		<?php if ($this->_var['good']['packageBuy_id'] == '0'): ?>
			<dl>
				<dt><a href="<?php echo $this->_var['good']['url']; ?>"><img src="<?php echo $this->_var['good']['goods_thumb']; ?>" /></a></dt>
				<dd class="name"><a href="<?php echo $this->_var['good']['url']; ?>"><?php echo $this->_var['good']['goods_name']; ?></a></dd>
				<?php if ($this->_var['good']['goods_attr']): ?><dd class="guige"><?php echo $this->_var['good']['goods_attr']; ?></span></dd><?php endif; ?>
				<dd class="price"><span>¥<?php echo $this->_var['good']['goods_price']; ?></span><b>数量：<?php echo $this->_var['good']['goods_number']; ?></b></dd>
			</dl>
		<?php else: ?>
			<?php if ($this->_var['good']['packageBuy'] == '1'): ?>
				<div class="allorders_taocan">
					<div class="allorders_taocan_title">
						<h6>套餐商品</h6>  
                        <p>¥ XXXXX</p>
						<span><?php echo $this->_var['good']['goods_number']; ?>套</span>
                    </div>
			<?php endif; ?>
					<div class="allorders_main_a">
						<dl>
						  <dt><a href="<?php echo $this->_var['good']['url']; ?>"><img src="<?php echo $this->_var['good']['goods_thumb']; ?>"></a></dt>
							<dd class="name"><a href="<?php echo $this->_var['good']['url']; ?>"><?php echo $this->_var['good']['goods_name']; ?></a></dd>
							<?php if ($this->_var['good']['goods_attr']): ?><dd class="guige"><?php echo $this->_var['good']['goods_attr']; ?><!--规格：40X50CM<span>白色</span>--></dd><?php endif; ?>
							<dd class="price"><span>¥<?php echo $this->_var['good']['goods_price']; ?></span></dd>
						</dl>
					</div>
			<?php if ($this->_var['good']['packageBuy'] == '3'): ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
           
                </div></td>
  </tr>
			  <tr>
				<td>订单状态：<span class="dingdanxinxi_a"><?php echo $this->_var['order']['order_status']; ?> &nbsp;<?php echo $this->_var['order']['pay_status']; ?>&nbsp;<?php echo $this->_var['order']['shipping_status']; ?></span></td>
			  </tr>
			  <tr>
				<td>订单号：<?php echo $this->_var['order']['order_sn']; ?><a href="http://wpa.qq.com/msgrd?v=3&uin=2237209139&site=qq&menu=yes" target="_blank" class="dingdanxinxi_b">在线投诉</a></td>
			  </tr>
			  <tr>
				<td>订单总金额：<span class="dingdanxinxi_a">￥<?php echo $this->_var['order']['total_fee']; ?> </span>
				  (<?php if ($this->_var['order']['goods_amount'] != '0' || $this->_var['order']['goods_amount'] != '0.00'): ?>
				    商品：￥<?php echo $this->_var['order']['goods_amount']; ?>
				   <?php endif; ?>
				   <?php if ($this->_var['order']['pay_fee'] != '0' || $this->_var['order']['pay_fee'] != '0.00'): ?>
				    &nbsp;支付费用：￥<?php echo $this->_var['order']['pay_fee']; ?>
				   <?php endif; ?>
				   <?php if ($this->_var['order']['shipping_fee'] != '0' || $this->_var['order']['shipping_fee'] != '0.00'): ?>
				    &nbsp;运费：￥<?php echo $this->_var['order']['shipping_fee']; ?>
				   <?php endif; ?>
				    <?php if ($this->_var['order']['insure_fee'] != '0' || $this->_var['order']['insure_fee'] != '0.00'): ?>
				    &nbsp;保价费：￥<?php echo $this->_var['order']['insure_fee']; ?>
				   <?php endif; ?>
				  
				     <?php if ($this->_var['order']['pack_fee'] != '0' || $this->_var['order']['pack_fee'] != '0.00'): ?>
				    &nbsp;包装费：￥<?php echo $this->_var['order']['pack_fee']; ?>
				   <?php endif; ?>
				     <?php if ($this->_var['order']['card_fee'] != '0' || $this->_var['order']['card_fee'] != '0.00'): ?>
				    &nbsp;贺卡费：￥<?php echo $this->_var['order']['card_fee']; ?>
				   <?php endif; ?>
				    <?php if ($this->_var['order']['tax'] != '0' || $this->_var['order']['tax'] != '0.00'): ?>
				    &nbsp;发票费：￥<?php echo $this->_var['order']['tax']; ?>
				   <?php endif; ?>
				    <?php if ($this->_var['order']['integral'] != '0' || $this->_var['order']['integral'] != '0.00'): ?>
				    &nbsp;使用积分数：<?php echo $this->_var['order']['integral']; ?>
				   <?php endif; ?>)
				   <?php if ($this->_var['order']['discount'] != '0'): ?>(优惠：￥<?php echo $this->_var['order']['formated_discount']; ?>)<?php endif; ?>
				</td>
			  </tr>
			  <tr>
			    <td>实付款：<span class="dingdanxinxi_a">
				￥<?php echo $this->_var['order']['money_paid']; ?> </span>
			  </tr>
			  <tr>
				<td>收货地址：
				<span id='orderInfoAddr'>
				<?php echo $this->_var['order']['consignee']; ?>
				&nbsp;<?php echo $this->_var['order']['province']; ?>&nbsp;<?php echo $this->_var['order']['city']; ?>&nbsp;<?php echo $this->_var['order']['district']; ?>&nbsp;<?php echo $this->_var['order']['address']; ?>
				&nbsp;	&nbsp;	&nbsp;
				<?php if ($this->_var['order']['tel']): ?>&nbsp;买家电话：<?php echo $this->_var['order']['tel']; ?><?php endif; ?>  
				<?php if ($this->_var['order']['mobile']): ?>&nbsp;买家手机：<?php echo $this->_var['order']['mobile']; ?><?php endif; ?>
				</span>
				<?php if ($this->_var['order']['pay_status'] == '未付款'): ?>
				<a class="dingdanxinxi_b" href="javascript:elem_show('theForm')">修改地址</a>
				<form name="theForm"  id="theForm" style="display:none;">
		<div class="xgdz">
            <table cellspacing="0" cellpadding="0" border="0" width="700" class="newaddress">
              <tbody><tr>
                <td width="151" align="right"><b>*</b>所在地区：</td>
                <td width="549"><label for="select5"></label>
                  <span class="select_a">
                        <select name="country" id="selCountries_1" onchange="region.changed(this, 1, 'selProvinces_1')" style="display:none;">
                      <option value="1" selected="">中国</option>
                    </select>
                        <select name="province" id="selProvinces_1" onchange="region.changed(this, 2, 'selCities_1',0)">
                            <option value="0">请选择省</option>
                                                        <option value="2">北京</option>
                                                        <option value="3">安徽</option>
                                                        <option value="4">福建</option>
                                                        <option value="5">甘肃</option>
                                                        <option value="6">广东</option>
                                                        <option value="7">广西</option>
                                                        <option value="8">贵州</option>
                                                        <option value="9">海南</option>
                                                        <option value="10">河北</option>
                                                        <option value="11">河南</option>
                                                        <option value="12">黑龙江</option>
                                                        <option value="13">湖北</option>
                                                        <option value="14">湖南</option>
                                                        <option value="15">吉林</option>
                                                        <option value="16">江苏</option>
                                                        <option value="17">江西</option>
                                                        <option value="18">辽宁</option>
                                                        <option value="19">内蒙古</option>
                                                        <option value="20">宁夏</option>
                                                        <option value="21">青海</option>
                                                        <option value="22">山东</option>
                                                        <option value="23">山西</option>
                                                        <option value="24">陕西</option>
                                                        <option value="25">上海</option>
                                                        <option value="26">四川</option>
                                                        <option value="27">天津</option>
                                                        <option value="28">西藏</option>
                                                        <option value="29">新疆</option>
                                                        <option value="30">云南</option>
                                                        <option value="31">浙江</option>
                                                        <option value="32">重庆</option>
                                                        <option value="33">香港</option>
                                                        <option value="34">澳门</option>
                                                        <option value="35">台湾</option>
                                                    </select>
                 </span>
                  <span class="select_a">
                        <select name="city" id="selCities_1" onchange="region.changed(this,3, 'selDistricts_1',0)">
                            <option value="0">请选择市</option>
                                                    </select>
                   </span>
                   <span class="select_a">
                        <select style="display: none;" name="district" id="selDistricts_1">    
                            <option value="0">请选择区</option>
                                                    </select>
                   </span>
                </td>
              </tr>
              <tr>
                <td align="right"><b>*</b>详细地址：</td>
                <td><label for="textfield2"></label>
                  <span class="select_b"><input type="text" name="address" id="address" value=""></span></td>
              </tr>
              <tr>
                <td align="right">邮编：</td>
                <td><span class="select_b"><input type="text" name="zipcode" id="zipcode" value=""></span></td>
              </tr>
              <tr>
                <td align="right"><b>*</b>收货人姓名：</td>
                <td><span class="select_b"><input type="text" name="consignee" id="consignee" value=""></span></td>
              </tr>
              <tr>
                <td align="right"><b>*</b>手机：</td>
                <td><span class="select_b"><input type="text" name="tel" id="tel" value=""></span></td>
              </tr>
			  <!--
              <tr>
                <td align="right"><input type="checkbox" name="is_first" id="is_first" value="1">
                  <label for="checkbox2"></label></td>
                <td>设为默认收货地址</td>
              </tr>
			  -->
              <tr>
                <td>&nbsp;</td>
                <td>
                    <a class="select_c"  href="javascript:check_format();">确认修改</a>
                    <a class="select_d"   href="javascript:elem_hide('theForm')">取消</a>
                    <input type="hidden" value="change_order_address" name="act" id='act'>
                    <input type="hidden" value="" name="address_id" id="address_id">
                </td>
              </tr>
            </tbody></table>
		</div>
 </form>
				
				
				<?php endif; ?>
				</td>
			  </tr>
			  <tr>
				<td>买家留言：<?php echo $this->_var['order']['postscript']; ?></td>
			  </tr>
			  <tr>
				<td>配送方式：<?php echo $this->_var['order']['shipping_name']; ?>  &nbsp;&nbsp;<?php if ($this->_var['freightInfo']['express_type']): ?>发货快递：<?php echo $this->_var['freightInfo']['express_name']; ?><?php endif; ?></td>
			  </tr>
			  <?php if ($this->_var['freightInfo']['express_type']): ?>
			   <tr>
				<td>运单号：<?php echo $this->_var['freightInfo']['express_no']; ?></td>
			  </tr>
			  <tr>
			  <script>
					  function change_text()
					  {
					 
					    if($('#freight_detail').css('display') == 'block')
						{
						  $("#show_freightDetail").html('收起物流明细');
						}
						else 
						{
						 $("#show_freightDetail").html('查看物流明细');
						}
						
					  }
					  function activeCurrent(id)
					  {
					     $('#detailExpressInfo li').removeClass('active');
						 $('#'+id).addClass('active');
					  }
					  $(function(){
				
					    Ajax.call( 'includes/freight_detail.php', "freightType='<?php echo $this->_var['freightInfo']['express_type']; ?>'&freightCom='<?php echo $this->_var['freightInfo']['express_company']; ?>'&freightNo='<?php echo $this->_var['freightInfo']['express_no']; ?>'",freightDetail_callback, 'GET', 'json', true, true );
				
					  });
					  function freightDetail_callback(result)
					  {
					 
				
					    var express_detail = result['data'];
						var lastInfo = new Array();
						var html = '';
					    $.each(express_detail,function(idx,item)
						{ 
								switch(idx)
								{
								  case 0:html += '<li class="special">'; break;
								  case (express_detail.length - 1):html += '<li class="last">'; break;
								  default: case 0:html += '<li class="">'; break;
								}
								
								//html += '<li class="last active">' //special
								html += '<span class="wl-stream-time">' + item['time'] + '</span>';
								html += '<span class="wl-stream-text">' + item['context'] + '</span>';
								html += '<div class="wl-stream-info">';
								html += '<p class="wl-linkb">';
								html += '<span class="pr10">查询服务提供商：<a href="http://www.ickd.cn" target="_blank">爱查快递</a></span>';
								html += '<span class="pr10">运单号：<?php echo $this->_var['freightInfo']['express_no']; ?>&nbsp;<?php echo $this->_var['freightInfo']['express_name']; ?></span>';
								html += '<span class="fright"></span>';
								html += '</p>';
								html += '</div>';
								html += '</li>';
								
								lastInfo['time'] = item['time'];
								lastInfo['context'] = item['context'];
						});
						$('#detailExpressInfo').html(html);
						$('#latest_express').html(lastInfo['time'] +' '+ lastInfo['context']);
						
						//*	  
						$('#detailExpressInfo li').on('click',function(){
					 
					  $('#detailExpressInfo li').removeClass('active');
						$(this).addClass('active');
					  });
					  //*/
					  }
					
					</script>
					
						<td>订单跟踪：<span id="latest_express"> </span>
					
		<a id="show_freightDetail" onclick="elem_toggle('freight_detail');change_text();" style="cursor:pointer;" class="dingdanxinxi_b" href="javascript:void(0)">查看物流明细</a>
	<div id="freight_detail" style="display:none;">
					<br/>
					 <div class="wl-lineCon ks-switchable-content">
													<div class="wl-module wl-stream wl-toggle">
														<div class="wl-streamUL" id="wl-midtrace">
														<ul id="detailExpressInfo">
														
														</ul>
														</div>
                                                    </div>
                     </div>
	</div>
	</td>
					
			
			  </tr>
			  <?php else: ?>
			  <tr><td>订单跟踪：没有物流信息</td></tr>
			  <?php endif; ?>
			  	   <tr>
    <td><a href="user.php?act=order_list" class="back_to_orderList">返回</a></td>
  </tr>
			</table>
        </div>
	</div>
		<?php endif; ?>
    
</div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
</body>
<script type="text/javascript">
<?php $_from = $this->_var['lang']['clips_js']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</script>
</html>

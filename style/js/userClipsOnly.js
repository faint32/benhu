$(function(){		
	titleListLiBindMouseover()
	titleListLiSetWidth()
	tabLiBindMouseover()
	setReturnGoodsUploadProof()
	setShaidanUploadInfo()
});
function titleListLiBindMouseover()
{
	$('.title-list li').mouseover(function(){
						var liindex = $('.title-list li').index(this);
						$(this).addClass('on').siblings().removeClass('on');
						$('.orders_tab_box div.orders_tab_main').eq(liindex).fadeIn(150).siblings('div.orders_tab_main').hide();
						var liWidth = $('.title-list li').width();
						$('.orders_tab .title-list p').stop(false,true).animate({'left' : liindex * liWidth + 'px'},300);	
						eleAutoCenter(1)
					});
}
function titleListLiSetWidth()
{
	$('.title-list li').each(function(index){
					$(this).css('width','130px')
					if(index=='{$ctl}')
					{
						$(this).addClass('on')
					}
				});
}
function tabLiBindMouseover()
{
	  $('#tab li').mouseover(function(){//chen 0905
				var t = $(this).index();
				var ul = $('#content ul');
				$('#tab li').removeClass();
				$(this).addClass('current');
				ul.css('display','none');
				ul.eq(t).css('display','block');
				});
}
function setReturnGoodsUploadProof()
{
   var params = {
	fileInput: $("#fileImage").get(0),
	url: "",
	filter: function(files) {
		var arrFiles = [];
		for (var i = 0, file; file = files[i]; i++) {
			if (file.type.indexOf("image") == 0) {
				if (file.size >= 5120000) {
					alert('您这张"'+ file.name +'"图片大小过大，应小于5000k');	
				} else {
					arrFiles.push(file);	
				}			
			} else {
				alert('文件"' + file.name + '"不是图片。');	
			}
		}
		return arrFiles;
	},
	onSelect: function(files) {
		var html = '', i = 0;
		$("#preview").html('<td>&nbsp;</td>');
		var funAppendImage = function() {
			file = files[i];
			if (file) {
				var reader = new FileReader()
				reader.onload = function(e) {
				 html = html + '<dl class="uploadimg" id="uploadimg_'+i+'">'
									+'<dt><img src="'+e.target.result+'" width="50" height="50" /></dt>'
									+'<dd><a class="upload_delete" href="javascript:" data-index="'+ i +'">删除</a></dd>'
								+'</dl>';			
					
					i++;
					funAppendImage();
				}
				reader.readAsDataURL(file);
			} else {
				$("#preview").html(html);
				if (html)
				{
					//删除方法
					$(".upload_delete").click(function() {
						ZXXFILE.funDeleteFile(files[parseInt($(this).attr("data-index"))]);
						return false;	
					});
					
				}
			}
		};
		funAppendImage();		
	},
	onDelete: function(file) {
		$("#uploadimg_" + file.index).fadeOut();
	},
	onFailure:function(file, respText){
	alert(file.name+"上传失败");
	},
	onComplete:function(){
	  document.getElementById('return_goods_form').submit();
	}
};
ZXXFILE = $.extend(ZXXFILE, params);
ZXXFILE.init();
}
function setShaidanUploadInfo()
{
var len=$('.shaidan').size();
  var succ_times = 0; //记录每个商品晒单图片上传成功的次数
 shaidan = new Array(len);
 shaidan_nums = 0; 
for(var i=0; i <len; i++)
shaidan[i]=new Html5UpLoad();
   $('.shaidan').each(function(index){
       var params = {
	   fileInput: $("#fileImage"+index).get(0),
	
	 //   url: "comment.php?order_id='{$order_id}'",
	filter: function(files) {
		var arrFiles = [];
		for (var i = 0, file; file = files[i]; i++) {
			if (file.type.indexOf("image") == 0) {
				if (file.size >= 5120000) {
					alert('您这张"'+ file.name +'"图片大小过大，应小于5000k');	
				} else {
					arrFiles.push(file);	
				}			
			} else {
				alert('文件"' + file.name + '"不是图片。');	
			}
		}
		return arrFiles;
	},
	onSelect: function(files) {
		var html = '', i = 0;
		$("#preview"+index).html('');
		var funAppendImage = function() {
			file = files[i];
			if (file) {
		
				var reader = new FileReader()
				
				reader.onload = function(e) 
				{
				 html = html + '<li id="uploadimg_'+index+'_'+i+'"><span><a href="javascript:void(0)"><img width="100" height="100" src="'+e.target.result+'"></a></span><a href="javascript:void(0)" data-index="'+ i +'" class="caozuo_'+index+'">删除</a>';			
					i++;
					funAppendImage();
				}
				reader.readAsDataURL(file);
			} else {
				$("#preview"+index).html(html);
				if (html)
				{
					//删除方法
					$(".caozuo_"+index).click(function() {
						shaidan[index].funDeleteFile(files[parseInt($(this).attr("data-index"))]);
						
						return false;	
					});
					
				}
			}
		};
		funAppendImage();		
	},
	onDelete: function(file) {
		$("#uploadimg_"+ index + '_' + file.index).fadeOut();
	},
	onFailure:function(file, respText){
	alert(file.name+"上传失败");
	},
	onComplete:function(){
	   succ_times++;
	if(succ_times == shaidan_nums)
	do_submit();
	}
};

shaidan[index] = $.extend(shaidan[index], params);
shaidan[index].init();
});
}

function turnoff(obj){
	document.getElementById(obj).style.display="none";
}
function show_complain(order_sn,order_id){
	     $('#complain').show();
		 $('#complain_order_sn').html(order_sn);
		 $('#complain_order_id').val(order_id);
}

function return_goods_before_submit()
{
 var order_id=$('#order_id').val();
	var rand_num=$('#rand_num').val();
	
	if(ZXXFILE.fileFilter[0])
   {

ZXXFILE.url = 'user.php?act=up_load&order_id='+order_id+'&rand_num='+rand_num;
ZXXFILE.funUploadFile();
   }
   else
   {
     document.getElementById('return_goods_form').submit();
   }
}


 //chen-1009
  function is_commented()
   {
   var order_id = $('#order_id').val();
     var param='act=ajax_isCommented&order_id='+order_id;
     Ajax.call( 'comment.php',param,is_commented_callback , 'GET', 'json', true, true );
   }
   function is_commented_callback(result)
   {
     if(result == '1')
	  alert('您已经评价过了，不能重复评价');
	 else if(result == '0')
	  commentForm_on_submit();
   }
   
   
function commentForm_on_submit()
{
var len=$('.shaidan').size();
shaidan_nums = 0; //记录有多少个商品进行了晒单
for(var i = 0; i < len; i++)
{
var goods_id = $('#goods_id'+i).val();
var order_id = $('#order_id').val();
shaidan[i].url = "comment.php?order_id="+order_id+"&goods_id="+goods_id+'&type=upload_file'; 
    shaidan[i].funUploadFile();
	
  if(shaidan[i].fileFilter.length !=0 ) 
  {
  shaidan_nums++;
  Ajax.call( 'comment.php',"act=get_shaidanIntegral",'' , 'GET', 'json', true, true );//获得晒单积分
  }
}
if(shaidan_nums==0)  do_submit();
}
function do_submit()
{
$('#comment_form').submit();
}



 function you_may_love()
   {
  var param='act=you_may_love';
     Ajax.call( 'user.php',param,you_may_love_callback , 'GET', 'json', true, true );
   }
   function you_may_love_callback(result)
  {
   var ele=$('#you_may_love');
   var str='';
   for(var i=0; i < result.length; i ++)
   {
   if(i==(result.length - 1))
         str += '<dl>';
	else str += '<dl class="home_m_2_mr10">';
	str+='<dt><a href="goods.php?id='+result[i].goods_id+'"><img src="'+result[i].goods_thumb+'" /></a></dt><dd><a href="goods.php?id='+result[i].goods_id+'">'+result[i].goods_name.substr(0,20)+'</a><span>¥'+result[i].shop_price+'</span></dd></dl>';
   }
    ele.empty();
	ele.html(str);
  }
  function delete_complain(id)
  {
     var param='act=delete_complain&id='+id;
     Ajax.call( 'user.php',param,delete_complain_callback , 'GET', 'json', true, true );
  }
   function delete_complain_callback(result)
  {
   if(result[1]==1)//删除成功
   {
     $('#complain'+result[0]).empty();
   }
   else if(result[1]==0)//删除失败
   {
     alert('删除失败');
   }
  }
   function cancle_back_order(id)
   {
    var param='act=cancle_back_order&id='+id;
     Ajax.call( 'user.php',param,cancle_back_order_callback , 'GET', 'json', true, true );
   }
   function cancle_back_order_callback(result)
  {
    if(result[1]==1)//取消申请成功
   {
     $('#return_goods_'+result[0]).empty();
   }
   else if(result[1]==0)//取消申请失败
   {
     alert('删除失败');
   }
  }
  //删除订单 chen 0903
  function on_delete(order_id)
  {
     $('#delete_order').show();
	 $('#del_order_id').val(order_id);
  }
   function delete_order()
  {
  var order_id=$('#del_order_id').val();
     var param='act=delete_order&order_id='+order_id;
     Ajax.call( 'user.php',param,delete_order_callback , 'GET', 'json', true, true );
  }
   function delete_order_callback(result)
  {
    if(result != "failed")
	{
	  $('.order_id_'+result).remove();//css('display','none');
	}
  }
  
  //评论已完成的订单  chen-0914
  function on_comment(goods_id_list,order_id)
  {
 
  window.location.href='user.php?act=comment_goods&goods_id_list='+goods_id_list+'&order_id='+order_id;

  }

   function cancle_back_order(id)
   {
    var param='act=cancle_back_order&id='+id;
     Ajax.call( 'user.php',param,cancle_back_order_callback , 'GET', 'json', true, true );
   }
   function cancle_back_order_callback(result)
  {
    if(result[1]==1)//取消申请成功
   {
     $('#return_goods_'+result[0]).empty();
   }
   else if(result[1]==0)//取消申请失败
   {
     alert('删除失败');
   }
  }
	$(document).ready(function(){
	textCounter();
	});
  function textCounter()    //描述，剩余多少个字
  {
  var descrip_ele=$('#pro_descrip');
   maxlimit= descrip_ele.attr('maxlength');
   var len = descrip_ele.val().length;
   var str='还可以写'+(maxlimit-len)+'个字。';
   $('#limit_count').html(str);
  }
  
   function show_orders(id)
 {
	     $('.slide-pics').each(function(){
		   $(this).hide();
		 });
		 $(id).show();
	  }
  
    function select_all_goods(flag)
								 {
									  if(flag)
									  {
									   $('.collection_goods_list').attr('checked',true);
									   $('.goods_list').attr('value',1);
									   }
									  else  
									   {
										   $('.collection_goods_list').attr('checked',false);
										    $('.goods_list').attr('value',0);
									   }
								 }
								 function select_one(flag,id)
								 {
									 if(flag)
									  {
									   $('#goods_'+id).attr('checked',true);
									   $('#goodslist_'+id).attr('value',1);
									   }
									  else  
									   {
										  $('#goods_'+id).attr('checked',false);
										    $('#goodslist_'+id).attr('value',0);
									   }
								 }
								 
								 function delete_select()
								 {
								 var arr = new Array();
								    $('.goods_list').each(function(){
									    if($(this).attr('value')=='1')
									     {
										   var str=$(this).attr('id');
										   var pos=str.indexOf('_')+1;
										    arr.push(str.substr(pos));
										 }
									});
									
									var id_arr= arr;
									Ajax.call('user.php?act=del_collected','rec_id_list=' + id_arr+'&type=del_sel', del_call_back , 'GET', 'TEXT', true, true );										
								 }
								function delete_one(id)
								{
								var id_arr=new Array();
								id_arr[0]=id;
								   Ajax.call('user.php?act=del_collected','rec_id_list=' + id_arr+'&type=del_one', del_call_back , 'GET', 'TEXT', true, true );
								}
								function del_call_back(obj)
								{
									if(obj=='failed')
									{
									   alert("删除失败！请刷新后重试，或联系管理员。");
									  return ;
									}
								 var result =  JSON.parse(obj);
								 
									 if(result.type=="del_sel")
									 {
									
										var arr=result.id_list.split(",");
										for(var i = 0; i<arr.length;i++)
										  {
												$('#goodslist_'+arr[i]).remove();
										  }
									 }
									 else
									 {
									    $('#goodslist_'+result.id_list).remove();
									 }
								}
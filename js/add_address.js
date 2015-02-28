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
				     if(comeFlag =='address_list' || comeFlag == 'check_out')
					 {
					 saveadd();
					
					 return ;
					 }
					//*
					checkArr['order_sn'] = '{$order.order_sn}';
					 checkArr['zip_code'] = $('#zipcode').val() == 0 ? '': $('#zipcode').val();
					 checkArr['callbackElemId'] = 'orderInfoAddr';
					 checkArr['hideElemIdList'] = 'theForm';
					 var act = $('#act').val();
					 
					 var url = 'user.php';
					 formAjaxSubmit(url,act,checkArr);
					 
					}
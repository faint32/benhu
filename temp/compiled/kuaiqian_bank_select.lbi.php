 <link href="style/css/jingdong.css" type="text/css" rel="stylesheet"/>
 <script type="text/javascript" src="style/js/kuaiqianBankSelect.js"></script>
<!--
<meta charset="utf-8"> 
<script type="text/javascript" src="js/jquery.min.js"></script>

-->
<div class="payment" >
<div id="payCardBoxDiv" class="paybox j_paybox paybox-selected">
    <div class="p-wrap">
     
        <div style="" class="bank-area j_bankArea">
        
        <div data-widget="tabs" class="bank-wrap j_tabs j_bankEdit" style="opacity: 1;">
            <div class="ui-tab">
                <div class="ui-tab-items">
                    <ul class="clearfix">
                        <li   class="ui-tab-item curr"  date-div="savingsDepositCardDiv">
                            <a href="javascript:;"><i></i>储蓄卡</a>
                        </li>
                        <li   class="ui-tab-item  " date-div="creditCardDiv">
                            <a href="javascript:;">信用卡</a>
                        </li>
						  <li   class="ui-tab-item" date-div="kuaiqianUserDiv">
                            <a href="javascript:;">其他</a>
                        </li>
                    </ul>
                </div>
            </div>

            
            <div id="savingsDepositCardDiv"  class="bw-tab-content" >
                
                <div id="quickPayListDiv" class="payment-list j_quickBankList">
				
			<ul class="pl-wrap">
<!--                       
					   <li class="pl-item " data-paytype="10-1" data-bankid="ICBC">
                            <span id="bank-icbc" class="bank-logo tmp"></span>
                        </li>
                        <li class="pl-item" data-paytype="10-1" data-bankid="CCB">
							<span id="bank-ccb" class="bank-logo tmp"></span>
                        </li>  
						  <li class="pl-item" data-paytype="10-1" data-bankid="ABC">
							<span id="bank-abc" class="bank-logo tmp"></span>
                        </li> 
						 <li class="pl-item" data-paytype="10-1" data-bankid="CMB">
							<span id="bank-cmb" class="bank-logo tmp"></span>
                        </li> 
						 <li class="pl-item" data-paytype="10-1" data-bankid="BOC">
							<span id="bank-boc" class="bank-logo tmp"></span>
                        </li> 
						
						
						  <li class="pl-item" data-paytype="10-1" data-bankid="SPDB">
                            <span id="bank-spdb" class="bank-logo tmp"></span>
                        </li>
                        <li class="pl-item" data-paytype="10-1" data-bankid="BCOM">
							<span id="bank-bcom" class="bank-logo tmp"></span>
                        </li>  
						  <li class="pl-item" data-paytype="10-1" data-bankid="GDB">
							<span id="bank-gdb" class="bank-logo tmp"></span>
                        </li> 
						 <li class="pl-item" data-paytype="10-1" data-bankid="CMBC">
							<span id="bank-cmbc" class="bank-logo tmp"></span>
                        </li> 
						 <li class="pl-item" data-paytype="10-1" data-bankid="CIB">
							<span id="bank-cib" class="bank-logo tmp"></span>
                        </li> 
						
						
						
						  <li class="pl-item  hover" data-paytype="10-1" data-bankid="CEB">
                            <span id="bank-ceb" class="bank-logo tmp"></span>
                        </li>
                        <li class="pl-item" data-paytype="10-1" data-bankid="CITIC">
							<span id="bank-citic" class="bank-logo tmp"></span>
                        </li>  
						  <li class="pl-item" data-paytype="10-1" data-bankid="PSBC">
							<span id="bank-psbc" class="bank-logo tmp"></span>
                        </li> 
						 <li class="pl-item" data-paytype="10-1" data-bankid="PAB">
							<span id="bank-pab" class="bank-logo tmp"></span>
                        </li> 
						 <li class="pl-item" data-paytype="10-1" data-bankid="SHB">
							<span id="bank-shb" class="bank-logo tmp"></span>
                        </li> 
						
						
						  <li class="pl-item " data-paytype="10-1" data-bankid="SDB">
                            <span id="bank-sdb" class="bank-logo tmp"></span>
                        </li>
                        <li class="pl-item" data-paytype="10-1" data-bankid="POST">
							<span id="bank-post" class="bank-logo tmp"></span>
                        </li>  
						  <li class="pl-item" data-paytype="10-1" data-bankid="BJRCB">
							<span id="bank-bjrcb" class="bank-logo tmp"></span>
                        </li> 
						 <li class="pl-item" data-paytype="10-1" data-bankid="BOB">
							<span id="bank-bob" class="bank-logo tmp"></span>
                        </li> 
						 <li class="pl-item" data-paytype="10-1" data-bankid="NBCB">
							<span id="bank-nbcb" class="bank-logo tmp"></span>
                        </li> 
						
						
						  <li class="pl-item " data-paytype="10-1" data-bankid="UPOP">
                            <span id="bank-upop" class="bank-logo tmp"></span>
                        </li>
                        <li class="pl-item" data-paytype="10-1" data-bankid="HSB">
							<span id="bank-hsb" class="bank-logo tmp"></span>
                        </li>  
						  <li class="pl-item" data-paytype="10-1" data-bankid="HXB">
							<span id="bank-hxb" class="bank-logo tmp"></span>
                        </li> 
						 <li class="pl-item" data-paytype="10-1" data-bankid="GZCB">
							<span id="bank-gzcb" class="bank-logo tmp"></span>
                        </li> 
						 <li class="pl-item" data-paytype="10-1" data-bankid="NJCB">
							<span id="bank-njcb" class="bank-logo tmp"></span>
                        </li> 
						
						
						  <li class="pl-item " data-paytype="10-1" data-bankid="CBHB">
                            <span id="bank-cbhb" class="bank-logo tmp"></span>
                        </li>
                        <li class="pl-item" data-paytype="10-1" data-bankid="HZB">
							<span id="bank-hzb" class="bank-logo tmp"></span>
                        </li>  
						  <li class="pl-item" data-paytype="10-1" data-bankid="BEA">
							<span id="bank-bea" class="bank-logo tmp"></span>
                        </li> 
						 <li class="pl-item" data-paytype="10-1" data-bankid="SRCB">
							<span id="bank-srcb" class="bank-logo tmp"></span>
                        </li> 
						 <li class="pl-item" data-paytype="10-1" data-bankid="CZB">
							<span id="bank-czb" class="bank-logo tmp"></span>
                        </li> 
						-->
                    </ul>
			   </div>
                
            </div>
            

            
            <div id="creditCardDiv"  class="bw-tab-content" style="display:none;">
                
                <div id="ebankPaymentListDiv" class="payment-list j_eBankList">
				<ul class="pl-wrap">
                            
								   
                    </ul>
                </div>
            </div>
            <style>
.kuaiqian_fangshi{ width:130px; height:30px;
display:block; text-align:center; 
font-size:14px; line-height:30px; 
background:url(style/images/pay_botton.gif); margin-right:10px; float:left;}
.kuaiqian_fangshi.hover{color: #ff5d5b;z-index: 20;}
</style>
             <div id="kuaiqianUserDiv"  class="bw-tab-content" style="display:none;">
			  		<a href="javascript:void(0)" class="kuaiqian_fangshi pl-item" data-payType='12' data-bankID=''>快钱账户登陆</a>
                     <a href="javascript:void(0)" class="kuaiqian_fangshi pl-item" data-payType='14' data-bankID=''>企业网银</a>
                    <a href="javascript:void(0)" class="kuaiqian_fangshi pl-item" data-payType='00' data-bankID=''>默认</a>			 
			</div>
		</div>
        
        </div>
       
    </div>
</div>
</div>		
	
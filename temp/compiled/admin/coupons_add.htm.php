<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="styles/bootstrap/js/jquery.min.js"></script>
    <script src="styles/bootstrap/js/bootstrap.min.js"></script>
    <script src="styles/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
    <script src="styles/bootstrap/js/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
     <script src="styles/bootstrap/js/sundries.js" charset="UTF-8"></script>
    <script src="styles/bootstrap/js/set_language_zh-CN.js"></script>
    <link rel="stylesheet" href="styles/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/bootstrap/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/bootstrap/css/sundries.css">
  </head>
  <body>
  <script>
      function trim(str){ 
  　　     return str.replace(/(^\s*)|(\s*$)/g, "");
  　　}
    function isPositiveInteger(oNum){
      if(!oNum) return false;
      var strP=/^\d+$/; //正整数
      if(!strP.test(oNum)) return false;
      return true;
    }

    function isfloat(oNum){
     if(!oNum) return false;
     var strP=/^\d+(\.\d+)?$/;
     if(!strP.test(oNum)) return false;
      try{
        if(parseFloat(oNum)!=oNum) return false;
      }catch(ex){
        return false;
      }
      return true;
    }

    function isEmptyValue(v)
    {
      return (v == '')? true : false;
    }

    function checkInput()
    {
      var checkFlag = true;
      $('.alert-danger').hide();
      $("form input").each(function(){               
         var v = trim($(this).val()); 
         switch($(this).attr('check-type'))
         {
           case 'notEmptyValue':
              if(isEmptyValue(v))
              {
                checkFlag = false;
                $(this).parents('.row-item').find('.alert_words').html('不能为空值!');
                $(this).parents('.row-item').find('.alert-danger').show();
              }
              break;
           case 'positiveInteger':
             if(!isPositiveInteger(v))
             {
              checkFlag = false;
              $(this).parents('.row-item').find('.alert_words').html('检查该值是否为正整数!');
              $(this).parents('.row-item').find('.alert-danger').show();
             }
            break;
             case 'float':
             if(!isfloat(v))
             {
              checkFlag = false;
              $(this).parents('.row-item').find('.alert_words').html('检查该值是否为浮点数!');
              $(this).parents('.row-item').find('.alert-danger').show();
             }
            break;
           default:
            break;
         }
      })
      return checkFlag;
    }
  </script>
    <form onsubmit="return checkInput();" action="coupons.php" method="post">
      <input type="hidden" name="act" value="add_coupon"/>
      <input type="hidden" name="coupon_id" value="<?php if ($this->_var['coupon']): ?><?php echo $this->_var['coupon']['coupon_id']; ?><?php else: ?>0<?php endif; ?>"/>
      <div class="row panel panel-default" style="margin:20px 10px 0px 10px;">
        <div class="container col-md-10" >
           <h3 style="text-align:left;"> <a href="index.php?act=main">ECSHOP 管理中心</a> - <?php echo $this->_var['featureName']; ?></h3>
        </div>
        <div class="col-md-2" >
           <a href="coupons.php?act=list" class="btn btn-default btn-lg" role="button" style="margin:14px 8px 8px 8px;">
             <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;购物券列表
           </a>
        </div>
            </div>

      <div class="panel panel-default" style="margin:20px 10px;">
        <div class="row row-item">
          <div class="col-md-4">
            <div class="notice_lable" style="margin-top:15px">
               <b class="coupon_lable">购物券名称</b>
             </div>
          </div>
          <div class="col-md-3">
              <div class="coupon_rightdiv" style="margin-top:12px;">
              <input type="input" name="coupon_name" class="form-control"  placeholder="输入购物券名称" check-type="notEmptyValue" <?php if ($this->_var['coupon']): ?>value="<?php echo $this->_var['coupon']['coupon_name']; ?>"<?php endif; ?>/>
            </div>
          </div>
          <div class="col-md-3 alert_format" id="tmp" style="margin:12px 0 0;">
             <div class="alert alert-danger" role="alert">
              <p class="alert_words">
                不能为空值！ 
              </p>
             </div>
          </div>
      
        </div>


        <div class="row row-item other_row">
          <div class="col-md-4">
            <div class="notice_lable">
               <b class="coupon_lable"> 购物券描述</b>
             </div>
          </div>
          <div class="col-md-3">
              <div class="coupon_rightdiv">
                  <input type="input" name="coupon_description" class="form-control"  placeholder="描述这张购物券使用方式" check-type="notEmptyValue" <?php if ($this->_var['coupon']): ?>value="<?php echo $this->_var['coupon']['coupon_description']; ?>"<?php endif; ?>/>
            </div>
          </div>

          <div class="col-md-3 alert_format">
            <div class="alert alert-danger" role="alert">
              <p class="alert_words">
                不能为空值！ 
              </p>
            </div>
          </div>
        </div>


        <div class="row row-item other_row">
          <div class="col-md-4">
            <div class="notice_lable">
               <b class="coupon_lable"> 购物券面值</b>
             </div>
          </div>
          <div class="col-md-3">
              <div class="coupon_rightdiv">
              <div class="input-group">
                    <div class="input-group-addon">￥:</div>
                     <input type="input" name="coupon_value" class="form-control" placeholder="输入购物券面值"  check-type="float" <?php if ($this->_var['coupon']): ?>value="<?php echo $this->_var['coupon']['coupon_value']; ?>"<?php endif; ?>>
               </div>
            </div>
          </div>
          <div class="col-md-3 alert_format">
            <div class="alert alert-danger" role="alert">
              <p class="alert_words">
                不能为空值！ 
              </p>
            </div>
          </div>
        </div>

        <div class="row row-item other_row">
          <div class="col-md-4">
            <div class="notice_lable">
               <span class="glyphicon glyphicon-question-sign notice" aria-hidden="true"></span>
               <b class="coupon_lable">使用限制</b>
             </div>
          </div>
          <div class="col-md-3">
              <div class="coupon_rightdiv">
              <div class="input-group">
                    <div class="input-group-addon">￥:</div>
                     <input type="input" name="restriction_ext" class="form-control"  placeholder="输入限制订单金额" check-type="float" <?php if ($this->_var['coupon']): ?>value="<?php echo $this->_var['coupon']['restriction_ext']; ?>"<?php endif; ?>>
               </div>
            </div>
            <div class="warning" style="display:none;">
            -1：表示无限制。输入的值表示订单满多少，才能使用该购物券。
            </div>
          </div>

          <div class="col-md-3 alert_format">
            <div class="alert alert-danger" role="alert">
              <p class="alert_words">
                不能为空值！ 
              </p>
            </div>
          </div>
        </div>
        
        <div class="row row-item other_row">
          <div class="col-md-4">
            <div class="notice_lable">
               <span class="glyphicon glyphicon-question-sign notice" aria-hidden="true"></span>
               <b class="coupon_lable"> 开始日期</b>
             </div>
          </div>
          <div class="col-md-3">
            <div class="coupon_rightdiv">
              <input type="input" name="start_time"  class="datetimepicker" check-type="notEmptyValue" <?php if ($this->_var['coupon']): ?>value="<?php echo $this->_var['coupon']['start_time']; ?>"<?php endif; ?>/>
            </div>
            <div class="warning" style="display:none;">
            该购物券在页面展示的开始时间。
            </div>
          </div>

          <div class="col-md-3 alert_format">
            <div class="alert alert-danger" role="alert">
              <p class="alert_words">
                不能为空值！ 
              </p>
            </div>
          </div>
        </div>

        <div class="row row-item other_row">
          <div class="col-md-4">
            <div class="notice_lable">
               <span class="glyphicon glyphicon-question-sign notice" aria-hidden="true"></span>
               <b class="coupon_lable"> 结束日期</b>
             </div>
          </div>
          <div class="col-md-3">
              <div class="coupon_rightdiv">
              <input type="input" name="end_time"  class="datetimepicker" check-type="notEmptyValue" <?php if ($this->_var['coupon']): ?>value="<?php echo $this->_var['coupon']['end_time']; ?>"<?php endif; ?>/>
            </div>
            <div class="warning" style="display:none;">
              该购物券在页面展示的结束时间。
            </div>
          </div>
          <div class="col-md-3 alert_format">
            <div class="alert alert-danger" role="alert">
              <p class="alert_words">
                不能为空值！ 
              </p>
            </div>
          </div>
        </div>

        <div class="row row-item other_row">
          <div class="col-md-4">
            <div class="notice_lable">
               <span class="glyphicon glyphicon-question-sign notice" aria-hidden="true"></span>
               <b class="coupon_lable">有效日期</b>
             </div>
          </div>
          <div class="col-md-3">
              <div class="coupon_rightdiv">
              <input type="input" name="validate_time"  class="datetimepicker" check-type="notEmptyValue" <?php if ($this->_var['coupon']): ?>value="<?php echo $this->_var['coupon']['validate_time']; ?>"<?php endif; ?>/>
            </div>
            <div class="warning" style="display:none;">
              该购物券过了这个时间，将不可用。
            </div>
          </div>
          <div class="col-md-3 alert_format">
            <div class="alert alert-danger" role="alert">
              <p class="alert_words">
                不能为空值！ 
              </p>
            </div>
          </div>
        </div>
        
        <div class="row row-item other_row">
          <div class="col-md-4">
            <div class="notice_lable">
               <span class="glyphicon glyphicon-question-sign notice" aria-hidden="true"></span>
               <b class="coupon_lable"> 总发放数</b>
             </div>
          </div>
          <div class="col-md-3">
              <div class="coupon_rightdiv">
              <div class="input-group">
                     <input type="input"  name="total_num_restriction" class="form-control"  placeholder="输入正整数"  check-type="positiveInteger" value="<?php if ($this->_var['coupon']): ?><?php echo $this->_var['coupon']['total_num_restriction']; ?><?php else: ?>0<?php endif; ?>" >
                     <div class="input-group-addon">张</div>
               </div>
            </div>
            <div class="warning" style="display:none;">
            该购物券，最多发放张数限制。
            </div>
          </div>
          <div class="col-md-3 alert_format">
            <div class="alert alert-danger" role="alert">
              <p class="alert_words">
                不能为空值！ 
              </p>
            </div>
          </div>          
        </div>


        <div class="row row-item other_row">
          <div class="col-md-4">
            <div class="notice_lable">
               <span class="glyphicon glyphicon-question-sign notice" aria-hidden="true"></span>
               <b class="coupon_lable"> 每天发放</b>
             </div>
          </div>
          <div class="col-md-3">
              <div class="coupon_rightdiv">
              <div class="input-group">
                     <input type="input" class="form-control" name="daily_total" placeholder="输入正整数" check-type="positiveInteger" <?php if ($this->_var['coupon']): ?>value="<?php echo $this->_var['coupon']['daily_total']; ?>"<?php else: ?>value="0"<?php endif; ?>>
                     <div class="input-group-addon">张</div>
               </div>
            </div>
            <div class="warning" style="display:none;">
            每天最多发放多少张购物券。
            </div>
          </div>
          <div class="col-md-3 alert_format">
            <div class="alert alert-danger" role="alert">
              <p class="alert_words">
                不能为空值！ 
              </p>
            </div>
          </div>          
        </div>

        <div class="row row-item other_row">
          <div class="col-md-4">
            <div class="notice_lable">
               <span class="glyphicon glyphicon-question-sign notice" aria-hidden="true"></span>
               <b class="coupon_lable"> 今天发放</b>
             </div>
          </div>
          <div class="col-md-3">
              <div class="coupon_rightdiv">
              <div class="input-group">
                     <input type="input"  name="daily_sent" class="form-control"  placeholder="输入正整数"  check-type="positiveInteger" value="<?php if ($this->_var['coupon']): ?><?php echo $this->_var['coupon']['today_sent']; ?><?php else: ?>0<?php endif; ?>" disabled>
                     <div class="input-group-addon">张</div>
               </div>
            </div>
            <div class="warning" style="display:none;">
            今天已经发放的购物券张数。
            </div>
          </div>
          <div class="col-md-3 alert_format">
            <div class="alert alert-danger" role="alert">
              <p class="alert_words">
                不能为空值！ 
              </p>
            </div>
          </div>          
        </div>


          <div class="row row-item other_row">
          <div class="col-md-4">
            <div class="notice_lable">
               <span class="glyphicon glyphicon-question-sign notice" aria-hidden="true"></span>
               <b class="coupon_lable"> 是否展示</b>
             </div>
          </div>
          <div class="col-md-3">
            <div class="coupon_rightdiv" style="margin-top:5px;">
              <?php if ($this->_var['coupon']['is_display'] == '0'): ?>
               <input type="radio" name="is_display"  checked="checked" value="1"/>是 &nbsp;&nbsp;
                <input type="radio" name="is_display" checked="" value="0"/>否　
              <?php else: ?>
                 <input type="radio" name="is_display" checked="" value="0"/>否 &nbsp;&nbsp;
                <input type="radio" name="is_display"  checked="checked" value="1"/>是
              <?php endif; ?>
              
            </div>
            <div class="warning" style="display:none;">
            如果选择是，表示该购物券将展示在可领界面上。
            </div>
          </div>
        </div>

        
         <div class="row row-item other_row" style="margin-bottom:20px;">
          <div class="col-md-4">
            <div class="notice_lable">
               <!-- <button type="submit" class="btn btn-default">确定</button> -->
               <input type="submit" class="btn btn-default" value="确定"/>
             </div>
          </div>
          <div class="col-md-3">
              <div class="coupon_rightdiv" style="margin-top:5px;">
              <button type="reset" class="btn btn-default">重置</button>
            </div>
          </div>
        </div>

      </div>



      <div class="row panel panel-default" style="margin:20px 10px 0px 10px;height:90px;">
        <?php echo $this->fetch('pagefooter.htm'); ?>
      </div>
    

    </form> 
  </body>
</html>

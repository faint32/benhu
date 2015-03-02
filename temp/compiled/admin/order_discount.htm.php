<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="styles/bootstrap/js/jquery-1.9.1.min.js"></script>
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
    function trim(str)
    { 
　　     return str.replace(/(^\s*)|(\s*$)/g, "");
　　}
    function isPositiveInteger(oNum)
    {
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
console.log($("input[name='discount_limitation']").val())
console.log($("input[name='discount_money']").val())
      if(!validOrderDiscount($("input[name='discount_limitation']").val(), $("input[name='discount_money']").val())){
        checkFlag = false;
      }
      return checkFlag;
    }
  </script>
    <form onsubmit="return checkInput();" action="order_discount.php" method="post">
      <input type="hidden" name="act" value="eidtOrderDis"/>
      <div class="row panel panel-default" style="margin:20px 10px 0px 10px;">
        <div class="container col-md-10" >
           <h3 style="text-align:left;"> <a href="index.php?act=main">ECSHOP 管理中心</a> - 满减</h3>
        </div>
     
      </div>

      <div class="panel panel-default" style="margin:20px 10px;">
       
       
        <div class="row row-item other_row">
          <div class="col-md-4">
            <div class="notice_lable">
               <span class="glyphicon glyphicon-question-sign notice" aria-hidden="true"></span>
               <b class="coupon_lable"> 活动名称</b>
             </div>
          </div>
          <div class="col-md-3">
            <div class="coupon_rightdiv">
              <input type="input" name="discount_name"  check-type="notEmptyValue" value="<?php echo $this->_var['discount_name']; ?>"/>
            </div>
            <div class="warning" style="display:none;">
            满减活动的名称!
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
              <input type="input" name="start_time"  class="datetimepicker" check-type="notEmptyValue" value="<?php echo $this->_var['start_time']; ?>"/>
            </div>
            <div class="warning" style="display:none;">
            活动开始时间。
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
              <input type="input" name="end_time"  class="datetimepicker" check-type="notEmptyValue" value="<?php echo $this->_var['end_time']; ?>"/>
            </div>
            <div class="warning" style="display:none;">
              活动结束时间。
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
                     <b class="coupon_lable"> 金额下限</b>
                   </div>
                </div>
                <div class="col-md-3">
                  <div class="coupon_rightdiv">
                      <div class="input-group">
                          <div class="input-group-addon">￥:</div>
                           <input type="input" check-type="notEmptyValue" placeholder="输入金额下限" class="form-control" class="discount_limitation" name="discount_limitation" value="<?php echo $this->_var['discount_limitation']; ?>">
                     </div>
                  </div>
                  <div class="warning" style="display:none;">
                    <div class="alert alert-warning" role="alert">金额下限：50,100  <br/>减免金额：5,11<br/>（订单满50块，可减免5块。满100块可减11块）</div>
                  </div>
                </div>
                <div class="col-md-3 alert_format">
                  <div class="alert alert-danger" role="alert">
                    <p class="alert_words">
                      不能为空！ 
                    </p>
                  </div>
                </div>
              </div>

              <div class="row row-item other_row">
                <div class="col-md-4">
                  <div class="notice_lable">
                     <span class="glyphicon glyphicon-question-sign notice" aria-hidden="true"></span>
                     <b class="coupon_lable"> 减免金额</b>
                   </div>
                </div>
                <div class="col-md-3">
                  <div class="coupon_rightdiv">
                    <div class="input-group">
                          <div class="input-group-addon">￥:</div>
                           <input type="input" check-type="notEmptyValue" placeholder="输入减免的金额" class="form-control" name="discount_money" value="<?php echo $this->_var['discount_money']; ?>">
                     </div>
                  </div>
                  <div class="warning" style="display:none;">
                     <div class="alert alert-warning" role="alert">金额下限：50,100  <br/>减免金额：5,11<br/>（订单满50块，可减免5块。满100块可减11块）</div>
                  </div>
                </div>

                <div class="col-md-3 alert_format">
                  <div class="alert alert-danger" role="alert">
                    <p class="alert_words">
                     不能为空！
                    </p>
                  </div>
                </div>
              </div>

       
         <div class="row row-item other_row" style="margin-bottom:20px;">
          <div class="col-md-4">
            <div class="notice_lable">
               <!-- <button type="submit" class="btn btn-default">确定</button> -->
               <input type="submit" class="btn btn-default" value="确定" data-toggle="modal" data-target="#myModal"/>
             </div>
          </div>
          <div class="col-md-3">
              <div class="coupon_rightdiv" style="margin-top:5px;">
              <button type="reset" class="btn btn-default">重置</button>
            </div>
          </div>
        </div>

      </div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">提交失败！</h4>
      </div>
      <div class="modal-body">
         请检查数据是否填写错误。
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">确定</button>
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

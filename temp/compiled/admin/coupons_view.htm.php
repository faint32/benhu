<!--<?php if ($this->_var['full_page']): ?>-->
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="styles/bootstrap/js/jquery.min.js"></script>
    <script src="styles/bootstrap/js/bootstrap.min.js"></script>

    <script src="../js/utils.js"></script>
    <script src="../js/transport3.js"></script>
    <script src="js/listtable.js"></script>
   
    <link rel="stylesheet" href="styles/bootstrap/css/bootstrap.min.css">
     <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/bootstrap/css/sundries.css">
  </head>
  <body>
     <div class="row panel panel-default" style="margin:20px 10px 0px 10px;">
      <div class="container col-md-10" >
         <h3 style="text-align:left;"> 
            <a href="index.php?act=main">ECSHOP 管理中心</a> - 购物券
         </h3>
      </div>
      <div class="col-md-2">
         <a style="margin:14px 8px 8px 8px;" role="button" class="btn btn-default btn-lg" href="coupons.php?act=list">
           <span aria-hidden="true" class="glyphicon glyphicon-plus-sign"></span>&nbsp;返回列表页
         </a>
      </div>
    </div>
<!--<?php endif; ?>-->
<div id="listDiv">
  <!--<?php if ($this->_var['coupons']): ?>-->
      <div id="coupons_list" class="row panel panel-default" style="margin:20px 10px ">
         <table class="table table-bordered table-hover text-center table-condensed" style="border-bottom:1px solid #ddd;">
           <thead>
              <tr>
                <th class="text-center">
                    <a href="javascript:listTable.sort('sent_coupon_id');" title="点击对列表排序">   购物券编号 <?php echo $this->_var['sort_sent_coupon_id']; ?> 
                      </span>
                    </a>
                </th>
                 <th class="text-center"><a href="javascript:listTable.sort('user_id');" title="点击对列表排序">所属用户id<?php echo $this->_var['sort_user_id']; ?> </a></th>
                 <th class="text-center">
                  <a href="javascript:listTable.sort('user_got_time');"  title="点击对列表排序">获得时间<?php echo $this->_var['sort_user_got_time']; ?></a>
                 </th>  
                 <th class="text-center">
                  <a href="javascript:listTable.sort('validate_time');"  title="点击对列表排序">有效期<?php echo $this->_var['sort_validate_time']; ?></a>
                 </th>  
                 <th class="text-center"><a href="javascript:listTable.sort('is_used');" title="点击对列表排序">是否使用<?php echo $this->_var['sort_is_used']; ?></a></th>
                 <th class="text-center"><a href="javascript:listTable.sort('used_time');"  title="点击对列表排序">使用时间<?php echo $this->_var['sort_used_time']; ?></a></th>
                 <th class="text-center"><a href="javascript:listTable.sort('order_id');" title="点击对列表排序">订单号<?php echo $this->_var['sort_order_id']; ?></a></th>
                 <th class="text-center">操作</th>
              </tr>
           </thead>
           <tbody>
            <!--<?php $_from = $this->_var['coupons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>-->
              <tr>
                <td><?php echo $this->_var['item']['sent_coupon_id']; ?></td>
                <td>
                  <?php echo $this->_var['item']['user_id']; ?>
                </td>
                <td>             
                  <?php echo $this->_var['item']['user_got_time']; ?>
                </td>
                <td>             
                  <?php echo $this->_var['item']['validate_time']; ?>
                </td>
                <td>                
                   <?php echo $this->_var['item']['is_used']; ?>
                </td>
                <td>             
                  <?php echo $this->_var['item']['used_time']; ?>
                </td>
                <td>
                  <?php echo $this->_var['item']['order_id']; ?>
                </td>
                <td>
                  <a href="javascript:listTable.remove(<?php echo $this->_var['item']['sent_coupon_id']; ?>, '您确认要删除这条记录吗? \nps:删除后用户将失去该购物券！')">删除</a>
                </td>
              </tr>
            <!--<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>-->
           </tbody>
        </table>
        <?php echo $this->_var['pagination']; ?>
      </div>
  <!--<?php else: ?>-->
        <div id="coupons_empty" class="row panel panel-default" style="margin:20px 10px">
          <div class="alert alert-warning" role="alert" style="margin:0px 0px;">
            <strong>无购物券！</strong> 去添加购物券吧。
          </div>
        </div>
  <!--<?php endif; ?>-->
</div>

   

<!--<?php if ($this->_var['full_page']): ?>-->
 <script>
        listTable.recordCount = '<?php echo $this->_var['record_count']; ?>';
        listTable.pageCount = '<?php echo $this->_var['page_count']; ?>';
        <?php $_from = $this->_var['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
        listTable.filter.<?php echo $this->_var['key']; ?> = '<?php echo $this->_var['item']; ?>';
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </script>
       <div class="row panel panel-default" style="margin:20px 10px 0px 10px;height:90px;">
        <?php echo $this->fetch('pagefooter.htm'); ?>
      </div>
  
  </body>
</html>
<!--<?php endif; ?>-->
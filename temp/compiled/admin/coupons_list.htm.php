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
         <h3 style="text-align:left;"> <a href="index.php?act=main">ECSHOP 管理中心</a> - 购物券</h3>
      </div>
      <div class="col-md-2" >
         <a href="coupons.php?act=add" class="btn btn-default btn-lg" role="button" style="margin:14px 8px 8px 8px;">
           <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;添加购物券
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
                  <a href="javascript:listTable.sort('coupon_id');" title="点击对列表排序">   编号 <?php echo $this->_var['sort_coupon_id']; ?> 
                    </span>
                  </a>
              </th>
               <th class="text-center"><a href="javascript:listTable.sort('coupon_name');" title="点击对列表排序">购物券名称<?php echo $this->_var['sort_coupon_name']; ?> </a></th>
               <th class="text-center">
                <a href="javascript:listTable.sort('coupon_description');"  title="点击对列表排序">描述<?php echo $this->_var['sort_coupon_description']; ?></a>
               </th>  
               <th class="text-center"><a href="javascript:listTable.sort('coupon_value');" title="点击对列表排序">面值<?php echo $this->_var['sort_coupon_value']; ?></a></th>
               <th class="text-center"><a href="javascript:listTable.sort('restriction_ext');"  title="点击对列表排序">订单金额限制<?php echo $this->_var['sort_restriction_ext']; ?></a></th>
               <th class="text-center"><a href="javascript:listTable.sort('start_time');" title="点击对列表排序">开始日期<?php echo $this->_var['sort_start_time']; ?></a></th>
               <th class="text-center"><a href="javascript:listTable.sort('end_time');" title="点击对列表排序">结束日期<?php echo $this->_var['sort_end_time']; ?></a></th>
                <th class="text-center"><a href="javascript:listTable.sort('validate_time');" title="点击对列表排序">有效日期<?php echo $this->_var['sort_validate_time']; ?></a></th>
                <th class="text-center"><a href="javascript:listTable.sort('total_num_restriction');" title="点击对列表排序">总发放数限制<?php echo $this->_var['sort_total_num_restriction']; ?></a></th>
               <th class="text-center"><a href="javascript:listTable.sort('daily_total');" title="点击对列表排序">每天发放数<?php echo $this->_var['sort_daily_total']; ?></a></th>
               <th class="text-center"><a href="javascript:listTable.sort('today_sent');" title="点击对列表排序">今天已发放<?php echo $this->_var['sort_today_sent']; ?></a></th>
               <th class="text-center"><a href="javascript:listTable.sort('is_display');" title="点击对列表排序">展示<?php echo $this->_var['sort_is_display']; ?></a></th>
               <th class="text-center">操作</th>
            </tr>
         </thead>
         <tbody>
          <!--<?php $_from = $this->_var['coupons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>-->
            <tr>
              <td><?php echo $this->_var['item']['coupon_id']; ?></td>
              <td>
                <span onclick="listTable.edit(this, 'edit_coupon_name', <?php echo $this->_var['item']['coupon_id']; ?>)" title="点击修改内容" ><?php echo $this->_var['item']['coupon_name']; ?></span>
              </td>
              <td>
                <span onclick="listTable.edit(this, 'edit_coupon_description', <?php echo $this->_var['item']['coupon_id']; ?>)" title="点击修改内容" >
                <?php echo $this->_var['item']['coupon_description']; ?>
                </span>
              </td>
              <td>
                <span onclick="listTable.edit(this, 'edit_coupon_value', <?php echo $this->_var['item']['coupon_id']; ?>)" title="点击修改内容" >
                 <?php echo $this->_var['item']['coupon_value']; ?>
                </span>
              </td>
              <td>
                <span onclick="listTable.edit(this, 'edit_restriction_ext', <?php echo $this->_var['item']['coupon_id']; ?>)" title="点击修改内容" >
                <?php echo $this->_var['item']['restriction_ext']; ?>
                </span>
              </td>
              <td>
                <?php echo $this->_var['item']['start_time']; ?>
              </td>
              <td><?php echo $this->_var['item']['end_time']; ?></td>
               <td><?php echo $this->_var['item']['validate_time']; ?></td>
                <td>
                <span onclick="listTable.edit(this, 'edit_total_num_restriction', <?php echo $this->_var['item']['coupon_id']; ?>)" title="点击修改内容" >
                  <?php echo $this->_var['item']['total_num_restriction']; ?>
                </span>
              </td>
              <td>
                <span onclick="listTable.edit(this, 'edit_daily_total', '<?php echo $this->_var['item']['coupon_id']; ?>')" title="点击修改内容" >
                  <?php echo $this->_var['item']['daily_total']; ?>
                </span>
              </td>
              <td>
                  <?php echo $this->_var['item']['today_sent']; ?>
              </td>
              <td>
                <?php if ($this->_var['item']['is_display'] == '1'): ?>
                <span onclick="listTable.bootstrap_toggle(this, 'toggle_display', '<?php echo $this->_var['item']['coupon_id']; ?>')" class="glyphicon glyphicon-ok" aria-hidden="true" status="yes" title="点击修改内容">
                </span>
                <?php else: ?>
                <span onclick="listTable.bootstrap_toggle(this, 'toggle_display', '<?php echo $this->_var['item']['coupon_id']; ?>')" class="glyphicon glyphicon-remove" aria-hidden="true" status="no">
                </span>
                <?php endif; ?>
              </td>
              <td>
                <a href="coupons.php?act=view&id=<?php echo $this->_var['item']['coupon_id']; ?>">查看</a>|
                <a href="coupons.php?act=add&id=<?php echo $this->_var['item']['coupon_id']; ?>">编辑</a>|
                <a href="javascript:listTable.remove(<?php echo $this->_var['item']['coupon_id']; ?>, '您确认要删除这条记录吗?')">移除</a>
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
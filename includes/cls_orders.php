<?php
   class order_list{
      var $pager;
	  var $elem_count;
	  var $orders;
	  var $where;
	  var $info; 
      var $comment;	  
     public function __construct(){
	  $this->pager  = array();
	  $this->orders = array();
	  $this->elem_count = 6;
	  
	  $this->where=array();
	  $this->where[0]=' and is_delete = 0 ';
	  $this->where[1]=' and order_status = 0 and shipping_status = 0 and pay_status = 0 and is_delete = 0 ';
	  $this->where[2]=' and order_status = 1 and shipping_status = 0 and pay_status = 2 and is_delete = 0 ';
	  $this->where[3]=' and order_status = 5 and shipping_status = 1 and pay_status = 2 and is_delete = 0 ';
	  $this->where[4]=' and order_status = 5 and shipping_status = 2 and pay_status = 2 and is_delete = 0 ';
	  $this->where[5]=' and order_status = 5 and shipping_status = 2 and pay_status = 2 and is_delete = 0 ';
	  //$this->where[6]=' and order_status = 2 and shipping_status = 0 and pay_status = 0 and is_delete = 0 ';
	  
	  $this->comment=array();
	  $this->comment[0]=0;
	  $this->comment[1]=0;
	  $this->comment[2]=0;
	  $this->comment[3]=0;
	  $this->comment[4]=2; //待评价的订单,需关联comment表
	  $this->comment[5]=1; //已评价的订单,需关联comment表
	  
	  $this->info=array();
	  $this->info[0]='已提交';
	  $this->info[1]='待付款';
	  $this->info[2]='待发货';
	  $this->info[3]='待收货';
	  $this->info[4]='待评价';
	  $this->info[5]='已完成';
	//  $this->info[6]='已取消';
	 }
	 
	// public $page;
   //  public $page_count;
	
   }
 /*  
   已提交
待付款  ' and pay_status=0 and order_status='.OS_UNCONFIRMED
待发货  ' and pay_status=2 and shipping_status=0 '
待收货  ' and pay_status=2 and shipping_status=1 '
待评价  ' and pay_status=2 and shipping_status=2 '
已完成  ' and pay_status=2 and shipping_status=2 '
已取消  ' and order_status='.OS_CANCELED
*/
?>
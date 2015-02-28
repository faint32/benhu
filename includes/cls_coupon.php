<?php
define('IN_ECS',1);
require_once('lib_time.php');
  class coupon
  {
    private $coupon_name;
    private $coupon_description;
  	private $isUsed;
  	private $couponValue;
  	private $validateTime;
    private $coupon_value;
    private $restriction_ext;
    public static $couponsConditions;

  	function __construct($Coupon_name, $Coupon_description, $IsUsed, $CouponValue, $ValidateTime, $Coupon_value, $Restriction_ext)
  	{
  		$this->coupon_name = $Coupon_name;
      $this->coupon_description = $Coupon_description;
      $this->isUsed = $IsUsed;
      $this->couponValue = $CouponValue;
      $this->validateTime = $ValidateTime;
      $this->coupon_value = $Coupon_value;
      $this->restriction_ext = $Restriction_ext;
  	}

    function __destory()
    {
      echo "This is __destory function!";
    }

    public function __get($property) 
    {
      if (property_exists($this, $property)) 
      {
        return $this->$property;
      }
    }

    public function __set($property, $value) 
    {
      if (property_exists($this, $property)) 
      {
        $this->$property = $value;
      }

      return $this;
    }
    public static function getCouponsConditions($type = '')
    {
      $con = array("notUsed" => "is_used = 0 AND validate_time > ".gmtime(), "used" => "is_used = 1", "invalid" => "is_used = 0 AND validate_time <= ".gmtime());

      if(empty($type))
      {
        return $con;
      }
      return $con[$type]; 
    }
  }
  

  // $coupons_list = array();

  // for ($i=0; $i < 10; $i++) { 
  // 	$newCoupon = new coupon($i,$i,$i,$i,$i,$i,$i);

  //   $newCoupon->__set('validateTime', gmtime());
  // 	$coupons_list[] = $newCoupon;
   
  // }
  // var_dump($coupons_list);


?>

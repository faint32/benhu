/* $Id : region.js 4865 2007-01-31 14:04:10Z paulgao $ */

var region = new Object();

region.isAdmin = false;

region.loadRegions = function(parent, type, target, def_type)
{
	//alert(region.getFileName())
  Ajax.call(region.getFileName(), 'type=' + type + '&target=' + target + "&parent=" + parent +"&def_type="+def_type, region.response, "GET", "JSON");
}

/* *
 * 载入指定的国家下所有的省份
 *
 * @country integer     国家的编号
 * @selName string      列表框的名称
 */
region.loadProvinces = function(country, selName)
{
  var objName = (typeof selName == "undefined") ? "selProvinces" : selName;

  region.loadRegions(country, 1, objName);
}

/* *
 * 载入指定的省份下所有的城市
 *
 * @province    integer 省份的编号
 * @selName     string  列表框的名称
 */
region.loadCities = function(province, selName)
{
  var objName = (typeof selName == "undefined") ? "selCities" : selName;

  region.loadRegions(province, 2, objName);
}

/* *
 * 载入指定的城市下的区 / 县
 *
 * @city    integer     城市的编号
 * @selName string      列表框的名称
 */
region.loadDistricts = function(city, selName)
{
  var objName = (typeof selName == "undefined") ? "selDistricts" : selName;

  region.loadRegions(city, 3, objName);
}

/* *
 * 处理下拉列表改变的函数
 *
 * @obj     object  下拉列表
 * @type    integer 类型
 * @selName string  目标列表框的名称
 * @def_val int     下拉后下个框默认选择的值 chen-0912
 */
region.changed = function(obj, type, selName, def_val)
{
  var parent = obj.options[obj.selectedIndex].value;

 def_val = (typeof (def_val) != 'undefined')? def_val:0;

 
  region.loadRegions(parent, type, selName,def_val);
}

region.response = function(result, text_result)
{
  var sel = document.getElementById(result.target);

  sel.length = 1;
  sel.selectedIndex = 0;
  sel.style.display = (result.regions.length == 0 && ! region.isAdmin && result.type + 0 == 3) ? "none" : '';

  if (document.all)
  {
    sel.fireEvent("onchange");
  }
  else
  {
    var evt = document.createEvent("HTMLEvents");
    evt.initEvent('change', true, true);
    sel.dispatchEvent(evt);
  }

  if (result.regions)
  {
	 
	  var eflag = 0; //默认的onchange函数可能已经改变了,result.def_type值可能不为0，但下拉匹配不到
    for (i = 0; i < result.regions.length; i ++ )
    {
      var opt = document.createElement("OPTION");
      opt.value = result.regions[i].region_id;
      opt.text  = result.regions[i].region_name;
        
		if(opt.value == result.def_type) //标记result.def_type能否匹配到
		{
	      eflag = 1;
	    }
      sel.options.add(opt);
    }
	//alert(1)
	if(eflag==1)
	sel.value=result.def_type; //设为默认值 chen-0912

	//alert(result.def_type)

	if(result.def_type !=0 )  //默认值不为0，触发onchange事件
	{
	  sel.dispatchEvent(evt); 
	}
  }
}

region.getFileName = function()
{
  if (region.isAdmin)
  {
    return "../region.php";
  }
  else
  {
    return "region.php";
  }
}

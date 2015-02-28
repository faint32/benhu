function another_batch(ele_id, extra_info)
{

  if(extra_info[0] == 'index_babyGrowth')
  {
  var age = extra_info[1];
  var cat_id = extra_info[2];
  
    Ajax.call( 'index.php?act=babyGrowth', 'ele_id=' + ele_id + '&age_index=' + age + '&cat_id=' + cat_id, anotherBatch_callback , 'GET', 'json', true, true );
  }
}
function anotherBatch_callback(result)
{
var ele_id = result.ele_id
var json = result.goods
var html = ''
for(var i=0; i<json.length; i++) 
{ 
html += '<dl><dt><a target="_blank" href="'+json[i].url+'"><img width="178" height="178" src="'+json[i].goods_thumb+'"></a></dt><dd><a title="'+json[i].goods_name+'" target="_blank" href="goods.php?id='+json[i].goods_id+'">'+json[i].goods_name+'</a><span class="main_2_left_price1">￥'+json[i].shop_price+'</span><span class="main_2_left_price2">￥'+json[i].market_price+'</span></dd></dl>'
} 
$('#'+ele_id).html(html)
}
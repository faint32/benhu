<?php if ($this->_var['comments']): ?>
     
    <?php $_from = $this->_var['comments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'comment');$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from AS $this->_var['comment']):
        $this->_foreach['loop']['iteration']++;
?>
    <div class="item_appraise">
            	 <dl>
                    <dd><?php if ($this->_var['comment']['username']): ?><?php echo htmlspecialchars($this->_var['comment']['username']); ?><?php else: ?><?php echo $this->_var['lang']['anonymous']; ?><?php endif; ?></dd>
		    <dt><img width="52" height="27" src="<?php echo $this->_var['comment']['rank_portrait']; ?>"></dt>
                </dl>
                <ul>
               	  <li class="item_appraise_a"><?php echo $this->_var['comment']['content']; ?></li>
				  <?php if ($this->_var['comment']['thumbs']): ?>
				           <div class="shaidan">
	<script  type="text/javascript">
		 
		 
		$(document).ready(function(){
			$('.shaidan_pic').each(function(shaidan_index){
			var len = $('.shaidan_pic').length;
		        $("#shaidan_" + shaidan_index + " > li").each(function(li_index){
				
				 $(this).click(function(){
				 
				 if( !$(this).val())
                 $(this).val(0);
			     $(this).val( $(this).val() + 1);
				
				    if($(this).val() == 2*len )
					{				
					 $(this).find('img').css('cursor',"url(http://www.benhu.com/style/cursor/zoom_in.png),url(http://www.benhu.com/style/cursor/zoom_in.cur),auto");
					  $('#shaidan_pic_'+shaidan_index).hide();
					    $(this).val(0);
					}
					 else if($(this).val() == len)
				    {
				$('.shaidan_pic li a img').css('cursor',"url(http://www.benhu.com/style/cursor/zoom_in.png),url(http://www.benhu.com/style/cursor/zoom_in.cur),auto");
				$(this).find('img').css('cursor',"url(http://www.benhu.com/style/cursor/zoom_out.png),url(http://www.benhu.com/style/cursor/zoom_out.cur),auto");		     
					$('#shaidan_pic_'+shaidan_index +' img').attr('src',$(this).find('img').attr('src'));
				      $('#shaidan_pic_'+shaidan_index).show();
					  
					
					}
			
			
			
				  });
				});
		    });
	});
		  
		</script>
		
    	<ul class="shaidan_pic" id="shaidan_<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>">
		     <?php $_from = $this->_var['comment']['thumbs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'thumb');$this->_foreach['li'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['li']['total'] > 0):
    foreach ($_from AS $this->_var['thumb']):
        $this->_foreach['li']['iteration']++;
?>
			    <li><a href="javascript:void(0)"><img id="pic_<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>_<?php echo ($this->_foreach['li']['iteration'] - 1); ?>" src="<?php echo $this->_var['thumb']['thumb']; ?>" width="100" height="100" /></a></li>  
			 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        	
        </ul>
        <div class="shaidan_a" id="shaidan_pic_<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>" style="display:none">
               	<img id="big_pic_<?php echo ($this->_foreach['loop']['iteration'] - 1); ?>" src="<?php echo $this->_var['thumb']['thumb']; ?>"  /> 
				</div>
        </div>
			<?php endif; ?>			  
                  <li class="item_appraise_b" style="text-align:right"><?php echo $this->_var['comment']['add_time']; ?></li>
                    <?php if ($this->_var['comment']['re_content']): ?>
                  <p class="item_appraise_d"><span>客服回复：<?php echo $this->_var['comment']['re_content']; ?></span></p>
                    <?php endif; ?>
              </ul>

   </div>
    
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    
     
    
    
		<div class="page_box">
			<div class="page">
				<?php if ($this->_var['pager']['page'] != 1): ?>
					<a href="<?php echo $this->_var['pager']['page_prev']; ?>"><?php echo $this->_var['lang']['page_prev']; ?></a>
				<?php endif; ?>
				<?php $_from = $this->_var['pager']['page_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item_0_37431300_1425287072');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item_0_37431300_1425287072']):
?>
					<?php if ($this->_var['key'] == $this->_var['pager']['page']): ?>
						<span class="current"><?php echo $this->_var['key']; ?></span>
					<?php else: ?>
						<a href="<?php echo $this->_var['item_0_37431300_1425287072']; ?>"><?php echo $this->_var['key']; ?></a>
					<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				<?php if ($this->_var['pager']['page'] != $this->_var['pager']['page_count']): ?>
					<a href="<?php echo $this->_var['pager']['page_next']; ?>"><?php echo $this->_var['lang']['page_next']; ?></a>
				<?php endif; ?>
			</div>
		</div>
    
    
    <div class="clear"></div>
  </div>
</div>
<?php else: ?>
<div class="item_nothing">还没人来评论噢！ </div>
<?php endif; ?>

<div class="blank5"></div>


<div id="comment_show" style="width: 666px; height: 283px; display:none;" class=" jqmID1">
  <div class="popbox" style="background:none; width:664px; margin-left:-332px;">
    <div class="popc" style="width:664px;">
      <h2 id="easyDialogTitle"><a class="popwinClose" href="#">关闭</a>发表评论</h2>
      <div class="commentsList stat_box" >
        <form action="javascript:;" onsubmit="submitComment(this)" method="post" name="commentForm" id="commentForm">
          <table width="606" border="0" cellspacing="5" cellpadding="0" >
            <tr width="606">
              <td width="66" align="right"><?php echo $this->_var['lang']['username']; ?>：</td>
              <td<?php if (! $this->_var['enabled_captcha']): ?><?php endif; ?>><?php if ($_SESSION['user_name']): ?><?php echo $_SESSION['user_name']; ?><?php else: ?><?php echo $this->_var['lang']['anonymous']; ?><?php endif; ?></td>
            </tr>
            <tr>
              <td align="right">E-mail：</td>
              <td><input type="text" name="email" id="email"  maxlength="100" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" class="inputBorder"/></td>
            </tr>
            <tr>
              <td align="right"><?php echo $this->_var['lang']['comment_rank']; ?>：</td>
              <td><input name="comment_rank" type="radio" value="1" id="comment_rank1" />
              <span class="star s1"></span>
 
                <input name="comment_rank" type="radio" value="2" id="comment_rank2" />
                  <span class="star s2"></span>
                <input name="comment_rank" type="radio" value="3" id="comment_rank3" />
                  <span class="star s3"></span>
                <input name="comment_rank" type="radio" value="4" id="comment_rank4" />
          <span class="star s4"></span>
                <input name="comment_rank" type="radio" value="5" checked="checked" id="comment_rank5" />
                  <span class="star s5"></span></td>
            </tr>
            <tr>
              <td align="right" valign="top"><?php echo $this->_var['lang']['comment_content']; ?>：</td>
              <td><textarea name="content" class="inputBorder" style="height:100px; width:480px;"></textarea>
                <input type="hidden" name="cmt_type" value="<?php echo $this->_var['comment_type']; ?>" />
                <input type="hidden" name="id" value="<?php echo $this->_var['id']; ?>" /></td>
            </tr>
            <tr>
              <td colspan="2"><?php if ($this->_var['enabled_captcha']): ?>
                
                <div style="padding-left:15px; text-align:left; float:left;"> <?php echo $this->_var['lang']['comment_captcha']; ?>：
                  <input type="text" name="captcha"  class="inputBorder" style="width:50px; margin-left:5px; margin-top:3px;"/>
                  <img src="captcha.php?<?php echo $this->_var['rand']; ?>" alt="captcha" onClick="this.src='captcha.php?'+Math.random()" class="captcha"> </div>
                
                <?php endif; ?>
                
                <input type="submit" class="red_btn_2" value="提交评论"></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>

 

<script type="text/javascript">
//<![CDATA[
<?php $_from = $this->_var['lang']['cmt_lang']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item_0_38015200_1425287072');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item_0_38015200_1425287072']):
?>
var <?php echo $this->_var['key']; ?> = "<?php echo $this->_var['item_0_38015200_1425287072']; ?>";
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

/**
 * 提交评论信息
*/
function submitComment(frm)
{
  var cmt = new Object;

  //cmt.username        = frm.elements['username'].value;
  cmt.email           = frm.elements['email'].value;
  cmt.content         = frm.elements['content'].value;
  cmt.type            = frm.elements['cmt_type'].value;
  cmt.id              = frm.elements['id'].value;
  cmt.enabled_captcha = frm.elements['enabled_captcha'] ? frm.elements['enabled_captcha'].value : '0';
  cmt.captcha         = frm.elements['captcha'] ? frm.elements['captcha'].value : '';
  cmt.rank            = 0;

  for (i = 0; i < frm.elements['comment_rank'].length; i++)
  {
    if (frm.elements['comment_rank'][i].checked)
    {
       cmt.rank = frm.elements['comment_rank'][i].value;
     }
  }

//  if (cmt.username.length == 0)
//  {
//     alert(cmt_empty_username);
//     return false;
//  }

  if (cmt.email.length > 0)
  {
     if (!(Utils.isEmail(cmt.email)))
     {
        alert(cmt_error_email);
        return false;
      }
   }
   else
   {
        alert(cmt_empty_email);
        return false;
   }

   if (cmt.content.length == 0)
   {
      alert(cmt_empty_content);
      return false;
   }

   if (cmt.enabled_captcha > 0 && cmt.captcha.length == 0 )
   {
      alert(captcha_not_null);
      return false;
   }
   Ajax.call('comment.php', 'cmt=' + $.toJSON(cmt), commentResponse, 'POST', 'JSON');
   return false;
}

/**
 * 处理提交评论的反馈信息
*/
  function commentResponse(result)
  {
    if (result.message)
    {
      alert(result.message);
    }

    if (result.error == 0)
    {
      var layer = document.getElementById('ECS_COMMENT');

      if (layer)
      {
        layer.innerHTML = result.content;
      }
    }
  }

//]]>
</script>

<?php if ($this->_var['ad_userCenter']['media_type'] == 0): ?>
    <a  style="float:left" href="<?php echo $this->_var['ad_userCenter']['ad_link']; ?>" target="_blank">
		<img src="data/afficheimg/<?php echo $this->_var['ad_userCenter']['ad_code']; ?>" width="364px" height="100px" border="0">
	</a>
  <?php elseif ($this->_var['ad_userCenter']['media_type'] == 1): ?>
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="360" height="100">
      <param name="movie" value="data/afficheimg/<?php echo $this->_var['ad_userCenter']['ad_code']; ?>" />
      <param name="quality" value="high" />
      <embed src="data/afficheimg/<?php echo $this->_var['ad_userCenter']['ad_code']; ?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="364px" height="100px"></embed>
    </object>
  <?php elseif ($this->_var['ad_userCenter']['media_type'] == 2): ?>
    <?php echo $this->_var['ad_userCenter']['ad_code']; ?>
  <?php elseif ($this->_var['ad_userCenter']['media_type'] == 3): ?>
    <a style="float:left" href="<?php echo $this->_var['ad_userCenter']['ad_link']; ?>" target="_blank"><?php echo $this->_var['ad_userCenter']['ad_code']; ?></a>
  <?php endif; ?>

function addPriceLadder(fromPage,apendElmId)
{
  var apendElms = getElms(fromPage);
  $('#' + apendElmId).append(apendElms);
}

function getElms(fromPage)
{
  var htmlText = '';
  switch(fromPage)
  {
    case 'order_discount':
      htmlText += '<hr/>';
      htmlText += $('#firstLadder').html();
    break;
  }
  return htmlText;
}
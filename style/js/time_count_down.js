$(function(){
    handleEndActivity()
	//*
    setInterval(function(){
		notStartedActivityEvents()
		startedActivityEvents()
		
	},100)
	//*/
})

function handleEndActivity()
{
  var times = 0
   for(var i = 1; i <= 3; i++ )
   {
		var $currShangouMainDl = $('#activity'+i + ' .shangou_main dl')
		var expectedEndNum = $currShangouMainDl.length
		var compareNum = 0
		$currShangouMainDl.each(function(){
		  if( isCurrSingleGoodActiEnd($(this)) )
		   {
				changeStatusFromNotstartToEnd($(this))
				compareNum++
		   }
		})
		if(expectedEndNum == compareNum)
		{
			//console.log('end_activity:'+i)
		   times++
		//   exchangeActivityLocation()
		}
		//console.log(expectedEndNum)
   }
   while(times--)
   {
	exchangeActivityLocation()
   }
}

function notStartedActivityEvents()
{
   $('.notStarted').each(function(){
		var start_time = parseInt($(this).attr('start-time'))
		if( (start_time - gmTime()) < 0 )
		{
		   changeStatusFromNotstartToStart( $(this) )
		}
   })
} 

function startedActivityEvents()
{
	 $('.started').each(function(){	
		if(isCurrSingleGoodActiEnd($(this)) )
		{
		   changeStatusFromStartToEnd( $(this) )
		}
		else
		{
		   var restTime = calcRestTime($(this))
		   $(this).children('dt').children('.grouptab_time').html('剩余时间：' + restTime[0] + '小时' + restTime[1] + '分' + restTime[2] + '秒')
		}
	    
   })
}


function changeStatusFromNotstartToStart(elm)
{    
	elm.removeClass('notStarted')
	elm.children('.kaishi_time').remove()
	
	var countDownHtml = elm.children('dt').html()
	var restTime = calcRestTime(elm)
	//console.log('restTime==' + restTime)
	countDownHtml = '<div class="grouptab_time">剩余时间：' + restTime[0] + '小时' + restTime[1] + '分' + restTime[2] + '秒</div>' + countDownHtml
	elm.children('dt').html(countDownHtml)
	
	elm.addClass('started')
}

function changeStatusFromNotstartToEnd(elm)
{    
	elm.removeClass('notStarted')
	elm.children('.kaishi_time').remove()
	
	elm.find('.button').addClass('button_1')
	elm.find('.button').removeClass('button')
	var endHtml = elm.html()
	endHtml =  '<div class="maiguang"></div>' + endHtml
	elm.html(endHtml)
}


function changeStatusFromStartToEnd(elm)
{
	elm.removeClass('started')
	elm.find('.button').addClass('button_1')
	elm.find('.button').removeClass('button')
	elm.children('dt').children('.grouptab_time').remove()
	
	
	var endHtml = elm.html()
	endHtml =  '<div class="maiguang"></div>' + endHtml
	elm.html(endHtml)	
	
	if(isCurrActivityEnd(elm))
	{
	  //alert(gmDate( parseInt(elm.attr('end-time'))) )
	   exchangeActivityLocation()
	}
}

function isCurrSingleGoodActiEnd(elm)
{
   var end_time = parseInt(elm.attr('end-time'))
   
   if( (end_time - gmTime()) < 0 )
   {
     return true;
   }
   return false;
}

function isCurrActivityEnd(elm)
{
   var $shangou_main = elm.parent()
   if($shangou_main.children('dl').length == $shangou_main.children('dl').children('.maiguang').length)
   {
      return true;
   }
   return false;
}

function exchangeActivityLocation()
{
console.log('exchangeActivityLocation')
  var tmp = $('#activity1').html()
  $('#activity1').html($('#activity2').html())
  $('#activity2').html($('#activity3').html())
  $('#activity3').html(tmp)
}

function calcRestTime(elm)
{
    var now_time = gmTime()
	var endTime = parseInt( elm.attr('end-time') )
	
	var restTotalSce = endTime - now_time
	var restHour = Math.floor( restTotalSce / 3600 )
	var restMin = Math.floor( (restTotalSce / 60 ) % 60 )
	var restSce =  Math.floor( restTotalSce  % 60 )
	return new Array(restHour,restMin,restSce)
}


function gmDate(unixtime) {
    var timestr = new Date(parseInt(unixtime + 8*60*60) * 1000);
    var datetime = timestr.toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
    return datetime;
}

function gmTime()
{
   var nowTime = new Date();
   return (parseInt( nowTime.getTime() / 1000.0 ) - 8*60*60)
}

<%

Dim temp
dim temp1
Dim temp2
Dim temp3


savePath = "./"  '存储路径
savePicName = ToUnixTime()  '存储图片名称

file_src = savePath&savePicName&"_src.jpg"
filename162 = savePath&savePicName&"_162.jpg"
filename48 = savePath&savePicName&"_48.jpg"
filename20 = savePath&savePicName&"_20.jpg"


temp = request.Form("pic")
temp1 = request.Form("pic1")
temp2 = request.Form("pic2")
temp3 = request.Form("pic3")

if temp=""  Then
Else
src = base64Decode(temp)
call Save2Local(src,server.MapPath(file_src))
end If


data1 = base64Decode(temp1)
data2 = base64Decode(temp2)
data3 = base64Decode(temp3)


call Save2Local(data1,server.MapPath(filename162))
call Save2Local(data2,server.MapPath(filename48))
call Save2Local(data3,server.MapPath(filename20))

Response.write("{""status"":1,""picUrl"":"""&savePath&savePicName&"""}")




function Save2Local(imgs,tofile) 
Set objStream = Server.CreateObject("ADODB.Stream") 
objStream.Type =1 
objStream.Open 
objstream.write imgs 
objstream.SaveToFile tofile,2 
objstream.Close() 
set objstream=nothing 
end function 

Function ToUnixTime()
	strTime = Now()
	intTimeZone = +8
    If IsEmpty(strTime) or Not IsDate(strTime) Then strTime = Now        
    If IsEmpty(intTimeZone) or Not isNumeric(intTimeZone) Then intTimeZone = 0        
     ToUnixTime = DateAdd("h",-intTimeZone,strTime)        
     ToUnixTime = DateDiff("s","1970-1-1 0:0:0", ToUnixTime)        
End Function       


 function Base64Encode(strData)
    dim objAds,objXd
    set objAds=createobject("adodb.stream")
    objAds.Type=2
    objAds.charset="unicode"
    objAds.mode=3
    call objAds.open()
    objAds.writeText strData
    objAds.Position=0
    objAds.Type=1
    'objAds.Position=2
 
    set objXd=createobject("msxml.domdocument")
    call objXd.loadXml("<root/>")
    objXd.DocumentElement.DataType="bin.base64"
    objXd.DocumentElement.NodeTypedValue=objAds.read()
    Base64Encode=objXd.DocumentElement.text
end function
 
function Base64Decode(strData)
    dim objXd
    set objXd=createobject("msxml.domdocument")
    call objXd.loadXml("<root/>")
    objXd.DocumentElement.DataType="bin.base64"
    objXd.DocumentElement.text=strData
    Base64Decode=objXd.DocumentElement.NodeTypedValue
end function
%>
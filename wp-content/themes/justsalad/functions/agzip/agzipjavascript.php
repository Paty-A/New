<?
echo '<script type="text/javascript">

function autoFill(city, state)
{
   document.getElementById("field7").value = (city);
   document.getElementById("field8").value = (state);
   document.getElementById("address").style.display = "block";
}

var xmlhttp

function getZipInfo(){
str = document.getElementById("field6").value;
	if (str.length<5){
	  return;
	}
xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null){
	  alert ("Your browser does not support XMLHTTP!");
	  return;
  }
var url="'.get_bloginfo('template_url').'/functions/agzip/agzipfinder.php";
url=url+"?q="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=stateChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateChanged()
{
if (xmlhttp.readyState==4)
  {
  	if(xmlhttp.responseText=="false"){
		autoFill("", "");
	}
	else{
//		alert("Response Text is "+xmlhttp.responseText);
		results = xmlhttp.responseText.split("|__|");
//		alert(results[0]+", "+results[1]);
		autoFill(results[0], results[1]);
	}
  }
}

function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}

</script>';
?>
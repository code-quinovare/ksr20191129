function loading(){
	$("body").append('<div id="background" class="background" style="display:none;"></div><div id="loadingdiv" class="loadingdiv" style="display:none;"><img src="img/images/loading.gif"></div>');
}
function showload(){
    document.getElementById('loadingdiv').style.display='block';
    document.getElementById('background').style.display='block';
}
function closeload(){
    document.getElementById('background').style.display='none';
    document.getElementById('loadingdiv').style.display='none';
}
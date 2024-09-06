function tampil(data) 
{ alert(data+"ok")
	if(data=="Lain")
	{
		$(".keterangan").show();
		$(".kota").hide();
		/*document.getElementById("keterangan").className  = "show";
		document.getElementById("kota").className  = "hide";*/
	}
	else if(data=="")
	{
		$(".keterangan").hide();
		$(".kota").hide();
		/*document.getElementById("keterangan").className  = "hide";
		document.getElementById("kota").className  = "hide";*/
	}
	else if(data=="Manual")
	{
		$(".keterangan").hide();
		$(".kota").hide();
		/*document.getElementById("keterangan").className  = "hide";
		document.getElementById("kota").className  = "hide";*/
	}
	else
	{
		$(".keterangan").hide();
		$(".kota").show();
		/*document.getElementById("keterangan").className  = "hide";
		document.getElementById("kota").className  = "show";*/
	}
}
function trapError() {
	return true; // stop the yellow triangle
}

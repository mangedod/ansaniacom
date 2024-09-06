
function getvar(name,url) {
		if (!url) url = window.location.href;
		name = name.replace(/[\[\]]/g, "\\$&");
		var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
			results = regex.exec(url);
		if (!results) return null;
		if (!results[2]) return '';
		return decodeURIComponent(results[2].replace(/\+/g, " "));
}

var browser = window.navigator.userAgent;
var isandroid = browser.indexOf("Android");

function fade(href)
{
	  window.location.href= href;
}
function slide(href) {
	window.location.href= href;
}


function logout()
{
	localStorage.removeItem('login');
	localStorage.removeItem('email');
	localStorage.removeItem('userid');
	localStorage.removeItem('userfullname');
	localStorage.removeItem('avatar');
	localStorage.removeItem('deviceid');
	localStorage.clear();
	slide("login.html");
}

function loading(id,jml)
{
	var content = '<div class="p-20"><div class="animated-background facebook"><div class="background-masker header-top"></div><div class="background-masker header-left"></div><div class="background-masker header-right"></div><div class="background-masker header-bottom"></div><div class="background-masker subheader-left"></div><div class="background-masker subheader-right"></div><div class="background-masker subheader-bottom"></div><div class="background-masker content-top"></div><div class="background-masker content-first-end"></div><div class="background-masker content-second-line"></div><div class="background-masker content-second-end"></div><div class="background-masker content-third-line"></div><div class="background-masker content-third-end"></div></div></div>';
	
	var contents = "";
	for(i=1;i<jml;i++)
	{
		contents += content;
	}
	$("#"+id).html(contents);
}

function loading1(id,jml)
{
	var content = '<div class="p-20"><div class="animated-background1 facebook"><div class="background-masker1 header-top"></div><div class="background-masker1 header-left"></div><div class="background-masker1 header-right"></div><div class="background-masker1 header-bottom"></div><div class="background-masker1 subheader-left"></div><div class="background-masker1 subheader-right"></div><div class="background-masker1 subheader-bottom"></div><div class="background-masker1 content-top"></div><div class="background-masker1 content-first-end"></div><div class="background-masker1 content-second-line"></div><div class="background-masker1 content-second-end"></div><div class="background-masker1 content-third-line"></div><div class="background-masker1 content-third-end"></div></div></div>';
	
	var contents = "";
	for(i=1;i<jml;i++)
	{
		contents += content;
	}
	$("#"+id).html(contents);
}
function loadingdetail(id)
{
	var content = '<div class="p-20"><div class="animated-background facebook"><div class="background-masker header-top"></div><div class="background-masker header-left"></div><div class="background-masker header-right"></div><div class="background-masker header-bottom"></div><div class="background-masker subheader-left"></div><div class="background-masker subheader-right"></div><div class="background-masker subheader-bottom"></div><div class="background-masker content-top"></div><div class="background-masker content-first-end"></div><div class="background-masker content-second-line"></div><div class="background-masker content-second-end"></div><div class="background-masker content-third-line"></div><div class="background-masker content-third-end"></div><div class="background-masker content-third-line"></div><div class="background-masker content-third-end"></div></div></div>';
	$("#"+id).html(content);
}
function loadingbar(id)
{
	var content = '<div class="p-20"><div class="animated-background facebook"><div class="background-masker content-second-line"></div><div class="background-masker content-second-end"></div><div class="background-masker content-third-line"></div><div class="background-masker content-third-end"></div><div class="background-masker content-third-line"></div><div class="background-masker content-third-end"></div></div></div>';
	$("#"+id).html(content);
}



$(function() {
	FastClick.attach(document.body);
});



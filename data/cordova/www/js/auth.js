$(document).ready(function(){
	var url="http://localhost:8080/ansaniacom/api/android/index.php/member/login/?callback=?";
    
    //Login Function
    $("#login").click(function(){
							   
	   var email=$("#username").val();
       var password=$("#password").val();
	   
	 /* window.FirebasePlugin.getToken(function(token)
	   {
		  localStorage.deviceid = token;
	   },function(error)
	   {
		 // alert(error);
	   });
		*/
		//var devices = device.model; 
    	//var dataString="username="+email+"&password="+password+"&deviceid="+localStorage.deviceid+"&device="+devices;
		
		var dataString="username="+email+"&password="+password+"&deviceid="+localStorage.deviceid;
		
		if($.trim(email).length<10){ 
			Materialize.toast('Email salah ketik', 2000);
		}
		//alert("Email masih kosong atau salah pengetikan email"); }
		if($.trim(password).length<3){ Materialize.toast('Password terlalu pendek', 2000); }
    	
		if($.trim(email).length>0 & $.trim(password).length>0)
		{
			$.ajax({
				type: "POST",
				url: url,
				data: dataString,
				crossDomain: true,
				cache: false,
				beforeSend: function(){ $("#login").html('Menyambungkan...');},
				success: function(data){
									
					if(data['status']=="OK")
					{
						var userid = data['userid'];
						var userfullname = data['userfullname'];
						var avatar = data['avatar'];
						
						localStorage.login="true";
						localStorage.email=email;
						localStorage.userid=userid;
						localStorage.userfullname=userfullname;
						localStorage.avatar=avatar;
						
						slide("index.html");
					}
					else if(data['status']=="ERROR")
					{
						swal(data['message']);
						$("#login").html('Login');
					}
				}
			});
		}return false;

    });

    //signup function
    $("#signup").click(function(){
		
		var urls="http://localhost:8080/ansaniacom/api/android/index.php/member/register/?callback=?";
		
    	var username=$("#username").val();
		var fullname=$("#userfullname").val();
    	var email=$("#useremail").val();
    	var password=$("#userpassword").val();
		var phone=$("#userphonegsm").val();

		
		if($.trim(useremail).length<10){ alert("Email masih kosong atau salah pengetikan email"); }
		if($.trim(password).length<3){ alert("Password masih kosong, terlalu pendek"); }
    
		var dataString="username="+username+"&userfullname="+fullname+"&useremail="+email+"&userpassword="+password+"&userphonegsm="+phone;

    	if($.trim(username).length>0 && $.trim(fullname).length>0 && $.trim(email).length>0 && $.trim(password).length>0)
		{

			$.ajax({
				type: "POST",
				url: urls,
				data: dataString,
				crossDomain: true,
				cache: false,
				beforeSend: function(){ $("#signup").val('Mendaftar...');},
				success: function(data){
					
					if(data['status']=="OK")
					{
						swal(data['message']);
						slide("login.html");						
					}
					else if(data['status']=="ERROR")
					{
						swal(data['message']);
					}
				}
			});
		}return false;

    });

    //Change Password
    $("#change_password").click(function(){
    	var email=localStorage.email;
    	var old_password=$("#old_password").val();
    	var new_password=$("#new_password").val();
    	var dataString="old_password="+old_password+"&new_password="+new_password+"&email="+email+"&change_password=";
    	if($.trim(old_password).length>0 & $.trim(old_password).length>0)
		{
			$.ajax({
				type: "POST",
				url: url,
				data: dataString,
				crossDomain: true,
				cache: false,
				beforeSend: function(){ $("#change_password").val('Connecting...');},
				success: function(data){
					if(data=="incorrect")
					{
						swal("Your old password is incorrect");
					}
					else if(data="success")
					{
						swal("Password Changed successfully");
					}
					else if(data="failed")
					{
						swal("Something Went wrong");
					}
				}
			});
		}return false;

    });

     //signup function
    $("#forget_password").click(function(){
		
		var urls="http://localhost:8080/ansaniacom/api/android/index.php/member/lupapassword/?callback=?";
		
    	var useremail=$("#useremail").val();
		var dataString="useremail="+useremail;
		
		if($.trim(useremail).length<10){ alert("Email masih kosong atau salah pengetikan email"); }
		
	
	   	if($.trim(useremail).length>0)
		{
			
			$.ajax({
				type: "POST",
				url: urls,
				data: dataString,
				crossDomain: true,
				cache: false,
				beforeSend: function(){ $("#forget_password").val('Meminta Password...');},
				success: function(data){
					if(data['status']=="OK")
					{
						slide("login.html");						
					}
					else if(data['status']=="ERROR")
					{
						swal(data['message']);
					}
				}
			});
		}return false;

    });


    //logout function
    $("#logout").click(function(){
    	localStorage.login="";
		localStorage.email="";
		localStorage.userid="";
    	slide("login.html");	
    });

    //Displaying user email on home page
    $("#email1").html(localStorage.email);
    var imageHash="http://www.gravatar.com/avatar/"+md5(localStorage.email);
    $("#profilepic").attr('src',imageHash);
});
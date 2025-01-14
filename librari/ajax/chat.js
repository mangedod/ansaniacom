/* 
Created by: Kenrick Beckett

Name: Chat Engine
*/

var instanse = false;
var state;
var mes;
var file;

function Chat () {
    this.update = updateChat;
    this.send = sendChat;
	this.getState = getStateOfChat;
}

//gets the state of the chat
function getStateOfChat(ch){
	
	if(!instanse){
		 instanse = true;
		 $.ajax({
			   type: "POST",
			   url: "http://jayagiriedu.net/librari/ajax/chat.php",
			   data: {  
			   			'function': 'getState',
						'file': file,
						'ch': ch,
						},
			   dataType: "json",
			
			   success: function(data){
				   state = data.state;
				   instanse = false;
			   },
			});
	}	 
}

//Updates the chat
function updateChat(ch){
	 if(!instanse){
		 instanse = true;
	     $.ajax({
			   type: "POST",
			   url: "http://jayagiriedu.net/librari/ajax/chat.php",
			   data: {  
			   			'function': 'update',
						'state': state,
						'ch': ch,
						'file': file
						},
			   dataType: "json",
			   success: function(data){
				   if(data.text){
						for (var i = 0; i < data.text.length; i++) {
                            $('#chat-area').append($("<p>"+ data.text[i] +"</p>"));
                        }								  
				   }
				   document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
				   instanse = false;
				   state = data.state;
			   },
			});
	 }
	 else {
		 setTimeout(updateChat, 1500);
	 }
}

//send the message
function sendChat(message,nickname,ch,uid)
{       
    updateChat(ch);
     $.ajax({
		   type: "POST",
		   url: "http://jayagiriedu.net/librari/ajax/chat.php",
		   data: {  
		   			'function': 'send',
					'message': message,
					'nickname': nickname,
					'ch': ch,
					'uid' :uid,
					
					'file': file
				 },
		   dataType: "json",
		   success: function(data){
			   updateChat(ch);
		   },
		});
}

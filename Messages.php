<?php
	// Session check and connection file inclusion
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	include("connection.php");
	
	// Setting page variables to be used in the code
	$userID = $_SESSION['userID'];
	$chatID = '0';	
	
?>

<!DOCTYPE html>
<html>
	<head>
		<!-- The head section currently contains details to make the software viewable
				Further changes are needed for the final version -->
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link rel="icon" href="#"/>
		<title>Helping Heroes</title>
	</head>
	<body onload="updateChats(); updateMessages();">
		<?php 
			// Necessary reference to include our dynamic navbar
			include("Navbar.php");
		?>
		<div class="container-fluid text-center">
			<div class="row content">
				<div class="col-sm-1 sidenav"></div>
				<div class="col-sm-10 text-center">
					<h2>Messages</h2>
					<div class="row content" style="height: 100%;">
						<div class="col-sm-5">
							<p>Below are all chats based on active jobs.</p>
							<div class="col-sm-12" id="chats"></div>
						</div>
						<div class="col-sm-7" id="messageBox" style="display: none; height: 100%;">
							<div class="col-sm-12" id="messages" style="overflow-y: scroll; height: 400px;"></div>
							<div class="col-sm-12" style="bottom: 0px;"> <input type="text" id="messageInput" onkeydown="if (event.keyCode == 13) sendMessage()" value="" placeholder=""></div>
						</div>
					</div>
				</div>
				<div class="col-sm-1 sidenav"></div>
			</div>
		</div>
		<script type="text/javascript">
			var messagebox = document.getElementById("messageBox");
			var messages = document.getElementById("messages");
			var chats = document.getElementById("chats");
			var input = document.getElementById("messageInput");
			var userid = "<?php echo $userID; ?>";
			var chatid = "<?php echo $chatID; ?>";
			var hasrefreshed = false;
			
			function updateChats() {
				var xmlhttp = new XMLHttpRequest();
				var output = "";
				xmlhttp.onreadystatechange=function() {
					if (xmlhttp.readyState==4 && xmlhttp.status==200) {
						var response = xmlhttp.responseText.split("\n")
						var rl = response.length
						var item = "";
						for (var i = 0; i < rl; i++) {
							item = response[i].split("\\")
							if (item[1] != undefined) {
								output += "<div class=\"chat\" onclick=\"selectChat(" + item[0] +  ")\" style=\"cursor: pointer\"> <div>" + item[1] + "</div> </div>";
							}
						}
						chats.innerHTML = output;
						chats.scrollTop = messages.scrollHeight;
					}
				}
				xmlhttp.open("GET","getChats.php?userid=" + userid,true);
				xmlhttp.send();
			}
			
			function updateMessages() {
				if (chatid != 0) {
					if (!hasrefreshed) {
						messagebox.style.display = "inline-block";
						hasrefreshed = true;
					};
					
					var xmlhttp = new XMLHttpRequest()
					var output = ""
					xmlhttp.onreadystatechange=function() {
						if (xmlhttp.readyState==4 && xmlhttp.status==200) {
							var response = xmlhttp.responseText.split("\n");
							var rl = response.length;
							var item = "";
							for (var i = 0; i < rl; i++) {
								item = response[i].split("\\")
								if (item[1] != undefined) {
									if (item[0] != userid) {
										//Message from other user
										output += "<div class=\"message text-left col-sm-12\"> <div class=\"msg msgfrom\">" + item[1] + "</div> <div class=\"msgarr msgarrfrom\"></div> <div class=\"msgsentby msgsentbyfrom\">Sent by " + item[0] + "</div> </div>";
									} else {
										//Message from current user
										output += "<div class=\"message text-right col-sm-12\"> <div class=\"msg\">" + item[1] + "</div> <div class=\"msgarr\"></div> <div class=\"msgsentby\">Sent by " + item[0] + "</div> </div>";
									}
								}
							}
							messages.innerHTML = output;
							messages.scrollTop = messages.scrollHeight;
						}
					}
					xmlhttp.open("GET","getMessages.php?userid=" + userid + "&chatid=" + chatid,true);
					xmlhttp.send();
				}
			}
			
			function sendMessage() {
				var message = input.value;
				if (message != "") {
					var xmlhttp=new XMLHttpRequest();

					xmlhttp.onreadystatechange=function() {
						if (xmlhttp.readyState==4 && xmlhttp.status==200) {
							message = escapehtml(message)
							messages.innerHTML += "<div class=\"message text-right col-sm-12\"> <div class=\"msg msgfrom\">" + message + "</div> <div class=\"msgarr msgarrfrom\"></div> <div class=\"msgsentby msgsentbyfrom\">Sent by " + userid + "</div> </div>";
							input.value = "";
						}
					}
					xmlhttp.open("GET","sendMessage.php?userid=" + userid + "&chatid=" + chatid + "&message=" + message,true);
					xmlhttp.send();
				}

			}
			
			function selectChat(inchatid) {
				chatid = inchatid;
				updateMessages();
			}
			
			function escapehtml(text) {
				return text
				.replace(/&/g, "&amp;")
				.replace(/</g, "&lt;")
				.replace(/>/g, "&gt;")
				.replace(/"/g, "&quot;")
				.replace(/'/g, "&#039;");
			}
			
			setInterval(function(){ updateMessages() }, 2500);
		</script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	</body>
</html>
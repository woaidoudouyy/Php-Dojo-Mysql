<?php
  // Create a database connection
  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "Sj890905";
  $dbname = "user";
  $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  // Test if connection succeeded
  if(mysqli_connect_errno()) {
    die("Database connection failed: " . 
         mysqli_connect_error() . 
         " (" . mysqli_connect_errno() . ")"
    );
  } else {
  	echo("Customer transaction report:");
  }
?>
<?php
	//Perform database query
	$query  = "SELECT u.id, u.password, un.description, u.actived ";
	$query .= "FROM user.user u ";
	$query .= "JOIN user.user_name un ON un.id = u.user_name_id ";
	$query .= "WHERE u.deleted = 0 ";
	$query .= "ORDER BY u.actived DESC";
	$result = mysqli_query($connection, $query);
	// Test if there was a query error
	if (!$result) {
		die("Database query failed.");
	}
?>

<!DOCTYPE html>

<html lang="en">
	<head>
		<title>Databases</title>
		<meta charset="utf-8"/>
	</head>
	<body>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/dojo/1.7/dojo/dojo.js"></script>
		<table>
			<tr>
				<th></th>
				<th>user name</th>
				<th>active</th>
				<th>password</th>				
			</tr>
		
		
		<?php
			$seq = 0;
			while($seq < 10) {	
				$userNameId = "userName".$seq;
				$passwordId = "password".$seq;
				$activeId = "active".$seq;
				$hiddenId = "hiddenId".$seq;
				$updateId = "update".$seq;
				$deleteId = "delete".$seq;
				$addId = "add".$seq;
				$addBtnClass = "addBtn".$seq;
				$updateBtnClass = "updateBtn".$seq;
				$deleteBtnClass = "deleteBtn".$seq;
				if($subject = mysqli_fetch_assoc($result))
				{


		?>
			<tr>
				<td><?php echo $seq ?>.</td>
				<td><input value="<?php echo $subject["description"] ?>" id="<?php echo $userNameId ?>"/></td>
				<td>
					<select id="<?php echo $activeId ?>">			
						<?php	
							if(1 == $subject["actived"]) {	
						?>
					  	<option selected>activated</option>
					  	<option>deactivated</option>
					  	<?php	
					  		} else {
						?>
						<option>activated</option>
					  	<option selected>deactivated</option>
					  	<?php			
					  		}
						?>
					</select>
				</td>
				<td><input value="<?php echo $subject["password"] ?>" id="<?php echo $passwordId ?>"/></td>
				<td><input type="hidden" value="<?php echo $subject["id"] ?>" id="<?php echo $hiddenId ?>"/></td>
				<td style ="display:none;" id = "<?php echo $addBtnClass?>" >[&nbsp;<a href="#"  onClick ="sendText(this)"  id="<?php echo $addId ?>">add</a>&nbsp;]</td>
				<td style ="display:inline;" id = "<?php echo $updateBtnClass?>" >[&nbsp;<a href="#" onClick ="updateText(this)" id="<?php echo $updateId?>">update</a>&nbsp;]</td>
				<td style ="display:inline;" id = "<?php echo $deleteBtnClass?>">[&nbsp;<a href="#" onClick ="deleteText(this)" id="<?php echo $deleteId?>">delete</a>&nbsp;]</td>
			</tr>
	  	<?php
				} else {
		?>
			<tr>
				<td><?php echo $seq ?>.</td>
				<td><input id="<?php echo $userNameId ?>"/></td>
				<td>
					<select id="<?php echo $activeId ?>">						
					  	<option>activated</option>
					  	<option>deactivated</option>
					</select>
				</td>
				<td><input id="<?php echo $passwordId ?>"/></td>
				<td><input type="hidden" id="<?php echo $hiddenId ?>"/></td>			
				<td id = "<?php echo $addBtnClass?>" style ="display:inline;">[&nbsp;<a href="#" class = "addBtn" onClick ="sendText(this)" id="<?php echo $addId ?>">add</a>&nbsp;]</td>
				<td id = "<?php echo $updateBtnClass?>" style ="display:none;">[&nbsp;<a href="#"class = "updateBtn" onClick ="updateText(this)" id="<?php echo $updateId?>">update</a>&nbsp;]</td>
				<td id = "<?php echo $deleteBtnClass?>" style ="display:none;">[&nbsp;<a href="#" class = "deleteBtn" onClick ="deleteText(this)" id="<?php echo $deleteId?>">delete</a>&nbsp;]</td>			
			</tr>
		<?php
				}
				$seq++;
			}
		?>
		</table>
		<div id="response"></div>
		<?php
		  // Release returned data
		  mysqli_free_result($result);
		?>
	<script>
		dojo.require("dojo.io.script");

		function sendText(elem){
			var elemId = elem.id
			var seq = elemId.substr(elemId.length - 1);
			var usernameId = "userName" + seq;
			var passwordId ="password"+seq;
			var activeId ="active" +seq;
			var hiddentId = "hiddenId" + seq;
			var username = document.getElementById(usernameId).value;
			var password = document.getElementById(passwordId).value;
			var active = document.getElementById(activeId).value;
			var activeValue;

			if (active==='activated'){
				activeValue = 1;
			}
			else if (active==='deactivated'){
				activeValue = 0;
			}
			require(["dojo/_base/xhr"], function(xhr){
				var deleteBtn = document.getElementById("deleteBtn"+seq);
				var updateBtn = document.getElementById("updateBtn"+seq);
				var addBtn = document.getElementById("addBtn"+seq);		
		    // post some data, ignore the response:
			    xhr.post({

			        url: "http://localhost/Test2.php", // read the url
			        timeout: 3000, // give up after 3 seconds
			        content: {  "id": -1,
				    "username":username,
				    "password":password,
				    "active": activeValue },
				    load: function(response,ioargs) {
					        alert('User has been created Successfully!');
					        addBtn.style.display = 'none';
					        deleteBtn.style.display = "inline";
					        updateBtn.style.display = "inline";
					        document.getElementById(hiddentId).value = response.id;
					   },
				    error : function(response,ioargs) {
					    alert(response.responseText);
					}
					    
				});
			});
		}
	

	function updateText(elem){

		var elemId = elem.id
		var seq = elemId.substr(elemId.length - 1);
		var usernameId = "userName" + seq;
		var passwordId ="password"+seq;
		var activeId ="active" +seq;
		var hiddentId = "hiddenId" + seq;
		var username = document.getElementById(usernameId).value;
		var password = document.getElementById(passwordId).value;
		var active = document.getElementById(activeId).value;
		var actualId =  document.getElementById(hiddentId).value ;
		var activeValue;

		if (active==='activated'){
			activeValue = 1;
		}
		else if (active==='deactivated'){
			activeValue = 0;
		}

		require(["dojo/_base/xhr"], function(xhr){
				var deleteBtn = document.getElementById("deleteBtn"+seq);
				var updateBtn = document.getElementById("updateBtn"+seq);
				var addBtn = document.getElementById("addBtn"+seq);		
		    // post some data, ignore the response:
			    xhr.put({

			        url: "http://localhost/Test2.php", // read the url
			        timeout: 3000, // give up after 3 seconds
			        content: {  
			        	"id":actualId,
				    "username":username,
				    "password":password,
				    "active": activeValue },
				    load: function(response,ioargs) {
					        alert('User has been updated Successfully!');
					        addBtn.style.display = 'none';
					        deleteBtn.style.display = "inline";
					        updateBtn.style.display = "inline";
					   },
				    error : function(response,ioargs) {
					    alert(response.responseText);
					}
					    
				});
			});

	}
	function deleteText(elem){
		var elemId = elem.id
		var seq = elemId.substr(elemId.length - 1);
			var usernameId = "userName" + seq;
		var passwordId ="password"+seq;
		var activeId ="active" +seq;
		var hiddentId = "hiddenId" + seq;
		var username = document.getElementById(usernameId);
		var password = document.getElementById(passwordId);
		var active = document.getElementById(activeId);
		var actualId =  document.getElementById(hiddentId) ;
		var deleteBtn = document.getElementById("deleteBtn"+seq);
		var updateBtn = document.getElementById("updateBtn"+seq);
		var addBtn = document.getElementById("addBtn"+seq);
		
		

	
		var xhrArgs = {
		      url: "http://localhost/Test2.php",
		      content: {  "id": actualId.value},
		      load: function(data){
		         alert('User has been Deleted Successfully!');
					        addBtn.style.display = 'inline';
					        deleteBtn.style.display = "none";
					        alert(deleteBtn.style.display)
					        updateBtn.style.display = "none";
					         username.value = "";
					 password.value = "";
		active.value = "";
		 actualId.value = "";

		      }
		      
		    }
		  
		    // Call the asynchronous xhrDelete
		    var deferred = dojo.xhrDelete(xhrArgs);
		 
		
		dojo.ready(deleteUri);

	}
	</script>
	</body>
</html>

<?php
  // Close database connection
  mysqli_close($connection);
?>
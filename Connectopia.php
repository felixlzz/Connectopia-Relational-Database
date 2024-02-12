
<?php
// The preceding tag tells the web server to parse the following text as PHP
// rather than HTML (the default)

// The following 3 lines allow PHP errors to be displayed along with the page
// content. Delete or comment out this block when it's no longer needed.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set some parameters

// Database access configuration
$config["dbuser"] = "ora_me10n";			// change "cwl" to your own CWL
$config["dbpassword"] = "a53731378";	// change to 'a' + your student number
$config["dbserver"] = "dbhost.students.cs.ubc.ca:1522/stu";
$db_conn = NULL;	// login credentials are used in connectToDB()

$success = true;	// keep track of errors so page redirects only if there are no errors

$show_debug_alert_messages = False; // show which methods are being triggered (see debugAlertMessage())

// The next tag tells the web server to stop parsing the text as PHP. Use the
// pair of tags wherever the content switches to PHP
?>

<html>

<head>
	<title>Connectopia Demonstration</title>
	<style> 
        .title{
            color: purple;
            font-size: 60px;
            text-align: center;
        } 

    </style>
</head>

<body>
	<div class="title"> Connectopia DBMS </div>
	
	<h2>Reset</h2>
	<p>Reset all tables to their default data values.</p>

	<form method="POST" action="Connectopia.php">
		<!-- "action" specifies the file or page that will receive the form data for processing. As with this example, it can be this same file. -->
		<input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
		<p><input type="submit" value="Reset" name="reset"></p>
	</form>

	<hr />

	<h2>Create New Event</h2>
	<form method="POST" action="Connectopia.php">
		<input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
		Location: <input type="text" name="insLocation"> <br /><br />
		Day (yyyy-mm-dd hh:mm:ss): <input type="text" name="insDay"> <br /><br />
        Event Name: <input type="text" name="insEventName"> <br /><br />
        Host (username): <input type="text" name="insUsername"> <br /><br />

		<input type="submit" value="Insert and Display Results" name="insertSubmit"></p>
	</form>

	<hr />

	<h2>Edit Event Details</h2>
	<form method="POST" action="Connectopia.php">
		<input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
		Location: <input type="text" name="eventLoc"> <br /><br />
		Date (yyyy-mm-dd hh:mm:ss): <input type="text" name="eventDate"> <br /><br />
		New Event Name: <input type="text" name="newEventName"> <br /><br />
        New Username: <input type="text" name="newUserName"> <br /><br />

		<input type="submit" value="Update and Display Results" name="updateSubmit"></p>
	</form>


	<hr />

	<h2>Delete a Feed</h2>
	<form method="POST" action="Connectopia.php">
		<input type="hidden" id="deleteTupleRequest" name="deleteTupleRequest">
        Feed Title: <input type="text" name="feedTitle"> <br /><br />
		
		<input type="submit" name="deleteTuples" value="Delete and Display Results"></p>
	</form>

	<hr />

    <h2>Search for Events</h2>
    <form method="POST" action="Connectopia.php">
        <input type="hidden" id="searchEvents" name="searchEvents">
        Location: <input type="text" name="location"><br /><br />
        Event Name: <input type="text" name="name"><br /><br />
        Host (username): <input type="text" name="username"><br /><br />
        <input type="submit" name="search" value="Search and Dsiplay Results">
    </form>

    <hr />

<!--     <h2>Table Projection</h2>
    <form method="POST" action="Connectopia.php">
        <input type="hidden" id="projectTableRequest" name="projectTableRequest">
        Table Name: <input type="text" name="tableName"><br /><br />
        Column Name: <input type="text" name="ColName"><br /><br />
        <input type="submit" name="project" value="Search">
    </form> -->

<!--     <hr /> -->

    <h2>Search for Messages</h2>
	    <p>Find all messages sent after the specified date.</p>
    <form method="POST" action="Connectopia.php">
        <input type="hidden" id="joinTableRequest" name="joinTableRequest">
        Date (yyyy-mm-dd hh:mm:ss): <input type="text" name="joinInputDay"> <br /><br />
        <input type="submit" name="join" value="Join and Display Results">
    </form>

    <hr />


    <h2>Count Users per Permission Group</h2>
    <form method="POST" action="Connectopia.php">
        <input type="hidden" id="groupByRequest" name="groupByRequest">
        <input type="submit" name="groupBy_Perm" value="Count and Display Results">
    </form>
    <hr />

    <h2>Best Commenters</h2>
	    <p>Find all users with a combined comment score over 100.</p>
    <form method="POST" action="Connectopia.php">
        <input type="hidden" id="groupByHavingRequest" name="groupByHavingRequest">
        <input type="submit" name="groupByHaving_HS" value = "Find and Display Results">
    </form>
    <hr />



    <h2>Quality Posters</h2>
	    <p>Find users who's average post score is higher than the overall average post score.</p>
    <form method="POST" action="Connectopia.php">
        <input type="hidden" id="groupByNestedRequest" name="groupByNestedRequest">
        <input type="submit" name="groupByNested_PS" value = "Find and Display Results">
	</form>
    <hr />

    <h2>Prolific Commenters</h2>
	    <p>Find users who have commented on every post.</p>
    <form method="POST" action="Connectopia.php">
        <input type="hidden" id="divisionRequest" name="divisionRequest">
        <input type="submit" name="division" value = "Find and Display Results">
	</form>
    <hr />

<h2> Projection with Any Relation </h2>
<form method="POST" action="Connectopia.php">
  <select id="selectEntity" name="selectEntity" onchange="updateAttributes()">
    <option value="" disabled selected>Please click to select a relation</option>
    <option value="AppUser">AppUser</option>
    <option value="Bot">Bot</option>
    <option value="Event">Event</option>
    <option value="RSVP">RSVP</option>
    <option value="Feed">Feed</option>
    <option value="Post">Post</option>
    <option value="PostComment">PostComment</option>
    <option value="Chat">Chat</option>
    <option value="Message">Message</option>
    <option value="PGroup">PGroup</option>
    <option value="Permission">Permission</option>
    <option value="HasPermission">HasPermission</option>
    <option value="UserBelongs">UserBelongs</option>
  </select>

  <div class="attribute-container" id="attributeContainer">
    <!-- Attributes and text input will be dynamically added here -->
  </div>

  <script>
    function updateAttributes() {
      // Get the selected value from the dropdown
      var selectedEntity = document.getElementById("selectEntity").value;

      // Get the container where attributes and text input will be added
      var attributeContainer = document.getElementById("attributeContainer");

      // Clear existing content
      attributeContainer.innerHTML = "";

      // Display attributes based on the selected entity
      if (selectedEntity !== "") {
        var attributesText = getAttributesText(selectedEntity);

        // Display attributes as text
        var attributesLine = document.createElement("p");
        attributesLine.appendChild(document.createTextNode("Attributes are: " + attributesText));
        attributeContainer.appendChild(attributesLine);

        // Add text input box
        var inputBox = document.createElement("input");
        inputBox.type = "text";
        inputBox.name = "projAttributes";
        inputBox.placeholder = "Please type all the attributes you want to project, connected with ONLY comma (no space) I.e. Attr1,Attr2,Attr3...";
        inputBox.style.width = "60%";
        inputBox.style.height = "40px";
        attributeContainer.appendChild(inputBox);
    
        var hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.id = "projectionRequest";
        hiddenInput.name = "projectionRequest";
        attributeContainer.appendChild(hiddenInput);

        var submitButton = document.createElement("input");
        submitButton.type = "submit";
        submitButton.name = "projection";
	submitButton.value = "Project and Display Results";
        attributeContainer.appendChild(submitButton);
      }
    }

    function getAttributesText(entity) {
      // Define attributes for each entity
      var attributesMap = {
        "AppUser": "Username, Joindate, Icon, Bio, Banned",
           "Bot": "Username, Token, Url",
           "Event":  "Location, eDay, Name, Username",
           "RSVP": "Location, eDay, Username",
           "Feed": "Title, Icon, Description",
           "Post": "Pid, Title, pType, pDesc, pDate, Score, Username, fTitle",
           "PostComment": "CMid, Text, cDate, Score, Pid, Username",
           "Chat": "Cid, Icon, Name",
           "Message": "MSGid, Text, mDate, Cid, Username",
           "PGroup": "Name, Displayname, Icon",
           "Permission": "Node",
           "HasPermission": "Name, Node, pValue",
           "UserBelongs": "Username, Name",
      };

      // Return attributes for the selected entity
      return attributesMap[entity] || "";
    }
  </script>
</form>
    <hr />



	<?php
	// The following code will be parsed as PHP

	function debugAlertMessage($message)
	{
		global $show_debug_alert_messages;

		if ($show_debug_alert_messages) {
			echo "<script type='text/javascript'>alert('" . $message . "');</script>";
		}
	}

	function executePlainSQL($cmdstr)
	{ //takes a plain (no bound variables) SQL command and executes it
		//echo "<br>running ".$cmdstr."<br>";
		global $db_conn, $success;

		$statement = oci_parse($db_conn, $cmdstr);
		//There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

		if (!$statement) {
			echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($db_conn); // For oci_parse errors pass the connection handle
			echo htmlentities($e['message']);
			$success = False;
		}

		$r = oci_execute($statement, OCI_DEFAULT);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = oci_error($statement); // For oci_execute errors pass the statementhandle
			echo htmlentities($e['message']);
			$success = False;
		}

		oci_commit($db_conn);
		return $statement;
	}

	function executeBoundSQL($cmdstr, $list)
	{
		/* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

		global $db_conn, $success;
		$statement = oci_parse($db_conn, $cmdstr);

		if (!$statement) {
			echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($db_conn);
			echo htmlentities($e['message']);
			$success = False;
		}

		foreach ($list as $tuple) {
			foreach ($tuple as $bind => $val) {
				//echo $val;
				//echo "<br>".$bind."<br>";
				oci_bind_by_name($statement, $bind, $val);
				unset($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
			}

			$r = oci_execute($statement, OCI_DEFAULT);
			if (!$r) {
				echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
				$e = OCI_Error($statement); // For oci_execute errors, pass the statementhandle
				echo htmlentities($e['message']);
				echo "<br>";
				$success = False;
			}
		}
		
		oci_commit($db_conn);
		return $statement;
	}

	// function printResult($result)
	// { //prints results from a select statement
	// 	echo "<br>Retrieved data from table demoTable:<br>";
	// 	echo "<table>";
	// 	echo "<tr><th>ID</th><th>Name</th></tr>";

	// 	while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
	// 		echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
	// 	}

	// 	echo "</table>";
	// }

	function connectToDB()
	{
		global $db_conn;
		global $config;

		// Your username is ora_(CWL_ID) and the password is a(student number). For example,
		// ora_platypus is the username and a12345678 is the password.
		// $db_conn = oci_connect("ora_cwl", "a12345678", "dbhost.students.cs.ubc.ca:1522/stu");
		$db_conn = oci_connect($config["dbuser"], $config["dbpassword"], $config["dbserver"]);

		if ($db_conn) {
			debugAlertMessage("Database is Connected");
			return true;
		} else {
			debugAlertMessage("Cannot connect to Database");
			$e = OCI_Error(); // For oci_connect errors pass no handle
			echo htmlentities($e['message']);
			return false;
		}
	}

	function disconnectFromDB()
	{
		global $db_conn;

		debugAlertMessage("Disconnect from Database");
		oci_close($db_conn);
	}

	function handleUpdateRequest()
	{
		global $db_conn;

		$sta = "UPDATE Event SET name = :newEventName, username = :newUsername WHERE location = :location AND eday = TO_DATE(:eventDate, 'yyyy-mm-dd hh24:mi:ss')";

		$tuple = array(
            ":location" => $_POST['eventLoc'],
            ":eventDate" => $_POST['eventDate'],
            ":newEventName" => $_POST['newEventName'],
            ":newUsername" => $_POST['newUserName']
        );

		$alltuples = array($tuple);

		executeBoundSQL($sta, $alltuples);

        $EventVisual = executePlainSQL("SELECT * FROM Event");
        printTable($EventVisual, "Location,Day,Event Name,Host Username");
	}

	function handleResetRequest()
	{
		global $db_conn;
		// Drop old table
		$reset = file_get_contents("ConnectopiaData.sql");
    
        executePlainSQL($reset);
		printAllTables();
	}

	function printTable($result, $columnHeaders) {
	    $columnHeaders = explode(",", $columnHeaders);
	    echo "<table style='border-collapse: collapse; width: 80%;'>";
	    echo "<tr>";
	    foreach ($columnHeaders as $columnName) {
		echo "<th style='border: 1px solid #a3a2a2; text-align: center; padding: 10px;'>{$columnName}</th>";
	    }
	    echo "</tr>";
		
	    while (($row = oci_fetch_row($result)) !== false) {
		echo "<tr>";
		foreach ($row as $tuple) {
		    echo "<td style='border: 1px solid #a3a2a2; text-align: center; padding: 8px;'>{$tuple}</td>";
		}
		echo "</tr>";
	    }
	    echo "</table>";
	}
	
	function printAllTables(){
        echo "<h2>AppUser</h2>";
    
        $AppUserVisual = executePlainSQL("SELECT * FROM AppUser");
    
        printTable($AppUserVisual, "Username,Joindate,Icon,Bio,Banned (0 is false)");
    
        echo "<br>";
    
        echo "<h2>Bot</h2>";
    
        $BotVisual = executePlainSQL("SELECT * FROM Bot");
    
        printTable($BotVisual, "Username,Token,Url");
    
        echo "<br>";
    
        echo "<h2>Event</h2>";
    
        $EventVisual = executePlainSQL("SELECT * FROM Event");
    
        printTable($EventVisual, "Location,Day,Event Name,Host Username");
    
        echo "<br>";
    
        echo "<h2>RSVP</h2>";
    
        $RSVPVisual = executePlainSQL("SELECT * FROM RSVP");
    
        printTable($RSVPVisual, "Location,Day,Attendee Username");
    
        echo "<br>";
    
        echo "<h2>Feed</h2>";
    
        $FeedVisual = executePlainSQL("SELECT * FROM Feed");
    
        printTable($FeedVisual, "Title,Icon,Description");
    
        echo "<br>";
    
        echo "<h2>Post</h2>";
    
        $PostVisual = executePlainSQL("SELECT * FROM Post");
    
        printTable($PostVisual, "Post ID,Title,Type,Description,Date,Score,Username,Feed Title");
    
        echo "<br>";
    
        echo "<h2>PostComment</h2>";
    
        $PostCommentVisual = executePlainSQL("SELECT * FROM PostComment");
    
        printTable($PostCommentVisual, "Comment ID,Text,Date,Score,Post ID,Username");
    
        echo "<br>";
    
        echo "<h2>Chat</h2>";
    
        $ChatVisual = executePlainSQL("SELECT * FROM Chat");
    
        printTable($ChatVisual, "Chat ID,Icon,Name");
    
        echo "<br>";
    
        echo "<h2>Message</h2>";
    
        $MessageVisual = executePlainSQL("SELECT * FROM Message");
    
        printTable($MessageVisual, "Message ID,Text,Date,Chat ID,Username");
    
        echo "<br>";
    
        echo "<h2>PGroup</h2>";
    
        $PGroupVisual = executePlainSQL("SELECT * FROM PGroup");
    
        printTable($PGroupVisual, "Permission Level Name,Display Name,Icon");
    
        echo "<br>";
    
        echo "<h2>Permission</h2>";
    
        $PermissionVisual = executePlainSQL("SELECT * FROM Permission");
    
        printTable($PermissionVisual, "Node");
    
        echo "<br>";
    
        echo "<h2>HasPermission</h2>";
    
        $HasPermissionVisual = executePlainSQL("SELECT * FROM HasPermission");
    
        printTable($HasPermissionVisual, "Permission Level Name,Node,Value");
    
        echo "<br>";

        echo "<h2>UserBelongs</h2>";
    
        $UserBelongsVisual = executePlainSQL("SELECT * FROM UserBelongs");
    
        printTable($UserBelongsVisual, "Username,Permission Level Name");
	}

	function handleInsertRequest()
	{
		global $db_conn;

		//Getting the values from user and insert data into the table
		$tuple = array(
			":bind1" => $_POST['insLocation'],
			":bind2" => $_POST['insDay'],
            ":bind3" => $_POST['insEventName'],
            ":bind4" => $_POST['insUsername']
		);

		$alltuples = array(
			$tuple
		);

		executeBoundSQL("insert into Event values (:bind1, TO_DATE(:bind2, 'yyyy-mm-dd hh24:mi:ss'), :bind3, :bind4)", $alltuples);
		
		$EventVisual = executePlainSQL("SELECT * FROM Event");
        printTable($EventVisual, "Location,Day,Event Name,Host Username");
	}

    function handleDeleteRequest() 
    {
        global $db_conn, $success;

		$deleteTitle = $_POST['feedTitle'];
        $var = array(":ftitle" => $deleteTitle);
        executePlainSQL("DELETE FROM Feed WHERE title = '" . $deleteTitle . "'");
        if ($success) {
            echo "Tuple with title '$deleteTitle' deleted successfully.";
        } else {
            echo "Error deleting tuple with title '$deleteTitle'.";
        }
		
		printAllTables();
    }

    function handleSelectionRequest()
    {
        $location = empty($_POST['location'])? '%' : '%' . $_POST['location'] . '%';
        $name = empty($_POST['name']) ? '%' : '%' . $_POST['name'] . '%';
        $username = empty($_POST['username']) ? '%' : '%' . $_POST['username'] . '%';
        $selectEvent = "SELECT * FROM Event WHERE location LIKE '" . $location . "' AND name LIKE '" . $name . "' AND username LIKE '" . $username . "'";
        
        $result = executePlainSQL($selectEvent);

        if ($result) {
            displayJoinResults($result);
        } else {
            echo "Error executing the search query.";
        }
    }

    function handleTableProjection()
    {
        global $db_conn;

		$attrs = $_POST['projAttributes'];
		$table = $_POST['selectEntity'];
		
		$sta = "SELECT " . $attrs . " FROM " . $table . "";
		$result = executePlainSQL($sta);

        if ($result) {
            displayJoinResults($result);
        } else {
            echo "Error executing the search query.";
        }
    }

	function handleJoinTableRequest()
    {
        global $db_conn, $success;

        //$inputDate = $_POST['joinInputDay'];

        $joinSta = "SELECT u.username, u.icon, m.text, m.mdate
                    FROM appuser u, Message m
                    WHERE u.username = m.username AND m.mdate >= TO_TIMESTAMP(:mdate, 'YYYY-MM-DD HH24:MI:SS')";
        $var = array(":mdate" => $_POST['joinInputDay']);
        $result = executeBoundSQL($joinSta, array($var));

        if ($success) {
            displayJoinResults($result);
        } else {
            echo "Error executing the join query.";
        }
    }

    function displayJoinResults($result)
    {
        echo "<h3>Query Results:</h3>";
        echo "<table border='1'>";
    
        // Fetch and display column names
        echo "<tr>";
        for ($i = 1; $i <= oci_num_fields($result); $i++) {
            $column_name = oci_field_name($result, $i);
            echo "<th>{$column_name}</th>";
        }
        echo "</tr>";
    
        // Fetch and display rows
        while ($row = oci_fetch_assoc($result)) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>{$value}</td>";
            }
            echo "</tr>";
        }
    
        echo "</table>";
    }

    function handleGroupByRequest() {
        global $db_conn;
        $result = executePlainSQL("SELECT name, count(*) FROM UserBelongs GROUP BY name");
        if(!$result){
     	    debugAlertMessage("An error has occured!");
            return;
        }
        printTable($result, "Permission Level Name,Count");
        oci_commit($db_conn);
    }

    function handleGroupByHavingRequest() {
        global $db_conn;
        $result = executePlainSQL("SELECT u.username, SUM(c.score)
        FROM appuser u, PostComment c
        WHERE u.username = c.username
        GROUP BY u.username
        HAVING SUM(c.score) > 100");
        if(!$result){
      	    debugAlertMessage("An error has occured!");
            return;
        }
        printTable($result, "Username,Sum of Comment Scores");
		oci_commit($db_conn);
    }

    function handleGroupByNestedRequest() {
        global $db_conn;
        $result = executePlainSQL("SELECT u.username, AVG(p.score)
        FROM appuser u, Post p
        WHERE u.username = p.username
        GROUP BY u.username
        HAVING AVG(p.score) > (SELECT AVG(score) FROM Post)");
        if(!$result){
     	    debugAlertMessage("An error has occured!");
            return;
        }
        printTable($result, "Username,User's Average Post Score");
	oci_commit($db_conn);
    }

    function handleDivisionRequest() {
        global $db_conn;
        $result = executePlainSQL(
        "SELECT u.username
        FROM appuser u
        WHERE NOT EXISTS (
            SELECT p.pid
            FROM post p
            WHERE NOT EXISTS (
                SELECT u.username
                FROM PostComment c
                WHERE p.pid = c.pid AND u.username = c.username))");
        
        if(!$result){
	    debugAlertMessage("An error has occured!");
            return;
        }

        printTable($result, "Username");
        oci_commit($db_conn);
    }

	function handleDisplayRequest()
	{
		global $db_conn;
		$result = executePlainSQL("SELECT * FROM demoTable");
		printResult($result);
	}

	// HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handlePOSTRequest()
	{
		if (!connectToDB()) {
			return;
		}
		
		if (array_key_exists('resetTablesRequest', $_POST)) {
			handleResetRequest();
		} else if (array_key_exists('updateQueryRequest', $_POST)) {
			handleUpdateRequest();
		} else if (array_key_exists('searchEvents', $_POST)) {
			handleSelectionRequest();
		} else if (array_key_exists('insertQueryRequest', $_POST)) {
			handleInsertRequest();
		} else if (array_key_exists('deleteTupleRequest', $_POST)) {
			handleDeleteRequest();
		} else if (array_key_exists('groupByRequest', $_POST)) {
			handleGroupByRequest();
		} else if (array_key_exists('groupByHavingRequest', $_POST)) {
			handleGroupByHavingRequest();
		} else if (array_key_exists('groupByNestedRequest', $_POST)) {
			handleGroupByNestedRequest();
		} else if (array_key_exists('divisionRequest', $_POST)) {
			handleDivisionRequest();
		}  else if (array_key_exists('joinTableRequest', $_POST)) {
			handleJoinTableRequest();
		} else if (array_key_exists('projectionRequest', $_POST)) {
			handleTableProjection();
		} 
		disconnectFromDB();
	}

	// HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
	function handleGETRequest()
	{
		if (connectToDB()) {
			if (array_key_exists('countTuples', $_GET)) {
				handleCountRequest();
			} elseif (array_key_exists('displayTuples', $_GET)) {
				handleDisplayRequest();
			}
			disconnectFromDB();
		}
	}

	if (isset($_POST['reset']) || isset($_POST['setup_DB']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['deleteTuples']) ||  isset($_POST['search']) ||
		isset($_POST['groupBy_Perm']) || isset($_POST['join']) || isset($_POST['groupByHaving_HS'])  || isset($_POST['groupByNested_PS']) || isset($_POST['division']) || isset($_POST['projection'])) {
		handlePOSTRequest();
	} else if (isset($_GET['countTupleRequest']) || isset($_GET['displayTuplesRequest'])) {
		handleGETRequest();
	}

	// End PHP parsing and send the rest of the HTML content
	?>
</body>

</html>

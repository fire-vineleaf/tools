<html>
<head>
<title>Repository Generator - 2.5</title>
</head>
<body>
<a name="toc"/>
<h1>TOC</h1>
<?php

require_once("../backend/config.inc.php");
require_once("../backend/includes.inc.php");

error_reporting(E_ALL);


$repository = new MySqlRepository($cfgMySqlHost, $cfgMySqlUserName, $cfgMySqlPassword, $cfgMySqlDatabase);

// mappings

$mappings["buildings"]["modelName"] = "Building";
$mappings["buildings"]["idFieldName"] = "building_id";
$mappings["buildings"]["idPropertyName"] = "buildingId";

$mappings["camps"]["modelName"] = "Camp";
$mappings["camps"]["idFieldName"] = "camp_id";
$mappings["camps"]["idPropertyName"] = "campId";

$mappings["accounts"]["modelName"] = "Account";
$mappings["accounts"]["idFieldName"] = "account_id";
$mappings["accounts"]["idPropertyName"] = "accountId";

$mappings["players"]["modelName"] = "Player";
$mappings["players"]["idFieldName"] = "player_id";
$mappings["players"]["idPropertyName"] = "playerId";


$mappings["fields"]["modelName"] = "Field";
$mappings["fields"]["idFieldName"] = "field_id";
$mappings["fields"]["idPropertyName"] = "fieldId";

$mappings["clans"]["modelName"] = "Clan";
$mappings["clans"]["idFieldName"] = "clan_id";
$mappings["clans"]["idPropertyName"] = "clanId";

$mappings["threads"]["modelName"] = "Thread";
$mappings["threads"]["idFieldName"] = "thread_id";
$mappings["threads"]["idPropertyName"] = "threadId";

$mappings["posts"]["modelName"] = "Post";
$mappings["posts"]["idFieldName"] = "post_id";
$mappings["posts"]["idPropertyName"] = "postId";

$mappings["invitations"]["modelName"] = "Invitation";
$mappings["invitations"]["idFieldName"] = "invitation_id";
$mappings["invitations"]["idPropertyName"] = "invitationId";

$mappings["messages"]["modelName"] = "Message";
$mappings["messages"]["idFieldName"] = "message_id";
$mappings["messages"]["idPropertyName"] = "messageId";

$mappings["replies"]["modelName"] = "Reply";
$mappings["replies"]["idFieldName"] = "reply_id";
$mappings["replies"]["idPropertyName"] = "replyId";

$mappings["participants"]["modelName"] = "Participant";
$mappings["participants"]["idFieldName"] = "message_id";
$mappings["participants"]["idPropertyName"] = "messageId";

$mappings["feed_items"]["modelName"] = "FeedItem";
$mappings["feed_items"]["idFieldName"] = "feed_item_id";
$mappings["feed_items"]["idPropertyName"] = "feedItemId";

$mappings["tasks"]["modelName"] = "Task";
$mappings["tasks"]["idFieldName"] = "task_id";
$mappings["tasks"]["idPropertyName"] = "taskId";



$query = "SHOW TABLES";
$stmt = $repository->mysqli->prepare($query);
$stmt->execute();
$a = array();
$stmt->bind_result($a["name"]);
$stmt->store_result();
$tableNames = array();
while ($stmt->fetch()) {
	$tableNames[] = $a["name"];
}
foreach ($tableNames as $tableName) {
	echo "<a href=\"#$tableName\">$tableName</a> | ";
}
foreach ($tableNames as $tableName) {
	echo "<a name=\"$tableName\"/>";
	echo "<h1>Table: $tableName</h1>";
	
	$navigation = "<p></p><p>";
	$navigation .= "<a href=\"#TOC\">TOC</a> | ";
	$navigation .= "<a href=\"#".$tableName."_rep_create\">rep_create</a> | ";
	$navigation .= "<a href=\"#".$tableName."_rep_getbyid\">rep_getbyid</a> | ";
	$navigation .= "<a href=\"#".$tableName."_rep_getbyname\">rep_getbyname</a> | ";
	$navigation .= "<a href=\"#".$tableName."_rep_getall\">rep_getall</a> | ";
	$navigation .= "<a href=\"#".$tableName."_rep_update\">rep_update</a> | ";
	$navigation .= "<a href=\"#".$tableName."_rep_delete\">rep_delete</a> | ";
	$navigation .= "<a href=\"#".$tableName."_service_create\">service_create</a> | ";
	$navigation .= "<a href=\"#".$tableName."_service_getbyid\">service_getbyid</a> | ";
	$navigation .= "<a href=\"#".$tableName."_service_getbyname\">service_getbyname</a> | ";
	$navigation .= "<a href=\"#".$tableName."_service_getall\">service_getall</a> | ";
	$navigation .= "<a href=\"#".$tableName."_service_update\">service_update</a> | ";
	$navigation .= "<a href=\"#".$tableName."_service_delete\">service_delete</a> | ";
	$navigation .= "<a href=\"#".$tableName."_api_create\">api_create</a> | ";
	$navigation .= "<a href=\"#".$tableName."_api_getbyid\">api_getbyid</a> | ";
	$navigation .= "<a href=\"#".$tableName."_api_getbyname\">api_getbyname</a> | ";
	$navigation .= "<a href=\"#".$tableName."_api_getall\">api_getall</a> | ";
	$navigation .= "<a href=\"#".$tableName."_api_update\">api_update</a> | ";
	$navigation .= "<a href=\"#".$tableName."_api_delete\">api_delete</a> | ";
	$navigation .= "<a href=\"#".$tableName."_routing_create\">routing_create</a> | ";
	$navigation .= "<a href=\"#".$tableName."_routing_getbyid\">routing_getbyid</a> | ";
	$navigation .= "<a href=\"#".$tableName."_routing_getbyname\">routing_getbyname</a> | ";
	$navigation .= "<a href=\"#".$tableName."_routing_getall\">routing_getall</a> | ";
	$navigation .= "<a href=\"#".$tableName."_routing_update\">routing_update</a> | ";
	$navigation .= "<a href=\"#".$tableName."_routing_delete\">routing_delete</a> | ";
$navigation .= "</p>";
	
	
	$query2 = "desc $tableName";
	$stmt2 = $repository->mysqli->prepare($query2);
	$stmt2->execute();
	$b = array();
	$stmt2->bind_result($b["Field"], $b["Type"], $b["Null"], $b["Key"], $b["Default"], $b["Extra"]);
	$fields = array();
	$fieldNames = array();
	$i = 0;
	while ($stmt2->fetch()) {
		$fields[$i]["Field"] = $b["Field"];
		$fields[$i]["Type"] = $b["Type"];
		$fields[$i]["Null"] = $b["Null"];
		$fields[$i]["Key"] = $b["Key"];
		$fields[$i]["Default"] = $b["Default"];
		$fields[$i]["Extra"] = $b["Extra"];
		$i++;
	}
	$stmt2->close();

	echo "<h2>Fields</h2>";
	$i = 0;
	$fieldsString = "";
	$bindingArrayString = "";
	$fieldTypeString = "";
	$propertiesString = "";
	$propertiesStringWithoutIdField = "";
	$insertValuesString = "";
	$updateFieldsString = "";
	foreach ($fields as $field) {
		if ($i != 0) {
			$fieldsString .= ", ";
			$bindingArrayString .= ", ";
			$insertValuesString .= ", ";
			$propertiesStringWithoutIdField .= ", \$model->" . underscore2Camelcase($field["Field"]) . "\n";
		}
		if ($i >= 2) {
			$updateFieldsString .= ", ";
		}
		if ($i >= 1) {
			$updateFieldsString .= $field["Field"] . " = ?";
		}
		
		$fieldsString .= $field["Field"];
		$bindingArrayString .= "\$a[\"" . underscore2Camelcase($field["Field"]) . "\"]";

		if (strrpos($field["Type"], "char") !== FALSE) {
			$fieldTypeString .= "s";
		} else {
			$fieldTypeString .= "i";
		}
		$propertiesString .= ", \$model->" . underscore2Camelcase($field["Field"]) . "\n";
		
		$insertValuesString .= "?";
		
		$i++;
	}
	echo $fieldsString;
	$fieldsStringWithoutIdField = str_replace($mappings[$tableName]["idFieldName"]. ", ", "", $fieldsString);
	$insertValuesStringWithoutIdField = substr($insertValuesString, 2);
	$fieldTypeStringWithoutIdField = substr($fieldTypeString, 1);
	$fieldTypeStringUpdate = substr($fieldTypeString, 1). substr($fieldTypeString, 0, 1);
	$modelName = $mappings[$tableName]["modelName"];
	
	echo "<a name=\"".$tableName."_fields\"/>";
	echo $navigation;
	echo "<h2>fields</h2><pre>";
	var_dump($fields);
	echo "</pre>";
	echo "<a name=\"".$tableName."_rep_getbyid\"/>";
	echo "<h2>$tableName - repository: get by id</h2>";
	
	?><pre>

/**
 * get <?php echo $mappings[$tableName]["modelName"]; ?> by id
 * @param int $id
 * @return <?php echo $mappings[$tableName]["modelName"]; ?>
 
 */	
public function get<?php echo $mappings[$tableName]["modelName"]; ?>ById($id) {
	$query = "SELECT <?php echo $fieldsString; ?> FROM <?php echo $tableName;?> where <?php echo $mappings[$tableName]["idFieldName"]; ?> = ?";
	$stmt = $this->prepare($query);
	$rc = $stmt->bind_param("i", $id);
	$this->checkBind($rc);
	$stmt = $this->execute($stmt);
	$a = array();
	$rc = $stmt->bind_result(<?php echo $bindingArrayString; ?>);
	$this->checkBind($rc);
	if ($stmt->fetch()) {
		return <?php echo $mappings[$tableName]["modelName"]; ?>::CreateModelFromRepositoryArray($a);
	} else {
		return null;
	}
}
	</pre><?php
	echo $navigation;
	echo "<a name=\"".$tableName."_rep_getbyname\"/>";
	echo "<h2>$tableName - repository: get by name</h2>";
	?><pre>
/**
 * gets <?php echo $mappings[$tableName]["modelName"]; ?> by name
 * @param string $name
 * @return <?php echo $mappings[$tableName]["modelName"]; ?>
 
 */	
public function get<?php echo $mappings[$tableName]["modelName"]; ?>ByName($name) {
	$query = "SELECT <?php echo $fieldsString; ?> FROM <?php echo $tableName;?> where name = ?";
	$stmt = $this->mysqli->prepare($query);
	if ($stmt === false) {
		throw new RepositoryException($this->mysqli->error, $this->mysqli->errno);
	}
	$rc = $stmt->bind_param("s", $name);
	if ($rc === false) {
		throw new RepositoryException($stmt->error, $stmt->errno);
	}
	if (!$stmt->execute()) {
		throw new RepositoryException($stmt->error, $stmt->errno);
	}
	$a = array();
	$rc = $stmt->bind_result(<?php echo $bindingArrayString; ?>);
	if ($rc === false) {
		throw new RepositoryException($stmt->error, $stmt->errno);
	}

	if ($stmt->fetch()) {
		return <?php echo $mappings[$tableName]["modelName"]; ?>::CreateModelFromRepositoryArray($a);
	} else {
		return null;
	}
}	
	</pre>
	<?php
	echo $navigation;
	echo "<a name=\"".$tableName."_rep_getall\"/>";
	echo "<h2>$tableName - repository: get all</h2>";
?><pre>
/**
 * retrieves all <?php echo $mappings[$tableName]["modelName"]; ?>s
 * @return Array
 */
public function get<?php echo $mappings[$tableName]["modelName"]; ?>s() {
	$query = "SELECT <?php echo $fieldsString; ?> FROM <?php echo $tableName;?>";
	$stmt = $this->prepare($query);
	$stmt = $this->execute($stmt);
	$a = array();
	$rc = $stmt->bind_result(<?php echo $bindingArrayString; ?>);
	$this->checkBind($rc);
	$models = array();
	while ($stmt->fetch()) {
		$models[] = <?php echo $mappings[$tableName]["modelName"]; ?>::CreateModelFromRepositoryArray($a);
	}
	return $models;
}
</pre><?php	
	
	echo $navigation;
	echo "<a name=\"".$tableName."_rep_create\"/>";
	echo "<h2>$tableName - repository: create</h2>";
		?><pre>
/**
 * creates <?php echo $mappings[$tableName]["modelName"]; ?> 
 * @param <?php echo $mappings[$tableName]["modelName"]; ?> $model
 * @return <?php echo $mappings[$tableName]["modelName"]; ?> 
 */	
public function create<?php echo $mappings[$tableName]["modelName"]; ?>($model) {
	$query = "INSERT INTO <?php echo $tableName;?> (<?php echo $fieldsStringWithoutIdField; ?>) VALUES (<?php echo $insertValuesStringWithoutIdField; ?>)";
	$stmt = $this->prepare($query);
	$rc = $stmt->bind_param("<?php echo $fieldTypeStringWithoutIdField; ?>"
		<?php echo $propertiesStringWithoutIdField; ?>
	);
	$this->checkBind($rc);
	$stmt = $this->execute($stmt);
	$model-><?php echo $mappings[$tableName]["idPropertyName"]; ?> = $this->mysqli->insert_id;
	return $model;
}
	</pre>
	<?php
	echo $navigation;
	echo "<a name=\"".$tableName."_rep_update\"/>";
	echo "<h2>$tableName - repository: update</h2>";
?><pre>
/**
 * updates <?php echo $mappings[$tableName]["modelName"]; ?> 
 * @param <?php echo $mappings[$tableName]["modelName"]; ?> $model
 * @return <?php echo $mappings[$tableName]["modelName"]; ?> 
 */
public function update<?php echo $mappings[$tableName]["modelName"]; ?>($model) {
	$query = "UPDATE <?php echo $tableName; ?> SET <?php echo $updateFieldsString; ?> WHERE <?php echo $mappings[$tableName]["idFieldName"]; ?> = ?";
	$stmt = $this->prepare($query);
	$rc = $stmt->bind_param("<?php echo $fieldTypeStringUpdate; ?>"
		<?php echo $propertiesStringWithoutIdField; ?> 
		, $model-><?php echo $mappings[$tableName]["idPropertyName"]; ?>
	);
	$this->checkBind($rc);
	$stmt = $this->execute($stmt);	
	return $model;
}
</pre><?php
	echo $navigation;
	echo "<a name=\"".$tableName."_rep_delete\"/>";
	echo "<h2>$tableName - repository: delete</h2>";

		?><pre>
/**
 * deletes <?php echo $mappings[$tableName]["modelName"]; ?> 
 * @param int $id
 */	
public function delete<?php echo $mappings[$tableName]["modelName"]; ?>($id) {
	$query = "DELETE FROM <?php echo $tableName;?> WHERE <?php echo $mappings[$tableName]["idFieldName"]; ?> = ?";
	$stmt = $this->prepare($query);
	$rc = $stmt->bind_param("i", $id);
	$this->checkBind($rc);
	$stmt = $this->execute($stmt);
}
	</pre>
	<?php	
	
	echo $navigation;
	echo "<a name=\"".$tableName."_service_getbyid\"/>";
	echo "<h2>$tableName - service: get by id</h2>";

	?><pre>
/**
 * gets <?php echo $mappings[$tableName]["modelName"]; ?> by id
 * @param int $id
 * @return <?php echo $mappings[$tableName]["modelName"]; ?>
 */	
public function get<?php echo $mappings[$tableName]["modelName"]; ?>ById($id) {
	if ($id == "") {
		throw new ParameterException("id is empty");
	}
	$model = $this->repository->get<?php echo $mappings[$tableName]["modelName"]; ?>ById($id);
	if ($model == null) {
		throw new NotFoundException($id);
	}
	return $model;
}
	</pre>
	<?php
	echo $navigation;
	echo "<a name=\"".$tableName."_service_getbyname\"/>";
	echo "<h2>$tableName - service: get by name</h2>";
	?><pre>
/**
 * gets <?php echo $mappings[$tableName]["modelName"]; ?> by name
 * @param string $name
 * @return <?php echo $mappings[$tableName]["modelName"]; ?> 
 */	
public function get<?php echo $mappings[$tableName]["modelName"]; ?>ByName($name) {
	if ($name == "") {
		throw new ParameterException("name is empty");
	}
	$model = $this->repository->get<?php echo $mappings[$tableName]["modelName"]; ?>ByName($name);
	if ($model == null) {
		throw new NotFoundException($name);
	}
	return $model;
}	
	</pre>
	<?php
	echo $navigation;
	echo "<a name=\"".$tableName."_service_getall\"/>";
	echo "<h2>$tableName - service: get all</h2>";
	?>
<pre>
/**
 * retrieves all <?php echo $mappings[$tableName]["modelName"]; ?>s
 * @return Array
 */
public function get<?php echo $mappings[$tableName]["modelName"]; ?>s() {
	$models = $this->repository->get<?php echo $mappings[$tableName]["modelName"]; ?>s();
	return $models;
}
</pre><?php	
	
	
	echo $navigation;
	echo "<a name=\"".$tableName."_service_create\"/>";
	echo "<h2>$tableName - service: create</h2>";
?><pre>	
/**
 * Creates a new <?php echo $mappings[$tableName]["modelName"]; ?> 
 * @param <?php echo $mappings[$tableName]["modelName"]; ?> $model
 * @return <?php echo $mappings[$tableName]["modelName"]; ?> 
 */
public function create<?php echo $mappings[$tableName]["modelName"]; ?>($model) {
	/* is the model a model? */
	if (!is_object($model)) {
		throw new ParameterException("model is null");
	}
	if (get_class($model) != "<?php echo $mappings[$tableName]["modelName"]; ?>") {
		throw new ParameterException("model is not of type <?php echo $mappings[$tableName]["modelName"]; ?>");
	}
	
	/* authorized? */
	$this->securityManager->checkAdminAuthorization();
	$this->securityManager->checkProjectAuthorization($project);
	$this->securityManager->checkMemberAuthorization($project);

	
	/* model valid? */
	$modelException = new ModelException("<?php echo $mappings[$tableName]["modelName"]; ?> contains validation errors");
	// check properties
	if ($model->name == "") {
		$modelException->addModelError("name", "empty");
	}
	// done
	if ($modelException->hasModelErrors()) {
		throw $modelException;
	}
	
	if (!$model->isNew()) {
		throw new ModelException("<?php echo $mappings[$tableName]["modelName"]; ?> is not new, cannot be created again");
	}
	
	// finally: we can create the <?php echo $mappings[$tableName]["modelName"]; ?> 
	$model->createdByUserId = $this->contextUser->userId;
	$model->createdAt = time();
	$this->repository->beginTransaction();
	$model = $this->repository->create<?php echo $mappings[$tableName]["modelName"]; ?>($model);
	$this->touchProject($project);
	
	$this->logAction("create-project", $model);
	
	$this->repository->commit();
	return $model;
}
</pre>
<?php
	echo $navigation;
	echo "<a name=\"".$tableName."_service_update\"/>";
	echo "<h2>$tableName - service: update</h2>";

	echo $navigation;
	echo "<a name=\"".$tableName."_service_delete\"/>";
	echo "<h2>$tableName - service: delete</h2>";

	echo $navigation;
	echo "<a name=\"".$tableName."_api_getbyid\"/>";
	echo "<h2>$tableName - apicontroller: get by id</h2>";
	
?>
<pre>	
	
/**
 * retrieves a <?php echo $mappings[$tableName]["modelName"]; ?> by id
 * @param array $parameters
 * @return <?php echo $mappings[$tableName]["modelName"]; ?>
 */
public function get<?php echo $mappings[$tableName]["modelName"]; ?>ById($parameters) {
	$id = $parameters["id"];
	$service = new XYZService($this->contextUser, $this->repository);
	$validationState = new ValidationState();
	$model = $service->get<?php echo $mappings[$tableName]["modelName"]; ?>ById($id, $validationState);
	if ($model == null) {
		return $validationState;
	} else {
		return $model;
	}
}
</pre>
<?php
	echo $navigation;	
	echo "<a name=\"".$tableName."_api_getbyname\"/>";	
	echo "<h2>$tableName - apicontroller: get by name</h2>";
?>
<pre>	
	
/**
 * retrieves a <?php echo $mappings[$tableName]["modelName"]; ?> by name
 * @param array $parameters
 * @return <?php echo $mappings[$tableName]["modelName"]; ?>
 */
public function get<?php echo $mappings[$tableName]["modelName"]; ?>ByName($parameters) {
	$name = $parameters["name"];
	$service = new XYZService($this->contextUser, $this->repository);
	$validationState = new ValidationState();
	$model = $service->get<?php echo $mappings[$tableName]["modelName"]; ?>ByName($name, $validationState);
	if ($model == null) {
		return $validationState;
	} else {
		return $model;
	}
}
</pre>
<?php
	echo $navigation;
	echo "<a name=\"".$tableName."_api_getall\"/>";	
	echo "<h2>$tableName - apicontroller: get all</h2>";
	echo $navigation;
	echo "<a name=\"".$tableName."_api_create\"/>";	
	echo "<h2>$tableName - apicontroller: create</h2>";
	echo $navigation;
	echo "<a name=\"".$tableName."_api_update\"/>";	
	echo "<h2>$tableName - apicontroller: update</h2>";
	echo $navigation;
	echo "<a name=\"".$tableName."_api_delete\"/>";	
	echo "<h2>$tableName - apicontroller: delete</h2>";
	echo $navigation;

	echo "<a name=\"".$tableName."_routing_getbyid\"/>";	
	echo "<h2>$tableName - routing: get by id</h2>";
?><pre>
$router->map ( 'GET', '/Api/xyzs/[i:id]', array (
		'c' => 'XYZApiController',
		'a' => 'get<?php echo $mappings[$tableName]["modelName"]; ?>ById'
));
</pre><?php
	echo $navigation;
	echo "<a name=\"".$tableName."_routing_getbyname\"/>";	
	echo "<h2>$tableName - routing: get by name</h2>";
?><pre>
$router->map ( 'GET', '/Api/xyzs/name/[a:name]', array (
		'c' => 'XYZApiController',
		'a' => 'get<?php echo $mappings[$tableName]["modelName"]; ?>ByName'
));
</pre><?php	

	echo $navigation;
	echo "<a name=\"".$tableName."_routing_create\"/>";	
	echo "<h2>$tableName - routing: create</h2>";
	echo $navigation;
	echo "<a name=\"".$tableName."_routing_update\"/>";	
	echo "<h2>$tableName - routing: update</h2>";
	echo $navigation;
	echo "<a name=\"".$tableName."_routing_delete\"/>";	
	echo "<h2>$tableName - routing: delete</h2>";
	echo $navigation;
	echo "<a name=\"".$tableName."_routing_\"/>";	
	echo "<h2>$tableName - routing: ....</h2>";
	echo $navigation;

}
$stmt->close();



function underscore2Camelcase($str) {
	$words = explode('_', strtolower($str));

	$return = '';
	foreach ($words as $word) {
		$return .= ucfirst(trim($word));
	}
	$return = lcfirst($return);
	return $return;
}

?>

</body>
</html>

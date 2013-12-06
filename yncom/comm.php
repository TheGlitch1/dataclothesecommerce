<?php
require_once('preheader.php'); // <-- this include file MUST go first before any HTML/output



$id = $_SESSION["id"];
	#the code for the class
	include ('ajaxCRUD.class.php'); // <-- this include file MUST go first before any HTML/output

	
	?>
	
	<?php
    #this one line of code is how you implement the class
    ########################################################
    ##

    $tblDemo = new ajaxCRUD("Commandes", "ordre_clients", "idCustomer_orders");

    ##
    ########################################################

    ## all that follows is setup configuration for your fields....
    ## full API reference material for all functions can be found here - http://ajaxcrud.com/api/
    ## note: many functions below are commented out (with //). note which ones are and which are not

    #i can define a relationship to another table
    #the 1st field is the fk in the table, the 2nd is the second table, the 3rd is the pk in the second table, the 4th is field i want to retrieve as the dropdown value
    #http://ajaxcrud.com/api/index.php?id=defineRelationship
    $tblDemo->defineRelationship("Clients_idClient", "clients", "idClient", "nom"); //use your own table - this table (tblDemoRelationship) not included in the installation script

    #i don't want to visually show the primary key in the table
    $tblDemo->omitPrimaryKey();

    #the table fields have prefixes; i want to give the heading titles something more meaningful
    
	$tblDemo->displayAs("Clients_idClient", "Nom du client");
	

    #i could omit a field if I wanted
    #http://ajaxcrud.com/api/index.php?id=omitField
    //$tblDemo->omitField("fldField2");

    #i could omit a field from being on the add form if I wanted
    //$tblDemo->omitAddField("fldField2");

    #i could disallow editing for certain, individual fields
    //$tblDemo->disallowEdit();

    #i could set a field to accept file uploads (the filename is stored) if wanted
    //$tblDemo->setFileUpload("fldField2", "uploads/");

    #i can have a field automatically populate with a certain value (eg the current timestamp)
    //$tblDemo->addValueOnInsert("fldField1", "NOW()");

    #i can use a where field to better-filter my table
    $tblDemo->addWhereClause("WHERE (Clients_idClient = $id)");

    #i can order my table by whatever i want
    //$tblDemo->addOrderBy("ORDER BY fldField1 ASC");

    #i can set certain fields to only allow certain values
    #http://ajaxcrud.com/api/index.php?id=defineAllowableValues
    

    //set field fldCheckbox to be a checkbox
    $tblDemo->defineCheckbox("fldCheckbox");

    #i can disallow deleting of rows from the table
    #http://ajaxcrud.com/api/index.php?id=disallowDelete
    $tblDemo->disallowDelete();

    #i can disallow adding rows to the table
    #http://ajaxcrud.com/api/index.php?id=disallowAdd
    $tblDemo->disallowAdd();

    #i can add a button that performs some action deleting of rows for the entire table
    #http://ajaxcrud.com/api/index.php?id=addButtonToRow
    $tblDemo->addButtonToRow("Afficher articles", "comm.php?p=1", "Ordre_Clients_idCustomer_orders");

    #set the number of rows to display (per page)
    $tblDemo->setLimit(30);

	#set a filter box at the top of the table
    //$tblDemo->addAjaxFilterBox('fldField1');

    #if really desired, a filter box can be used for all fields
    //$tblDemo->addAjaxFilterBoxAllFields();

    #i can set the size of the filter box
    //$tblDemo->setAjaxFilterBoxSize('fldField1', 3);

	#i can format the data in cells however I want with formatFieldWithFunction
	#this is arguably one of the most important (visual) functions
	$tblDemo->formatFieldWithFunction('fldField1', 'makeBlue');
	$tblDemo->formatFieldWithFunction('fldField2', 'makeBold');

	//$tblDemo->modifyFieldWithClass("fldField1", "zip required"); 	//for testing masked input functionality
	//$tblDemo->modifyFieldWithClass("fldField2", "phone");			//for testing masked input functionality

	//$tblDemo->onAddExecuteCallBackFunction("mycallbackfunction"); //uncomment this to try out an ADD ROW callback function



	#actually show the table
	$tblDemo->showTable();

	#my self-defined functions used for formatFieldWithFunction
	function makeBold($val){
		return "<b>$val</b>";
	}

	function makeBlue($val){
		return "<span style='color: blue;'>$val</span>";
	}

	function myCallBackFunction($array){
		echo "THE ADD ROW CALLBACK FUNCTION WAS implemented";
		print_r($array);
	}
?>

	<center>
			le client a <b><?php $tblDemo->insertRowsReturned();?></b> commande(s)<br />
		</center>

		<div style="clear:both;"></div>
		
<?php

if(isset($_REQUEST["p"]));
{
	$tblDemo = new ajaxCRUD("Produits", "produits_commandes", "Ordre_Clients_idCustomer_orders");
	$tblDemo->defineRelationship("Produit_idProducts", "produit", "idProducts", "description"); //use your own table - this table (tblDemoRelationship) not included in the installation script
	$tblDemo->omitPrimaryKey();
	$tblDemo->disallowAdd();
	$tblDemo->disallowDelete();
	$c=$_GET["Ordre_Clients_idCustomer_orders"];
	
	if($c=="")
		return;
	//echo $_REQUEST["id"]." - ".$_SESSION["Ordre_Clients_idCustomer_orders"]." - ".$_GET["Ordre_Clients_idCustomer_orders"];
	$tblDemo->addWhereClause("WHERE (Ordre_Clients_idCustomer_orders = $c)");
	$tblDemo->showTable();
	
	}
	
?>
	
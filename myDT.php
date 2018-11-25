<?php
/* configure */
$TB_name="aroTable";
//$columnLimitArr=array("a01","a02","a03"); 
if (!isset($columnLimitArr)) $columnLimitArr=array();
$limitColumn='id'; 
$limitValue='12';  
$equalValue="!=";
$today  = mktime( date("H") , date("i"), date("s"), date("m")  , date("d"), date("Y"));
$encodeKey=base64_encode($today);
$getLinks="TB_name=".$TB_name."&limitColumn=".$limitColumn."&limitValue=".$limitValue."&equalValue=".$equalValue."&encodeKey=".$encodeKey;

/*sql*/
$dirBin=dirname(__FILE__);
include($dirBin."/myTB_config.php");
$con=mysqli_connect($DB_host,$DB_user,$DB_pass,$DB_name);// Check connection
if (mysqli_connect_errno()){
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

/* default column*/
$columnArr=array(); 
$sql = "show full columns from `".$DB_name."`.`".$TB_name."`";
if ($result=mysqli_query($con,$sql)){	
 while ($row=mysqli_fetch_row($result)){
  $column = $row[0]; 
  $tArr=explode("(",$row[1]); $type=$tArr[0];
  $isEmptyValue = trim($row[3]);     
  $comment = trim($row[8]); 
  if ($comment!=""){  $label=$comment; }else{  $label=$column; }   
  $tmp=$label.":".$column.":".$type.":".$isEmptyValue;
  if (count($columnLimitArr)>0){ 
   if (in_array($column,$columnLimitArr)) array_push($columnArr,$tmp);
  }else{
   array_push($columnArr,$tmp);	  
  }
 }
}

/* default column*/
$th=""; $columnsRecord=""; $fields=""; 
for($i=0;$i<count($columnArr);$i++){ 
 $tmpArr=explode(":",trim($columnArr[$i]));
 $columnLabel=$tmpArr[0]; $columnName=$tmpArr[1]; $type=$tmpArr[2]; $isEmptyValue=$tmpArr[3];
 $th.="<th>".$columnLabel."</th>";       
 $columnsRecord.='{ data: "'.$columnName.'" },'; 
 $fields.='{label: "'.$columnLabel.':",name: "'.$columnName.'"},';
 $getLinks.="&c[]=".$columnName."&t[]=".$type."&d[]=".$isEmptyValue;    
}
if ($columnsRecord!="") $columnsRecord='columns: [ '.substr($columnsRecord,0,-1).'],';
if ($fields!="") $fields='fields: [ '.substr($fields,0,-1).']';


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
	<title>Editor example - Basic initialisation</title>

	<!----------bootstrap 4 ------>
	<!--link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="DT/webcss/dataTables.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="DT/webcss/buttons.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="DT/webcss/colReorder.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="DT/webcss/responsive.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="DT/webcss/scroller.bootstrap.min.css">	
	<link rel="stylesheet" type="text/css" href="DT/webcss/select.bootstrap.min.css"-->
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css"/>	
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.4/css/buttons.bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.5.0/css/colReorder.bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.bootstrap.min.css"/>	
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/scroller/1.5.0/css/scroller.bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.2.6/css/select.bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="<?=$DT_folder;?>/css/editor.bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=$DT_folder;?>/css/editor.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="demo.css">		
	<style type="text/css" class="init">
	</style>
	
	<!----------bootstrap 3 ------>
	<!--script type="text/javascript" language="javascript" src="DT/webjs/jquery-1.12.4.js"></script>
	<script type="text/javascript" language="javascript" src="DT/webjs/bootstrap.min.js"></script>
	<script type="text/javascript" language="javascript" src="DT/webjs/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="DT/webjs/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" language="javascript" src="DT/webjs/dataTables.colReorder.min.js	"></script>	
	<script type="text/javascript" language="javascript" src="DT/webjs/dataTables.select.min.js"></script>	
	<script type="text/javascript" language="javascript" src="DT/webjs/dataTables.responsive.min.js"></script>
	<script type="text/javascript" language="javascript" src="DT/webjs/responsive.bootstrap.min.js"></script>		
	<script type="text/javascript" language="javascript" src="DT/webjs/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="DT/webjs/buttons.bootstrap.min.js"></script>	
	<script type="text/javascript" language="javascript" src="DT/webjs/buttons.colVis.min.js"></script>
	<script type="text/javascript" language="javascript" src="DT/webjs/buttons.html5.min.js"></script>
	<script type="text/javascript" language="javascript" src="DT/webjs/dataTables.scroller.min.js"></script-->	
	<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>	
	<script type="text/javascript" src="https://cdn.datatables.net/colreorder/1.5.0/js/dataTables.colReorder.min.js"></script>	
	<script type="text/javascript" src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>	
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.2/js/responsive.bootstrap.min.js"></script>	
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.colVis.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script>		
	<script type="text/javascript" src="https://cdn.datatables.net/scroller/1.5.0/js/dataTables.scroller.min.js"></script>	
	<script type="text/javascript" language="javascript" src="<?=$DT_folder;?>/js/editor.bootstrap.min.js"></script>	
	<script type="text/javascript" language="javascript" src="<?=$DT_folder;?>/js/dataTables.editor.min.js"></script>
	<script type="text/javascript" language="javascript" class="init">

var editor; // use a global for the submit and return data rendering in the examples

$(document).ready(function() {
	editor = new $.fn.dataTable.Editor( {
		ajax: "myDT_staff.php?<?=$getLinks;?>",		
		table: "#myTable",		
		"i18n": {
                create: {
                    title:  "表單: <?=$TB_name;?>"
                },
                edit: {
                    title:  "表單: <?=$TB_name;?>"
                }
        },
		<?=$fields;?>			
	} );

	var table = $('#myTable').DataTable( {
        dom: 'Bfrtip',
		ajax: {
			url: "myDT_staff.php?<?=$getLinks;?>",
			type: "POST"
		},		
		<?=$columnsRecord;?>
		select: true,	
		buttons: [
			/*{ extend: "create", editor: editor, text: '新增' },*/
			{ extend: "edit",   editor: editor, text: '編輯' },
			{ extend: "remove", editor: editor, text: '刪除' },
			{ extend: "colvis", editor: editor, text: '欄位' },
     		{
                extend: 'collection',
                text: '匯出',
                buttons: [
					{ extend: "excelHtml5", editor: editor, exportOptions: {columns: ':visible',orthogonal: 'export'}, text: 'Excel' }
                ]
            }
		],
		scrollX: true,		
		scrollY: '67vh',
		deferRender:    true,
		scroller:       true,	
		scrollCollapse: true,		
		processing: true,
		colReorder: true,
		lengthChange: false,
		serverSide: true
	} );
  	
} );



	</script>
</head>


	<div class="container90">
		<section>
			<!--table id="example" class="display" style="width:100%"-->
			<table id="myTable" class="table table-striped nowrap" style="width:100%">			
				<thead>	
				<?=$th;?>
				</thead>
			</table>
		</section>
	</div>

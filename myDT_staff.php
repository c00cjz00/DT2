<?php
$dirBin=dirname(__FILE__);
include($dirBin."/myTB_config.php");

/*
 * Example PHP implementation used for the index.html example
 */

// DataTables PHP library
define("DATATABLES", true, true);
include( $DT_folder."/lib/Bootstrap.php" );

// Alias Editor classes so they are easy to use
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Mjoin,
	DataTables\Editor\Options,
	DataTables\Editor\Upload,
	DataTables\Editor\Validate,
	DataTables\Editor\ValidateOptions;


// cjz //	
$Field = new Field();
$whereValue="";
if (!isset($_GET['c'])) { echo "no column\n"; exit(); }
if (!isset($_GET['t'])) { echo "no types\n"; exit(); }
if (!isset($_GET['d'])) { echo "no isEmyty\n"; exit(); }
if (!isset($_GET['TB_name'])) { echo "no TB_name\n"; exit(); }
if (!isset($_GET['limitColumn'])) { echo "no limitColumn\n"; exit(); }
if (!isset($_GET['limitValue'])) { echo "no limitValue\n"; exit(); }
if (!isset($_GET['equalValue'])) { echo "no equalValue\n"; exit(); }
if (!isset($_GET['encodeKey'])) { echo "no encodeKey\n"; exit(); }
$columns=$_GET['c'];
$types=$_GET['t']; 
$isEmyty=$_GET['d'];
$TB_name=$_GET['TB_name'];
$limitColumn=$_GET['limitColumn']; 
$limitValue=$_GET['limitValue']; 
$equalValue=$_GET['equalValue'];
$encodeKey=$_GET['encodeKey'];

$today  = mktime( date("H") , date("i"), date("s"), date("m")  , date("d"), date("Y"));
$decodeKey=base64_decode($encodeKey);
$timeDiff=($today-$decodeKey);
if ($timeDiff>1800)  { echo "key error\n"; exit(); }

	
// Build our Editor instance and process the data coming from _POST
$Editor = new Editor(); $Field = new Field(); 

for($i=0;$i<count($columns);$i++){ 
 $tmpArr=explode(":",trim($columns[$i])); $column=$tmpArr[0];  $type=$types[$i]; $isEmpty=$isEmyty[$i];
 if (($type=="int") || ($type=="decimal") || ($type=="float") ) {
  ##必為數值
  $inst[]=$Field->inst($column) 
  			->validator( Validate::numeric()  )
			->setFormatter( Format::ifEmpty(null) ) ;
 }elseif ($type=="date"){
  ## 日期
  $inst[]=$Field->inst($column)
			->validator( Validate::dateFormat( 
				'Y-m-d', 
               ValidateOptions::inst()
                    ->allowEmpty( true )				
			) )
			->getFormatter( Format::dateSqlToFormat( 'Y-m-d' ) )
			->setFormatter( Format::dateFormatToSql('Y-m-d' ) )  ; 
			     
 }elseif ($type=="email"){
  ## Email 
  $inst[]=$Field->inst($column) 
   			->validator( Validate::email( ValidateOptions::inst() 
			->message( 'Please enter an e-mail address' )) );
   
 }elseif ($isEmpty=="NO") {  
  ## 不可為空直
  $inst[]=$Field->inst($column) 
   			->validator( Validate::notEmpty( ValidateOptions::inst() 
			->message( 'A value is required2' )) );
 }else{
  $inst[]=$Field->inst($column);   
 } 
}		
Editor::inst( $db, $TB_name )
	->fields($inst)
    ->where($limitColumn,$limitValue,$equalValue)
	#->where( 'office', 'London' )
    #->where( 'salary', 100000, '>' )
	->process( $_POST )
	->json();

	

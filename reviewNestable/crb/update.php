<?php
 //Identify if the table already exists and if so then drop that table
 	$sqldrop = "IF OBJECT_ID('[$table]', 'U') IS NOT NULL
 				DROP TABLE $table";
	$sqldropresult = odbc_exec($connection,$sqldrop);

 //remove temporary table
//		$sqldelete = 'DROP TABLE '.$table;
//		$sqldeleteresult = odbc_exec($connection,$sqldelete);

//Update Resume Staging Record
	$update = "UPDATE ResumesStaging
					   SET 
					       ResumeName = '$resumename'
					      ,TitlePageText = '$resumetitle'
					      ,FooterText = '$resumefooter'
					      ,ImgFileName = '$image'
					      ,Deadline = '$deadline'
					      ,Height = '$height'
					      ,SortOrder = '$sortorder'
					      ,StdResume = '$stdresume'
					      ,RFP = '$rfp'
					      ,InclTOC = '$incltoc'
					      ,BiosPgBreak = '$biospgbreak'
					      ,Comments = RTRIM(LTRIM('$comments'))
					      ,Deactivate = '$deactivate'
					      ,Reviewed = '0' 
					      ,Approved = '0'
					      ,ReviewedByUserID = NULL
					      ,ReviewedOnDtTm = NULL
					      ,ApprovedByUserID = NULL
					      ,ApprovedOnDtTm = NULL
					WHERE ResumeStagingID = '$uniqueresumeID'";
		$updateresult = odbc_exec($connection,$update);
	
        //Drop Existing Staging Records
        $delete = "DELETE FROM dbo.ResumeAssemblyStaging
                WHERE ResumeStagingID = '$uniqueresumeID'";
        $deleteresult = odbc_exec($connection,$delete);

//Save the Assembly Order to the Resume Assembly Staging Table

$listorder = $_POST['listorder']; //value from the hidden field in CRB after list is sorted by user
$sortarray = array(); //initialize array object
$sortlistorder = parse_str($listorder, $sortarray); //populate the sort array with the list

//initialize id and sort order variables
$sectionid = '0';
$subsectionid = '0';
$caseparaid = '0';
$bioid = '0';

$isectionorder = 0;
$isubsectionorder = 0;
$icaseparaorder = 1;
$ibioorder = 1;

//initialize counter to get proper section id and sort order
$j = 0;

//loop through the 3 level which is the casepara level
foreach (array_values($sortarray)[2] as $key => $value) { //The index 2 is always the 3rd level which is casepara level
$caseparaid = $key; //set CaseParaID

//test $value against $subsectionid and if matched then subection exists, else increment to next subection
if ($value == $subsectionid) {
$icaseparaorder = $icaseparaorder + 1;  //increment casepara becasue this is same subsection
} else {
$icaseparaorder = 1; //reset order for starting the new subsection
$subsectionid = $value;
//set variable so we can test to see if this is a new section
$match = array_values(array_values($sortarray)[1])[$j];
//increment counter
$j = $j + 1;

if ($match==$sectionid) {
$isubsectionorder = $isubsectionorder + 1; //increment subsection because this is the same section 
} else {
$isubsectionorder = 1; //reset order for starting the new section
$sectionid = $match;
$isectionorder = $isectionorder + 1; //increment section
}
}

//Test and convert ID to accomodate any staging records.

if ($uniqueresumeID > 10000) {
	$resumestagingid1 = $uniqueresumeID;
	$resumeid1 = 0;
} else {
	$resumestagingid1 = 0;
	$resumeid1 = $uniqueresumeID;
}

if ($sectionid > 10000) {
	$sectionstagingid1 = $sectionid;
	$sectionid1 = 0;
} else {
	$sectionstagingid1 = 0;
	$sectionid1 =$sectionid;
}

if ($subsectionid > 10000) {
	$subsectionstagingid1 = $subsectionid;
	$subsectionid1 = 0;
} else {
	$subsectionstagingid1 = 0;
	$subsectionid1 =$subsectionid;
}

if ($caseparaid > 10000) {
	$caseparastagingid1 = $caseparaid;
	$caseparaid1 = 0;
} else {
	$caseparastagingid1 = 0;
	$caseparaid1 =$caseparaid;
}

		$insertassembly =	"INSERT INTO ResumeAssemblyStaging
						(
						 ResumeStagingID
						,SectionStagingID
						,SubsectionStagingID
						,CaseParaStagingID
						,BioStagingID
						,ResumeID
						,SectionID
						,SubsectionID
						,CaseParaID
						,BioID
						,SectionAssemblyOrder
						,SubsectionAssemblyOrder
						,CaseParaAssemblyOrder
						,BioAssemblyOrder
						,CRB
						,Bio
						,RequestedByUserID
						)
						VALUES
						(
						$resumestagingid1,
						$sectionstagingid1,
						$subsectionstagingid1,
						$caseparastagingid1,
						'0',
						$resumeid1,
						$sectionid1,
						$subsectionid1,
						$caseparaid1,
						'0',
						$isectionorder,
						$isubsectionorder,
						$icaseparaorder,
						'0',
						'1',
						'0',
						'$userID'
						)";
	$insertassemblyresult = odbc_exec($connection,$insertassembly);
//						echo $insertassembly.'<br>';

}           

// count values in the array.  If 3, the the bios have been removed and only sections, subsections and caseparas exist.
$counta = count($sortarray);
if ($counta == 4) {
//loop through the 4th Index which is the Bios level
foreach (array_values($sortarray)[3] as $key => $value) { //The index 2 is always the 3rd level which is casepara level

$bioid = $key; //set CaseParaID
//	echo 'bioid:  '.$bioid.'<br>';
//test $value against $subsectionid and if matched then subection exists, else increment to next subection
if ($value == $subsectionid) {
//echo 'value:  '.$value.'<br>';
//echo 'subsectionid:  '.$subsectionid.'<br>';
$ibioorder = $ibioorder + 1;  //increment casepara because this is same subsection
} else {
	//echo 'Else value !!!!!'.$value.'<br>';
	//echo 'Else SubsectionID !!!!!'.$subsectionid.'<br>';
$ibioorder = 1; //reset order for starting the new subsection
$subsectionid = $value;
//set variable so we can test to see if this is a new section
$match = array_values(array_values($sortarray)[1])[$j];
//echo $j.'<br/>';
//increment counter
$j = $j + 1;

if ($match==$sectionid) {
$isubsectionorder = $isubsectionorder + 1; //increment subsection because this is the same section 
} else {
$isubsectionorder = 1; //reset order for starting the new section
$sectionid = $match;
$isectionorder = $isectionorder + 1; //increment section
}
}

if ($uniqueresumeID > 10000) {
	$resumestagingid1 = $uniqueresumeID;
	$resumeid1 = 0;
} else {
	$resumestagingid1 = 0;
	$resumeid1 = $uniqueresumeID;
}

if ($sectionid > 10000) {
	$sectionstagingid1 = $sectionid;
	$sectionid1 = 0;
} else {
	$sectionstagingid1 = 0;
	$sectionid1 =$sectionid;
}

if ($subsectionid > 10000) {
	$subsectionstagingid1 = $subsectionid;
	$subsectionid1 = 0;
} else {
	$subsectionstagingid1 = 0;
	$subsectionid1 =$subsectionid;
}

if ($bioid > 10000) {
	$biostagingid1 = $bioid;
	$bioid1 = 0;
} else {
	$biostagingid1 = 0;
	$bioid1 =$bioid;
}
		$insertbioassembly =	"INSERT INTO ResumeAssemblyStaging
						(
						 ResumeStagingID
						,SectionStagingID
						,SubsectionStagingID
						,CaseParaStagingID
						,BioStagingID
						,ResumeID
						,SectionID
						,SubsectionID
						,CaseParaID
						,BioID
						,SectionAssemblyOrder
						,SubsectionAssemblyOrder
						,CaseParaAssemblyOrder
						,BioAssemblyOrder
						,CRB
						,Bio
						,RequestedByUserID
						)
						VALUES
						(
						$resumestagingid1,
						$sectionstagingid1,
						$subsectionstagingid1,
						'0',
						$biostagingid1,
						$resumeid1,
						$sectionid1,
						$subsectionid1,
						'0',
						$bioid1,
						$isectionorder,
						$isubsectionorder,
						'0',
						$ibioorder,
						'1',
						'1',
						'$userID'
						)";
	$insertbioassemblyresult = odbc_exec($connection,$insertbioassembly);

//echo $insertbioassembly;

}           

}//close if bios exist

?>
<?php
//Get Max Sort Order in Resume Table
  $sqlresume = "Select Case 
					When isnull((SELECT MAX (SortOrder) FROM Resumes),0) > isnull((SELECT MAX (SortOrder) FROM ResumesStaging),0) 
					Then (SELECT MAX (SortOrder) FROM Resumes)
					Else (SELECT MAX (SortOrder) FROM ResumesStaging)
					END AS MaxSortOrder";
  $sqlresumeresult = odbc_exec($connection,$sqlresume);
  while ($resumerow = odbc_fetch_array($sqlresumeresult)){    
    $sortorder = $resumerow['MaxSortOrder'] + 1;    
}

//Save Resume Information to the Resume Staging Table
		$insert =	"INSERT INTO ResumesStaging
			           (
			            ResumeName
			           ,TitlePageText
			           ,FooterText
			           ,ImgFileName
			           ,Deadline
			           ,Height
			           ,SortOrder
			           ,StdResume
			           ,RFP
			           ,InclTOC
			           ,BiosPgBreak
			           ,CRB
			           ,Comments
			           ,RequestedByUserID
			           ,TempID
			           )
				    VALUES
			           (
			           '$resumename',
			           '$resumetitle',
			           '$resumefooter',
			           '$image',
			           '$deadline',
			           '$height',
			           '$sortorder',
			           '$stdresume',
			           '$rfp',
			           '$incltoc',
			           '$biospgbreak',
			           '1',
			           RTRIM(LTRIM('$comments')),
			           '$userID',
			           '9999'
			           )";
	$insertresult = odbc_exec($connection,$insert);
//echo $insert;

//Retrieve Resume ID from new record
  $sqlnewresume = "SELECT ResumeStagingID
                  FROM ResumesStaging
                  WHERE TempID = '9999'";
  $sqlnewresumeresult = odbc_exec($connection,$sqlnewresume);
  while ($newresumerow = odbc_fetch_array($sqlnewresumeresult)){    
    $resumestagingid = $newresumerow['ResumeStagingID'];    
}

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
//echo $j.'<br/><br/><br/><br>';
$j = $j + 1;

if ($match==$sectionid) {
$isubsectionorder = $isubsectionorder + 1; //increment subsection because this is the same section 
} else {
$isubsectionorder = 1; //reset order for starting the new section
$sectionid = $match;
$isectionorder = $isectionorder + 1; //increment section
}
}

//echo the values that will go into the insert statement			
//echo 'The CaseParaID is:  '.$caseparaid.'<br/>';
//echo 'The SubsectionID is:  '.$subsectionid.'<br/>';
//echo 'The SectionID is:  '.$sectionid.'<br/>';
//echo 'The CaseParaOrder is:  '.$icaseparaorder.'<br/>';
//echo 'The SubsectionOrder is:  '.$isubsectionorder.'<br/>';
//echo 'The SectionOrder is:  '.$isectionorder.'<br/>';
//echo 'Insert SQL Statement Goes Here';
//echo '<br/>';		
//echo '<br/>';
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
						'$resumestagingid',
						'0',
						'0',
						'0',
						'0',
						'0',
						$sectionid,
						$subsectionid,
						$caseparaid,
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

}           

// count values in the array.  If 3, the the bios have been removed and only sections, subsections and caseparas exist.
$counta = count($sortarray);
if ($counta == 4) {

//print_r($sortarray);	
// through the 4th Index which is the Bios level
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

//echo the values that will go into the insert statement			
//echo 'The BioID is:  '.$bioid.'<br/>';
//echo 'The SubsectionID is:  '.$subsectionid.'<br/>';
//echo 'The SectionID is:  '.$sectionid.'<br/>';
//echo 'The BioOrder is:  '.$ibioorder.'<br/>';
//echo 'The SubsectionOrder is:  '.$isubsectionorder.'<br/>';
//echo 'The SectionOrder is:  '.$isectionorder.'<br/>';
//echo 'Insert SQL Statement Goes Here';
//echo '<br/>';		
//echo '<br/>';
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
						'$resumestagingid',
						'0',
						'0',
						'0',
						'0',
						'0',
						$sectionid,
						$subsectionid,
						'0',
						$bioid,
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

//Remove Temp Resume ID from new record
  $sqlupdatetempid = "Update dbo.ResumesStaging
						Set TempID = Null
						Where TempID = '9999'";
  $sqlupdatetempidresult = odbc_exec($connection,$sqlupdatetempid);



?>
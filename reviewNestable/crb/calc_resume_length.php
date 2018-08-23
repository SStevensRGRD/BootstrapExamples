<?php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
require_once ($_SERVER['DOCUMENT_ROOT'].'\firmresumedev\incl\connectFRdb.php');



if(isset($_GET['resumeID']))

{

    $pResumeID = $_GET['resumeID'];
    $data = array();


	//Get Resume IDs
/*
	$sql = "SELECT DISTINCT UniqueResumeID FROM v_ApprovedStandardResumes ORDER BY UniqueResumeID";
	$sqlresult = odbc_exec($connection,$sql);
	while ($row = odbc_fetch_array($sqlresult)) {
		$pResumeID = $row['UniqueResumeID'];
*/
		//Set Value of the following pages:  Title Page, Index, Introduction
		$pPages = 3;

		//Get count of pages in each section for each resume. 
		//Assumes, on average, content covers 9.25" (234.95mm) per page - aka 11" minus 3/4" top & bottom margin minus 1/4" for variable page breaks due to orphan and widow lines.
		$sql1 = "SELECT
					UniqueSectionID, 

					ceiling((
						sum(ParaHeight) -- ParaHeight
						+
						(Select Height From Sections Where SectionID = v.UniqueSectionID) --SectionHeight
						+
						((Select Count(Distinct ss.SubsectionID) from Subsections ss inner join v_ApprovedStandardResumes v1 On ss.SubsectionID = v1.SubsectionID and v1.SectionID = v.UniqueSectionID and ss.PrintOnPDF = 1 Group by v1.UniqueSectionID)
						*(Select Distinct (Height) from Subsections ss inner join v_ApprovedStandardResumes v1 On ss.SubsectionID = v1.SubsectionID and v1.SectionID = v.UniqueSectionID and ss.PrintOnPDF = 1))
						+
						(
						isnull((Select Count(Distinct ss.SubsectionID) from Subsections ss inner join v_ApprovedStandardResumes v1 On ss.SubsectionID = v1.SubsectionID and v1.SectionID = v.UniqueSectionID and ss.PrintOnPDF = 0 Group by v1.UniqueSectionID),0)
						*isnull((Select Distinct (Height) from Subsections ss inner join v_ApprovedStandardResumes v1 On ss.SubsectionID = v1.SubsectionID and v1.SectionID = v.UniqueSectionID and ss.PrintOnPDF = 0),0)) --Subsection Height
						) / 234.95) as CountSectionPages
				FROM v_ApprovedStandardResumes v
				WHERE UniqueResumeID = $pResumeID AND Bio <> 1 and Intro <> 1
				GROUP BY UniqueResumeID, UniqueSectionID, SectionName, SectionAssemblyOrder, SectionHeight
				Order by SectionAssemblyOrder";
		$sql1result = odbc_exec($connection,$sql1);
		while ($row1 = odbc_fetch_array($sql1result)) {
			$pPages = $pPages + $row1['CountSectionPages'];

		}

		//Get count of pages in Bio section for each resume
		//Assumes one of two scenarios:
		//either content covers more than 1/2 of the page and page break with only one bio record on the page
		//or if content is less than 1/2 of the page then on average, content covers 9.25" (234.95mm) per page.
		//Page 1 of the bio section separately calc'd to account for the section heading
		$sql2 = "SELECT DISTINCT
							floor(
							(
							(
								--1st paragraph of Bio Section + Bio Section Heading
								SELECT
								Case When (v.BioHeight + v.SectionHeight) < 120.65 Then  (v.BioHeight + v.SectionHeight) Else 234.95 End
								FROM v_ApprovedStandardResumes v
								Where v.Bio = 1 
								AND v.SectionAssemblyOrder = (SELECT min([SectionAssemblyOrder]) FROM v_ApprovedStandardResumes s Where s.Bio = 1) 
								AND v.SubsectionAssemblyOrder = (SELECT min([SubsectionAssemblyOrder]) FROM v_ApprovedStandardResumes ss Where ss.Bio = 1) 
								AND v.ParaAssemblyOrder = (SELECT min([ParaAssemblyOrder]) FROM v_ApprovedStandardResumes p Where p.Bio = 1) 
							)
							+
								--Bio Section Except 1st paragraph  Bio Section Heading
							(
								SELECT
								sum(Case When v.BioHeight < 120.65 Then v.BioHeight Else 234.95 End)
								FROM v_ApprovedStandardResumes v
								Where v.Bio = 1 
								AND v.ResumeAssemblyID NOT IN 
								(SELECT ResumeAssemblyID
								FROM v_ApprovedStandardResumes v
								Where v.Bio = 1 
								AND v.SectionAssemblyOrder = (SELECT min([SectionAssemblyOrder]) FROM v_ApprovedStandardResumes s Where s.Bio = 1) 
								AND v.SubsectionAssemblyOrder = (SELECT min([SubsectionAssemblyOrder]) FROM v_ApprovedStandardResumes ss Where ss.Bio = 1) 
								AND v.ParaAssemblyOrder = (SELECT min([ParaAssemblyOrder]) FROM v_ApprovedStandardResumes p Where p.Bio = 1) )
							) 
							) / 234.95) as CountBioPages

						FROM v_ApprovedStandardResumes v
						WHERE UniqueResumeID = $pResumeID";
		$sql2result = odbc_exec($connection,$sql2);
		while ($row2 = odbc_fetch_array($sql2result)) {
			$pPages = $pPages + $row2['CountBioPages'];
		}

$data[] = $pPages;

    $reply = array('data' => $data, 'error' => false);

} //close test for variable passed to ajax php file correctly
else
{
	$reply = 'This is a test';
//    $reply = array('data1' => $data1, 'error' => true);
}

$json = json_encode($reply);    
echo $json; 
?>
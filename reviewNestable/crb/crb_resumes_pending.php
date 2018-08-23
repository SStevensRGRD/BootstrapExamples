<script type="text/javascript" charset="utf-8">
$(document).ready(function () {
	$('#resumes_pending').dataTable( {
		"columnDefs": [
		{ "orderable": false, "targets": 0 },
		{ "orderable": false, "targets": 1 },
		{ "orderable": false, "targets": 8 },
		{ "searchable": false, "targets": 0 },
		{ "searchable": false, "targets": 1 },
		{ "searchable": false, "targets": 8 },
		{ "visible": false, "targets": 0 },
		{ "visible": false, "targets": 1 },
		]
	} );
});
</script>
<div id="pending">
	<div class="row">
		<div class="large-12 columns">
			<table id="resumes_pending" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Sort Order</th>
						<th>Resume Staging ID</th>
						<th>Resume Name</th>
						<th>Resume Title</th>
						<th>Resume Footer</th>
						<th>Comments</th>
						<th>Requested By</th>
						<th>Requested On</th>
						<th>Record Actions</th>
					</tr>
				</thead>
				<tbody>
<?php
	$sql =	"SELECT
						ResumeStagingID, 
						ResumeID, 
						ResumeName, 
						TitlePageText, 
						FooterText, 
						ImgFileName, 
						CONVERT(VARCHAR(10),Deadline,101) AS DeadlineFmt,
						Deadline, 
						Height, 
						SortOrder, 
						StdResume, 
						Case 
							When StdResume = 0 Then 'No' 
							When StdResume = 1 Then 'Yes' 
						End as StdResumeYN,
						Comments, 
						Reviewed, 
						Approved, 
						Deactivate, 
						RequestedByUserID, 
						(SELECT UserList.FullName from UserList Where UserID = RequestedByUserID) as RequestedByUser,
						CONVERT(VARCHAR(10),RequestedOnDtTm,101) AS RequestedOnDtTmFmt,
						RequestedOnDtTm, 
						ReviewedByUserID, 
						(SELECT UserList.FullName from UserList Where UserID = ReviewedByUserID) as ReviewedByUser,
						CONVERT(VARCHAR(10),ReviewedOnDtTm,101) AS ReviewedOnDtTmFmt,
						ReviewedOnDtTm, 
						ApprovedByUserID, 
						(SELECT UserList.FullName from UserList Where UserID = ApprovedByUserID) as ApprovedByUser,
						CONVERT(VARCHAR(10),ApprovedOnDtTm,101) AS ApprovedOnDtTmFmt,
						ApprovedOnDtTm, 
						Case 
							When Reviewed = 0 AND Approved = 0 Then 'Pending Review' 
							When Reviewed = 1 AND Approved = 0 Then 'Pending Approval' 
							When Reviewed = 1 AND Approved = 1 Then 'Approved' 
							When Reviewed = 0 AND Approved = 1 Then 'Approved Without Review' 
						End as Status
					FROM ResumesStaging Where CRB = 1
					--WHERE Deactivate = 0
					ORDER BY 	Deadline";
	$sqlresult = odbc_exec($connection,$sql);
	while ($row = odbc_fetch_array($sqlresult)) {
?>
						<tr>
							<td><?php echo $row['SortOrder']; ?></td>
							<td><?php echo $row['ResumeStagingID']; ?></td>
							<td><?php echo $row['ResumeName']; ?></td>
							<td><?php echo $row['TitlePageText']; ?></td>
							<td><?php echo $row['FooterText']; ?></td>
							<td><?php echo $row['Comments']; ?></td>
							<td><?php echo $row['RequestedByUser']; ?></td>
							<td><?php echo $row['RequestedOnDtTmFmt']; ?></td>
							<td>
								<a href="CRB_edit_p2.php?rid=<?php echo $row['ResumeStagingID'] ?>" class="hyperlink" style='color:#0000FF'>
									Edit
								</a>
								<br>
							</td>
						</tr>  
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
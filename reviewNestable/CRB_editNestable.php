<?php
//============================================================+
// File name   : CRB_ReviewNestable.php
// Begin       : 2017-01-06
// Last Update : 2017-01-06
//
// Description : Custom Resume Builder (part 2)
//
// Data Sources: 'v_ApprovedStandardResumes'
//
// Author: Sue Stevens
// Based on Examples Written by: Manuele J Sarfatti found here:
// http://mjsarfatti.com/sandbox/nestedSortable/
// and here:
// https://github.com/ilikenwf/nestedSortable
//============================================================+

//============================================================+
  session_start();

  if(!isset($_SESSION['UserID'])){
    header('location:index.php?user=invalid');
  }
  require_once('\incl\header.php');
  $userID = $_SESSION['UserID'];
  $usemode = $_SESSION['UseMode'];

  if(isset($_SESSION['datasource'])){
    $table = '[dbo].['.$_SESSION['datasource'].']';
  } else {
    $table = 'v_ApprovedStandardResumes';
  }

  if(isset($_SESSION['uniqueresumeID'])){
    $uniqueresumeID = $_SESSION['uniqueresumeID'];
  } 

  if(isset($_SESSION['path'])){
    $path = $_SESSION['path'];
  }


  if(isset($_SESSION['resumeID'])){
    $resumeID = $_SESSION['resumeID'];
  }

  if(isset($_SESSION['resumename'])){
    $resumename = $_SESSION['resumename'];
  }

  if(isset($_SESSION['resumetitle'])){
    $resumetitle = $_SESSION['resumetitle'];
  }

  if(isset($_SESSION['resumefooter'])){
    $resumefooter = $_SESSION['resumefooter'];
  }

  if(isset($_SESSION['inclTOC'])){
    $incltoc = $_SESSION['inclTOC'];
  }

  if(isset($_SESSION['stdresume'])){
    $stdresume = $_SESSION['stdresume'];
  }

  if(isset($_SESSION['rfp'])){
    $rfp = $_SESSION['rfp'];
  }

  if(isset($_SESSION['height'])){
    $height = $_SESSION['height'];
  }

  if(isset($_SESSION['image'])){
    $image = $_SESSION['image'];
  }

  if(isset($_SESSION['comments'])){
    $comments = $_SESSION['comments'];
  }

  if(isset($_SESSION['deadline'])){
    $deadline = $_SESSION['deadline'];
  }

  if(isset($_SESSION['pglength'])){
    $pglength = $_SESSION['pglength'];
  }

  if(isset($_SESSION['sortorder'])){
    $sortorder = $_SESSION['sortorder'];
  }

  if(isset($_SESSION['biospgbreak'])){
    $biospgbreak = $_SESSION['biospgbreak'];
  }

  $deactivate = 0;

  if (isset($_POST['next'])) {

    require_once('\incl\crb\update.php');
    header('location:'.$path);

  }

?>

<style type="text/css">
    
    body {
      -webkit-border-radius: 10px;
      -moz-border-radius: 10px;
      border-radius: 10px;
      color: #444;
      background-color: #fff;
      font-size: 13px;
      font-family: Freesans, sans-serif;
      padding: 2em 4em;
      width: 1000px;
      margin: 15px auto;
      box-shadow: 1px 1px 8px #444;
      -mox-box-shadow: 1px 1px 8px #444;
      -webkit-box-shadow: 1px -1px 8px #444;
    }
        
    .placeholder {
      outline: 1px dashed #4183C4;
    }
    
    .mjs-nestedSortable-error {
      background: #fbe3e4;
      border-color: transparent;
    }
    
    #tree {
      width: 550px;
      margin: 0;
    }
    
    ol {
      padding-left: 25px;
    }
    
    ol.sortable,ol.sortable ol {
      list-style-type: none;
    }
    
    .sortable li div {
      border: 1px solid #d4d4d4;
      -webkit-border-radius: 3px;
      -moz-border-radius: 3px;
      border-radius: 3px;
      cursor: move;
      border-color: #D4D4D4 #D4D4D4 #BCBCBC;
      margin: 0;
      padding: 3px;
    }
    
    li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
      border-color: #999;
    }
    
    .disclose, .expandEditor {
      cursor: pointer;
      width: 20px;
      display: none;
    }
    
    .sortable li.mjs-nestedSortable-collapsed > ol {
      display: none;
    }
    
    .sortable li.mjs-nestedSortable-branch > div > .disclose {
      display: inline-block;
    }
    
    .sortable span.ui-icon {
      display: inline-block;
      margin: 0;
      padding: 0;
    }
    
    .menuDiv {
      background: #EBEBEB;
    }
    
    .menuEdit {
      display: none;
      background: #FFF;
    }
    
    .itemTitle {
      vertical-align: middle;
      cursor: pointer;
    }
    
    .deleteMenu {
      float: right;
      cursor: pointer;
    }
    
    h1 {
      font-size: 2em;
      margin-bottom: 0;
    }
    
    h2 {
      font-size: 1.2em;
      font-weight: 400;
      font-style: italic;
      margin-top: .2em;
      margin-bottom: 1.5em;
    }
    
    h3 {
      font-size: 1em;
      margin: 1em 0 .3em;
    }
    
    p,ol,ul,pre,form {
      margin-top: 0;
      margin-bottom: 1em;
    }
    
    dl {
      margin: 0;
    }
    
    dd {
      margin: 0;
      padding: 0 0 0 1.5em;
    }
        
    .notice {
      color: #c33;
    }
    </style>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" />
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
  <script type="text/javascript" src="nestedSortable-master/jquery.mjs.nestedSortable.js"></script>
  
  <script>
$(document).ready(function(){
//    $().ready(function(){
      var ns = $('ol.sortable').nestedSortable({
        forcePlaceholderSize: true,
        handle: 'div',
        helper: 'clone',
        items: 'li',
        opacity: .6,
        placeholder: 'placeholder',
        revert: 250,
        tabSize: 300,
        tolerance: 'pointer',
        toleranceElement: '> div',
        maxLevels: 3,
        protectRoot: true,
        isTree: true,
        expandOnHover: 700,
        startCollapsed: true,





      create: function (event, ui) {
        var listorderi = $(this).nestedSortable('serialize');
        //console.log('Fired Create!');
        //console.log(listorderi);
        document.forms[0].listorder.value = listorderi;
      },

      update:  function(event, ui) {
        var listorder = $(this).nestedSortable('serialize');
        //console.log('Fired Update!');
        //console.log(listorder);
        document.forms[0].listorder.value = listorder;
      },

      });



      $('.expandEditor').attr('title','Click to show/hide item editor');
      $('.disclose').attr('title','Click to show/hide children');
      $('.deleteMenu').attr('title', 'Click to delete item.');
    
      $('.disclose').on('click', function() {
        $(this).closest('li').toggleClass('mjs-nestedSortable-expanded').toggleClass('mjs-nestedSortable-collapsed');
        $(this).toggleClass('ui-icon-minusthick').toggleClass('ui-icon-plusthick');
      });
      
      $('.expandEditor, .itemTitle').click(function(){
        var id = $(this).attr('data-id');
        $('#menuEdit'+id).toggle();
        $(this).toggleClass('ui-icon-triangle-1-n').toggleClass('ui-icon-triangle-1-s');
      });
      
      $('.deleteMenu').click(function(){
        var id = $(this).attr('data-id');
        $('#'+id).remove();
        var listorder = $('ol.sortable').nestedSortable('serialize');
        //console.log(listorder);
        //console.log('Delete!');
        document.forms[0].listorder.value = listorder;
      });


});
  
  </script>

<div class="row">
  <div class="large-12 columns">
    <nav aria-label="You are here:" role="navigation">
      <ul class="breadcrumbs">
        <li><a href="view.php">Home</a></li>
        <li><a href="CRB_resume.php">Custom Resume Builder</a></li>
        <li><a href="CRB_reviewNestable.php">Create Custom Resume</a></li>
      </ul>
    </nav>
  </div>
</div>

<div class="row">
  <div class="large-12 columns">
    <a name="CRB_Resume"></a>
    <h4 Style="text-align: center">Create Custom Resume</h4>
    <hr>
    <form action="" method="post" id="form_crbreviewnestable" name="form_crbreviewnestable" enctype="multipart/form-data">
      <div class="row">
        <div class="large-12 columns">Estimated Page Length:
          <input type="" id="pglength" name="pglength" style="border:hidden; background-color:transparent;" value="<?php echo $pglength; ?>" readonly>
        </div>
      </div>
      <hr>

      <div class="row">
        <div class="large-12 columns">
          <input type="hidden" id="listorder" name="listorder" value = "" />
        </div>
      </div>

<div id="wrap">
    <ol id="ResumeID_<?php echo 'resumeid'.$uniqueresumeID; ?>" class="sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded">

<?php      
//Section 
  $sqlsection = "SELECT DISTINCT
                  UniqueSectionID, 
                  SectionName,
                  SectionAssemblyOrder 
                  FROM $table
                  WHERE (UniqueResumeID = '$uniqueresumeID')
                  ORDER BY SectionAssemblyOrder";
  $sqlsectionresult = odbc_exec($connection,$sqlsection);
  while ($secrow = odbc_fetch_array($sqlsectionresult)){  
    $qsectionID = $secrow['UniqueSectionID'];
?>

       <li id="SectionID_<?php echo $secrow['UniqueSectionID']; ?>" style="display: list-item;" class="mjs-nestedSortable-branch mjs-nestedSortable-collapsed">
       <div class="menuDiv">
         <span title="Click to show/hide subsections" class="disclose ui-icon ui-icon-plusthick">
         <span></span>
         </span>
         <span>
         <span data-id="SectionID_<?php echo $secrow['UniqueSectionID']; ?>" class="itemTitle"><?php echo $secrow['SectionName']; ?></span>
         <span title="Click to delete item." data-id="SectionID_<?php echo $secrow['UniqueSectionID']; ?>" class="deleteMenu ui-icon ui-icon-closethick">
         <span></span>
         </span>
         </span>
       </div>

       <ol>
<?php      
//Subsection 
  $sqlsubsection = "SELECT DISTINCT
                  UniqueSectionID, 
                  UniqueSubsectionID,
                  SectionName,
                  SubsectionName,
                  SectionAssemblyOrder,
                  SubsectionAssemblyOrder,
                  Bio 
                  FROM $table
                  WHERE (UniqueResumeID = '$uniqueresumeID' AND UniqueSectionID = '$qsectionID')
                  ORDER BY SectionAssemblyOrder, SubsectionAssemblyOrder";
  $sqlsubsectionresult = odbc_exec($connection,$sqlsubsection);
  while ($subrow = odbc_fetch_array($sqlsubsectionresult)){    
    $qsubsectionID = $subrow['UniqueSubsectionID'];    
    $qbio = $subrow['Bio'];    
?>
       <li id="SubsectionID_<?php echo $subrow['UniqueSubsectionID']; ?>" style="display: list-item;" class="mjs-nestedSortable-branch mjs-nestedSortable-collapsed">
       <div class="menuDiv">
         <span title="Click to show/hide paragraphs" class="disclose ui-icon ui-icon-plusthick">
         <span></span>
         </span>
         <span>
         <span data-id="SubsectionID_<?php echo $subrow['UniqueSubsectionID']; ?>" class="itemTitle"><?php echo $subrow['SubsectionName']; ?></span>
         <span title="Click to delete item." data-id="SubsectionID_<?php echo $subrow['UniqueSubsectionID']; ?>" class="deleteMenu ui-icon ui-icon-closethick">
         <span></span>
         </span>
         </span>
       </div>

<?php 

if ($qbio == 0) {
?>
         <ol>
<?php      
//Paragraphs 
  $sqlcasepara = "SELECT DISTINCT
                  UniqueSectionID, 
                  UniqueSubsectionID,
                  UniqueCaseParaID,
                  SectionName,
                  SubsectionName,
                  ParaName,
                  CaseParagraphText,
                  SectionAssemblyOrder,
                  SubsectionAssemblyOrder,
                  ParaAssemblyOrder
                  FROM $table
                  WHERE isnull(UniqueCaseParaID,0) <> 0 AND 
                        (Bio = 0 AND UniqueResumeID = '$uniqueresumeID' AND UniqueSectionID = '$qsectionID' AND UniqueSubsectionID = '$qsubsectionID')
                  ORDER BY SectionAssemblyOrder, SubsectionAssemblyOrder, ParaAssemblyOrder";
  $sqlcasepararesult = odbc_exec($connection,$sqlcasepara);
  while ($caserow = odbc_fetch_array($sqlcasepararesult)){ 
?>
           <li id="CaseParaID_<?php echo $caserow['UniqueCaseParaID']; ?>" class="mjs-nestedSortable-leaf">
           <div class="menuDiv">
             <span title="Click to show/hide item paragraphs" data-id="CaseParaID_<?php echo $caserow['UniqueCaseParaID']; ?>" class="expandEditor ui-icon ui-icon-triangle-1-n">
             <span></span>
             </span>
             <span>
             <span data-id="CaseParaID_<?php echo $caserow['UniqueCaseParaID']; ?>" class="itemTitle"><?php echo $caserow['ParaName']; ?></span>
             <span title="Click to delete item." data-id="CaseParaID_<?php echo $caserow['UniqueCaseParaID']; ?>" class="deleteMenu ui-icon ui-icon-closethick">
             <span></span>
             </span>
             </span>
             <div id="menuEditCaseParaID_<?php echo $caserow['UniqueCaseParaID']; ?>" class="menuEdit hidden">
               <p>
                 <?php echo strip_tags(html_entity_decode($caserow['CaseParagraphText']),".<p></p><strong></strong><em></em><i></i><blockquote></blockquote>"); ?>
               </p>
             </div>
           </div>
           </li>
<?php } //End Paragraphs ?>
     </ol>

<?php
} else {
?>

         <ol>
<?php      
//Bios Paragraphs 
  $sqlbio = "SELECT DISTINCT
                  UniqueSectionID, 
                  UniqueSubsectionID,
                  UniqueBioID,
                  SectionName,
                  SubsectionName,
                  ParaName,
                  BioParagraphText,
                  BioEduText,
                  BioAwardsText,
                  SectionAssemblyOrder,
                  SubsectionAssemblyOrder,
                  ParaAssemblyOrder
                  FROM $table
                  WHERE isnull(UniqueBioID,0) <> 0 
                  AND UniqueResumeID = '$uniqueresumeID' AND UniqueSectionID = '$qsectionID' AND UniqueSubsectionID = '$qsubsectionID'
                  ORDER BY SectionAssemblyOrder, SubsectionAssemblyOrder, ParaAssemblyOrder";
//echo $sqlbio;                  
  $sqlbioresult = odbc_exec($connection,$sqlbio);
  while ($biorow = odbc_fetch_array($sqlbioresult)){ 
?>

           <li id="BioID_<?php echo $biorow['UniqueBioID']; ?>" class="mjs-nestedSortable-leaf">
           <div class="menuDiv">
             <span title="Click to show/hide item editor" data-id="BioID_<?php echo $biorow['UniqueBioID']; ?>" class="expandEditor ui-icon ui-icon-triangle-1-n">
             <span></span>
             </span>
             <span>
             <span data-id="BioID_<?php echo $biorow['UniqueBioID']; ?>" class="itemTitle"><?php echo $biorow['ParaName']; ?></span>
             <span title="Click to delete item." data-id="BioID_<?php echo $biorow['UniqueBioID']; ?>" class="deleteMenu ui-icon ui-icon-closethick">
             <span></span>
             </span>
             </span>
             <div id="menuEditBioID_<?php echo $biorow['UniqueBioID']; ?>" class="menuEdit hidden">
               <p>
                 <?php echo html_entity_decode($biorow['BioParagraphText']); ?>
               </p>
               <p>
                 <b>Education: </b><?php echo html_entity_decode($biorow['BioEduText']); ?>
               </p>
               <p>
                 <b>Awards: </b><?php echo html_entity_decode($biorow['BioAwardsText']); ?>
               </p>
             </div>
           </div>
           </li>

<?php } //End Bios ?>
     </ol>


<?php } //End Else
?>

       </li>
<?php } //End Subsection ?>
     </ol>

       </li>
<?php } //End Section ?>
     </ol>
</div>




<div class="row">
<div class="large-12 columns">
<p>
<input type="submit" class="button" value="Next" name="next">
<a href="view.php" class="button">Cancel</a>
</p>
</div>
</div>


</form>

</div>
</div>
</body>
</html>
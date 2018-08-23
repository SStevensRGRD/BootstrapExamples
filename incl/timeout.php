<?php
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    // last request was more than 60 minutes ago 3600
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
	header('location:index.php?user=timeout');    
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
?>
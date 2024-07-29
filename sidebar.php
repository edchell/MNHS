
<style>
a{
    font-size: 2rem
}
</style>
<?php 
include 'db.php';

// Initialize $school_year with a default value
$school_year = '';

// Execute query
$query = mysqli_query($conn, "SELECT * FROM school_year WHERE status='Yes'");

// Check if query execution was successful and if any rows are returned
if ($query && mysqli_num_rows($query) > 0) {
    $s = mysqli_fetch_assoc($query);
    // Check if the array $s contains the 'school_year' key
    if (isset($s['school_year'])) {
        $school_year = $s['school_year'];
    }
} else {
    // Handle cases where query fails or returns no rows
    // Optionally, log the error or set $school_year to a default value
    error_log('Query failed or no rows returned.');
}

// Close the database connection
mysqli_close($conn);
?>

<!-- Your HTML content here -->
<ul class="nav navbar-nav side-nav">
 <li>
    <a href="rms.php?page=home"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
 </li>
 <li>
    <a id=demo1 href="javascript:void(0)" data-toggle="collapse" data-target="#masterlistCollapse"><i class="fa fa-fw fa-files-o"></i> Master List <i class="fa fa-fw fa-caret-down"></i></a>
    <ul id="masterlistCollapse" class="collapse">
        <li>
            <a href="rms.php?page=Students"><i class="fa fa-fw fa-users"></i> Students List</a>
        </li>
        <li class="">
            <a href="rms.php?page=subjects"><i class="fa fa-fw fa-book"></i> Subjects List</a>
        </li>
    </ul>
 </li>
 <li>
    <a href="javascript:void(0)" data-toggle="collapse" data-target="#recordsCollapse"><i class="fa fa-fw fa-file"></i> Records       <i class="fa fa-fw fa-caret-down"></i></a>
    <ul class="collapse" id="recordsCollapse">
        <li>
            <a href="rms.php?page=records"><i class="fa fa-fw fa-files-o"></i>Academic Record </a>
        </li>
        <!-- Commented out items -->
        <!-- <li>
            <a href="rms.php?page=candidates&sy=<?php echo htmlspecialchars($school_year, ENT_QUOTES, 'UTF-8'); ?>"><i class="fa fa-fw fa-users"></i> Promote Candidates </a>
        </li> -->
        <!-- <li>
            <a href="rms.php?page=candidates_list&sy=<?php echo htmlspecialchars($school_year, ENT_QUOTES, 'UTF-8'); ?>"><i class="fa fa-fw fa-file-o"></i> Candidates List </a>
        </li> -->
    </ul>
 </li>
 <li>
    <a href="javascript:void(0)" data-toggle="collapse" data-target="#reportsCollapse"><i class="fa fa-fw fa-file"></i> Reports       <i class="fa fa-fw fa-caret-down"></i></a>
    <ul id="reportsCollapse" class="collapse">
        <li>
            <a href="rms.php?page=report"><i class="fa fa-fw fa-files-o"></i> Form 137</a>
        </li>
    </ul>
 </li>
 <li>
    <a href="javascript:void(0)" data-toggle="collapse" data-target="#maintenanceCollapse"><i class="fa fa-fw fa-gears"></i> Maintenance       <i class="fa fa-fw fa-caret-down"></i></a>
    <ul id="maintenanceCollapse" class="collapse">
        <li>
            <a href="rms.php?page=school_year"><i class="fa fa-fw fa-calendar"></i>School Year</a>
        </li>
        <li>
            <a href="rms.php?page=grade"><i class="fa fa-fw fa-file-text-o"></i> Grade List</a>
        </li>
    </ul>
 </li>
 <li>
    <a href="rms.php?page=users"><i class="fa fa-users"></i> Users</a>
 </li>
</ul>
<script>
    $('.side-nav li a').each(function(){
        if((location.href).includes($(this).attr('href')) == true){
            $(this).closest('li').addClass("active");
            console.log($(this).closest('li').parent('ul').attr('id'));
            if($(this).closest('li').parent('ul').hasClass('collapse') == true){
                $('[data-target="#'+$(this).closest('li').parent('ul').attr('id')+'"]').click();
            }
        }
    });
</script>

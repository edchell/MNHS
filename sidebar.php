<?php 
include 'db.php';

$query = mysqli_query($conn, "SELECT * FROM school_year WHERE status='No'");
$s = mysqli_fetch_assoc($query);
$school_year = $s['school_year'];
?>

<ul class="nav navbar-nav side-nav">
    <li>
        <a href="rms.php?page=home"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
    </li>
    <li>
        <a href="javascript:void(0)" data-toggle="collapse" data-target="#masterlistCollapse">
            <i class="fa fa-fw fa-files-o"></i> Master List <i class="fa fa-fw fa-caret-down"></i>
        </a>
        <ul id="masterlistCollapse" class="collapse">
            <li>
                <a href="rms.php?page=Students"><i class="fa fa-fw fa-users"></i> Students List</a>
            </li>
            <li>
                <a href="rms.php?page=subjects"><i class="fa fa-fw fa-book"></i> Subjects List</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="javascript:void(0)" data-toggle="collapse" data-target="#recordsCollapse">
            <i class="fa fa-fw fa-file"></i> Records <i class="fa fa-fw fa-caret-down"></i>
        </a>
        <ul id="recordsCollapse" class="collapse">
            <li>
                <a href="rms.php?page=records"><i class="fa fa-fw fa-files-o"></i> Academic Record</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="javascript:void(0)" data-toggle="collapse" data-target="#reportsCollapse">
            <i class="fa fa-fw fa-file"></i> Reports <i class="fa fa-fw fa-caret-down"></i>
        </a>
        <ul id="reportsCollapse" class="collapse">
            <li>
                <a href="rms.php?page=report"><i class="fa fa-fw fa-files-o"></i> Form 137</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="rms.php?page=users"><i class="fa fa-fw fa-users"></i> Users</a>
    </li>
    <li>
        <a href="rms.php?page=archive"><i class="fa fa-fw fa-archive"></i> Archived</a>
    </li>
    <li>
        <a href="javascript:void(0)" data-toggle="collapse" data-target="#maintenanceCollapse">
            <i class="fa fa-fw fa-gears"></i> Maintenance <i class="fa fa-fw fa-caret-down"></i>
        </a>
        <ul id="maintenanceCollapse" class="collapse">
            <li>
                <a href="rms.php?page=school_year"><i class="fa fa-fw fa-calendar"></i> School Year</a>
            </li>
            <li>
                <a href="rms.php?page=grade"><i class="fa fa-fw fa-file-text-o"></i> Grade List</a>
            </li>
        </ul>
    </li>
</ul>

<script>
    $(document).ready(function() {
        // Highlight active menu item
        $('.side-nav li a').each(function() {
            if (location.href.includes($(this).attr('href'))) {
                $(this).closest('li').addClass("active");

                // Expand the parent collapse menu if needed
                var parentCollapse = $(this).closest('li').parent('ul');
                if (parentCollapse.hasClass('collapse')) {
                    $('[data-target="#' + parentCollapse.attr('id') + '"]').click();
                }
            }
        });
    });
</script>

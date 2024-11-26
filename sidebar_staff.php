
<?php 
include 'db.php';

$query = mysqli_query($conn,"SELECT * FROM school_year where status='Yes' ");
$s = mysqli_fetch_assoc($query);
$school_year=$s['school_year'];
?>




 <ul class="nav navbar-nav side-nav">
 <li style="background-color: transparent;">
<a href="rms.php?page=home"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
</li>
<li style="background-color: transparent;">
<a id=demo1 href="javascript:void(0)" data-toggle="collapse" data-target="#masterlistCollapse"><i class="fa fa-fw fa-files-o"></i> Master List <i class="fa fa-fw fa-caret-down"></i></a>
<ul id="masterlistCollapse" class="collapse">
<li style="background-color: transparent;">
        <a href="rms.php?page=grade7"><i class="fa fa-fw fa-minus"></i> Grade 7</a>
    </li>
    <li style="background-color: transparent;">
        <a href="rms.php?page=grade8"><i class="fa fa-fw fa-minus"></i> Grade 8</a>
    </li>
    <li style="background-color: transparent;">
        <a href="rms.php?page=grade9"><i class="fa fa-fw fa-minus"></i> Grade 9</a>
    </li>
    <li style="background-color: transparent;">
        <a href="rms.php?page=grade10"><i class="fa fa-fw fa-minus"></i> Grade 10</a>
    </li>
    <li style="background-color: transparent;">
        <a href="rms.php?page=grade11"><i class="fa fa-fw fa-minus"></i> Grade 11</a>
    </li>
    <li style="background-color: transparent;">
        <a href="rms.php?page=grade12"><i class="fa fa-fw fa-minus"></i> Grade 12</a>
    </li>
    <li class="" style="background-color: transparent;">
        <a href="rms.php?page=subjects"><i class="fa fa-fw fa-book"></i> Subjects List</a>
    </li>
</ul>
</li>
<li style="background-color: transparent;">
    <a href="javascript:void(0)" data-toggle="collapse" data-target="#recordsCollapse"><i class="fa fa-fw fa-file"></i> Records       <i class="fa fa-fw fa-caret-down"></i></a>
    <ul class="collapse" id="recordsCollapse">
        <li>
            <a href="rms.php?page=records"><i class="fa fa-fw fa-files-o"></i>Academic Record </a>
        </li>
    </ul>
</li>
<li style="background-color: transparent;">
    <a href="javascript:void(0)" data-toggle="collapse" data-target="#reportsCollapse"><i class="fa fa-fw fa-file"></i> Reports       <i class="fa fa-fw fa-caret-down"></i></a>
    <ul id="reportsCollapse" class="collapse">
        <li style="background-color: transparent;">
            <a href="rms.php?page=report"><i class="fa fa-fw fa-files-o"></i> Form 137</a>
        </li>
    </ul>
</li>
</ul>
<script>
    $('.side-nav li a').each(function(){
        if((location.href).includes($(this).attr('href')) == true){
            $(this).closest('li').addClass("active")
            console.log($(this).closest('li').parent('ul').attr('id'))
            if($(this).closest('li').parent('ul').hasClass('collapse') == true){
                $('[data-target="#'+$(this).closest('li').parent('ul').attr('id')+'"]').click()
            }
        }
    })
</script>

                
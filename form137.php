<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="images/logo.jpg">
    <title>MNHS - Student Grading System</title>
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/css/styles.css" rel="stylesheet">
    <link href="asset/css/sb-admin.css" rel="stylesheet">
    <link href="asset/css/plugins/morris.css" rel="stylesheet">
    <link href="asset/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="datatables/jquery.dataTables.js"></script>
    <script src="datatables/dataTables.bootstrap.js"></script>
    <link href="datatables/dataTables.bootstrap.css" rel="stylesheet">
    <script src="assets/js/jquery.min.js"></script>
    <script src="asset/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/ie-emulation-modes-warning.js"></script>
    <script src="assets/js/jq.js"></script>
</head>
<style>
    * {
        margin: 0 auto;
        padding: 0;
    }
    body {
        background-color: white;
        color: black;
        font-size: 15px;
    }
    .printContainer {
        text-align: center;
        margin-top: 2%;
        width: 100%;
    }
    .btn-head {
        margin-left: 2%
    }
    .left-head {
        text-align: left;
    }
    .left-head p {
        margin-bottom: 2px;
        margin-left: 10%;
    }
    .center-head {
        display:flex;
        align-items:center;
        justify-content:space-between;
    }
    .kd {
        width:220px;
        height:200px;
    }
    .deped {
        width:230px;
        height:230px;
    }


    @media print {
        .btn-head {
            visibility: hidden;
        }
        .left-head {
            text-align: left;
        }
        .left-head p {
            margin-bottom: -3px;
            margin-left: 0;
        }
        .printContainer {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
        }
        .kd {
            width:140px;
            height:120px;
        }
        .deped {
            width:190px;
            height:190px;
        }
    }
</style>
<body>
    <div class="btn-head">
        <button class="btn btn-info" onclick="window.print()">Print</button>
        <button class="btn btn-info" onclick="window.close()">Cancel</button>
    </div>
	<div class="printContainer">
		<div class="left-head">
			<p>DepEd Form 137-A</p>
			<p>LRN No.</p>
		</div>
        <br>
        <div class="center-head">
			<div>
				<img src="images/logo.png" alt="" class="kd">
			</div>
			<div>
				<p>Department of Education</p>
				<p>Region VII</p>
				<p>Province of Cebu</p>
				<p><b>Madridejos National High School</b></p>
				<p>Poblacion, Madridejos, Cebu</p>
			</div>
			<div>
				<img src="images/deped.png" alt="" class="deped">
			</div>
		</div>
        <p><b><h4>SECONDARY STUDENT' PERMANENT RECORD</h4></b></p>
	</div>
</body>
</html>
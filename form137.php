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
    }
    .printContainer {
        text-align: center;
    }
    .btn-head {
        margin-left: 2%
    }
    .center-head {
        display:flex;
        align-items:center;
        justify-content:space-between;
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
        }
        .printContainer {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
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
				<img src="images/logo.png" alt="" style="width:90px;height:90px;">
			</div>
			<div>
				<p>Department of Education</p>
				<p>Region VII</p>
				<p>Province of Cebu</p>
				<p><b>Madridejos National High School</b></p>
				<p>Poblacion, Madridejos, Cebu</p>
			</div>
			<div>
				<img src="images/deped.png" alt="" style="width:120px;height:120px;">
			</div>
		</div>
	</div>
</body>
</html>
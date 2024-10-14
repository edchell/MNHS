<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['USER'])) { 
    header("HTTP/1.0 404 Not Found"); // Set the response status to 404
    exit();
}

include('../includes/header.php');
include('include/topnav.php');
include('include/sidebar.php');
include('academic_code.php');
?>

<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="row">
						<div class="col-xl-12 col-lg-8 col-md-8 col-sm-12 mb-30">
							<div class="card-box height-100-p overflow-hidden">
								<div class="profile-tab height-100-p">
									<div class="tab height-100-p">
										<ul class="nav nav-tabs customtab p-3 d-flex align-items-center justify-content-between" role="tablist">
                                            <div class="text-start">
											<h3 class="text-primary">
                                            <?php
                                                include '../includes/config.php';
                                                $id = $_GET['student_id'];
                                                $sql=  mysqli_query($conn, "SELECT * FROM student_info where STUDENT_ID = '$id' ");
                                                while($row = mysqli_fetch_assoc($sql)) {
                                                ?>
                                                    <h3 class="text-primary"><?php echo $row['LASTNAME'] . ', ' . $row['FIRSTNAME']. ' ' . $row['MIDDLENAME'] ?></h3>
                                                    <?php
                                                } mysqli_close($conn);
                                            ?>
                                            </h3>
                                            <br>
                                            <label for="">Select Grade</label>
                                            <select class="custom-select col-3" name="" id="">
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                            </div>
                                            <div class="text-end">
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#addSubjectModal">
                                                    <i class="fa fa-user-plus"></i> Add Record
                                                </button>
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#addSubjectModal">
                                                    <i class="fa fa-user-plus"></i> Update Record
                                                </button>
                                            </div>
										</ul>
										<div class="tab-content">

											<!-- Setting Tab start -->
											<div class="tab-pane fade height-100-p active show" id="setting" role="tabpanel">
												<div class="profile-setting">
                                                    <div class="d-flex -align-items-justify-content-between">
														<div class="form-group mx-3 col-md-4">
															<label>Lastname</label>
														    <input class="form-control form-control-lg" type="text" name="lastname" value="<?php echo htmlspecialchars($student['LASTNAME']); ?>">
														</div>
													    <div class="form-group mx-3 col-md-4">
															<label>Firstname</label>
																<input class="form-control form-control-lg" type="text" name="firstname" value="<?php echo htmlspecialchars($student['FIRSTNAME']); ?>">
															</div>
                                                        <div class="form-group mx-3 col-md-4">
															<label>Middlename</label>
															<input class="form-control form-control-lg" type="text" name="middlename" value="<?php echo htmlspecialchars($student['MIDDLENAME']); ?>">
														</div>
                                                    </div>
												</div>
											</div>
											<!-- Setting Tab End -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

<?php
include('../includes/footer.php');
?>
<?php
include('../includes/header.php');
include('include/topnav.php');
include('include/sidebar.php');
include('student_code.php');

// Check if the user is not logged in
if (!isset($_SESSION['FIRSTNAME']) && !isset($_SESSION['LASTNAME'])) { 
    header("HTTP/1.0 404 Not Found"); // Set the response status to 404
    include("404.php"); // Include your 404 page
    exit();
}
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
											<h3 class="text-primary">Student Personal Details</h3>
											<a href="db.php?page=student_list" class="btn btn-primary">BACK</a>
										</ul>
										<div class="tab-content">

											<!-- Setting Tab start -->
											<div class="tab-pane fade height-100-p active show" id="setting" role="tabpanel">
												<div class="profile-setting">
													<form action="student_update.php" method="POST">
                                                    <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student['STUDENT_ID']); ?>">
														<div class="profile-edit-list row">
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
                                                            <div class="d-flex -align-items-justify-content-between">
																<div class="form-group mx-3 col-md-4">
																	<label>LRN No.</label>
																	<input class="form-control form-control-lg" type="text" name="lrn_no" value="<?php echo htmlspecialchars($student['LRN_NO']); ?>">
																</div>
																<div class="col-sm-12 mx-4 col-md-4">
                                                                    <label>Gender</label>
                                                                    <select class="custom-select col-12" name="gender">
                                                                        <option value="" disabled>Select Gender</option>
                                                                        <option value="male" <?php echo $student['GENDER'] == 'male' ? 'selected' : ''; ?>>Male</option>
                                                                        <option value="female" <?php echo $student['GENDER'] == 'female' ? 'selected' : ''; ?>>Female</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group mx-4 col-md-4">
																	<label>Date of Birth</label>
																	<input class="form-control date-picker" placeholder="Select Birtdate" type="text" name="dob" value="<?php echo htmlspecialchars($student['DATE_OF_BIRTH']); ?>">
																</div>
                                                            </div>
                                                            <div class="d-flex -align-items-justify-content-between">
																<div class="form-group mx-3 col-md-9">
																	<label>Birth Place</label>
																	<input class="form-control form-control-lg" type="text" name="birth_place" value="<?php echo htmlspecialchars($student['BIRTH_PLACE']); ?>">
																</div>
																<div class="form-group mx-3 col-md-9">
																	<label>Address</label>
																	<input class="form-control form-control-lg" type="text" name="address" value="<?php echo htmlspecialchars($student['ADDRESS']); ?>">
																</div>
                                                            </div>
                                                            <div class="d-flex -align-items-justify-content-between">
																<div class="form-group mx-3 col-md-9">
																	<label>Parent/Guardian</label>
																	<input class="form-control form-control-lg" type="text" name="parent_guardian" value="<?php echo htmlspecialchars($student['PARENT_GUARDIAN']); ?>">
																</div>
																<div class="form-group mx-3 col-md-9">
																	<label>Parent/Guardian Address</label>
																	<input class="form-control form-control-lg" type="text" name="p_address" value="<?php echo htmlspecialchars($student['P_ADDRESS']); ?>">
																</div>
                                                            </div>
                                                                <h3 class="text-primary p-3">Intermediate Course Details</h3>
                                                                <div class="d-flex -align-items-justify-content-between">
                                                                    <div class="form-group mx-3 col-md-9">
                                                                        <label>School Completed</label>
                                                                        <input class="form-control form-control-lg" type="text" name="school_completed" value="<?php echo htmlspecialchars($student['INT_COURSE_COMP']); ?>">
                                                                    </div>
                                                                    <div class="form-group mx-3 col-md-9">
                                                                        <label>School Year</label>
                                                                        <input class="form-control form-control-lg" type="text" name="school_year" value="<?php echo htmlspecialchars($student['SCHOOL_YEAR']); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex -align-items-justify-content-between">
                                                                    <div class="form-group mx-3 col-md-9">
                                                                        <label>General Average</label>
                                                                        <input class="form-control form-control-lg" type="text" name="gen_ave" value="<?php echo htmlspecialchars($student['GEN_AVE']); ?>">
                                                                    </div>
                                                                    <div class="form-group mx-3 col-md-9">
                                                                        <label>Total No. of Years</label>
                                                                        <input class="form-control form-control-lg" type="text" name="total_no_of_years" value="<?php echo htmlspecialchars($student['TOTAL_NO_OF_YEARS']); ?>">
                                                                    </div>
                                                                </div>
                                                                </div>
                                                                        <button class="btn btn-primary pull-right mb-3 mx-4 mt-4 col-2">Update</button>
                                                        </div>
													</form>
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DepEd Form 137 - High School</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        fieldset {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 15px;
        }
        legend {
            font-weight: bold;
            padding: 0 10px;
        }
        label {
            display: block;
            margin: 5px 0;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        textarea {
            resize: vertical;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>DepEd Form 137 - High School</h1>
        <form action="submit_form.php" method="post"> <!-- Form action and method -->
            
            <!-- Learner's Information -->
            <fieldset>
                <legend>Learner's Information</legend>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" required>

                <label for="middlename">Middle Name:</label>
                <input type="text" id="middlename" name="middlename" required>

                <label for="lrn">LRN (Learner Reference Number):</label>
                <input type="text" id="lrn" name="lrn" required>

                <label for="birth_date">Date of Birth:</label>
                <input type="date" id="birth_date" name="birth_date" required>

                <label for="sex">Sex:</label>
                <select id="sex" name="sex" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>

                <label for="shs_admission_date">Date of SHS Admission (MM/DD/YYYY):</label>
                <input type="date" id="shs_admission_date" name="shs_admission_date" required>
            </fieldset>

            <!-- Eligibility for SHS Enrollment -->
            <fieldset>
                <legend>Eligibility for SHS Enrollment</legend>
                <label for="high_school_completer">High School Completer*:</label>
                <input type="text" id="high_school_completer" name="high_school_completer" required>

                <label for="gen_ave_hs">Gen. Ave.:</label>
                <input type="text" id="gen_ave_hs" name="gen_ave_hs" required>

                <label for="junior_high_school_completer">Junior High School Completer:</label>
                <input type="text" id="junior_high_school_completer" name="junior_high_school_completer" required>

                <label for="gen_ave_jh">Gen. Ave.:</label>
                <input type="text" id="gen_ave_jh" name="gen_ave_jh" required>

                <label for="graduation_date">Date of Graduation/Completion (MM/DD/YYYY):</label>
                <input type="date" id="graduation_date" name="graduation_date" required>

                <label for="school_name">Name of School:</label>
                <input type="text" id="school_name" name="school_name" required>

                <label for="school_address">School Address:</label>
                <textarea id="school_address" name="school_address" rows="3" required></textarea>

                <label for="pept_passer">PEPT Passer**:</label>
                <input type="text" id="pept_passer" name="pept_passer">

                <label for="pept_rating">Rating:</label>
                <input type="text" id="pept_rating" name="pept_rating">

                <label for="als_ae">ALS A&E:</label>
                <input type="text" id="als_ae" name="als_ae">

                <label for="als_rating">Rating:</label>
                <input type="text" id="als_rating" name="als_rating">

                <label for="others_specify">Others (Pls. Specify):</label>
                <input type="text" id="others_specify" name="others_specify">

                <label for="exam_date">Date of Examination/Assessment (MM/DD/YYYY):</label>
                <input type="date" id="exam_date" name="exam_date">

                <label for="community_learning_center">Name and Address of Community Learning Center:</label>
                <textarea id="community_learning_center" name="community_learning_center" rows="3"></textarea>
            </fieldset>

            <!-- Scholastic Record -->
            <fieldset>
                <legend>Scholastic Record</legend>
                <label for="school">SCHOOL:</label>
                <input type="text" id="school" name="school" required>

                <label for="school_id">SCHOOL ID:</label>
                <input type="text" id="school_id" name="school_id" required>

                <label for="grade_level">GRADE LEVEL:</label>
                <input type="text" id="grade_level" name="grade_level" required>

                <label for="school_year">SY (School Year):</label>
                <input type="text" id="school_year" name="school_year" required>

                <label for="semester">SEM (Semester):</label>
                <input type="text" id="semester" name="semester" required>

                <label for="track_strand">TRACK/STRAND:</label>
                <input type="text" id="track_strand" name="track_strand" required>

                <label for="section">SECTION:</label>
                <input type="text" id="section" name="section" required>

                <!-- Subjects Table -->
                <h2>Subjects</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Indicate if Subject is CORE, APPLIED, or SPECIALIZED</th>
                            <th>SUBJECTS</th>
                            <th>Quarter First</th>
                            <th>Quarter Second</th>
                            <th>SEM FINAL GRADE</th>
                            <th>ACTION TAKEN</th>
                            <th>REMARK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Example data rows; replace this with your dynamic data
                        $rows = [
                            [
                                'subject_type' => 'CORE',
                                'subject' => 'Mathematics',
                                'quarter_first' => '85',
                                'quarter_second' => '90',
                                'sem_final_grade' => '87',
                                'action_taken' => 'Passed',
                                'remark' => 'Excellent'
                            ],
                            [
                                'subject_type' => 'APPLIED',
                                'subject' => 'Computer Science',
                                'quarter_first' => '88',
                                'quarter_second' => '92',
                                'sem_final_grade' => '90',
                                'action_taken' => 'Passed',
                                'remark' => 'Good'
                            ],
                            // Add more rows as needed
                        ];

                        foreach ($rows as $index => $row) {
                            echo '<tr>';
                            echo '<td><input type="text" name="subject_type_' . ($index + 1) . '" value="' . htmlspecialchars($row['subject_type']) . '" required></td>';
                            echo '<td><input type="text" name="subject_' . ($index + 1) . '" value="' . htmlspecialchars($row['subject']) . '" required></td>';
                            echo '<td><input type="text" name="quarter_first_' . ($index + 1) . '" value="' . htmlspecialchars($row['quarter_first']) . '" required></td>';
                            echo '<td><input type="text" name="quarter_second_' . ($index + 1) . '" value="' . htmlspecialchars($row['quarter_second']) . '" required></td>';
                            echo '<td><input type="text" name="sem_final_grade_' . ($index + 1) . '" value="' . htmlspecialchars($row['sem_final_grade']) . '" required></td>';
                            echo '<td><input type="text" name="action_taken_' . ($index + 1) . '" value="' . htmlspecialchars($row['action_taken']) . '" required></td>';
                            echo '<td><input type="text" name="remark_' . ($index + 1) . '" value="' . htmlspecialchars($row['remark']) . '" required></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Certification Section -->
                <fieldset>
                    <legend>Certification</legend>
                    <label for="date_checked">Date Checked (MM/DD/YYYY):</label>
                    <input type="date" id="date_checked" name="date_checked" required>

                    <label for="certified_true">Certified True and Correct:</label>
                    <input type="text" id="certified_true" name="certified_true" required>

                    <label for="signature_adviser">Signature of Adviser over Printed Name:</label>
                    <input type="text" id="signature_adviser" name="signature_adviser" required>

                    <label for="signature_authorized">Signature of Authorized Person over Printed Name:</label>
                    <input type="text" id="signature_authorized" name="signature_authorized" required>

                    <label for="designation">Designation:</label>
                    <input type="text" id="designation" name="designation" required>

                    <label for="conducted_from">Conducted from (MM/DD/YYYY):</label>
                    <input type="date" id="conducted_from" name="conducted_from" required>

                    <label for="conducted_to">to (MM/DD/YYYY):</label>
                    <input type="date" id="conducted_to" name="conducted_to" required>

                    <label for="certification_school">SCHOOL:</label>
                    <input type="text" id="certification_school" name="certification_school" required>

                    <label for="certification_school_id">SCHOOL ID:</label>
                    <input type="text" id="certification_school_id" name="certification_school_id" required>
                </fieldset>
            </fieldset>

            <!-- Submit Button -->
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>

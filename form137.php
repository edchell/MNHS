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
        <h1>DepEd Form 137 - High School (Form 10)</h1>

        <!-- Learner's Information -->
        <fieldset>
            <legend>Learner's Information</legend>
            <label for="lrn">LRN (Learner Reference Number):</label>
            <input type="text" id="lrn" name="lrn" required>

            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required>

            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required>

            <label for="middlename">Middle Name:</label>
            <input type="text" id="middlename" name="middlename" required>

            <label for="birth_date">Date of Birth:</label>
            <input type="date" id="birth_date" name="birth_date" required>

            <label for="sex">Sex:</label>
            <select id="sex" name="sex" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="3" required></textarea>

            <label for="school_name">Name of School:</label>
            <input type="text" id="school_name" name="school_name" required>

            <label for="school_address">School Address:</label>
            <textarea id="school_address" name="school_address" rows="3" required></textarea>
        </fieldset>

        <!-- Scholastic Record -->
        <fieldset>
            <legend>Scholastic Record</legend>
            <label for="school_year">School Year:</label>
            <input type="text" id="school_year" name="school_year" required>

            <label for="grade_level">Grade Level:</label>
            <input type="text" id="grade_level" name="grade_level" required>

            <label for="semester">Semester:</label>
            <input type="text" id="semester" name="semester" required>

            <!-- Subjects Table -->
            <h2>Subjects</h2>
            <table>
                <thead>
                    <tr>
                        <th>Subject Type</th>
                        <th>Subject Name</th>
                        <th>Quarter 1</th>
                        <th>Quarter 2</th>
                        <th>Quarter 3</th>
                        <th>Quarter 4</th>
                        <th>Final Grade</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Example data rows; replace this with your dynamic data
                    $rows = [
                        [
                            'subject_type' => 'Core',
                            'subject_name' => 'Mathematics',
                            'quarter1' => '85',
                            'quarter2' => '90',
                            'quarter3' => '88',
                            'quarter4' => '92',
                            'final_grade' => '89',
                            'remarks' => 'Passed'
                        ],
                        [
                            'subject_type' => 'Core',
                            'subject_name' => 'English',
                            'quarter1' => '87',
                            'quarter2' => '91',
                            'quarter3' => '90',
                            'quarter4' => '93',
                            'final_grade' => '90',
                            'remarks' => 'Passed'
                        ],
                        // Add more rows as needed
                    ];

                    foreach ($rows as $index => $row) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['subject_type']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['subject_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['quarter1']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['quarter2']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['quarter3']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['quarter4']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['final_grade']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['remarks']) . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </fieldset>

        <!-- Certification Section -->
        <fieldset>
            <legend>Certification</legend>
            <label for="certification_date">Date:</label>
            <input type="date" id="certification_date" name="certification_date" required>

            <label for="certified_true">Certified True and Correct by:</label>
            <input type="text" id="certified_true" name="certified_true" required>

            <label for="signature_adviser">Signature of Adviser over Printed Name:</label>
            <input type="text" id="signature_adviser" name="signature_adviser" required>

            <label for="signature_authorized">Signature of Authorized Person over Printed Name:</label>
            <input type="text" id="signature_authorized" name="signature_authorized" required>

            <label for="designation">Designation:</label>
            <input type="text" id="designation" name="designation" required>
        </fieldset>
    </div>
</body>
</html>

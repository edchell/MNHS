<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Information</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #e0f7fa; /* Light blue background */
        }
        .search-container {
            background-color: #ffffff; /* White background for the form */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            margin-top: 20px;
        }
        input {
            border: 0;
            outline: 0;
            background: transparent;
            border-bottom: 1px solid black;
        }
        .form-control {
            height: 30px;
            font-size: 12px;
        }
        .text-right {
            text-align: right;
        }
        .disabled-input {
            text-align: center;
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid black;
        }
        .table th, .table td {
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Search Form -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="search-container">
                    <h2>Search Student</h2>
                    <form id="search-form">
                        <div class="form-group">
                            <label for="id">ID:</label>
                            <input type="text" id="id" class="form-control" placeholder="Enter ID">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name:</label>
                            <input type="text" id="lastname" class="form-control" placeholder="Enter Last Name">
                        </div>
                        <button type="button" id="search-button" class="btn btn-primary">Search</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Results will be shown here -->
        <div id="result" class="mt-4"></div>
    </div>

    <script>
        $(document).ready(function() {
            $('#search-button').on('click', function() {
                var id = $('#id').val();
                var lastname = $('#lastname').val();

                $.ajax({
                    type: 'POST',
                    url: 'searchStudent.php',
                    data: { id: id, lastname: lastname },
                    beforeSend: function() {
                        $("#result").html('Searching, please wait...');
                    },
                    success: function(response) {
                        $("#result").html(response);
                    },
                    error: function() {
                        $("#result").html('An error occurred while searching.');
                    }
                });
            });
        });
    </script>
</body>
</html>

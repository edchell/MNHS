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
        input {
            border: 0;
            outline: 0;
            background: light blue
            border-bottom: 1px solid black;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        .page-header {
            margin-top: 20px;
        }
        .back-button {
            background-color: #6c757d;
            color: light blue;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
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
            background: light blue
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
        <div class="row">
            <div class="col-md-12">
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

        <!-- Results will be shown here -->
        <div id="result"></div>
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

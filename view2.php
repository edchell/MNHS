<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Display</title>
    <style>
        body {
            display: flex;
            height: calc(100vh); /* Full viewport height */
            width: calc(100vw); /* Full viewport width */
            justify-content: center;
            align-items: center;
            background-image: url('images/Mad.jpg.jpg');
            background-repeat: no-repeat; /* Prevent tiling */
            background-size: cover; /* Scale the image to cover the container */
            background-position: center; /* Center the image */
        }
        input {
            border: 0;
            outline: 0;
            background: transparent;
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
            color: white;
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
            background: transparent;
            border: none;
            border-bottom: 1px solid black;
        }
        .table th, .table td {
            text-align: center;
            font-size: 10px;
        }
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background: transparent;
        }
        .form-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Forms Container -->
        <div class="row">
            <div class="col-md-12">
                <div class="form-container">
                    <!-- Search Form -->
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
                        <button type="button" id="search-button" class="btn-primary">Search</button>
                    </form>

                    <!-- Results will be shown here -->
                    <div id="result"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to handle the search button click -->
    <script>
        document.getElementById('search-button').addEventListener('click', function() {
            // Retrieve values from input fields
            const id = document.getElementById('id').value;
            const lastname = document.getElementById('lastname').value;

            // For demonstration, show an alert with the entered values
            alert('Search initiated!\nID: ' + id + '\nLast Name: ' + lastname);

            // Here, you would add code to perform the actual search, e.g., make an API call or filter results
        });
    </script>
</body>
</html>

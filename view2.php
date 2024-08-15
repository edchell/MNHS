<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Display</title>
    <!-- Link to Bootstrap CSS for styling -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
            width: 100vw; /* Full viewport width */
            margin: 0;
            background-image: url('images/Mad.jpg.jpg');
            background-repeat: no-repeat; /* Prevent tiling */
            background-size: cover; /* Scale the image to cover the container */
            background-position: center; /* Center the image */
        }
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background: #fff; /* Added background to improve text readability */
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
        /* Additional styling for the result display */
        #result {
            margin-top: 20px;
            font-size: 16px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
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
                <button type="button" id="search-button" class="btn btn-primary">Search</button>
            </form>
            <!-- Results will be shown here -->
            <div id="result"></div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- JavaScript to handle the search button click -->
    <script>
        document.getElementById('search-button').addEventListener('click', function() {
            // Retrieve values from input fields
            const id = document.getElementById('id').value.trim();
            const lastname = document.getElementById('lastname').value.trim();

            // Check if inputs are empty and display appropriate message
            if (!id && !lastname) {
                document.getElementById('result').innerHTML = '<p class="text-danger">Please enter at least one search criteria.</p>';
            } else {
                document.getElementById('result').innerHTML = `
                    <p><strong>Search initiated!</strong></p>
                    <p><strong>ID:</strong> ${id ? id : 'N/A'}</p>
                    <p><strong>Last Name:</strong> ${lastname ? lastname : 'N/A'}</p>
                `;
            }
        });
    </script>
</body>
</html>

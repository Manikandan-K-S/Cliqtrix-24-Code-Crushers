<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>

    <!-- Bootstrap CSS from CDN for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <script>
        function validate() {
            var pass = document.register.pass.value;
            var repass = document.register.repass.value;

            if (pass !== repass) {
                alert("Re-type Password doesn't match");
                return false;
            }

            return true;
        }
    </script>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">User Registration</h2>

                        <form method="post" name="register" onsubmit="return validate()">
                            <div class="form-group">
                                <label for="name">Enter your Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Enter your Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>

                            <div class="form-group">
                                <label for="mobile">Enter your Mobile No</label>
                                <input type="text" class="form-control" name="mobile" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Enter your Password</label>
                                <input type="password" class="form-control" name="pass" required>
                            </div>

                            <div class="form-group">
                                <label for="repassword">Re-Type Password</label>
                                <input type="password" class="form-control" name="repass" required>
                            </div>

                            <div class="form-group">
                                <label for="address">Enter your Address</label>
                                <textarea class="form-control" name="address" required></textarea>
                            </div>

                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-primary" value="Register" name="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js from CDN for Bootstrap functionality -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
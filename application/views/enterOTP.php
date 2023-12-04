<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify</title>

    <!-- Bootstrap CSS from CDN for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <script>
        function setvalue() {
            document.getElementById('address').value = "<?=$address?>";
        }
    </script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center">Verify your OTP</h2>
        <p class="text-center">We have sent a one-time password to the email: <?=$email?></p>

        <form action="<?=base_url('virtushop/checkOTP')?>" method="post" onclick="setvalue()" class="mt-3">
            <input type="hidden" name="name" value="<?=$name?>">
            <input type="hidden" name="email" value="<?=$email?>">
            <input type="hidden" name="mobile" value="<?=$mobile?>">
            <input type="hidden" name="pass" value="<?=$password?>">
            <textarea name="address" style="display: none;"><?=$address?></textarea>

            <div class="form-group">
                <label for="otp">Enter OTP</label>
                <input type="number" class="form-control" name="otp" required>
            </div>

            <div class="text-center">
                <input type="submit" class="btn btn-primary" value="Submit" name="submit">
            </div>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js from CDN for Bootstrap functionality -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

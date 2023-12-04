<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2 align='center'>User Login</h2>

    <form method="post">

        <table align='center' cellpadding='4px'>
            <tr>
                <td>Enter your email</td>
                <td><input type="text" name="email" ></td>
            </tr>

            <tr>
                <td>Enter your Password</td>
                <td><input type="password" name="pass" ></td>
            </tr>

            <tr>
                <td>New user <a href="<?=base_url($this->projurl.'register')?>">Register</a></td>
            </tr>

            <tr>
                <td><input type="submit" value="Login" name='Submit'></td>
            </tr>

        </table>

    </form>
</body>
</html>
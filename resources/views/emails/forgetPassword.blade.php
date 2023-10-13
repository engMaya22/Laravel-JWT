<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forget Password</title>
</head>
<body>
    <p>Dear {{$user->first_name}}</p>
    <p>To create a new password click on the button:</p>
    <a target="_blank" class="btn btn-lg btn-primary" href="{{config('app.fe_url')}}/change-password?email={{$user->email}}&verify_token={{$verify_token}}">Reset Password</a>
</body>
</html>
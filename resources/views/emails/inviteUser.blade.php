<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <h1>{{$user->organization->name}} Invitation</h1>
    </div>
    <p>Hi {{$user->first_name}}</p>
    <p>{{$text}}</p>
    <p>Kindly complate the settings of your account by the clicking on the button below</p>
    <a target="_blank" class="btn btn-lg btn-primary" href="{{config('app.fe_url')}}/activate?email={{$user->email}}&code={{$code}}">Active Account</a>
</body>
</html>
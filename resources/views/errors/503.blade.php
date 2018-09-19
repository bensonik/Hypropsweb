
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SchoolBeta | 505 Error</title>
    <!-- <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="icon" href="images/favicon.ico" type="image/x-icon"> -->
    <!-- Bootstrap CSS -->

    {!! Html::style('assets/css/bootstrap.min.css') !!}

    {!! Html::style('assets/css/material.css') !!}

    {!! Html::style('assets/css/error.css') !!}

    <!-- custom scrollbar stylesheet -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <!--320-->
</head>

<body class="error-bg">
<div class="container">
    <div class="col-md-8 col-md-offset-2 error">
        <img src="assets/images/505.png" class="img-responsive center-block" alt="404">
        <div class="error-message-two">
            Whoops!
        </div>
        <div class="error-bottom-two">
            The page you are looking for could have been deleted or never been existed. <a href="{{URL::route('home')}}">Take me to Home Page</a>
        </div>
    </div>
</div>

</body>

</html>
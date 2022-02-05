<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment Status</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <h2>Payment Status</h2>
                <br>
            </div>
        </div>
    </div>
    
    <div class="card" style="background-color: #fff;width: 400px;border-radius: 5px;box-sizing: border-box;padding: 80px 30px 25px 30px;text-align: center;position: relative;box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);max-width: 100%;margin: 28px auto 0;font-size: 35px;padding: 20px;">

    @if ($errors->any())
        <div class="alert alert-danger">
            <span class="card__success" style="position: absolute;top: -50px;left: 145px;width: 100px;height: 100px;border-radius: 100%;background-color: #f34b4b;border: 5px solid #fff;padding: 20px;color: #fff;"><i class="fas fa-info"></i></span>
            <ul style="list-style: none;padding: 0;margin: 0;">
                @foreach ($errors->all() as $error)
                    <li><h1 style="color: #000;margin: 68px 0 27px;font-size: 25px;">{{ $error }}</h1></li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger">
            <span class="card__success" style="position: absolute;top: -50px;left: 145px;width: 100px;height: 100px;border-radius: 100%;background-color: #f34b4b;border: 5px solid #fff;padding: 20px;color: #fff;"><i class="fas fa-exclamation-triangle"></i></span>
            <h1 style="color: #000;margin: 68px 0 27px;font-size: 25px;">{{ session()->get('error') }}</div>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="alert alert-success">
            <span class="card__success" style="position: absolute;top: -50px;left: 145px;width: 100px;height: 100px;border-radius: 100%;background-color: #60c878;border: 5px solid #fff;padding: 20px;color: #fff;"><i class="fas fa-check"></i></span>
            <h1 style="color: #000;margin: 68px 0 27px;font-size: 25px;">{{ session()->get('success') }}<br><span style="font-size: 16px;">Thank you for your transfer</span></h1>
            <a href="#" class="btn btn-success">Continue Shopping</a>
        </div>
    @endif


    </div>

    </body>
</html>
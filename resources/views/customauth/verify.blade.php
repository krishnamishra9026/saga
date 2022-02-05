<html>
    <head>

    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Please change your password by clicking on the below link:-</div>
                          <div class="card-body">
                           @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                   {{ __('A fresh verification link has been sent to your email address.') }}
                               </div>
                           @endif
                           <a href="https://www.saga-bags.com/public/en-SA/reset-password/{{$token}}">https://www.saga-bags.com/public/en-SA/reset-password/{{$token}}</a>.
                       </div>
                   </div>
               </div>
           </div>
       </div>
    </body>
</html>
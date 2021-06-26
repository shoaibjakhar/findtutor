<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Favicon -->
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{asset('public/assets/frontend/css/fontawesome.min.css')}}">
    <!-- Main CSS -->
    <!-- <link rel="stylesheet" href="{{asset('public/assets/modal/css/style.css')}}"> -->

    <link rel="stylesheet" href="{{asset('public/assets/frontend/css/app.css')}}">
    

</head>

<body>
    <!-- Header -->
    <header class="header">
        <!-- Logo -->
        <div class="header--logo">
            <a href="{{url('index')}}" title="Find Tutor 360"> <img src="{{asset('public/assets/frontend/images/logo.png')}}" alt="Find Tutor 360"> </a>
        </div>

        <div class="header--navbar-sm">
            <button class="btn btn-primary">Join For Free</button>
            <button class="btn btn-collapse"> <i class="fal fa-bars"></i> </button>
        </div>
        <!-- Header Navbar -->
        <div class="header--inner">
            <nav class="header--navbar">
                <ul>
                    <li class="nav-item"> <a href="{{url('index')}}" class="nav-link active">Home</a></li>
                    <li class="nav-item"> <a href="{{url('student')}}" class="nav-link">Student</a></li>
                    <li class="nav-item"> <a href="{{url('tutor')}}" class="nav-link">Tutor</a></li>
                    <li class="nav-item"> <a href="{{url('institution')}}" class="nav-link">Institution</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Bookstore
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a href="{{url('buy-book')}}" class="nav-link">Buy Books</a>
                            <a href="{{url('sell-book')}}" class="nav-link">Sell Books</a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- Header Right -->
            <div class="header--right">
                <ul>
                    <li><a href="#"> Help? </a></li>
                    <li><a href="#" data-toggle="modal" data-target="#loginmodel">Sign in</a></li>
                </ul>
                <a href="#"><button class="btn btn-primary" data-toggle="modal" data-target="#signupmodel">Join For Free</button></a>
            </div>
        </div>
    </header>


        @yield('user_layout')

            <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="footer--card">
                        <h3>Let's have fun here</h3>
                        <div class="contact_info">
                            <ul>
                                <li><a href="tel:123456789"> <i class="fas fa-phone"></i> (00) 123 456 789</a></li>
                                <li><a href="mailto: hi@findatutor360.com"> <i class="fas fa-envelope"></i>
                                        hi@findatutor360.com</a></li>
                            </ul>
                        </div>
                        <div class="social_icons">
                            <ul>
                                <li><a href="https://m.facebook.com/FindaTutor360-1776732395927627/" class="facebook"> <i class="fab fa-facebook-f"></i> </a></li>
                                <li><a href="https://twitter.com/FindATutor360" class="twitter"> <i class="fab fa-twitter"></i> </a></li>
                                <li><a href="https://www.instagram.com/findatutor360/" class="instagram"> <i class="fab fa-instagram"></i> </a></li>
                                <li><a href="https://www.linkedin.com/company/findatutor360" class="linkedin"> <i class="fab fa-linkedin-in"></i> </a></li>
                                <li><a href="https://www.youtube.com/channel/UCUepd7mMMmxvby5z_pMzJCg" class="youtube"> <i class="fab fa-youtube"></i> </a></li>
                            </ul>
                        </div>


                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-3 col-6">
                            <div class="footer--card">
                                <h3>About Us</h3>
                                <ul>
                                    <li><a href="#">Our Team </a></li>
                                    <li><a href="#">Careers </a></li>
                                    <li><a href="#">Partners </a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="footer--card">
                                <h3>Customer Service </h3>
                                <ul>
                                    <li><a href="#"> FAQ's </a></li>
                                    <li><a href="#"> How it works </a></li>
                                    <li><a href="#"> Contact info </a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="footer--card">
                                <h3>Our Terms </h3>
                                <ul>
                                    <li><a href="#">Cookie Policy </a></li>
                                    <li><a href="#">Privacy Policy </a></li>
                                    <li><a href="#">Review Policy </a></li>

                                </ul>
                            </div>
                        </div>
                        <div class="col-md-2 col-6">
                            <div class="footer--payment">
                                <h3>We Accept</h3>
                                <div class="payments">
                                    <div class="payments--card">
                                        <img src="{{asset('public/assets/frontend/images/credit-card.png')}}" alt="credit-card">
                                        <h4>Debit Card</h4>
                                    </div>
                                    <div class="payments--card">
                                        <img src="{{asset('public/assets/frontend/images/bank.png')}}" alt="transfer">
                                        <h4>Bank Transfer</h4>
                                    </div>

                                    <div class="payments--card">
                                        <img src="{{asset('public/assets/frontend/images/mobile-payment.png')}}" alt="MTN-Mobile">
                                        <h4>Mobile Money</h4>
                                    </div>
                                </div>

                                <h3>Courier Partner</h3>
                                <div class="courier">
                                    <img src="{{asset('public/assets/frontend/images/courier.png')}}" alt="courier">
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>


    </footer>
    <div class="footer--copyright">
        <p>Copyright © 2020 - Developed By Peges Inc </p>
    </div>


<style>
    
    .form-control {
        border: 1px solid #eee !important;
        border-radius: 7px;
        font-size: 12px;
    }
    .modal-title {
        color: #000;
    }

    .col-md-6 {
        padding-bottom: 14px;
    }
    .modal-content {
        padding: 20px; 
    }

</style>
 <div class="modal fade" id="signupmodel" style="margin-top: 6%;" role="dialog" style="opacity:0.5 ">

            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">Sign Up</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>

                    </div>

                <div class="modal-body">
                    
                     <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                           
                            <div class="col-md-6">

                                <input id="name" type="text" placeholder="First Name" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="name" autofocus  style="color: black;margin-bottom:-7px;margin-bottom:-7px">

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input id="name" type="text" placeholder="Last Name" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="name" autofocus style="color: black;margin-bottom:-7px">

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                           <div class="col-md-6">
                                <input id="email" type="email" placeholder="example@gmail.com" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" style="color: black;margin-bottom:-7px">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" style="color: black;margin-bottom:-7px">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6"> 
                                <input id="password-confirm" type="password" placeholder="Password Confirm" class="form-control" name="password_confirmation" required autocomplete="new-password" style="color: black;margin-bottom:-7px">
                            </div>
                            <div class="col-md-6">
                                <input id="country-code" type="number" placeholder="Country Code" class="form-control" name="country_code" required style="color: black;margin-bottom:-7px">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <input id="phone-no" type="number" placeholder="Phone No" class="form-control" name="phone_no" required style="color: black;margin-bottom:-7px">
                            </div>
                            <div class="col-md-6">
                                <select id="role" class="form-control" name="role" required style="color: black;margin-bottom:-7px">
                                    <option value="">Select Role</option>
                                    <option value="student">Student</option>
                                    <option value="tutor">Tutor</option>
                                    <option value="institute">Institute</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>

                    </form>
                    </div>
                </div>
            </div>
        </div>


    <div class="modal fade" id="loginmodel"  style="margin-top: 8%">
        <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="exampleModalLabel">Sign In</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <div class="modal-body">
                        <form id="login" action="{{ route('login') }}" method="POST">
                        <div class="modal-body">
                            @csrf()
                            
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email"  type="email" placeholder="example@gmail.com" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="color:black">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" style="color:black">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                    
                </div>
            </div>
        </div>









        <!-- <script type="text/javascript">
            $(document).ready(function(){
                $('#studentadd').on('submit',function(e) {
                    e.preventDefault();
                    $.ajax({
                        method: "POST",
                        url: "register",
                        data:$('#studentadd').serialize(),
                        success:function(response) {
                            console.log(response);
                            // $('#studentmodel').hide();
                            alert("Data Saved");
                            $('#studentmodel').hide();
                        },
                        error:function(error) {
                            console.log(error)
                            alert("Data Not Saved");
                        }
                    });
                });
            });
        </script> -->





    <!-- jQuery Files -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="{{asset('public/assets/frontend/js/main.js')}}"></script>
    <script src="{{asset('public/assets/frontend/js/plugins.js')}}"></script>
    <script src="{{asset('public/assets/frontend/js/script.js')}}"></script>
</body>

</html>
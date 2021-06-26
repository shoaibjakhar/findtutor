@extends('Frontend/App/layout')
@section('user_layout')


<script src="//code.tidio.co/n4wn2mpbpnrwhsn7wqqccjjecb9gcrlj.js"></script>
	<!-- Hero -->
    <section class="hero hero--buy_book">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="hero--inner">
                        <h2>GHANA’S NO. 1 ONLINE BOOKSTORE</h2>
                        <p>BROWSE , CHOOSE AND BUY AFFORDABLE BOOKS FROM YOUR COUCH</p>
                        <form action="{{URL::to('search-book')}}" method="POST">
                            @csrf
                            <div class="search-box-sm">
                                <input type="search" placeholder="Search" name="search">
                                <button class="btn" type="submit"> <img src="public/assets/frontend/images/search-icon.png" alt="search-icon"> </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How it work -->
    <section class="how_works how_works--bg-gray how_works--padding how_works--sm_text">
        <span class="shape-1"><img src="public/assets/frontend/images/how-works/line.svg" alt="line.svg"></span>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="section__head text-center">
                        <h3>How It Works </h3>
                    </div>
                </div>
                <div class="col">
                    <div class="how_works--card">
                        <div class="how_works--card__icon">
                            <img src="public/assets/frontend/images/how-works/seo.svg" alt="seo">
                        </div>
                        <div class="how_works--card__desc">
                            <p>Search for book using
                                Title, ISBN or Author</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="how_works--card">
                        <div class="how_works--card__icon">
                            <img src="public/assets/frontend/images/how-works/open-book.svg" alt="open-book">
                        </div>
                        <div class="how_works--card__desc">
                            <p>Choose desired book and pay for
                                the book and courier</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="how_works--card">
                        <div class="how_works--card__icon">
                            <img src="public/assets/frontend/images/how-works/sell.svg" alt="sell">
                        </div>
                        <div class="how_works--card__desc">
                            <p>Seller delivers to our
                                courier or delivery partner</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="how_works--card">
                        <div class="how_works--card__icon">
                            <img src="public/assets/frontend/images/how-works/selling.svg" alt="selling">
                        </div>
                        <div class="how_works--card__desc">
                            <p>Courier delivers books to you.
                                conveniently Easy!</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>

    <!-- Book Showcase -->
    <section class="bookShowcase">
        <span class="shape-1"> <img src="public/assets/frontend/images/bg-dot-shape.svg" alt="bg-shape"> </span>
        <div class="container">
            <div class="row">
                @if(!empty($searched_book))
                @foreach($searched_book as $searched)
                <div class="col-md-6">
                    <a href="#" class="bookShowcase--card">
                        <div class="bookShowcase--card__cover">
                            <img src="public/images/thumbnail/{{$searched->picture}}"  style="width:300px;height: 150px;">
                        </div>
                        <div class="bookShowcase--card__desc">
                            <h3>{{$searched->title_of_book}}</h3>
                            <p>Author:{{$searched->author}}</p>
                            <p>Category:{{$searched->category}}</p>
                        </div>
                    </a>
                </div>
                @endforeach
                @elseif(!empty($all_books))

                @foreach($all_books as $searched)
                <div class="col-md-6">
                    <a class="bookShowcase--card">
                        <div class="bookShowcase--card__cover">
                            <img src="public/images/thumbnail/{{$searched->picture}}"  style="width:300px;height: 150px;">
                        </div>
                        <div class="bookShowcase--card__desc">
                            <h3>{{$searched->title_of_book}}</h3>
                            <p>Author:{{$searched->author}}</p>
                            <p>Category:{{$searched->category}}</p>
                        </div>
                    </a>
                </div>
                @endforeach

                @endif
               

            </div>
        </div>
    </section>

    <!-- Blue Show case -->
    <section class="blueShowcase">
        <span class="shape-1"><img src="public/assets/frontend/images/blue-bg-shape.svg" alt="blue-bg-shape"></span>
        <span class="shape-2"><img src="public/assets/frontend/images/blue-bg-shape-2.svg" alt="blue-bg-shape"></span>
        <h3>TAKE ADVANTAGE OF US</h3>
        <span class="line"></span>
        <p>If you see a book that you like, buy now or <span>forever miss</span> the chance
            to get it at our incredibly low prices</p>
    </section>


    <!-- Box section-->
    <section class="box_section box_section__margin">
        <span class="shape shape--1"><img src="public/assets/frontend/images/dot-circle.svg" alt=""></span>
        <span class="shape shape--2"><img src="public/assets/frontend/images/dot-square.svg" alt=""></span>
        <span class="shape shape--3"><img src="public/assets/frontend/images/dot-square.svg" alt=""></span>
        <span class="shape shape--4"><img src="public/assets/frontend/images/circle-big.svg" alt=""></span>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="box_section--card">
                        <div class="box_section--card__icon">
                            <img src="public/assets/frontend/images/doller.svg" alt="doller">
                        </div>
                        <div class="box_section--card__title">
                            <h3>Great Value </h3>
                        </div>
                        <div class="box_section--card__desc">
                            <p>You have a choice of students,
                                tutors, institutions, bookstores covering all
                                educational areas at your finger tip.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box_section--card">
                        <div class="box_section--card__icon">
                            <img src="public/assets/frontend/images/credit card.svg" alt="doller">
                        </div>
                        <div class="box_section--card__title">
                            <h3>Safe Payments </h3>
                        </div>
                        <div class="box_section--card__desc">
                            <p>Pay for services and products with the
                                most popular and secure payment
                                methods.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box_section--card">
                        <div class="box_section--card__icon">
                            <img src="public/assets/frontend/images/security.svg" alt="doller">
                        </div>
                        <div class="box_section--card__title">
                            <h3>Escrow Payments </h3>
                        </div>
                        <div class="box_section--card__desc">
                            <p>We protect both parties through our
                                escrow system from payment to
                                solution delivery</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box_section--card">
                        <div class="box_section--card__icon">
                            <img src="public/assets/frontend/images/customer-support.svg" alt="doller">
                        </div>
                        <div class="box_section--card__title">
                            <h3>Customer Support</h3>
                        </div>
                        <div class="box_section--card__desc">
                            <p> Round the clock assistance for a
                                smooth experience through all
                                our channels</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Sign Up -->
    <section class="signUP">
        <span class="shape-1"> <img src="public/assets/frontend/images/circle-big.svg" alt=""> </span>
        <div class="signUP--inner signUP--inner--width">
            <h2>WE ARE HERE TO HELP</h2>
            <h3>Our bookstore support staff are on standby whenever you need help. Take advantage of all available
                channels from our direct lines, WhatsApp, email and resource centre to get in touch. We are too eager to
                help.</h3>
            <button class="btn btn-green text-uppercase" data-toggle="modal" data-target="#signupmodel">JOIN FOR FREE</button>
        </div>
    </section>

@endsection
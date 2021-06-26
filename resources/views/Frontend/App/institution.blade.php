@extends('Frontend/App/layout')
@section('user_layout')
<script src="//code.tidio.co/n4wn2mpbpnrwhsn7wqqccjjecb9gcrlj.js"></script>
	 <!-- Hero -->
    <section class="hero hero--institution">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="hero--inner">
                        <h3>Expand Your Reach</h3>
                        <p>
                            We continue to change lives by connecting students
                            nationwide to instructors.
                        </p>
                        <button class="btn btn-green" data-toggle="modal" data-target="#loginmodel">Log In</button>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- How it work -->
    <section class="how_works how_works--bg-gray how_works--padding">
        <span class="shape-2"><img src="public/assets/frontend/images/how-works/big-shape.svg" alt="big-shape.svg"></span>
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
                            <img src="public/assets/frontend/images/how-works/to-do-list.svg" alt="to-do-list">
                        </div>
                        <div class="how_works--card__desc">
                            <p>Sign up and create a free account 
                                for the institution</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="how_works--card">
                        <div class="how_works--card__icon">
                            <img src="public/assets/frontend/images/how-works/clock.svg" alt="clock">
                        </div>
                        <div class="how_works--card__desc">
                            <p>Answer enquiries from student 
                                & arrange lessons</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="how_works--card">
                        <div class="how_works--card__icon">
                            <img src="public/assets/frontend/images/how-works/monitor.svg" alt="monitor">
                        </div>
                        <div class="how_works--card__desc">
                            <p>Teach, according to your agreed 
                                format and schedule</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="how_works--card">
                        <div class="how_works--card__icon">
                            <img src="public/assets/frontend/images/how-works/wallet.svg" alt="wallet">
                        </div>
                        <div class="how_works--card__desc">
                            <p>Get paid into your preferred 
                                account while you are at it. 
                                </p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>


    <!-- Photo Gallery -->
    <section class="photGallery photGallery--bottom">
        <img class="img-big" src="public/assets/frontend/images/how-works/connect-bg-big.svg" alt="photo-gallery-desk.png">
        <img class="img-sm" src="public/assets/frontend/images/how-works/connect-bg-sm.svg" alt="photo-gallery-smg">
        <div class="signup_btn">
            <button class="btn btn-yellow" data-toggle="modal" data-target="#signupmodel">Join for free</button>
        </div>
    </section>

    <!-- Possibilities -->
    <section class="posibilities">
        <span class="shape shape--1"> <img src="public/assets/frontend/images/posibilities/shape-line-1.svg" alt="shape-line-1"> </span>
        <span class="shape shape--2"> <img src="public/assets/frontend/images/posibilities/shape-line-2.svg" alt="shape-line-2"> </span>
        <span class="shape shape--3"> <img src="public/assets/frontend/images/posibilities/shape-line-3.svg" alt="shape-line-3"> </span>
        <span class="shape shape--4"> <img src="public/assets/frontend/images/posibilities/shape-line-4.svg" alt="shape-line-4"> </span>
        <span class="shape shape--5"> <img src="public/assets/frontend/images/posibilities/shape-line-5.svg" alt="shape-line-5"> </span>
        <div class="section__head text-center">
            <h3>Endless Possibilities</h3>
        </div>
        <div class="posibilities--inner">
            <div class="posibilities--card">
                <div class="posibilities--card__head">
                    <div class="posibilities--card__head-icon">
                        <img src="public/assets/frontend/images/posibilities/care.svg" alt="care">
                    </div>
                    <div class="posibilities--card__head-title">
                        <h3> New Communities 
                            </h3>
                    </div>
                </div>
                <div class="posibilities--card__desc">
                    <p>Thousands of students, companies nationwide are looking for 
                        great instructors working in institutions like yours on 
                        <strong>FindaTutor360</strong>. Reach this new market with your content.</p>
                </div>
            </div>
            <div class="posibilities--card">
                <div class="posibilities--card__head">
                    <div class="posibilities--card__head-icon">
                        <img src="public/assets/frontend/images/posibilities/schedule.svg" alt="care">
                    </div>
                    <div class="posibilities--card__head-title">
                        <h3>Flexible  Schedule</h3>
                    </div>
                </div>
                <div class="posibilities--card__desc">
                    <p>Set your work schedule, mode of teaching either  online or offline and fees for each subject</p>
                </div>
            </div>
            <div class="posibilities--card">
                <div class="posibilities--card__head">
                    <div class="posibilities--card__head-icon">
                        <img src="public/assets/frontend/images/posibilities/earn-money.svg" alt="care">
                    </div>
                    <div class="posibilities--card__head-title">
                        <h3>Earn Money</h3>
                    </div>
                </div>
                <div class="posibilities--card__desc">
                    <p>Earn the extra money without spending on marketing. 
                        You also earn when you sell books and you receive 
                        amazing book discounts from our bookstores.</p>
                </div>
            </div>
            <div class="posibilities--card">
                <div class="posibilities--card__head">
                    <div class="posibilities--card__head-icon">
                        <img src="public/assets/frontend/images/posibilities/graduation.svg" alt="care">
                    </div>
                    <div class="posibilities--card__head-title">
                        <h3>Inspire Students</h3>
                    </div>
                </div>
                <div class="posibilities--card__desc">
                    <p>Help people learn new skills, advance their careers, 
                        and explore their hobbies by sharing your knowledge.</p>
                </div>
            </div>
        </div>
    </section>

    
    <!-- Box section-->
    <section class="small_box_section">
        <span class="shape-4"> <img src="public/assets/frontend/images/box-icons/shape-l-8.svg" alt=""> </span>
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="section__head text-center">
                        <h3>Why We Know FindATutor360 Is The Best?</h3>
                    </div>
                </div>
                
                <div class="col">
                    <div class="small_box_section--card">
                        <div class="small_box_section--card__icon">
                            <img src="public/assets/frontend/images/box-icons/teaching.svg" alt="teaching">
                        </div>

                        <div class="small_box_section--card__desc">
                            <p>Teach with complete peace of mind, knowing your money is secured…</p>
                        </div>
                        <div class="small_box_section--card_btn">
                            <button class="btn btn-green" data-toggle="modal" data-target="#signupmodel">Get Started</button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="small_box_section--card">
                        <div class="small_box_section--card__icon">
                            <img src="public/assets/frontend/images/box-icons/elearning.svg" alt="elearning">
                        </div>

                        <div class="small_box_section--card__desc">
                            <p>Tools to make your transaction smooth, from teaching online , reviewing students, etc.
                            </p>
                        </div>
                        <div class="small_box_section--card_btn">
                            <button class="btn btn-green" data-toggle="modal" data-target="#signupmodel">Get Started</button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="small_box_section--card">
                        <div class="small_box_section--card__icon">
                            <img src="public/assets/frontend/images/box-icons/profile.svg" alt="profile">
                        </div>

                        <div class="small_box_section--card__desc">
                            <p>It’s completely free to have a profile and gain access to thousands of students who are
                                actively seeking tuition. </p>
                        </div>
                        <div class="small_box_section--card_btn">
                            <button class="btn btn-green" data-toggle="modal" data-target="#signupmodel">Get Started</button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="small_box_section--card">
                        <div class="small_box_section--card__icon">
                            <img src="public/assets/frontend/images/box-icons/sell.svg" alt="sell">
                        </div>

                        <div class="small_box_section--card__desc">
                            <p>You can sell published books, new and used books and make more money …</p>
                        </div>
                        <div class="small_box_section--card_btn">
                            <button class="btn btn-green" data-toggle="modal" data-target="#signupmodel">Get Started</button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="small_box_section--card">
                        <div class="small_box_section--card__icon">
                            <img src="public/assets/frontend/images/box-icons/custom-live.svg" alt="custom-live.svg">
                        </div>

                        <div class="small_box_section--card__desc">
                            <p>Our customer service team, standing by to help you in make your time here stress free.
                            </p>
                        </div>
                        <div class="small_box_section--card_btn">
                            <button class="btn btn-green" data-toggle="modal" data-target="#signupmodel">Get Started</button>
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
            <h3>
                Our Institution support staff are on standby whenever you need help. Take advantage of all available
                channels from our direct lines, WhatsApp, email and resource centre to get in touch. We are too eager to
                help.</h3>
            <button class="btn btn-green text-uppercase" data-toggle="modal" data-target="#signupmodel">JOIN FOR FREE</button>
        </div>
    </section>

@endsection
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Webpixels">
    <title>PILI NATIONAL HIGH SCHOOL</title>
    <link rel="shortcut icon" href="{{ asset('image/logo/'.$sprofile->school_logo) }}">
    <!-- Preloader -->
    <style>
        @keyframes hidePreloader {
            0% {
                width: 100%;
                height: 100%;
            }

            100% {
                width: 0;
                height: 0;
            }
        }

        body>div.preloader {
            position: fixed;
            background: white;
            width: 100%;
            height: 100%;
            z-index: 1071;
            opacity: 0;
            transition: opacity .5s ease;
            overflow: hidden;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        body:not(.loaded)>div.preloader {
            opacity: 1;
        }

        body:not(.loaded) {
            overflow: hidden;
        }

        body.loaded>div.preloader {
            animation: hidePreloader .5s linear .5s forwards;
        }
    </style>
    <script>
        window.addEventListener("load", function() {
            setTimeout(function() {
                document.querySelector('body').classList.add('loaded');
            }, 300);
        });
    </script>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/brand/favicon.png" type="image/png') }}"><!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/libs/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <!-- Quick CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/quick-website.css') }}" id="stylesheet">
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    {{-- <div class="modal fade" tabindex="-1" role="dialog" id="modal-cookies" data-backdrop="false" aria-labelledby="modal-cookies" aria-hidden="true">
        <div class="modal-dialog modal-dialog-aside left-4 right-4 bottom-4">
            <div class="modal-content bg-dark-dark">
                <div class="modal-body">
                    <!-- Text -->
                    <p class="text-sm text-white mb-3">
                        We use cookies so that our themes work for you. By using our website, you agree to our use of cookies.
                    </p>
                    <!-- Buttons -->
                    <a href="pages/utility/terms.html" class="btn btn-sm btn-white" target="_blank">Learn more</a>
                    <button type="button" class="btn btn-sm btn-primary mr-2" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div> --}}
 
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="index.html">
                <!-- <img alt="Image placeholder" src="assets/img/brand/dark.svg" id="navbar-logo"> -->
                PNOP
            </a>
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mt-4 mt-lg-0 ml-auto">
                    <li class="nav-item ">
                        <a class="nav-link" href="#missionVision">Mission & Vision</a>
                    </li>
                   
                    <li class="nav-item ">
                        <a class="nav-link" href="#pnhsHistory">History</a>
                    </li>
                </ul>
                <!-- Button -->
                <a href="{{ route("auth.login") }}"  class="navbar-btn btn btn-sm btn-primary d-none d-lg-inline-block ml-3 text-white" >
                    @auth  My Dashboard @else Login @endauth
                </a>
              
            </div>
        </div>
    </nav>
    <!-- Main content -->
    <section class="slice py-7">
        <div class="container">
            <div class="row row-grid align-items-center">
                <div class="col-12 col-md-5 col-lg-6 order-md-2 text-center">
                    <!-- Image -->
                    <figure class="w-100">
                        <img alt="Image placeholder" src="{{ asset('assets/img/svg/illustrations/illustration-3.svg') }}" class="img-fluid mw-md-120">
                    </figure>
                </div>
                <div class="col-12 col-md-7 col-lg-6 order-md-1 pr-md-5">
                    <!-- Heading -->
                    <img src="{{ asset('image/logo/logo.png') }}" class="img-fluid" style="height: 70px;" alt="Illustration" />
                    <img src="{{ asset('image/logo/deped.png') }}" class="img-fluid ml-2" style="height: 70px;" alt="Illustration" />
                    <h1 class="display-4 text-center text-md-left mb-3 mt-2">
                      PILI NATIONAL HIGH SCHOOL <strong class="text-primary">online portal</strong>
                    </h1>
                    <!-- Text -->
                    <p class="lead text-center text-md-left text-muted">
                        A community of lifelong learners, responsible global citizens, and champions of our own success
                    </p>
                    <!-- Buttons -->
                    <div class="text-center text-md-left mt-5">
                        <a href="{{ route('appoint') }}" class="btn btn-primary btn-icon">
                            <span class="btn-inner--text">Get Appointment</span>
                            <span class="btn-inner--icon"><i data-feather="chevron-right"></i></span>
                        </a>
                        <a href="{{ route('form') }}" class="btn btn-neutral btn-icon d-none d-lg-inline-block">Pre Enroll Online Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="slice slice-lg pt-lg-6 pb-0 pb-lg-6 bg-section-secondary" id="missionVision">
        <div class="container">
            <!-- Title -->
            <!-- Section title -->
            <div class="row mb-5 justify-content-center text-center">
                <div class="col-lg-6">
                   
                    <h2 class=" mt-4">DepEd Mission & Vision</h2>
                    <!-- <div class="mt-2">
                        <p class="lead lh-180">sa</p>
                    </div> -->
                </div>
            </div>
            <!-- Card -->
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body pb-5">
                            <div class="pt-4 pb-5">
                                <img src="{{asset('assets/img/svg/illustrations/illustration-5.svg')}}" class="img-fluid img-center" style="height: 150px;" alt="Illustration" />
                            </div>
                            <h5 class="h4 lh-130 mb-3">Mission</h5>
                            <p class="text-muted mb-0">
                                To protect and promote the right of every Filipino to quality, equitably, culture-based, and complete basic education where:
                                <ul>
                                    <li>Students learn in a child-friendly, gender-sensitive, safe, and motivating environment</li>
                                    <li>Teachers facilitate learning and constantly nurture every learner</li>
                                </ul>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body pb-5">
                            <div class="pt-4 pb-5">
                                <img src="{{asset('assets/img/svg/illustrations/illustration-6.svg')}}" class="img-fluid img-center" style="height: 150px;" alt="Illustration" />
                            </div>
                            <h5 class="h4 lh-130 mb-3">Vision</h5>
                            <p class="text-muted mb-0">
                                We dream of Filipinos who passionately love their country and whose values and competencies enable them to realize their full potential and contribute meaningfully to building the nation. As a learner-centered public institution, the Department of Education continuously improves itself to better serve its stakeholders.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body pb-5">
                            <div class="pt-4 pb-5">
                                <img src="{{asset('assets/img/svg/illustrations/illustration-7.svg')}}" class="img-fluid img-center" style="height: 150px;" alt="Illustration" />
                            </div>
                            <h5 class="h4 lh-130 mb-3">Core Values</h5>
                            <p class="text-muted mb-0">
                                <ul>
                                    <li><h5>Maka-Diyos</h5></li>
                                    <li><h5>Makatao</h5></li>
                                    <li><h5>Makaklikasan</h5></li>
                                    <li><h5>Makabansa</h5></li>
                                </ul>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="slice slice-lg" id="pnhsHistory">
        <div class="container">
            <div class="py-6">
                <div class="row row-grid justify-content-between align-items-center">
                    <div class="col-lg-6 order-lg-2">
                        <h5 class="h3">PNHS History</h5>
                        <p class="lead my-4">
                            Pili National High School was founded in 1970 by former Municipal Mayor of Pili, Hon. Jose B. Velarde. It was then occupying the facilities of Marcos Stadium, now, the Freedom Sports Complex where the Division Office is located. The establishment of PNHS was very much different from other secondary schools. When PNHS was opened in 1970, all 52 enrollees were selected from the different barangays of Pili for this reason, it was dubbed as Pili Special Barrio High School. Likewise, the salaries of the teachers were defrayed by the local government of Pili. However, there were only 26 graduates in 1974. 
                        </p>
                      
                    </div>
                    <div class="col-lg-6 order-lg-1">
                        <div class="card mb-0">
                            <div class="card-body p-1">
                                <img alt="Image placeholder" src="{{ asset('image/logo/10.webp')  }}" width="160%" class="img-fluid shadow rounded">
                            </div>
                        </div>
                    </div>
                </div>
                <p class="lead">
                    The Municipal Council of Pili continued the scholarship program until 1980 to the indigent residents of Pili.
                    The first principal was Mr. Jose T. Malanyaon while the first teacher was Ms. Maria Busadre. Mr. Gregorio Ayen, Mrs. Catalina Malanyaon, and Mr. Domingo Vargas were the part time teachers. Due to the increase of enrolment, permanent teachers were hired. They were Mrs. Tecla V. Nano, Mrs. Editha T. Ballester-Secondary Head Teacher III, Mr. Romeo P. Permelona-Master Teacher II, and Ms. Francia V. Felizminio now Atty. Francia F. Apongol. In 1976, there were 20 teachers and due to this development, Mr Germites C. Dineros was assigned Principal I. The growth of the school prompted the government to shoulder the salaries of the teachers and other financial matters.
                    As the number of the enrollees build up, the available classrooms can no longer accommodate students. Mr. Dineros worked for the procurement of the new site in El Rosario Village IV (La Paz), Pawili, Pili, Camarines Sur. The present PNHS site is 1.5 hectares which was donated by Mr. Conrado Colarina, through the efforts of Supt. Jose Malanyaon, thru thereafter, the construction of the buildings started.
                    During the school year 1980-81 the first and second year students were transferred to the new site leaving the third and fourth year students at the Marcos Stadium. Mrs. Esther V. Velasco was the teacher-in-charge in PNHS new campus, while the principal, Ms. Josefa S. Priela took charged of PNHS at Marcos Stadium.There was a rapid influx of the enrollment thus, a night and summer classes were opened.
                    In 1990, Mrs. Josefa S. Priela retired from the service and Mrs. Tecla Nano became the officer-in-charge from 1990-1991.  In July 1, 1991, Mr. Hermogenes T. Tosoc assumed office as principal of Pili National High School and retired in November 1997. Mrs. Editha Ballester became the officer-in-charge from 1997 to 1998.           
                </p>
            </div>
            
        </div>
    </section>
    <footer class="position-relative" id="footer-main">
        <div class="footer pt-lg-7 footer-dark bg-dark">
            <!-- SVG shape -->
            <div class="shape-container shape-line shape-position-top shape-orientation-inverse">
                <svg width="2560px" height="100px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="none" x="0px" y="0px" viewBox="0 0 2560 100" style="enable-background:new 0 0 2560 100;" xml:space="preserve" class=" fill-section-secondary">
                    <polygon points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
            <!-- Footer -->
            <div class="container pt-4">
            
                <hr class="divider divider-fade divider-dark my-4">
                <div class="row align-items-center justify-content-md-between pb-4">
                    <div class="col-md-6">
                        <div class="copyright text-sm font-weight-bold text-center text-md-left">
                            &copy; 2020 <a href="https://webpixels.io" class="font-weight-bold" target="_blank">Webpixels</a>. All rights reserved
                        </div>
                    </div>
                    <div class="col-md-6">
                        <ul class="nav justify-content-center justify-content-md-end mt-3 mt-md-0">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Team Gladious
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Core JS  -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/svg-injector/dist/svg-injector.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/dist/feather.min.js') }}"></script>
    <!-- Quick JS -->
    <script src="{{ asset('assets/js/quick-website.js') }}"></script>
    <!-- Feather Icons -->
    <script>
        feather.replace({
            'width': '1em',
            'height': '1em'
        })
    </script>
</body>

</html>
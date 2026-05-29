


@extends($activeTemplate.'layouts.frontend')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        :root {
            --primary-color: #122edbba;
            --secondary-color: #122edbba;
            --dark-bg: #1a1a2e;
            --darker-bg: #16213e;
            --text-light: #f1f1f1;
            --text-lighter: #ffffff;
            --accent-color: #00cec9;
            --danger-color: #ff7675;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark-bg);
            color: var(--text-light);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Mobile Navigation */
        .nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 65px;
            background: rgba(26, 26, 46, 0.9);
            backdrop-filter: blur(10px);
            display: flex;
            overflow-x: auto;
            z-index: 1000;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav__link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
            min-width: 50px;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav__link:hover {
            background: rgba(108, 92, 231, 0.2);
            color: var(--accent-color);
        }

        .nav__icon {
            font-size: 22px;
            margin-bottom: 3px;
        }

        .nav__text {
            font-size: 12px;
            opacity: 0.9;
        }

        .nav__link--active {
            color: var(--accent-color);
        }

        /* Video Background */
        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        #myVideo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
            opacity: 0.15;
            filter: blur(3px);
        }

        /* Blog Section */
        .blog-section {
            padding: 4rem 0;
        }

        .post-item {
            background: rgba(26, 26, 46, 0.8);
            backdrop-filter: blur(7px);
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: calc(100% - 20px);
            margin-top: 10px;
        }

        .post-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 206, 201, 0.3);
        }

        .post-thumb img {
            width: 100%;
            height: auto;
            border-radius: 12px 12px 0 0;
            transition: transform 0.3s ease;
        }

        .post-item:hover .post-thumb img {
            transform: scale(1.05);
        }

        .post-content {
            padding: 1.5rem;
        }

        .blog-header h6 {
            color: var(--text-lighter);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .meta-post {
            display: flex;
            margin-bottom: 1rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .entry-content p {
            color: var(--text-light);
            font-size: 1rem;
            line-height: 1.6;
        }

        h6 a {
            color: #adc3e1  !important;
        }

        .post-item .post-content .meta-post a {
            color: #adc3e1 !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav {
                display: flex;
            }
        }

        @media (min-width: 768px) {
            .nav {
                display: none;
            }
        }
    </style>

    <!-- Mobile Navigation -->
    <nav class="nav">
    <a href="{{ route('home') }}" class="nav__link nav__link--active">
        <i class="material-icons nav__icon">home</i>
        <span class="nav__text">@lang('Home')</span>
    </a>
    <a href="{{ route('pages', ['about']) }}" class="nav__link">
        <i class="material-icons nav__icon">info</i>
        <span class="nav__text">@lang('About')</span>
    </a>
    <a href="{{ route('pages', ['how-it-works']) }}" class="nav__link">
        <i class="material-icons nav__icon">help</i>
        <span class="nav__text">@lang('How It Works')</span>
    </a>
    <a href="{{ route('contact') }}" class="nav__link ">
        <i class="material-icons nav__icon">mail</i>
        <span class="nav__text">@lang('Contact')</span>
    </a>
    @guest
        <a href="{{ route('user.login') }}" class="nav__link ">
            <i class="material-icons nav__icon">login</i>
            <span class="nav__text">@lang('Login')</span>
        </a>
    @else
        <a href="{{ route('user.home') }}" class="nav__link">
            <i class="material-icons nav__icon">dashboard</i>
            <span class="nav__text">@lang('Dashboard')</span>
        </a>
    @endguest
</nav>


    <div class="video-background">
        <video autoplay muted loop id="myVideo">
            <source src="https://kredox.org/All-Media/Dashboard.webm" type="video/webm">
        </video>
    </div>

    <section class="blog-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center mb-30-none">
                @foreach($blogs as $element)
                    <div class="col-md-6 col-xl-4 col-sm-10">
                        <div class="post-item">
                            <div class="post-thumb c-thumb">
                                <a href="{{ route('blog.details', [$element->id, slug($element->data_values->title)]) }}">
                                    <img src="{{ getImage('assets/images/frontend/blog/thumb_'. @$element->data_values->blog_image, '370x275')}}" alt="blog">
                                </a>
                            </div>
                            <div class="post-content">
                                <div class="blog-header">
                                    <h6 class="title">
                                        <a href="{{ route('blog.details', [$element->id, slug($element->data_values->title)]) }}">{{__(@$element->data_values->title)}}</a>
                                    </h6>
                                </div>
                                <div class="meta-post">
                                    <div class="date">
                                        <a href="javascript:void(0)">
                                            <i class="flaticon-calendar"></i>
                                            {{showDateTime($element->created_at, 'd M Y')}}
                                        </a>
                                    </div>
                                </div>
                                <div class="entry-content">
                                    <p>{{strlimit(strip_tags(@$element->data_values->description_nic), 100)}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{paginateLinks($blogs)}}
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('myVideo');
            if (video) {
                const playPromise = video.play();

                if (playPromise !== undefined) {
                    playPromise.catch(error => {
                        video.muted = true;
                        video.play();
                    });
                }
            }
        });
    </script>
@endsection
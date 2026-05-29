@php
    $content = getContent('how_to_work.content', true);
    $elements = getContent('how_to_work.element');
@endphp
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<nav class="nav">
    <a href="{{ route('home') }}" class="nav__link">
        <i class="material-icons nav__icon">home</i>
        <span class="nav__text">@lang('Home')</span>
    </a>
    <a href="{{ route('pages', ['about']) }}" class="nav__link ">
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


<style>
    :root {
        --primary-color: #0d8aad;
        --secondary-color: #00c9a7;
        --accent-color: #00ffcc;
        --dark-color: #0a192f;
        --darker-color: #020c1b;
        --light-color: #ccd6f6;
        --lighter-color: #e6f1ff;
        --success-color: #64ffda;
        --warning-color: #ff9e64;
        --danger-color: #ff6b6b;
        --gradient-primary: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        --gradient-accent: linear-gradient(135deg, var(--accent-color) 0%, #00ffcc 100%);
        --shadow-sm: 0 2px 10px rgba(0, 0, 0, 0.3);
        --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.4);
        --shadow-lg: 0 8px 30px rgba(0, 201, 167, 0.3);
        --card-bg: #112240;
        --nav-bg: #020c1b;
    }

    body {
        margin: 0 0 65px 0;
        /* Leave space for bottom nav */
    }

    /* ========== Mobile Navigation ========== */
    .nav {
        display: none;
    }

    @media screen and (max-width: 767px) {
        .nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 65px;
            background: var(--nav-bg);
            display: flex;
            overflow-x: auto;
            z-index: 1000;
            box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.3);
            border-top: 1px solid rgba(100, 255, 218, 0.1);
        }

        .nav__link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
            min-width: 55px;
            overflow: hidden;
            white-space: nowrap;
            font-size: 11px;
            font-weight: 600;
            color: rgba(204, 214, 246, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            -webkit-tap-highlight-color: transparent;
            padding: 6px 3px;
        }

        .nav__link:hover {
            color: var(--accent-color);
            background: rgba(100, 255, 218, 0.05);
        }

        .nav__link--active {
            color: var(--accent-color);
            background: rgba(100, 255, 218, 0.1);
        }

        .nav__icon {
            font-size: 22px;
            margin-bottom: 3px;
            transition: all 0.3s ease;
        }

        .nav__link--active .nav__icon {
            transform: translateY(-3px);
        }
</style>
<section class="how-section padding-top padding-bottom oh">
    <div class="container">
        <div class="section-header">
            <h2 class="title">{{__(@$content->data_values->heading)}}</h2>
            <p>{{__(@$content->data_values->sub_heading)}}</p>
        </div>
        <div class="how-wrapper">
            @foreach($elements as $element)
                <div class="how-item">
                    <div class="how-thumb">
                        @php echo $element->data_values->work_icon @endphp
                    </div>
                    <div class="how-content">
                        <h5 class="title">{{__($element->data_values->title)}}</h5>
                        <p>{{__($element->data_values->sub_title)}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
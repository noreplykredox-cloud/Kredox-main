<header class="header-section">
    <div class="container">
        <div class="header-wrapper">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="logo">
                </a>
            </div>
            <ul class="menu">
 
                <li>
                    <a href="{{ route('home') }}">@lang('Home')</a>
                </li>

                @foreach ($pages as $k => $data)
                    <li><a href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a></li>
                @endforeach

                <li>
                    <a href="{{ route('plan') }}">@lang('Plan')</a>
                </li>

                <li>
                    <a href="{{ route('blog') }}">@lang('Blog')</a>
                </li>

                <li>
                    <a href="{{ route('contact') }}">@lang('Contact')</a>
                </li>
                
                
                @guest
                    <li class="d-md-none">
                        <a href="{{ route('user.login') }}" class="custom-button theme py-0 m-1">@lang('Sign In')</a>
                    </li>
                @endguest

                @auth
                    <li class="d-md-none">
                        <a href="{{ route('user.home') }}" class="custom-button theme py-0 m-1">@lang('Dashboard')</a>
                    </li>
                @endauth
                

            </ul>
            
            <div class="right-area ms-lg-0 ms-auto">
                
                @if ($general->language == 1)
                    <select name="language" class="select-bar langSel">
                        @foreach ($language as $item)
                            <option value="{{ $item->code }}" @if (session('lang') == $item->code) selected @endif>
                                {{ __($item->name) }}</option>
                        @endforeach
                    </select>
                @endif

                @guest
                    <a href="{{ route('user.login') }}" class="custom-button theme hover-cl-light d-none d-md-flex">
                        @lang('Sign In')
                    </a>
                @endguest

                @auth
                    <a href="{{ route('user.home') }}"
                        class="custom-button theme hover-cl-light d-none d-md-flex">@lang('Dashboard')</a>
                @endauth

            </div>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<a href="https://api.whatsapp.com/send?phone=918619170510" class="float" target="_blank">
<i class="fa fa-whatsapp my-float"></i>
</a>
<style>
    .float{
position: fixed;
    width: 60px;
    height: 60px;
    bottom: 67px;
    right: 13px;
    background-color: #25d366;
    color: #FFF;
    border-radius: 50px;
    text-align: center;
    font-size: 30px;
    box-shadow: 2px 2px 3px #999;
    z-index: 100;
}

.my-float{
	margin-top:16px;
}
                         
                
    
    <link rel="stylesheet" 
          href=
"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .download-btn {
            display: inline-block;
            padding: 2px 5px;
            background-color: #a5fb73;
            color: rgb(0, 0, 0);
            border: none;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none;
            transition:
                background-color 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .download-btn:hover {
            background-color: #0056b3;
        }

        .download-icon {
            margin-right: 5px;
        }

        .download-btn::after {
            content: "";
            position: absolute;
            top: 0;
            left: 50%;
            width: 100%;
            height: 100%;
            background-color:
                rgba(255, 255, 255, 0.3);
            transform:
                translateX(-50%) scaleX(0);
            transition:
                transform 0.5s ease-in-out;
            z-index: 1;
        }

        .download-btn:hover::after {
            transform:
                translateX(-50%) scaleX(1);
        }
    </style>
    <a href="https://yukotrader.com/Yuko-Trader.apk" class="download-btn">
        <i class="fas fa-download download-icon"></i>
        Download APK
    </a>


            <div class="header-bar ms-2 ms-md-4">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</header>

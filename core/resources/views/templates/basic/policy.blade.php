@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <style>
        :root {
            --primary-red: #ff0000;
            --deep-red: #8b0000;
            --black-pure: #000000;
            --glass-bg: rgba(255, 255, 255, 0.02);
        }

        .policy-wrapper {
            background-color: var(--black-pure);
            min-height: 100vh;
            padding: 150px 0 100px;
            position: relative;
            overflow: hidden;
        }

        /* Orbital Background Effect */
        .orbital-bg {
            position: absolute;
            top: 0;
            right: 0;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(255, 0, 0, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(30%, -30%);
            pointer-events: none;
        }

        .policy-header {
            text-align: center;
            margin-bottom: 80px;
            position: relative;
            z-index: 5;
        }

        .policy-badge {
            display: inline-block;
            background: rgba(255, 0, 0, 0.1);
            color: var(--primary-red);
            padding: 8px 25px;
            border-radius: 50px;
            font-weight: 900;
            letter-spacing: 3px;
            font-size: 11px;
            margin-bottom: 25px;
            border: 1px solid rgba(255, 0, 0, 0.2);
            text-transform: uppercase;
        }

        .policy-title {
            font-size: clamp(40px, 6vw, 70px);
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -2px;
            margin-bottom: 20px;
        }

        .policy-title span {
            color: var(--primary-red);
            text-shadow: 0 0 20px rgba(255, 0, 0, 0.4);
        }

        /* Policy Content Box */
        .policy-fortress {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 40px;
            padding: 60px;
            position: relative;
            z-index: 5;
            box-shadow: 0 50px 100px rgba(0, 0, 0, 0.5);
        }

        .policy-fortress::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 3px;
            background: var(--primary-red);
            box-shadow: 0 0 15px var(--primary-red);
            border-radius: 0 0 10px 10px;
        }

        /* Content Styling */
        .policy-content-rich {
            color: #bbb;
            line-height: 1.8;
            font-size: 16px;
        }

        .policy-content-rich h1,
        .policy-content-rich h2,
        .policy-content-rich h3,
        .policy-content-rich h4 {
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 40px 0 20px;
            font-weight: 800;
        }

        .policy-content-rich h2 {
            font-size: 24px;
            border-left: 4px solid var(--primary-red);
            padding-left: 20px;
        }

        .policy-content-rich p {
            margin-bottom: 25px;
        }

        .policy-content-rich ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 30px;
        }

        .policy-content-rich ul li {
            position: relative;
            padding-left: 30px;
            margin-bottom: 15px;
        }

        .policy-content-rich ul li::before {
            content: '→';
            position: absolute;
            left: 0;
            color: var(--primary-red);
            font-weight: 900;
        }

        .policy-content-rich strong {
            color: #fff;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #050505;
        }

        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-red);
        }

        @media (max-width: 767px) {
            .policy-wrapper {
                padding-top: 120px;
            }

            .policy-fortress {
                padding: 22px 0px;
                border-radius: 30px;
            }

            .policy-title {
                font-size: 35px;
            }

            .policy-header {
                margin-bottom: 50px;
            }
        }
    </style>

    <div class="policy-wrapper">
        <div class="orbital-bg"></div>

        <div class="container">
            <div class="policy-header">
                <span class="policy-badge">Protocol Classification</span>
                <h1 class="policy-title">Legal <span>Infrastructure</span></h1>
                <div class="d-flex justify-content-center">
                    <div
                        style="width: 60px; height: 2px; background: var(--primary-red); box-shadow: 0 0 10px var(--primary-red);">
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="policy-fortress">
                        <div class="policy-content-rich">
                            @php echo $policy->data_values->details @endphp
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
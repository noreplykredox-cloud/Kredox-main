@extends($activeTemplate . 'layouts.master')
@section('content')

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --ms-primary: #ff0000;
            --ms-bg: #0a0a0a;
            --ms-card: #111111;
            --ms-border: rgba(255, 0, 0, 0.15);
            --ms-text: #ffffff;
            --ms-text-soft: #b0b0b0;
            --ms-muted: #666;
            --ms-gradient: linear-gradient(135deg, #8b0000 0%, #ff0000 100%);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--ms-bg);
            color: var(--ms-text);
            margin: 0;
            overflow: hidden;
        }

        footer {
            display: none !important;
        }

        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        #bgVideo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.12;
        }

        /* Compact Layout Wrapper */
        .viewport-wrapper {
            margin-left: 280px;
            height: 100vh;
            padding: 30px 40px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: var(--transition);
        }

        /* Withdraw History Style Header */
        .dashboard-header {
            background: #000;
            border-radius: 12px;
            border: 1px solid rgba(255, 0, 0, 0.2);
            padding: 20px 25px;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: #ff0000;
            box-shadow: 0 0 10px #ff0000;
        }

        .inner-header-box {
            padding: 9px 7px;
        }

        .greeting-text h1 {
            color: var(--ms-text);
            font-size: 28px;
            margin: 0 0 5px 0;
            font-weight: 800;
        }

        .greeting-text p {
            color: var(--ms-text-soft);
            font-size: 14px;
            margin: 0;
            font-weight: 500;
            max-width: 100%;
        }

        /* Main Grid */
        .compact-grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 25px;
            flex: 1;
            min-height: 0;
        }

        .main-card {
            background: var(--ms-card);
            border: 1px solid var(--ms-border);
            border-radius: 24px;
            padding: 17px 9px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(15px);
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .main-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--ms-gradient);
            border-radius: 24px 24px 0 0;
        }

        .card-layout {
            display: flex;
            gap: 30px;
            flex: 1;
        }

        .fields-col {
            flex: 1;
        }

        .fields-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px 25px;
        }

        /* Photo Section */
        .photo-col {
            width: 180px;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-left: 1px solid var(--ms-border);
            padding-left: 30px;
        }

        .p-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 2px solid var(--ms-primary);
            padding: 3px;
            cursor: pointer;
            position: relative;
            transition: var(--transition);
            overflow: hidden;
        }

        .p-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            background: var(--ms-bg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .p-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .p-img i {
            font-size: 60px;
            color: #333;
        }

        .avatar-edit-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 35%;
            background: rgba(0, 0, 0, 0.75);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: white;
            transition: var(--transition);
            opacity: 0;
            font-weight: 700;
            gap: 5px;
        }

        .p-preview:hover .avatar-edit-overlay {
            opacity: 1;
        }

        .p-preview:hover {
            box-shadow: 0 0 25px rgba(255, 0, 0, 0.3);
        }

        /* Photo Trust Badges */
        .photo-status {
            margin-top: 15px;
            background: rgba(0, 255, 0, 0.05);
            border: 1px solid rgba(0, 255, 0, 0.1);
            padding: 5px 12px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .photo-status .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #00ff00;
            box-shadow: 0 0 8px #00ff00;
        }

        .photo-status span {
            font-size: 10px;
            font-weight: 800;
            color: #00ff00;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .photo-trust-text {
            text-align: center;
            margin-top: 15px;
            padding: 0 5px;
        }

        .photo-trust-text h5 {
            font-size: 13px;
            font-weight: 800;
            color: #fff;
            margin: 0 0 5px;
            letter-spacing: 0.5px;
        }

        .photo-trust-text p {
            font-size: 10.5px;
            color: var(--ms-text-soft);
            line-height: 1.5;
            margin: 0;
        }

        /* Sidebar Info */
        .side-panel {
            background: var(--ms-card);
            border: 1px solid var(--ms-border);
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.8);
            display: flex;
            flex-direction: column;
        }

        .sb-feat {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .sb-ico {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 0, 0, 0.08);
            border: 1px solid rgba(255, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--ms-primary);
            font-size: 20px;
        }

        .sb-txt h4 {
            font-size: 15px;
            font-weight: 700;
            margin: 0 0 3px;
            color: #fff;
        }

        .sb-txt p {
            font-size: 11.5px;
            color: var(--ms-text-soft);
            line-height: 1.4;
            margin: 0;
        }

        /* Inputs */
        .fg {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .fg.w100 {
            grid-column: span 2;
        }

        .fl {
            font-size: 12px;
            font-weight: 700;
            color: var(--ms-muted);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-left: 2px;
        }

        .fi {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 0, 0, 0.12);
            border-radius: 12px;
            padding: 13px 16px;
            color: #fff;
            font-size: 15.5px;
            font-weight: 500;
            transition: var(--transition);
            outline: none;
        }

        .fi:focus {
            border-color: var(--ms-primary);
            background: rgba(255, 0, 0, 0.04);
        }

        .fi:read-only {
            color: #666;
            background: rgba(0, 0, 0, 0.1);
            border-color: transparent;
        }

        .sb-btn {
            background: var(--ms-gradient);
            color: #fff;
            border: none;
            padding: 14px 45px;
            border-radius: 16px;
            font-size: 15px;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 10px 30px rgba(255, 0, 0, 0.4);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
        }

        .sb-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 0, 0, 0.6);
        }

        /* FAQ */
        .q-title {
            font-size: 16px;
            font-weight: 800;
            margin: 20px 0 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .q-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--ms-border);
            border-radius: 12px;
            margin-bottom: 8px;
        }

        .q-head {
            padding: 10px 15px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            font-weight: 700;
        }

        .q-head i {
            color: var(--ms-primary);
            font-size: 18px;
        }

        .q-body {
            padding: 0 15px;
            max-height: 0;
            overflow: hidden;
            transition: var(--transition);
            font-size: 12px;
            color: var(--ms-text-soft);
        }

        .q-card.active .q-body {
            padding: 5px 15px 15px;
            max-height: 100px;
        }

        /* RESPONSIVE */
        @media (max-width: 1400px) {
            .compact-grid {
                grid-template-columns: 1fr;
            }

            body {
                overflow: auto;
            }

            .viewport-wrapper {
                height: auto;
                margin-left: 280px;
                padding: 25px;
            }
        @media (max-width: 1200px) {
            .viewport-wrapper {
                margin-left: 0;
                padding: 70px 10px 15px 10px;
            }

            body {
                overflow: auto;
            }
            
            .dashboard-header {
                padding: 15px 12px;
                margin-bottom: 15px;
            }
            
            .greeting-text h1 {
                font-size: 22px;
            }
            
            .greeting-text p {
                font-size: 13px;
            }
        }

        @media (max-width: 991px) {
            .card-layout {
                flex-direction: column-reverse;
            }

            .photo-col {
                width: 100%;
                border-left: none;
                padding-left: 0;
                border-bottom: 1px solid var(--ms-border);
                padding-bottom: 25px;
                margin-bottom: 15px;
            }
        }

        @media (max-width: 576px) {
            .viewport-wrapper {
                padding-top: 85px;
                padding-left: 12px;
                padding-right: 12px;
            }
            
            .dashboard-header {
                padding: 18px 12px;
            }

            .greeting-text h1 {
                font-size: 20px;
            }

            .fields-grid {
                grid-template-columns: 1fr;
            }

            .fg.w100 {
                grid-column: span 1;
            }

            .sb-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="viewport-wrapper">

        {{-- Withdraw History Style Header --}}
        <div class="dashboard-header">
            <div class="inner-header-box">
                <div class="greeting-text">
                    <h1>Profile Management</h1>
                    <p>Update your personal information, manage your profile visibility, and secure your account credentials
                        to ensure the best experience on our platform.</p>
                </div>
            </div>
        </div>

        <div class="compact-grid">

            <div class="main-card">
                <form action="" method="post" style="height: 100%; display: flex; flex-direction: column;">
                    @csrf
                    <div class="card-layout">

                        <div class="fields-col">
                            <div class="fields-grid">
                                <div class="fg">
                                    <label class="fl">First Name</label>
                                    <input type="text" name="firstname" value="{{ $user->firstname }}" class="fi" required>
                                </div>
                                <div class="fg">
                                    <label class="fl">Last Name</label>
                                    <input type="text" name="lastname" value="{{ $user->lastname }}" class="fi" required>
                                </div>
                                <div class="fg">
                                    <label class="fl">Email Address</label>
                                    <input type="email" value="{{ $user->email }}" class="fi" readonly>
                                </div>
                                <div class="fg">
                                    <label class="fl">Mobile Number</label>
                                    <input type="text" value="{{ $user->mobile }}" class="fi" readonly>
                                </div>
                                <div class="fg w100">
                                    <label class="fl">Home Address</label>
                                    <input type="text" name="address" value="{{ @$user->address->address }}" class="fi"
                                        placeholder="Full street address">
                                </div>
                                <div class="fg">
                                    <label class="fl">City</label>
                                    <input type="text" name="city" value="{{ @$user->address->city }}" class="fi">
                                </div>
                                <div class="fg">
                                    <label class="fl">State</label>
                                    <input type="text" name="state" value="{{ @$user->address->state }}" class="fi">
                                </div>
                                <div class="fg">
                                    <label class="fl">Zip / Pincode</label>
                                    <input type="text" name="zip" value="{{ @$user->address->zip }}" class="fi">
                                </div>
                                <div class="fg">
                                    <label class="fl">Country</label>
                                    <input type="text" value="{{ @$user->address->country }}" class="fi" disabled>
                                </div>
                            </div>

                            <div style="display: flex; justify-content: flex-end;">
                                <button type="submit" class="sb-btn">
                                    Save Profile
                                    <i class="material-icons">verified</i>
                                </button>
                            </div>
                        </div>

                        {{-- Profile Photo Section --}}
                        <div class="photo-col">
                            <div class="p-preview" onclick="openAvatarModal()">
                                <div class="p-img">
                                    @if($user->image)
                                        <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image) }}"
                                            alt="Profile">
                                    @else
                                        <i class="fas fa-user"></i>
                                    @endif
                                </div>
                                <div class="avatar-edit-overlay">
                                    <i class="fas fa-camera"></i>
                                    <span>Edit</span>
                                </div>
                            </div>

                            {{-- Trust Badges & Info Text --}}
                            <div class="photo-status">
                                <div class="dot"></div>
                                <span>Active Identity</span>
                            </div>

                            <div class="photo-trust-text">
                                <h5>IDENTITY PHOTO</h5>
                                <p>Used for account security, transaction verification, and instant platform sync.</p>
                            </div>

                            <div
                                style="margin-top: 20px; text-align: center; border-top: 1px solid var(--ms-border); padding-top: 15px; width: 100%;">
                                <p
                                    style="color: var(--ms-muted); font-size: 10px; text-transform: uppercase; font-weight: 700;">
                                    Account Safety</p>
                                <div style="color: var(--ms-primary); font-size: 18px; margin-top: 5px;">
                                    <i class="fas fa-shield-alt"></i>
                                    <i class="fas fa-lock" style="margin-left: 10px;"></i>
                                    <i class="fas fa-user-check" style="margin-left: 10px;"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <div class="side-panel">
                <div class="sb-feat">
                    <div class="sb-ico"><i class="material-icons">shield</i></div>
                    <div class="sb-txt">
                        <h4>Bank-Level Security</h4>
                        <p>Protected with 256-bit SSL encryption protocols.</p>
                    </div>
                </div>

                <div class="sb-feat">
                    <div class="sb-ico"><i class="material-icons">cloud_done</i></div>
                    <div class="sb-txt">
                        <h4>Global Sync</h4>
                        <p>Updates synchronized instantly across the network.</p>
                    </div>
                </div>

                <div class="sb-feat">
                    <div class="sb-ico"><i class="material-icons">support_agent</i></div>
                    <div class="sb-txt">
                        <h4>24/7 Support</h4>
                        <p>Get priority help for account verification anytime.</p>
                    </div>
                </div>

                <div class="q-title"><i class="material-icons">menu_book</i> Knowledge Base</div>

                <div class="q-card" onclick="this.classList.toggle('active')">
                    <div class="q-head">Identity Secure? <i class="material-icons">keyboard_arrow_down</i></div>
                    <div class="q-body">Advanced hashing ensures your personal data is never exposed.</div>
                </div>

                <div class="q-card" onclick="this.classList.toggle('active')">
                    <div class="q-head">Change Email? <i class="material-icons">keyboard_arrow_down</i></div>
                    <div class="q-body">Requires manual verification via a support ticket.</div>
                </div>
            </div>

        </div>
    </div>

@endsection
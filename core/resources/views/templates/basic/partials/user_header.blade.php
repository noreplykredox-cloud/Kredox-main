<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __($general->site_name) }} - User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-black: #0a0a0a;
            --dark-black: #000000;
            --card-black: #111111;
            --sidebar-black: #0d0d0d;
            --accent-red: #ff0000;
            --deep-red: #8b0000;
            --light-red: #ff3333;
            --hover-red: #ff1a1a;
            --border-red: rgba(255, 0, 0, 0.2);
            --text-white: #ffffff;
            --text-light: #e6e6e6;
            --text-muted: #999999;
            --success-green: #00ff00;
            --gradient-red: linear-gradient(135deg, var(--deep-red) 0%, var(--accent-red) 100%);
            --gradient-black: linear-gradient(135deg, var(--dark-black) 0%, var(--card-black) 100%);
            --shadow-red: 0 0 15px rgba(255, 0, 0, 0.3);
            --transition: all 0.3s ease;
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--dark-black);
            color: var(--text-white);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .sidebar-container {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-black);
            border-right: 1px solid var(--border-red);
            box-shadow: 5px 0 25px rgba(0, 0, 0, 0.5);
            z-index: 1000;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            /* Hide scrollbar but keep functionality */
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE and Edge */
        }

        .sidebar-container::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }

        .sidebar-logo {
            border-bottom: 1px solid var(--border-red);
            background: var(--gradient-black);
            text-align: center;
            flex-shrink: 0;
            padding: 15px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-logo a {
            display: inline-block;
            transition: var(--transition);
        }


        .sidebar-logo img {
            width: 235px;
            height: 188px;
            object-fit: fill;
            margin-top: -15px;
            filter: brightness(1.2) drop-shadow(0 0 10px rgba(255, 0, 0, 0.3));
        }

        .sidebar-logo a:hover {
            transform: scale(1.05);
        }

        /* User Profile Section - Aesthetic Refinement */
        .user-profile {
            padding: 22px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.02);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
            margin-bottom: 5px;
            backdrop-filter: blur(5px);
        }

        /* Name row — name + inline edit button */
        .name-row {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 0;
        }

        .profile-edit-btn {
            position: static;
            width: 18px;
            height: 18px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 8px;
            transition: var(--transition);
            cursor: pointer;
            z-index: 5;
            flex-shrink: 0;
        }

        .profile-edit-btn:hover {
            background: var(--gradient-red);
            color: white;
            border-color: transparent;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.3);
            transform: scale(1.1);
        }

        .user-avatar {
            width: 52px;
            height: 52px;
            background: var(--dark-black);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid var(--accent-red);
            padding: 2px;
            position: relative;
            cursor: pointer;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.15);
            flex-shrink: 0;
            overflow: hidden;
        }

        .user-avatar-inner {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            background: var(--card-black);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-avatar-inner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-avatar-inner i {
            font-size: 22px;
            color: var(--text-muted);
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-edit-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 35%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: white;
            transition: var(--transition);
            opacity: 0;
        }

        .user-avatar:hover .avatar-edit-overlay {
            opacity: 1;
        }

        /* Avatar Modal Styles */
        .avatar-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: var(--transition);
        }

        .avatar-modal-overlay.show {
            display: flex;
            opacity: 1;
        }

        .avatar-modal-card {
            background: var(--card-black);
            border: 1px solid var(--border-red);
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            padding: 35px;
            box-shadow: var(--shadow-card);
            transform: translateY(-20px);
            transition: var(--transition);
        }

        @media (max-width: 480px) {
            .avatar-modal-card {
                padding: 25px 20px;
                width: 95%;
            }

            .current-avatar-preview {
                width: 150px;
                height: 150px;
            }

            .avatar-modal-header h3 {
                font-size: 16px;
            }
        }

        .avatar-modal-overlay.show .avatar-modal-card {
            transform: translateY(0);
        }

        .avatar-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255, 0, 0, 0.1);
            padding-bottom: 15px;
        }

        .avatar-modal-header h3 {
            color: var(--text-white);
            margin: 0;
            font-size: 18px;
        }

        .close-modal-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 20px;
            cursor: pointer;
            transition: var(--transition);
        }

        .close-modal-btn:hover {
            color: var(--light-red);
            transform: rotate(90deg);
        }

        .avatar-modal-body {
            text-align: center;
        }

        .current-avatar-preview {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            border: 3px solid rgba(255, 0, 0, 0.4);
            margin: 0 auto 20px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--dark-black);
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.2);
        }

        .current-avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .current-avatar-preview i {
            font-size: 70px;
            color: var(--text-muted);
        }

        .upload-btn-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
            width: 100%;
        }

        .upload-btn-wrapper span {
            display: block;
            padding: 12px 20px;
            background: rgba(255, 0, 0, 0.1);
            border: 1px dashed var(--light-red);
            color: var(--light-red);
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
        }

        .upload-btn-wrapper:hover span {
            background: rgba(255, 0, 0, 0.2);
        }

        .upload-btn-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
            height: 100%;
            width: 100%;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .save-avatar-btn,
        .remove-avatar-btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .save-avatar-btn {
            background: var(--gradient-red);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 0, 0, 0.3);
        }

        .save-avatar-btn:hover:not(:disabled) {
            box-shadow: 0 4px 20px rgba(255, 0, 0, 0.5);
            transform: translateY(-2px);
        }

        .save-avatar-btn:disabled {
            background: #222;
            color: #555;
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
            opacity: 0.6;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Spinner Styles */
        .btn-spinner {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: btn-spin 0.8s linear infinite;
        }

        @keyframes btn-spin {
            to {
                transform: rotate(360deg);
            }
        }

        .remove-avatar-btn {
            background: transparent;
            border: 1px solid var(--border-red);
            color: var(--text-light);
        }

        .remove-avatar-btn:hover {
            background: rgba(255, 0, 0, 0.1);
            color: var(--light-red);
        }

        .user-info {
            flex: 1;
            min-width: 0;
            /* Prevents overflow */
        }

        .user-info h4 {
            color: var(--text-white);
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 4px;
            letter-spacing: 0.2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 180px;
            /* Base desktop width */
        }

        .profile-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
            min-width: 0;
        }

        .uid-badge {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.4);
            font-size: 10px;
            padding: 2px 7px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
            letter-spacing: 0.4px;
            min-width: 0;
            overflow: hidden;
            max-width: 120px;
        }

        .uid-badge b {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex: 1;
            min-width: 0;
        }

        .online-indicator {
            flex-shrink: 0;
        }

        .uid-badge span {
            text-transform: uppercase;
        }

        .uid-badge b {
            color: var(--light-red);
            font-weight: 600;
            text-transform: lowercase;
            /* Specifically force lowercase for the value */
        }

        .online-indicator {
            display: flex;
            align-items: center;
            gap: 4px;
            color: var(--success-green);
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .online-indicator .dot {
            width: 6px;
            height: 6px;
            background: var(--success-green);
            border-radius: 50%;
            box-shadow: 0 0 8px var(--success-green);
            animation: pulse-online 2.5s infinite;
        }

        @keyframes pulse-online {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.6;
                transform: scale(1.1);
            }
        }

        /* Navigation Menu */
        .sidebar-menu {
            padding: 15px 0;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            /* Hide scrollbar */
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .sidebar-menu::-webkit-scrollbar {
            display: none;
        }

        .menu-item {
            list-style: none;
            margin-bottom: 2px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: var(--text-light);
            text-decoration: none;
            transition: var(--transition);
            position: relative;
            font-weight: 500;
            white-space: nowrap;
        }

        .menu-link:hover,
        .menu-item.active .menu-link {
            background: rgba(255, 0, 0, 0.1);
            color: var(--light-red);
            border-left: 3px solid var(--accent-red);
        }

        .menu-link i {
            width: 24px;
            font-size: 18px;
            margin-right: 15px;
            text-align: center;
            flex-shrink: 0;
        }

        .menu-text {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dropdown-arrow {
            font-size: 12px;
            transition: var(--transition);
            margin-left: auto;
            flex-shrink: 0;
        }

        .menu-item.open .dropdown-arrow {
            transform: rotate(90deg);
        }

        /* Submenu */
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
            background: rgba(20, 20, 20, 0.8);
        }

        .menu-item.open .submenu {
            max-height: 500px;
        }

        .submenu-item {
            list-style: none;
        }

        .submenu-link {
            display: flex;
            align-items: center;
            padding: 12px 20px 12px 55px;
            color: var(--text-muted);
            text-decoration: none;
            transition: var(--transition);
            font-size: 14px;
            position: relative;
            white-space: nowrap;
        }

        .submenu-link:hover,
        .submenu-item.active .submenu-link {
            color: var(--light-red);
            background: rgba(255, 0, 0, 0.05);
        }

        .submenu-link i {
            width: 18px;
            font-size: 13px;
            margin-right: 10px;
            flex-shrink: 0;
        }

        /* Status Indicator */
        .status-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: var(--success-green);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--success-green);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        /* Bottom Section */
        .sidebar-bottom {
            margin-top: auto;
            flex-shrink: 0;
            border-top: 1px solid var(--border-red);
        }

        /* Account Menu */
        .account-menu {
            padding: 0px 0;
        }

        /* Logout Section */
        .logout-section {
            padding: 10px 0;
            background: var(--gradient-black);
        }

        .logout-link {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: var(--text-light);
            text-decoration: none;
            transition: var(--transition);
            font-weight: 500;
            white-space: nowrap;
        }

        .logout-link:hover {
            background: rgba(255, 0, 0, 0.1);
            color: var(--light-red);
        }

        .logout-link i {
            width: 24px;
            font-size: 18px;
            margin-right: 15px;
            flex-shrink: 0;
        }

        /* Mobile Top Bar */
        .mobile-top-bar {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background: var(--gradient-black);
            border-bottom: 1px solid var(--border-red);
            z-index: 1001;
            align-items: center;
            justify-content: space-between;
            padding: 0 15px;
            box-shadow: var(--shadow-red);
        }

        .mobile-toggle {
            background: transparent;
            border: none;
            color: var(--text-white);
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            transition: var(--transition);
        }

        .mobile-toggle:hover {
            color: var(--light-red);
        }

        .mobile-logo-img {
            width: 203px;
            height: 120px;
            object-fit: fill;
            margin-top: -10px;
            filter: brightness(1.2) drop-shadow(0 0 5px rgba(255, 0, 0, 0.3));
        }

        .mobile-notification {
            color: var(--text-white);
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            text-decoration: none;
            transition: var(--transition);
        }

        .mobile-notification:hover {
            color: var(--light-red);
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(3px);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Main Content Area */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background: var(--dark-black);
            transition: var(--transition);
            padding: 20px;
        }

        /* Content Header for Mobile */
        .content-header {
            display: none;
            padding: 15px;
            background: var(--card-black);
            border-bottom: 1px solid var(--border-red);
            margin: -20px -20px 20px -20px;
            align-items: center;
            gap: 15px;
        }

        .mobile-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }

        .mobile-user-avatar {
            width: 40px;
            height: 40px;
            background: var(--gradient-red);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: var(--text-white);
            border: 2px solid var(--light-red);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar-container {
                width: 280px;
                transform: translateX(-100%);
                padding-top: 0;
            }

            .sidebar-logo {
                display: flex !important;
                height: 54px;
                background: transparent;
                border-bottom: 1px solid rgba(255, 0, 0, 0.1);
                margin-bottom: 5px;
            }

            .user-profile {
                display: flex !important;
                padding: 12px 14px !important;
                gap: 12px !important;
            }

            .user-avatar {
                width: 46px !important;
                height: 46px !important;
                flex-shrink: 0 !important;
                align-self: center !important;
                border: 1.5px solid #ff0000 !important;
                box-shadow: 0 0 10px rgba(255, 0, 0, 0.35) !important;
                padding: 2px !important;
            }

            .user-info {
                flex: 1 !important;
                min-width: 0 !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: center !important;
                gap: 4px !important;
            }

            .user-info h4 {
                font-size: 15px !important;
                font-weight: 700 !important;
                color: #ffffff !important;
                margin: 0 !important;
                padding: 0 !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
                line-height: 1.2 !important;
            }

            .profile-meta {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                gap: 8px !important;
                flex-wrap: nowrap !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .uid-badge {
                font-size: 10px !important;
                padding: 2px 7px !important;
                border-radius: 4px !important;
                white-space: nowrap !important;
                margin: 0 !important;
                max-width: 110px !important;
                min-width: 0 !important;
                overflow: hidden !important;
            }

            .uid-badge b {
                color: #ff3333 !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
                white-space: nowrap !important;
                flex: 1 !important;
                min-width: 0 !important;
            }

            .online-indicator {
                font-size: 10px !important;
                font-weight: 800 !important;
                color: #00ff00 !important;
                white-space: nowrap !important;
                text-shadow: 0 0 8px rgba(0, 255, 0, 0.3) !important;
                margin: 0 !important;
                flex-shrink: 0 !important;
            }

            .online-indicator .dot {
                width: 7px !important;
                height: 7px !important;
                background: #00ff00 !important;
                box-shadow: 0 0 7px #00ff00 !important;
            }

            .profile-edit-btn {
                width: 16px !important;
                height: 16px !important;
                font-size: 7px !important;
                background: rgba(255, 255, 255, 0.04) !important;
                border: 1px solid rgba(255, 255, 255, 0.08) !important;
                color: #666 !important;
                position: static !important;
                top: unset !important;
                right: unset !important;
            }

            /* Sidebar container.active */
            .sidebar-container.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
                padding-top: 80px;
            }

            /* Fix dashboard container overlapping with mobile top bar globally */
            .dashboard-container,
            .deposit-container,
            .deposit-history-container,
            .login-container,
            .list-container,
            .payment-container,
            .password-reset-container,
            .verification-container,
            .split-container {
                margin-left: 0 !important;
                padding-top: 80px !important;
            }

            .mobile-top-bar {
                display: flex;
            }

            .sidebar-overlay {
                display: block;
            }

            .content-header {
                display: flex;
            }
        }

        @media (max-width: 768px) {
            .sidebar-menu {
                padding: 0;
            }

            .menu-link {
                padding: 10px 20px;
                font-size: 14px;
            }

            .submenu-link {
                padding: 8px 20px 8px 50px;
                font-size: 13px;
            }

            .logout-link {
                padding: 10px 20px;
            }
        }

        @media (max-width: 480px) {
            .sidebar-container {
                width: 100%;
            }

            .content-header {
                padding: 12px;
            }

            .main-content {
                padding: 12px;
            }
        }

        /* Animation Effects */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .menu-item {
            animation: fadeIn 0.5s ease forwards;
            opacity: 0;
        }

        .menu-item:nth-child(1) {
            animation-delay: 0.1s;
        }

        .menu-item:nth-child(2) {
            animation-delay: 0.2s;
        }

        .menu-item:nth-child(3) {
            animation-delay: 0.3s;
        }

        .menu-item:nth-child(4) {
            animation-delay: 0.4s;
        }

        .menu-item:nth-child(5) {
            animation-delay: 0.5s;
        }

        .menu-item:nth-child(6) {
            animation-delay: 0.6s;
        }

        .menu-item:nth-child(7) {
            animation-delay: 0.7s;
        }

        /* Demo Content Styling */
        .dashboard-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .welcome-card {
            background: var(--gradient-black);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid var(--border-red);
            box-shadow: var(--shadow-red);
        }

        .welcome-card h1 {
            color: var(--text-white);
            margin-bottom: 15px;
            font-size: 28px;
        }

        .welcome-card p {
            color: var(--text-light);
            font-size: 16px;
            line-height: 1.6;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--card-black);
            border-radius: 10px;
            padding: 20px;
            border: 1px solid var(--border-red);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-red);
        }

        .stat-card h3 {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-card .value {
            color: var(--light-red);
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-card .subtext {
            color: var(--text-muted);
            font-size: 13px;
        }

        /* Active link highlight */
        .menu-item.active>.menu-link {
            background: rgba(255, 0, 0, 0.15);
            color: var(--light-red);
            border-left: 3px solid var(--accent-red);
        }

        /* Improved submenu animation */
        .submenu {
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <!-- Mobile Top Bar -->
    <div class="mobile-top-bar">
        <button class="mobile-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <a href="{{ route('home') }}">
            <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="{{ __($general->site_name) }}"
                class="mobile-logo-img">
        </a>
        <a href="{{ route('ticket.index') }}" class="mobile-notification">
            <i class="fas fa-comments"></i>
        </a>
    </div>

    <!-- Overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar Navigation -->
    <div class="sidebar-container" id="sidebar">
        <!-- Logo -->
        <div class="sidebar-logo">
            <a href="{{ route('home') }}">
                <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="{{ __($general->site_name) }}">
            </a>
        </div>

        <!-- User Profile - Premium UI -->
        <div class="user-profile">
            <div class="user-avatar" id="avatarToggleBtn" @auth onclick="openAvatarModal()" @endauth>
                <div class="user-avatar-inner">
                    @auth
                        @if(auth()->user()->image)
                            <img src="{{ getImage(getFilePath('userProfile') . '/' . auth()->user()->image, getFileSize('userProfile')) }}"
                                alt="avatar">
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    @else
                        <i class="fas fa-user"></i>
                    @endauth
                </div>
                <div class="avatar-edit-overlay">
                    <i class="fas fa-camera"></i>
                </div>
            </div>

            <div class="user-info">
                <div class="name-row">
                    <h4 title="{{ auth()->user()->fullname ?? auth()->user()->username ?? 'Guest User' }}">
                        {{ auth()->user()->fullname ?? auth()->user()->username ?? 'Guest User' }}
                    </h4>
                    <a href="{{ route('user.profile.setting') }}" class="profile-edit-btn" title="Edit Profile">
                        <i class="fas fa-pen"></i>
                    </a>
                </div>
                <div class="profile-meta">
                    <div class="uid-badge" title="UID: {{ auth()->user()->username }}">
                        <i class="fas fa-shield-halved"></i> <span>UID:</span> <b>{{ auth()->user()->username }}</b>
                    </div>
                    <div class="online-indicator">
                        <span class="dot"></span> ONLINE
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <ul class="sidebar-menu">
            <!-- Dashboard -->
            <li class="menu-item {{ request()->routeIs('user.home') ? 'active' : '' }}">
                <a href="{{ route('user.home') }}" class="menu-link">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <!-- Deposit -->
            <li class="menu-item {{ request()->routeIs('user.deposit.*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="menu-link dropdown-toggle">
                    <i class="fas fa-money-bill-wave"></i>
                    <span class="menu-text">Deposit</span>
                    <i class="fas fa-chevron-right dropdown-arrow"></i>
                </a>
                <ul class="submenu">
                    <li class="submenu-item {{ request()->routeIs('user.deposit.index') ? 'active' : '' }}">
                        <a href="{{ route('user.deposit.index') }}" class="submenu-link">
                            <i class="fas fa-plus-circle"></i>
                            <span>Deposit Money</span>
                        </a>
                    </li>
                    <li class="submenu-item {{ request()->routeIs('user.deposit.history') ? 'active' : '' }}">
                        <a href="{{ route('user.deposit.history') }}" class="submenu-link">
                            <i class="fas fa-history"></i>
                            <span>Deposit History</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Withdraw -->
            <li class="menu-item {{ request()->routeIs('user.withdraw*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="menu-link dropdown-toggle">
                    <i class="fas fa-wallet"></i>
                    <span class="menu-text">Withdraw</span>
                    <i class="fas fa-chevron-right dropdown-arrow"></i>
                </a>
                <ul class="submenu">
                    <li class="submenu-item {{ request()->routeIs('user.withdraw') ? 'active' : '' }}">
                        <a href="{{ route('user.withdraw') }}" class="submenu-link">
                            <i class="fas fa-credit-card"></i>
                            <span>Withdraw Money</span>
                        </a>
                    </li>
                    <li class="submenu-item {{ request()->routeIs('user.withdraw.history') ? 'active' : '' }}">
                        <a href="{{ route('user.withdraw.history') }}" class="submenu-link">
                            <i class="fas fa-list-alt"></i>
                            <span>Withdraw History</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Investment -->
            <li class="menu-item {{ request()->routeIs('plan') ? 'active' : '' }}">
                <a href="{{ route('plan') }}" class="menu-link">
                    <i class="fas fa-chart-line"></i>
                    <span class="menu-text">Investment</span>
                </a>
            </li>

            <!-- Transactions -->
            <li class="menu-item {{ request()->routeIs('user.transactions') ? 'active' : '' }}">
                <a href="{{ route('user.transactions') }}" class="menu-link">
                    <i class="fas fa-exchange-alt"></i>
                    <span class="menu-text">Transactions</span>
                </a>
            </li>

            <!-- Node Network -->
            <li class="menu-item {{ request()->routeIs('user.referral.*') ? 'active' : '' }}">
                <a href="javascript:void(0)" class="menu-link dropdown-toggle">
                    <i class="fas fa-network-wired"></i>
                    <span class="menu-text">Node Network</span>
                    <i class="fas fa-chevron-right dropdown-arrow"></i>
                </a>
                <ul class="submenu">
                    <li class="submenu-item {{ request()->routeIs('user.referral.log') ? 'active' : '' }}">
                        <a href="{{ route('user.referral.log') }}" class="submenu-link">
                            <i class="fas fa-link"></i>
                            <span>Connected Nodes</span>
                        </a>
                    </li>
                    @if(false) <!-- Hidden for now -->
                        <li class="submenu-item">
                            <a href="#" class="submenu-link">
                                <i class="fas fa-hand-holding-usd"></i>
                                <span>Network Allocation Rewards</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        </ul>

        <!-- Bottom Section -->
        <div class="sidebar-bottom">
            <!-- Account Menu -->
            <ul class="sidebar-menu account-menu">
                <li
                    class="menu-item {{ request()->routeIs('user.profile.*') || request()->routeIs('user.change.password') || request()->routeIs('ticket.*') ? 'active' : '' }}">
                    <a href="javascript:void(0)" class="menu-link dropdown-toggle">
                        <i class="fas fa-user-cog"></i>
                        <span class="menu-text">Account</span>
                        <i class="fas fa-chevron-right dropdown-arrow"></i>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item {{ request()->routeIs('user.profile.setting') ? 'active' : '' }}">
                            <a href="{{ route('user.profile.setting') }}" class="submenu-link">
                                <i class="fas fa-user-edit"></i>
                                <span>Profile Setting</span>
                            </a>
                        </li>

                        <li class="submenu-item {{ request()->routeIs('user.withdraw.wallets') ? 'active' : '' }}">
                            <a href="{{ route('user.withdraw.wallets') }}" class="submenu-link">
                                <i class="fas fa-wallet"></i>
                                <span>Saved Wallets</span>
                            </a>
                        </li>

                        @if ($general->balance_transfer == 1)
                            <li class="submenu-item {{ request()->routeIs('user.balance.transfer') ? 'active' : '' }}">
                                <a href="{{ route('user.balance.transfer') }}" class="submenu-link">
                                    <i class="fas fa-random"></i>
                                    <span>Balance Transfer</span>
                                </a>
                            </li>
                        @endif

                        <li class="submenu-item {{ request()->routeIs('user.change.password') ? 'active' : '' }}">
                            <a href="{{ route('user.change.password') }}" class="submenu-link">
                                <i class="fas fa-lock"></i>
                                <span>Change Password</span>
                            </a>
                        </li>

                        <li class="submenu-item {{ request()->routeIs('user.twofactor') ? 'active' : '' }}">
                            <a href="{{ route('user.twofactor') }}" class="submenu-link">
                                <i class="fas fa-shield-alt"></i>
                                <span>2FA Security</span>
                            </a>
                        </li>

                        <li class="submenu-item {{ request()->routeIs('ticket.*') ? 'active' : '' }}">
                            <a href="{{ route('ticket.index') }}" class="submenu-link">
                                <i class="fas fa-headset"></i>
                                <span>Support Messenger</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Logout/Login Section -->
            <div class="logout-section">
                @auth
                    <a href="{{ route('user.logout') }}" class="logout-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                @else
                    <a href="{{ route('user.login') }}" class="logout-link">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Login</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mobileOnlyToggle = document.querySelector('.mobile-toggle.mobile-only');
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

            // Function to toggle sidebar
            function toggleSidebar() {
                const isActive = sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');

                const icon = isActive ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
                sidebarToggle.innerHTML = icon;
                if (mobileOnlyToggle) {
                    mobileOnlyToggle.innerHTML = icon;
                }

                // Prevent body scroll when sidebar is open on mobile
                if (window.innerWidth <= 1024) {
                    document.body.style.overflow = isActive ? 'hidden' : '';
                }
            }

            // Main toggle button
            sidebarToggle.addEventListener('click', function (e) {
                e.stopPropagation();
                toggleSidebar();
            });

            // Mobile-only toggle button
            if (mobileOnlyToggle) {
                mobileOnlyToggle.addEventListener('click', function (e) {
                    e.stopPropagation();
                    toggleSidebar();
                });
            }

            // Close sidebar when clicking overlay
            sidebarOverlay.addEventListener('click', function () {
                if (sidebar.classList.contains('active')) {
                    toggleSidebar();
                }
            });

            // Avatar popup modal functions
            window.openAvatarModal = function () {
                const modal = document.getElementById('avatarModal');
                if (modal) {
                    // Reset input and state when opening
                    const input = document.getElementById('avatarUploadInput');
                    const saveBtn = document.querySelector('.save-avatar-btn');
                    const previewImg = document.getElementById('avatarPreviewImg');
                    const previewIcon = document.getElementById('avatarPreviewIcon');

                    if (input) input.value = '';
                    if (saveBtn) saveBtn.disabled = true;

                    // Reset preview to original
                    if (previewImg) {
                        const originalSrc = previewImg.getAttribute('data-original-src');
                        if (originalSrc) {
                            previewImg.src = originalSrc;
                            previewImg.style.display = 'block';
                            if (previewIcon) previewIcon.style.display = 'none';
                        } else {
                            previewImg.style.display = 'none';
                            previewImg.src = '';
                            if (previewIcon) previewIcon.style.display = 'block';
                        }
                    }

                    modal.style.display = 'flex';
                    // small delay to allow display flex to apply before opacity transition
                    setTimeout(() => modal.classList.add('show'), 10);
                }
            };

            window.closeAvatarModal = function () {
                const modal = document.getElementById('avatarModal');
                if (modal) {
                    modal.classList.remove('show');
                    setTimeout(() => {
                        modal.style.display = 'none';
                        // Reset button state on close
                        const saveBtn = document.querySelector('.save-avatar-btn');
                        if (saveBtn) saveBtn.disabled = true;
                    }, 300);
                }
            };

            window.previewAvatar = function (input) {
                const saveBtn = document.querySelector('.save-avatar-btn');
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        const icon = document.getElementById('avatarPreviewIcon');
                        const img = document.getElementById('avatarPreviewImg');
                        if (icon) icon.style.display = 'none';
                        if (img) {
                            img.style.display = 'block';
                            img.src = e.target.result;
                        }
                    }
                    reader.readAsDataURL(input.files[0]);
                    if (saveBtn) saveBtn.disabled = false;
                } else {
                    if (saveBtn) saveBtn.disabled = true;
                }
            };

            // Handle dropdown toggles
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const parent = this.parentElement;

                    // Close other dropdowns on mobile
                    if (window.innerWidth <= 1024) {
                        dropdownToggles.forEach(otherToggle => {
                            if (otherToggle !== this) {
                                otherToggle.parentElement.classList.remove('open');
                            }
                        });
                    }

                    parent.classList.toggle('open');
                });
            });

            // Close sidebar when clicking a link on mobile
            document.querySelectorAll('.menu-link, .submenu-link').forEach(link => {
                link.addEventListener('click', function (e) {
                    if (window.innerWidth <= 1024 && !this.classList.contains('dropdown-toggle')) {
                        sidebar.classList.remove('active');
                        sidebarOverlay.classList.remove('active');
                        sidebarToggle.innerHTML = '<i class="fas fa-bars"></i>';
                        if (mobileOnlyToggle) {
                            mobileOnlyToggle.innerHTML = '<i class="fas fa-bars"></i>';
                        }
                    }
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function (event) {
                if (!event.target.closest('.menu-item')) {
                    // Don't close dropdowns on desktop for better UX
                    if (window.innerWidth <= 1024) {
                        document.querySelectorAll('.menu-item.open').forEach(item => {
                            if (!item.contains(event.target)) {
                                item.classList.remove('open');
                            }
                        });
                    }
                }

                // Close sidebar when clicking outside on mobile
                if (window.innerWidth <= 1024 && sidebar.classList.contains('active')) {
                    if (!sidebar.contains(event.target) &&
                        !sidebarToggle.contains(event.target) &&
                        (!mobileOnlyToggle || !mobileOnlyToggle.contains(event.target))) {
                        toggleSidebar();
                    }
                }

                // Close avatar modal when clicking outside the card
                const avatarModal = document.getElementById('avatarModal');
                if (avatarModal && avatarModal.classList.contains('show')) {
                    const avatarCard = avatarModal.querySelector('.avatar-modal-card');
                    if (event.target === avatarModal && !avatarCard.contains(event.target)) {
                        closeAvatarModal();
                    }
                }
            });

            // Handle keyboard navigation
            document.addEventListener('keydown', function (e) {
                // Escape to close sidebar on mobile
                if (e.key === 'Escape') {
                    if (window.innerWidth <= 1024 && sidebar.classList.contains('active')) {
                        sidebar.classList.remove('active');
                        sidebarOverlay.classList.remove('active');
                        sidebarToggle.innerHTML = '<i class="fas fa-bars"></i>';
                        if (mobileOnlyToggle) {
                            mobileOnlyToggle.innerHTML = '<i class="fas fa-bars"></i>';
                        }
                    }
                }

                // Ctrl/Cmd + B to toggle sidebar
                if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                    e.preventDefault();
                    toggleSidebar();
                }
            });

            // Update layout on resize
            function updateLayout() {
                if (window.innerWidth > 1024) {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                    sidebarToggle.innerHTML = '<i class="fas fa-bars"></i>';
                    if (mobileOnlyToggle) {
                        mobileOnlyToggle.innerHTML = '<i class="fas fa-bars"></i>';
                    }
                }
            }

            window.addEventListener('resize', updateLayout);

            // Initialize active dropdowns based on current route
            function initializeActiveDropdowns() {
                const activeSubmenuItems = document.querySelectorAll('.submenu-item.active');
                activeSubmenuItems.forEach(item => {
                    const parentMenu = item.closest('.menu-item');
                    if (parentMenu) {
                        parentMenu.classList.add('active');
                    }
                });
            }

            initializeActiveDropdowns();

            // Smooth scroll for sidebar menu (without showing scrollbar)
            const sidebarMenu = document.querySelector('.sidebar-menu');
            if (sidebarMenu) {
                sidebarMenu.addEventListener('wheel', function (e) {
                    e.preventDefault();
                    this.scrollTop += e.deltaY;
                }, { passive: false });
            }

            // Handle Avatar Upload Form Submit (Show Loader)
            const avatarForm = document.getElementById('avatarUploadForm');
            if (avatarForm) {
                avatarForm.addEventListener('submit', function () {
                    const btn = this.querySelector('.save-avatar-btn');
                    if (btn) {
                        btn.disabled = true;
                        btn.innerHTML = '<span class="btn-spinner"></span> Saving...';
                        btn.style.opacity = '0.8';
                    }
                });
            }

            window.handleAvatarRemove = function () {
                const btn = document.getElementById('removeAvatarBtn');
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<span class="btn-spinner"></span> Removing...';
                    btn.style.opacity = '0.8';
                }
                document.getElementById('avatarRemoveForm').submit();
            };
        });
    </script>

    <!-- Avatar Upload Modal -->
    <div class="avatar-modal-overlay" id="avatarModal">
        <div class="avatar-modal-card">
            <div class="avatar-modal-header">
                <h3>Update Profile Photo</h3>
                <button type="button" class="close-modal-btn" onclick="closeAvatarModal()"><i
                        class="fas fa-times"></i></button>
            </div>
            <div class="avatar-modal-body">
                <div class="current-avatar-preview">
                    @if(auth()->user()->image)
                        <img src="{{ getImage(getFilePath('userProfile') . '/' . auth()->user()->image, getFileSize('userProfile')) }}"
                            alt="avatar" id="avatarPreviewImg"
                            data-original-src="{{ getImage(getFilePath('userProfile') . '/' . auth()->user()->image, getFileSize('userProfile')) }}">
                    @else
                        <i class="fas fa-user" id="avatarPreviewIcon"></i>
                        <img src="" alt="avatar" id="avatarPreviewImg" style="display:none;" data-original-src="">
                    @endif
                </div>

                <form id="avatarUploadForm" action="{{ route('user.profile.photo.submit') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <label class="upload-btn-wrapper">
                        <span><i class="fas fa-camera"></i> Choose New Photo</span>
                        <input type="file" name="image" id="avatarUploadInput" accept="image/*"
                            onchange="previewAvatar(this)">
                    </label>

                    <div class="modal-actions">
                        <button type="submit" class="save-avatar-btn" disabled><i class="fas fa-save"></i> Save
                            Changes</button>
                        @if(auth()->user()->image)
                            <button type="button" class="remove-avatar-btn" id="removeAvatarBtn"
                                onclick="handleAvatarRemove()"><i class="fas fa-trash"></i>
                                Remove</button>
                        @endif
                    </div>
                </form>

                @if(auth()->user()->image)
                    <form id="avatarRemoveForm" action="{{ route('user.profile.photo.remove') }}" method="POST"
                        style="display:none;">
                        @csrf
                    </form>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
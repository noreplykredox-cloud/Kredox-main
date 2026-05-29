@extends($activeTemplate . 'layouts.master')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __($general->site_name) }} - Manual Deposit</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <style>
        /* ========== Enhanced Dark Black & Red Theme ========== */
        :root {
            --primary-black: #0a0a0a;
            --dark-black: #000000;
            --card-black: #111111;
            --sidebar-black: #0d0d0d;
            --hover-black: #1a1a1a;
            --accent-red: #ff0000;
            --deep-red: #8b0000;
            --light-red: #ff3333;
            --hover-red: #ff1a1a;
            --border-red: rgba(255, 0, 0, 0.25);
            --text-white: #ffffff;
            --text-light: #f0f0f0;
            --text-muted: #aaaaaa;
            --success-green: #00ff88;
            --warning-orange: #ff9900;
            --danger-red: #ff4444;
            --gradient-red: linear-gradient(135deg, var(--deep-red) 0%, var(--accent-red) 100%);
            --gradient-black: linear-gradient(135deg, var(--dark-black) 0%, var(--card-black) 100%);
            --gradient-card: linear-gradient(145deg, #111111 0%, #1a1a1a 100%);
            --shadow-red: 0 0 20px rgba(255, 0, 0, 0.4);
            --shadow-card: 0 10px 30px rgba(0, 0, 0, 0.6);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --sidebar-width: 280px;
            --border-radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Roboto', system-ui, sans-serif;
            background: var(--dark-black);
            color: var(--text-white);
            min-height: 100vh;
            overflow-x: hidden;
        }
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background: var(--dark-black);
            transition: var(--transition);
            position: relative;
            overflow-x: hidden;
        }

        /* Video Background */
        .video-background {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: 100vh;
            z-index: 0;
            overflow: hidden;
            transition: var(--transition);
        }

        #bgVideo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.15) sepia(0.3) hue-rotate(-10deg) saturate(1.5);
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
            padding: 30px;
        }

        /* Mobile Navigation */
        .mobile-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: var(--gradient-black);
            border-top: 1px solid var(--border-red);
            padding: 12px 0;
            z-index: 1000;
            box-shadow: 0 -5px 30px rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
        }

        .mobile-nav .nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 12px;
            padding: 8px 5px;
            border-radius: 8px;
            transition: var(--transition);
            position: relative;
        }

        .mobile-nav .nav-link i {
            font-size: 20px;
            margin-bottom: 5px;
            transition: var(--transition);
        }

        .mobile-nav .nav-link.active {
            color: var(--light-red);
            background: rgba(255, 0, 0, 0.15);
            transform: translateY(-5px);
        }

        .mobile-nav .nav-link.active i {
            transform: scale(1.2);
            text-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
        }

        .nav-badge {
            position: absolute;
            top: -5px;
            right: 5px;
            background: var(--gradient-red);
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: bold;
        }

        /* Breadcrumb */
        .page-breadcrumb {
            margin-bottom: 25px;
        }

        .breadcrumb {
            background: rgba(0, 0, 0, 0.5);
            border-radius: var(--border-radius);
            padding: 15px 20px;
            border: 1px solid var(--border-red);
            backdrop-filter: blur(10px);
        }

        .breadcrumb-item a {
            color: var(--text-muted);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb-item a:hover {
            color: var(--light-red);
        }

        .breadcrumb-item.active {
            color: var(--light-red);
        }

        .breadcrumb-item + .breadcrumb-item::before {
            color: var(--text-muted);
        }

        /* Payment Header */
        .payment-header {
            background: var(--gradient-card);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid var(--border-red);
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-card);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .payment-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--gradient-red);
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-icon {
            width: 70px;
            height: 70px;
            background: var(--gradient-red);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: white;
            box-shadow: 0 10px 20px rgba(255, 0, 0, 0.3);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .header-text h1 {
            color: var(--text-white);
            margin: 0 0 8px 0;
            font-size: 28px;
            font-weight: 700;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .header-text p {
            color: var(--text-muted);
            margin: 0;
            font-size: 14px;
        }

        .header-status {
            display: flex;
            align-items: center;
        }

        .status-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 153, 0, 0.15);
            padding: 12px 25px;
            border-radius: 25px;
            border: 1px solid rgba(255, 153, 0, 0.3);
            backdrop-filter: blur(5px);
        }

        .status-dot {
            width: 10px;
            height: 10px;
            background: var(--warning-orange);
            border-radius: 50%;
            animation: pulse 1.5s infinite;
            box-shadow: 0 0 10px var(--warning-orange);
        }

        .status-badge span {
            color: var(--warning-orange);
            font-weight: 600;
            font-size: 14px;
        }

        /* Payment Grid */
        .payment-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        @media screen and (max-width: 1200px) {
            .payment-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Glass Card Styles */
        .glass-card {
            background: var(--gradient-card);
            border-radius: var(--border-radius);
            border: 1px solid var(--border-red);
            overflow: hidden;
            box-shadow: var(--shadow-card);
            transition: var(--transition);
            backdrop-filter: blur(10px);
        }

        .glass-card:hover {
            transform: translateY(-5px);
            border-color: var(--light-red);
            box-shadow: var(--shadow-red);
        }

        .glass-card .card-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-red);
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .glass-card .card-header h3 {
            color: var(--text-white);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: 600;
        }

        .glass-card .card-header h3 i {
            color: var(--light-red);
        }

        .glass-card .card-body {
            padding: 25px;
        }

        /* Payment Summary */
        .payment-summary {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .summary-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .summary-label {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-light);
            font-size: 15px;
        }

        .summary-label i {
            color: var(--light-red);
            font-size: 18px;
            width: 24px;
        }

        .summary-value {
            font-weight: 700;
            font-size: 18px;
            color: var(--text-white);
        }

        .summary-value.highlight {
            color: var(--light-red);
            font-size: 22px;
            text-shadow: 0 0 10px rgba(255, 0, 0, 0.3);
        }

        .summary-value.success {
            color: var(--success-green);
            font-size: 22px;
            text-shadow: 0 0 10px rgba(0, 255, 136, 0.3);
        }

        /* Crypto Address Box */
        .crypto-address-box {
            background: rgba(0, 0, 0, 0.4);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-top: 25px;
            border: 1px solid var(--border-red);
        }

        .address-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .address-header i {
            color: var(--light-red);
            font-size: 22px;
        }

        .address-header span {
            color: var(--text-white);
            font-weight: 600;
            font-size: 16px;
        }

        .address-container {
            display: flex;
            gap: 12px;
            margin-bottom: 25px;
        }

        .address-input {
            flex: 1;
            background: rgba(0, 0, 0, 0.6);
            border: 1px solid var(--border-red);
            border-radius: 8px;
            color: var(--text-white);
            padding: 15px;
            font-family: 'Courier New', monospace;
            font-size: 15px;
            letter-spacing: 1px;
            transition: var(--transition);
        }

        .address-input:focus {
            outline: none;
            border-color: var(--light-red);
            box-shadow: 0 0 0 3px rgba(255, 0, 0, 0.1);
        }

        .copy-btn {
            background: var(--gradient-red);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0 25px;
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 120px;
            justify-content: center;
            font-size: 14px;
        }

        .copy-btn:hover {
            background: var(--light-red);
            transform: translateY(-2px);
            box-shadow: var(--shadow-red);
        }

        .qrcode-container {
            text-align: center;
            padding: 20px;
        }

        .qrcode-placeholder {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            padding: 40px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            border: 2px dashed var(--border-red);
            transition: var(--transition);
        }

        .qrcode-placeholder:hover {
            border-color: var(--light-red);
            background: rgba(255, 0, 0, 0.05);
        }

        .qrcode-placeholder i {
            font-size: 60px;
            color: var(--text-muted);
        }

        .qrcode-placeholder span {
            color: var(--text-muted);
            font-size: 15px;
            font-weight: 500;
        }

        /* Method Info */
        .method-info {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 25px;
            background: rgba(0, 0, 0, 0.4);
            border-radius: var(--border-radius);
            margin-bottom: 25px;
            border: 1px solid var(--border-red);
        }

        .method-icon {
            width: 70px;
            height: 70px;
            background: var(--gradient-red);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: white;
            box-shadow: 0 10px 20px rgba(255, 0, 0, 0.3);
        }

        .method-details h4 {
            color: var(--text-white);
            margin: 0 0 8px 0;
            font-size: 20px;
            font-weight: 700;
        }

        .method-details p {
            color: var(--text-muted);
            margin: 0;
            font-size: 14px;
        }

        /* Form Fields */
        .form-fields {
            margin: 25px 0;
        }

        .contact-form-group {
            margin-bottom: 25px;
        }

        .form-label {
            color: var(--text-light);
            margin-bottom: 10px;
            display: block;
            font-weight: 600;
            font-size: 14px;
        }

        .form-control {
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid var(--border-red);
            color: var(--text-white);
            padding: 15px;
            border-radius: 8px;
            width: 100%;
            transition: var(--transition);
            font-size: 15px;
        }

        .form-control:focus {
            background: rgba(0, 0, 0, 0.6);
            border-color: var(--light-red);
            box-shadow: 0 0 0 3px rgba(255, 0, 0, 0.1);
            outline: none;
        }

        /* Important Notes */
        .important-notes {
            background: rgba(255, 153, 0, 0.15);
            border: 1px solid rgba(255, 153, 0, 0.3);
            border-radius: var(--border-radius);
            padding: 25px;
            margin: 30px 0;
        }

        .note-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .note-header i {
            color: var(--warning-orange);
            font-size: 22px;
        }

        .note-header span {
            color: var(--warning-orange);
            font-weight: 700;
            font-size: 16px;
        }

        .note-list {
            margin: 0;
            color: var(--text-light);
        }

        .note-list li {
            margin-bottom: 10px;
            line-height: 1.6;
            position: relative;
            padding-left: 5px;
        }

        .note-list li::marker {
            color: var(--warning-orange);
        }

        /* Submit Section */
        .submit-section {
            text-align: center;
            margin-top: 30px;
        }

        .submit-btn {
            background: var(--gradient-red);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 18px 40px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 12px;
            min-width: 350px;
            justify-content: center;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0 10px 30px rgba(255, 0, 0, 0.3);
        }

        .submit-btn:hover {
            background: var(--light-red);
            transform: translateY(-3px);
            box-shadow: var(--shadow-red);
        }

        .submit-btn:active {
            transform: translateY(-1px);
        }

        .help-text {
            color: var(--text-muted);
            font-size: 13px;
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        /* Support Card */
        .support-card .card-body {
            padding: 20px;
        }

        .support-content {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .support-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: var(--border-radius);
            border: 1px solid var(--border-red);
            transition: var(--transition);
            cursor: pointer;
        }

        .support-item:hover {
            background: rgba(255, 0, 0, 0.1);
            border-color: var(--light-red);
            transform: translateX(5px);
        }

        .support-item i {
            color: var(--light-red);
            font-size: 24px;
            width: 50px;
            text-align: center;
        }

        .support-item h5 {
            color: var(--text-white);
            margin: 0 0 5px 0;
            font-size: 16px;
            font-weight: 600;
        }

        .support-item p {
            color: var(--text-muted);
            margin: 0;
            font-size: 13px;
        }

        /* Recent Deposits */
        .recent-deposits-card {
            margin-top: 40px;
        }

        .recent-deposits-card .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .view-all {
            color: var(--light-red);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .view-all:hover {
            color: var(--text-white);
            transform: translateX(5px);
        }

        .deposits-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .deposit-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: var(--border-radius);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: var(--transition);
            cursor: pointer;
        }

        .deposit-item:hover {
            background: rgba(255, 0, 0, 0.05);
            border-color: var(--border-red);
            transform: translateX(5px);
        }

        .deposit-icon {
            width: 55px;
            height: 55px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .deposit-details {
            flex: 1;
        }

        .deposit-details h5 {
            color: var(--text-white);
            margin: 0 0 8px 0;
            font-size: 16px;
            font-weight: 600;
        }

        .deposit-details p {
            color: var(--text-muted);
            margin: 0;
            font-size: 13px;
        }

        .deposit-amount {
            font-weight: 700;
            font-size: 18px;
        }

        /* Colors */
        .text-success {
            color: var(--success-green) !important;
        }

        .text-warning {
            color: var(--warning-orange) !important;
        }

        .text-danger {
            color: var(--danger-red) !important;
        }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 50px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .empty-state p {
            margin: 0;
            font-size: 15px;
        }

        /* Responsive Design */
        @media screen and (max-width: 1200px) {
            .sidebar-container {
                transform: translateX(-100%);
            }

            .sidebar-container.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .video-background {
                left: 0;
            }

            .mobile-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .mobile-nav {
                display: flex;
                justify-content: space-around;
            }

            .content-wrapper {
                padding: 20px;
                padding-bottom: 100px;
            }
        }

        @media screen and (max-width: 768px) {
            .sidebar-container {
                width: 100%;
            }

            .mobile-toggle {
                top: 15px;
                right: 15px;
                width: 45px;
                height: 45px;
                font-size: 18px;
            }

            .content-wrapper {
                padding: 15px;
                padding-bottom: 100px;
            }

            .payment-header {
                flex-direction: column;
                gap: 20px;
                padding: 20px;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .header-icon {
                width: 60px;
                height: 60px;
                font-size: 26px;
            }

            .header-text h1 {
                font-size: 24px;
            }

            .status-badge {
                padding: 10px 20px;
            }

            .payment-grid {
                gap: 20px;
            }

            .glass-card .card-body {
                padding: 20px;
            }

            .summary-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .summary-value {
                font-size: 16px;
            }

            .summary-value.highlight,
            .summary-value.success {
                font-size: 20px;
            }

            .address-container {
                flex-direction: column;
            }

            .copy-btn {
                width: 100%;
            }

            .method-info {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .submit-btn {
                min-width: 100%;
                padding: 16px 20px;
                font-size: 15px;
            }

            .support-item {
                flex-direction: column;
                text-align: center;
                gap: 15px;
                padding: 15px;
            }

            .support-item i {
                width: auto;
            }

            .deposit-item {
                padding: 15px;
                gap: 15px;
            }

            .deposit-icon {
                width: 45px;
                height: 45px;
                font-size: 20px;
            }
        }

        @media screen and (max-width: 480px) {
            .content-wrapper {
                padding: 12px;
                padding-bottom: 90px;
            }

            .payment-header {
                padding: 15px;
            }

            .glass-card .card-header {
                padding: 15px;
            }

            .glass-card .card-body {
                padding: 15px;
            }
            
            .glass-card{
                max-width : 363px !important;
            }

            .submit-btn {
                padding: 14px;
                font-size: 14px;
                min-width: auto;
            }

            .mobile-nav {
                padding: 10px 0;
            }

            .mobile-nav .nav-link {
                font-size: 11px;
                padding: 6px 3px;
            }

            .mobile-nav .nav-link i {
                font-size: 18px;
            }
        }

        /* Loading Animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--dark-black);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.3s;
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255, 0, 0, 0.1);
            border-top: 4px solid var(--accent-red);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ========== Progress Bar ========== */
.progress-section {
    margin-bottom: 30px;
    animation: slideDown 0.5s ease;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.progress-bar-container {
    background: var(--gradient-card);
    border-radius: 15px;
    border: 1px solid var(--border-red);
    padding: 25px;
    box-shadow: var(--shadow-card);
    position: relative;
    overflow: hidden;
}

.progress-bar-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--deep-red) 0%, var(--accent-red) 100%);
    opacity: 0.3;
}

.progress-steps {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    flex: 1;
    min-width: 0;
}

.step::before {
    content: '';
    position: absolute;
    top: 16px;
    left: 57%;
    right: -43%;
    height: 2px;
    background: rgba(255, 255, 255, 0.1);
    z-index: -1;
}

.step:last-child::before {
    display: none;
}

.step.active::before {
    background: var(--gradient-red);
}

.step-number {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.05);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    font-weight: 700;
    font-size: 16px;
    margin-bottom: 10px;
    transition: var(--transition);
    position: relative;
    z-index: 2;
}

.step.active .step-number {
    background: var(--gradient-red);
    border-color: var(--light-red);
    color: white;
    box-shadow: 0 0 15px rgba(255, 0, 0, 0.5);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.5); }
    70% { box-shadow: 0 0 0 10px rgba(255, 0, 0, 0); }
    100% { box-shadow: 0 0 0 0 rgba(255, 0, 0, 0); }
}

.step.completed .step-number {
    background: var(--gradient-red);
    border-color: var(--light-red);
    color: white;
}

.step.completed .step-number::after {
    content: '✓';
    font-size: 18px;
}

.step-label {
    color: var(--text-muted);
    font-size: 14px;
    font-weight: 500;
    text-align: center;
    transition: var(--transition);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
}

.step.active .step-label {
    color: var(--text-white);
    text-shadow: 0 0 10px rgba(255, 0, 0, 0.3);
}

.progress-track {
    height: 6px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 15px;
}

.progress-fill {
    height: 100%;
    background: var(--gradient-red);
    border-radius: 3px;
    transition: width 0.5s ease;
    position: relative;
    overflow: hidden;
}

.progress-fill::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background: linear-gradient(90deg, 
        transparent, 
        rgba(255, 255, 255, 0.2), 
        transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.progress-text {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.current-step {
    color: var(--light-red);
    font-weight: 600;
    font-size: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.current-step::before {
    content: '';
    width: 10px;
    height: 10px;
    background: var(--gradient-red);
    border-radius: 50%;
    display: inline-block;
    animation: blink 1.5s infinite;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.step-title {
    color: var(--text-light);
    font-size: 15px;
    font-weight: 500;
}

/* Responsive Design for Progress Bar */
@media screen and (max-width: 768px) {
    .progress-bar-container {
        padding: 20px 15px;
    }
    
    .step-number {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }
    
    .step-label {
        font-size: 12px;
    }
    
    .progress-text {
        flex-direction: column;
        gap: 8px;
        text-align: center;
    }
    
    .step::before {
        top: 14px;
    }
}

@media screen and (max-width: 480px) {
    .progress-steps {
        margin-bottom: 15px;
    }
    
    .step-number {
        width: 32px;
        height: 32px;
        margin-bottom: 8px;
    }
    
    .step-label {
        font-size: 11px;
    }
    
    .progress-bar-container {
        padding: 15px 12px;
    }
    
      .step::before {
        top: 12px;
        right: -38%;
        left: 63%;
    }
}

    </style>
</head>
<body>
    <!-- Main Content -->
    <div class="main-content">
        <div class="progress-steps">
            <div class="step active" data-step="1">
                <div class="step-number">1</div>
                <div class="step-label">Deposit Details</div>
            </div>
            <div class="step active" data-step="2">
                <div class="step-number">2</div>
                <div class="step-label">Payment</div>
            </div>
            <div class="step" data-step="3">
                <div class="step-number">3</div>
                <div class="step-label">Confirmation</div>
            </div>
        </div>
        <div class="content-wrapper">
            <div class="payment-header">
                <div class="header-content">
                    <div class="header-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <div class="header-text">
                        <h1>BPE-20 Payment</h1>
                        <p>Complete your payment securely</p>
                    </div>
                </div>
                <div class="header-status">
                    <div class="status-badge">
                        <span class="status-dot"></span>
                        <span>Payment Pending</span>
                    </div>
                </div>
            </div>

            <div class="payment-grid">
                <!-- Left Column: Payment Details -->
                <div class="payment-details-section">
                    <!-- Payment Info Card -->
                    <div class="payment-info-card glass-card">
                        <div class="card-header">
                            <h3><i class="fas fa-receipt"></i> Payment Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="payment-summary">
                                <div class="summary-item">
                                    <div class="summary-label">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <span>Requested Amount</span>
                                    </div>
                                    <div class="summary-value highlight">
                                        {{ showAmount($data['amount']) }} {{ __($general->cur_text) }}
                                    </div>
                                </div>
                                <div class="summary-item">
                                    <div class="summary-label">
                                        <i class="fas fa-calculator"></i>
                                        <span>Payable Amount</span>
                                    </div>
                                    <div class="summary-value success">
                                        {{ showAmount($data['final_amo']) }} {{ $data['method_currency'] }}
                                    </div>
                                </div>
                                <div class="summary-item">
                                    <div class="summary-label">
                                        <i class="fas fa-exchange-alt"></i>
                                        <span>Exchange Rate</span>
                                    </div>
                                    <div class="summary-value">
                                        1 {{ __($general->cur_text) }} = {{ showAmount($data['rate']) }} {{ $data['method_currency'] }}
                                    </div>
                                </div>
                                <div class="summary-item">
                                    <div class="summary-label">
                                        <i class="fas fa-clock"></i>
                                        <span>Processing Time</span>
                                    </div>
                                    <div class="summary-value">
                                        10-30 Minutes
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    <div class="instructions-card glass-card">
                        <div class="card-header">
                            <h3><i class="fas fa-info-circle"></i> Payment Instructions</h3>
                        </div>
                        <div class="card-body">
                            <div class="instructions-content">
                                @php echo $data->gateway->description @endphp
                                
                                @if($data->gateway->crypto == 1)
                                <div class="crypto-address-box">
                                    <div class="address-header">
                                        <i class="fas fa-wallet"></i>
                                        <span>Wallet Address</span>
                                    </div>
                                    <div class="address-container">
                                        <input type="text" 
                                               id="cryptoAddress" 
                                               value="0x6db11e65d08ebc127164de142ae742ce4618c14c" 
                                               readonly
                                               class="address-input">
                                        <button type="button" 
                                                onclick="copyCryptoAddress()" 
                                                class="copy-btn">
                                            <i class="fas fa-copy"></i> Copy
                                        </button>
                                    </div>
                                    <div class="qrcode-container">
                                        <div class="qrcode-placeholder">
                                            <i class="fas fa-qrcode"></i>
                                            <span>Scan QR Code</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Payment Form -->
                <div class="payment-form-section">
                    <!-- Payment Form Card -->
                    <div class="payment-form-card glass-card">
                        <div class="card-header">
                            <h3><i class="fas fa-credit-card"></i> Complete Payment</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                                @csrf
                                
                                <!-- Payment Method Info -->
                                <div class="method-info">
                                    <div class="method-icon">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <div class="method-details">
                                        <h4>{{ $data->gateway->name }}</h4>
                                        <p>Manual Bank Transfer / Crypto Payment</p>
                                    </div>
                                </div>

                                <!-- Gateway Form Fields -->
                                <div class="form-fields">
                                    <x-viser-form identifier="id" identifierValue="{{ $gateway->form_id }}" />
                                </div>

                                <!-- Important Notes -->
                                <div class="important-notes">
                                    <div class="note-header">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <span>Important Notes</span>
                                    </div>
                                    <ul class="note-list">
                                        <li>Make payment to the exact amount shown above</li>
                                        <li>Include your Transaction ID in payment reference</li>
                                        <li>Screenshots must be clear and readable</li>
                                        <li>Payment verification takes 10-30 minutes</li>
                                    </ul>
                                </div>

                                <!-- Submit Button -->
                                <div class="submit-section">
                                    <button type="submit" class="submit-btn">
                                        <i class="fas fa-paper-plane"></i>
                                        <span>Confirm & Submit Payment</span>
                                    </button>
                                    <p class="help-text">
                                        <i class="fas fa-shield-alt"></i>
                                        Your payment is secured with 256-bit SSL encryption
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hide loading overlay
            setTimeout(() => {
                document.getElementById('loadingOverlay').style.opacity = '0';
                setTimeout(() => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                }, 300);
            }, 500);

            // Initialize toastr
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            const mainContent = document.querySelector('.main-content');

            function toggleSidebar() {
                sidebar.classList.toggle('active');
                const isActive = sidebar.classList.contains('active');
                
                // Update toggle icon
                sidebarToggle.innerHTML = isActive 
                    ? '<i class="fas fa-times"></i>' 
                    : '<i class="fas fa-bars"></i>';
                
                // Adjust video background position
                if (window.innerWidth <= 1200) {
                    videoBackground.style.left = isActive ? '100%' : '0';
                    mainContent.style.marginLeft = '0';
                }
            }

            sidebarToggle.addEventListener('click', toggleSidebar);

            // Handle dropdown toggles
            document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const parent = this.parentElement;
                    const isActive = parent.classList.contains('active');
                    
                    // Close other dropdowns on mobile
                    if (window.innerWidth <= 1200) {
                        document.querySelectorAll('.menu-item.active').forEach(item => {
                            if (item !== parent) {
                                item.classList.remove('active');
                            }
                        });
                    }
                    
                    parent.classList.toggle('active');
                });
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 1200 && 
                    !sidebar.contains(e.target) && 
                    !sidebarToggle.contains(e.target) &&
                    sidebar.classList.contains('active')) {
                    toggleSidebar();
                }
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.menu-item')) {
                    document.querySelectorAll('.menu-item.active').forEach(item => {
                        item.classList.remove('active');
                    });
                }
            });

            // Handle window resize
            function handleResize() {
                if (window.innerWidth > 1200) {
                    sidebar.classList.remove('active');
                    sidebarToggle.innerHTML = '<i class="fas fa-bars"></i>';
                    videoBackground.style.left = '280px';
                    mainContent.style.marginLeft = '280px';
                } else {
                    videoBackground.style.left = sidebar.classList.contains('active') ? '100%' : '0';
                    mainContent.style.marginLeft = '0';
                }
            }

            window.addEventListener('resize', handleResize);

            // Initialize active dropdowns
            function initActiveDropdowns() {
                document.querySelectorAll('.submenu-item.active').forEach(item => {
                    const parent = item.closest('.menu-item');
                    if (parent) {
                        parent.classList.add('active');
                    }
                });
            }

            initActiveDropdowns();

            // Form validation
            const paymentForm = document.getElementById('paymentForm');
            if (paymentForm) {
                paymentForm.addEventListener('submit', function(e) {
                    const requiredFields = this.querySelectorAll('[required]');
                    let isValid = true;
                    
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            field.style.borderColor = '#ff4444';
                            isValid = false;
                        } else {
                            field.style.borderColor = '';
                        }
                    });
                    
                    if (!isValid) {
                        e.preventDefault();
                        toastr.error('Please fill all required fields');
                    }
                });
            }
        });

        // Copy crypto address function
        function copyCryptoAddress() {
            const addressInput = document.getElementById('cryptoAddress');
            
            // Create temporary element for copy
            const tempInput = document.createElement('input');
            tempInput.value = addressInput.value;
            document.body.appendChild(tempInput);
            
            // Select and copy
            tempInput.select();
            tempInput.setSelectionRange(0, 99999);
            
            try {
                document.execCommand('copy');
                toastr.success('Address copied to clipboard!');
            } catch (err) {
                toastr.error('Failed to copy address');
            }
            
            // Clean up
            document.body.removeChild(tempInput);
            
            // Visual feedback
            addressInput.style.borderColor = '#00ff88';
            setTimeout(() => {
                addressInput.style.borderColor = '';
            }, 1000);
        }

        // Support functions
        function openLiveChat() {
            toastr.info('Live chat will open in a new window');
            // In a real application, this would open a chat widget
        }

        function showFAQ() {
            toastr.info('Opening FAQ page');
            // In a real application, this would open FAQ modal
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + B to toggle sidebar
            if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                e.preventDefault();
                document.getElementById('sidebarToggle').click();
            }
            
            // Escape to close sidebar on mobile
            if (e.key === 'Escape' && window.innerWidth <= 1200) {
                const sidebar = document.getElementById('sidebar');
                if (sidebar.classList.contains('active')) {
                    document.getElementById('sidebarToggle').click();
                }
            }
        });
    </script>
</body>
<style>
footer {
  display: none !important;
}
</style>
</html>
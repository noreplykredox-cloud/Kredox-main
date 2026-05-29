
<?php $__env->startSection('panel'); ?>
    <?php
        $policys = getContent('policy_pages.element', false, null, true);
    ?>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <nav class="nav">
        <a href="https://yukotrader.com/" class="nav__link">
            <i class="material-icons nav__icon">home</i>
            <span class="nav__text">Home</span>
        </a>
        <a href="https://yukotrader.com/about" class="nav__link nav__link">
            <i class="material-icons nav__icon">settings_accessibility</i>
            <span class="nav__text">About Us</span>
        </a>
        <a href="https://yukotrader.com/how-it-works" class="nav__link">
            <i class="material-icons nav__icon">receipt_long</i>
            <span class="nav__text">How it Works</span>
        </a>
        <a href="https://yukotrader.com/contact" class="nav__link">
            <i class="material-icons nav__icon">connect_without_contact</i>
            <span class="nav__text">Contact</span>
        </a>
        <a href="https://yukotrader.com/user/dashboard" class="nav__link">
            <i class="material-icons nav__icon">input</i>
            <span class="nav__text">Login/Signup</span>
        </a>
    </nav>

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background-color: #f4f4f9;
        }

        .nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 55px;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
            background: -webkit-linear-gradient(-90deg, #124656 0%, #063a4a 45%, #063b46 100%);
            display: flex;
            overflow-x: auto;
            z-index: 2;
        }

        .nav__link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
            min-width: 50px;
            overflow: hidden;
            white-space: nowrap;
            font-size: 13px;
            color: #e1d4d4;
            text-decoration: none;
            -webkit-tap-highlight-color: transparent;
            transition: background-color 0.1s ease-in-out;
        }

        .nav__link:hover {
            background-color: #eeeeee;
        }

        .nav__link--active {
            color: #009578;
        }

        .nav__icon {
            font-size: 21px;
        }

        @media screen and (min-width: 600px) {
            .nav {
                display: none;
            }
        }
        
    

.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-size: cover;
    background-image: url(https://t4.ftcdn.net/jpg/07/05/25/85/360_F_705258557_3L5bAIeNgPXvFGwvqQPhhy7LOnBLSBMr.jpg);
    background-repeat: no-repeat;
}

.login-box {
    padding: 2rem;
    border-radius: 33px;
    width: 100%;
    max-width: 900px;
    text-align: center;
    position: fixed;
    top: 0;
    overflow: auto;
    bottom: 0;
    background: radial-gradient(#685731, transparent);
    border: 1px solid #f1f1f1;
    backdrop-filter: url(https://t4.ftcdn.net/jpg/07/05/25/85/360_F_705258557_3L5bAIeNgPXvFGwvqQPhhy7LOnBLSBMr.jpg);
}

        .login-box h3 {
    margin-bottom: 3rem;
    color: #d7cfcf;
}
.login-box label {
    display: block;
    text-align: left;
    margin-bottom: 0.5rem;
    color: #e2d2ff;
}

.input-group:not(.has-validation)>.dropdown-toggle:nth-last-child(n+3), .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu) {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    height: 60px;
}

        .login-box input {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .login-box button {
            width: 100%;
            padding: 0.75rem;
            background-color: #009578;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .login-box button:hover {
            background-color: #007a5c;
        }

        .login-box a {
            color: #009578;
            text-decoration: none;
        }

        .login-box p {
            margin-top: 1rem;
            color: #666;
        }
    </style>

    <section class="login-container">
        
       <div class="login-box">
           <div class="top w-100 text-center">
                <a href="<?php echo e(route('home')); ?>" class="account-logo"><img
                        src="<?php echo e(getImage(getFilePath('logoIcon') . '/logo.png')); ?>" alt="<?php echo app('translator')->get('logo'); ?>"></a>
            </div>
           <h3><?php echo app('translator')->get('Create Your Account'); ?></h3>
             
               
            <div class="middle w-100">
                <form action="<?php echo e(route('user.register')); ?>" method="POST"
                    class="contact-form row mb--25 align-items-center verify-gcaptcha">
                    <?php echo csrf_field(); ?>
                    <?php if(session()->get('reference') != null): ?>
                        <div class="col-md-12">
                            <div class="contact-form-group">
                                <label><?php echo app('translator')->get('Reference By'); ?></label>
                                <input type="text" name="referBy" id="referenceBy"
                                    value="<?php echo e(session()->get('reference')); ?>" readonly>
                            </div>
                        </div>
                    <?php endif; ?>
                    

                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label><?php echo app('translator')->get('Username'); ?></label>
                            <input type="text" placeholder="<?php echo app('translator')->get('Username'); ?>" id="username" class="checkUser"
                                value="<?php echo e(old('username')); ?>" required name="username">
                                <small class="text--danger usernameExist"></small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label><?php echo app('translator')->get('Email Address'); ?></label>
                            <input type="email" placeholder="<?php echo app('translator')->get('Email Address'); ?>" id="email" class="checkUser"
                                value="<?php echo e(old('email')); ?>" required name="email">
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label><?php echo e(__('Country')); ?></label>
                            <div class="select-item">
                                <select name="country" id="country" class="select-bar">
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option data-mobile_code="<?php echo e($country->dial_code); ?>" value="<?php echo e($country->country); ?>"
                                            data-code="<?php echo e($key); ?>">
                                            <?php echo e(__($country->country)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label><?php echo app('translator')->get('Mobile'); ?></label>
                            <div class="input-group ">

                                <span class="input-group-text mobile-code">

                                </span>
                                <input type="hidden" name="mobile_code">
                                <input type="hidden" name="country_code">

                                <input type="number" name="mobile" id="mobile" value="<?php echo e(old('mobile')); ?>"
                                    class="form-control checkUser" placeholder="<?php echo app('translator')->get('Your Phone Number'); ?>">
                            </div>
                            <small class="text--danger mobileExist"></small>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label><?php echo app('translator')->get('Password'); ?></label>
                            <div class="form-group">
                                <input type="password" placeholder="<?php echo app('translator')->get('Enter Password'); ?>" id="password" required
                                    name="password">
                                <?php if($general->secure_password): ?>
                                    <div class="input-popup">
                                        <p class="error lower"><?php echo app('translator')->get('1 small letter minimum'); ?></p>
                                        <p class="error capital"><?php echo app('translator')->get('1 capital letter minimum'); ?></p>
                                        <p class="error number"><?php echo app('translator')->get('1 number minimum'); ?></p>
                                        <p class="error special"><?php echo app('translator')->get('1 special character minimum'); ?></p>
                                        <p class="error minimum"><?php echo app('translator')->get('6 character password'); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <label><?php echo app('translator')->get('Confirm Password'); ?></label>
                            <input type="password" placeholder="<?php echo app('translator')->get('Confirm Password'); ?>" id="password" required
                                name="password_confirmation">
                        </div>
                    </div>

                    <div class="col-md-12 captcha">
                        <?php if (isset($component)) { $__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243 = $component; } ?>
<?php $component = App\View\Components\Captcha::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('captcha'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Captcha::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243)): ?>
<?php $component = $__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243; ?>
<?php unset($__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243); ?>
<?php endif; ?>
                    </div>

                    <?php if($general->agree): ?>
                        <div class="col-md-12">
                            <div class="contact-form-group checkgroup">
                                <input type="checkbox" id="check" name="agree" required>
                                <label for="check"><?php echo app('translator')->get('I agree with'); ?>
                                    <?php $__currentLoopData = $policys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $policy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a class="text-theme"
                                            href="<?php echo e(route('policy.pages', [slug($policy->data_values->title), $policy->id])); ?>"><?php echo e(__($policy->data_values->title)); ?></a>
                                        <?php if(!$loop->last): ?>
                                            ,
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </label>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="col-md-6">
                        <div class="contact-form-group">
                            <button type="submit" class="mt-3"><?php echo app('translator')->get('Create Account'); ?></button>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <div class="contact-form-group">
                            <p class="text-white m-0"><?php echo app('translator')->get('Already have an account?'); ?> <a href="<?php echo e(route('user.login')); ?>"
                                    class="text-theme"><?php echo app('translator')->get('Sign In'); ?></a></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="bottom w-100 text-center">
                <p class="text-white">&copy; <?php echo app('translator')->get('All Right Reserved By'); ?> <a href="<?php echo e(route('home')); ?>"
                        class="text-theme"><?php echo e(__($general->site_name)); ?></a>
                 </p>
            </div>
       </div>
        </div>
    </section>

    <div class="modal fade custom--modal" id="existModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('You are with us'); ?></h5>
                    <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-white"><?php echo app('translator')->get('You already have an account please Sign in '); ?></p>
                </div>
                <div class="modal-footer">
                    <button href="javascript:void(0)" class="btn btn--danger" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                    <a href="<?php echo e(route('user.login')); ?>" class="custom-button theme btn-sm text-white"><?php echo app('translator')->get('Login'); ?></a>
                </div>
            </div>
    
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
    <style>
        .country-code .input-group-text {
            background: #fff !important;
        }

        .country-code select {
            border: none;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php if($general->secure_password): ?>
    <?php $__env->startPush('script-lib'); ?>
        <script src="<?php echo e(asset('assets/global/js/secure_password.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        (function($) {
            <?php if($mobileCode): ?>
                $(`option[data-code=<?php echo e($mobileCode); ?>]`).attr('selected', '');
            <?php endif; ?>
            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });
            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            $('.checkUser').on('focusout', function(e) {
                var url = '<?php echo e(route('user.checkUser')); ?>';
                var value = $(this).val();
                var token = '<?php echo e(csrf_token()); ?>';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/sptspl-trade/htdocs/trade.sptspl.com/public/core/resources/views/templates/basic/user/auth/register.blade.php ENDPATH**/ ?>
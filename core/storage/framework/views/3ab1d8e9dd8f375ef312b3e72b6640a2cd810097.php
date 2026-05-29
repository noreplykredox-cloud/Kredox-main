
<?php $__env->startSection('content'); ?>
    <?php
        $kycInfo = getContent('kyc_info.content', true);
        
    ?>
    
   

    <div class="dashboard-section padding-top padding-bottom">
        
     
     
             <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<nav class="nav">
  <a href="https://yukotrader.com/user/dashboard" class="nav__link">
    <i class="material-icons nav__icon">dashboard</i>
    <span class="nav__text">Dashboard</span>
  </a>
  <a href="<?php echo e(route('plan')); ?>" class="nav__link nav__link">
    <i class="material-icons nav__icon">travel_explore</i>
    <span class="nav__text">Plan</span>
  </a>
  <a href="https://yukotrader.com/user/deposit" class="nav__link">
    <i class="material-icons nav__icon">add_card</i>
    <span class="nav__text">Deposit</span>
  </a>
  <a href="https://yukotrader.com/user/withdraw" class="nav__link">
    <i class="material-icons nav__icon">request_quote</i>
    <span class="nav__text">Withdraw</span>
  </a>
  <a href="https://yukotrader.com/user/referral/users" class="nav__link">
    <i class="material-icons nav__icon">diversity_3</i>
    <span class="nav__text">My Team</span>
  </a>
   <a href="https://yukotrader.com/user/logout" class="nav__link">
    <i class="material-icons nav__icon">logout</i>
    <span class="nav__text">Logout</span>
  </a>
  
  
</nav>

        
  <style>
  body {
    margin: 0 0 55px 0;
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
    z-index:2;
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
    font-family: sans-serif;
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

  </style>
     
     
     
<!--
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<nav class="nav">
  <a href="https://yukotrader.com/user/dashboard" class="nav__link">
    <i class="material-icons nav__icon">dashboard</i>
    <span class="nav__text">Dashboard</span>
  </a>
  <a href="https://yukotrader.com/user/deposit" class="nav__link nav__link--active">
    <i class="material-icons nav__icon">person</i>
    <span class="nav__text">Profile</span>
  </a>
  <a href="#" class="nav__link">
    <i class="material-icons nav__icon">devices</i>
    <span class="nav__text">Devices</span>
  </a>
  <a href="#" class="nav__link">
    <i class="material-icons nav__icon">lock</i>
    <span class="nav__text">Privacy</span>
  </a>
  <a href="#" class="nav__link">
    <i class="material-icons nav__icon">settings</i>
    <span class="nav__text">Settings</span>
  </a>
</nav>

        
  <style>
  body {
    margin: 0 0 55px 0;
}

.nav {
    position: fixed;
    bottom: 0;
    width: 100%;
    height: 55px;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
    background-color: #ffffff;
    display: flex;
    overflow-x: auto;
    z-index:2;
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
    font-family: sans-serif;
    font-size: 13px;
    color: #444444;
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
    font-size: 18px;
}
@media screen and (min-width: 600px) {
  .nav__link {
  display: none;
  }
}

  </style>
 -->
  <!--
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<nav class="mobile-nav">
  <a href="#" class="bloc-icon">
    <i class="material-icons nav__icon">dashboard</i>
    <span class="nav__text">Dashboard</span>
  </a>
  <a href="#" class="bloc-icon">
    <i class="material-icons nav__icon">person</i>
    <span class="nav__text">Profile</span>
  </a>
  <a href="#" class="bloc-icon">
    <i class="material-icons nav__icon">devices</i>
    <span class="nav__text">Devices</span>
  </a>
  <a href="#" class="bloc-icon">
    <i class="material-icons nav__icon">lock</i>
    <span class="nav__text">Privacy</span>
  </a>
  <a href="#" class="bloc-icon">
    <i class="material-icons nav__icon">settings</i>
    <span class="nav__text">Settings</span>
  </a>
</nav>
     <style>
     .nav__icon {
    font-size: 18px;
}
     
     .mobile-nav {
  background: #F1F1F1;
  position: fixed;
  bottom: 0;
  height: 65px;
  width: 100%;
  display: flex;
  justify-content: space-around;
  z-index:99;
}

.bloc-icon {
  display: flex;
  justify-content: center;
  align-items: center;
}

.bloc-icon img {
  width: 30px;
}

@media screen and (min-width: 600px) {
  .mobile-nav {
  display: none;
  }
}









     </style>
        
        -->
        
        <div class="container">
            
            
            
      
        <section>
            
        <div class="video-background">
        <div class="video-foreground">
        <video autoplay muted loop id="myVideo">
        <source src="https://yukotrader.com/video.mp4" type="video/mp4">
        </video>
        </div>
        </div>
        </section>
<style>
    #myVideo {
  position: fixed;
  right: 0;
  bottom: 0;
  min-width: 100%;
  min-height: 100%;
  opacity: 5.70;
  filter: blur(0px);
}
</style>

 <h4 class="welcome-message">Welcome back, <span class="user-name"><?php echo e($user->firstname); ?> <?php echo e($user->lastname); ?></span> (<?php echo e($username); ?>)</h4>
<br>

<style>
.welcome-message {
    transform: matrix(1, 0, 0, 1, 0, 0);
    color: #FFFFFF;
    font-family: Arial, sans-serif;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    box-shadow: 0 0 0 1px #fff;
    background-image: url(https://t4.ftcdn.net/jpg/04/61/47/03/360_F_461470323_6TMQSkCCs9XQoTtyer8VCsFypxwRiDGU.jpg);
}

.user-name {
    transform: matrix(1, 0, 0, 1, 0, 0);
    color: #E74C3C;
    font-weight: bold;
}
</style>

<!--
  <h4 class="memory001">Welcome back, <span style="color: red;"><?php echo e($user->firstname); ?> <?php echo e($user->lastname); ?></span> (<?php echo e($username); ?>)</h4>
<br>


    <style>
 .memory001{
transform: matrix(1, 0, 0, 1, 0, 0);
    color: aliceblue;
}
}
    </style>
    -->

           <?php if(auth()->user()->kv == 0): ?>
                <div class="alert alert-info" role="alert">
                    <h5 class="alert-heading"><?php echo app('translator')->get('KYC Verification required'); ?></h5>
                    <hr>
                    <p class="mb-0"><?php echo e(__($kycInfo->data_values->verification_content)); ?> <a href="<?php echo e(route('user.kyc.form')); ?>"><?php echo app('translator')->get('Click Here to Verify'); ?></a></p>
                </div>
            <?php elseif(auth()->user()->kv == 2): ?>
                <div class="alert alert-warning" role="alert">
                    <h5 class="alert-heading"><?php echo app('translator')->get('KYC Verification pending'); ?></h5>
                    <hr>
                    <p class="mb-0"><?php echo e(__($kycInfo->data_values->pending_content)); ?> <a href="<?php echo e(route('user.kyc.data')); ?>"><?php echo app('translator')->get('See KYC Data'); ?></a></p>
                </div>
            <?php endif; ?>

            <div class="row justify-content-center mb-30-none"> 
                <div class="col-md-12">
                    <div class="input-group contact-form-group">
                        <input type="text" name="key" value="<?php echo e(route('home')); ?>?reference=<?php echo e($username); ?>"
                            class="form-control referralURL referral-input" readonly>
                        <button type="button" class="input-group-text copytext bg--base border--base text-white"
                            id="copyBoard"> <i class="fa fa-copy"></i> </button>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title"><?php echo app('translator')->get('Current Balance'); ?></h5>
                            <h4 class="amount"><?php echo e($general->cur_sym); ?><?php echo e(showAmount($balance)); ?></h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title"><?php echo app('translator')->get('Total Deposit'); ?></h5>
                            <h4 class="amount"><?php echo e($general->cur_sym); ?><?php echo e(showAmount($deposit)); ?></h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="far fa-credit-card"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title"><?php echo app('translator')->get('Total Withdraw'); ?></h5>
                            <h4 class="amount"><?php echo e($general->cur_sym); ?><?php echo e(showAmount($withdraw)); ?></h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-money-check-alt"></i>
                        </div>
                       <div class="dashboard-content totalammbr">
    <h5 class="title"><?php echo app('translator')->get('Total Team Business'); ?></h5>
    <?php
        $transactionsdataa = 0;

        // Function to get all referred users recursively up to a certain level
        function getAllReferredUsers($userIds, $level = 1, $maxLevel = 10) {
            if ($level > $maxLevel) return $userIds;

            $referredUsers = DB::table('users')->whereIn('ref_by', $userIds)->pluck('id')->toArray();

            if (empty($referredUsers)) return $userIds;

            $userIds = array_merge($userIds, getAllReferredUsers($referredUsers, $level + 1, $maxLevel));
            return $userIds;
        }

        // Get the initial list of referred users
        $initialUsers = DB::table('users')->where('ref_by', auth()->user()->id)->pluck('id')->toArray();

        if (!empty($initialUsers)) {
            // Get all referred users up to the 10th level
            $allReferredUsers = getAllReferredUsers($initialUsers);

            // Remove duplicate user IDs
            $uniqueUserIds = array_values(array_unique($allReferredUsers));

            // Calculate the total transaction amount
            $transactionsdataa = DB::table('transactions')
                ->where('remark', 'LIKE', '%plan_purchase%')
                ->whereIn('user_id', $uniqueUserIds)
                ->sum('amount');
        }
    ?>

    <h4 class="amount childaount">$<?php echo e(number_format($transactionsdataa, 2)); ?></h4>
    <style>
        .totalammbr .childaount {
            display: none;
        }
        .totalammbr .childaount:nth-child(2) {
            display: block;
        }
    </style>
</div>

                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title"><?php echo app('translator')->get('Direct Referral'); ?></h5>
                            

                            <?php  $trantiref = DB::table('transactions')->where('user_id', auth()->user()->id)->where('remark', 'Like', '%referral_commission%')->sum('amount'); ?>
                            <h4 class="amount">$<?php echo e(showAmount($trantiref)); ?></h4>
                      
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-item">
                        <div class="dashboard-thumb">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="dashboard-content">
                            <h5 class="title"><?php echo app('translator')->get('My Plan'); ?></h5>
                            

                            <?php  $trantipl = DB::table('transactions')->where('user_id', auth()->user()->id)->where('remark', 'Like', '%plan_purchase%')->sum('amount'); ?>
                            <h4 class="amount">$<?php echo e(showAmount($trantipl)); ?></h4>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mt-5">
                    <div class="card custom--card primary-bg">
                        <div class="card-header">
                            <h5 class="card-title"><?php echo app('translator')->get('Latest Trasactions'); ?></h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="deposite-table">
                                <thead class="custom--table">
                                    <tr>
                                        <th><?php echo app('translator')->get('Date'); ?></th>
                                        <th><?php echo app('translator')->get('TRX'); ?></th>
                                        <th><?php echo app('translator')->get('Amount'); ?></th>
                                        <th><?php echo app('translator')->get('Charge'); ?></th>
                                        <th><?php echo app('translator')->get('Post Balance'); ?></th>
                                        <th><?php echo app('translator')->get('Detail'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td>
                                                <?php echo e(showDateTime($trx->created_at)); ?>

                                                <br>
                                                <?php echo e(diffforhumans($trx->created_at)); ?>

                                            </td>
                                            <td>
                                                <?php echo e($trx->trx); ?>

                                            </td>
                                            <td class="budget">
                                                <strong
                                                    <?php if($trx->trx_type == '+'): ?> class="text--success" <?php else: ?> class="text--danger" <?php endif; ?>>
                                                    <?php echo e($trx->trx_type == '+' ? '+' : '-'); ?> <?php echo e(getAmount($trx->amount)); ?>

                                                    <?php echo e(__($general->cur_text)); ?>

                                                </strong>
                                            </td>
                                            <td class="budget">
                                                <?php echo e(__(__($general->cur_sym))); ?>

                                                <?php echo e(getAmount($trx->charge)); ?>

                                            </td>
                                            <td><?php echo e(getAmount($trx->post_balance)); ?>

                                                <?php echo e(__($general->cur_text)); ?>

                                            </td>
                                            <td><?php echo e(__($trx->details)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?php $__env->stopSection(); ?>



<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $('#copyBoard').click(function() {
                var copyText = document.getElementsByClassName("referralURL");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .copied::after {
            background-color: #<?php echo e($general->base_color); ?>;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/user/dashboard.blade.php ENDPATH**/ ?>

<header class="header-section">
    
    <div class="container">
        
        <div class="header-wrapper">
            <div class="logo">
                <a href="<?php echo e(route('home')); ?>">
                    <img src="<?php echo e(getImage(getFilePath('logoIcon') . '/logo.png')); ?>" alt="logo">
                </a>
            </div>
            
            <ul class="menu">
                <li>
                    <a href="<?php echo e(route('user.home')); ?>"><?php echo app('translator')->get('Dashboard'); ?></a>
                </li>

                <li class="menu-item-has-children">
                    <a href="javascript:void(0)"><?php echo app('translator')->get('Deposit'); ?></a>
                    <ul class="submenu">
                        <li>
                            <a href="<?php echo e(route('user.deposit.index')); ?>"><?php echo app('translator')->get('Deposit Money'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('user.deposit.history')); ?>"><?php echo app('translator')->get('Deposit History'); ?></a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item-has-children">
                    <a href="javascript:void(0)"><?php echo app('translator')->get('Withdraw'); ?></a>
                    <ul class="submenu">
                        <li>
                            <a href="<?php echo e(route('user.withdraw')); ?>"><?php echo app('translator')->get('Withdraw Money'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('user.withdraw.history')); ?>"><?php echo app('translator')->get('Withdraw History'); ?></a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="<?php echo e(route('plan')); ?>"><?php echo app('translator')->get('Plan'); ?></a>
                </li>
                
                <li>
                    <a href="<?php echo e(route('user.transactions')); ?>"><?php echo app('translator')->get('Transactions'); ?></a>
                </li>
                
                <li class="menu-item-has-children">
                    <a href="javascript:void(0)"><?php echo app('translator')->get('Referrals'); ?></a>
                    <ul class="submenu">
                        <li>
                            <a href="<?php echo e(route('user.referral.log')); ?>"><?php echo app('translator')->get('Referred Users'); ?></a>
                        </li>
                        <!--

                        <li>
                            <a href="<?php echo e(route('user.referral.commissions')); ?>"><?php echo app('translator')->get('Referrals Commissions'); ?></a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('user.level.commissions')); ?>"><?php echo app('translator')->get('Level Commissions'); ?></a>
                        </li>
                        -->
                    </ul>
                </li>

                <li class="menu-item-has-children">
                    <a href="javascript:void(0)">Account</a>
                    <ul class="submenu">
                        <li>
                            <a href="<?php echo e(route('user.profile.setting')); ?>"><?php echo app('translator')->get('Profile Setting'); ?></a>
                        </li>
                        <?php if($general->balance_transfer == 1): ?>
                            <!--
                            <li>
                                <a href="<?php echo e(route('user.balance.transfer')); ?>"><?php echo app('translator')->get('Balance Transfer'); ?></a>
                            </li>
                            -->
                        <?php endif; ?>

                        <?php if($general->epin_status == 1): ?>
                            <li>
                                <a href="<?php echo e(route('user.epin.recharge')); ?>"><?php echo app('translator')->get('E-Pin Recharge'); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('user.recharge.log')); ?>"><?php echo app('translator')->get('Recharge Log'); ?></a>
                            </li>
                        <?php endif; ?>

                        <li>
                            <a href="<?php echo e(route('user.change.password')); ?>"><?php echo app('translator')->get('Change Password'); ?></a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('ticket.index')); ?>"><?php echo app('translator')->get('Support Ticket'); ?></a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('user.twofactor')); ?>"><?php echo app('translator')->get('2FA Security'); ?></a>
                        </li>

                        <li>
                            <a href="<?php echo e(route('user.logout')); ?>"><?php echo app('translator')->get('Logout'); ?></a>
                        </li>
                    </ul>
                </li>
            </ul>
            
            

            <div class="header-bar ml-2 ml-md-4">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</header>
<?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/partials/user_header.blade.php ENDPATH**/ ?>
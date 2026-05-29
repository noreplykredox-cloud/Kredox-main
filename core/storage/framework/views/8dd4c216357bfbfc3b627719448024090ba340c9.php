<?php $__env->startSection('content'); ?>
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<nav class="nav">
  <a href="https://yukotrader.com/user/dashboard" class="nav__link">
    <i class="material-icons nav__icon">dashboard</i>
    <span class="nav__text">Dashboard</span>
  </a>
  <a href="https://yukotrader.com/subscribe/plan" class="nav__link nav__link">
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
     
    <div class="transaction-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center">

                <?php if(!request()->routeIs('user.recharge.log')): ?>
                    <div class="col-md-12">
                        <div class="show-filter mb-3 text-end">
                            <button type="button" class="btn btn--base showFilterBtn btn-sm"><i class="las la-filter"></i>
                                <?php echo app('translator')->get('Filter'); ?></button>
                        </div>
                        <div class="card responsive-filter-card mb-4 primary-bg">
                            <div class="card-body">
                                <form action="">
                                    <div class="d-flex flex-wrap gap-4">
                                        <div class="flex-grow-1 contact-form-group">
                                            <label><?php echo app('translator')->get('Transaction Number'); ?></label>
                                            <input type="text" name="search" value="<?php echo e(request()->search); ?>"
                                                class="form-control form--control">
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="contact-form-group">
                                                <label><?php echo app('translator')->get('Type'); ?></label>
                                                <div class="select-item">
                                                    <select name="trx_type" class="select-bar">
                                                        <option value=""><?php echo app('translator')->get('All'); ?></option>
                                                        <option value="+" <?php if(request()->trx_type == '+'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Plus'); ?>
                                                        </option>
                                                        <option value="-" <?php if(request()->trx_type == '-'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Minus'); ?>
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="contact-form-group">
                                                <label><?php echo app('translator')->get('Remark'); ?></label>
                                                <select class="select-bar" name="remark">
                                                    <option value=""><?php echo app('translator')->get('Any'); ?></option>
                                                    <?php $__currentLoopData = $remarks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $remark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($remark->remark); ?>" <?php if(request()->remark == $remark->remark): echo 'selected'; endif; ?>>
                                                            <?php echo e(__(keyToTitle($remark->remark))); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 align-self-end">
                                            <div class="contact-form-group">
                                                <button class="btn btn--base w-100"><i class="las la-filter"></i>
                                                    <?php echo app('translator')->get('Filter'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="primary-bg item-rounded">
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

                                <td>
                                    <strong
                                        <?php if($trx->trx_type == '+'): ?> class="text--success" <?php else: ?> class="text--danger" <?php endif; ?>>
                                        <?php echo e($trx->trx_type == '+' ? '+' : '-'); ?> <?php echo e(getAmount($trx->amount)); ?>

                                        <?php echo e(__($general->cur_text)); ?></strong>
                                </td>

                                <td>
                                    <?php echo e(getAmount($trx->charge)); ?> <?php echo e(__($general->cur_text)); ?>

                                </td>
                                <td>
                                    <?php echo e(getAmount($trx->post_balance)); ?> <?php echo e(__($general->cur_text)); ?></td>
                                <td class="text-end">
                                    <?php echo e(__($trx->details)); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php if($transactions->hasPages() ): ?>
                    <div class="py-3">
                        <?php echo e(paginateLinks($transactions)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/user/transactions.blade.php ENDPATH**/ ?>
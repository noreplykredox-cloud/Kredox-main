
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
            <div class="primary-bg item-rounded">
                <form action="">
                    <div class="d-flex justify-content-end pt-3 mx-3">
                        <div class="input-group contact-form-group w-50">
                            <input type="text" name="search" class="form-control" value="<?php echo e(request()->search); ?>" placeholder="<?php echo app('translator')->get('Search by transactions'); ?>">
                            <button class="input-group-text bg--base text-white">
                                <i class="las la-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="deposite-table">
                        <thead class="custom--table">
                            <tr>
                                <th><?php echo app('translator')->get('Gateway | Transaction'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('Initiated'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('Amount'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('Conversion'); ?></th>
                                <th class="text-center"><?php echo app('translator')->get('Status'); ?></th>
                                <th><?php echo app('translator')->get('Action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $__empty_1 = true; $__currentLoopData = $withdraws; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdraw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <span class="fw-bold"><span class="text-primary">
                                                <?php if(@$withdraw->method->name): ?>
                                                <?php echo e(__(@$withdraw->method->name)); ?>

                                            <?php else: ?>
                                                <?php echo app('translator')->get('E-pin'); ?>
                                            <?php endif; ?>

                                            </span></span>
                                        <br>
                                        <small><?php echo e($withdraw->trx); ?></small>
                                    </td>
                                    <td class="text-center">
                                        <?php echo e(showDateTime($withdraw->created_at)); ?> <br>
                                        <?php echo e(diffForHumans($withdraw->created_at)); ?>

                                    </td>
                                    <td class="text-center">
                                        <?php echo e(__($general->cur_sym)); ?><?php echo e(showAmount($withdraw->amount)); ?> - <span
                                            class="text--danger"
                                            title="<?php echo app('translator')->get('charge'); ?>"><?php echo e(showAmount($withdraw->charge)); ?> </span>
                                        <br>
                                        <strong title="<?php echo app('translator')->get('Amount after charge'); ?>">
                                            <?php echo e(showAmount($withdraw->amount - $withdraw->charge)); ?>

                                            <?php echo e(__($general->cur_text)); ?>

                                        </strong>

                                    </td>
                                    <td class="text-center">
                                        1 <?php echo e(__($general->cur_text)); ?> = <?php echo e(showAmount($withdraw->rate)); ?>

                                        <?php echo e(__($withdraw->currency)); ?>

                                        <br>
                                        <strong><?php echo e(showAmount($withdraw->final_amount)); ?>

                                            <?php echo e(__($withdraw->currency)); ?>

                                        </strong>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $withdraw->statusBadge ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm h-auto btn--primary <?php if($withdraw->withdraw_information): ?> detailBtn <?php else: ?> disabled <?php endif; ?>"
                                            data-user_data="<?php echo e(json_encode($withdraw->withdraw_information)); ?>"
                                            <?php if($withdraw->status == Status::PAYMENT_REJECT): ?> data-admin_feedback="<?php echo e($withdraw->admin_feedback); ?>" <?php endif; ?>>
                                            <i class="fa fa-desktop"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if($withdraws->hasPages()): ?>
                    <?php echo e(paginateLinks($withdraws)); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>



    
    <div id="detailModal" class="modal fade custom--modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Details'); ?></h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <ul class="list-group userData">

                    </ul>
                    <div class="feedback"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger btn-sm" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var userData = $(this).data('user_data');
                var html = `;
                userData.forEach(element => {
                    if (element.type != 'file') {
                        html += 
                        <li class="list-group-item d-flex justify-content-between align-items-center primary-bg text-white">
                            <span>${element.name}</span>
                            <span">${element.value}</span>
                        </li>;
                    }
                });
                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = 
                        <div class="my-3">
                            <strong><?php echo app('translator')->get('Admin Feedback'); ?></strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    ;
                } else {
                    var adminFeedback = '';
                }

                modal.find('.feedback').html(adminFeedback);

                modal.modal('show');
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make($activeTemplate . 'layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/templates/basic/user/withdraw/log.blade.php ENDPATH**/ ?>
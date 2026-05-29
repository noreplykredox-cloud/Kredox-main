<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-12">
            <div class="row gy-4">

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--19">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-money-bill-wave-alt"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white"><?php echo e($general->cur_sym); ?><?php echo e(showAmount($user->balance)); ?></h3>
                            <p class="text-white"><?php echo app('translator')->get('Balance'); ?></p>
                        </div>
                        <a href="<?php echo e(route('admin.report.transaction')); ?>?search=<?php echo e($user->username); ?>" class="widget-two__btn"><?php echo app('translator')->get('View All'); ?></a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->


                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--primary">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-wallet"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white"><?php echo e($general->cur_sym); ?><?php echo e(showAmount($totalDeposit)); ?></h3>
                            <p class="text-white"><?php echo app('translator')->get('Deposits'); ?></p>
                        </div>
                        <a href="<?php echo e(route('admin.deposit.list')); ?>?search=<?php echo e($user->username); ?>" class="widget-two__btn"><?php echo app('translator')->get('View All'); ?></a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--1">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white"><?php echo e($general->cur_sym); ?><?php echo e(showAmount($totalWithdrawals)); ?></h3>
                            <p class="text-white"><?php echo app('translator')->get('Withdrawals'); ?></p>
                        </div>
                        <a href="<?php echo e(route('admin.withdraw.log')); ?>?search=<?php echo e($user->username); ?>" class="widget-two__btn"><?php echo app('translator')->get('View All'); ?></a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--17">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-exchange-alt"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white"><?php echo e($totalTransaction); ?></h3>
                            <p class="text-white"><?php echo app('translator')->get('Transactions'); ?></p>
                        </div>
                        <a href="<?php echo e(route('admin.report.transaction')); ?>?search=<?php echo e($user->username); ?>" class="widget-two__btn"><?php echo app('translator')->get('View All'); ?></a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->


            </div>

            <div class="row gy-4 mt-2">

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--19">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-pager"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white"><?php echo e($general->cur_sym); ?><?php echo e(showAmount($totalReferralCommission)); ?></h3>
                            <p class="text-white"><?php echo app('translator')->get('Total Referral Commissions'); ?></p>
                        </div>
                        <a href="<?php echo e(route('admin.users.referral.commission',$user->id)); ?>" class="widget-two__btn"><?php echo app('translator')->get('View All'); ?></a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->


                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--primary">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-terminal"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white"><?php echo e($general->cur_sym); ?><?php echo e(showAmount($totalLevelCommission)); ?></h3>
                            <p class="text-white"><?php echo app('translator')->get('Total Level Commissions'); ?></p>
                        </div>
                        <a href="<?php echo e(route('admin.users.level.commission',$user->id)); ?>" class="widget-two__btn"><?php echo app('translator')->get('View All'); ?></a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--1">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-lock"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white"><?php echo e(__($totalPinGenerate)); ?></h3>
                            <p class="text-white"><?php echo app('translator')->get('Total Created Pin'); ?></p>
                        </div>
                        <a href="<?php echo e(route('admin.users.generate.pin',$user->id)); ?>" class="widget-two__btn"><?php echo app('translator')->get('View All'); ?></a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--17">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-lock-open"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white"><?php echo e(__($totalUsedPin)); ?></h3>
                            <p class="text-white"><?php echo app('translator')->get('Total Used Pin'); ?></p>
                        </div>
                        <a href="<?php echo e(route('admin.users.used.pin',$user->id)); ?>" class="widget-two__btn"><?php echo app('translator')->get('View All'); ?></a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->


            </div>

            <div class="d-flex flex-wrap gap-3 mt-4">
                <div class="flex-fill">
                    <button data-bs-toggle="modal" data-bs-target="#manualPaymentModal" class="btn btn--info btn--shadow w-100 btn-lg">
                        <i class="las la-hand-holding-usd"></i> <?php echo app('translator')->get('Manual Payment'); ?>
                    </button>
                </div>
                <div class="flex-fill">
                    <button data-bs-toggle="modal" data-bs-target="#addSubModal" class="btn btn--success btn--shadow w-100 btn-lg bal-btn" data-act="add">
                        <i class="las la-plus-circle"></i> <?php echo app('translator')->get('Balance'); ?>
                    </button>
                </div>

                <div class="flex-fill">
                    <button data-bs-toggle="modal" data-bs-target="#addSubModal" class="btn btn--danger btn--shadow w-100 btn-lg bal-btn" data-act="sub">
                        <i class="las la-minus-circle"></i> <?php echo app('translator')->get('Balance'); ?>
                    </button>
                </div>

                <div class="flex-fill">
                    <a href="<?php echo e(route('admin.report.login.history')); ?>?search=<?php echo e($user->username); ?>" class="btn btn--primary btn--shadow w-100 btn-lg">
                        <i class="las la-list-alt"></i><?php echo app('translator')->get('Logins'); ?>
                    </a>
                </div>

                <div class="flex-fill">
                    <a href="<?php echo e(route('admin.users.notification.log',$user->id)); ?>" class="btn btn--secondary btn--shadow w-100 btn-lg">
                        <i class="las la-bell"></i><?php echo app('translator')->get('Notifications'); ?>
                    </a>
                </div>

                <div class="flex-fill">
                    <a href="<?php echo e(route('admin.users.login',$user->id)); ?>" target="_blank" class="btn btn--primary btn--gradi btn--shadow w-100 btn-lg">
                        <i class="las la-sign-in-alt"></i><?php echo app('translator')->get('Login as User'); ?>
                    </a>
                </div>

                <?php if($user->kyc_data): ?>
                <div class="flex-fill">
                    <a href="<?php echo e(route('admin.users.kyc.details', $user->id)); ?>" target="_blank" class="btn btn--dark btn--shadow w-100 btn-lg">
                        <i class="las la-user-check"></i><?php echo app('translator')->get('KYC Data'); ?>
                    </a>
                </div>
                <?php endif; ?>

                <div class="flex-fill">
                    <?php if($user->status == Status::USER_ACTIVE): ?>
                    <button type="button" class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal">
                        <i class="las la-ban"></i><?php echo app('translator')->get('Ban User'); ?>
                    </button>
                    <?php else: ?>
                    <button type="button" class="btn btn--success btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal">
                        <i class="las la-undo"></i><?php echo app('translator')->get('Unban User'); ?>
                    </button>
                    <?php endif; ?>
                </div>
            </div>


            <div class="card mt-30">
                <div class="card-header">
                    <h5 class="card-title mb-0"><?php echo app('translator')->get('Information of'); ?> <?php echo e($user->fullname); ?></h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.users.update',[$user->id])); ?>" method="POST"
                          enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label><?php echo app('translator')->get('First Name'); ?></label>
                                    <input class="form-control" type="text" name="firstname" required value="<?php echo e($user->firstname); ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Last Name'); ?></label>
                                    <input class="form-control" type="text" name="lastname" required value="<?php echo e($user->lastname); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Email'); ?> </label>
                                    <input class="form-control" type="email" name="email" value="<?php echo e($user->email); ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Mobile Number'); ?> </label>
                                    <div class="input-group ">
                                        <span class="input-group-text mobile-code"></span>
                                        <input type="number" name="mobile" value="<?php echo e(old('mobile')); ?>" id="mobile" class="form-control checkUser" required>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label><?php echo app('translator')->get('Address'); ?></label>
                                    <input class="form-control" type="text" name="address" value="<?php echo e(@$user->address->address); ?>">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('City'); ?></label>
                                    <input class="form-control" type="text" name="city" value="<?php echo e(@$user->address->city); ?>">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label><?php echo app('translator')->get('State'); ?></label>
                                    <input class="form-control" type="text" name="state" value="<?php echo e(@$user->address->state); ?>">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label><?php echo app('translator')->get('Zip/Postal'); ?></label>
                                    <input class="form-control" type="text" name="zip" value="<?php echo e(@$user->address->zip); ?>">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group ">
                                    <label><?php echo app('translator')->get('Country'); ?></label>
                                    <select name="country" class="form-control">
                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option data-mobile_code="<?php echo e($country->dial_code); ?>" value="<?php echo e($key); ?>"><?php echo e(__($country->country)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group  col-xl-3 col-md-6 col-12">
                                <label><?php echo app('translator')->get('Email Verification'); ?></label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-bs-toggle="toggle" data-on="<?php echo app('translator')->get('Verified'); ?>" data-off="<?php echo app('translator')->get('Unverified'); ?>" name="ev"
                                       <?php if($user->ev): ?> checked <?php endif; ?>>

                            </div>

                            <div class="form-group  col-xl-3 col-md-6 col-12">
                                <label><?php echo app('translator')->get('Mobile Verification'); ?></label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-bs-toggle="toggle" data-on="<?php echo app('translator')->get('Verified'); ?>" data-off="<?php echo app('translator')->get('Unverified'); ?>" name="sv"
                                       <?php if($user->sv): ?> checked <?php endif; ?>>

                            </div>
                            <div class="form-group col-xl-3 col-md- col-12">
                                <label><?php echo app('translator')->get('2FA Verification'); ?> </label>
                                <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="<?php echo app('translator')->get('Enable'); ?>" data-off="<?php echo app('translator')->get('Disable'); ?>" name="ts" <?php if($user->ts): ?> checked <?php endif; ?>>
                            </div>
                            <div class="form-group col-xl-3 col-md- col-12">
                                <label><?php echo app('translator')->get('KYC'); ?> </label>
                                <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="<?php echo app('translator')->get('Verified'); ?>" data-off="<?php echo app('translator')->get('Unverified'); ?>" name="kv" <?php if($user->kv == 1): ?> checked <?php endif; ?>>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn--primary w-100 h-45"><?php echo app('translator')->get('Submit'); ?>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div id="manualPaymentModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title"><?php echo app('translator')->get('Manual Payments for'); ?> <?php echo e($user->username); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>

            <div class="modal-body">

                
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#paymentList" role="tab"><?php echo app('translator')->get('Payment List'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#newPayment" role="tab"><?php echo app('translator')->get('Add New'); ?></a>
                    </li>
                </ul>

                <div class="tab-content">
                    
                    <div class="tab-pane fade show active" id="paymentList" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th><?php echo app('translator')->get('Amount'); ?></th>
                                        <th><?php echo app('translator')->get('Description'); ?></th>
                                        <th><?php echo app('translator')->get('Start Time'); ?></th>
                                        <th><?php echo app('translator')->get('Frequency'); ?></th>
                                        <th><?php echo app('translator')->get('Status'); ?></th>
                                        <th><?php echo app('translator')->get('Action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $user->manualPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(showAmount($payment->amount)); ?></td>
                                            <td><?php echo e($payment->description); ?></td>
                                            <td><?php echo e(showDateTime($payment->start_time)); ?></td>
                                            <td><?php echo e(ucfirst($payment->frequency)); ?></td>
                                            <td>
                                                <?php if($payment->status === 'active'): ?>
                                                    <span class="badge bg-success"><?php echo app('translator')->get('Active'); ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger"><?php echo app('translator')->get('Inactive'); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn--primary editPaymentBtn"
                                                    data-id="<?php echo e($payment->id); ?>"
                                                    data-amount="<?php echo e($payment->amount); ?>"
                                                    data-description="<?php echo e($payment->description); ?>"
                                                    data-start_time="<?php echo e($payment->start_time); ?>"
                                                    data-frequency="<?php echo e($payment->frequency); ?>"
                                                    data-monthly_day="<?php echo e($payment->monthly_day); ?>">
                                                    <i class="las la-edit"></i>
                                                </button>

                                                <form action="<?php echo e(route('admin.users.manual.payment.toggle', $payment->id)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button class="btn btn-sm btn--info">
                                                        <i class="las la-sync-alt"></i>
                                                    </button>
                                                </form>

                                                <form action="<?php echo e(route('admin.users.manual.payment.delete', $payment->id)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button class="btn btn-sm btn--danger" onclick="return confirm('Are you sure?')">
                                                        <i class="las la-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($user->manualPayments->isEmpty()): ?>
                                        <tr><td colspan="6"><?php echo app('translator')->get('No Manual Payments found.'); ?></td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    
                    <div class="tab-pane fade" id="newPayment" role="tabpanel">
                        <form action="<?php echo e(route('admin.users.manual.payment', $user->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label><?php echo app('translator')->get('Amount'); ?></label>
                                    <input type="number" name="amount" class="form-control" required step="0.01" min="0">
                                </div>
                                <div class="form-group col-md-8">
                                    <label><?php echo app('translator')->get('Description'); ?></label>
                                    <textarea name="description" class="form-control" required></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label><?php echo app('translator')->get('Start Crediting Time'); ?></label>
                                    <input type="datetime-local" name="start_time" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label><?php echo app('translator')->get('Frequency'); ?></label>
                                    <select name="frequency" id="frequency" class="form-control" required>
                                        <option value="daily"><?php echo app('translator')->get('Daily'); ?></option>
                                        <option value="monthly"><?php echo app('translator')->get('Monthly'); ?></option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 d-none" id="dayOfMonthWrapper">
                                    <label><?php echo app('translator')->get('Day of Month (1–30)'); ?></label>
                                    <select name="monthly_day" class="form-control">
                                        <?php for($i = 1; $i <= 30; $i++): ?>
                                            <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-3 text-end">
                                <button type="submit" class="btn btn--primary"><?php echo app('translator')->get('Submit'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="editManualPaymentModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="POST" action="" id="editManualPaymentForm" class="modal-content">
            <?php echo csrf_field(); ?>
            <div class="modal-header">
                <h5 class="modal-title"><?php echo app('translator')->get('Edit Manual Payment'); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="modal-body row">
                <div class="form-group col-md-6">
                    <label><?php echo app('translator')->get('Amount'); ?></label>
                    <input type="number" name="amount" class="form-control" step="0.01" min="0" required>
                </div>
                <div class="form-group col-md-6">
                    <label><?php echo app('translator')->get('Start Time'); ?></label>
                    <input type="datetime-local" name="start_time" class="form-control" required>
                </div>
                <div class="form-group col-md-12">
                    <label><?php echo app('translator')->get('Description'); ?></label>
                    <textarea name="description" class="form-control" required></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label><?php echo app('translator')->get('Frequency'); ?></label>
                    <select name="frequency" class="form-control frequencySelect">
                        <option value="daily"><?php echo app('translator')->get('Daily'); ?></option>
                        <option value="monthly"><?php echo app('translator')->get('Monthly'); ?></option>
                    </select>
                </div>
                <div class="form-group col-md-6 d-none" id="editDayOfMonthWrapper">
                    <label><?php echo app('translator')->get('Day of Month'); ?></label>
                    <select name="monthly_day" class="form-control">
                        <?php for($i=1;$i<=30;$i++): ?>
                            <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn--primary w-100" type="submit"><?php echo app('translator')->get('Update'); ?></button>
            </div>
        </form>
    </div>
</div>
    
    
    <div id="addSubModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span><?php echo app('translator')->get('Balance'); ?></span></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.users.add.sub.balance',$user->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="act">
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Amount'); ?></label>
                            <div class="input-group">
                                <input type="number" step="any" name="amount" class="form-control" placeholder="<?php echo app('translator')->get('Please provide positive amount'); ?>" required>
                                <div class="input-group-text"><?php echo e(__($general->cur_text)); ?></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Remark'); ?></label>
                            <textarea class="form-control" placeholder="<?php echo app('translator')->get('Remark'); ?>" name="remark" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100"><?php echo app('translator')->get('Submit'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="userStatusModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <?php if($user->status == Status::USER_ACTIVE): ?>
                        <span><?php echo app('translator')->get('Ban User'); ?></span>
                        <?php else: ?>
                        <span><?php echo app('translator')->get('Unban User'); ?></span>
                        <?php endif; ?>
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.users.status',$user->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <?php if($user->status == Status::USER_ACTIVE): ?>
                        <h6 class="mb-2"><?php echo app('translator')->get('If you ban this user he/she won\'t able to access his/her dashboard.'); ?></h6>
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Reason'); ?></label>
                            <textarea class="form-control" name="reason" rows="4" required></textarea>
                        </div>
                        <?php else: ?>
                        <p><span><?php echo app('translator')->get('Ban reason was'); ?>:</span></p>
                        <p><?php echo e($user->ban_reason); ?></p>
                        <h4 class="text-center mt-3"><?php echo app('translator')->get('Are you sure to unban this user?'); ?></h4>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <?php if($user->status == Status::USER_ACTIVE): ?>
                        <button type="submit" class="btn btn--primary h-45 w-100"><?php echo app('translator')->get('Submit'); ?></button>
                        <?php else: ?>
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo app('translator')->get('Yes'); ?></button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
<script>
    (function($){
    "use strict"
        $('.bal-btn').click(function(){
            var act = $(this).data('act');
            $('#addSubModal').find('input[name=act]').val(act);
            if (act == 'add') {
                $('.type').text('Add');
            }else{
                $('.type').text('Subtract');
            }
        });
        let mobileElement = $('.mobile-code');
        $('select[name=country]').change(function(){
            mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
        });

        $('select[name=country]').val('<?php echo e(@$user->country_code); ?>');
        let dialCode        = $('select[name=country] :selected').data('mobile_code');
        let mobileNumber    = `<?php echo e($user->mobile); ?>`;
        mobileNumber        = mobileNumber.replace(dialCode,'');
        $('input[name=mobile]').val(mobileNumber);
        mobileElement.text(`+${dialCode}`);

    })(jQuery);
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const frequencySelect = document.getElementById("frequency");
        const dayWrapper = document.getElementById("dayOfMonthWrapper");

        frequencySelect.addEventListener("change", function () {
            if (this.value === "monthly") {
                dayWrapper.classList.remove("d-none");
            } else {
                dayWrapper.classList.add("d-none");
            }
        });

        // trigger on load
        frequencySelect.dispatchEvent(new Event('change'));
    });
</script>
<script>
    (function ($) {
        "use strict";

        $('.editPaymentBtn').click(function () {
            const modal = $('#editManualPaymentModal');
            const form = modal.find('form');
            const id = $(this).data('id');

            // Use Laravel route helper with placeholder
            const route = `<?php echo e(route('admin.users.manual.payment.update', ['id' => '__id__'])); ?>`.replace('__id__', id);

            form.attr('action', route);
            form.find('[name=amount]').val($(this).data('amount'));
            form.find('[name=description]').val($(this).data('description'));
            form.find('[name=start_time]').val($(this).data('start_time').slice(0, 16)); // format for datetime-local
            form.find('[name=frequency]').val($(this).data('frequency')).trigger('change');
            form.find('[name=monthly_day]').val($(this).data('monthly_day') || '');

            modal.modal('show');
        });

        // Toggle monthly day visibility
        $(document).on('change', '.frequencySelect', function () {
            const wrapper = $('#editDayOfMonthWrapper');
            if ($(this).val() === 'monthly') {
                wrapper.removeClass('d-none');
            } else {
                wrapper.addClass('d-none');
            }
        });
    })(jQuery);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\trade\core\resources\views/admin/users/detail.blade.php ENDPATH**/ ?>
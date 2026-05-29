

<?php $__env->startSection('panel'); ?>


<!--
    <?php if(@json_decode($general->system_info)->version > systemDetails()['version']): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">
                    <h3 class="card-title"> <?php echo app('translator')->get('New Version Available'); ?> <button class="btn btn--dark float-end"><?php echo app('translator')->get('Version'); ?> <?php echo e(json_decode($general->system_info)->version); ?></button> </h3>
                </div>
                <div class="card-body">
                    <h5 class="card-title text-dark"><?php echo app('translator')->get('What is the Update ?'); ?></h5>
                    <p><pre  class="f-size--24"><?php echo e(json_decode($general->system_info)->details); ?></pre></p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if(@json_decode($general->system_info)->message): ?>
    <div class="row">
        <?php $__currentLoopData = json_decode($general->system_info)->message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-12">
                <div class="alert border border--primary" role="alert">
                    <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
                    <p class="alert__message"><?php echo $msg; ?></p>
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
-->
    <div class="row gy-4">
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--primary has-link overflow-hidden box--shadow2">
                <a href="<?php echo e(route('admin.users.all')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                    <div class="col-4">
                        <i class="las la-users f-size--56"></i>
                    </div>
                    <div class="col-8 text-end">
                        <span class="text-white text--small"><?php echo app('translator')->get('Total Users'); ?></span>
                        <h2 class="text-white"><?php echo e($widget['total_users']); ?></h2>
                    </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--success has-link box--shadow2">
                <a href="<?php echo e(route('admin.users.active')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                    <div class="col-4">
                        <i class="las la-user-check f-size--56"></i>
                    </div>
                    <div class="col-8 text-end">
                        <span class="text-white text--small"><?php echo app('translator')->get('Active Users'); ?></span>
                        <h2 class="text-white"><?php echo e($widget['verified_users']); ?></h2>
                    </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--danger has-link box--shadow2">
                <a href="<?php echo e(route('admin.users.email.unverified')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                    <div class="col-4">
                        <i class="lar la-envelope f-size--56"></i>
                    </div>
                    <div class="col-8 text-end">
                        <span class="text-white text--small"><?php echo app('translator')->get('Email Unverified Users'); ?></span>
                        <h2 class="text-white"><?php echo e($widget['email_unverified_users']); ?></h2>
                    </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--red has-link box--shadow2">
                <a href="<?php echo e(route('admin.users.mobile.unverified')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                    <div class="col-4">
                        <i class="las la-comment-slash f-size--56"></i>
                    </div>
                    <div class="col-8 text-end">
                        <span class="text-white text--small"><?php echo app('translator')->get('Mobile Unverified Users'); ?></span>
                        <h2 class="text-white"><?php echo e($widget['mobile_unverified_users']); ?></h2>
                    </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->

    <div class="row gy-4 mt-2">
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="fas fa-hand-holding-usd overlay-icon text--success"></i>
                <div class="widget-two__icon b-radius--5 bg--success">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div class="widget-two__content">
                    <h3><?php echo e($general->cur_sym); ?><?php echo e(showAmount($deposit['total_deposit_amount'])); ?></h3>
                    <p><?php echo app('translator')->get('Total Deposited'); ?></p>
                </div>
                <a href="<?php echo e(route('admin.deposit.list')); ?>" class="widget-two__btn border border--success btn-outline--success"><?php echo app('translator')->get('View All'); ?></a>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="fas fa-spinner overlay-icon text--warning"></i>
                <div class="widget-two__icon b-radius--5 bg--warning">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="widget-two__content">
                    <h3><?php echo e($deposit['total_deposit_pending']); ?></h3>
                    <p><?php echo app('translator')->get('Pending Deposits'); ?></p>
                </div>
                <a href="<?php echo e(route('admin.deposit.pending')); ?>" class="widget-two__btn border border--warning btn-outline--warning"><?php echo app('translator')->get('View All'); ?></a>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="fas fa-ban overlay-icon text--danger"></i>
                <div class="widget-two__icon b-radius--5 bg--danger">
                    <i class="fas fa-ban"></i>
                </div>
                <div class="widget-two__content">
                    <h3><?php echo e($deposit['total_deposit_rejected']); ?></h3>
                    <p><?php echo app('translator')->get('Rejected Deposits'); ?></p>
                </div>
                <a href="<?php echo e(route('admin.deposit.rejected')); ?>" class="widget-two__btn border border--danger btn-outline--danger"><?php echo app('translator')->get('View All'); ?></a>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="fas fa-percentage overlay-icon text--primary"></i>
                <div class="widget-two__icon b-radius--5 bg--primary">
                    <i class="fas fa-percentage"></i>
                </div>
                <div class="widget-two__content">
                    <h3><?php echo e($general->cur_sym); ?><?php echo e(showAmount($deposit['total_deposit_charge'])); ?></h3>
                    <p><?php echo app('translator')->get('Deposited Charge'); ?></p>
                </div>
                <a href="<?php echo e(route('admin.deposit.list')); ?>" class="widget-two__btn border border--primary btn-outline--primary"><?php echo app('translator')->get('View All'); ?></a>
            </div>
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->

    <div class="row gy-4 mt-2">
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="lar la-credit-card overlay-icon text--success"></i>
                <div class="widget-two__icon b-radius--5 border border--success text--success">
                <i class="lar la-credit-card"></i>
                </div>
                <div class="widget-two__content">
                <h3><?php echo e($general->cur_sym); ?><?php echo e(showAmount($withdrawals['total_withdraw_amount'])); ?></h3>
                <p><?php echo app('translator')->get('Total Withdrawan'); ?></p>
                </div>
                <a href="<?php echo e(route('admin.withdraw.log')); ?>" class="widget-two__btn border border--success btn-outline--success"><?php echo app('translator')->get('View All'); ?></a>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="las la-sync overlay-icon text--warning"></i>
                <div class="widget-two__icon b-radius--5 border border--warning text--warning">
                <i class="las la-sync"></i>
                </div>
                <div class="widget-two__content">
                <h3><?php echo e($withdrawals['total_withdraw_pending']); ?></h3>
                <p><?php echo app('translator')->get('Pending Withdrawals'); ?></p>
                </div>
                <a href="<?php echo e(route('admin.withdraw.pending')); ?>" class="widget-two__btn border border--warning btn-outline--warning"><?php echo app('translator')->get('View All'); ?></a>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="las la-times-circle overlay-icon text--danger"></i>
                <div class="widget-two__icon b-radius--5 border border--danger text--danger">
                <i class="las la-times-circle"></i>
                </div>
                <div class="widget-two__content">
                <h3><?php echo e($withdrawals['total_withdraw_rejected']); ?></h3>
                <p><?php echo app('translator')->get('Rejected Withdrawals'); ?></p>
                </div>
                <a href="<?php echo e(route('admin.withdraw.rejected')); ?>" class="widget-two__btn border border--danger btn-outline--danger"><?php echo app('translator')->get('View All'); ?></a>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6">
            <div class="widget-two box--shadow2 b-radius--5 bg--white">
                <i class="las la-percent overlay-icon text--primary"></i>
                <div class="widget-two__icon b-radius--5 border border--primary text--primary">
                <i class="las la-percent"></i>
                </div>
                <div class="widget-two__content">
                <h3><?php echo e($general->cur_sym); ?><?php echo e(showAmount($withdrawals['total_withdraw_charge'])); ?></h3>
                <p><?php echo app('translator')->get('Withdrawal Charge'); ?></p>
                </div>
                <a href="<?php echo e(route('admin.withdraw.log')); ?>" class="widget-two__btn border border--primary btn-outline--primary"><?php echo app('translator')->get('View All'); ?></a>
            </div>
        </div>
    </div><!-- row end-->

    <div class="row gy-4 mt-2">
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--primary has-link overflow-hidden box--shadow2">
                <a href="<?php echo e(route('admin.plan.index')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                    <div class="col-4">
                        <i class="las la-paper-plane f-size--56"></i>
                    </div>
                    <div class="col-8 text-end">
                        <span class="text-white text--small"><?php echo app('translator')->get('Total Plans'); ?></span>
                        <h2 class="text-white"><?php echo e($widget['total_plans']); ?></h2>
                    </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--warning has-link box--shadow2">
                <a href="<?php echo e(route('admin.pin.index')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                    <div class="col-4">
                        <i class="las la-key f-size--56"></i>
                    </div>
                    <div class="col-8 text-end">
                        <span class="text-white text--small"><?php echo app('translator')->get('All Pins'); ?></span>
                        <h2 class="text-white"><?php echo e($widget['total_pins']); ?></h2>
                    </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--info has-link box--shadow2">
                <a href="<?php echo e(route('admin.report.commissions')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                    <div class="col-4">
                        <i class="las la-lock-open f-size--56"></i>
                    </div>
                    <div class="col-8 text-end">
                        <span class="text-white text--small"><?php echo app('translator')->get('Total Commissions'); ?></span>
                        <h2 class="text-white"><?php echo e($general->cur_sym); ?><?php echo e(showAmount($widget['total_commissions'])); ?></h2>
                    </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--success has-link box--shadow2">
                <a href="<?php echo e(route('admin.pin.used')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                    <div class="col-4">
                        <i class="lab la-key f-size--56"></i>
                    </div>
                    <div class="col-8 text-end">
                        <span class="text-white text--small"><?php echo app('translator')->get('Used Pins'); ?></span>
                        <h2 class="text-white"><?php echo e($widget['total_used_pins']); ?></h2>
                    </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->

    <div class="row mb-none-30 mt-30">
        <div class="col-xl-6 mb-30">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title"><?php echo app('translator')->get('Monthly Deposit & Withdraw Report'); ?> (<?php echo app('translator')->get('Last 12 Month'); ?>)</h5>
                <div id="apex-bar-chart"> </div>
              </div>
            </div>
          </div>
        <div class="col-xl-6 mb-30">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title"><?php echo app('translator')->get('Transactions Report'); ?> (<?php echo app('translator')->get('Last 30 Days'); ?>)</h5>
                <div id="apex-line"></div>
              </div>
            </div>
        </div>
    </div>

    <div class="row mb-none-30 mt-5">
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title"><?php echo app('translator')->get('Login By Browser'); ?> (<?php echo app('translator')->get('Last 30 days'); ?>)</h5>
                    <canvas id="userBrowserChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo app('translator')->get('Login By OS'); ?> (<?php echo app('translator')->get('Last 30 days'); ?>)</h5>
                    <canvas id="userOsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo app('translator')->get('Login By Country'); ?> (<?php echo app('translator')->get('Last 30 days'); ?>)</h5>
                    <canvas id="userCountryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

    <script src="<?php echo e(asset('assets/admin/js/vendor/apexcharts.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/js/vendor/chart.js.2.8.0.js')); ?>"></script>

    <script>
        "use strict";


        var options = {
            series: [{
                name: 'Total Deposit',
                data: [
                  <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e(getAmount(@$depositsMonth->where('months',$month)->first()->depositAmount)); ?>,
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                ]
            }, {
                name: 'Total Withdraw',
                data: [
                  <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e(getAmount(@$withdrawalMonth->where('months',$month)->first()->withdrawAmount)); ?>,
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                ]
            }],
            chart: {
                type: 'bar',
                height: 450,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: <?php echo json_encode($months, 15, 512) ?>,
            },
            yaxis: {
                title: {
                    text: "<?php echo e(__($general->cur_sym)); ?>",
                    style: {
                        color: '#7c97bb'
                    }
                }
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "<?php echo e(__($general->cur_sym)); ?>" + val + " "
                    }
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
        chart.render();



        var ctx = document.getElementById('userBrowserChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($chart['user_browser_counter']->keys(), 15, 512) ?>,
                datasets: [{
                    data: <?php echo e($chart['user_browser_counter']->flatten()); ?>,
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                maintainAspectRatio: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });



        var ctx = document.getElementById('userOsChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($chart['user_os_counter']->keys(), 15, 512) ?>,
                datasets: [{
                    data: <?php echo e($chart['user_os_counter']->flatten()); ?>,
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(0, 0, 0, 0.05)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            },
        });


        // Donut chart
        var ctx = document.getElementById('userCountryChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($chart['user_country_counter']->keys(), 15, 512) ?>,
                datasets: [{
                    data: <?php echo e($chart['user_country_counter']->flatten()); ?>,
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });

        // apex-line chart
        var options = {
        chart: {
            height: 450,
            type: "area",
            toolbar: {
            show: false
            },
            dropShadow: {
            enabled: true,
            enabledSeries: [0],
            top: -2,
            left: 0,
            blur: 10,
            opacity: 0.08
            },
            animations: {
            enabled: true,
            easing: 'linear',
            dynamicAnimation: {
                speed: 1000
            }
            },
        },
        dataLabels: {
            enabled: false
        },
        series: [
            {
            name: "Plus Transactions",
            data: [
                <?php $__currentLoopData = $trxReport['date']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trxDate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e(@$plusTrx->where('date',$trxDate)->first()->amount ?? 0); ?>,
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ]
            },
            {
            name: "Minus Transactions",
            data: [
                    <?php $__currentLoopData = $trxReport['date']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trxDate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e(@$minusTrx->where('date',$trxDate)->first()->amount ?? 0); ?>,
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                ]
            }
        ],
        fill: {
            type: "gradient",
            gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.9,
            stops: [0, 90, 100]
            }
        },
        xaxis: {
            categories: [
                <?php $__currentLoopData = $trxReport['date']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trxDate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    "<?php echo e($trxDate); ?>",
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ]
        },
        grid: {
            padding: {
            left: 5,
            right: 5
            },
            xaxis: {
            lines: {
                show: false
            }
            },
            yaxis: {
            lines: {
                show: false
            }
            },
        },
        };

        var chart = new ApexCharts(document.querySelector("#apex-line"), options);

        chart.render();


    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u171472567/domains/yukotrader.com/public_html/core/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>
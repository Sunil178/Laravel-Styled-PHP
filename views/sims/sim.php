<?php ob_start(); ?>
    <style>
        .card {
            padding: 3rem;
            font-size: large;
            font-family: sans-serif;
        }

        .container {
            width: 65%;
        }

        .row {
            padding-bottom: 1rem;
        }

        .copy {
            cursor: pointer;
        }

        .copied {
            opacity: 0;
        }

        .finish-section {
            display: none;
        }
    </style>
<?php $customStyle = ob_get_clean(); ?>

<?php ob_start(); ?>

    <div class="navbar-nav-left w-100">
        <ul class="navbar-nav align-items-center ms-auto">
            <li class="nav-item lh-1 me-10 fs-5">
                <strong>Balance:</strong>&nbsp;&nbsp;<span class="amount"><?php echo $balance; ?></span> ₽
            </li>
        </ul>
    </div>

<?php $customNavbar = ob_get_clean(); ?>

<?php ob_start(); ?>

<div class="card w-75">
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">#<?php echo $sim->order_id; ?></div>
            </div>
            <div class="row">
                <div class="col-6">Date</div>
                <div class="col-6 text-end sim_created_at"></div>
            </div>
            <div class="row">
                <div class="col-6">Campaign</div>
                <div class="col-6 text-end"><?php echo $sim->product_name; ?></div>
            </div>
            <div class="row">
                <div class="col-6">Operator</div>
                <div class="col-6 text-end"><?php echo $sim->operator_name; ?></div>
            </div>
            <div class="row">
                <div class="col-6">Price</div>
                <div class="col-6 text-end"><?php echo $sim->price; ?> ₽</div>
            </div>
            <div class="row">
                <div class="col-6">Number</div>
                <div class="col-6 text-end"><span class="text-info copied">Copied...</span><span class="copy fw-bold" data-copy="<?php echo $sim->phone; ?>"><?php echo $sim->phone; ?></span><i class='bx bxs-copy-alt ps-3 copy' data-copy="<?php echo $sim->phone; ?>"></i></div>
            </div>
            <div class="row">
                <div class="col-6">OTP</div>
                <div class="col-6 text-end"><span class="text-info copied">Copied...</span><span class="copy otp fw-bold" data-copy="<?php echo $sim->otp; ?>"><?php echo $sim->otp; ?></span><i class='bx bxs-copy-alt ps-3 copy otp-icon' data-copy="<?php echo $sim->otp; ?>"></i></div>
            </div>
            <div class="row">
                <div class="col-6">Status</div>
                <div class="col-6 text-end sim-status"><?php echo $sim->status; ?></div>
            </div>
            <?php if ($sim->status == 'RECEIVED') { ?>
                <div class="row text-center ban-cancel-section">
                    <div class="col-6"><a href="/sims/ban/<?php echo $sim->order_id; ?>" class="btn btn-info w-75">Ban</a></div>
                    <div class="col-6"><a href="/sims/cancel/<?php echo $sim->order_id; ?>" class="btn btn-info w-75">Cancel</a></div>
                </div>
                <div class="row finish-section">
                    <div class="col-12 text-center"><a href="/sims/finish/<?php echo $sim->order_id; ?>" class="btn btn-info w-75">Finish</a></div>
                </div>
            <?php } ?>
            <div class="row">
                <form method="POST" action="/sims/new" id="form">
                    <input type="hidden" name="product_id" value="<?php echo $sim->product_id; ?>">
                    <input type="hidden" name="operator_id" value="<?php echo $sim->operator_id; ?>">
                </form>
                <div class="col-12 text-center"><button class="btn btn-info w-75" onclick="document.getElementById('form').submit();">Repeat Order</button></div>
            </div>
            <?php if ($sim->status == 'RECEIVED') { ?>
                <div class="row progress-section">
                    <div class="col-12 text-center">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped active" role="progressbar"
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                20:00
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php $customSection = ob_get_clean(); ?>

<?php ob_start(); ?>

<script>
    const amount = $('.amount');
    const currency = parseFloat(amount.text().trim())
                        .toLocaleString('en-IN', {
                                style: 'currency',
                                currency: 'INR',
                            })
                            .replace('₹', '');
    amount.text(currency);

    $('.copy').on('click', function (event) {
        const data = $(this).data('copy').replace('+91', '');
        navigator.clipboard.writeText(data);
        $(this).parent().find('.copied').css({opacity: 1, visibility: "visible"}).animate({opacity: 0}, 1000);
    });

    const sim_created_at = new Date("<?php echo $sim->sim_created_at; ?>");
    $('.sim_created_at').text(sim_created_at.toLocaleString());

    <?php if ($sim->status == 'RECEIVED') { ?>
        var otp = "<?php echo $sim->otp; ?>";
        function getNumberOtp() {
            console.log("getNumberOtp()");
            $.ajax({
                url: "/sims/check/<?php echo $sim->order_id; ?>",
                success: function (response) {
                    console.log("Success", response);
                    response = JSON.parse(response);
                    if (response.status == 200 || response.status == 421) {
                        otp = response.data.otp;
                        $('.otp').data('copy', otp);
                        $('.otp-icon').data('copy', otp);
                        $('.otp').text(otp);
                        $('.progress-section').hide();
                        $('.sim-status').text(response.data.status);
                    }
                    if (response.status == 200) {
                        $('.ban-cancel-section').hide();
                        $('.finish-section').show();
                    }
                    else if (response.status == 421) {
                        $('.ban-cancel-section').hide();
                        $('.finish-section').hide();
                    }
                },
                error: function (response) {
                    console.log("Error", response);
                }
            });
        }

        function progress(timeleft, time_element, $element) {
            var progressBarWidth = timeleft * time_element;
            $element.animate({ width: progressBarWidth }, 500).html(Math.floor(timeleft % 3600 / 60) + " : " + Math.floor(timeleft % 3600 % 60));
            if (otp) {
                return;
            }
            if (timeleft % 2 == 0) {
                getNumberOtp();
            }
            if(timeleft > 0) {
                setTimeout(function() {
                    progress(timeleft - 1, time_element, $element);
                }, 1000);
            }
        };

        const expire_at = new Date("<?php echo $sim->expires_at; ?>");
        // expire_at.setHours(expire_at.getHours() + 5);
        // expire_at.setMinutes(expire_at.getMinutes() + 20);

        const current_date = new Date();

        var timeleft = Math.floor((expire_at - current_date) / 1000);

        if (timeleft < 0) {
            timeleft = 0;
        }
        const progress_bar = $('.progress-bar');
        const time_element = progress_bar.width() / 1200;
        progress(timeleft, time_element, progress_bar);
    <?php } ?>
</script>

<?php
    $customScript = ob_get_clean();
    include_once __DIR__."/../../layout/index.php";
?>

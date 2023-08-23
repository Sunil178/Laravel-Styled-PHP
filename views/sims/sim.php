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
    </style>
<?php $customStyle = ob_get_clean(); ?>

<?php ob_start(); ?>
    <div class="w-100"></div>
<?php $customNavbar = ob_get_clean(); ?>

<?php ob_start(); ?>

<!--  -->
    <div class="card w-75">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-6">Date</div>
                    <div class="col-6 text-end"><?php echo date('d M Y, h:i:s A', strtotime($sim->sim_created_at)); ?></div>
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
                    <div class="col-6 text-end"><span class="text-info copied">Copied...</span><span class="copy fw-bold"><?php echo $sim->phone; ?><i class='bx bxs-copy-alt ps-3'></i></span></div>
                </div>
                <div class="row">
                    <div class="col-6">OTP</div>
                    <div class="col-6 text-end"><span class="text-info copied">Copied...</span><span class="copy fw-bold"><?php echo $sim->otp; ?><i class='bx bxs-copy-alt ps-3'></i></span></div>
                </div>
                <div class="row">
                    <div class="col-6">Status</div>
                    <div class="col-6 text-end"><?php echo $sim->status; ?></div>
                </div>
                <div class="row text-center">
                    <div class="col-6"><a href="/sims/ban/<?php echo $sim->order_id; ?>" class="btn btn-info w-75">Ban</a></div>
                    <div class="col-6"><a href="/sims/cancel/<?php echo $sim->order_id; ?>" class="btn btn-info w-75">Cancel</a></div>
                </div>
                <div class="row">
                    <div class="col-12 text-center"><a href="/sims/finish/<?php echo $sim->order_id; ?>" class="btn btn-info w-75">Finish</a></div>
                </div>
                <div class="row">
                    <div class="col-12 text-center"><button class="btn btn-info w-75">Repeat Order</button></div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped active" role="progressbar"
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                100%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--  -->

<?php $customSection = ob_get_clean(); ?>

<?php ob_start(); ?>

<script>
    $('input[name="date"]').on('change', function (event) {
        window.location = "/sims/" + this.value;
    });

    $('.copy').on('click', function (event) {
        const phone = $(this).text().trim().substring(3);
        navigator.clipboard.writeText(phone);
        const copied = $(this).siblings();
        copied.css({opacity: 1, visibility: "visible"}).animate({opacity: 0}, 1000);
    });

    function progress(timeleft, timetotal, $element) {
        var progressBarWidth = timeleft * $element.width() / timetotal;
        $element.animate({ width: progressBarWidth }, 500).html(Math.floor(timeleft / 60) + " : " + (timeleft % 60));
        if(timeleft > 0) {
            setTimeout(function() {
                progress(timeleft - 1, timetotal, $element);
            }, 1000);
        }
    };

    const expires_at = "<?php echo $sim->expires_at; ?>";
    const expire_date = new Date(expires_at);
    expire_date.setHours(expire_date.getHours() + 5);
    expire_date.setMinutes(expire_date.getMinutes() + 20);

    const current_date = new Date();

    var timeleft = (expire_date - current_date) / 1000;

    // progress(1200, 1200, $('.progress-bar'));
    if (timeleft < 0) {
        timeleft = 0;
    }
    progress(timeleft, 1200, $('.progress-bar'));
</script>

<?php
    $customScript = ob_get_clean();
    include_once __DIR__."/../../layout/index.php";
?>

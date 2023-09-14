<?php ob_start(); ?>
<link rel="stylesheet" href="/assets/css/sim.css" />
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

<div class="cards">

    <div class="card p-5 w-75">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">#<?php echo $sim->order_id; ?></div>
                </div>
                <div class="row">
                    <div class="col-4">Date</div>
                    <div class="col-8 text-end date-time"><?php echo $sim->sim_created_at; ?></div>
                </div>
                <div class="row">
                    <div class="col-4">Campaign</div>
                    <div class="col-8 text-end"><?php echo $sim->product_name; ?></div>
                </div>
                <div class="row">
                    <div class="col-4">Operator</div>
                    <div class="col-8 text-end"><?php echo $sim->operator_name; ?></div>
                </div>
                <div class="row">
                    <div class="col-4">Price</div>
                    <div class="col-8 text-end"><?php echo $sim->price; ?> ₽</div>
                </div>
                <div class="row">
                    <div class="col-4">Number</div>
                    <div class="col-8 text-end"><span class="text-info copied">Copied...</span><span class="copy fw-bold" data-copy="<?php echo $sim->phone; ?>"><?php echo $sim->phone; ?></span><i class='bx bxs-copy-alt ps-3 copy' data-copy="<?php echo $sim->phone; ?>"></i></div>
                </div>
                <div class="row">
                    <div class="col-4">OTP</div>
                    <div class="col-8 text-end"><span class="text-info copied">Copied...</span><span class="copy otp fw-bold" data-copy="<?php echo $sim->otp; ?>"><?php echo $sim->otp; ?></span><i class='bx bxs-copy-alt ps-3 copy otp-icon' data-copy="<?php echo $sim->otp; ?>"></i></div>
                </div>
                <div class="row">
                    <div class="col-4">Status</div>
                    <div class="col-8 text-end sim-status"><?php echo $sim->status; ?></div>
                </div>
                <?php if ($sim->status == 'RECEIVED') { ?>
                    <div class="row text-center ban-cancel-section <?php echo $sim->otp ? 'hidden' : '' ?>">
                        <div class="col-4"><a href="/sims/ban/<?php echo $sim->order_id; ?>" class="btn btn-info w-75">Ban</a></div>
                        <div class="col-8"><a href="/sims/cancel/<?php echo $sim->order_id; ?>" class="btn btn-info w-75">Cancel</a></div>
                    </div>
                    <div class="row finish-section <?php echo $sim->otp ? '' : 'hidden' ?>">
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

    <div class="card w-50">
        <div class="card-body" id="sms-message-box">
            <?php if ($sim->sms) { ?>
                <?php $sim->sms = json_decode($sim->sms, true); ?>
                <?php foreach ($sim->sms as $sms) { ?>
                    <div class="sms">
                        <div>
                            <label>Code:</label>&nbsp;&nbsp;<em onClick="selectText(this);"><?php echo $sms['code']; ?></em>
                        </div>
                        <div>
                            <label>Message:</label>&nbsp;&nbsp;<em onClick="selectText(this);"><?php echo $sms['text']; ?></em>
                        </div>
                        <div>
                            <label>Sender:</label>&nbsp;&nbsp;<em onClick="selectText(this);"><?php echo $sms['sender']; ?></em>
                        </div>
                        <div>
                            <label>Time:</label>&nbsp;&nbsp;<em class="date-time"><?php echo $sms['date']; ?></em>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

</div>

<div id="snackbar">Copied...</div>

<?php $customSection = ob_get_clean(); ?>

<?php
    ob_start();
    include_once __DIR__."/script.php";
    $customScript = ob_get_clean();

    include_once __DIR__."/../../layout/index.php";
?>

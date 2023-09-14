<script>

    function smsTemplate(message) {
        return `
            <div class="sms">
                <div>
                    <label>Code:</label>&nbsp;&nbsp;<em onClick="selectText(this);">${message.code}</em>
                </div>
                <div>
                    <label>Message:</label>&nbsp;&nbsp;<em onClick="selectText(this);">${message.text}</em>
                </div>
                <div>
                    <label>Sender:</label>&nbsp;&nbsp;<em onClick="selectText(this);">${message.sender}</em>
                </div>
                <div>
                    <label>Time:</label>&nbsp;&nbsp;<em class="date-time">${message.date}</em>
                </div>
            </div>
            <hr>
        `;
    }

    function fixDateTime() {
        $('.date-time').each(function(index, element) {
            element.innerText = new Date(element.innerText).toLocaleString();            
        });
    }
    fixDateTime();

    function showToast() {
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 800);
    }

    const amount = $('.amount');
    const currency = parseFloat(amount.text().trim())
                        .toLocaleString('en-IN', {
                                style: 'currency',
                                currency: 'INR',
                            })
                            .replace('₹', '');
    amount.text(currency);

    $('.copy').on('click', function (event) {
        const data = $(this).data('copy').toString().replace('+91', '');
        navigator.clipboard.writeText(data);
        $(this).parent().find('.copied').css({opacity: 1, visibility: "visible"}).animate({opacity: 0}, 1000);
    });

    <?php if ($sim->status == 'RECEIVED') { ?>
        var otp = "<?php echo $sim->otp; ?>";
        function getNumberOtp() {
            $.ajax({
                url: "/sims/check/<?php echo $sim->order_id; ?>",
                success: function (response) {
                    // console.log("Success", response);
                    response = JSON.parse(response);
                    if (response.status == 200 || response.status == 421) {
                        if (!otp) {
                            otp = response.data.otp;
                            $('.otp').data('copy', otp);
                            $('.otp-icon').data('copy', otp);
                            $('.otp').text(otp);
                            $('.sim-status').text(response.data.status);

                            for (let message of response.data.sms) {
                                $('#sms-message-box').append( smsTemplate(message) );
                            }
                            fixDateTime();
                        }
                    }
                    if (response.status == 200) {
                        $('.ban-cancel-section').hide();
                        $('.finish-section').show();
                    }
                    else if (response.status == 421) {
                        $('.progress-section').hide();
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
            if (otp && otp == '0000') {
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

        if (timeleft <= 0) {
            timeleft = 0;
            $('.ban-cancel-section').hide();
            $('.finish-section').hide();
        }
        const progress_bar = $('.progress-bar');
        const time_element = progress_bar.width() / 1200;
        progress(timeleft, time_element, progress_bar);
    <?php } ?>

    function selectText(container) {
        if (document.selection) {
            var range = document.body.createTextRange();
            range.moveToElementText(container);
            range.select();
        } else if (window.getSelection) {
            var range = document.createRange();
            range.selectNode(container);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
        }
        document.execCommand("Copy");
        showToast();
    }
</script>

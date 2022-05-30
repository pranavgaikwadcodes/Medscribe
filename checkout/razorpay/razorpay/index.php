<?php

if(isset($_GET['amt']) && isset($_GET['name']) && isset($_GET['pid']))
{
    $docFees = $_GET['amt'];
    $name = $_GET['name'];
    
    $pid = $_GET['pid'];
}

?>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<style>
    .checkout{
        height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .checkout input {
        margin-top: 10px;
        font-size: 30px;
    }

</style>

<form>
    <div class="checkout">
        <input type="textbox" name="name" id="name" placeholder="Enter your name"
            value="<?php echo $name; ?>" />
        <input type="textbox" name="amt" id="amt" placeholder="Enter amt" disabled
            value="<?php echo $docFees;?>" />
        <input type="hidden" name="PID" id="PID" value="<?php echo $pid;?>" />
        <input type="button" name="btn" id="btn" class="btn btn-primary" value="Proceed to pay <?php echo $docFees?> /-"
            onclick="pay_now()" />
    </div>

</form>

<script>
function pay_now() {
    var name = jQuery('#name').val();
    var amt = jQuery('#amt').val();
    var pid = jQuery('#PID').val();

    jQuery.ajax({
        type: 'post',
        url: 'payment_process.php',
        data: "pid=" + pid,
        success: function(result) {
            var options = {
                "key": "rzp_test_vLy9KqIRm8dOlC",
                "amount": amt * 100,
                "currency": "INR",
                "name": "Medscribe",
                "description": "Pay Doctor",
                "image": "../../../images/Pic1.png",
                "handler": function(response) {
                    jQuery.ajax({
                        type: 'post',
                        url: 'payment_process.php',
                        data: "payment_id=" + response.razorpay_payment_id,
                        success: function(result) {
                            window.location.href = "../../../admin-panel.php";
                        }
                    });
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
        }
    });


}
</script>
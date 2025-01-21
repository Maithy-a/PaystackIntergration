<?php
session_start();
define('INCLUDE_CHECK', true);

include('includes/head.php');
include('includes/configs.php');
include('includes/db.php');
include('includes/quote.php');

// Check authentication
if (!isset($_SESSION['customer_id'])) {
    header("Location: index.php");
    exit();
}

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : "";
unset($_SESSION['success_message']);

$customer_id = $_SESSION['customer_id'];

// Fetch wallet balance and email
$query = "SELECT a.balance, c.email FROM Account a 
          JOIN customer c ON a.customer_id = c.customer_id 
          WHERE a.customer_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Database error: " . $conn->error);
}
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$stmt->bind_result($wallet_balance, $email);
$stmt->fetch();
$stmt->close();

$_SESSION['wallet_balance'] = $wallet_balance;
$currency = "KES";
$amount = 2000;
?>

<!DOCTYPE html>
<html lang="en">

<body>
<div class="page">
    <?php
    include('includes/nav.php');
    include('includes/sidebar.php');
    ?>
    <div class="page-wrapper">
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <div class="page-pretitle">Dashboard</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                <div class="quote mb-4">
                    <h3>Quote</h3>
                    <figcaption class="blockquote-footer">
                        <cite class="text-secondary">
                            <?php echo htmlspecialchars($money_quote); ?>
                        </cite>
                    </figcaption>
                </div>

                <form id="paymentForm" method="POST" action="">
                    <div class="container mt-4">
                        <div class="card">
                            <div class="card-body d-flex align-items-center">
                                <div class="me-4">
                                    <svg width="80px" height="80px" viewBox="0 0 24.00 24.00"
                                        xmlns="http://www.w3.org/2000/svg" fill="#000000" stroke="#000000"
                                        stroke-width="0.00024000000000000003">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0" transform="translate(0,0), scale(1)">
                                        </g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"
                                            stroke="#CCCCCC" stroke-width="0.096"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <defs>
                                                <style>
                                                    .cls-1 {
                                                        fill: #f7bf75;
                                                    }

                                                    .cls-2,
                                                    .cls-4 {
                                                        fill: #ffeabb;
                                                    }

                                                    .cls-3 {
                                                        fill: #f1734d;
                                                    }

                                                    .cls-4 {
                                                        fill-rule: evenodd;
                                                    }
                                                </style>
                                            </defs>
                                            <g id="Cart">
                                                <path class="cls-1"
                                                    d="M12,8.12A3.95,3.95,0,1,1,8,12.06,3.93,3.93,0,0,1,12,8.12">
                                                </path>
                                                <path class="cls-1"
                                                    d="M15.33,17.61l1.19,2.05A8.87,8.87,0,0,0,20.87,12H18.44v.06a6.5,6.5,0,0,1-3.11,5.55">
                                                </path>
                                                <path class="cls-2"
                                                    d="M12,3.11a8.89,8.89,0,1,0,4.54,16.55l-1.19-2.05A6.49,6.49,0,1,1,12,5.57H12V3.11Z">
                                                </path>
                                                <path class="cls-3"
                                                    d="M12,3.11V5.57A6.49,6.49,0,0,1,18.44,12h2.43A8.89,8.89,0,0,0,12,3.11">
                                                </path>
                                                <path class="cls-3"
                                                    d="M12,9a3.12,3.12,0,1,1-3.11,3.11A3.11,3.11,0,0,1,12,9"></path>
                                                <path class="cls-4"
                                                    d="M11.46,10.18v-.1a.5.5,0,0,1,.5-.5.5.5,0,0,1,.5.5v.1a1.51,1.51,0,0,1,.37.25,1.4,1.4,0,0,1,.26.39.5.5,0,0,1-.92.4.22.22,0,0,0-.05-.08.23.23,0,0,0-.16-.06.23.23,0,1,0,0,.45,1.23,1.23,0,0,1,.5,2.35V14a.5.5,0,0,1-.5.5.5.5,0,0,1-.5-.5v-.11a1.05,1.05,0,0,1-.37-.25,1.36,1.36,0,0,1-.27-.39.5.5,0,0,1,.93-.39.16.16,0,0,0,0,.07A.24.24,0,0,0,12,13h0a.23.23,0,0,0,0-.46,1.23,1.23,0,0,1-.5-2.35Z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <!-- Wallet Balance Info -->
                                <div>
                                    <div class="text-muted">Your wallet balance</div>
                                    <div class="h3 mb-0 text-purple">
                                        <span id="currency">KES</span>
                                        <span>
                                            <?php echo htmlspecialchars(number_format($_SESSION['wallet_balance'], 2), ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary w-100" id="addmoney" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                 Initiate Deposit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            <!-- Success Notification -->
            <?php if (!empty($success_message)): ?>
                <script>
                    new Notify({
                        status: 'success',
                        title: 'Login Successful',
                        text: '<?php echo htmlspecialchars($success_message); ?>',
                        effect: 'fade',
                        speed: 300,
                        autoclose: true,
                        autotimeout: 5000,
                        position: 'right top',
                    });
                </script>
            <?php endif; ?>

            <!-- Paystack Script -->
            <script type="text/javascript">
                const paymentForm = document.getElementById('paymentForm');
                paymentForm.addEventListener("submit", payWithPaystack, false);

                function payWithPaystack(e) {
                    e.preventDefault();

                    let handler = PaystackPop.setup({
                        key: '<?php echo $PublicKey; ?>',
                        email: '<?php echo $email; ?>',
                        amount: <?php echo $amount; ?> * 100,
                        currency: '<?php echo $currency; ?>',
                        ref: '' + Math.floor((Math.random() * 1000000000) + 1),

                        onClose: function () {
                            new Notify({
                                status: 'info',
                                title: 'Payment Cancelled',
                                text: 'Payment window was closed.',
                                effect: 'slide',
                                speed: 300,
                                autoclose: true,
                                autotimeout: 5000,
                                position: 'right top'
                            });
                        },

                        callback: function (response) {
                            let message = 'Payment completed successfully! Reference ID: ' + response.reference;

                            // Show success notification
                            new Notify({
                                status: 'success',
                                title: 'Payment Success',
                                text: message,
                                effect: 'slide',
                                speed: 300,
                                autoclose: true,
                                autotimeout: 5000,
                                position: 'right top'
                            });

                            // Redirect to server-side verification
                            window.location.href = "/verify_transaction.php?reference=" + response.reference;
                        }
                    });

                    handler.openIframe();
                }
            </script>
            <script src="https://js.paystack.co/v1/inline.js"></script>

            <?php include 'includes/footer.php'; ?>
        </div>
    </div>
</div>
</body>

</html>
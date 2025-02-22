<html>

<head>
  <?php include("includes/head.php"); ?>
</head>

</html>

<body class="d-flex flex-column" data-bs-theme="dark">
  <div class="page page-center">
    <div class="container container-tight py-4">
      <form class="card card-md" action="/forgot-password" method="POST" autocomplete="off" novalidate>
        <div class="card-body">

          <h2 class="card-title text-center mb-4">Forgot password</h2>

          <p class="text-secondary mb-4">Enter your email address and your password will be reset and emailed to you.
          </p>

          <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control" placeholder="Enter email">
          </div>

          <div class="form-footer">
            <a href="#" class="btn btn-primary w-100">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                <path d="M3 7l9 6l9 -6" />
              </svg>
              Reset password
            </a>

            <div class="text-center text-secondary mt-3">
              Forget it, <a href="./index">send me back</a> to the sign in screen.
            </div>

          </div>

        </div>

      </form>

    </div>
  </div>
</body>
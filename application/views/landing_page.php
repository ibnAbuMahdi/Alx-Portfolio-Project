<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Proma</title>


    <!-- Bootstrap core CSS -->

    
    <!-- Custom styles for this page -->
    <link href="<?php echo base_url(); ?>/assets/styles/heroes.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- custom scripts for this page -->
    <script src="<?php echo base_url(); ?>assets/scripts/jquery-3.6.0.js"></script>
    <script src="<?php echo base_url(); ?>assets/scripts/landing.js?version=23"></script>
  </head>
  <body>
    <div class="container my-5">
    <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg">
      <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
        <h1 class="display-4 fw-bold lh-1">proma</h1>
        <p class="lead">3x your productivity with proma. Track and manage the progress of your jobs. Keep all details of your tasks and jobs in one place.</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
          <a href="#sign-up" data-bs-toggle="modal" data-bs-target="#"><button type="button" class="btn btn-primary btn-lg px-4 me-md-2 fw-bold">Get started</button></a>
          <a href="<?php echo base_url(); ?>Proma/sign_in" class="btn btn-outline-secondary btn-lg px-4">Sign in </a>
        </div>
      </div>
      <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg">
          <img class="rounded-lg-3" src="<?php echo base_url(); ?>/assets/images/landing1.png" alt="" width="720">
      </div>
    </div>
    </div>

    <div class="b-example-divider"></div>

    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
      <div class="col-lg-7 text-center text-lg-start">
        <h1 class="display-4 fw-bold lh-1 mb-3">For the Multitasking Professional</h1>
        <p class="col-lg-10 fs-4">Never miss deadlines again. Reduce imperfections in your output. Automate progress tracking of repetitive jobs.</p>
      </div>
      <div class="col-md-10 mx-auto col-lg-5">
        <?php if ($this->session->flashdata('invalid email')){
          echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          Invalid email provided.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        } ?>
        
        <form id="sign-up" class="has-validation p-4 p-md-5 border rounded-3 bg-light" method="POST" enctype="multipart/form-data" action="<?php echo site_url("proma/create_user"); ?>">
          <div class="form-floating mb-3 has-validation">
            <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
            <label for="email">Email address</label>
          </div>
          <div class="form-floating mb-3 has-validation">
            <input type="password" class="form-control" name=password id="pword" placeholder="Password" required>
            <label for="pword">Password</label>
            <small>Password length must be atleast 6 characters long</small>
          </div>

          <div class="checkbox mb-3">
            <label>
              <input type="checkbox" value="remember-me"> Remember me
            </label>
          </div>
          <button class="w-100 btn btn-lg btn-primary" type="submit" id='send'>Sign up</button>
          <hr class="my-4">
          <small class="text-muted">By clicking Sign up, you agree to the terms of use.</small>
        </form>
      </div>
    </div>
    </div>

    <div class="b-example-divider"></div>
    
  <div class="bg-dark text-secondary px-4 py-5 text-center">
    <div class="py-5">
      <h1 class="display-5 fw-bold text-white">About</h1>
      <div class="col-lg-6 mx-auto">
        <p class="fs-5 mb-4"> A lot of self employed professionals I came accross like freelancers, local fashion designers, consultants, find it difficult to manage their jobs and clients. This is designed to solved that problem for them. It is also a portfolio project for the <a href="https://www.alxafrica.com/software-engineering/">Alx SE</a> software engineering program </p>
      </div>
    </div>
    <?php $this->load->view("sidelinks/footer"); ?>
  </div>


<script> 
    let Settings = {base_url: '<?= site_url() ?>'};
</script>
</body>
</html>
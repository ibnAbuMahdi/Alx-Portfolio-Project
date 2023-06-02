
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
    <link href="<?php echo base_url(); ?>assets/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>assets/styles/navbar-top-fixed.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/styles/header.css?version=43" rel="stylesheet">
    
    <!-- scripts -->
    <script src="<?php echo base_url(); ?>assets/scripts/jquery-3.6.0.js"></script>
    <?php $this->load->view("header_script"); ?>


  </head>
  <body>
    
  <?php $this->load->view("sidelinks/header"); ?>

<main class="container">
  <div class="bg-light p-5 rounded">
    <h1 id=templates>My Templates</h1>
    
    <section>
      <div class="row gy-4">
        <div class=col-6>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Template title</h5>
              <p class="card-text">Some description of the job template that tells what the job is about</p>
              <a href="#" class="btn btn-primary">Create job</a>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Task1 title</li>
              <li class="list-group-item">Task2 title</li>
              <li class="list-group-item">Task3 title</li>
            </ul>
            <div class="card-footer text-muted">
              2 weeks (duration)
            </div>
          </div>
        </div>
        <div class=col-6>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Template title</h5>
              <p class="card-text">Some description of the job template that tells what the job is about</p>
              <a href="#" class="btn btn-primary">Create job</a>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Task1 title</li>
              <li class="list-group-item">Task2 title</li>
              <li class="list-group-item">Task3 title</li>
            </ul>
            <div class="card-footer text-muted">
              2 weeks (duration)
            </div>
          </div>
        </div>
      </div>
    </section>
</main>


    <script src="<?php echo base_url(); ?>/assets/dist/js/bootstrap.bundle.min.js"></script>

      
  </body>
</html>

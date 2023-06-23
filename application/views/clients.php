
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
    <h1 id=clients>My Clients</h1>
    
  <div class="w-100 align-items-center justify-content-between flex-wrap">
      <div class="row gy-4">
        <?php if (count($clients)){ foreach ($clients as $row){ ?>
          <div class="col-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title"><?php echo $row->fullname; ?></h5>
                <p class="card-text"><?php echo $row->notes; ?></p>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><?php echo $row->phone; ?></li>
                <li class="list-group-item"><?php echo $row->email; ?></li>
              </ul>
              <div class="card-footer d-flex justify-content-between">
                <a href="<?php echo base_url('proma/client_jobs/'.$row->id); ?>" class="card-link">Jobs</a>
                <a href="<?php echo base_url('proma/delete_client/'.$row->id); ?>" class="card-link btn btn-danger">Delete</a>
              </div>
            </div>
        </div>
        <?php }} else { ?>
          <div class=col-6 >
          <div class="card" >
            <div class="card-body">
              <h5 class="card-title">No clients</h5>
              <a href="" data-bs-toggle="modal" data-bs-target="#clientModal" class="btn btn-primary">Add a client</a>
            </div>
          </div>
        </div>
        <?php } ?>
    </div> 
  </div>

</main>


    <script src="<?php echo base_url(); ?>/assets/dist/js/bootstrap.bundle.min.js"></script>

      
  </body>
</html>

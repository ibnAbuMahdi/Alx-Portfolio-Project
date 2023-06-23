
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
    <!-- <link href="<?php echo base_url(); ?>assets/scripts/header_script.php" rel="preload"> -->
    <?php $this->load->view("header_script"); ?>


  </head>
  <body>
    
  <?php $this->load->view("sidelinks/header"); ?>

<main class="container">
  <div class="bg-light p-5 rounded">
    <h1 id=templates>My Templates</h1>
    
    <section>
      <div class="row gy-4">
        <?php if(count($temps)){
          foreach ($temps as $id=>$temp) { ?>
        <div class=col-6>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><?php echo $temp['title']; ?></h5>
              <p class="card-text"><?php echo $temp['notes']; ?></p>
              <a href="<?php echo base_url('proma/create_job/'.$id); ?>" class="btn btn-primary">Create job</a>
            </div>
            <ul class="list-group list-group-flush">
              <?php foreach ($temp['tasks'] as $title) { ?>
              <li class="list-group-item"><?php echo $title->title ?></li>
              <?php } ?>
            </ul>
            <div class="card-footer text-muted d-flex justify-content-between">
              <a href='#'><?php echo $temp['file'] ?></a>
              <a href="<?php echo base_url('proma/delete_template/'.$id); ?>" class="card-link btn btn-danger">Delete</a>
            </div>
          </div>
        </div>
        <?php }} else { ?>
          <div class=col-6 >
          <div class="card" >
            <div class="card-body">
              <h5 class="card-title">No templates</h5>
              <a href="" data-bs-toggle="modal" data-bs-target="#templateModal" class="btn btn-primary">Add job template</a>
            </div>
          </div>
        </div>
        <?php } ?>
        
      </div>
    </section>
</main>


    <script src="<?php echo base_url(); ?>/assets/dist/js/bootstrap.bundle.min.js"></script>

      
  </body>
</html>

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
    <link href="<?php echo base_url(); ?>assets/styles/navbar-top-fixed.css?version=22" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/styles/header.css?version=43" rel="stylesheet">

    <!-- scripts -->
    <script src="<?php echo base_url(); ?>assets/scripts/jquery-3.6.0.js"></script>
    <?php $this->load->view("header_script"); ?>
    <script src="<?php echo base_url(); ?>assets/scripts/jobs.js"></script>
  </head>
  <body>
      <?php $this->load->view("sidelinks/header"); ?>
    
      <main class="container">
  <div class="bg-light p-5 rounded">
    <h1 id=clients><?= $name->fullname ?> Jobs</h1>
    
      <div class="btn-group w-100 align-items-center justify-content-between flex-wrap py-4">
        <div class="dropdown">
          <button class="btn btn-secondary btn-success dropdown-toggle" type="button" id="dropdownMenuButtonSM" data-bs-toggle="dropdown" aria-expanded="false">
            Completed
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonSM" id="completed">
            <li>
              <form class="p-2 mb-2 bg-light border-bottom">
                <input type="search" class="form-control" autocomplete="false" placeholder="Search titles" id="f_c">
              </form>
            </li>
          </ul>
        </div>
        <div class="dropdown">
          <button class="btn btn-secondary btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            Ongoing
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" id=ongoing>
            <li>
              <form class="p-2 mb-2 bg-light border-bottom">
                <input type="search" class="form-control" autocomplete="false" placeholder="Search titles" id="f_on">
              </form>
            </li>
          </ul>
        </div>
        <div class="dropdown">
          <button class="btn btn-secondary btn-danger dropdown-toggle" type="button" id="dropdownMenuButtonLG" data-bs-toggle="dropdown" aria-expanded="false">
            Overdue
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonLG" id="overdue">
            <li>
              <form class="p-2 mb-2 bg-light border-bottom">
                <input type="search" class="form-control" autocomplete="false" placeholder="Search titles" id="f_ov">
              </form>
            </li>
          </ul>
        </div>
      </div>
      <div class=row>
      </div>
      <section>
        <div class="row gy-4">
          <?php foreach($jobs as $job) { ?>
            <div class=col-6 >
            <div id = "<?php echo $job->id; ?>" class="card job-card" >
              <div id="card-header" val="<?php echo $job->clientId; ?>" class="card-header">
                <div class=row>
                  <div class=col-6 id="client"></div>
                  <div id="end-date" class="col-6"></div>                
                </div>
              </div>
              <div id="status" status=<?php echo $job->status; ?> class="card-body">
                <h5 class="card-title"><?php echo $job->title; ?></h5>
                <p class="card-text"><?php echo $job->notes; ?></p>
                <a href="<?php echo site_url('proma/get_job/'.$job->id); ?>" class="btn btn-primary">View job</a>
              </div>
              <div class="progress mb-3">
                <div class="progress-bar text-dark" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
              </div>
            </div>
          </div>
         <?php } ?>
          
        </div>
      </section>        
    </div>

  
  </main>
    <script src="<?php echo base_url(); ?>/assets/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      let Settings = {base_url: '<?= site_url() ?>'};
    </script>  
  </body>
</html>

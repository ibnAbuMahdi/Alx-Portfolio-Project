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
    <?php $i = 1; $this->load->view("new_job_script"); ?>
    <script src="<?php echo base_url(); ?>assets/scripts/jobs.js"></script>
  </head>
  <body>
    <?php $this->load->view("sidelinks/header"); ?>
    <main class="container">
      <div class="bg-light p-5 rounded">
        <h1 id=templates>Create Job</h1>
        <form>
          <div class="mb-3">
            <input type="text" class="form-control" id="job-title" value="<?php echo $temp[0]->title; ?>" required>
            <div class="valid-feedback">
              Please provide a valid name
            </div>
          </div>
          
          <div class="input-group">
            <span class="input-group-text">Description</span>
            <textarea class="form-control" id="job-desc" aria-label="description" value="<?php echo $temp[0]->notes; ?>"><?php echo $temp[0]->notes; ?></textarea>
          </div>
          <br>
          <div class="input-group mb-3">
            <span class="input-group-text">File</span>
            <input type="text" class="form-control" value="<?php echo $temp[0]->file; ?>" id="job-filename" disabled>
            <span class="btn btn-primary input-group-text" id="change_job_file"><?php if (isset($temp[0]->file)) {echo 'Change';} else {echo 'Add';} ?></span>
          </div>
          <select id="client" class="form-control form-select w-50">
            <option selected disabled>Attach client</option>
            <?php foreach($clients as $cl) { ?>
              <option id=<?php echo $cl->id; ?>><?php echo $cl->fullname; ?></option>
            <?php } ?>
          </select>
          <br>
          <div class="min-vh-100 d-flex flex-column align-items-center justify-content-center">
            <h2>Tasks</h2>
            <div class="card mb-6">
            <?php foreach ($tasks as $task) { ?>
              <div class="card-header">
                <h4 id=<?php echo $task->id; ?>> Task <?php echo $i; ?></h4>
              </div>
              <div class="card-body" id="card-body">
                <div class=task>
                <div class="mb-3">
                  <input type="text" class="form-control" id="task-title" placeholder="Task title" required value="<?php echo $task->title; ?>">
                  <div class="valid-feedback">
                    Please provide a valid title
                  </div>
                </div>
                <div class="input-group mb-3" id="dur-group">
                  <input type="number" class="form-control" id="task-duration" placeholder="Duration" required value="<?php echo $task->duration; ?>">
                  <select id="duration-unit" class="form-control form-select" required value="<?php echo $task->unit; ?>">
                    <option>Hours</option>
                    <option>Days</option>
                    <option>Weeks</option>
                    <option>Years</option>
                  </select>
                  <!-- <span class="btn btn-primary input-group-text" id="addLong">Change</span> -->
                </div>
                <div class="input-group">
                  <span class="input-group-text">Task description</span>
                  <textarea class="form-control" id="task-desc"><?php echo $task->notes; ?></textarea>
                </div>
                <br>
                <div class="input-group mb-3">
                  <span class="input-group-text">File</span>
                  <input type="text" class="form-control" value="<?php echo $task->file; ?>" id="task-file" disabled>
                  <span class="btn btn-primary input-group-text change_task_file" id="change_task_file"><?php if (isset($task->file)) {echo 'Change';} else {echo 'Add';} ?></span>
                </div>
                <div class="input-group mb-3" id=sdate>
                  <span class=" input-group-text" id="">Start date</span>
                  <input type="date" class="form-control task-sdate" placeholder="Start date" id="task-sdate">
                </div>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="">End date</span>
                  <input type="date" class="form-control task-edate" placeholder="End date" id="task-edate" disabled>
                </div>
                 <ul id="selected_deps"></ul>
                <select class="form-control form-select deps">
                  <option disabled selected>Select dependencies</option>
                </select>
                <hr>
                <h5>Task <?php echo $i; ?> input</h5>
                <ul id=t_texts><?php $txts = explode('<>', $task->texts); foreach($txts as $txt){ ?>
                  <li><?php echo $txt; ?><button class='btn-close del-item' type='button'></button></li>
                  <?php } ?>
                </ul>
                <div class="input-group mb-3">
                  <input type="text" class="form-control task-text" placeholder="Text input name" aria-label="text" aria-describedby="email">
                  <span class="btn btn-primary input-group-text addText">Add</span>
                </div>
                <ul id=t_files>
                  <?php $fls = explode('<>', $task->files); foreach($fls as $fl){ ?>
                    <li><?php echo $fl; ?><button class='btn-close del-item' type='button'></button></li>
                  <?php } ?>
                </ul>
                <div class="input-group mb-3">
                  <input type="text" class="form-control task-file" placeholder="File input name" id="">
                  <span class="btn btn-primary input-group-text addFile" id="">Add</span>
                </div>
                <ul id=t_long-texts>
                  <?php $lngs = explode('<>', $task->longs); foreach($lngs as $lng){ ?>
                    <li><?php echo $lng; ?><button class='btn-close del-item' type='button'></button></li>
                  <?php } ?>
                </ul>
                <div class="input-group mb-3">
                  <input type="text" class="form-control task-long" placeholder="long text input name" id="">
                  <span class="btn btn-primary input-group-text addLong" id="">Add</span>
                </div>
                <fieldset id=t_boxes>
                <?php $bxs = explode('<>', $task->boxes); foreach($bxs as $bx){ ?>
                  <div  class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" ><?php echo $bx; ?></label><button class='btn-close del-item' type='button'></button>
                  </div>
                <?php } ?>
                </fieldset>
                <div class="mb-3 form-check">
                  <input type="checkbox" class="form-check-input" id="exampleCheck1">
                  <input type="text" class="form-control task-check" placeholder="checkbox input name" id="">
                  <span class="btn btn-primary input-group-text addCheck" id="">Add</span>
                </div>
                <fieldset class="mb-3" id=t_radios>
                  <?php $rds = explode('<>', $task->radios); $j = 1; foreach($rds as $rd){ ?>
                    <div class="form-check">
                      <input type="radio" class="form-check-input" id="exampleRadio<?php echo $j; ?>">
                      <label class="form-check-label" for="exampleRadio<?php echo $j; ?>"><?php echo $rd; ?></label><button class='btn-close del-item' type='button'></button>
                    </div>
                  <?php $j++;} ?>
                </fieldset>
                <fieldset class="mb-3">
                  <div class="mb-3 form-check">
                    <input type="radio" name="radios" class="form-check-input" id="exampleRadio2">
                    <input type="text" class="form-control task-radio" placeholder="radio button input name" id="">
                    <span class="btn btn-primary input-group-text addRadio" id="">Add</span>
                  </div>
                </fieldset>
                <br>
                </div>
                <?php $i++;} ?>
                <div id=i style="display: none"><?php echo $i; ?></div>
                </div>
              </div>
              <div class="d-flex mb-3 justify-content-evenly">
                <button type="button" id='newTask' class="btn btn-primary">Add task</button>
                <button type="button" id='createJob' class="btn btn-success">Create job</button>
              </div>
            </div>
            
          </div>
        </form>
      </div>
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    </main>

    <script src="<?php echo base_url(); ?>/assets/dist/js/bootstrap.bundle.min.js"></script>
      
  </body>
</html>

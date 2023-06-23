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
    <link href="<?php echo base_url(); ?>assets/styles/header.css?version=3" rel="stylesheet">

    <!-- scripts -->
    <script src="<?php echo base_url(); ?>assets/scripts/jquery-3.6.0.js"></script>
    <?php $i = 1; $k = 1;?>
    <script src="<?php echo base_url(); ?>assets/scripts/update_job.js?version=13"></script>
  </head>
  <body>
    <?php $this->load->view("sidelinks/header"); ?>
    <main class="container">
      <div class="bg-light p-5 rounded">
        <h1 id=jobs>Update Job</h1>
        <form>
          <div class="mb-3">
            <input type="text" class="form-control" id="job-title" value="<?php echo $job->title; ?>" required disabled>
            <div class="valid-feedback">
              Please provide a valid name
            </div>
          </div>
          
          <div class="input-group">
            <span class="input-group-text">Description</span>
            <textarea class="form-control" id="job-desc" aria-label="description" value="<?php echo $job->notes; ?>" disabled><?php echo $job->notes; ?></textarea>
          </div>
          <br>
          <?php if (isset($job->file)) { ?>
          <div class="input-group mb-3">
            <span class="input-group-text">File</span>
            <input type="text" class="form-control" value="<?php echo $job->file; ?>" id="job-filename" disabled>
            <a href="<?php echo base_url('Proma/download/'.$job->file.'/'.$job->id); ?>"><span class="btn btn-primary input-group-text" id="download-job-file"><?php echo 'Download'; ?></span></a>
          </div>
          <?php } ?>
          <select id="client" class="form-control form-select w-50">
            <?php foreach($client as $cl) { ?>
              <option selected disabled><?php echo $cl->fullname; ?></option>
            <?php } ?>
          </select>
          <br>
          <div class="min-vh-100 d-flex flex-column align-items-center justify-content-center">
            <h2>Tasks</h2>
            <div class="card mb-6">
            <?php $j = 1; foreach ($tasks as $task) { ?>
              <div class="card-header">
                <div class="d-flex justify-content-between">
                  <h4 id=<?php echo $task->id; ?>> Task <?php echo $i; ?></h4>
                  <p id="hide">hide</p>
                </div>
              </div>
              <div class="card-body " id="card-body">
                
                <div id=<?php echo $task->id; ?> class="task show">
                
                <div class="mb-3">
                  <input type="text" class="form-control" id="task-title" placeholder="Task title" required value="<?php echo $task->title; ?>" disabled>
                  <div class="valid-feedback">
                    Please provide a valid title
                  </div>
                </div>
                <div class="input-group">
                  <span class="input-group-text">Task description</span>
                  <textarea class="form-control" id="task-desc" disabled><?php echo $task->notes; ?></textarea>
                </div>
                <br>
                <div class="input-group mb-3">
                  <span class="input-group-text">File</span>
                  <input type="text" class="form-control" value="<?php echo $task->file; ?>" id="task-file" disabled>
                  <a href="<?php if (isset($task->file)) {echo base_url('Proma/download/'.$task->file.'/'.$job->id);} ?>"><span class="btn btn-primary input-group-text change_task_file" id="download-task-file"><?php if (isset($task->file)) {echo 'Download';} else {echo 'No file';} ?></span></a>
                </div>
                <div class="input-group mb-3" id=sdate>
                  <span class=" input-group-text" id="">Start date</span>
                  <input type="date" class="form-control task-sdate" placeholder="Start date" value="<?php echo $task->start_date; ?>" id="task-sdate" disabled>
                </div>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="">End date</span>
                  <input type="date" class="form-control task-edate" placeholder="End date" id="task-edate" value="<?php echo $task->end_date; ?>" disabled>
                </div>
                 <ul id="selected_deps">
                  <?php $deps = explode('<>', $task->prev_tasks); if(count($deps)){ ?>
                    <h6>Dependencies</h6>
                    <?php  foreach($deps as $dep){ ?>
                          <li><?php echo $dep; ?></li>
                  <?php } }?>
                 </ul>
                <hr>
                <h5>Task <?php echo $i; ?> input</h5>
                <?php $txts = explode('<>', $task->texts); 
                      $dtxts = $input[$task->id][0] ? explode('<>', $input[$task->id][0]->titles) : explode('<>', $input[$task->id][0]);
                      $kv = [];
                        foreach ($dtxts as $nv){ if ($nv){
                          $kv[explode('_',$nv)[0]] = explode('_',$nv)[1];
                        }} 
                        foreach($kv as $k=>$v){ ?>
                          <label><?php echo $k.':'; ?></label>
                          <input type="text" class="form-control" value="<?php echo $v; ?>" disabled>
                        <?php }
                  foreach(array_diff($txts, array_keys($kv)) as $txt){ ?>
                <div class="mb-3 texts">
                  <label><?php echo $txt; ?></label>
                  <input type="text" class="form-control task-text" aria-label="text" aria-describedby="email">
                </div>
                <?php } ?>

                <?php $fls = explode('<>', $task->files); 
                    if ($input[$task->id][4]) {$dfls = explode('<>', $input[$task->id][4]->titles); } else {$dfls = explode('<>', $input[$task->id][4]); }
                    $kv = [];
                      foreach ($dfls as $nv){ if ($nv){
                        $kv[explode('_', explode(':',$nv)[0])[0]] = explode(':',$nv)[1];
                      }}
                      foreach($kv as $k=>$v){ ?>
                        <label><?php echo $k.':'; ?></label>
                        <input type="text" class="form-control" value="<?php echo $v; ?>" disabled>
                        <a href="<?php echo base_url('Proma/download/'.$v.'/'.$job->id); ?>"><span class="btn btn-primary input-group-text change_task_file" id="<?php echo $v; ?>"><?php echo 'Download'; ?></span></a>
                      <?php }
                foreach(array_diff($fls, array_keys($kv)) as $fl){ ?>
                <div class="mb-3">
                  <label><?php echo $fl; ?></label>
                  <input type="file"  class="form-control taskFile" aria-label="text" aria-describedby="email">
                </div>
                <?php } ?>
                <?php $lngs = explode('<>', $task->longs); 
                      $dlongs = $input[$task->id][1] ? explode('<>', $input[$task->id][1]->titles) : explode('<>', $input[$task->id][1]);
                      $kv = [];
                        foreach ($dlongs as $nv){ if ($nv){
                          $kv[explode('_',$nv)[0]] = explode('_',$nv)[1];
                        }}
                        foreach($kv as $k=>$v){ ?>
                          <label><?php echo $k.':'; ?></label>
                          <textarea class="form-control" value="<?php echo $v; ?>" disabled><?php echo $v; ?></textarea>
                        <?php }
                foreach(array_diff($lngs, array_keys($kv)) as $lng){ ?>
                <div class="mb-3 long-texts">
                  <label><?php echo $lng; ?></label>
                  <textarea class="form-control"></textarea>
                </div>
                <?php } ?>
                
                <fieldset  class="mb-3" id=t_boxes>
                <?php  $bxs = explode('<>', $task->boxes); 
                      $dbxs = $input[$task->id][2] ? explode('<>', $input[$task->id][2]->titles) : explode('<>', $input[$task->id][2]);
                      $kv = [];
                        foreach ($dbxs as $nv){ if ($nv){
                          $kv[count($kv)] = $nv;
                        }}
                        foreach($kv as $k){ ?>
                          <div class="form-check">
                            <input type="checkbox" name=boxes class="form-check-input" value="<?php echo $k; ?>" id="check<?php echo $k; ?>" checked disabled>
                            <label for="check<?php echo $k; ?>"><?php echo $k; ?></label>
                          </div>
                        <?php }
                foreach(array_diff($bxs, $kv) as $bx){ ?>
                <div class="form-check">
                  <input type="checkbox" name=boxes class="form-check-input" value="<?php echo $bx; ?>" id="check<?php echo $k; ?>">
                  <label for="check<?php echo $k; ?>"><?php echo $bx; ?></label>
                </div>
                <?php $k++;} ?>
                </fieldset>

                <fieldset class="mb-3" id=t_radios>
                  <?php $rds = explode('<>', $task->radios); 
                        $drds = $input[$task->id][3] ? explode('<>', $input[$task->id][3]->titles) : explode('<>', $input[$task->id][3]);
                        $kv = [];
                          foreach ($drds as $nv){ if ($nv){
                            $kv[count($kv)] = $nv;
                          }}
                          foreach($kv as $k){ ?>
                            <div class="form-check">
                              <input type="radio" name=boxes class="form-check-input" value="<?php echo $k; ?>" id="radio<?php echo $k; ?>" checked disabled>
                              <label for="radio<?php echo $k; ?>"><?php echo $k; ?></label>
                            </div>
                          <?php }
                        foreach(array_diff($rds, $kv) as $rd){if (count($kv)){ ?>
                          <div class="form-check">
                            <input type="radio" name=radios class="form-check-input" id="radio<?php echo $j; ?>" value="<?php echo $rd; ?>" disabled>
                            <label class="form-check-label" for="radio<?php echo $j; ?>"><?php echo $rd; ?></label>
                          </div>
                      <?php $j++;} else { ?>
                        <div class="form-check">
                        <input type="radio" name=radios class="form-check-input" id="radio<?php echo $j; ?>" value="<?php echo $rd; ?>">
                        <label class="form-check-label" for="radio<?php echo $j; ?>"><?php echo $rd; ?></label>
                      </div>
                  <?php $j++;
                      }} ?>
                </fieldset>
                <div class="form-check d-flex justify-content-end">
                  <input type="checkbox" name="done-box" id="<?php echo $task->id; ?>" class="form-check-input" value="task_done"
                  <?php if ($task->status == 'done'){ echo 'checked '; echo 'disabled';} ?>
                  >
                  <label for="<?php echo $task->id; ?>">Task done</done>
                </div>
                <br>
                  </div>
                  </div>
                <?php $i++;} ?>
                <div id=i style="display: none"><?php echo $i; ?></div>
              <div class="card-footer">
              <div class="d-flex mb-3 justify-content-between">
                <fieldset class="mb-3">
                  <div class="mb-3 form-check">
                    <input type="checkbox" name="done-box" id="job-done" class="form-check-input" value="job_done">
                    <label for="job-done">Done</done>
                  </div>
                </fieldset>
                <button type="button" id='updateJob' class="btn btn-success">Update</button>
              </div>
              </div>
            </div>
            
          </div>
        </form>
      </div>
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    </main>

    <script src="<?php echo base_url(); ?>/assets/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      let Settings = {base_url: '<?= site_url() ?>', jobId: '<?= $job->id ?>'};
    </script> 
  </body>
</html>

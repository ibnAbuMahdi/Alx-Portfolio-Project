<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo base_url(); ?>proma/jobs">Proma</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
          <a class="nav-link" id=jobs aria-current="page" href="<?php echo base_url(); ?>proma/jobs">Jobs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id=templates href="<?php echo base_url(); ?>proma/templates">Templates</a>
        </li>
        <li  class="nav-item">
          <a class="nav-link" id=clients href="<?php echo base_url(); ?>proma/clients">Clients</a>
        </li>
        <li  class="nav-item">
          <a class="nav-link" id=history href="<?php echo base_url(); ?>proma/history">History</a>
        </li>
      </ul>
      
      <div class="dropdown">
        <button class="btn btn-outline-success dropdown-toggle" type="button" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false" >
        Create New</button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#clientModal">Client</a></li>
          <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#templateModal">Template</a></li>
          <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#jobModal">Job</a></li>
        </ul>
      </div>
      <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>proma/sign_out">Sign-out</a>
          </li>
      </ul>
    </div>
  </div>
</nav>
<div class="modal fade" id="clientModal" tabindex="-1" 
  aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="clientModalTitle">Create client</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo site_url("proma/create_client"); ?>" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <input type="text" class="form-control" name="name" placeholder="Full name" required>
            <div class="valid-feedback">
              Please provide a valid name
            </div>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text" id="email">@</span>
            <input type="text" class="form-control" name=email placeholder="Email address" aria-label="Email" aria-describedby="email">
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" name=phone placeholder="phone number" aria-label="Email" aria-describedby="email">
          </div>
          <div class="input-group">
            <span class="input-group-text">Notes</span>
            <textarea class="form-control" name=notes aria-label="With textarea"></textarea>
          </div>
          <br>
          <div class="mb-3">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="templateModal" tabindex="-1" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="templateModalTitle">Create Template</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <input type="text" class="form-control" id="temp-title" placeholder="Template title" required>
            <div class="valid-feedback">
              Please provide a valid name
            </div>
          </div>
          
          <div class="input-group">
            <span class="input-group-text">Description</span>
            <textarea class="form-control" id="temp-desc" aria-label="description"></textarea>
          </div>
          <br>
          <input type="file" class="form-control" name="temp-file" id="temp-file">
          <br>
          <div class="min-vh-100 d-flex flex-column align-items-center justify-content-center">
            <h2>Task Details</h2>
            <div class="card mb-6">
              <div class="card-body">
                <div class="mb-3">
                  <input type="text" class="form-control" id="task-title" placeholder="Task title" required>
                  <div class="valid-feedback">
                    Please provide a valid title
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="number" class="form-control" id="task-duration" placeholder="Duration" required>
                  <select id="duration-unit" class="form-control form-select" required>
                    <option>Hours</option>
                    <option>Days</option>
                    <option>Weeks</option>
                    <option>Months</option>
                    <option>Years</option>
                  </select>
                </div>
                <div class="input-group">
                  <span class="input-group-text">Task description</span>
                  <textarea class="form-control" id="task-desc"></textarea>
                </div>
                <br>
                <input type="file" class="form-control" id="taskFile">
                <hr>
                <h4>Task input</h4>
                <ul id=texts></ul>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" id="task-text" placeholder="Text input name" aria-label="text" aria-describedby="email">
                  <span class="btn btn-primary input-group-text" id="addText">Add</span>
                </div>
                <ul id=files></ul>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="File input name" id="task-file">
                  <span class="btn btn-primary input-group-text" id="addFile">Add</span>
                </div>
                <ul id=long-texts></ul>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="long text input name" id="task-long">
                  <span class="btn btn-primary input-group-text" id="addLong">Add</span>
                </div>
                <ul id=boxes></ul>
                <div class="mb-3 form-check">
                  <input type="checkbox" class="form-check-input" id="exampleCheck1">
                  <input type="text" class="form-control" placeholder="checkbox input name" id="task-box">
                  <span class="btn btn-primary input-group-text" id="addCheck">Add</span>
                </div>
                <ul id=radios></ul>
                <fieldset class="mb-3">
                  <div class="mb-3 form-check">
                    <input type="radio" name="radios" class="form-check-input" id="exampleRadio2">
                    <input type="text" class="form-control" placeholder="radio button input name" id="task-radio">
                    <span class="btn btn-primary input-group-text" id="addRadio">Add</span>
                  </div>
                </fieldset>
              </div>
              <button type="button" id=add-task class="btn btn-primary">Add task</button>
            </div>
          </div>
        </form>
        <div class="modal-footer">
          <div class="mb-3">
            <button type="button" id=create class="btn btn-primary">Create</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="jobModal" tabindex="-1" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="jobModalTitle">Create job</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <a href="<?php echo base_url(); ?>proma/templates"><button type="button" class="btn btn-primary" >Existing template</button></a>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#templateModal">New Template</button>
        </div>
      </div>
    </div>
  </div>
</div>

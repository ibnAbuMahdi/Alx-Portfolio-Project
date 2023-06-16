<script>
$(function(){
    //def objects
    let job = {};
    let tasks = [];
    let task = {};
    let files = '';
    let templateFile = new FormData();
    let tasksFile = new FormData();
    let units = {'Hours': 3600000, 'Days': 3600000*24, 'Weeks': 3600000*24*7, 'Years': 3600000*24*7*52}

    // set active tab
    removeActive();
    $('h1').each((index, item)=>{
        if ($(item).attr('id') === 'jobs'){
            $('#jobs').addClass('active');
        } else if($(item).attr('id') === 'clients'){
            $('#clients').addClass('active');
        }else if($(item).attr('id') === 'templates'){
            $('#templates').addClass('active');
        }else if($(item).attr('id') === 'history'){
            $('#history').addClass('active');
        }
    });

    //select client
    //do search
    $('#search').on('change', ()=>{
        //todo
    });

    //do sign out
    $('#sign_out').click(()=>{

    });
    
    // Change temp file
    $('#change_job_file').click(()=>{
        let parent = $('#change_job_file').parent();
        $(parent).empty();
        $(parent).append($('<input type="file" class="form-control" name="job-file" id="job-file">'));
    });
    
    //Change task file
    
    $('.change_task_file').each((ix, item)=>{
        $(item).click(()=>{
            let parent = $(item).parent();
            $(parent).empty();
            $(parent).append($('<input type="file" class="form-control" name="temp-file" id="taskFile">'));
        });
        
    });
    
    let i = $('#i').text();
    
    // create template
    //add task
    $('#newTask').click(()=>{
       $('#card-body').each((ix, item)=>{
            $(item).append($(
                '<div class=task>\
                <h4>Task ' + i + '</h4><div class="mb-3">\
                  <input type="text" class="form-control" id="task-title" placeholder="Task title" required>\
                  <div class="valid-feedback">\
                    Please provide a valid title\
                  </div>\
                </div>\
                <div class="input-group mb-3" id="dur-group">\
                  <input type="number" class="form-control" id="task-duration" placeholder="Duration" required>\
                  <select id="duration-unit" class="form-control form-select" required>\
                    <option>Hours</option>\
                    <option>Days</option>\
                    <option>Weeks</option>\
                    <option>Years</option>\
                  </select>\
                </div>\
                <div class="input-group">\
                  <span class="input-group-text">Task description</span>\
                  <textarea class="form-control" id="task-desc"></textarea>\
                </div>\
                <br>\
                <div class="input-group mb-3">\
                    <input type="file" class="form-control" id="taskFile">\
                </div>\
                <div class="input-group mb-3" id=sdate>\
                    <span class=" input-group-text" id="">Start date</span>\
                  <input type="date" class="form-control task-sdate" placeholder="Start date" id="">\
                </div>\
                <div class="input-group mb-3">\
                    <span class="input-group-text" id="">End date</span>\
                  <input type="date" class="form-control task-edate" placeholder="End date" id="" disabled>\
                </div>\
                <ul id="selected_deps"></ul>\
                <select class="form-control form-select deps">\
                  <option disabled selected>Select dependencies</option>\
                </select>\
                <hr>\
                <h4>Task ' + i + ' input</h4>\
                <ul id=texts></ul>\
                <div class="input-group mb-3">\
                  <input type="text" class="form-control task-text" id="" placeholder="Text input name" aria-label="text" aria-describedby="email">\
                  <span class="btn btn-primary input-group-text addText" id="">Add</span>\
                </div>\
                <ul id=files></ul>\
                <div class="input-group mb-3">\
                  <input type="text" class="form-control" placeholder="File input name" id="task-file">\
                  <span class="btn btn-primary input-group-text addFile" id="">Add</span>\
                </div>\
                <ul id=long-texts></ul>\
                <div class="input-group mb-3">\
                  <input type="text" class="form-control" placeholder="long text input name" id="task-long">\
                  <span class="btn btn-primary input-group-text addLong" id="">Add</span>\
                </div>\
                <ul id=boxes></ul>\
                <div class="mb-3 form-check">\
                  <input type="checkbox" class="form-check-input" id="exampleCheck1">\
                  <input type="text" class="form-control task-check" placeholder="checkbox input name" id="">\
                  <span class="btn btn-primary input-group-text addCheck" id="">Add</span>\
                </div>\
                <ul id=radios></ul>\
                <fieldset class="mb-3">\
                  <div class="mb-3 form-check">\
                    <input type="radio" name="radios" class="form-check-input" id="exampleRadio2">\
                    <input type="text" class="form-control task-radio" placeholder="radio button input name" id="">\
                    <span class="btn btn-primary input-group-text addRadio" id="">Add</span>\
                  </div>\
                </fieldset>\
                </div>'
            ));
        });
        i++;
        attachAdds();
        setDates();
        setPrevs();
        addDeps();
    });
    
    // attach click() to Add buttons
    function attachAdds(){
            //add text input
        $('.addText').each((ix, item)=>{
            $(item).click(()=>{
                const val = $(item).siblings('.task-text').val();
                if (val.length){
                    $(item).parent().prev().append($('<li>').text(val).append($('<button>').attr('type', 'button').addClass(['btn-close', 'del-item'])));
                    $('.del-item').each((ix, item)=>{
                        $(item).click(()=>{
                            $(item).parent().remove();
                        });
                    });
                    $(item).siblings('.task-text').val('');
                    // update task array
                }
            });
            
        });
        
        //add long text
        $('.addLong').each((ix, item)=>{
            $(item).click(()=>{
                const val = $(item).siblings('.task-long').val();
                if (val.length){
                    $(item).parent().prev().append($('<li>').text(val).append($('<button>').attr('type', 'button').addClass(['btn-close', 'del-item'])));
                    $('.del-item').each((ix, item)=>{
                        $(item).click(()=>{
                            $(item).parent().remove();
                        });
                    });
                    $(item).siblings('.task-long').val('');
                    // update task array
                }
            });
        });
        
        //add file
        $('.addFile').each((ix, item)=>{
            $(item).click(()=>{
                const val = $(item).siblings('.task-file').val();
                if (val.length){
                    $(item).parent().prev().append($('<li>').text(val).append($('<button>').attr('type', 'button').addClass(['btn-close', 'del-item'])));
                    $('.del-item').each((ix, item)=>{
                        $(item).click(()=>{
                            $(item).parent().remove();
                        });
                    });
                    $(item).siblings('.task-file').val('');
                    // update task array
                }
            });
        });
        
        //add check boxes
        $('.addCheck').each((ix, item)=>{
            $(item).click(()=>{
                const val = $(item).siblings('.task-check').val();
                if (val.length){
                    $(item).parent().before($('<div>').addClass(['mb-3', 'form-check'])
                    .append($('<input>').attr({type: 'checkbox', class: 'form-check-input'}))
                    .append($('<label>').text(val))
                    .append($('<button>').attr('type', 'button').addClass(['btn-close', 'del-item']))
                    );
                    $('.del-item').each((ix, item)=>{
                        $(item).click(()=>{
                            $(item).parent().remove();
                        });
                    });
                    $(item).siblings('.task-check').val('');
                    // update task array
                }
            });
        });

        //add radio buttons
        $('.addRadio').each((ix, item)=>{
            $(item).click(()=>{
                const val = $(item).siblings('.task-radio').val();
                if (val.length){
                    $(item).closest('fieldset').prev().append($('<div>').addClass(['mb-3', 'form-check'])
                    .append($('<input>').attr({type: 'radio', class: 'form-check-input'}))
                    .append($('<label>').addClass('form-check-label').text(val))
                    .append($('<button>').attr('type', 'button').addClass(['btn-close', 'del-item']))
                    );
                    $(item).siblings('.task-radio').val('');
                    $('.del-item').each((ix, item)=>{
                        $(item).click(()=>{
                            $(item).parent().remove();
                        });
                    });
                }
            });
        });

        //delete task input
        $('.del-item').each((ix, item)=>{
            $(item).click(()=>{
                $(item).parent().remove();
            });
        });
    }
    
    attachAdds();
    
    function setDates(){
        $('.task-sdate').each((ix, item)=>{
            $(item).change(()=>{
                updateDate(item);
            });
        });

        $('div#dur-group').each((ix, item)=>{
            $(item).find('select').change(()=>{
                let it = $(item).parent().find('#sdate').find('input')[0];
                updateDate(it);
            });
            $(item).find('input').change(()=>{
                let it = $(item).parent().find('#sdate').find('input')[0];
                updateDate(it);
            });
        });
    }

    setDates();

    function setDeps(){
        $('.task-edate').each((ix, item)=>{     //for each task-edate
            $(item).change(()=>{                //add on change callback
                $('.task-edate').each((ix, edate) => {          // go through all task-edate
                    $('.deps').each((ix, dep)=>{                //compare task-edate with all task-edate in all deps
                        let sdate_t = $(dep).prev().prev().find('input')[0];        // add edate to list it's value < sdate value
                        let taskTitle = $(edate).parent().parent().find('#task-title').val();
                        if(Date.parse($(edate).val()) < Date.parse($(sdate_t).val())){
                            insertTitle(taskTitle, dep)
                        } else {
                            removeOption(taskTitle, dep);
                        }
                    });
                });
                
            });
        });
    }

    setDeps();
    
    function addDeps(){
        $('.deps').each((ix, item)=>{
            if (!$(item).attr('changed')){
                $(item).change(()=>{
                    $(item).prev().append($('<li>').text($(item).val()));
                });
                $(item).attr('changed', true);
            }            
        });
    }

    addDeps();

    function insertTitle(title, select){
        let notIn = true;
        $(select).children().each((ix, opt)=>{
            if ($(opt).text() == title) {
                notIn = false;
            }
        });
        if (notIn) {
            $(select).append($('<option>').text(title));
        }
    }

    function removeOption(title, select){
        $(select).children().each((ix, opt)=>{
            if ($(opt).text() == title) {
                $(opt).remove();
            }
        });
    }

    function updateDate(item){
        if ($(item).val()){
            let sdate = Date.parse($(item).val());
            let sel = $(item).parent().parent().find('#dur-group').find('select')[0];
            let inp = $(item).parent().parent().find('#dur-group').find('input')[0];
            let dur = units[$(sel).val()] * $(inp).val();
            let end = $(item).parent().next().find('input')[0];
            let d = (new Date(dur + sdate)).toISOString();
            let iso = d.slice(0, d.indexOf('T'));
            $(end).val(iso);
            $(item).parent().next().find('input').change();
        }
    }

    // create 
    $('#createJob').click(()=>{
        $('#createJob').attr('disabled', true);
        $('#newTask').attr('disabled', true);
        $('#createJob').parent().prepend($('<div>').addClass(['spinner-border', 'text-primary']).attr('role', 'status'));
        if ($('#job-title').val().length){
            let c_name = $('#client').val();
            let c_id = "";
            $('#client option').each((ix, item)=>{
                if (c_name && $(item).val() == c_name){ 
                    c_id = $(item).attr('id');
                }
            });
            job['title'] = $('#job-title').val();
            job['desc'] = $('#job-desc').val();
            job['client'] = c_id;
            job['files'] = getFiles();
            job['tasks'] = getTasks();
        } else {
            alert('Job title cannot be empty!');
        }
        if (job.files && job.tasks){
            postJob();
        } else {
            job = {};
            $('#createJob').attr('disabled', false);
            $('#newTask').attr('disabled', false);
            $('#createJob').parent().find('div.spinner-border').remove();
        }
    });

    function getTasks(){
        let tasks = [];
        let ok = true;
        $('.task').each((ix, task)=>{
            let task_o = {};
            let deps = [];
            let title = $(task).find('#task-title').val();
            let dur = $(task).find('#task-duration').val();
            let desc = $(task).find('#task-desc').val();
            let unit = $(task).find('#duration-unit').val();
            let sdate = $(task).find('#task-sdate').val();
            let edate = $(task).find('#task-edate').val();
            $(task).find('#selected_deps').children().each((ix, dep)=>{
                deps[deps.length] = $(dep).text();
            });
            if (sdate){
                task_o = {'title': title, 'desc': desc, 'dur': dur, 'unit': unit, 'sdate': sdate, 'edate': edate, 'deps': deps};
            } else {
                alert('start date of task ' + (ix + 1) + ' cannot be empty.');
                ok = false;
                //exit();
            }
            if (!ok) { return }
            let texts = [];
            let longs = [];
            let files = [];
            let boxes = [];
            let radios = [];
            $('#t_texts').children('li').each((ix, item)=>{
                texts[texts.length] = $(item).text();
            });
            $('#t_files').children('li').each((ix, item)=>{
                files[files.length] = $(item).text();
            });
            $('#t_long-texts').children('li').each((ix, item)=>{
                longs[longs.length] = $(item).text();
            });
            $('#t_boxes').find('label').each((ix, item)=>{
                boxes[boxes.length] = $(item).text();
            });
            $('#t_radios').find('label').each((ix, item)=>{
                radios[radios.length] = $(item).text();
            });
            task_o['texts'] = texts;
            task_o['longs'] = longs;
            task_o['files'] = files;
            task_o['boxes'] = boxes;
            task_o['radios'] = radios;
            tasks[tasks.length] = task_o;
        });

        return ok ? tasks : ok;
    }

    function getFiles(){
        let fileNames = {};
        let ok = true;
        //get job file name if exist
        if ($('#job-filename').val()){
            fileNames['job-file'] = $('#job-filename').val();
        } else {
            let fileInput = $('#job-file')[0];
            tasksFile.append('job_file', fileInput.files[0]);
        }

        //get filename for each task if exist
        $('.task').each((ix, task)=>{
            let title = $(task).find('#task-title').val();
            let dur = $(task).find('#task-duration').val();
            let unit = $(task).find('#duration-unit').val();
            if (title.length && $.isNumeric(dur) && dur){
                if ($(task).find('#task-file')[0]){
                    fileNames[title + dur + unit] = $(task).find('#task-file').val();
                } else {
                    let fileInput = $(task).find('#taskFile')[0];
                    if (fileInput){
                        tasksFile.append(title + dur + unit, fileInput.files[0]);
                        fileNames[title + dur + unit] = '';
                    }
                }
            } else {
                alert('Task ' + (ix + 1) + ' must have a title and duration');
                ok = false;
            }
        });

        //Upload files if exist
        if(ok && tasksFile){
            $.ajax({
            url: '<?php echo site_url(); ?>proma/upload_files',
            type: 'POST',
            data: tasksFile, 
            contentType: false,
            cache: false,
            processData: false,
            success: (data)=>{
                if (data !== 'failed') {
                    Object.assign(fileNames, JSON.parse(data));
                } else if (data === 'failed') {
                    alert('Error creating job');
                }
                tasksFile = new FormData();
            }
            });
        }
        return ok ? fileNames : ok;
    }

    function postJob() {
            $.ajax({
            url: '<?php echo site_url(); ?>proma/post_job',
            type: 'POST',
            data: {job: JSON.stringify(job)}, 
            success: (data)=>{
                if (data == 'success') {
                    alert('Job successfully created!'); 
                }
                job = {};
            },
            error: (error)=>{
                console.log(error);
            }
        }).done(()=>{
            $('#createJob').attr('disabled', false);
            $('#newTask').attr('disabled', false);
            $('#createJob').parent().find('div.spinner-border').remove();
        });
    }

    function removeActive(){
        $('#jobs').removeClass('active');
        $('#clients').removeClass('active');
        $('#templates').removeClass('active');
        $('#history').removeClass('active');
    }

});

</script>

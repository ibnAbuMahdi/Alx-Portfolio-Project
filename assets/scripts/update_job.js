$(()=>{
    let job = {};
    let tasks = [];
    let tasksFile = new FormData();
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

    $('.card-header #hide').each((ix, item)=>{
        $(item).click(()=>{
            if($(item).parent().parent().next().find('.task:first').hasClass('show')){
                $(item).text('show');
                $(item).parent().parent().next().find('.task:first').removeClass('show');
                $(item).parent().parent().next().find('.task:first').addClass('hide');
            } else {
                $(item).text('hide');
                $(item).parent().parent().next().find('.task:first').removeClass('hide');
                $(item).parent().parent().next().find('.task:first').addClass('show');
            }
        });
    });

    $('#updateJob').click(()=>{
        $('#updateJob').attr('disabled', true);
        $('#updateJob').parent().prepend($('<div>').addClass(['spinner-border', 'text-primary']).attr('role', 'status'));
        getTasks();
        getFiles(); 
        
        job['id'] = Settings.jobId;
        job['job_done'] = $('#job-done:checked').val();
        if (!job.tasks){
            job = {};
            $('#updateJob').attr('disabled', false);
            $('#updateJob').parent().find('div.spinner-border').remove();
        }
    });

    function getTasks(){
        let tasks = [];
        $('.task').each((ix, task)=>{
            let task_o = {};
            let texts = {};
            let longs = {};
            let radios = {};
            let boxes = {};
            $(task).find('.texts').each((ix, item)=>{
                texts[$(item).find('label:first').text()] = $(item).find('input[type="text"]:first').val();
            });
            $(task).find('.long-texts').each((ix, item)=>{
                longs[$(item).find('label:first').text()] = $(item).find('textarea:first').val();
            });
            $(task).find('input[name="boxes"]:checked').each((ix, item)=>{
                boxes[$(item).next().text()] = $(item).val();
            });
            radios[$(task).find('input[name="radios"]:checked').val()] = $(task).find('input[name="radios"]:checked').val();
            task_o[$(task).attr('id')] = $(task).find('input[name="done-box"]:checked:first').val();
            task_o['texts'] = texts;
            task_o['longs'] = longs;
            task_o['boxes'] = boxes;
            task_o['radios'] = radios;
            task_o['id'] = $(task).attr('id');
            tasks[tasks.length] = task_o;
        });

        job['tasks'] = tasks;
    }

    function getFiles(){
        let fileNames = {};
        let ok = true;
        
        //get filename for each task if exist
        $('.task').each((ix, task)=>{
    
            $(task).find('input.taskFile').each((ix, file)=>{
                if(file.files[0]){
                    tasksFile.append($(file).prev().text() + '_' + $(task).attr('id'), file.files[0]);
                }
            });
           
        });
        //Upload files if exist
        if(ok){
            $.ajax({
            url: Settings.base_url+'proma/upload_input_files',
            type: 'POST',
            data: tasksFile, 
            contentType: false,
            cache: false,
            processData: false,
            success: (data)=>{
                console.log(data);
                if (data !== 'failed') {
                    Object.assign(fileNames, JSON.parse(data));
                } else if (data === 'failed') {
                    alert('Error creating job');
                }
                tasksFile = new FormData();
            }
        
            }).promise().done(()=>{
                job['files'] = fileNames;
                updateJob();
            }).done(()=>{
                history.go(Settings.base_url+'/Proma/jobs');
            });
        }
    }

    function updateJob() {
            $.ajax({
            url: Settings.base_url + 'proma/update_job',
            type: 'POST',
            data: {job: JSON.stringify(job)}, 
            success: (data)=>{
                console.log(data);
                if (data == 'success') {
                    alert('Job successfully updated!'); 
                }
                job = {};
            },
            error: (error)=>{
                console.log(error);
            }
        }).done(()=>{
            $('#updateJob').attr('disabled', false);
            $('#updateJob').parent().find('div.spinner-border').remove();
        });
    }

    function removeActive(){
        $('#jobs').removeClass('active');
        $('#clients').removeClass('active');
        $('#templates').removeClass('active');
        $('#history').removeClass('active');
    }

});
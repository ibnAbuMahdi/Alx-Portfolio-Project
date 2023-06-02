<script>
$(function(){
    //def objects
    let template = {};
    let tasks = [];
    let task = {}
    let templateFile = new FormData();
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

    //do search
    $('#search').on('change', ()=>{
        //todo
    });

    //do sign out
    $('#sign_out').click(()=>{

    });
    
    // create template
        //add text input
    $('#addText').click(()=>{
        const val = $('#task-text').val();
        if (val.length){
            $('#texts').append($('<li>').text(val).append($('<button>').attr('type', 'button').addClass(['btn-close', 'del-item'])));
            $('.del-item').each((ix, item)=>{
                $(item).click(()=>{
                    $(item).parent().remove();
                });
            });
            $('#task-text').val('');
            // update task array
        }
    });
        //add long text
    $('#addLong').click(()=>{
        const val = $('#task-long').val();
        if (val.length){
            $('#long-texts').append($('<li>').text(val).append($('<button>').attr('type', 'button').addClass(['btn-close', 'del-item'])));
            $('.del-item').each((ix, item)=>{
                $(item).click(()=>{
                    $(item).parent().remove();
                });
            });
            $('#task-long').val('');
            // update task array
        }
    });
        //add file
    $('#addFile').click(()=>{
        const val = $('#task-file').val();
        if (val.length){
            $('#files').append($('<li>').text(val).append($('<button>').attr('type', 'button').addClass(['btn-close', 'del-item'])));
            $('.del-item').each((ix, item)=>{
                $(item).click(()=>{
                    $(item).parent().remove();
                });
            });
            $('#task-file').val('');
            // update task array
        }
    });
        //add check boxes
    $('#addCheck').click(()=>{
        const val = $('#task-box').val();
        if (val.length){
            $('#boxes').append($('<li>').text(val).append($('<button>').attr('type', 'button').addClass(['btn-close', 'del-item'])));
            $('.del-item').each((ix, item)=>{
                $(item).click(()=>{
                    $(item).parent().remove();
                });
            });
            $('#task-box').val('');
            // update task array
        }
    });
        //add radio buttons
    $('#addRadio').click(()=>{
        const val = $('#task-radio').val();
        if (val.length){
            $('#radios').append($('<li>').text(val).append($('<button>').attr('type', 'button').addClass(['btn-close', 'del-item'])));
            $('.del-item').each((ix, item)=>{
                $(item).click(()=>{
                    $(item).parent().remove();
                });
            });
            $('#task-radio').val('');
            // update task array
        }
    });
   
        //add task
    $('#add-task').click(()=>{
        if ($('#task-title').val().length && $('#task-duration').val()){
            task['title'] = $('#task-title').val();
            task['duration'] = $('#task-duration').val();
            task['unit'] = $('#duration-unit').val();
            task['file'] = $('#taskFile').val();
            task['desc'] = $('#task-desc').val();
            let texts = [];
            let longs = [];
            let files = [];
            let boxes = [];
            let radios = [];
            $('#texts').children('li').each((ix, item)=>{
                texts[texts.length] = $(item).text();
            });
            $('#files').children('li').each((ix, item)=>{
                files[files.length] = $(item).text();
            });
            $('#long-texts').children('li').each((ix, item)=>{
                longs[longs.length] = $(item).text();
            });
            $('#boxes').children('li').each((ix, item)=>{
                boxes[boxes.length] = $(item).text();
            });
            $('#radios').children('li').each((ix, item)=>{
                radios[radios.length] = $(item).text();
            });
            task['texts'] = texts;
            task['longs'] = longs;
            task['files'] = files;
            task['boxes'] = boxes;
            task['radios'] = radios;
            tasks[tasks.length] = task;
            clearTask();
            alert('Task saved successfully!');
        } else {
            alert('Task title or task duration cannot be empty');
        }
    });

    // create 
    $('#create').click(()=>{
        if ($('#temp-title').val().length){
            let fileInput = $('#temp-file')[0];
            templateFile.append('temp-file', fileInput.files[0]);
            template['title'] = $('#temp-title').val();
            template['desc'] = $('#temp-desc').val();
            template['file'] = templateFile;
            template['tasks'] = tasks;
            clearTemplate();
            postTemplate();
        } else {
            alert('Template title cannot be empty!');
        }
    });
    
    function postTemplate() {
        $.ajax({
            url: '<?php echo site_url(); ?>proma/create_template',
            type: 'POST',
            data: templateFile, 
            contentType: false,
            cache: false,
            processData: false,
            success: (data)=>{
                alert(data);
                if (data == template['title']) {
                    alert('Template successfully created!'); 
                } else {
                    alert('Error creating template');
                }
                template = {};
            }
        });
    }
    function removeActive(){
        $('#jobs').removeClass('active');
        $('#clients').removeClass('active');
        $('#templates').removeClass('active');
        $('#history').removeClass('active');
    }

    function clearTemplate(){
        $('#temp-title').val("");
        $('#temp-desc').val("");
        $('#temp-file').val("");
    }

    function clearTask(){
        $('#task-title').val("");
        $('#task-duration').val("");
        $('#duration-unit').val("");
        $('#taskFile').val("");
        $('#task-desc').val("");
        $('#texts').empty();
        $('#files').empty();
        $('#long-texts').empty();
        $('#boxes').empty();
        $('#radios').empty();
    }
});

</script>

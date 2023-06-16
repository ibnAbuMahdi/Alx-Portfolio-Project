$(()=>{
    //do dropdowns
    const completed = $('#completed');
    const ongoing = $('#ongoing');
    const overdue = $('#overdue');
    function setBorders(){
        $('.job-card').each((ix, item)=>{
            // job borders
            const title = $(item).find('h5')[0];
            if ($(item).find('#status').attr('status') === 'done'){
                $(item).addClass('completedJob');
                completed.append($('<li>').html($('<a>').text($(title).text()).attr({'href': Settings.base_url+'proma/get_job/'+$(item).attr('id'), 'class': 'li', 'id': $(item).attr('id')})));
            } else if ($(item).find('#status').attr('status') === 'started'){
                $(item).addClass('ongoingJob');
                ongoing.append($('<li>').html($('<a>').text($(title).text()).attr({'href': Settings.base_url+'proma/get_job/'+$(item).attr('id'), 'class': 'li', 'id': $(item).attr('id')})));
            }else if ($(item).find('#status').attr('status') === 'stopped'){
                overdue.append($('<li>').html($('<a>').text($(title).text()).attr({'href': Settings.base_url+'proma/get_job/'+$(item).attr('id'), 'class': 'li', 'id': $(item).attr('id')})));
                $(item).addClass('overdueJob');
            }
       }); 
    }
   setBorders();

   $('.job-card').each((ix, item)=>{
        $.ajax({
            url: Settings.base_url + "proma/get_tasks",
            type: 'POST',
            data: {'id': $(item).attr('id'), 'c_id': $(item).find('#card-header').attr('val')},
            success: (data)=>{
                console.log(data);
                updateJobProgress(item, data);
            },
            error: (error)=>{
                console.log(error.responseText);
            }

        });
   });

   function updateJobProgress (item, data){
        let done = JSON.parse(data)['done'];
        let all = JSON.parse(data)['all'];
        let date = JSON.parse(data)['date'][0]['end_date']
        const title = $(item).find('h5')[0];

        const tasksRate = done / all;
        const quad = Math.floor(tasksRate * 4);
        if (quad === 0){
            $(item).find('.progress-bar').addClass('bg-danger').text('0%');
        } else if(quad === 1){
            $(item).find('.progress-bar').addClass(['bg-warning', 'w-25', 'text-dark']).text('25%');
        }else if(quad === 2){
            $(item).find('.progress-bar').addClass(['bg-info', 'w-50', 'text-dark']).text('50%');
        }else if(quad === 3){
            $(item).find('.progress-bar').addClass(['w-75']).text('75%');
        }else if(quad === 4){
            $(item).find('.progress-bar').addClass(['bg-success', 'w-100']).text('100%');
            if ($(item).hasClass('ongoingJob')){
                $(item).removeClass('ongoingJob');
            } else if ($(item).hasClass('overdueJob')){
                $(item).removeClass('overdueJob');
            }
            $(item).find('#status').attr('status','done');
            $(item).addClass('completedJob');
            completed.append($('<li>').html($('<a>').text($(title).text()).attr({'href': '#', 'class': 'li', 'id': $(item).attr('id')})));
            ongoing.find('#' + $(item).attr('id')).parent().remove();
            overdue.find('#' + $(item).attr('id')).parent().remove();
            
        }

        $(item).find('#end-date').text(date);
        
        if (JSON.parse(data)['client']){
            let client = JSON.parse(data)['client']['fullname'];
            $(item).find('#client').text(client);
        }
   }

    $('#f_c').change((item)=>{
        let titles = $('<ul>');
        const query = $(item).val();
        $(item).parents('li').siblings().each((ix, item)=>{
            console.log('changed');
            if ($(item).text().search(query) >= 0){
                titles.append(item);
            }
        });
        $(this).parents('ul').find('.li').remove();
        $(this).parents('ul').append($(titles).find('*'));
        
    });
    $('#f_on').change(()=>{
        let titles = $('<ul>');
        const query = $(this).val();
        $(this).parents('li').siblings().each((ix, item)=>{
            if ($(item).text().search(query) >= 0){
                titles.append(item);
            }
        });
        $(this).parents('ul').find('.li').remove();
        $(this).parents('ul').append($(titles).find('*'));
    });

    $('#f_ov').change(()=>{
        let titles = $('<ul>');
        const query = $(this).val();
        $(this).parents('li').siblings().each((ix, item)=>{
            if ($(item).text().search(query) >= 0){
                titles.append(item);
            }
        });
        $(this).parents('ul').find('.li').remove();
        $(this).parents('ul').append($(titles).find('*'));
    });



  

});
$(()=>{
    //do dropdowns
    const completed = $('#completed');
    const ongoing = $('#ongoing');
    const overdue = $('#overdue');
    let jobs = '<?php echo $jobs ?>'

    $('h5').each((ix, item)=>{
        const title = $(item).text();
        //use id = $(item).attr('id') instead of title
        if ($(item).parent().parent().hasClass('completedJob')){
            completed.append($('<li>').html($('<a>').text(title).attr({'href': '#', 'class': 'li'})));
        } else if ($(item).parent().parent().hasClass('ongoingJob')) {
            ongoing.append($('<li>').html($('<a>').text(title).attr({'href': '#', 'class': 'li'})));
        } else if ($(item).parent().parent().hasClass('overdueJob')) {
            overdue.append($('<li>').html($('<a>').text(title).attr({'href': '#', 'class': 'li'})));
        }
        //todo
        //replace title with jobs[id]
        // replace # with <?php echo site_url(); ?>/getJob/id

    });

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


    //do jobs borders and progressbars

   $('card').each((ix, item)=>{
        // job borders
        if ($(item).find('#status').text() === 'completed'){
            $(item).addClass('completedJob');
        } else if ($(item).find('#status').text() === 'ongoing'){
            $(item).addClass('ongoingJob');
        }else if ($(item).find('#status').text() === 'overdue'){
            $(item).addClass('overdueJob');
        }
        // progressbars
        const tasksRate = Number($(item).find("#done-tasks").val()) / Number($(item).find("#all-tasks").val());
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
        }

        // date
   }); 

});
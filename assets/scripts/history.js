$(()=>{
    //do dropdowns

    //do jobs borders
    if (Date.parse(date) < Date.parse(new Date()) && $(item).find('#status').attr('status') === 'started'){
        overdue.append($('<li>').html($('<a>').text($(title).text()).attr({'href': Settings.base_url+'proma/get_job/'+$(item).attr('id'), 'class': 'li', 'id': $(item).attr('id')})));
        $(item).addClass('overdueJob');
        completed.find('#' + $(item).attr('id')).parent().remove();
        ongoing.find('#' + $(item).attr('id')).parent().remove();
    }
    
});
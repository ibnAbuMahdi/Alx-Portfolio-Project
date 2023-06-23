$(()=>{
    $('#send').attr('disabled', true);
    $('#pword').change(()=>{
        if($('#pword').val().length >= 6){
            $('#send').attr('disabled', false);
        } else if ($('#pword').val().length < 6){
            $('#send').attr('disabled', true);
        }
    });

    $('.btn-close').each((ix, item)=>{
        $(item).click(()=>{
            $(item).parent().remove();
        });
    });
});
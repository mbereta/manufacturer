require(["jquery", "mage/calendar"],function($){
    $(document).ready(function(){        
        $('.manufacturer-datetime-filter').each(function(){            
            htmlId = $(this).attr('data-htmlId');
            dateFormat = $(this).attr('data-dateFormat');
            timeFormat = $(this).attr('data-timeFormat');
            showsTime = $(this).attr('data-showsTime');
            buttonText = $(this).attr('data-buttonText');            
            $('#'+htmlId+'_range') .dateRange({               
                dateFormat: dateFormat,
                timeFormat: timeFormat,
                showsTime: Boolean(showsTime),
                buttonText: buttonText,
                from: {
                    id: htmlId+'_from'
                },
                to: {
                    id: htmlId+'_to'
                }
            });
        });
    });
});

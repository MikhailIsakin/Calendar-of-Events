jQuery( document ).ready(function( $ ) {
    var calendarEl = document.getElementById( 'coe' );

    var calendar = new FullCalendar.Calendar( calendarEl, {
        plugins: [ 'dayGrid' ],

        eventSources: [{
            events: [],
        }],

    });

    calendar.render();

    var calendarCache = [];

    $('.fc-button-group').click(function() {
        updateEvents();
    });

    var monthYear = function() {
        {
            var now = new Date( calendar.view.title ),
                month = ( '0' + ( now.getMonth() + 1 ) ).slice( -2 ),
                year = now.getFullYear();
            return {
                year: year,
                month: month
            };
        }
    };

    function addEvent( year, month, data ) {
        calendar.addEvent({
            start: year + '-' + month + '-' + data[0],
            title: data[1],
            description: data[2]
        });
    }

    function updateEvents() {
        var date = monthYear(),
            updateYearMonth = date.year + '-' + date.month;
        if ( $.inArray( updateYearMonth, calendarCache ) < 0 ) {
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: 'action=get_events&date=' + updateYearMonth,
                dataType:"json",
                beforeSend: function( xhr ) {},
                success: function( data ) {
                    data.forEach(function( event, i, data ) {
                        addEvent( date.year, date.month, data[i] );
                    });
                    calendarCache.push( updateYearMonth );
                }
            });
        }
    }

    updateEvents();
});
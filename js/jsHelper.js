$(document).ready(function() {
    $(function() {
        $.datepicker.setDefaults($.datepicker.regional[ "pl" ]);
        $("#dateFrom").datepicker({
            autoSize: true, // automatically resize the input field 
            minDate: new Date(), // prevent selection of date older than today
            dateFormat: "d MM yy",
            closeText: 'Zamknij',
            prevText: '&#x3c;Poprzedni',
            nextText: 'Następny&#x3e;',
            currentText: 'Dziś',
            monthNames: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec',
                'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
            monthNamesShort: ['Sty', 'Lu', 'Mar', 'Kw', 'Maj', 'Cze',
                'Lip', 'Sie', 'Wrz', 'Pa', 'Lis', 'Gru'],
            dayNames: ['Niedziela', 'Poniedzialek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'],
            //dayNamesShort: ['Nie', 'Pn', 'Wt', 'Śr', 'Czw', 'Pt', 'So'], it doesnt work
            dayNamesMin: ['Nd', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'Sb'],
            //beforeShowDay: $.datepicker.noWeekends, // Disable selection of weekends
            firstDay: 1 // Start with Monday
                    //showOn: "button",
                    //buttonImage: "img/DatePickerIcon.gif",
                    //buttonImageOnly: true

//showOn: 'button',
// Show a button next to the text-field
//        altFormat: 'dd-mm-yy', // Date Format used
//        //constrainInput: true, // prevent letters in the input field

        });
        var disabledDays = ["5-21-2013"];
        $("#dateTo").datepicker({
            autoSize: true, // automatically resize the input field 
            minDate: new Date(), // prevent selection of date older than today
            dateFormat: "d MM yy",
            closeText: 'Zamknij',
            prevText: '&#x3c;Poprzedni',
            nextText: 'Następny&#x3e;',
            currentText: 'Dziś',
            monthNames: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec',
                'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
            monthNamesShort: ['Sty', 'Lu', 'Mar', 'Kw', 'Maj', 'Cze',
                'Lip', 'Sie', 'Wrz', 'Pa', 'Lis', 'Gru'],
            dayNames: ['Niedziela', 'Poniedzialek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'],
            //dayNamesShort: ['Nie', 'Pn', 'Wt', 'Śr', 'Czw', 'Pt', 'So'], it doesnt work
            dayNamesMin: ['Nd', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'Sb'],
            //beforeShowDay: $.datepicker.noWeekends, // Disable selection of weekends
            //beforeShowDay: disabledDays, // Disable selection of weekends
            firstDay: 1 // Start with Monday
//            showOn: "button",
//            buttonImage: "img/DatePickerIcon.gif",
//            buttonImageOnly: true

//showOn: 'button',
// Show a button next to the text-field
//        altFormat: 'dd-mm-yy', // Date Format used
//        //constrainInput: true, // prevent letters in the input field

        });

        $("#cancelReservationLink").click(function() {
            $("#cancelReservationPanel").slideToggle(600);
            //$("#cancelReservationPanel").fadeIn(600);
            $('#cancelReservationPanel input').blur(function()
            {
                if (!$(this).val()) {
                    $(".error_text").fadeIn(600);
                    //$(this).parents('p').addClass('warning');
                }
            });
        });
    });
});
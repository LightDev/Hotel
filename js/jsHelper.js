$(document).ready(function() {
    $(function() {
        //$("#dateFrom").load(function() {

        //});
        $(function() {
            $('#dateFrom').datepicker("setDate", new Date());
            var dateFrom = $('#dateFrom').datepicker('getDate');
            var dayFrom = dateFrom.getDate();
            var monthFrom = $('#dateFrom').datepicker('getDate').getMonth() + 1;
            var yearFrom = $('#dateFrom').datepicker('getDate').getFullYear();
            $('#dateTo').datepicker("setDate", new Date(yearFrom, monthFrom - 1, dayFrom + 1));
            if (dayFrom < 10)
                dayFrom = "0" + dayFrom;
            if (monthFrom < 10)
                monthFrom = "0" + monthFrom;
            var fullDateFrom = yearFrom + "-" + monthFrom + "-" + dayFrom;
            var fullDateTo = yearFrom + "-" + monthFrom + "-" + (parseInt(dayFrom) + 1);
            //str_output = fullDate;
            document.reservationForm.dateFromHidden.value = fullDateFrom;
            document.reservationForm.dateToHidden.value = fullDateTo;

        });
        $.datepicker.setDefaults($.datepicker.regional[ "pl" ]);
        $("#dateFrom").datepicker({
            autoSize: true, // automatically resize the input field 
            minDate: new Date(), // prevent selection of date older than today
            dateFormat: "d MM yy",
            //dateFormat: "dd-mm-yy",
            closeText: 'Zamknij',
            numberOfMonths: 2,
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
            firstDay: 1, // Start with Monday
            onSelect: function(dateText, inst) {
//                var dateAsString = dateText; //the first parameter of this function
//                var dateAsObject = $(this).datepicker('getDate'); //the getDate method
                var dateFrom = $(this).datepicker('getDate');
                var dayFrom = dateFrom.getDate();
                var monthFrom = $(this).datepicker('getDate').getMonth() + 1;
                var yearFrom = $(this).datepicker('getDate').getFullYear();
                $('#dateTo').datepicker("setDate", new Date(yearFrom, monthFrom - 1, dayFrom + 1));
                if (dayFrom < 10)
                    dayFrom = "0" + dayFrom;
                if (monthFrom < 10)
                    monthFrom = "0" + monthFrom;
                var fullDateFrom = yearFrom + "-" + monthFrom + "-" + dayFrom;
                var fullDateTo = yearFrom + "-" + monthFrom + "-" + (parseInt(dayFrom) + 1);
                //str_output = fullDate;
                document.reservationForm.dateFromHidden.value = fullDateFrom;
                document.reservationForm.dateToHidden.value = fullDateTo;

                var dateTo = $('#dateTo').datepicker('getDate');
                var dayTo = dateTo.getDate();
                var monthTo = $('#dateTo').datepicker('getDate').getMonth() + 1;
                var yearTo = $('#dateTo').datepicker('getDate').getFullYear();
                if (dayFrom >= dayTo && monthFrom >= monthTo && yearFrom >= yearTo) {
                    //$('#dateFrom').datepicker('setDate', $dateFrom).datepicker("option", 'minDate', $dateFrom);
                    $('#dateTo').datepicker('setDate', dateFrom).datepicker("option", 'minDate', dateFrom);
                }


                //alert(str_output);
            },
            onClose: function() {
                //$(this).focus();
            }

        });
        $('#dateFrom').datepicker().datepicker("setDate", new Date()); // Date equals December 1, 2011.

        //var disabledDays = ["5-21-2013"];
        $("#dateTo").datepicker({
            autoSize: true, // automatically resize the input field 
            minDate: new Date(), // prevent selection of date older than today
            dateFormat: "d MM yy",
            numberOfMonths: 2,
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
            firstDay: 1, // Start with Monday
            onSelect: function(dateText, inst) {

                var dateTo = $(this).datepicker('getDate');
                var dayTo = dateTo.getDate();
                if (dayTo < 10)
                    dayTo = "0" + dayTo;
                var monthTo = $(this).datepicker('getDate').getMonth() + 1;
                if (monthTo < 10)
                    monthTo = "0" + monthTo;
                var yearTo = $(this).datepicker('getDate').getFullYear();
                var fullDate = yearTo + "-" + monthTo + "-" + dayTo;
                document.reservationForm.dateToHidden.value = fullDate;

                var dateFrom = $('#dateFrom').datepicker('getDate');
                var dayFrom = dateFrom.getDate();
                var monthFrom = $('#dateFrom').datepicker('getDate').getMonth() + 1;
                var yearFrom = $('#dateFrom').datepicker('getDate').getFullYear();
                if (dayFrom <= dayTo && monthFrom <= monthTo && yearFrom <= yearTo) {
                    $('#dateFrom').datepicker('setDate', dateTo).datepicker("option", 'minDate', dateTo);
                    // $('#dateTo').datepicker('setDate', $dateFrom).datepicker("option", 'beforeShowDay', $dateFrom);
                }

            }
//            onLoad: function() {
//                alert('lol');
//                $("#dateTo").datepicker();
//                $("#dateTo").datepicker("setDate", "+1d");
//
//            }
        });
//        $("#dateTo").load(function() {
//            alert('lol');
//            $("#dateTo").datepicker();
//            $("#dateTo").datepicker("setDate", "+1d");
//
//        });

//        var $endDate = $('#dateFrom').datepicker('getDate');
//        $endDate.setDate($endDate.getDate() + 1);
//        $('#dateTo').datepicker('setDate', $endDate).datepicker("option", 'minDate', $endDate);
        //$('#dateTo').datepicker().datepicker("setDate", new Date($endDate.getDate())); // Date equals December 1, 2011.

        $("#resevationSubmit").click(function() {
            document.forms["reservationForm"].submit();
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


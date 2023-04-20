new Lightpick({
 field: document.getElementById('lesson_time_Start'),
 secondField: document.getElementById('lesson_time_End'),
 minDate: moment().startOf('month').add(7, 'day'),
 singleDate: false,
 format: 'YYYY-MM-DD'
});
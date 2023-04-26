
const time = Date.now();
const today = new Date(time);
new Lightpick({
 field: document.getElementById('lesson_time_Start'),
 secondField: document.getElementById('lesson_time_End'),
 minDate: today.toISOString(),
 singleDate: false,
 format: 'YYYY-MM-DD'
});

$(document).ready(function(){
 $('.timepicker').mdtimepicker({
  timeFormat: 'hh:mm:ss.000',
  theme:'blue',
  format:'hh:mm',
  readOnly: false,
  is24hour: true,
 });

});

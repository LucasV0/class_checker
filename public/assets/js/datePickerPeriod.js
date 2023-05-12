const time = Date.now();
const today = new Date(time);
new Lightpick({
    field: document.getElementById('period_Period_Start'),
    secondField: document.getElementById('period_Period_End'),
    minDate: today.toISOString(),
    singleDate: false,
    format: 'DD/MM/YYYY',
});
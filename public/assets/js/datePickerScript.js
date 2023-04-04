const start = datepicker('.some-start', { id: 1,
    formatter: (input, date, instance) => {
        const value = date.toLocaleDateString()
        input.value = value // => '1/1/2099'
    } })
const end = datepicker('.some-end', { id: 1,
    formatter: (input, date, instance) => {
        const value = date.toLocaleDateString()
        input.value = value // => '1/1/2099'
    } })

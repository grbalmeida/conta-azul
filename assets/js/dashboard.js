$(function() {
    const firstReport = new Chart($('#first_report'), {
        type: 'line',
        data: {
            labels: daysList, // horizontal
            datasets: [{
                label: 'Receitas',
                data: revenue, // vertical
                fill: false, // Preenchimento apenas da linha
                backgroundColor: '#0000ff',
                borderColor: '#0000ff'
            }, {
                label: 'Despesas',
                data: expenses,
                fill: false,
                backgroundColor: '#ff0000',
                borderColor: '#ff0000'
            }]
        }
    })

    const secondReport = new Chart($('#second_report'), {
        type: 'pie',
        data: {
            labels: ['Aguardando Pagamento', 'Pago', 'Cancelado'],
            datasets: [{
                data: paymentOptionsValues,
                backgroundColor: ['#ffce56', '#36a2eb', '#ff6384']
            }]
        }
    })
})
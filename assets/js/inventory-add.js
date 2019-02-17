$(function() {
    $('[data-number]').mask('0#')
    $('[data-price]').mask('000.000.000.000.000,00', {reverse: true})
})
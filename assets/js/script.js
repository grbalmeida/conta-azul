$(function() {
    $('.tab-item').on('click', function() {
        $('.active-tab').removeClass('active-tab')
        $(this).addClass('active-tab')
        const item = $('.active-tab').index()
        $('.tab-body').hide()
        $('.tab-body').eq(item).show()
    })
    $('.tab-body').eq(0).show()
})
$(function() {
    $('.tab-item').on('click', function() {
        $('.active-tab').removeClass('active-tab')
        $(this).addClass('active-tab')
        const item = $('.active-tab').index()
        $('.tab-body').hide()
        $('.tab-body').eq(item).show()
    })
    $('.tab-body').eq(0).show()

    $('[data-search]').on('focus', function() {
        $(this).animate({
            'max-width': '300px'
        })
    })

    $('[data-search]').on('blur', function() {
        if ($(this).val().length === 0) {
            $(this).animate({
                'max-width': '200px'
            })
        }
        
        setTimeout(() => {
            $('.search_results').hide()
        }, 500)
    })

    $('[data-search]').on('keyup', function() {
        const dataType = $(this).attr('data-type')
        const query = $(this).val()
        
        if(dataType && query.trim().length > 0) {
            $.ajax({
                url: `${BASE_URL}/ajax/${dataType}`,
                type: 'GET',
                data: {query},
                dataType: 'json',
                success: function(response) {
                    if(!$('.search_results').length > 0) {
                        $('[data-search]').after('<div class="search_results"></div>')
                    }

                    $('.search_results').css('left', `${$('[data-search]').offset().left}px`)
                    $('.search_results').css('top', 
                        `${$('[data-search]').offset().top + $('[data-search]').height() + 10}px`)

                    let html = ''

                    response.forEach(result => {
                        html += `<div class="search_item">
                                    <a href="${result.link}">${result.name}</a>
                                </div>`
                    })

                    $('.search_results').html(html)
                    $('.search_results').show()
                }
            })
        }
    })
})
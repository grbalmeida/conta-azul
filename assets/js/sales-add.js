function selectCustomer(obj) {
    const id = $(obj).attr('data-user-id')
    const name = $(obj).html()

    $('.search_results').hide()
    $('[name="customer_name"]').val(name)
    $('[name="customer_name"]').attr('data-user-id', id)
    $('[name="customer_id"]').val(id)
}

$(function() {
    $('[data-add-customer]').on('click', function(e) {
        e.preventDefault()
        const name = $('[data-search-customer-sale]').val()

        if(name.trim().length > 4) {
            if(confirm(`Você deseja adicionar um cliente com o nome ${name}?`)) {
                $.ajax({
                    url: `${BASE_URL}/ajax/add_customer`,
                    type: 'POST',
                    data: {name},
                    dataType: 'json',
                    success: function(response) {
                        $('.search_results').hide()
                        $('[name="customer_name"]').attr('data-user-id', response.id)
                        $('[name="customer_id"]').val(response.id)
                    }
                })
            }            
        }
    })

    $('[data-search-customer-sale]').on('keyup', function() {
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
                        $('[data-search-customer-sale]').after('<div class="search_results"></div>')
                    }

                    $('.search_results').css('left', `${$('[data-search-customer-sale]').offset().left}px`)
                    $('.search_results').css('top', 
                        `${$('[data-search-customer-sale]').offset().top + $('[data-search-customer-sale]').height() + 10}px`)

                    let html = ''

                    response.forEach(result => {
                        html += `<div class="search_item">
                                    <a 
                                        href="javascript:;" 
                                        data-user-id=${result.id}
                                        onclick="selectCustomer(this)">${result.name}</a>
                                </div>`
                    })

                    $('.search_results').html(html)
                    $('.search_results').show()
                }
            })
        }
    })
})
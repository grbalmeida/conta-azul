$(function() {
    $('input[name="phone"]').mask('(00) 00000-0000');
    $('input[name="zipcode"]').mask('00000-000')
    $('input[name="number"]').mask('0#')
    $('input[name="zipcode"]').on('blur', function() {
        const zipcode = $(this).val().trim().replace(/\D/g, '')

        if(zipcode.length === 8) {
            clearFields('address', 'state', 'country', 'neighborhood')
            $.ajax({
                url: `http://api.postmon.com.br/v1/cep/${zipcode}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if(response.cidade) {
                        $('input[name="address"]').val(response.logradouro)
                        $('input[name="city"]').val(response.cidade)
                        $('input[name="state"]').val(response.estado_info.nome)
                        $('input[name="country"]').val('Brasil')
                        $('input[name="neighborhood"]').val(response.bairro)
                        $('input[name="number"]').focus()
                    }
                } 
            })
        }
    })

    function clearFields(...params) {
        params.forEach(param => $(`input[name="${param}"]`).val(''))
    }
})
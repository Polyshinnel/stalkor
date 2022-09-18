$('#search-history').on('keyup', function(event) {
    var search = $(this).val();

    if ((search != '') && (search.length > 3)){
        $.ajax({
            type: "POST",
            url: "/searchProducts",
            data: {
                'query': search,
                'pathname': window.location.pathname
            },
            success: function(msg){
                if(msg != '' || msg != '[]' || msg != 'null'){
                    var json = $.parseJSON(msg);
                    console.log(json)
                    $('.page-table__units-wrapper').empty();
                    for(var i = 0; i < json.length;i++){
                        var htmlBlock = '<div class="page-table__unit"><div class="page-table__unit-favorite" data-id="'+json[i].product_id+'" data-favorite="'+json[i].favorite+'"><svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.97895 9.85263C7.24737 10.1211 7.73684 10.1211 8.00526 9.85263L10.8474 7.01053C11.1316 6.72632 11.1316 6.26842 10.8474 5.98421C10.5632 5.7 10.1053 5.7 9.82105 5.98421L7.5 8.30526L5.17895 5.98421C5.03684 5.84211 4.84737 5.76316 4.65789 5.76316C4.46842 5.76316 4.27895 5.84211 4.13684 5.98421C3.85263 6.26842 3.85263 6.72632 4.13684 7.01053L6.97895 9.85263Z" fill="#8B83BA"/><path d="M7.5 15C11.6368 15 15 11.6368 15 7.5C15 3.36316 11.6368 0 7.5 0C3.36316 0 0 3.36316 0 7.5C0 11.6368 3.36316 15 7.5 15ZM7.5 1.45263C10.8316 1.45263 13.5474 4.16842 13.5474 7.5C13.5474 10.8316 10.8316 13.5474 7.5 13.5474C4.16842 13.5474 1.45263 10.8316 1.45263 7.5C1.45263 4.16842 4.16842 1.45263 7.5 1.45263Z" fill="#8B83BA"/></svg></div><a href="/products/'+json[i].product_id+'" class="page-table__unit-link"><div class="page-table__unit-img"><img src="'+json[i].picture+'"></div></a><a href="/products/'+json[i].product_id+'" class="page-table__unit-link"><p class="page-table__unit-name">'+json[i].name+'</p></a><p class="page-table__unit-sku">'+json[i].vendor_code+'</p><p class="page-table__unit-brand">'+json[i].vendor+'</p><p class="page-table__unit-price">'+json[i].price+'</p><p class="page-table__unit-quantity">'+json[i].quantity+'</p><p class="page-table__unit-sold">'+json[i].quantity_sold+'</p><p class="page-table__unit-groupSoldQuant">'+json[i].group_quantity+'</p><p class="page-table__unit-groupSoldPrice">'+json[i].group_price+'</p></div>'
                        $('.page-table__units-wrapper').append(htmlBlock);
                    }
                }
            }
        });
    }

    if(((event.originalEvent.code == 'Backspace') || (event.originalEvent.code == 'Delete')) && (search.length<1)){
        location.reload();
    }
});


$('.show-pass').click(function(){
    var type = $(this).parent().find('input').attr('type');
    if(type == 'password')
    {
        $(this).parent().find('input').attr('type','text');
    }
    else
    {
        $(this).parent().find('input').attr('type','password');
    }
});

$('.auth-btn').click(function(){
    var login = $('#user-login').val();
    var pass = $('#user-pass').val();

    $.ajax({
        type: "POST",
        url: "/authUser",
        data: {
            'username': login,
            'password': pass
        },
        success: function(msg){
            if(msg != 'AuthSuccess'){
                $('.error-msg').html(msg);
            }else{
                var url = '/';
                window.location.href = url;
            }
        }
    });
})


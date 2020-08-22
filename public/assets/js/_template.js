$('.load-more').on('click', function(event) {
    
    // get target path
    var target = $(this).attr("data-target");
    var value = $(this).attr("data-value");

    if(!target) {
        alert('Error: target attribute not defined. Please define target attribute.');
        return false;
    } 

    var route = $("#"+target).attr('data-route');

    if(!route) {
        alert('Error: route not defined.');
        return false;
    }

    $.ajax({
        type: "POST",
        data : { 'v':value },
        url : route,
        beforeSend: function() {
           $(".backDrop").fadeIn( 100, "linear" );
           $(".loader").fadeIn( 100, "linear" );
        },
        success:function(data, textStatus, jqXHR)
        {
            if ( data != '' ) 
            {
                var obj = jQuery.parseJSON( data );
                if ( obj.status == 1) 
                {
                    if (obj.data != '') 
                    {
                        $('.load-more').attr("data-value", obj.val);
                        $("#"+target).find(".load-more").parent().before(obj.data);
                    }                    
                } else {
                  alert( obj.message );
                }
            }

          setTimeout(function () {
            $(".backDrop").fadeOut( 100, "linear" );
            $(".loader").fadeOut( 100, "linear" );
          }, 80);

        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            $(".backDrop").fadeOut( 100, "linear" );
            $(".loader").fadeOut( 100, "linear" );
            alert('You have ' + errorThrown + ' request cannot processing..');
        }
    });
    return false;
    event.preventDefault(); //STOP default action
    event.unbind(); //unbind. to stop multiple form submit. 
});

$('body').on('click', 'a.dEdit', function(event) { //due to ajax data request with datatable grids

        //path of the route
        var route = $(this).data("route");
        var name = $(this).data("title");
        
        if (!$(this).data("route")) {
            alert('Error: route attribute not defined. Please define route attribute.');
            return false;
        }

        $.ajax({
            type: "GET",
            url : route,
            async : true,
            beforeSend: function()
            {
                $('#dynamicEdit').modal('show');
                $("#dynamicEdit").find("#formTitle").html(name);
                setTimeout(function () {
                    //$('#loader').html() defined in layout before editing model
                    $("#dynamicEdit").find("#dataResult").html($('#loader').html());
                } , 10);
            },
            success:function(data, textStatus, jqXHR)
            {
                $("#dynamicEdit").find("#dataResult").html(data);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                $('#dynamicEdit').modal('hide');
                alert('You have '+ thrownError +', so request cannot processing..'); //alert with HTTP error
            }
        });
    return false;
    event.preventDefault(); //STOP default action
    event.unbind(); //unbind. to stop multiple form submit.
}).ajaxComplete(function () {

    /*$('select').addClass('chosen');
    $('.chosen').chosen({
        disable_search_threshold: 15
    });*/

}).on('click', 'a.toggle-status', function(event) {

    var $this = $(this);
    //path of the route
    var route = $(this).data("route");

    //confirm message
    var message = $(this).data("message");
    var src = $(this).children('img').attr('src');

    var ll = src.length;
    var path = src.substring(-0, Number(ll) - 5);
    
    if (!$(this).data("route")) {
        alert('Error: route attribute not defined. Please define data-route attribute.');
        return false;
    }

    if (!$(this).data("message")) {
        alert('Error: message attribute not defined. Please define data-message attribute.');
        return false;
    }

    $.get(route, function( data ) {
        
        var obj = jQuery.parseJSON( data );        
        if ( obj.status == 1) 
        {
            var imgsrc = obj.data;
            $this.html("<img src='" + path + imgsrc + "' />");
        } else {    
            alert('Internal server error.');
            window.location.reload();
        }

    });
    
}).on('click', 'a.__drop', function(event) {

    var $this = $(this);
    //path of the route
    var route = $(this).data("route");

    //confirm message
    var message = $(this).data("message");

    if (!$(this).data("route")) {
        alert('Error: route attribute not defined. Please define data-route attribute.');
        return false;
    }

    if (!$(this).data("message")) {
        alert('Error: message attribute not defined. Please define data-message attribute.');
        return false;
    }

    if(confirm(message)) {

        $.get(route, function( data ) {
            
            var obj = jQuery.parseJSON( data );
            if( obj.status == 1 ) {
                alert(obj.message);
                window.location.reload();
            } else {
                alert(obj.message);
               window.location.reload();
            }
        });
    }
    
}).on('click', '.check-all', function(event) {

    var checkAll = $(this);
    $('.table .check-one').each(function(){ 

        if(checkAll.val() == '1')
            this.checked = false;
        else
            this.checked = true;

    });

    if(checkAll.val() == '1')
        checkAll.val('0');
    else 
        checkAll.val('1');
}).on('click', '._back', function(event) {
    history.back(1);
});

//always first input be focus.
$('form:first *:input[type!=hidden]:first').focus();

$('select.ajaxChange').on('change', function(event)
{
    var val = $(this).val();
    //work with both the diffrenace is matter performance and speed
    // first one is fastest and very reliable as compare to second one
    // for more info read-out this artical @link

    var target = $(this).data("target"); //$(this).attr("data-target");
    var route = $(this).data("route");   //$(this).attr("data-route");

    if (val != '') {

        if (!$(this).data("target")) {
            alert('Error: target attribute not defined. Please define target attribute.');
            return false;
        }

        if (!$(this).data("route")) {
            alert('Error: route attribute not defined. Please define route attribute.');
            return false;
        }

        $.ajax({
            type: "GET",
            url : route + '/' + val,
            beforeSend: function() {
                //$(".backDrop").fadeIn( 100, "linear" );
                //$(".loader").fadeIn( 100, "linear" );
            },
            success:function(data, textStatus, jqXHR) {
                /*setTimeout(function() {
                 $(".backDrop").fadeOut( 100, "linear" );
                 $(".loader").fadeOut( 100, "linear" );
                 }, 80);*/

                $("#"+target).html(data);
                $(".select2").trigger('select2:updated');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                //$(".backDrop").fadeOut( 100, "linear" );
                //$(".loader").fadeOut( 100, "linear" );
                alert('You have '+errorThrown+' request cannot processing..');
            }
        });
        return false;
        event.preventDefault(); //STOP default action
        event.unbind(); //unbind. to stop multiple form submit.
    }
}).ajaxComplete(function () {

    $('select').addClass('select2');
    $(".select2").select2({
        //placeholder: "Select a State",
        allowClear: true
    });

});

$(function() {

    // lazy load code start
    var loading = false;
    $(window).scroll(function() {

        if ($(window).scrollTop() == $(document).height() - $(window).height()) {

            if(loading == false) {

                // enable the lazy load get dynamic data & render
                var length = $("#lazy-load").length;

                if (length === 1) {

                    // get route path
                    var route = $("#lazy-load").attr("data-route");
                    var value = $("#lazy-load").attr("data-value");
                    var end = $("#lazy-load").attr("data-end");

                    if(!route) {
                        alert('Error: route attribute not defined. Please define data-route attribute.');
                        return false;
                    }
                    if(!value) {
                        alert('Error: value attribute not defined. Please define data-value attribute.');
                        return false;
                    }
                    if(!end) {
                        alert('Error: end attribute not defined. Please define data-end attribute.');
                        return false;
                    }

                    if ( end == 0 ) {

                        $(".backDrop").fadeIn( 100, "linear" );
                        $(".loader").fadeIn( 100, "linear" );

                        loading = true; //prevent further ajax loading

                        //load data from the server using a HTTP POST request
                        $.post(route, {'v': value }, function(data) {
                                           
                            if ( data != '' ) 
                            {
                                var obj = jQuery.parseJSON( data );
                                if ( obj.status == 1) 
                                { 
                                    $('#lazy-load').attr("data-end", obj.end);                                    
                                    if (obj.data != '') 
                                    {
                                        $('#lazy-load').attr("data-value", obj.val);                                        
                                        $("#lazy-load tbody").append(obj.data);
                                    }                                    
                                } else {
                                  alert( obj.message );
                                }
                            }

                            setTimeout(function (){
                                $(".backDrop").fadeOut( 100, "linear" );
                                $(".loader").fadeOut( 100, "linear" );
                            }, 80);

                            loading = false;
                       
                        }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
                           
                            $(".backDrop").fadeOut( 100, "linear" );
                            $(".loader").fadeOut( 100, "linear" );
                            alert('You have '+ thrownError +', so request cannot processing..'); //alert with HTTP error
                            loading = false;
                       
                        });
                    }
                }
            }
        }
    })
    // lazy load code end.

    //Datemask dd-mm-yyyy
    $(".date-mask").inputmask("dd-mm-yyyy");

    //Mobile-mask
    $(".mobile-mask").inputmask("(999)-999-9999", {"placeholder": "(999)-999-9999"});

    //Input-mask
    $("[data-mask]").inputmask();

    // dateticker
    $(".date-picker").datepicker({
        showButtonPanel: false,
        dateFormat: "dd-mm-yy",
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        changeMonth: true,
        changeYear: true,
        //showMonthAfterYear: true,
        defaultDate: new Date()
    });

    $(".date-future").datepicker({
        showButtonPanel: false,
        dateFormat: "dd-mm-yy",
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        changeMonth: true,
        changeYear: true,
        showMonthAfterYear: true,
        minDate: +1
    });

    $(".date-past").datepicker({
        showButtonPanel: false,
        dateFormat: "dd-mm-yy",
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        changeMonth: true,
        changeYear: true,
        showMonthAfterYear: true,
        defaultDate: new Date(1985, 00, 01),
        maxDate: -1
    });

    // select2
    $(".select2").select2({
        //placeholder: "Select a State",
        allowClear: true
    });

    $('.fSelect').fSelect({
        placeholder: '-Select-',
        numDisplayed: 10,
        overflowText: '{n} selected',
        searchText: 'Search',
        showSearch: true
    });

    var h = '250px';
    if ($('[slim-scroll]')) {
        h = $('[slim-scroll]').attr('data-height');
    }
    //slim scroll
    $('[slim-scroll]').slimScroll({
        height: h
    });

    //$('.model').modal();

    /**
     * Function is used to appear confirm dialog box.
     */
    function confirmation(message)
    {
        $.messager.confirm('Confirm', message, function(isConfirm) {
            if(isConfirm) {

            }
        });
    }

    /**
     * Function is used to appear alert dialog box.
     */
    function verify(heading, message, priority)
    {
        $.messager.alert(heading, message, priority);
    }

    //post data for sorting data..
    function sortData(route, data) {
        $.post(route, data, function(response) {
            if(response == 1) {
                $('.sortalert').fadeIn( 250, "linear" );
            }
            setTimeout(function () {
                $('.sortalert').fadeOut( 250, "linear" );
            }, 4000);
        });
    }

    // submit form with ajax
    function submitForm(form, pageNumber, perPage, liveSearch) {
        //var token = $('meta[name="_token"]').attr('content');
        var postData = $(form).serializeArray();    
        var formMethod = $(form).attr("method");
        var formUrl = $(form).attr("action");
        var token = $('meta[name="csrf-token"]').attr('content');

        postData.push(
            { name: 'page', value: pageNumber }, 
            { name: 'perpage', value: perPage },
            { name: '_token', value: token },
            { name: 'keyword', value: liveSearch }
        );

        $.ajax(
        {
            url : formUrl,
            type: formMethod,
            data : postData,
            beforeSend: function() {
                $(".backDrop").fadeIn( 100, "linear" );
                $(".loader").fadeIn( 100, "linear" );
            },
            success:function(data, textStatus, jqXHR)
            {
                if ( data != '' ) 
                {
                    $("#paginate-load").html(data);
                    // for sort records
                    if(sorting) 
                    {
                        // refresh sorting here.
                        $( "table tbody" ).sortable({ update: function() {
                            var order = $(this).sortable("serialize") + '&update=update';
                                sortData(sorting, order);
                            } 
                        });
                    }
                }
                setTimeout(function (){
                    $(".backDrop").fadeOut( 100, "linear" );
                    $(".loader").fadeOut( 100, "linear" );
                }, 80);
            },
            error: function(jqXHR, textStatus, thrownError)
            {
                $(".backDrop").fadeOut( 100, "linear" );
                $(".loader").fadeOut( 100, "linear" );
                alert('You have '+ thrownError +', so request cannot processing..'); //alert with HTTP error
            }
        });
        return false;
    }

    var ajaxFilter = $("#ajaxForm").length;

    //Filter form onsubmit function
    $("#ajaxForm").submit(function() {
        submitForm("#ajaxForm", "", "", "");
        return false;    
    });

    // enable the paginate load get dynamic data & render
    var length = $("#paginate-load").length;
    if (length === 1) {
        
        // get route path
        var route = $("#paginate-load").attr("data-route");
        var sorting = $("#paginate-load").attr("data-sorting");

        if(!route) {
            alert('Error: route attribute not defined. Please define data-route attribute.');
            return false;
        }

        //ajax pagination code start
        function loadData(page, perpage, liveSearch) {

            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax
            ({
                type: "POST",
                data : {'_token' : token, 'page': page, 'perpage': perpage, 'keyword': liveSearch},
                url: route,
                beforeSend: function() {
                    $(".backDrop").fadeIn( 100, "linear" );
                    $(".loader").fadeIn( 100, "linear" );
                },
                success: function(data)
                {
                    if ( data != '' ) {
                        $("#paginate-load").html(data);
                        //for sort news
                        if(sorting) {
                            // refresh sorting here.
                            $( "table tbody" ).sortable({ update: function() {
                                    var order = $(this).sortable("serialize") + '&update=update'+ '&_token=' + token;
                                    sortData(sorting, order);
                                } 
                            });
                        }
                    }
                    setTimeout(function (){
                        $(".backDrop").fadeOut( 100, "linear" );
                        $(".loader").fadeOut( 100, "linear" );
                    }, 40);
                },
                error: function(jqXHR, textStatus, thrownError) {
                    $(".backDrop").fadeOut( 100, "linear" );
                    $(".loader").fadeOut( 100, "linear" );
                    alert('You have '+ thrownError +', so request cannot processing..'); //alert with HTTP error
                }
            });
        }

        loadData(1, '', '');  // For first time page load default results
        $('body').on('click', '.pagination li._paginate', function() {
            var page = $(this).attr('p');
            var livSearch = $('.live-search').val();
            var perPage = parseInt($('#per-page').val());

            if (ajaxFilter === 1) {
                submitForm("#ajaxForm", page, perPage, livSearch);
            } else {
                loadData(page, perPage, livSearch);
            }
        });

        $('body').on('keyup', 'input.live-search', function (event) {
            var livSearch = $(this).val();
            var perPage = parseInt($('#per-page').val());
            if (livSearch.length % 2 == 0) {
                if (ajaxFilter === 1) {
                    submitForm("#ajaxForm", 1, perPage, livSearch);
                } else {
                    loadData(1, perPage, livSearch);
                }
            }
        });
        $('body').on('change', '#per-page', function() {
            var livSearch = $('.live-search').val();
            var perPage = parseInt($(this).val());

            if (ajaxFilter === 1) {
                submitForm("#ajaxForm", 1, perPage, livSearch);
            } else {
                loadData(1, perPage, livSearch);
            }
        });

        $('body').on('click', '#go_btn', function() {
            var page = parseInt($('.goto').val());
            var livSearch = $('.live-search').val();
            var perPage = parseInt($('#per-page').val());
            var noOfPages = parseInt($('._total').html());
            if (page != 0 && page <= noOfPages) {

                if (ajaxFilter === 1) {
                    submitForm("#ajaxForm", page, perPage, livSearch);
                } else {
                    loadData(page, perPage, livSearch);
                }

            } else {
                alert('Enter a page between 1 and ' + noOfPages);
                $('.goto').val("").focus();
                return false;
            }
        });
    }

    var isRequestSent = false;
    $('#ajax-save').ajaxForm({
        delegation: true,
        statusCode: {
            400: function() {

            },
            500: function() {
                alert('An internal error has occurred. Click OK to reload page.')
                window.location.reload();
            }
        },
        beforeSend: function() {
            if (isRequestSent === true) {
                return false;
            } else {
                isRequestSent = true;
                $(".backDrop").fadeIn( 100, "linear" );
                $(".loader").fadeIn( 100, "linear" );
            }
        },
        success: function(r) {
            $('.ajax-right-sidebar').html(r);
        },
        success:function(data, textStatus, jqXHR)
        {
            if (data != '') 
            {
                $("#paginate-load").html(data);
                // for sort records
                if(sorting) 
                {
                    // refresh sorting here.
                    $( "table tbody" ).sortable({ update: function() {
                        var order = $(this).sortable("serialize") + '&update=update';
                            sortData(sorting, order);
                        } 
                    });
                }
            }
            setTimeout(function (){
                $(".backDrop").fadeOut( 100, "linear" );
                $(".loader").fadeOut( 100, "linear" );
            }, 80);
        }
    });
});


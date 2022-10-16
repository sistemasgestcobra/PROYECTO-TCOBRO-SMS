/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var ajaxInProgress = false;
 var main_path = $('#main_path').val(),
     numdecimales = 3,
     ivaporcent = 12,
     userid = $('#userid').val(),
     valorcero = 0;
     valorcero = valorcero.toFixed(numdecimales),
     csrf_name = $("#sec_csrf_token").attr('name'),
     csrf_value = $("#sec_csrf_token").val();

function alertaError(message, title){
    toastr8["error"](message, "Alerta");
}
function alertaExito(message, title){
    toastr8["success"](message, "Alerta");
}

var optprint1 = { debug: false, importCSS: true, printContainer: true, loadCSS: main_path+"resources/css/allstyles.css", removeInline: false };
        function printelem(){
//            $(document).on("click", 'input[id ^= autosuggest]', function(e) {            
            $(document).on("click", "[id ^= printbtn]", function(event){
                var elem = $(this).attr('data-target');
                $("#"+elem).printThis(                        
                    optprint1
                );
            });
        }


    function conservarValoresNoEditables(elem){
        var valprevio = 1;
        $(document).delegate(elem,'focus',function(){
            valprevio = $(this).val();
        }).delegate(elem,'change keyup keydown',function(){
            $(this).val(valprevio);
            toastr8["info"]("Accion no permitida!!", "Cuidado");
            $(elem).attr("disabled", true);
        });
        return false;
    }

function getNumericVal(elem,type){
    var newval,
        elemval = $.trim($(elem).val());
        elemval = elemval.replace(',',''); //para que maneje bien los miles
    if(isNaN(elemval) || elemval==''){
        newval = 0;
    }else{
        if(type == 'float'){
            newval = parseFloat(elemval);
        }
        if(type == 'int'){
            newval = parseInt(elemval);
        }
    }
    return newval;
}

function sumarValues(values, tipo){
    var totalsuma = 0;    
    if(tipo == 'float'){
        $.each(values, function(index, value) {
            totalsuma+=parseFloat(value);
        });
    }
    if(tipo == 'int'){
        $.each(values, function(index, value) {
            totalsuma+=parseInt(value);
        });
    }    
    return parseFloat(totalsuma);
//    return getMoneyFormatted(totalsuma);
}

function getNumericAttr(elem,attrname,type){
    var newval,
        elemval = $.trim($(elem).attr(attrname)); 
        elemval = elemval.replace(',',''); //para que maneje bien los miles
    if(type == 'float'){
      newval = parseFloat(elemval);
//      newval = getMoneyFormatted(newval);
    }
    if(type == 'int'){
      newval = parseInt(elemval);
    }
    return newval;    
}

function checkLength( o, n, min, max ) {
        if ( o.val().length > max || o.val().length < min ) {
                toastr8["info"]("Longitud no permitida!!", "Validacion");                             
                    o.parent('div').addClass("has-error");
                return false;
        } else {
                o.parent('div').removeClass("has-error");
    //          o.removeClass("ui-state-error");
                return true;
        }
}

function getResponseNewAction(data){
    if(data.ok > 0){
       /* $('.top-right').notify({
        message: {text: 'El proceso se ha completado correctamente'}, type: 'success', fadeOut: {delay: 3500}
        }).show();*/
        $.scojs_message('El proceso se ha completado correctamente', $.scojs_message.TYPE_OK);
    }else{
       /* $('.top-right').notify({
        message: {text: 'No se ha podido completar el proceso!'}, type: 'warning', fadeOut: {delay: 3500}
        }).show();*/
        // e.preventDefault();
        $.scojs_message('No se ha podido completar el proceso', $.scojs_message.TYPE_ERROR);
    }
}

function remove_wait_msg(){
    $('#'+outputelem).next('div #msg_wait').remove()
}

function processJson(data) { 
    // 'data' is the json object returned from the server 
//    $('#clientslistout').html(data.html);
//alert(data.responseHeader.QTime);
}

//var progress_bar = '<div class="progress"> <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"> <span class="sr-only">45% Complete</span> </div></div>';        
var progress_bar = '<img alt="..." src="'+main_path+"assets/images/ajax-loader.gif"+'" />';
function loadFormAjax(){
    $(document).on("click", '#ajax_json_btn', function(e) {
        if(ajaxInProgress) {
            console.log("CUIDADO DETENGASE");
            e.preventDefault();
            return false;
        }else{
            var form = $(this).parents('form');
            $(form).ajaxForm({ 
                // dataType identifies the expected content type of the server response 
                dataType:  'json', 

                // success identifies the function to invoke when the server response 
                // has been received 
                success:   processJson,
                resetForm: true
            });             
        }
    });
    
    $(document).on("click", '#ajaxformbtn', function(e) {
            if(ajaxInProgress) {
                toastr8["info"]("Hay otro proceso ejecutandose en este momento!", "Cuidado");
                console.log("Hay otro proceso ejecutandose en este momento!");
                return false;
            }else{
                
                var outputelem = $(this).attr('data-target'),
                    clearForm = $(this).attr('clear-form'),
                    resetForm = $(this).attr('reset-form');

                if( resetForm == '0' ){
                    resetForm = false;
                }

                if(clearForm == null || clearForm == 'undefined' || clearForm == '' || clearForm == 'false' || clearForm == '0'){
                    clearForm = false;
                }

//alert($(this).val());
                $("#"+outputelem).html(progress_bar);
                    var form = $(this).parents('form');
                    $(form).ajaxForm({
                        target: "#"+outputelem,
                        clearForm : clearForm,
                        resetForm: resetForm
                    });
            }
        });
    
    $(document).on("click", '#ajaxformurl', function(e) {
        var outputelem = $(this).attr('data-target'),
            url = $(this).attr('data-url');
        $("#"+outputelem).html(progress_bar);        
            var form = $(this).parents('form');
            $(form).ajaxForm({
    //            beforeSubmit : validateNewBoleto,
                url: url,
                target: "#"+outputelem
            });
    });    
    
    $(document).on("click", '#ajaxformbtn2', function(e) {
        var form = $(this).parents('form'),outputelem = $(this).attr('data-target');
        if(outputelem != '' && outputelem != 'undefined' || outputelem != null){
            $("#"+outputelem).html(progress_bar);
                $(form).ajaxSubmit({target: "#"+outputelem});            
        }else{
            $(form).ajaxSubmit();            
        }
        return false;
    }); 
    
    $(document).on("click", "#ajaxformbtn3", function(e) {
        var objThis = $(this);
        var outputelem = objThis.attr('data-target');        
        bootbox.confirm("<h2><span class='glyphicon glyphicon-question-sign'></span>&nbsp;Seguro que desea realizar esta operacion?</h2> <h4 class='text-info'>No se podra anular los cambios</h4>", function(result) {
            if(result){
                var form = $(objThis).parents('form');
                $(form).ajaxSubmit({target: "#"+outputelem});
            
            }
        }); 
    });    
    
    /* 
     * cargamos mediante ajax sin necesidad que este dentro de un form 
     * lo unico q el elemento debe tener es el atributo data-id
     * sobre el cual se ejecutara una funcion desde php
    */
       $(document).on("click", "#ajaxidbtn", function(e) {
           var rowid = $(this).attr('rowid'),
               url = $(this).attr('data-url'),
               datatarget = $(this).attr('data-target');
            $.ajax({
                type: "POST",
                url: url,
                data: { rowid: rowid },       
                success: function(html){
                    $(datatarget).html(html);
                },
                error: function(){
                    toastr8["info"]("Error!! No se pudo alcanzar el archivo de proceso", "Error");
                }              
            });
            return false;
       });
    /* 
        * igual que el anterior, solo que este comprueba si ya tiene
        * algo en el div, no hace la llamada ajax
    */
       $(document).on("click", "#ajaxidbtn2", function(e) {
           var rowid = $(this).attr('rowid'),
               url = $(this).attr('data-url'),
               datatarget = $(this).attr('data-target');
               var htmltarget = $.trim($(datatarget).html());
               if(htmltarget == '' || htmltarget == 'undefined' || htmltarget == null){
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: { rowid: rowid },       
                        success: function(html){
                            $(datatarget).html(html);
                        },
                        error: function(){
                            toastr8["info"]("Error!! No se pudo alcanzar el archivo de proceso", "Error");
                        }              
                    });                   
               }

//            .done(function( msg ) {
//                alert( "Data Saved: " + msg );
//            });           
       });
    
    /* este no reemplaza el contenido, sino que lo adjunta al que ya existe */
       $(document).on("click", "#ajax_append_btn", function(e) {
           var rowid = $(this).attr('rowid'),
               url = $(this).attr('data-url'),
               datatarget = $(this).attr('data-target'),
               append_to = $(this).attr('myself');
               
               if(append_to != 'undefined' && append_to != null && append_to != ''){
                   //alert("buscando valor de myself");
                   datatarget = $(this).parents(datatarget);
               }
               
            var dataObject = {};
            dataObject['action'] = 'call_this';        
            dataObject[csrf_name] = csrf_value;       
            $.ajax({
                type: "POST",
                url: url,
                data: dataObject,       
                success: function(html){
                    $(datatarget).append(html);
                },
                error: function(){
                    toastr8["info"]("Error!! No se pudo alcanzar el archivo de proceso", "Error");                    
                }              
            });
            return false;
       });    
    
    return false;
}

    
    $.input_autosuggest = function(e) {        
      $(document).on("focus", 'input[id ^= autosuggest_]', function(e) {
            var objThis = $(this);
            objThis.show();
            var callbackFunction = $(this).attr('callback'),
                minLength = $(this).attr('min-length');
            $(this).select2({
//                placeholder: "Select a State",
                allowClear: true,
                minimumInputLength: minLength,    
                ajax: {
                    dataType: "json",
                    url: objThis.attr('data-url'),
                    quietMillis: 250,        
                    data: function( term, page ) {
                            return {
                                    // search term
                                    q: term
                            };
                    },             

                    results: function (data) {
                        return {results: data};
                    },
                    cache: true   
                },
                    initSelection: function( element, callback ) {
                            // the input tag has a value attribute preloaded that points to a preselected repository's id
                            // this function resolves that id attribute to an object that select2 can render
                            // using its formatResult renderer - that way the repository name is shown preselected
                            var id = $( element ).val();
                            if ( id !== "" ) {
                                    $.ajax( objThis.attr('data-url') +'?q='+id, {
                                            dataType: "json"
                                    }).done( function( data ) {
//                                        console.log("El ID es: "+JSON.stringify(data[0]));
                                            callback( data[0] );
//                                            window[callbackFunction](data);
//                                            console.log("El ID es: "+data.text);
//                                            console.log(data[0].text);
//                                            return data[0].text;
                                    });
                            }
                    },
                    formatSelection:  function( item ) {
                        if(callbackFunction != null && callbackFunction != "" && callbackFunction != "undefined"){
                            window[callbackFunction](item);                                  
                        }
                        return item.text;
                    },
                    // apply css that makes the dropdown taller
                    dropdownCssClass: "bigdrop",   
                    // we do not want to escape markup since we are displaying html in results
                    escapeMarkup: function( m ) {
                            return m;
                    }                    
            });                             
            });     
            
            $('input[id ^= autosuggest_]').focus();    
    
    };

$.callPHPFunction = function( elemclick ){
    var elemclickgeneric = '#call-php';
    if(!elemclick) {
        elemclick = elemclickgeneric;
    }

    $(document).on('click', elemclick, function(e){
        var url = $.trim($(this).attr('php-function')),
        // title = $.trim($(this).attr('title')),
        elemoutput = $.trim($(this).attr('data-target'));  
        
        var dataObject = {};
        dataObject['action'] = 'call_this';        
        dataObject[csrf_name] = csrf_value;
      $.ajax({
           type: "POST",
           url: url,
           data: dataObject,
           success:function(html) {
             $("#"+elemoutput).html(html);
           }
      });
    });    
};

    var submitFormOpt = { 
        target:        '#messagesout',   // target element(s) to be updated with server response 
//        beforeSubmit:  showRequest,  // pre-submit callback 
//        success:       showResponse  // post-submit callback 
 
        // other available options: 
        //url:       url         // override for form's 'action' attribute 
        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
          dataType:  'json',
        //clearForm: true        // clear all form fields after successful submit 
        resetForm: true        // reset the form after successful submit 
 
        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    };       
    
$.submitForm = function(){    
            // bind to the form's submit event 
            $('#ajax_form').submit(function() { 
                if(ajaxInProgress) {
                    toastr8["info"]("Hay otro proceso ejecutandose en este momento!", "Cuidado");
                    console.log("Hay otro proceso ejecutandose en este momento!");
                    return false;
                }else{
                    // inside event callbacks 'this' is the DOM element so we first 
                    // wrap it in a jQuery object and then invoke ajaxSubmit 
                    $(this).ajaxSubmit(submitFormOpt); 

                    // !!! Important !!! 
                    // always return false to prevent standard browser submit and page navigation 
                    return false;                    
                }                
            });
};

/**
 * 
 * @returns {undefined}
 * @description Envia un formulario mediante ajax, incluyendo los valores del boton en el que se ha hecho click
 */
$.submitFormBtnVal = function(){
    
        //Prevents users from accidentally submitting form with enter key (e.g. IE problem) 
        //http://stackoverflow.com/questions/895171/prevent-users-from-submitting-form-by-hitting-enter
        $(document).on("keyup keypress", "form#prevent_key13 input[type='text']", function (e) {
            if (e.keyCode === 13 /*enterkey*/ ) {
                e.preventDefault();
                return false;
            }
        });    
    
        $(document).on("click", '[id ^= autosubmit]', function(e) {
//            var event = e;
            if(ajaxInProgress) {
                toastr8["info"]("Hay otro proceso ejecutandose en este momento!", "Cuidado");
                console.log("Hay otro proceso ejecutandose en este momento!");
                return false;
            }else{
                e.preventDefault();
                //var form = $(this);
                var form = $(this).parents('form'),
                    resetForm = $(this).attr('reset-form'),
                    dataTarget = $(this).attr('data-target');

                if(dataTarget == 'undefined' || dataTarget == '' ||  dataTarget == null ){
                    dataTarget = '#messagesout';
                }
                    
                if( resetForm == '0' ){
                    resetForm = false;
                }else{
                    resetForm = true;
                }
        //                var formData = form.serialize();
                    var formData = form.serialize() 
                        + '&' 
                        + encodeURI( $(this).attr('name') )
                        + '='
                        + encodeURI( $(this).attr('value') )
                    ;                

                $.ajax({
                  type: form.attr('method'),
                  url: form.attr('action'),
                  data: formData
                }).done(function(html) {
                  $(dataTarget).html(html);
                  if(resetForm){
                    form.trigger("reset");                      
                  }
                }).fail(function() {
                  // Optionally alert the user of an error here...
                });                      
            }            
        });
};


$.getValFromPorcent = function( value, porcent ) {
    parseFloat(value);
    parseFloat(porcent);
    var result = (value * porcent) / 100;    
    return result;
};

/**
 * Estas funciones trabajan con bootstrap-table methods
 * @returns {undefined}
 * 
 * Ejemplo de la data-function para prepend
 *     function getRowNewAbono() {
        var d = new Date();
        var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate();        
        var startId = ~~(Math.random() * 100),
                rows = [];
            rows.push({
                id: startId,
                amount: 0,
                date_abono: strDate
            });
        return rows;
    }
 */
$.apply_bootstrapTableMethods = function(){
    $(document).on("click", "#btn_method_table", function(e) {
        var $table_name = $(this).data('table-name'),
            $method = $(this).data('method'),
            $table = $('#'+$table_name);
            
        if( $method == 'refresh' ){
            $table.bootstrapTable('refresh');            
        }

        if( $method == 'remove' ){
            var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                return row.id;
            });
            $table.bootstrapTable('remove', {
                field: 'id',
                values: ids
            });           
        }

        if( $method == 'prepend' ){
            var callbackFunction = $(this).data('function');
            $table.bootstrapTable('prepend', window[callbackFunction]());          
        }                   
      
    });     
}

    $(function() {
        
        $('[data-toggle="tooltip"]').tooltip();         
         $('input[rel="txtTooltip"]').tooltip();
        $.getValFromPorcent();
        
        $(document).on("mousedown", "input.number", function(e) {
            $(".number").numeric();
        });
        $(document).on("mousedown", "input.integer", function(e) {
            $(".integer").numeric(false, function() {this.value = "1";this.focus();});
        });
        $(document).on("mousedown", "input.positive", function(e) {
            $(".positive").numeric({negative: false}, function() {this.value = "";this.focus();});
        });
        $(document).on("mousedown", "input.positive-integer", function(e) {
            $(".positive-integer").numeric({decimal: false, negative: false}, function() {this.value = "";this.focus();});
        });
        
        $.callPHPFunction();
        $.input_autosuggest();
        loadFormAjax();        
        printelem();
        $.submitForm();
        $.submitFormBtnVal();        
                
        /* == FOR VERTICAL TABS */
            $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
                e.preventDefault();
                $(this).siblings('a.active').removeClass("active");
                $(this).addClass("active");
                var index = $(this).index();
                $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
                $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
            });
            
            Mousetrap.bindGlobal('f12', function() {
                return false;
            });    
            Mousetrap.bindGlobal('ctrl+w', function() {
                return false; /* se evita q se cieerre la ventana*/
            });            
            Mousetrap.bindGlobal('ctrl+f4', function() {
                return false; /* se evita q se cieerre la ventana*/
            });   
            /* Se abre el detalle de la tabla con bootstra-table */
            Mousetrap.bindGlobal('ctrl+o', function() {
                $( ".detail-icon" ).trigger( "click" );             
                return false;
            });            
        
        $.apply_bootstrapTableMethods();
    });    

        // this bit needs to be loaded on every page where an ajax POST may happen
//        $.ajaxSetup({
//            data: {
//                csrf_test_name: $.cookie('csrfcookml1')
//            }
//        });  

    $( document ).ajaxStart(function() {
        /* Para evitar repetir una peticion ajax */
        ajaxInProgress = true;
    });
        
        /* Para reactivar despue de .off es necesario la variable e dentro de function(e) */
    $( document ).ajaxStop(function(e) {
        ajaxInProgress = false;
    });

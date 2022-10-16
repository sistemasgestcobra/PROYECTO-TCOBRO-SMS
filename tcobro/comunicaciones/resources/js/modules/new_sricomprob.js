/**
 * 
 * @utor: Esteban Chamba 
 * @email: estyom.1@gmail.com
 * @twitter: @estyom_1
 */

/* Cuando se cambia el valortax_cart de porcentaje en recargos */
function recdescporcent(elemevent,elempush){
   $(document).on("keyup", elemevent, function(e) {
        var subtot_cart = getNumericVal('#subtot_cart_bruto','float'),
            recporcent = getNumericVal(elemevent,'float'),
            recval = (subtot_cart * recporcent) /100;
//        $(elempush).val(recval.toFixed(numdecimales));
        $(elempush).val(recval);
   });
}

/**
 * Cuando se cambia el valor de porcentaje en recargos
 * @param {type} elemevent
 * @param {type} elempush
 * @returns {undefined}
 */
function recdescval( elemevent, elempush ){
   $(document).on("keyup", elemevent, function(e) {       
        var subtot_cart = getNumericVal('#subtot_cart_bruto','float'),
            recval = getNumericVal(elemevent,'float'),
            recporcent = parseFloat((recval * 100)/subtot_cart);
//        $(elempush).val(recporcent.toFixed(numdecimales));       
        $(elempush).val(recporcent);       
   });
}


/* Cuando se cambia el valor de porcentaje en recargos */
function control_stock(){
   $(document).on("keyup", '#qty_productslist', function(e) {
       var new_val = parseFloat($(this).val()),
           stock_bod = parseFloat($(this).attr('stock_bod'));
            
            if(isNaN(new_val) || new_val==''){ new_val = 0; }
            if(isNaN(stock_bod) || stock_bod==''){ stock_bod = -1; }
            
           if(new_val > stock_bod){
                $(this).val('1');
                alertaError('No puede agregar una cantidad mayor al stock');
           }
   });
   
//   $(document).on("keyup", '#qty_btn', function(e) {
//       var new_val = parseFloat($(this).val()),
//           stock_bod = parseFloat($(this).attr('stock_bod'));
//           
//           if(new_val > stock_bod){
//                $(this).val('1');
//                alertaError('No puede agregar una cantidad mayor al stock');
//           }else{
//               if(!isNaN(new_val) && new_val!=''){ 
//                    $(this).next('span').children('button').removeAttr('disabled','disabled').removeClass('btn-default').addClass('btn-success');               
//               }
//           }
//   });
}

/* Cuando se cambia la bodega seleccionada */
//function change_bodega(){
//   $(document).on("change", "#bodega_id_loadprodpanel", function(e) {
//       var selected_bod = $(this).val();
//    /*********************************************************************/
////        $("#bodega_id_loadprodpanel option:selected").removeAttr("selected");
//        // Select the option you want to select
//        $("#bodega_id_loadprodpanel :selected").prop('selectedIndex','-1');        
//        $("#bodega_id_loadprodpanel option[value='"+selected_bod+"']").attr("selected", "selected");
////        $("#bodega_id_loadprodpanel").prop('selectedIndex', selected_bod);
//    /*********************************************************************/
//    
//    var url = $(this).attr('data-url');
//        $.ajax({
//            type: "POST",
//            url: url,
//            data: { bodegaid: selected_bod },       
//            success: function(html){
//                $('#messagesout').html(html);                    
//            },
//            error: function(){
//                alertaError("Error!! No se pudo alcanzar el archivo de proceso", "Error!!");
//            }              
//        });
//    /*********************************************************************/
//
//   });
//}

/* Cargar la secuencia visible dependiendo del comprobante seleccionado */
function changeComprobante(){
   $(document).on("change", "#codcomprobante_facturacion", function(e) {
    /*********************************************************************/
    var comprobante_cod = $(this).val();
    var dataObject = {};
    dataObject[csrf_name] = csrf_value;
    dataObject['comprobante'] = comprobante_cod;
    var url = $(this).attr('data-url');
        $.ajax({
            type: "POST",
            url: url,
            data: dataObject,       
            success: function(html){
                $('#messagesout').html(html);                    
            },
            error: function(){
                alertaError("Error!! No se pudo alcanzar el archivo de proceso", "Error!!");
            }              
        });
    /*********************************************************************/

   });
}

$.processCart = function() {
        var subtotCart = 0, recval = 0, descval = 0, taxCart = 0;
            recval = parseFloat($("#recval").val());
            descval = parseFloat($("#descval").val());
        var recporcent = parseFloat($("#recporcent").val());
        var desdporcent = parseFloat($("#desdporcent").val());
            
        $('input[id ^= qty_btn]').each(function(e) {
            var productId = $(this).attr('product-id');
            var qty = parseFloat( $('#qty_btn'+productId).val() );
            var price = parseFloat( $('#price_btn'+productId).val() );
            var tax_prod = parseFloat( $('#price_btn'+productId).attr("tax") );
                                    
            var recval_unit = $.getValFromPorcent( price, recporcent );
            var descval_unit = $.getValFromPorcent( price, desdporcent );            
            var price_neto = price + recval_unit - descval_unit;             
            var tax_val = $.getValFromPorcent( price_neto, tax_prod );
            
            if( !$('#apply_iva').is(':checked') ){
                tax_val = 0;
            }
            
                taxCart += tax_val * qty;
            var price_pvp = price + tax_val;
            var totsiniva = qty * price;
            subtotCart += totsiniva;

            $("#pvp_info_"+productId).val(price_pvp.toFixed(numdecimales));
            $("#totsiniva"+productId).html(totsiniva.toFixed(numdecimales));

        });

        /**
         * Se establece el subtot_cart_bruto antes de aplicar descuentos/recargos
         */
        $("#subtot_cart_bruto").val( subtotCart.toFixed(numdecimales) );
        
        /**
         * #subtot_cart es luego de haber aplicado descuents/recargos
         */
        subtotCart = subtotCart + recval - descval;
        $("#subtot_cart").val( subtotCart.toFixed(numdecimales) );
        $("#tax_cart").val( taxCart.toFixed(numdecimales) );
//        $("#total_cart").val( (subtotCart + taxCart).toFixed(numdecimales) );    
//        $('input[id ^= total_cart]').val( (subtotCart + taxCart).toFixed(numdecimales) );    
        
        var valor_retencion = $("#valor_retencion").val();
        $('input[id ^= total_cart]').val( ((subtotCart + taxCart) - valor_retencion).toFixed(numdecimales) );    
        $('#total_cart').val( (subtotCart + taxCart).toFixed(numdecimales) );  
};

$.getCartTotales = function(event, elem) {
        $(document).on(event, elem, function(e) {
            $.processCart();
//            return false;
        });        
};

$.removeProduct = function(speed) {
        $(document).on("click", "#remove_product", function(e) {
            $(this).fadeOut(speed,function(){
                $(this).parents('tr').remove();
                $.processCart();
            });

//            return false;
        });
};

    var refresh_cart_insert_prod = function ( item ) {
        var addRow = true;
        $("input#product_id").each(function(e) {
            if( $(this).val() == item.id ){
                addRow = false;
            }
        });
//        $table.bootstrapTable('append', randomData());
        if( addRow ){
            $(".no-records-found").remove();
            var productRow = '<tr>';
                productRow += '<td> <input type="hidden" id="product_id" name="product_id[]" value="'+item.id+'"/>  <i class="glyphicon glyphicon-remove-sign text-danger" style="cursor: pointer" id="remove_product" style="cursor:pointer"></i></td>';
                productRow += '<td> '+item.id+' </td>';
                productRow += '<td> <input type="text" name="product_name[]" product-id="'+item.id+'" value="'+item.name+'" class="form-control input-sm"> </td>';
                productRow += '<td> <input type="text"  id="qty_btn'+item.id+'" product-id="'+item.id+'" name="product_qty[]" value="1" class="positive form-control input-sm" required="" style="width: 60px" autocomplete="off"/> </td>';
                productRow += '<td> <input type="text" tax="'+item.tax+'" id="price_btn'+item.id+'" product-id="'+item.id+'" name="product_price[]" value="'+item.price_no_tax+'" required="" class="positive form-control input-sm" style="width: 80px" autocomplete="off"/>  </td>';
                productRow += '<td> <input type="text" id="pvp_info_'+item.id+'"  product-id="'+item.id+'" value="'+item.id+'" class="positive form-control input-sm" style="width: 80px" autocomplete="off"/>  </td>';
                productRow += '<td> <span class="pull-right" id="totsiniva'+item.id+'">0.00</span>  </td>';
            productRow += '</tr>';

            $("#cart_detail").append(productRow);
            $.processCart();              
        }else{
            toastr8["warning"]("El producto ya se encuentra agregado", "Alerta");
        }
      
    };
    
    /**
     * 
     * @param {type} item
     * @returns {undefined}
     * @description Hace visible el anticipo disponible del cliente seleccionado, se ejecuta al seleccionar el cliente
     */
    var setClientAnticipo = function ( item ) {
        
        /**
         * Cambia el atributo para modificar los datos de la persona seleccionada
         */
        $('.edit_person').attr( 'php-function', main_path+"modal/admin__clients__open_ml_cliente__"+item.id+"/0/0");
        
        if( item.client_anticipo > 0 ){
            $("#anticipos_area").show();
        }else{
            $("#anticipos_area").hide();
        }
        $("#anticipo_client_val").html(item.client_anticipo);
        
        if( item.cupocredito > 0 ){
            $("#pay_credito_area").show();
            $("#pay_cheque_area").show();
        }else{
            $("#pay_credito_area").hide();            
            $("#pay_cheque_area").hide();
//            $("#credito_pay_view").html("<label>No cuenta con credito</label>");
//            $("#cheque_pay_view").html("<label>No cuenta con credito</label>");
        }
        
    };

    /* Obtener el cambio para los cobros en efectivo*/
    $.get_cambio_efectivo = function() {
            $(document).on("keyup", "#total_cart_efectivo", function(e) {
                var valor_retencion = parseFloat( $("#valor_retencion").val() );
                var total_cart = parseFloat( $("#total_cart").val() );
                var efectivo = parseFloat( $("#total_cart_efectivo").val() );
                var cambio = (efectivo + valor_retencion) - total_cart;
                $("#cambio_val").val( cambio.toFixed(2) );
            });
    };
    
    /**
     * Digitar directamente el pvp desde el carrito de compras
     * @returns {undefined}
     */
    $.set_pvp = function() {
        $(document).on('click', '#change_pvp_btn', function(e) {                
            $('input[id ^= qty_btn]').each(function(e) {
                var productId = $(this).attr('product-id');
                var pvp_val = parseFloat( $('#pvp_info_'+productId).val() );
                var qty = parseFloat( $('#qty_btn'+productId).val() );
                var tax_prod = parseFloat( $('#price_btn'+productId).attr("tax") );

                var val_division_desc = (tax_prod / 100) + 1;                
                var tax_val = pvp_val - (pvp_val / val_division_desc); 
                    if( !$('#apply_iva').is(':checked') ){
                        tax_val = 0;
                    }

                var price_unit = ( pvp_val - tax_val );

                $('#price_btn'+productId).val(price_unit);            
            });

            $.processCart();
    //            return false;
        });      
    };




$(function() {

/**
 * Establecer el PVP, digitandolo directamente
 */
    $.set_pvp();
    
    control_stock();
//    change_bodega();
    changeComprobante();
    
    recdescporcent("#recporcent",'#recval');
    recdescporcent("#desdporcent",'#descval');    
    recdescval('#recval',"#recporcent");
    recdescval('#descval',"#desdporcent");  
                
    /* Funciones para actualizar datos del carrito de compras */
            $(document).on("click", 'input[id ^= qty_btn]', function(e) {
                $(this).val("");  
            });           

            $(document).on("click", 'input[id ^= pvp_info]', function(e) {
                $(this).val("");  
            });           
            
            
//            $(document).on("focusout", 'input[id ^= qty_btn]', function(e) {
//                var product_id = $(this).attr('product-id');                   
//                var current_qty = $("#qty_cartlist-"+product_id).val();  
//                $(this).val(current_qty);  
//            });
            
            
//            $(document).on("keyup", "input[id ^= price_btn]", function(e) {
//                var product_id = $(this).attr('product-id');        
//                var price_value = $(this).val();
//                var outputelem = $(this).attr('data-target');
//                $("#price_cartlist-"+product_id).val(price_value);
//                    var form = $("#product-form-"+product_id);
//                    $(form).ajaxSubmit(
//                    {
//                        target: "#"+outputelem,
//                    });
//                    return false;
//            });            
            
            $(document).on("click", "input[id ^= price_btn]", function(e) {
                $(this).val("");  
            });
            
//            $(document).on("keyup", 'input[id ^= qty_btn]', function(e) {
//                var product_id = $(this).attr('product-id');        
//                var qty_value = $(this).val();
//                var outputelem = $(this).attr('data-target');
//                $("#qty_cartlist-"+product_id).val(qty_value);
//                    var form = $("#product-form-"+product_id);
//                    $(form).ajaxSubmit(
//                    {
//                        target: "#"+outputelem,
//                    });
//                    return false;
//            });    
        $.processCart();
        $.getCartTotales("keyup", 'input[id ^= price_btn]');
        $.getCartTotales("keyup", 'input[id ^= qty_btn]');
        $.getCartTotales("keyup", '#recporcent');
        $.getCartTotales("keyup", '#desdporcent');
        $.getCartTotales("keyup", '#recval');
        $.getCartTotales("keyup", '#descval');
        $.getCartTotales("change", '#apply_iva');
        $.removeProduct(300);
        $.get_cambio_efectivo();
        
        
        Mousetrap.bindGlobal('ctrl+s', function() {
            $( "#pay_now_button" ).trigger( "click" ); 
            return false;
        });
        Mousetrap.bindGlobal('ctrl+n', function() {
            $( "#cart_detail" ).html(""); 
            return false;
        });
        
        Mousetrap.bindGlobal('ctrl+c', function() {
            $( "#autosuggest_cienttoventa" ).val("");
            $( "#autosuggest_cienttoventa" ).focus();
        });
        Mousetrap.bindGlobal('ctrl+i', function() {
            $( "#autosuggest_searchproductventa" ).val("");
            $( "#autosuggest_searchproductventa" ).focus();
            return false;
        });
        
        /* Se elimina el ultimo producto cargado*/
        Mousetrap.bindGlobal('ctrl+z', function() {
            $('#cart_detail i').last('#remove_product').trigger( "click" );
            return false;
        });
        
        /**
         * se aplica el pago en efectivo
         */
        Mousetrap.bindGlobal('ctrl+1', function() {
            $( "#autosubmit_pay_efectivo" ).trigger( "click" );
            return false;
        });
        Mousetrap.bindGlobal('ctrl+2', function() {
            $( "#autosubmit_pay_tarjeta" ).trigger( "click" );
            return false;
        });
        Mousetrap.bindGlobal('ctrl+3', function() {
            $( "#autosubmit_pay_credito" ).trigger( "click" );
            return false;
        });
        Mousetrap.bindGlobal('ctrl+4', function() {
            $( "#autosubmit_pay_cheque" ).trigger( "click" );
            return false;
        });
        Mousetrap.bindGlobal('ctrl+p', function() {
            $( "#printbtn_pv" ).trigger( "click" );
            return false;
        });
        
});

//    window.onbeforeunload = confirmExit;
//    function confirmExit()
//    {
//      return "Ha intentado salir de esta pagina. Si ha realizado algun cambio en los campos sin hacer clic en el boton Guardar, los cambios se perderan. Seguro que desea salir de esta pagina? ";
//    }
//}
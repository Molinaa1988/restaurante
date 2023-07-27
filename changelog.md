Mods by Rafa M.


En caja.php
    Se reorganizó el orden de los divs en el container dtsSecundario, específicamente el selectpicker de clientes se
    movió hacia abajo, y se configiraron los eventos de mostrar y ocultarTic()
    
    Además se oculta todo por defecto hasta que seleccionemos un pedido.

    Se agregó la funcion pulsar que reconce un enter en el input de importe para poder realizar el registro de la venta

En la tabla de comprobante y comprobantec
    Se agregaron sendos campos de FechaFact para registrar la fecha en que se hizo la facturacion y no la del pedido.

En ReporteCuentasporCobrar.php  
    se corrigió un bug a la hora de llamar al AjaxImprimirPDF porque no se mandaba el campo de nombre de cliente en la ruta.
    Se editó la vista del table para que muestre la FechaFact en vez de la Fecha del pedido

En AjaxRealizarVenta.php
    Se agregó al array de dtsSave la FechaFact con la fecha actual 

En modelRealizarVenta.php
    Se editarion las funciones de upRegistroCompra y original, así como las de registroCompra y original 
    para agregar el campo de FechaFact con la fecha actual de facturacion.

En modelReportes.php
    Se agregó el campo de FechaFact a la consulta de ReporteCuentasporCobrar

En el modelInventario.php
    Se agregó la funcion de updateTablaIngredientes para actualizar cualquier campo con cualquier valor de la tabla ingredientes 

En ingredientes.php
    se añadio la propiedad de contenteditable en los td del table para ver los ingredientes.
    Y se capturan esos valores mediante un json al final del archivo, se envían con ajax a saveinlineEdit.php


En saveinlineEdit.php
    Se creó este archivo en la carpeta ajax, recibe los valores y los pasa a un array y luego invoca la funcion de 
    modelInventario::updateTablaIngredientes

## 01-06-21

En ReporteIngredientes.php
    En la línea 150 se agregó el selectpicker para poder filtrar los ingredientes.

En AjaxImprimirPDF.php
    Se agregó en el pdf de la precuenta el apartado para el nombre del cliente por pedido.

Para lo de poder reaperturar todos los pedidos de la misma mesa...

En controllerSalon.php
    Se añadió un ciclo foreach para realizar la reapertura de varios pedidos en la misma mesa.
    Además se llama a otra funcion para traer todos esos pedidos de la misma mesa.

En modelSalon.php
    Se agregó la funcion idPedidoReapartura1 que es lo mismo pero con un fetchAll para poder traer todos.

Ahora lo de registrar CxC pero por fechas


## 02-06-21

En ReporteVentaPorDia.php
    Se comentó la seccion de CREDITOS para que ya no aparezcan en el balance general del día que se dio fiado. 
    Y se modificó la consulta.
    Se agregó en el area de otros ingresos, una tabla para las cuentas por cobrar canceladas

En AjaxImprimirPDF.php
    Se comentó las menciones a CREDITOS para que ya no los use.
    Se corrigió el balance ya que sumaba dos veces la caja inicial.
    Se agregó la seccion de CXC Canceladas y se suman en otros ingresos

En modelCierre.php
    Se editó la funcion de correoresumenticket para que devuelva todos los registros cuya forma de pago no sea crédito.

En modelReportes.php
    Se editó la funcion ReporteVentaspordia para que no regrese los CR.

En ReporteCuentasporCobrar.php
    Se editó la tabla cuentasporcobrar añadiendo la columna FechaC para saber cuando pagaron el crédito.
    Se agregó al table html la columna de fecha cancelado y fecha de otorgado el crédito.
    En el boton de onclick para pagar() lo manda por Ajax

En AjaxExtras.php 
    Se tienen dos funciones de updateCuentas. Una para pasar estado de P a C  y la 2 para pasar de C a P

En modelRealizarVenta.php
    Se editaron las funciones de updateCuenta y updateCuenta2.
    Si se pasa de pendiente a cancelado se manda la fecha actual.
    Pero si de pasa de cancelado a pendiente se manda la fecha en null.

En controllerGastoIngreso.php
    Se agregó la funcion VistaCxcc y su llamado al model

En modelGastoIngreso.php
    Se creó la funcion vistacxcc para mostrar la CxC canceladas en un día.

En AjaxCierre.php
    Se editó toda la seccion del pdf para agregar las CxC y lo mismo para generar el txt que se manda por correo.


# 08-07-21

## Contabilidad de Tickets
 
## cierre.php
    Se agregan los botones para los otros cortes con sus modal correspondientes.
    Al hacer click en el boton de cierre de caja, solo tiene que cerrar la caja
    hacer los descuentos de ingredientes, y enviar el reporte PDF

## AjaxCierre.
    Borre todo el codigo que segun yo no hace nada. 
    Ahora hacer la funcion para que registre los corte Z

## modelCierre.php 
    Se agrego una funcion para registrar el corte Z pero que cuente como un ticket mas


## 12-07-21

## Contabilidad de Tickets
    Ya estan todos los documentos, es decir corte X , Z , gran Z y la cinta.
    Estos se manejan desde botones en cierre.php que llaman al AjaxCierre para agregarlos a la tabla de comprobantesc
    Y luego se imprimen con el AjaxFactura
    Ya esta todo listo, espero ma;ana poder hacer la actualizacion.

## 16-07-21

# cierre.php
    Se agrega el boton exclusivo para el corte x


## 26-07-21
    Se agrego en el pedidobar los platos, para poder imprimir el pedido y enviarlo a cocina
    Ya permite cambio de meseros en el salon. En menupedido


# TODO 
    Revisar los ajaximprimir, que saque todo de la bd y no de los params de la URL

## 27-07-21
    Se ajustaron los documentos para los FCF y CCF

# 04-08-21

# Cambios esteticos en lo de polo
    El favicon, agregar un banner, el title, las imagenes,etc.
    Ah, habia un bug en agregar usuarios, era por no marcar como null la coloumna datos de la tabla usuarios.

# Ahora a por lo otros comprobantes.
    Cambios en caja.php para agregar el otro radio button, de otros :v 
    Y en AjaxUltimosNrosComprobante.php para que busque los nros por TipoComprobante=O
    Y en AjaxRealizarVenta.php para que registre los O en comprobante y comprobantec
    En ReporteVentaspordia.php para mostrar como Otros
    En AjaxImprimirPDF.php para corregir el RSD y los demas reportes, agregar el tipo O que es todo igual menos la resolucion
    En ReporteVentas.php para mostrar los tickets de nuevo y para mostrar otros.
    varios model y controller para agregarles lo de TipoComprobante O

# 09-08-21
# Cambios menores
    Se detecto un bug que los numeros de comproabante difieren con comprobanteC ya que la primera no incluye los cortes.
    Se soluciono con un if en AjaxUltimosNrosComprobante.php
    Ahora estoy ajustando los tickets.


# 12-08-21

## Printer
    Usando el ESC/POS Print Driver for PHP que se instala con composer. Se logra mandar a imprimir texto sin pasar 
    por la ventana de impresion. Creamos el AjaxPrinter.

    Se modifico caja, agregando el checkbox para mostrar el pdf o no, si esta marcada y marcado Tickets o Otros, se manda la ruta
    del AjaxImprimirPDF, si no se manda a llamar el AjaxPrinter.php.
    Funciona desde el celular, solo debe entrar con la direccion IP.

# 16-08-21

## Mods pedidas por el cliente.
    Mostar las bebidas en cocina, en el modelCocina.php en la funcion de  detallePedido se quita lo de formade preparar cocina.
    En cocina.php se hace un if para que rtevise el estado y vea si es bebiba o comida.

    Tambien se corrigio el AjaxImprimirPDF.php  para que muestre los comentarios y el nombre del mesero en el pedido que se imprime.
    Y agregue lo del importe y el cambio en los tickets. Para que ingrese estos campos se modifico el AjaxRealizarVenta y el modelRealizarVenta     


# 17-08-21

# V. PIRRAMAR 
    Se pasaron los tickets que se generan al cobrar en caja, los de pedidos de bar que ahora también llevan lo de comida,
    y el de pre cuenta a impresion directa, usando el AjaxPrinter.php que usa el protocolo ESC/POS de mike42 phpprinter.
    Ahora solo voy a corregir lo del AjaxCierre, que en ese reporte también se muestren los tickets otros.
    Listo.


# V. TIERRAMAR
    A ADAPTARLO PARA TIERRAMAR EN USULUTAN

    




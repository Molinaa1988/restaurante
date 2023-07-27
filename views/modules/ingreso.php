


<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <!--<a href="#">Tierramar<b> Usulutan</b></a> -->
      <h1><b>Restaurante</b></h1>
  </div>
  <div class="login-box-body">
    <p class="login-box-msg">Inicio de Sesion</p>

    <form method="post" id="formIngreso" onsubmit="return validarIngreso()">
      <div class="form-group has-feedback">
        <table>
           <tr class="odd gradeX">
              <td style="width:95%;">
      <input id="usuario" class="form-control" type="text" placeholder="Ingrese su Usuario" name="usuarioIngreso"></td>
      <td>
        <img id="usuario-opener" class="tooltip-tipsy" src="views/dist/img/usuario.png" width="30" height="30"></td>
        </tr>
      </table>
      </div>
      <div class="form-group has-feedback">
        <table>
           <tr class="odd gradeX">
              <td style="width:95%;">
      <input id="contra" class="form-control" type="password" placeholder="Ingrese su Contraseña" name="passwordIngreso"></td>
      <td>
        <img id="contra-opener" class="tooltip-tipsy" src="views/dist/img/candado.png" width="30" height="30"></td>
        </tr>
      </table>
      </div>

		<?php
			$ingreso = new Ingreso();
			$ingreso -> ingresoController();

		?>
      <div class="row">
        <div class="col-xs-4"></div>

        <div class="col-xs-4">
         <input class="btn btn-primary btn-block btn-flat" type="submit" value="Ingresar">
        </div>

      </div>
    </form>

  </div>

</div>


<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<script src="../../plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
  $('#usuario')
  	.keyboard({
  		openOn : null,
  		stayOpen : true,
  		layout : 'qwerty'
  	})
  	.addTyping();

  $('#usuario-opener').click(function(){
  	var kb = $('#usuario').getkeyboard();
  	// close the keyboard if the keyboard is visible and the button is clicked a second time
  	if ( kb.isOpen ) {
  		kb.close();
  	} else {
  		kb.reveal();
  	}
  });
  $('#contra')
    .keyboard({
      openOn : null,
      stayOpen : true,
      layout : 'qwerty'
    })
    .addTyping();

  $('#contra-opener').click(function(){
    var kb = $('#contra').getkeyboard();
    // close the keyboard if the keyboard is visible and the button is clicked a second time
    if ( kb.isOpen ) {
      kb.close();
    } else {
      kb.reveal();
    }
  });
</script>
</body>



<!--====  Fin de FORMULARIO DE INGRESO  ====-->

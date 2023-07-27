
<html>
<head>


  <title>Airmail Ping</title>
  <?php
  require_once "../../models/modelRealizarVenta.php";
  ?>

</head>

<body>

  <div align="center">
    <table cellpadding="0" cellspacing="0" border="0">
      <tr>
        <td width="100%" height="8" valign="top">
          <div height="8">
          </div>
        </td>
      </tr>
      <tr class="header-background">
        <td class="header container" align="center">
          <div class="content">
            <span class="brand">
              <a href="#">
                <!-- Reporte -->
              </a>
            </span>
          </div>
        </td>
      </tr>
    </table>

    <table class="body-wrap w320">
      <tr>
        <td></td>
        <td class="container">
          <div class="content">
            <table cellspacing="0">
              <tr>
                <td>
                  <table class="soapbox">
                    <tr>
                      <td class="soapbox-title">Mensaje enviado desde FUEGO Y BRASA</td>
                    </tr>
                  </table>
                  <table class="body">
                    <tr>
                      <td class="body-padding"></td>
                      <td class="body-padded">
                        <div class="body-title">Mensaje enviado por:  {{first_name}} </div>
                        <table class="body-text">
                          <tr>
                            <td class="body-text-cell">
                              {{message}}
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td class="body-padding"></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </div>
        </td>
        <td></td>
      </tr>
    </table>


  </div>

</body>
</html>

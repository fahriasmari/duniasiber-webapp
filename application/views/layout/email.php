<!doctype html>
<html>
<head>
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!--
    email html ini menggunakan css dengan tipe inline
    untuk generator html inline css, dapat ditemukan pada halaman berikut : https://htmlemail.io/inline/
  -->
  <style>
    /* pertahankan <style> ini di bagian <head> ! */

    @media only screen and (max-width: 620px) {
      table[class=body] h1 {
        font-size: 28px !important;
        margin-bottom: 10px !important;
      }

      table[class=body] p,
      table[class=body] ul,
      table[class=body] ol,
      table[class=body] td,
      table[class=body] span,
      table[class=body] a {
        font-size: 15px !important;
      }

      table[class=body] .wrapper {
        padding: 10px !important;
      }

      table[class=body] .content {
        padding: 0 !important;
      }

      table[class=body] .container {
        padding: 0 !important;
        width: 100% !important;
      }

      table[class=body] .main {
        border-left-width: 0 !important;
        border-radius: 0 !important;
        border-right-width: 0 !important;
      }

      table[class=body] .btn table {
        width: 100% !important;
      }

      table[class=body] .btn a {
        width: 100% !important;
      }

      table[class=body] .img-responsive {
        height: auto !important;
        max-width: 100% !important;
        width: auto !important;
      }
    }

    @media all {
      .btn-primary table td:hover {
        background-color: #0069d9 !important;
      }

      .btn-primary a:hover {
        background-color: #0069d9 !important;
        border-color: #0069d9 !important;
      }
    }
  </style>
</head>
<body style="background-color: #343a40; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
<table class="body" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #343a40;">
  <tr>
    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
    <img src="<?= base_url("assets/img/brand-logo.png") ?>" alt="DuniaSiber" style="width: 200px; display: block; margin: 30px auto;">
    <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; margin: 0 auto; max-width: 580px; width: 580px;">
      <div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px;">
      <!-- area konten email -->
      <?php
      if($tujuan == "VERIFIKASI") {                                             // email untuk tujuan verifikasi email
      ?>
      <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #f8f9fa; border-radius: 3px;">
        <tr>
          <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
              <tr>
                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                  <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px;">
                    Hai <?= $email ?>,
                  </p>
                  <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px;">
                    Kami sedang mempersiapkan akun DuniaSiber yang akan anda pergunakan, tapi sebelum itu anda diharuskan untuk memverifikasi email
                    yang digunakan untuk sinkronisasi akun.
                  </p>
                  <table class="btn btn-primary" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                    <tbody>
                      <tr>
                        <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                          <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                            <tbody>
                              <tr>
                                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #007bff; border-radius: 5px; text-align: center;">
                                  <a href="<?= $token ?>" target="_blank" style="display: inline-block; color: #ffffff; background-color: #007bff; border: solid 1px #007bff; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: normal; padding: 12px 25px; text-transform: capitalize; border-color: #007bff;">
                                    Verifikasi Email
                                  </a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px;">
                    Terima kasih telah menggunakan layanan DuniaSiber.
                  </p>
                  <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px;">
                    Hormat kami. <br>
                    ~ IT Support-duniasiber
                  </p>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <?php
      }else if($tujuan == "RESETPASSWORD") {                                    // email untuk tujuan reset password
      ?>
      <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #f8f9fa; border-radius: 3px;">
        <tr>
          <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
              <tr>
                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                  <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px;">
                    Hai <?= $email ?>,
                  </p>
                  <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px;">
                    Permintaan reset password anda telah kami terima, silahkan meng-klik tombol di bawah untuk melanjutkan proses tersebut.
                  </p>
                  <table class="btn btn-primary" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                    <tbody>
                      <tr>
                        <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                          <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                            <tbody>
                              <tr>
                                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #007bff; border-radius: 5px; text-align: center;">
                                  <a href="<?= $token ?>" target="_blank" style="display: inline-block; color: #ffffff; background-color: #007bff; border: solid 1px #007bff; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: normal; padding: 12px 25px; text-transform: capitalize; border-color: #007bff;">
                                    Atur Ulang Password Baru
                                  </a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px;">
                    Jika anda tidak merasa untuk meminta reset password, silahkan abaikan email ini.
                  </p>
                  <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px;">
                    Hormat kami. <br>
                    ~ IT Support-duniasiber
                  </p>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <?php
      }else if($tujuan == "UBAHEMAIL") {                                         // email untuk fitur "ubah email"
      ?>
      <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #f8f9fa; border-radius: 3px;">
        <tr>
          <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
              <tr>
                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                  <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px;">
                    Hai <?= $email ?>,
                  </p>
                  <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px;">
                    Permintaan perubahan email anda telah kami terima, silahkan meng-klik tombol di bawah untuk melanjutkan proses tersebut.
                  </p>
                  <table class="btn btn-primary" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                    <tbody>
                      <tr>
                        <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                          <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                            <tbody>
                              <tr>
                                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #007bff; border-radius: 5px; text-align: center;">
                                  <a href="<?= $token ?>" target="_blank" style="display: inline-block; color: #ffffff; background-color: #007bff; border: solid 1px #007bff; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: normal; padding: 12px 25px; text-transform: capitalize; border-color: #007bff;">
                                    Verifikasi Perubahan Email
                                  </a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px;">
                    Jika anda tidak merasa untuk meminta perubahan email, silahkan abaikan email ini.
                  </p>
                  <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin-bottom: 15px;">
                    Hormat kami. <br>
                    ~ IT Support-duniasiber
                  </p>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <?php
      }
      ?>
      <!-- bagian footer -->
      <div style="clear: both; margin-top: 10px; text-align: center; width: 100%;">
        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
          <tr>
            <td style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 13px; color: #999999; text-align: center;">
              &copy; 2020 - DuniaSiber
            </td>
          </tr>
        </table>
      </div>
      <!-- /.bagian footer -->
      <!-- /.area konten email -->
      </div>
    </td>
    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
  </tr>
</table>
</body>
</html>

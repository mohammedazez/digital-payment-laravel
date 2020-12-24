<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <style type="text/css" rel="stylesheet" media="all">
        /* Media Queries */
        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>

<?php

$style = [
    /* Layout ------------------------------ */

    'body' => 'margin: 0; padding: 0; width: 100%; background-color: #F2F4F6;',
    'email-wrapper' => 'width: 100%; margin: 0; padding: 0; background-color: #F2F4F6;',

    /* Masthead ----------------------- */

    'email-masthead' => 'padding: 10px 0; text-align: center;',
    'email-masthead_name' => 'font-size: 16px; font-weight: bold; color: #2F3133; text-decoration: none; text-shadow: 0 1px 0 white;',

    'email-body' => 'width: 100%; margin: 0; padding: 0; border-top: 1px solid #EDEFF2; border-bottom: 1px solid #EDEFF2; background-color: #FFF;',
    'email-body_inner' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0;',
    'email-body_cell' => 'padding: 20px;',

    'email-footer' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0; text-align: center;',
    'email-footer_cell' => 'color: #AEAEAE; padding: 20px; text-align: center;',

    /* Body ------------------------------ */

    'body_action' => 'width: 100%; margin: 30px auto; padding: 0; text-align: center;',
    'body_sub' => 'margin-top: 25px; padding-top: 25px; border-top: 1px solid #EDEFF2;',

    /* Type ------------------------------ */

    'anchor' => 'color: #3869D4;',
    'header-1' => 'margin-top: 0; color: #2F3133; font-size: 19px; font-weight: bold; text-align: left;',
    'paragraph' => 'margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;',
    'paragraph-sub' => 'margin-top: 0; color: #74787E; font-size: 12px; line-height: 1.5em;',
    'paragraph-center' => 'text-align: center;',

    /* Buttons ------------------------------ */

    'button' => 'display: block; display: inline-block; width: 200px; min-height: 20px; padding: 10px;
                 background-color: #3869D4; border-radius: 3px; color: #ffffff; font-size: 15px; line-height: 25px;
                 text-align: center; text-decoration: none; -webkit-text-size-adjust: none;',

    'button--green' => 'background-color: #22BC66;',
    'button--red' => 'background-color: #dc4d2f;',
    'button--blue' => 'background-color: #3869D4;',
];
?>

<?php $fontFamily = 'font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;'; ?>

<body style="{{ $style['body'] }}">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="{{ $style['email-wrapper'] }}" align="center">
                <table width="100%" cellpadding="0" cellspacing="0">

                    <!-- Email Body -->
                    <tr>
                        <td style="{{ $style['email-body'] }}" width="100%">
                            <table style="{{ $style['email-body_inner'] }}" align="center" width="570" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="{{ $fontFamily }} {{ $style['email-body_cell'] }}">
                                        <!-- Greeting -->
                                        <center data-parsed="">
                                          	<img src="https://ci6.googleusercontent.com/proxy/ixw8cOE-1bs41F7srPVxWvt3AomWxyO53fzHfMxXZtHuUzNWL-FHZgImNgg0FRTPe2ffFdI_TMwminxb7g7T0O5ABwbW2zp5B8Zo_ViXH6ZMauYuJxlfm2QB1Sf6mA=s0-d-e1-ft#https://domainesia-assets.s3.amazonaws.com/email/welcometodomainesia.jpg" valign="bottom" style="width: 100%;" align="center">
                                       	</center>
                                        <h6 style="font-weight: bold;font-size: 15px;color: #006EAA;">Halo, {{$users->name}}!</h6>

                                        <!-- Intro -->

                                        <p style="{{ $style['paragraph'] }} font-size: 15px;">Pertama-tama, terima kasih telah mendaftar di {{$GeneralSettings->nama_sistem}}! <br>Akun anda telah berhasil dibuat dan sekarang anda dapat melakukan login menggunakan detail berikut:</p>
                                        
                                        <p style="{{ $style['paragraph'] }}font-size: 15px;">
                                            No. HP : <a href="mailto:{{$users->email}}" style="color:#006EAA">{{ $users->phone }}</a><br>
                                            Kunjungi alamat ini untuk login : <a href="{{ url('/member') }}" style="color:#006EAA">{{ url('/member') }}</a>
                                        </p>

                                        <p style="{{ $style['paragraph'] }}font-size: 15px;">Kami berharap dapat memberikan pengalaman layanan terbaik bagi anda.</p><br>
                                        
                                        <p style="{{ $style['paragraph'] }}font-size: 15px;">
	                                        <span style="color:#006EAA">
	                                           	<strong>
	                                              	<small style="font-style: italic;color:#006EAA;">Salam,</small> <br>
	                                              	<span style="color:#006EAA">Tim {{$GeneralSettings->nama_sistem}}<br><br></span>
	                                           	</strong>
	                                        </span>
                                        </p>

                                        <hr style="border: 2px solid #006EAA;" />

                                        <p style="{{ $style['paragraph'] }} text-align: center;" >
                                           Temukan kami di: <a href="#" style="font-weight: bold;text-decoration: underline;color:#006EAA;">Facebook</a> | <a href="#" style="font-weight: bold;text-decoration: underline;color:#006EAA;">Twitter</a> | <a href="#" style="font-weight: bold;text-decoration: underline;color:#006EAA;">Google+</a> | <a href="" style="font-weight: bold;text-decoration: underline;color:#006EAA;">Instagram</a>
                                        </p>
                                        <p style="{{ $style['paragraph'] }} text-align: center;font-size: 13px;" >
                                           SUKA DENGAN LAYANAN KAMI? <a href="#" style="border: 1px solid #006EAA;border-radius: 5px;padding: 5px 5px;color: white;background-color: #006EAA">TULIS PENGALAMANMU!</a>
                                        </p>

                                        <!-- Outro -->
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td>
                            <table style="{{ $style['email-footer'] }}" align="center" width="570" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="{{ $fontFamily }} {{ $style['email-footer_cell'] }}">
                                        <p style="{{ $style['paragraph-sub'] }}margin-bottom: 0px">
                                            &copy; {{ date('Y') }}
                                            <a style="{{ $style['anchor'] }}" href="{{ url('/') }}" target="_blank">{{$GeneralSettings->nama_sistem}} - {{$GeneralSettings->motto}}</a>.
                                            All rights reserved.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<!DOCTYPE html>
<html lang="en">



<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Bond | Email </title>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');



        body {
            text-align: center;
            margin: 0 auto;
            width: 60%;
            font-family: 'Poppins', sans-serif;
            background-color: #e2e2e2;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh
        }
        .main-font {
            font-family: 'Poppins', sans-serif;
        }

        .alt-font {
            font-family: 'Poppins', sans-serif;

        }
        @media screen and (max-width: 768px) {
            body {
                width: 90%;
            }
        }

        ul {
            margin: 0;
            padding: 0;
        }

        li {
            display: inline-block;
            text-decoration: unset;
        }

        a {
            text-decoration: none;
        }

        p {
            margin: 15px 0;
        }

        h5 {
            color: #fff;
            text-align: left;
            font-weight: 400;
        }

        .text-center {
            text-align: center
        }

        .main-bg-light {
            background-color: #fafafa;
        }

        .title {
            color: #AB0202;
            font-size: 22px;
            font-weight: 600;
            margin-top: 10px;
            margin-bottom: 10px;
            padding-bottom: 0;
            text-transform: uppercase;
            display: inline-block;
            line-height: 1;
        }

        table {
            margin-top: 30px
        }

        table p {
            color: #040404;
        }

        table td {
            color: #040404 !important;
            text-align: center;
        }

        table.order-detail td a {
            color: #040404 !important;
            text-align: center;
        }

        table td {
            color: #040404 !important;
            text-align: center;
        }

        table.top-0 {
            margin-top: 0;
        }

        table.footer-social-icon td a {
            margin-right: 10px;
        }

        table.footer-social-icon td:last-child a {
            margin-right: 0;
        }

        table.footer-social-icon td a img {
            border: 1px solid #000000;
            border-radius: 50%;
        }

        table.order-detail,
        .order-detail th,
        .order-detail td {
            border: 1px solid #ddd;
            border-collapse: collapse;
        }

        table.order-detail {
            width: 50%;
            margin: 0 auto;
        }
        table.order-detail button{
            font-weight: 400;
            
            color: #212529;
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.55rem;
            font-size: 1rem;
            border-radius: 0.25rem;
            cursor: pointer;
        }
        table.order-detail button:hover{
            
    border: 1px solid #ddd;
        }
        table.order-detail button img{
            height: 10px;
        }

        @media screen and (max-width: 768px) {
            table.order-detail {
                width: 70%;
                margin: 0 auto;
            }
        }

        @media screen and (max-width: 600px) {
            table.order-detail {
                width: 90%;
                margin: 0 auto;
            }
        }

        .order-detail th {
            font-size: 16px;
            padding: 15px;
            text-align: center;
        }

        .footer-social-icon tr td img {
            margin-left: 5px;
            margin-right: 5px;

            width: 30px;
            height: 30px;
        }

        .text-main {
            color: #AB0202;
        }

        .bg-color {
            background-color: #AB0202;
        }

        .text-white {
            color: #fff;
        }

        .box-container {
            background-color: #fff;
            -webkit-box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);
            box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);
            /* background:linear-gradient(to top, rgba(237, 41, 36, 0.9) 83%, rgba(255,255,255,0.4) 17% ); */
            border-radius: 30px;
        }
    </style>
</head>

<body style="margin: 20px auto;">
    <div class="box-container" style="background: url('https://digitalbondmena.com/frontend/digitalbondmessageemail/assets/images/Cover.png') #fff;background-size: contain; background-repeat: no-repeat; background-position:center -71%;">

        <table align="center" border="0" cellpadding="0" cellspacing="0"
            style=" border-top-left-radius: 30px; border-top-right-radius: 30px; width: 100%; margin-top: 0;">
            <tbody>
                <tr>
                    <td>
                        <table cellpadding="0" cellspacing="0" border="0" align="left" style="border-top-left-radius: 30px; border-top-right-radius: 30px;width: 100%;margin-top: 0;  margin-bottom: 30px;  ">
                            <tbody>
                                <tr>
                                    <td
                                        style="font-size: 13px; font-weight: 400; color: #444444; letter-spacing: 0.2px;width: 10%; text-align: left;">
                                        <img src="https://digitalbondmena.com/frontend/digitalbondmessageemail/assets/images/cover_email.png" style="width: 40%;" alt="">
                                    </td>
                                    <td class="user-info"
                                        style="font-size: 13px; font-weight: 400; color: #444444; letter-spacing: 0.2px;width: 10%;  text-align: right;">

                                        <img src="https://digitalbondmena.com/frontend/digitalbondmessageemail/assets/images/logo/logo.png" style="width: 40%; margin-right: 20px;"
                                            alt="">

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table align="center" style="padding: 0 30px;" border="0" cellpadding="0" cellspacing="0">
                            

                            <tr>
                                <td>
                                    <h2 class="title ">You have a new candidate | {{ $useName }}</h2>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>New request has been recevied</p>
                                </td>
                            </tr>
                            <tr>

                                <td>
                                    <div style="border-top:1px solid #ddd;height:1px;margin: 10px 0;"></div>
                                </td>
                            </tr>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0"
                            style="margin: 0 auto 10px auto; padding: 0 30px;">
                            <tr>
                                <td>
                                    <h2 class="title" style="text-align: center;">User DETAILS</h2>
                                </td>
                            </tr>
                        </table>
                        <table class="order-detail" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td colspan="2"
                                    style="line-height: 40px;font-size: 13px;color: #000000;padding-left: 20px;text-align:left;border-right: unset;">
                                    Name :</td>
                                <td colspan="3" class="price"
                                    style="line-height: 40px;text-align: right;padding-right: 44px;font-size: 13px;color: #000000;text-align:right;border-left: unset;">
                                    <b>{{ $useName }}</b></td>
                            </tr>
                            <tr style="">
                                <td colspan="2"
                                    style="line-height: 40px;font-size: 13px;color: #000000;padding-left: 20px;text-align:left;border-right: unset;">
                                    Email: </td>
                                <td colspan="3" class="email" id="email"
                                    style="line-height: 40px;text-align: right;padding-right: 10px;font-size: 13px;color: #000000;text-align:right;border-left: unset; position: relative;">
                                    
                                    <b>{{ $userEmail }}</b>
                                    <button style="margin-right:-36px !important;" onclick="copyToClipboard('#email')" title="Copy email">
                                        <img src="https://digitalbondmena.com/frontend/digitalbondmessageemail/assets/images/email-temp/copy.png" alt="">
                                    </button>
                                 </td>
                            </tr>

                            <tr>
                                <td colspan="2" style="line-height: 40px;font-size: 13px;color: #000000;
                                        padding-left: 20px;text-align:left;border-right: unset;">Phone :</td>
                                <td colspan="3" class="price" id="phone"
                                    style="
                                            line-height: 40px;text-align: right;padding-right: 10px;font-size: 13px;color: #000000;text-align:right;border-left: unset; position: relative;">
                                    <b><a href="tel:{{ $phone }}">{{ $phone }}</a>
                                    </b>
                                            <button style="margin: 0 -36px 0 0;" onclick="copyToClipboard('#phone')" title="Copy phone">
                                                <img src="https://digitalbondmena.com/frontend/digitalbondmessageemail/assets/images/email-temp/copy.png" alt="">
                                                </button>
                                    </td>
                            </tr>
                            <tr>
                                <td colspan="2"
                                    style="line-height: 40px;font-family: Arial;font-size: 13px;color: #000000;padding-left: 20px;text-align:left;border-right: unset;">
                                    Position: </td>
                                <td colspan="3" class="price"
                                    style="line-height: 40px;text-align: right;padding-right: 44px;font-size: 13px;color: #000000;text-align:right;border-left: unset;">
                                    <b>{{ $userPostion }}</b></td>
                            </tr>
                            <tr>
                                <td colspan="2"
                                    style="line-height: 40px;font-family: Arial;font-size: 13px;color: #000000;padding-left: 20px;text-align:left;border-right: unset;">
                                    Experience: </td>
                                <td colspan="3" class="price"
                                    style="line-height: 40px;text-align: right;padding-right: 44px;font-size: 13px;color: #000000;text-align:right;border-left: unset;">
                                    <b>{{ $userExperience }}</b></td>
                            </tr>
                        </table>
                        
                        <table align="center" style="padding: 0 30px; margin-top: 10px;" border="0" cellpadding="0"
                            cellspacing="0">
                            <!-- <tr>
                                <td>
                                    <img src="assets/images/logo/logo.png" alt=""
                                        style="margin-bottom: 30px;">
                                </td>
                                <td>
                                    <img src="assets/images/logo/logo.png" alt=""
                                        style="margin-bottom: 30px;">
                                </td>
                            </tr> -->
                            <tr>
                                <td>
                                    <div style="border-top:1px solid #ddd;height:1px;margin: 10px 0;"></div>
                                </td>
                            </tr>
                            @if($userCoverLetter)
                            <tr>
                                <td>
                                    <h2 class="title ">Cover letter</h2>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>{{ $userCoverLetter }}</p>
                            </tr>
                            @endif
                            <tr>

                                <td>
                                    <div style="border-top:1px solid #ddd;height:1px;margin-top: 10px;"></div>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="text-center top-0 " align="center" border="0" cellpadding="0"  cellspacing="0"
            style=" width:100%; border-bottom-right-radius: 30px">
            <tr>
                <td style="padding: 10px 30px;">
                    <div>
                        <h4 class="title" style="margin:0;text-align: center;">Follow us on</h4>
                    </div>
                    <table border="0" cellpadding="0" cellspacing="0" class="footer-social-icon" align="center"
                        class="text-center" style="margin-top:10px;">
                        <tr>
                            <td>
                                <a href="https://www.facebook.com/DigitalBondMena/" target="_blank"> 
                                    <img src="https://digitalbondmena.com/frontend/digitalbondmessageemail/assets/images/email-temp/facebook.png" alt="">
                                </a>
                            </td>
                            <td>
                                <a href="https://www.instagram.com/digitalbondmena/" target="_blank">
                                    <img src="https://digitalbondmena.com/frontend/digitalbondmessageemail/assets/images/email-temp/instagram.png" alt="">
                                </a>
                            </td>

                            <td>
                                <a href="https://www.linkedin.com/company/digital-bond/" target="_blank">
                                    <img src="https://digitalbondmena.com/frontend/digitalbondmessageemail/assets/images/email-temp/linkedin.png" alt="">
                                </a>
                            </td>
                        </tr>
                    </table>
                    <div style="border-top: 1px solid #ddd; margin: 15px auto 0;"></div>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 20px auto 0;">

                        <tr>
                            <td>
                                <div style="font-size:13px; margin:0;">
                                    Copyright © 2022
                                    <a href="https://digitalbondmena.com/" target="_blank">
                                        <img src="https://digitalbondmena.com/frontend/digitalbondmessageemail/assets/images/logo/logo.png"
                                            style="height:30px; margin: 0 5px; object-fit: contain;" alt="">

                                    </a>
                                    , All rights reserved.</div>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
    }
    </script>
</body>


</html>

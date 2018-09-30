@extends('app')
@section('content')

<div class="container">
    <div class="row content">
        <div class="col-md-12 text-center">


            <div class="loggedout">
                <div class="row">
                    <div class="col-sm-12  col-md-12">
                        <div class="white-box">
                            <h1>Oh dear!</h1>
                            <p>You must be logged in to view this page.</p>
                        </div>

                        <div class="row">
                            <div class="col-xs-6 leftB">
                                <a href="javascript:void(0);" class="btn btn-primary" data-remodal-target="registermodal">Register (FREE)</a>
                            </div>
                            <div class="col-xs-6 rightB">
                                <a href="javascript:void(0);" class="btn btn-secondary" data-remodal-target="loginmodal">Login</a>
                            </div>
                        </div>

                        <div class="row" style="opacity: 0.1; margin-top: 10px;">
                            <div class="col-xs-3 leftB">
                                <img src="/assets/img/envato_btn.png" style="width: 100%;">
                            </div>
                            <div class="col-xs-3 leftB rightB">
                                <img src="/assets/img/creativemarket.png" style="width: 100%;">
                            </div>
                            <div class="col-xs-3 leftB rightB">
                                <img src="/assets/img/twitter.png" style="width: 100%;">
                            </div>
                            <div class="col-xs-3 rightB">
                                <img src="/assets/img/dribbble_btn.png" style="width: 100%;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    body {
        background: url(/assets/img/login.jpg);
        background-attachment: fixed !important;
    }
    .col-xs-6.leftB,.col-xs-6.rightB{
        width: 50%;
        padding: 15px;
    }
    .vali:hover{
        opacity: 0.8;
    }

    .main{
        background: #ffffff;
    }

    .main h1{
        background: #f3f3f3;
        color: #414141;
        font-size: 24px;
        line-height: 100px;
        font-weight: bold;
        border-bottom: solid 1px #e6e6e6;
    }
    .tableblock{
        display: table;
        height: 350px;
    }
    .tablecell{
        display: table-cell;
        vertical-align: middle;
    }
    .savedfilesBox, .options{
        min-height: 220px;
    }
    .template-holder-tile .gridview{
        text-align: left;
        padding: 30px 20px;
    }

    .template-holder-tile h3{
        margin: 0px;
        padding: 0px;
        font-size: 20px;
        text-align: center;
    }

    .template-holder-tile ul{
        margin: 0px;
        padding: 0px;
        list-style: none;
        margin-top: 20px;
    }

    .template-holder-tile ul li{
        text-align: left;
        margin-bottom: 10px;
    }

    .template-holder-tile ul li a{
        color: #333;
        display: block;
        text-decoration: none;
    }

    .template-holder-tile ul li a i{
        margin-left: 30px;
        margin-right: 10px;
        color: #eb3b4a;
    }


    .imageholder{
        margin: 0px;
        width: 100%;
        height: 150px;
        overflow: hidden;
    }
    .imageholder img{
        width: 100%;
    }
    .redeem-form{
        margin: 5%;
        border: solid 1px #e4e4e4;
        padding: 50px 40px;
        border-radius: 5px;
        text-align: left;
        margin-top: 25px;
        margin-bottom: 30px;
        background: #f9f9f9;
    }
    .redeem-form label{
        font-weight: bold;
        font-size: 20px;
        color: #444;
    }
    .redeem-form input[type=text]{
        border: solid 1px #ddd;
        box-shadow: none;
        height: 40px;
        text-align: left;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .redeem-form i{
        font-size: 12px;
    }
    .redeem-form .btn{
        border-bottom: 40px;
    }
    .btn-redeem{
        width: 350px;
        display: inline-block;
        background: #eb3b4a;
        color: #ffffff;
        padding: 5px 25px;
        line-height: 50px;
        border-radius: 4px;
        margin-top: 50px;
    }
    .btn-evanto{
        width: 350px;
        background: #1b1b1b;
        border-radius: 4px;
        display: inline-block;
        line-height: 50px;
        padding: 10px 30px;
        color: #ffffff;
        margin-top: 20px;
    }

    .btn-evanto:hover, .btn-redeem:hover, .btn-evanto:focus, .btn-redeem:focus{
        color: #ffffff;
        text-decoration: none;
        opacity: 0.5;
    }

    .btn-evanto img{
        height: 20px;
        position: relative;
        top: -4px;
        left: 2px;
    }
    .content{
        padding: 50px 0px;
    }

    .intro{
        line-height: 30px;
    }

    .inner-banner{
        background: #1b1b1b;
        padding: 20px;
    }

    .inner-banner img{
        padding-top: 5px;
    }

    .inner-banner ul{
        list-style: none;
        padding: 0px;
        margin: 0px;
    }

    .inner-banner li{
        padding: 0px;
        margin: 0px;
    }

    .inner-banner li a{
        line-height: 35px;
        color: #ffffff;
    }

    .inner-banner li.active a{
        color: #eb3b4a;
    }

    .inner-banner p{
        line-height: 15px;
        color: #ffffff;
    }

    .inner-banner .btn{
        font-weight: bold;
    }

    .alert{
        margin-bottom: 40px;
    }
    .gridview .box{
        -webkit-box-shadow: 0px 0px 12px 0px rgba(71,71,71,0.16);
        -moz-box-shadow: 0px 0px 12px 0px rgba(71,71,71,0.16);
        box-shadow: 0px 0px 12px 0px rgba(71,71,71,0.16);
    }
    .tempholder{
        margin-left: 50px;
        margin-right: 50px;
    }
    body{
        background: url('/assets/img/bg.png');
        background-size: cover;
        background-attachment: fixed  !important;
    }

    .gridview ul.menu{
        padding: 0px;
        margin: 0px;
    }

    .gridview ul.menu li{
        border-top: solid 1px #f3f3f3;
        line-height: 40px;
        padding: 0px;
        margin: 0px;
        padding: 5px 25px;
    }

    .gridview ul.menu li i{
        margin: 0px;
        margin-right: 10px;
    }

    .box h3{
        line-height: 60px;
    }

    .scrollwindow{
        height: 169px;
        overflow: auto;
        padding: 0px !important;
        margin: 0px !important;
    }

    span.close{
        background: #ee3845;
        width: 25px;
        height: 25px;
        text-align: center;
        opacity: 1 !important;
        position: relative;
        top: 5px;
        margin: 0px;
        padding: 0px;
    }

    span.close i{
        color: #ffffff !important;
        font-size: 13px;
        text-align: center;
        line-height: 25px;
        margin: 0px !important;
        padding: 0px !important;
    }

    .scrollwindow ul{
        margin: 0px;
        padding: 0px;
    }

    .scrollwindow ul li{
        padding: 0px;
        margin: 0px;
        text-align: left !important;
        line-height: normal !important;
    }

    .scrollwindow ul li:nth-child(2n){
        background: #f9f9f9;
    }
    .scrollwindow ul li:nth-child(2n+1){
        background: #ebebeb;
    }

    .scrollwindow ul li .title{
        font-weight: bold;
        font-size: 15px;
        padding: 0px;
        margin: 0px;
        margin-top: 10px;
        margin-bottom: 5px;
        line-height: normal !important;
    }

    .scrollwindow ul li .btn{
        border-radius: 0px !important;
        color: #fff !important;
        padding: 8px 0px;
        text-align: center !important;
        font-weight: bold;
        margin-top: 12px;
        margin-bottom: 12px;
        width: 100%;
    }

    .leftb{
        padding-right: 10px;
    }

    .rightb{
        padding-left: 10px;
    }

    .scrollwindow ul li .btn i{
        color: #ffffff;
        margin-right: 0px;
        margin-left: 5px;
    }

    .notemplates{
        line-height: 19px !important;
        padding-top: 25px !important;
    }

    .template-holder-tile .box{
        max-width: 300px;
        margin-left: auto;
        margin-right: auto;
    }

    .loggedout .white-box{
        background: #ffffff;
        padding: 40px;
        margin-top: 60px;
    }

    .loggedout .white-box h1{
        font-weight: bold;
        font-size: 40px;
    }

    .loggedout .btn{
        width: 100%;
        border-radius: 0px;
        margin-top: 10px;
        height: 50px;
        line-height: 50px;
        padding-top: 0px;
        padding-bottom: 0px;
        font-weight: bold;
        font-size: 13px;
    }

    .loggedout .btn-primary{
        background: #b0b0b0;
        border: 0px;
    }

    .loggedout .btn:hover{
        opacity: 0.8 !important;
    }

    .loggedout .leftB{
        padding-right: 5px;
    }

    .loggedout .rightB{
        padding-left: 5px;
    }

    .mainmenu a{
        font-weight: bold;
        text-transform: uppercase;
        text-decoration: none;
        color: #fff;
    }

    .mainmenu .btn{
        margin-left: 10px;
    }

    .mainmenu .btn-secondary:hover{
        opacity: 0.8 !important;
    }

    .btn-primary:hover{
        color: #ffffff !important;
    }

    .restore{
        list-style: none;
        padding: 0px;
        margin: 0px;
    }

    .restore li{
        text-align: center;
        padding: 10px 20px;
    }

    .restore input{
        border: solid 1px #ccc;
        width: 100%;
        line-height: 30px;
        border-radius: 3px;
        background: #f1f1f1;
        padding: 3px;
        text-align: center;
    }

    .restore li:first-child{
        text-align: left;
        padding: 5px 25px;
        line-height: 40px;
    }

    .restore li:first-child a{
        color: #000000;
        text-decoration: none;
        line-height: 30px;
    }

    .restore li:first-child i{
        color: #ee3845;
        margin-right: 10px;
    }

    .links a:hover{
        opacity: 0.8;
        cursor: pointer !important;
    }

    body{
        background: url('/assets/img/login.jpg');
        background-attachment: fixed !important;
    }

    body{
        background: url('/assets/img/login.jpg');
        background-attachment: fixed !important;
    }
</style>
    @endsection
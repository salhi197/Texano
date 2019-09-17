@extends('layouts.app')
<!-- Load Stripe.js on your website. -->

@section('content')

    <style>
        .spacer {
            margin-bottom: 24px;
        }

        /**
         * The CSS shown here will not be introduced in the Quickstart guide, but shows
         * how you can use CSS to style your Element's container.
         */
        .StripeElement {
            background-color: white;
            padding: 10px 12px;
            border-radius: 4px;
            border: 1px solid #ccd0d2;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        #card-errors {
            color: #fa755a;
        }
    </style>

    <div id="generic_price_table">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!--PRICE HEADING START-->
                        <div class="price-heading clearfix">
                            <h1>Plans & Pricing</h1>
                        </div>
                        <!--//PRICE HEADING END-->
                    </div>
                </div>
            </div>
            <div class="container">

                <!--BLOCK ROW START-->
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-xl-4">

                        <!--PRICE CONTENT START-->
                        <div class="generic_content clearfix">

                            <!--HEAD PRICE DETAIL START-->
                            <div class="generic_head_price clearfix">

                                <!--HEAD CONTENT START-->
                                <div class="generic_head_content clearfix">

                                    <!--HEAD START-->
                                    <div class="head_bg"></div>
                                    <div class="head">
                                        <span>Free</span>
                                    </div>
                                    <!--//HEAD END-->

                                </div>
                                <!--//HEAD CONTENT END-->

                                <!--PRICE START-->
                                <div class="generic_price_tag clearfix">

                                </div>
                                <!--//PRICE END-->

                            </div>
                            <!--//HEAD PRICE DETAIL END-->

                            <!--FEATURE LIST START-->
                            <div class="generic_feature_list">
                                <ul>
                                    <li><span>1000</span> QUERIES PER MONTH</li>
                                    <li><span>10GB</span> Storage</li>
                                    <li><span>1</span> Accounts</li>
                                    <li><span>No</span> Support</li>
                                </ul>
                            </div>
                            <!--//FEATURE LIST END-->

                            <!--BUTTON START-->
                            @if(!$alreadyProMember)
                            <label type="label" class="label-input100" style="color: cornflowerblue;">
                                You have a free subscription
                            </label>
                            @endif
                            <!--//BUTTON END-->

                        </div>
                        <!--//PRICE CONTENT END-->

                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-4">

                        <!--PRICE CONTENT START-->
                        <div class="generic_content active clearfix">

                            <!--HEAD PRICE DETAIL START-->
                            <div class="generic_head_price clearfix">

                                <!--HEAD CONTENT START-->
                                <div class="generic_head_content clearfix">

                                    <!--HEAD START-->
                                    <div class="head_bg"></div>
                                    <div class="head">
                                        <span>Pro</span>
                                    </div>
                                    <!--//HEAD END-->

                                </div>
                                <!--//HEAD CONTENT END-->

                                <!--PRICE START-->
                                <div class="generic_price_tag clearfix">
                                <span class="price">
                                    <span class="sign">$</span>
                                    <span class="currency">19</span>
                                    <span class="cent">.99</span>
                                    <span class="month">/MON</span>
                                </span>
                                </div>
                                <!--//PRICE END-->

                            </div>
                            <!--//HEAD PRICE DETAIL END-->

                            <!--FEATURE LIST START-->
                            <div class="generic_feature_list">
                                <ul>
                                    <li><span>10000</span> QUERIES PER MONTH</li>
                                    <li><span>50GB</span> Storage</li>
                                    <li><span>3</span> Accounts</li>
                                    <li><span>Email</span> Support</li>
                                </ul>
                            </div>
                            <!--//FEATURE LIST END-->

                            <!--BUTTON START-->
                            <div class="generic_price_btn clearfix">
                                <!-- Button trigger modal -->
                                @if  (!$alreadyProMember)
                                    <button type="button" class="generic_price_btn clearfix" data-toggle="modal"
                                            data-target="#exampleModal">
                                        Upgrade to Pro
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">

                                                <div class="modal-body">

                                                    {{--                                                <div class="row">--}}

                                                    <form action="{{ url('/upgrade') }}" method="POST"
                                                          id="payment-form">
                                                        {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <label for="email">Email Address</label>
                                                            <input type="email" class="form-control" id="email">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="name_on_card">Name on Card</label>
                                                            <input type="text" class="form-control" id="name_on_card"
                                                                   name="name_on_card">
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="address">Address</label>
                                                                    <input type="text" class="form-control" id="address"
                                                                           name="address">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="city">City</label>
                                                                    <input type="text" class="form-control" id="city"
                                                                           name="city">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="province">Province</label>
                                                                    <input type="text" class="form-control"
                                                                           id="province" name="province">
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-4-lg-4">
                                                                <div class="form-group">
                                                                    <label for="postalcode">Postal Code</label>
                                                                    <input type="text" class="form-control"
                                                                           id="postalcode" name="postalcode">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4-lg-4">
                                                                <div class="form-group">
                                                                    <label for="country">Country</label>
                                                                    <input type="text" class="form-control" id="country"
                                                                           name="country">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4-lg-4">
                                                                <div class="form-group">
                                                                    <label for="phone">Phone</label>
                                                                    <input type="text" class="form-control" id="phone"
                                                                           name="phone">
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="form-group">
                                                            <label for="card-element">Credit Card</label>
                                                            <div id="card-element">
                                                                <!-- a Stripe Element will be inserted here. -->
                                                            </div>

                                                            <!-- Used to display form errors -->
                                                            <div id="card-errors" role="alert"></div>
                                                        </div>

                                                        <div class="spacer"></div>

                                                        <button type="submit" class="btn btn-success">Submit Payment
                                                        </button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                            @else
                                <label type="label" class="label-input100" style="color: cornflowerblue;">
                                    You have a PRO subscription
                                </label>
                        @endif


                    </div>

                    </div>
                    </div> <!-- end of PRO col-4 -->
                    <div class="col-md-4 col-lg-4 col-xl-4">

                        <!--PRICE CONTENT START-->
                        <div class="generic_content clearfix">

                            <!--HEAD PRICE DETAIL START-->
                            <div class="generic_head_price clearfix">

                                <!--HEAD CONTENT START-->
                                <div class="generic_head_content clearfix">

                                    <!--HEAD START-->
                                    <div class="head_bg"></div>
                                    <div class="head">
                                        <span>Entreprise</span>
                                    </div>
                                    <!--//HEAD END-->

                                </div>
                                <!--//HEAD CONTENT END-->

                                <!--PRICE START-->
                                <div class="generic_price_tag clearfix">
                                <span class="price">
                                    <span class="sign">On demand</span>
                                </span>
                                </div>
                                <!--//PRICE END-->

                            </div>
                            <!--//HEAD PRICE DETAIL END-->

                            <!--FEATURE LIST START-->
                            <div class="generic_feature_list">
                                <ul>
                                    <li><span>On demand</span> QUERIES PER MONTH</li>
                                    <li><span>On demand</span> Storage</li>
                                    <li><span>On demand</span> Accounts</li>
                                    <li><span>24/7</span> Support</li>
                                </ul>
                            </div>
                            <!--//FEATURE LIST END-->

                            <!--BUTTON START-->
                            <div class="generic_price_btn clearfix">
        @if($error= Session::get('error'))
            <div class="alert alert-danger">
                <p>{{$error}}</p>
            </div>
        @endif




                                <a class="" href="">Request a demo</a>
                            </div>
                            <!--//BUTTON END-->

                        </div>
                        <!--//PRICE CONTENT END-->

                    </div>
                </div>
                </div>
                <!--//BLOCK ROW END-->

            </div>
        </section>

    </div>



    <script src="https://js.stripe.com/v3"></script>

@endsection



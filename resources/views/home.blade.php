
@extends('layouts.app')

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

.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}


.checkout input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

.checkout label {
  margin-bottom: 10px;
  display: block;
}

.checkout .icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.checkout .btn {
  background-color: #4CAF50;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.checkout .btn:hover {
  background-color: #45a049;
}

.checkout a {
  color: #2196F3;
}


.checkout span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}

    </style>


<div class="container">
        @if($message= Session::get('success'))
            <div class="alert alert-success">
                <p>{{$message}}</p>
            </div>
        @endif
        @if($error= Session::get('error'))
            <div class="alert alert-danger">
                <p>{{$error}}</p>
            </div>
        @endif
        <div class="row">
            <div class="col-md-3">
                <div class="menu-nav-stacked">
                    <ul class="list-group">
                        <li class="list-group-item"> <i class="fas fa-chart-bar"></i>&nbsp; 
                        <a href="{{route('home', ['tab' => 'plan-usage'])}}">Plan Usage</a>
                        </li>
                        <li class="list-group-item"> <i class="fas fa-user"></i>&nbsp; 
                            <a href="{{route('home', ['tab' => 'profile'])}}">Profile</a>
                        </li>
                        <li class="list-group-item"> <i class="fas fa-lock"></i>&nbsp; 
                            <a href="{{route('home', ['tab' => 'change-password'])}}">Change password</a>
                        </li>
                        <li class="list-group-item"> <i class="fas fa-money-check"></i>&nbsp;  
                            <a href="{{route('home', ['tab' => 'billing-settings'])}}">Billing and settings </a>
                        </li>
                        <li class="list-group-item"> <i class="fas fa-history"></i>&nbsp; 
                            <a href="{{route('home', ['tab' => 'billing-history'])}}">Billing & History </a>
                        </li>
                    </ul>
                </div>                
            </div>
            <div class="col-md-9 ">
        @if(session('status'))
            <div class="panel panel-default">
                <div class="panel-heading">
                <div class="alert alert-success">
                    {{session('status')}}
                </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="invalid-feedback" role="alert">
            {{session('error')}}
            </div>
        @endif
                @if($tab=="plan-usage")
                <div class="panel panel-default">
                    <div class="panel-heading">PLAN USAGE</div>
                    <div class="panel-body">
                        <div class="middle">
                            <div class="bar-container">
                            <div class="bar-4" style="width: {{$pourcentage}}%;">
                                {{$pourcentage}}%
                            </div>
                            </div>
                        </div>
                        <div class="side right">
                            <div>{{$requests}}/1000</div>
                        </div>

                    </div>
                </div>
                @endif
                @if($tab=="change-password")
                <div class="panel panel-default">
                    <div class="panel-heading">Change Password</div>
                    <div class="panel-body">
                        <form method="post" action="{{route('update-password')}}" id="update-password">
                        @csrf   
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{ trans('home.Currrent_password') }} </label>
                                <input type="password" class="form-control" placeholder="current password" name="password" data-validate="Password is required">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">{{ trans('home.new_password') }}</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="new Password" name="new_password" required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">{{ trans('home.confirm_Password') }}</label>
                                <input type="password" class="form-control" placeholder="confirm Password" name="password_confirm" required autofocus> 
                            </div>

                        </form>
                    </div>
                    <div class="panel-footer">
                            <button class="btn btn-primary" onclick="event.preventDefault();document.getElementById('update-password').submit();"                            
                            >{{ trans('home.update') }}</button>
                    </div>

                </div>
                @endif
                @if($tab=="profile")
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('home.profile') }} - {{ trans('home.change_email') }}</div>
                    <div class="panel-body">
                        <form method="post" action="/home" id="editEmail-form">
                        @csrf   
                            <div class="form-group">
                                <label for="exampleInputEmail1">{{ trans('home.email') }} {{ trans('home.address') }}</label>
                                <input type="email" value="{{ Auth::user()->email }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">{{ trans('home.password') }}</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">send me Notifications</label>
                            </div>

                        </form>
                    </div>
                    <div class="panel-footer">
                            <button class="btn btn-primary" onclick="event.preventDefault();document.getElementById('editEmail-form').submit();"                            
                            >{{ trans('home.submit') }}</button>
                    </div>

                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('home.profile') }} - {{ trans('home.change_language') }}</div>
                    <div class="panel-body">
                            <a class="dropdown-item" href="{{ url('/lang/en') }}">
                                <img src="{{ asset('svg/united-kingdom.svg') }}" width="30px"> {{ trans('home.english') }}
                            </a>
                            <a class="dropdown-item" href="{{ url('/lang/dutch') }}">
                                <img src="{{ asset('svg/germany.svg') }}" width="30px"> {{ trans('home.deutsh') }}
                            </a>
                    </div>
                </div>

                @endif
                @if($tab=="billing-settings")
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('home.billing_settings') }}</div>
                    <div class="panel-body">    
                    <section class="pricing py-5">
                        <div class="container">
                            <div class="row">
                            <!-- Free Tier -->
                            <div class="col-lg-4">
                                <div class="card mb-5 mb-lg-0">
                                <div class="card-body">
                                    <h5 class="card-title text-muted text-uppercase text-center">Free</h5>
                                    <h6 class="card-price text-center">$0<span class="period">/month</span></h6>
                                    <hr>
                                    <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>1000 QUERIES PER MONTH</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>10GB Storage</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Single User</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>No Support</li>
                                    </ul>
                                    <a href="#" class="btn btn-block btn-primary text-uppercase">Already a member</a>
                                    
                                </div>
                                </div>
                            </div>
                            <!-- Plus Tier -->
                            <div class="col-lg-4">
                                <div class="card mb-5 mb-lg-0">
                                <div class="card-body">
                                    <h5 class="card-title text-muted text-uppercase text-center">Pro</h5>
                                    <h6 class="card-price text-center"><span class="period">$ 19 .99 /MON</span></h6>
                                    <hr>
                                    <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span><strong>3 Users</strong></li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>50GB Storage</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>10000 QUERIES PER MONTH</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Email support</li>
                                    </ul>
                                    <a href="#" class="btn btn-block btn-primary text-uppercase" data-toggle="modal" data-target="#paymentModal">{{ trans('home.upgrade') }}</a>
                                </div>
                                </div>
                            </div>
                            <!-- Pro Tier -->
                            <div class="col-lg-4">
                                <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-muted text-uppercase text-center">Entreprise</h5>
                                    <h6 class="card-price text-center"><span class="period">On Demand</span></h6>
                                    <hr>
                                    <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>On demand Accounts</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>On demand QUERIES per month</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>On demand Storage</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>24/7 Support</li>
                                    </ul>
                                    <a href="#" class="btn btn-block btn-primary text-uppercase" data-toggle="modal" data-target="#contactModal">{{ trans('home.contact') }}</a>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </section>
                    </div>
                </div>
                @section('scripts')
                <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
                <script type="text/javascript" src="{{ asset('js/checkout.js') }}"></script>
                <script src="https://www.paypalobjects.com/api/checkout.js"></script>
                <script type="text/javascript" src="{{ asset('js/checkout-paypal.js') }}"></script>


                @endsection

                @endif


                @if($tab=="billing-pricing")
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('home.payment_method') }}</div>
                    <div class="panel-body">
                        <p> You don’t have a Credit Card associated. Please add one. </p>
                        <button type="button" class="btn btn-primary">
                            Add One
                        </button>
                    </div>

                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">BILLING INFO</div>
                    <div class="panel-body">
    
                    </div>
                </div>
                @endif
                @if($tab=="billing-history")
                <div class="panel panel-default">
                    <div class="panel-heading">Billing History<span id="invoices" style="display:none;"> {{$invoices}}</span></div>
                    <div class="panel-body">
                    @if(count($invoices)==0)
                     You do not have any invoices.
                    @else

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">{{ trans('home.Amount') }}</th>
                                <th scope="col">{{ trans('home.Description') }}</th>
                                <th scope="col">{{ trans('home.State') }}</th>
                                <th scope="col">{{ trans('home.Date') }}</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <script>
                                var data = <?=json_encode($invoices)?>; // Don't forget to sanitize
                                data=data.data
                                    $.each(data, function (index, item) {
                                        var eachrow = "<tr>"
                                                    + "<td>" + data[index].amount_paid + "</td>"
                                                    + "<td>" + checkData(data[index].description) + "</td>"
                                                    + "<td>" + data[index].status + "</td>"
                                                    + "<td>" + new Date(data[index].date).toUTCString() + "</td>"
                                                    + "</tr>";
                                        $('#tbody').append(eachrow);
                                    });

                                function checkData(dataString) {
                                    if(dataString === 'null') {
                                        return dataString;
                                    }
                                    else return '';
                                }

                            </script>

                        </tbody>

                        </table> 
                        @endif                   
                    </div>
                </div>

                @endif

            </div>
        </div>

    </div>

<!-- payment modal  -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="form-group">
                    <div id="paypal-button">

                    </div>
                </div>
            </div>
            <hr class="mb-4">
            <form action="{{route('upgrade')}}" method="POST" id="payment-form">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email"><i class="fa fa-envelope"></i> Email Address</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name_on_card">Name on Card</label>
                            <input type="text" class="form-control" id="name_on_card"
                                name="name_on_card">
                        </div>
                    
                    </div>  
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="card-element">Credit Card</label>
                            <div id="card-element">
                                <!-- a Stripe Element will be inserted here. -->
                            </div>
                            <!-- Used to display form errors -->
                            <div id="card-errors" role="alert"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Accepted Cards</label>
                        <div class="icon-container">
                        <i class="fa fa-cc-visa" style="color:navy;"></i>
                        <i class="fa fa-cc-amex" style="color:blue;"></i>
                        <i class="fa fa-cc-mastercard" style="color:red;"></i>
                        <i class="fa fa-cc-discover" style="color:orange;"></i>
                        </div>
                    </div>
                </div>

                <div class="spacer"></div>

                <div class="modal-footer">
                    <div class="powered-by-stripe"></div>                
                    <button type="submit" class="btn btn-success">Pay 9.99$</button>
                </div>
    
            </form>
            </div>

        </div>
    </div>
</div>
                                            
<!-- contact modal  -->
<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
            <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Contact Us :</h4>
          <form action="{{route('contact')}}" method="POST">
          {{ csrf_field() }}

            <div class="mb-3">
              <label for="username">Full name : </label>
              <div class="input-group">
                <input type="text" class="form-control" id="username" name="full_name" placeholder="Username" required="">
                <div class="invalid-feedback" style="width: 100%;">
                  Your username is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="username">Company name : </label>
              <div class="input-group">
                <input type="text" class="form-control" name="company_name" id="company_name" placeholder="company Name" required="">
                <div class="invalid-feedback" style="width: 100%;">
                  Your Company name is required.
                </div>
              </div>
            </div>


            <div class="mb-3">
              <label for="email">Email <span class="text-muted">(Optional)</span></label>
              <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com">
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="mb-3">
              <label for="username">Phone Number : </label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-phone"></i></span>
                </div>
                <input type="text" class="form-control" name="phone" data-inputmask="&quot;mask&quot;: &quot;(999) 999-9999&quot;" data-mask="" im-insert="true">
                <div class="invalid-feedback" style="width: 100%;">
                  Your Phone is required.
                </div>
              </div>
              <div class="mb-3">
              <label for="">How Many Requests You expect per month :</label>
              <div class="input-group">
              <select class="custom-select d-block w-100" name="requests" id="requests" required="">
                  <option value="">Choose...</option>
                  <option>less 3000</option>
                  <option>between 3000,30000</option>
                  <option>more 30,000</option>
                </select>

              </div>


            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
          </form>
        </div>


            </div>

        </div>
    </div>
</div>





@endsection




@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="menu-nav-stacked">
                    <ul class="list-group">
                    <li class="list-group-item"> <i class="fas fa-chart-bar"></i>&nbsp; 
                    <a href="{{route('dashboard', ['tab' => 'plan-usage'])}}">Plan Usage</a>
                    </li>
                    <li class="list-group-item"> <i class="fas fa-user"></i>&nbsp; 
                        <a href="{{route('dashboard', ['tab' => 'profile'])}}">Profile</a>
                    </li>
                    <li class="list-group-item"> <i class="fas fa-lock"></i>&nbsp; 
                        <a href="{{route('dashboard', ['tab' => 'change-password'])}}">Change password</a>
                    </li>
                    <li class="list-group-item"> <i class="fas fa-money-check"></i>&nbsp;  
                        <a href="{{route('dashboard', ['tab' => 'biling-pricing'])}}">Billing and pricing</a>
                    </li>
                    <li class="list-group-item"> <i class="fas fa-history   "></i>&nbsp; 
                        <a href="{{route('dashboard', ['tab' => ''])}}">Billing and settings </a>
                    </li>
                    </ul>
                </div>                
            </div>
            <div class="col-md-9 ">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{session('status')}}
                        </div>
                    @endif                           
                    @if(session('errors'))
                        <div class="alert alert-success">
                            {{session('errors')}}
                        </div>
                    @endif                           
                        
                    </div>
                </div>
                
                @if($tab=="plan-usage")
                <div class="panel panel-default">
                    <div class="panel-heading">PLAN USAGE</div>
                    <div class="panel-body">

                    </div>
                </div>
                @endif
                @if($tab=="change-password")
                <div class="panel panel-default">
                    <div class="panel-heading">Change Password</div>
                    <div class="panel-body"></div>
                </div>
                @endif
                @if($tab=="profile")
                <div class="panel panel-default">
                    <div class="panel-heading">Profile - Change Email</div>
                    <div class="panel-body">
                    <form method="post" action="/home" id="editEmail-form">
                    @csrf   
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
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
                            >Submit</button>
                        </div>

                </div>
                @endif
                @if($tab=="plan-pricing")
                <div class="panel panel-default">
                    <div class="panel-heading">Panel Heading</div>
                    <div class="panel-body">Panel Content</div>
                </div>
                @endif
                @if($tab=="plan-pricing")
                <div class="panel panel-default">
                    <div class="panel-heading">Plans & Pricing</div>
                    <div class="panel-body">Panel Content</div>
                </div>
                @endif
                @if($tab=="billing-history")
                <div class="panel panel-default">
                    <div class="panel-heading">Billing History</div>
                    <div class="panel-body">Panel Content</div>
                </div>

                @endif

            </div>
        </div>

        <br>
        @if($message= Session::get('success'))
            <div class="alert alert-success">
                <p>{{$message}}</p>
            </div>
        @endif



    </div>
@endsection
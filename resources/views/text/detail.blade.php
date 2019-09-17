@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Text details</h3>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Text titel : </strong>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <strong>Text data : </strong> 
                </div>
            </div>
            <div class="col-md-12">
                <a href="{{route('text.index')}}" class="btn btn-sm btn-success">Back</a>
            </div>
        </div>
    </div>
@endsection
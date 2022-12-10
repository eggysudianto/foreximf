@extends('layouts.app_admin')

@section('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
<link rel="stylesheet" href="http://demo.expertphp.in/css/jquery.treeview.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('content')
<h1 class="h3 mb-2 text-gray-800">Member TreeView</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a style="float: left;" href="javascript:document.referrer ? window.location = document.referrer : history.back()" data-toggle="tooltip" title="Back">
                <i class="fa fa-arrow-left"> Back </i>
            </a>
        </div>
        <div class="card-body">
             {!! $tree !!}
        </div>
    </div>
@endsection

@section('js')
<script src="http://demo.expertphp.in/js/jquery.js"></script>   
<script src="http://demo.expertphp.in/js/jquery-treeview.js"></script>
<script type="text/javascript" src="http://demo.expertphp.in/js/demo.js"></script>
@endsection
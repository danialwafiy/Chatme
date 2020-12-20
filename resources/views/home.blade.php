@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center mb-5 d-block d-md-none">
        <h3 class="text-secondary text-center">WhatsApp Link Generator.</h3>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6 mb-4">
            <h1 class="text-center mb-4">Single Link</h1>
            <h1 class="text-center mb-4"><i class="fas fa-comment fa-5x"></i></h1>
            <h5 class="text-center mb-4 text-secondary font-weight-bold">WhatsApp instantly with a pretext chat.</h5>
            <button onclick="redirectAddSingleLink()" class="btn bg-custom border-success text-center col-md-4 offset-md-4 mb-4">Get Started !</button>
        </div>
        <div class="col-md-6">
            <h1 class="text-center mb-4">Group Link</h1>
            <h1 class="text-center mb-4"><i class="fas fa-comments fa-5x"></i></i></h1>
            <h5 class="text-center mb-4 text-secondary font-weight-bold"> Choose a pretext chat before WhatsApp.</h5>
            <button onclick="redirectAddGroupLink()" class=" btn bg-custom border-success text-center col-md-4 offset-md-4 mb-4">Get Started !</button>
        </div>
        <p class="d-none">{{$totalUser}}</p>
    </div>
</div>
<script>
    function redirectAddSingleLink(){
        location.href = "/single/add";
    };
    function redirectAddGroupLink(){
        location.href = "/group/add";
    };
</script>
@endsection


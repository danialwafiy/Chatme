@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="response-message"></div>
            <div class="card p-3 bg-custom shadow-lg text-dark">
                <h1 class="mb-3">Generate Single Link</h1>
                <form method="post" id="form-add-single-link">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Short URL</span>
                            <span class="input-group-text" id="wasap">chatme.my/s/</span>
                        </div>
                        <input type="text" class="form-control" name="short_url" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Phone No.</span>
                        </div>
                        <input type="text" class="form-control" name="phone" required>
                        <label class="w-100">Currently we only support Malaysia (+60) country code.</label>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Pretext Chat</span>
                        </div>
                        <textarea type="text" class="form-control" rows="6" name="pretext"></textarea>
                    </div>
                    <button class="btn btn-primary float-right" type="submit">Generate</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){$("#form-add-single-link").on("submit",function(e){e.preventDefault(),$("#response-message").empty();var s=$(this);$.ajax({method:"POST",url:"/singlelink",data:s.serialize(),success:function(e){e.success&&($("#response-message").append('<div class="alert alert-success">'+e.success+"</div>"),$("#form-add-single-link").trigger("reset")),e.error&&$("#response-message").append('<div class="alert alert-danger">'+e.error+"</div>")}})})});
</script>
@endsection



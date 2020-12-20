@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5" id="main-div" style="display:none">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="response-message"></div>
            <div class="card p-3 bg-custom shadow-lg text-dark">
                <h1 class="mb-3">Edit Link</h1>
                <form method="post" id="form-edit-link">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Short URL</span>
                            <span class="input-group-text">chatme.my/s/</span>
                        </div>
                        <input type="text" class="form-control" name="short_url" id="short_url" value="">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Phone No.</span>
                        </div>
                        <input type="text" class="form-control" name="phone" id="phone">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Pretext Chat</span>
                        </div>
                        <textarea type="text" class="form-control" rows="6" name="pretext" id="pretext"></textarea>
                    </div>
                    <button class="btn btn-primary float-right" type="submit">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){var e=window.location.href.substring(window.location.href.lastIndexOf("/")+1);$("#form-edit-link").on("submit",function(s){s.preventDefault(),$("#response-message").empty();var t=$(this);$.ajax({method:"PUT",url:"/singlelink/"+e,data:t.serialize(),success:function(e){e.success&&$("#response-message").append('<div class="alert alert-success">'+e.success+"</div>"),e.error&&$("#response-message").append('<div class="alert alert-danger">'+e.error+"</div>")}})})}),$(document).ready(function(){var e=window.location.href.substring(window.location.href.lastIndexOf("/")+1);$.ajax({type:"get",url:"/singlelink/"+e,dataType:"JSON",data:{_token:"{{ csrf_token() }}",id:e},success:function(e){$("#main-div").show();var s=decodeURIComponent(e.pretext);$("#type").val(e.social_type),$("#short_url").val(e.short_url),$("#title").val(e.title),$("#phone").val(e.phone),$("#pretext").val(s)}})});
</script>
@endsection



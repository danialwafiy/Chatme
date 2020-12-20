@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5" id="main-div" style="display:none">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="response-message"></div>
            <div class="card p-3 bg-custom shadow-lg text-dark">
                <h1 class="mb-3">Show Link</h1>
                <form id="form-show-link">
                    <fieldset disabled="disabled">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Short URL</span>
                            <span class="input-group-text">chatme.my/s/</span>
                        </div>
                        <input type="text" class="form-control" name="short_url" id="short_url" value="" >
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Phone No.</span>
                        </div>
                        <input type="text" class="form-control" name="phone" id="phone" >
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Pretext Chat</span>
                        </div>
                        <textarea type="text" class="form-control" rows="6" name="pretext" id="pretext" style="white-space: pre-line" ></textarea>
                    </div>
                    </fieldset>
                    <button class="btn btn-primary float-right" type="submit">Edit Link</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){$("#form-show-link").on("submit",function(t){t.preventDefault();var e=window.location.href.substring(window.location.href.lastIndexOf("/")+1);location.href="/single/edit/"+e})}),$(document).ready(function(){var t=window.location.href.substring(window.location.href.lastIndexOf("/")+1);$.ajax({type:"get",url:"/singlelink/"+t,dataType:"JSON",data:{_token:"{{ csrf_token() }}",id:t},success:function(t){$("#main-div").show();var e=decodeURIComponent(t.pretext);$("#type").val(t.social_type),$("#short_url").val(t.short_url),$("#title").val(t.title),$("#phone").val(t.phone),$("#pretext").val(e)}})});
</script>
@endsection



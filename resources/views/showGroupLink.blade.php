@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5" id="main-div" style="display:none">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="response-message"></div>
            <div class="card p-3 bg-custom shadow-lg text-dark">
                <h1 class="mb-3">Show Group Link</h1>
                <form method="post" id="form-show-group-link">
                    <fieldset disabled="disabled">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Short URL</span>
                            <span class="input-group-text">chatme.my/g/</span>
                        </div>
                        <input type="text" class="form-control" name="short_url" id="short_url">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Phone No.</span>
                        </div>
                        <input type="text" class="form-control" name="phone" id="phone">
                        <label class="w-100">Currently we only support Malaysia (+60) country code.</label>
                    </div>
                    <div id="pretext-group">
                    </div>
                    </fieldset>
                    <button class="btn btn-primary float-right" type="submit">Edit Link</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){$("#form-show-group-link").on("submit",function(t){t.preventDefault();var e=window.location.href.substring(window.location.href.lastIndexOf("/")+1);location.href="/group/edit/"+e})}),$(document).ready(function(){var t=window.location.href.substring(window.location.href.lastIndexOf("/")+1);$.ajax({type:"get",url:"/grouplink/"+t,dataType:"JSON",data:{_token:"{{ csrf_token() }}",shortURL:t},success:function(t){for($("#main-div").show(),$("#short_url").val(t.grouplink.short_url),$("#phone").val(t.grouplink.phone),i=0;i<t.pretext.length;i++){var e=decodeURIComponent(t.pretext[i]);input=$('<div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text">Pretext Chat</span></div><textarea type="text" class="form-control" rows="5" name="pretext_chat[]">'+e+"</textarea></div>"),$("#pretext-group").append(input)}}})});
</script>
@endsection



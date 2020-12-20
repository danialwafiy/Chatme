@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5" id="main-div" style="display:none">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="response-message"></div>
            <div class="card p-3 bg-custom shadow-lg text-dark">
                <h1 class="mb-3">Edit Group Link</h1>
                <form method="post" id="form-edit-group-link">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Short URL</span>
                            <span class="input-group-text">chatme.my/g/</span>
                        </div>
                        <input type="text" class="form-control" name="short_url" id="short_url" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Phone No.</span>
                        </div>
                        <input type="text" class="form-control" name="phone" id="phone" required>
                        <label class="w-100">Currently we only support Malaysia (+60) country code.</label>
                    </div>
                    <div id="pretext-group">
                    </div>
                    <button class="btn btn-success float-left" type="button" onclick="addMorePretext()">Add More Pretext Chat</button>
                    <button class="btn btn-primary float-right" type="submit">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
var totalPretext,i;function addMorePretext(){totalPretext<5?(input=$('<div class="input-group mb-3" id="div'+i+'"><div class="input-group-prepend"><span class="input-group-text">Pretext Chat</span></div><textarea type="text" class="form-control" rows="5" name="pretext_chat[]" required></textarea><button class="btn btn-danger" onclick="removePretext('+i+')">Remove</button></div>'),$("#pretext-group").append(input),i++,totalPretext++):alert("Maximum pretext is 5")}function removePretext(e){$("#div"+e).remove(),totalPretext--}$(document).ready(function(){var e=window.location.href.substring(window.location.href.lastIndexOf("/")+1);$("#form-edit-group-link").on("submit",function(t){t.preventDefault(),$("#response-message").empty();var r=$(this);totalPretext<2?$("#response-message").append('<div class="alert alert-danger">A minimum of 2 pretext is required to generate group link.</div>'):$.ajax({method:"PUT",url:"/grouplink/"+e,data:r.serialize(),success:function(e){e.success&&$("#response-message").append('<div class="alert alert-success">'+e.success+"</div>"),e.error&&$("#response-message").append('<div class="alert alert-danger">'+e.error+"</div>")}})})}),$(document).ready(function(){var e=window.location.href.substring(window.location.href.lastIndexOf("/")+1);$.ajax({type:"get",url:"/grouplink/"+e,dataType:"JSON",data:{_token:"{{ csrf_token() }}",shortURL:e},success:function(e){for($("#main-div").show(),$("#short_url").val(e.grouplink.short_url),$("#phone").val(e.grouplink.phone),totalPretext=e.pretext.length,console.log(totalPretext),i=0;i<e.pretext.length;i++){var t=decodeURIComponent(e.pretext[i]);input=$('<div class="input-group mb-3" id="div'+i+'"><div class="input-group-prepend"><span class="input-group-text">Pretext Chat</span></div><textarea type="text" class="form-control" rows="5" name="pretext_chat[]" required>'+t+'</textarea><button class="btn btn-danger" onclick="removePretext('+i+')">Remove</button></div>'),$("#pretext-group").append(input)}}})});
</script>
@endsection



@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="response-message"></div>
            <div class="card p-3 bg-custom shadow-lg text-dark">
                <h1 class="mb-3">Generate Group Link</h1>
                <form method="post" id="form-add-group-link">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Short URL</span>
                            <span class="input-group-text" id="wasap">chatme.my/g/</span>
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
                    <div id="pretext-group">
                        <div class="input-group mb-3">
                                <label class="w-100">You can add up to 5 pretext chat.</label>

                            <div class="input-group-prepend">
                                <span class="input-group-text">Pretext Chat</span>
                            </div>
                            <textarea type="text" class="form-control" rows="5" name="pretext_chat[]" required></textarea>
                        </div>
                    </div>
                    <button class="btn btn-success float-left" type="button" onclick="addMorePretext()"><i class="fas fa-plus"></i> Add Pretext Chat</button>
                    <button class="btn btn-primary float-right" type="submit">Generate</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
var totalPretext=1,i=1;function addMorePretext(){totalPretext<5?(input=$('<div class="input-group mb-3" id="div'+i+'"><div class="input-group-prepend"><span class="input-group-text">Pretext Chat</span></div><textarea type="text" class="form-control" rows="5" name="pretext_chat[]" required></textarea><button class="btn btn-danger" onclick="removePretext('+i+')">Remove</button></div>'),$("#pretext-group").append(input),i++,totalPretext++):alert("Maximum pretext is 5")}function removePretext(e){$("#div"+e).remove(),totalPretext--}$(document).ready(function(){$("#form-add-group-link").on("submit",function(e){e.preventDefault(),$("#response-message").empty();var t=$(this);totalPretext<2?$("#response-message").append('<div class="alert alert-danger">A minimum of 2 pretext is required to generate group link.</div>'):$.ajax({method:"POST",url:"/grouplink",data:t.serialize(),success:function(e){e.success&&($("#form-add-group-link").trigger("reset"),$("#response-message").append('<div class="alert alert-success">'+e.success+"</div>")),e.error&&$("#response-message").append('<div class="alert alert-danger">'+e.error+"</div>")}})})});
</script>
@endsection



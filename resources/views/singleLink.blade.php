@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="float-left col-md-8 col-2 clearfix">Single Link</h1>
            <a href="{{route('addSingleLink')}}" class="btn bg-custom border border-dark float-right my-auto"><i class="fas fa-plus"></i> Generate Single Link</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div id="response-message"></div>
                <table class="table text-center table-hover table-borderless table-responsive-sm rounded shadow p-3 mb-5" style="background-color:rgb(255, 255,255,0.5);">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Short URL</th>
                            <th scope="col">Phone No.</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($links as $key=>$links)
                        <tr class="post{{$links->id}}">
                            <td class="index">{{$key + 1}}</td>
                            <td>{{$links->short_url}}</td>
                            <td>{{$links->phone}}</td>
                        <td>
                            <button class="btn btn-info py-0" onclick="redirectShowPage({{$links->id}})"  title="Show"><i class="far fa-eye"></i></button>
                            <button class="btn btn-primary py-0" onclick="redirectEditPage({{$links->id}})"  title="Edit"><i class="fas fa-edit"></i> </button>
                            <button class="btn btn-danger py-0" onclick="removeLink({{$links->id}})"><i class="fas fa-trash" title="Delete"></i> </button>
                            <button class="btn btn-secondary py-0" onclick="copyLink({{json_encode($links->short_url)}},{{json_encode($links->social_type)}},{{json_encode($links->id)}})" title="Copy"><i class="fas fa-copy" data-toggle="popover" data-content="Link copied!" id="btn{{$links->id}}"></i> </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>
<script>
function redirectShowPage(e){location.href="/single/show/"+e}function removeLink(e){if(console.log(e),!confirm("Are you sure you want to Delete this link?"))return!1;$.ajax({type:"delete",url:"/singlelink/"+e,dataType:"JSON",data:{_token:"{{ csrf_token() }}",id:e},success:function(e){$("#response-message").append('<div class="alert alert-danger mx-auto">Link '+e.short_url+" deleted.</div>"),$(".post"+e.id).remove(),$("table tr").length>1&&$("td.index").text(function(e){return e+1})}})}function redirectEditPage(e){location.href="/single/edit/"+e}function copyLink(e,t,n){$("#btn"+n).popover("show"),setTimeout(function(){$("#btn"+n).popover("hide")},1e3);var o=window.location.host+'/s/'+e,i=document.createElement("input");i.setAttribute("type","text"),i.setAttribute("display","none"),i.setAttribute("value",o),document.body.appendChild(i),i.select(),document.execCommand("Copy"),i.parentElement.removeChild(i)}
</script>
@endsection


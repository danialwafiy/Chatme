@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="float-left col-md-8 col-2 clearfix">Group Link</h1>
            <a href="{{route('addGroupLink')}}" class="btn bg-custom border border-dark float-right my-auto"><i class="fas fa-plus"></i> Generate Group Link</a>
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
                        @foreach($grouplinks as $key=>$grouplinks)
                        <tr class="post{{$grouplinks->id}}">
                            <td class="index">{{$key + 1}}</td>
                            <td>{{$grouplinks->short_url}}</td>
                            <td>{{$grouplinks->phone}}</td>
                        <td>
                            <button class="btn btn-info py-0" onclick="redirectShowPage({{json_encode($grouplinks->short_url)}})"  title="Show"><i class="far fa-eye"></i></button>
                            <button class="btn btn-primary py-0" onclick="redirectEditPage({{json_encode($grouplinks->short_url)}})"  title="Edit"><i class="fas fa-edit"></i> </button>
                            <button class="btn btn-danger py-0" onclick="removeLink({{json_encode($grouplinks->short_url)}})"><i class="fas fa-trash" title="Delete"></i> </button>
                            <button class="btn btn-secondary py-0" onclick="copyLink({{json_encode($grouplinks->short_url)}},{{json_encode($grouplinks->social_type)}},{{json_encode($grouplinks->id)}})" title="Copy"><i class="fas fa-copy" data-toggle="popover" data-content="Link copied!" id="btn{{$grouplinks->id}}"></i> </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>
<script>
function redirectShowPage(e){location.href="/group/show/"+e}function removeLink(e){if(console.log(e),!confirm("Are you sure you want to Delete this link?"))return!1;$.ajax({type:"delete",url:"/grouplink/"+e,dataType:"JSON",data:{_token:"{{ csrf_token() }}",shortURL:e},success:function(e){$("#response-message").append('<div class="alert alert-danger mx-auto">Link '+e.short_url+" deleted.</div>"),$(".post"+e.id).remove(),$("table tr").length>1&&$("td.index").text(function(e){return e+1})}})}function redirectEditPage(e){location.href="/group/edit/"+e}function copyLink(e,t,o){$("#btn"+o).popover("show"),setTimeout(function(){$("#btn"+o).popover("hide")},1e3);var n="https://chatme.my/g/"+e,r=document.createElement("input");r.setAttribute("type","text"),r.setAttribute("display","none"),r.setAttribute("value",n),document.body.appendChild(r),r.select(),document.execCommand("Copy"),r.parentElement.removeChild(r)}
</script>
@endsection


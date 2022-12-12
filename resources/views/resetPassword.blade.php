@extends('layouts.app')

@section('content')

<div class="main">
    <div class="blankpage-form-field" style="width: 25%; margin: 0 auto; padding-top: 100px">
        <div id="message"></div>
        <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
            <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                <span class="page-logo-text mr-1">Restablecer contraseña</span>
            </a>
        </div>
        <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
                <input type="hidden" id="id" name="id" value="{{ $user }}">
                <div class="form-group">
                    <label class="form-label" for="password">Nueva Contraseña</label>
                    <input type="password" id="password" name="new-password" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label class="form-label" for="repet-password">Repetir Contraseña</label>
                    <input type="password" id="repet-password" name="repet-password" class="form-control" placeholder="">
                </div>
                <button onclick="save()" type="button" class="btn btn-primary float-right">Guardar</button>
            <hr>
            <div class="blankpage-footer text-center" >
                <a href="/login" style="font-size: 14px"><strong>Login</strong></a>
            </div>
        </div>
        
    </div>
</div>
<script>
    function save(){
        var datos = new FormData();
        datos.append("id", $("#id").val());
        datos.append("new-password", $("#password").val());
        datos.append("repet-password", $("#repet-password").val());

        $.ajax({
            url: "/api/updatePassword",
            method : "POST",
            data: datos,
            cache: false,
            contentType : false,
            processData : false,             
            success: function(response){
                let html = "";
                if(response.isSuccess){
                    html = "<div class='alert alert-success'>"+ response.message +"</div>";
                }else{
                    html = "<div class='alert alert-danger'>"+ response.message +"</div>";
                }
                $("#message").html(html);
                $("#password").val("");
                $("#repet-password").val("");
            }
        });
    }
</script>
@endsection
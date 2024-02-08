<template>
    <div class="back-login">
        <div class="blankpage-form-field">
            <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
                <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                    <span class="page-logo-text mr-1">Parking Derco | Recuperando contraseña</span>
                </a>
            </div>
            <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
                <form >
                    <div class="form-group">
                        <label class="form-label" for="password">Nueva Contraseña</label>
                        <input type="password" v-model="form.password" id="password" class="form-control" placeholder="nueva contraseña">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="repetPassword">Repetir Contraseña</label>
                        <input type="password" v-model="form.repetPassword" id="repetPassword" class="form-control" placeholder="repetir contraseña">
                    </div>
                    <button @click.prevent="recover" class="btn btn-primary float-right">Enviar</button>
                </form>
                <hr>
                <div class="blankpage-footer text-center">
                    <router-link to="/login" style="font-size: 14px"><strong>Login</strong></router-link>
                </div>
            </div>
            
        </div>
    </div>
    
</template>
<script>
export default {
    data(){
        return{
            form:{
                password: '',
                repetPassword: ''
            },
            errors: []
        }
    },
    methods:{
        async recover(){
            let self = this;
            await axios.get('api/sendResetLinkEmail/' + this.form.email)
                .then(response => {
                    if (!response.data.isSuccess) { 
                        self.$swal.fire({
                            icon: 'error',
                            title: 'Envio de email',
                            text: 'El correo ingresado no existe',
                        })
                    }
                    console.log(response);
                })
                .catch(function (error) {
                    self.$swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Ocurrio un error al enviar el correo!',
                    })
                });
         }
    }
}
</script>
<template>
    <div class="back-login">
        <div class="blankpage-form-field">
            <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
                <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                    <span class="page-logo-text mr-1">Parking Inchcape</span>
                </a>
            </div>
            <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
                <form >
                    <div class="form-group">
                        <label class="form-label" for="username">Usuario</label>
                        <input type="email" v-model="form.email" id="username" class="form-control" placeholder="Correo" value="">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Contraseña</label>
                        <input type="password" v-model="form.password" id="password" class="form-control" placeholder="contraseña" value="">
                    </div>
                    <!-- <div class="form-group text-left">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberme">
                            <label class="custom-control-label" for="rememberme"> Recordar contraseña(30 días)</label>
                        </div>
                    </div> -->
                    <button @click.prevent="login" class="btn btn-primary float-right w-100">
                        <span v-if="!isLoading">Iniciar Sesión</span>
                        <span v-if="isLoading">Ingresando...</span>
                    </button>
                </form>
                <hr>
                <div class="blankpage-footer text-center" >
                    <router-link to="/recover-password" style="font-size: 14px"><strong>Recuperar contraseña</strong></router-link>
                    <!-- | <router-link to="/register"><strong>Registrar Cuenta</strong></router-link> -->
                </div>
            </div>
            
        </div>
        <!-- <video poster="/public/admin/img/backgrounds/clouds.png" id="bgvid" playsinline autoplay muted loop>
            <source src="./public/admin/assets/media/video/cc.webm" type="video/webm">
            <source src="/public/admin/assets/media/video/cc.mp4" type="video/mp4">
        </video> -->
    </div>
    
</template>
<script>
export default {
    data(){
        return{
            form:{
                email: '',
                password: ''
            },
            isLoading: false,
            errors: []
        }
    },
    methods:{
        async login(){
            let self = this;
            this.isLoading = true;
            await axios.post('api/login', this.form)
                .then(response => {
                    localStorage.setItem('access_token', response.data.access_token);
                    self.$router.push({ name: "dashboard"}); 
                })
                .catch(function (error) {
                    self.$swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Usuario o Contraseña incorrectos!',
                    })
                })
                .finally(() => {
                    this.isLoading = false;
                });
        }
    }
}
</script>
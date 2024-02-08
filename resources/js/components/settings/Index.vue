<template>
    
    <main id="js-page-content" role="main" class="page-content">
        
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-chart-area'></i> Configuraciones 
                <small>
                </small>
            </h1>
        </div>
        <br>
        <div class="col-lg-12">
            <div class="panel-hdr mb-2 py-4">
                <div class="panel-toolbar">
                    <select name="sede" id="sede" class="browser-default custom-select" style="width: 200px;" @change="changeSelect" v-model="datos.sede_id">
                        <option v-for="sede in sedes" :key="sede.id+sede.name" :value="sede.id">{{sede.name }}</option>
                    </select>
                </div>
            </div>


            <div id="panel-4" class="panel">

                <div class="panel-hdr">
                        <h2 style="text-align: center; font-size: 1.125rem;"><b>Envío de correo</b></h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-success" @click="envio">Envio de correo</button>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Hora</span>
                                    </div>
                                    <input class="form-control" id="time" type="time" name="time" v-model="datos.time">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Correo principal</span>
                                    </div>
                                    <input type="email" id="email" name="email" aria-label="Email" class="form-control" v-model="datos.email">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend col-12 col-sm-12">
                                        <span class="input-group-text">Correos de copia</span>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                        <input type="email" id="email1" name="email1" aria-label="Email1" class="form-control" v-model="datos.email1">
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                        <input type="email" id="email2" name="email2" aria-label="Email2" class="form-control" v-model="datos.email2">
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                        <input type="email" id="email3" name="email3" aria-label="Email3" class="form-control" v-model="datos.email3">
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                                        <input type="email" id="email4" name="email4" aria-label="Email4" class="form-control" v-model="datos.email4">
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col align-self-end">
                                <button type="submit" class="btn btn-primary" @click.prevent="guardar">
                                    <span v-if="!isLoading">Guardar Cambios</span>
                                    <span v-if="isLoading">Guardando...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </main>
    
</template>
<script>

export default {
    name: "Setting",
    components: {

    },
    data(){
        return {
            isLoading: false,
            items:[],
            user: {},
            datos: {time:'', sede_id: 0, email:'',email1:'', email2:'', email3:'', email4:''},
            titulo:'',
            isLoading: false,
            sedes: []
        }
    },
    mounted: async function(){
        await this.init();
    },
    methods:{
        async init(){

            const token = localStorage.getItem('access_token');
            await axios.get('api/getSession/'+ token).then((res)=>{
                this.user = res.data;
            })

            this.renderCardSettings(this.user.sede_id)
        },
        async renderCardSettings(sede_id = 0) {
            await this.axios.get(`/api/setting?sede_id=${sede_id}`)
                    .then(response=>{
                        this.datos = response.data[0]
                        this.getSedes();
                    })
                    .catch(error=>{
                        console.log(error);
                        this.datos =[]
                    })
        },
        async getSedes() {
            await this.axios.get('/api/sede')
                .then((res) => {
                    this.sedes = res.data.sedes;
                })
                .catch((err) => {
                    console.log(err)
                })
        },
        guardar(){
            this.isLoading = true;

            axios.put('/api/setting/' + this.datos.id, this.datos).then(response=>{
                this.items = [].concat(response.data);          
                $('#modalForm').modal('hide');
                this.$swal.fire(
                    'Editado correctamente!',
                    '',
                    'success'
                )
                this.init();
                //swal("Felicidades!", "Usuario editado correctamente!", "success");
            }).catch(function (error) {
                console.log(error);
            })
            .finally(() => {
                this.isLoading = false;
            })
        },
        envio() {
            axios.post('/api/emailProgramacionSemanal').then((res) => {
                if (res.data.success) {
                    this.$swal.fire(
                        'Correo enviado',
                        '',
                        'success'
                    )
                } else { 
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Error de envio',
                        text: res.data.error,
                    })
                }
               
            }).catch(error => {
                this.$swal.fire({
                    icon: 'error',
                    title: 'Error de envio',
                    text: 'Ocurrio un error',
                })
            }); 
        },
        changeSelect(e) {
            this.renderCardSettings(e.target.value)
        }
    }
}
</script>

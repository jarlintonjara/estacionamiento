<template>
    <main id="js-page-content" role="main" class="page-content">
        <div class="content">
            <div class="subheader">
                <h1 class="subheader-title">
                    <i class="subheader-icon fal fa-chart-area"></i>Sedes
                </h1>
            </div>
    
            <div class="col-lg-12">
                <div id="panel-4" class="panel">
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="panel-hdr">
                                <button class="btn btn-success" @click="openModalCreate">Nuevo</button>
                            </div>
                        </div>
    
                        <div class="container">
                            <table class="table table-bordered table-hover table-striped w-100" id="tableSedes">
                                <thead class="bg-warning-200">
                                    <tr class="text-center">
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="sedes.length == 0" class="text-center">
                                        <td colspan="3">No hay datos</td>
                                    </tr>
    
                                    <tr v-if="sedes.length > 0" v-for="sede in sedes" class="text-center">
                                        <td>{{sede.name}}</td>
                                        <td>{{sede.email}}</td>
                                        <td>
                                            <button class="btn btn-warning" @click="editSede(sede)">
                                                <i class="far fa-edit"></i></button>
    
                                            <button class="btn btn-danger" @click="deleteSede(sede.id)">
                                                <i class="fa fa-trash"></i>
                                                </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalSede">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-titlte">
                            <i class="fa fa-build"></i>
                            {{title}}
                        </h5>
                        <button class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Nombre</label>
                                    <input type="text" id="name" class="form-control" required v-model="fields.name">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="email">Correo</label>
                                    <input type="email" id="email" class="form-control" required v-model="fields.email">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" @click="closeModal">Cerrar</button>

                        <button type="submit" @click.prevent="createSede" v-if="isCreated" class="btn btn-primary">
                            <span v-if="isLoading">Guardando...</span>
                            <span v-if="!isLoading">Crear</span>
                        </button>

                        <button type="submit" @click.prevent="updateSede" v-if="isEdit" class="btn btn-primary">
                            <span v-if="isLoading">Actualizando...</span>
                            <span v-if="!isLoading">Actualizar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>        
    </main>
</template>

<script>
    import Spinner from '../Spinner.vue';
    
    export default {
        name: "Sede",
        components: {
            Spinner
        },
        data(){
            return {
                title: '',
                fields: {
                    name: '',
                    email: ''
                },
                isEdit: false,
                isCreated: false,
                sedes: [],
                isLoading: false,
                id: 0
            }
        },
        mounted() {
            this.getSedes()
        },
        methods: {
            validateFields() {
                if(this.fields.name === "") {
                    this.$swal.fire({
                        icon: 'error',
                        'title': 'Oops...',
                        text: 'El campo nombre es requerido'
                    });
                    return false;
                } 

                if(this.fields.email === "") {
                    this.$swal.fire({
                        icon: 'error',
                        'title': 'Oops...',
                        text: 'El campo correo es requerido'
                    });
                    return false;
                }

                return true;
            },
            async getSedes(){
                this.isLoading = true;

                await this.axios.get('/api/sede')
                    .then(response => {
                        this.sedes = response.data.sedes
                    })
                    .catch(err => {
                        console.log(err)
                    })
                    .finally(() => {
                        this.isLoading = false;
                    })

                    $("#tableSedes").DataTable().destroy();
                    $("#tableSedes").DataTable();
            },
            openModalCreate() {
                this.title = "Crear Sede";
                this.isCreated = true;
                this.isEdit = false;

                this.reset()

                $('#modalSede').modal('show')
            },
            closeModal() {
                this.title = "";
                $('#modalSede').modal('hide')
            },
            async createSede() {
                let errors = this.validateFields();

                if(errors) {
                    this.isLoading = true;

                    axios.post('api/sede', this.fields)
                    .then((res) => {
                        this.$swal.fire({
                            'icon': 'success',
                            'title': '',
                            'text': 'Sede creada Exitosamente'
                        });
    
                        this.reset();
                        $("#modalSede").modal("hide");
    
                        this.getSedes()
                    })
                    .catch((err) => {
                        console.log(err)
                    })            
                    .finally(() => {
                        this.isLoading = false;
                    })        
                }
            },
            async editSede(sede) {
                this.fields.name = sede.name;
                this.fields.email = sede.email;
                this.title = "Editar Sede " + sede.name;
                this.isEdit = true;
                this.isCreated = false;
                this.id = sede.id

                $("#modalSede").modal("show");
            },
            async updateSede() {
                let errors = this.validateFields();

                if(errors) {
                    this.isLoading = true;
                    axios.put('api/sede/' + this.id, this.fields)
                    .then((res) => {
                        $("#modalSede").modal("hide");
                        this.getSedes();
                    })
                    .catch((err) => {
                        console.log(err)
                    })
                    .finally(() => {
                        this.isLoading = false;
                    })
                }
            },
            async deleteSede(id) {
                this.$swal.fire({
                    icon: 'warning',
                    title: 'Eliminacion de Registro',
                    text: '¿Estas seguro de eliminar este registro?'
                })
                .then((res) => {
                    if(res.isConfirmed) {
                        axios.delete('/api/sede/' + id)
                        .then((res) => {
                            console.log(' -------- eliminar sede -------- ')
                        })
                        .finally(() => {
                            this.$swal.close();
                            window.location.reload();
                        })
                    }
                })
            },
            loading: function(){
                this.$swal.fire({
                    title: 'Cargando...',
                    html: `
                        <div class="spinner-border text-primary my-4" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    onBeforeOpen: () => {
                        this.$swal.showLoading()
                    }
                });
            },
            reset() {
                this.fields.name = "";
                this.fields.email = "";
            }
        },
    }
</script>
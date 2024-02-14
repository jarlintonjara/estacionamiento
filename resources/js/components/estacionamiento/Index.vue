<template>
    
    <main id="js-page-content" role="main" class="page-content">

        <div class="content">
            <div class="subheader">
                <h1 class="subheader-title">
                    <i class='subheader-icon fal fa-chart-area'></i> Estacionamiento 
                </h1>
            </div>
            <div class="col-lg-12">
                    <div id="panel-4" class="panel">
                        <div class="panel-container show">
                            <div class="panel-content">
                                <div class="panel-hdr">
                                    <button class="btn btn-success" @click="openModalCreate">Nuevo</button>
                                </div><br>
                                <table id="dt-estacionamiento" class="table table-bordered table-hover table-striped w-100">
                                    <thead class="bg-warning-200">
                                        <tr class="text-center">
                                            <th>N.Estación</th>
                                            <th>Sede</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>    
                                        <tr v-if="estacionamientos.length > 0" v-for="estacionamiento in estacionamientos" class="text-center">
                                            <td>{{estacionamiento.numero}}</td>
                                            <td>{{estacionamiento.sede.name}}</td>
                                            <td>
                                                <button class="btn btn-warning" @click="editModal(estacionamiento)">
                                                    <i class="far fa-edit"></i>
                                                </button>
    
                                                <button class="btn btn-danger" @click="deleteElem(estacionamiento.id)">
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
            
            <div class="modal fade" id="modalEstacionamiento">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                {{title}}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="nro">Numero</label>
                                        <input class="form-control" type="text" id="nro" required v-model="fields.nro">
                                    </div>
        
                                    <div class="form-group col-md-6">
                                        <label for="sede_id">Sede</label>
                                        <select name="sede_id" id="sede_id" class="browser-default custom-select form-control" v-model="fields.sede_id">
                                            <option>Seleccione una Sede</option>
                                            <option v-for="sede in sedes" :key="sede.name + sede.id" :value="sede.id">{{sede.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" @click="closeModal">Cerrar</button>
    
                            <button type="submit" class="btn btn-primary" @click.prevent="create" v-if="isCreated" >
                                <span v-if="isLoading">Guardando..</span>
                                <span v-if="!isLoading">Crear</span>
                            </button>
    
                            <button type="submit" class="btn btn-primary" v-if="isEdit" @click.prevent="update">
                                <span v-if="isLoading">Actualizando...</span>
                                <span v-if="!isLoading">Actualizar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal ver detalles -->
            <!-- <div class="modal fade" id="modalDetalle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title"><i class="fas fa-info-circle"></i> Detalles del usuario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped">                  
                                    <tbody>
                                        <tr>
                                        <th scope="row">Numero</th><td>{{info.name}}</td></tr>
                                        <tr>
                                        <th scope="row">E-Sede</th>                      
                                            <td>{{info.email}}</td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Ubicación</th>                      
    
                                        </tr>
                                        <tr>
                                        <th scope="row">Fecha actualización</th>
                                    
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div> -->
    </main>

</template>
<script>

import Spinner from '../Spinner.vue';

export default {
    name: "Estacionamiento",
    components: {
        Spinner
    },
    data(){
        return {
            session: {},
            fields: {
                nro: '',
                sede_id: ''
            },
            sedes: [],
            title: '',
            id: 0,
            estacionamientos: [],
            isEdit: false,
            isCreated: false,
            isLoading: false
        }
    },
    created: function() {
        const curr_user = localStorage.getItem('curr_user');
        this.session = JSON.parse(curr_user);
    },
    mounted(){
        this.getEstacionamiento();
    },
    methods: {
        validateFields() {
            if(this.fields.nro === "") {
                this.$swal.fire({
                    'icon': 'warning',
                    'title': 'Oops...',
                    'text': 'El campo numero es requerido'
                });
                return false;
            }

            if(this.fields.sede_id === "") {
                this.$swal.fire({
                    'icon': 'warning',
                    'title': 'Oops...',
                    'text': 'El campo sede es requerido'
                });
                return false;
            }

            return true;
        },
        getEstacionamiento: async function(sede_id = this.session.curr_sede_id) {

            this.isLoading = true;

            await axios.get(`/api/estacionamiento?curr_sede_id=${sede_id}`)
                .then((res) => {
                    this.sedes = res.data.sedes;
                    this.estacionamientos = res.data.estacionamientos;
                })
                .catch((err) => {
                    console.log(err)
                })
                .finally(() => {
                    this.isLoading = false;
                })

                this.$tablaGlobal('#dt-estacionamiento');
        },
        openModalCreate() {
            this.isEdit = false;
            this.isCreated = true;
            this.title = "Crear Estacionamiento"
            this.reset();

            $("#modalEstacionamiento").modal("show")
        },
        closeModal() {
            $("#modalEstacionamiento").modal("hide")
        },
        create: function () {
            let errors = this.validateFields();

            if(errors) {
                this.isLoading = true;

                axios.post('/api/estacionamiento', this.fields)
                    .then((res) => {
                        $("#modalEstacionamiento").modal("hide")

                        this.getEstacionamiento();
                    })
                    .catch((err) => {
                        console.log(err)
                    })
                    .finally(() => {
                        this.isLoading = false;
                    })
            }
        },
        editModal(estacionamiento) {
            this.title = "Editar Estacionamiento " + estacionamiento.numero;

            this.isCreated = false;
            this.isEdit = true;

            this.id = estacionamiento.id;
            this.fields.nro = estacionamiento.numero;
            this.fields.sede_id = estacionamiento.sede_id;

            $("#modalEstacionamiento").modal("show")
        },
        async update() {
            let errors = this.validateFields();

            if(errors) {
                this.isLoading = true;

                axios.put('/api/estacionamiento/' + this.id, this.fields)
                    .then((res) => {
                        this.getEstacionamiento()
                        $("#modalEstacionamiento").modal("hide")
                    })
                    .catch((err) => {
                        console.log(err)
                    })
                    .finally(() => {
                        this.isLoading = false;
                    })
            }
        },
        reset() {
            this.fields.nro = "";
            this.fields.sede_id = "";
        },
        async deleteElem(id) {
            this.$swal.fire({
                icon: 'warning',
                title: 'Eliminacion de Registro',
                text: '¿Estas seguro de eliminar este registro?'
            })
            .then((res) => {
                if(res.isConfirmed) {
                    axios.delete('/api/estacionamiento/' + id)
                    .then((res) => {
                        this.getEstacionamiento()
                    })
                    .finally(() => window.location.reload() )
                }
            })
        }
    },
}

</script>
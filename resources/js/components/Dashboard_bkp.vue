<template>
    <main id="js-page-content" role="main" class="page-content">
        <div class="content">
            <div class="subheader">
                <h1 class="subheader-title">
                    <i class='subheader-icon fal fa-chart-area'></i> <span class='fw-300'>Dashboard</span>
                </h1>
            </div>
    
            <!-- Sedes -->
            <div class="row mb-4">
                <div class="d-flex d-flex-row my-4 outline-0 border-0 p-0" v-if="user && user.role_id === 1">
                    <select name="sedes" id="sedes" class="browser-default custom-select" style="width: 200px;" @change="changeSede" v-model="user.sede_id">
                        <option v-for="sede in sedes" :key="sede.id+sede.name" :value="sede.id">{{sede.name }}</option>
                    </select>
                </div>
            </div>

            <!-- Total Usuarios, Estacionamientos y Programaciones -->
            <div class="row d-flex gap-4 mb-5">
                <div class="bg-success-400 col-12 col-lg-3 rounded-lg p-3">
                    <h5 style="font-weight: bold">Usuarios</h5>
                    <h3>{{ report.totalUsers }}</h3>
                </div>
    
                <div class="bg-warning-400 col-12 col-lg-3 ronded-lg p-3">
                    <h5 style="font-weight: bold">Estacionamientos</h5>
                    <h3>{{ report.totalParkings }}</h3>
                </div>
    
                <div class="bg-info-400 col-12 col-lg-3 rounded-lg p-3">
                    <h5 style="font-weight: bold">Programaciones</h5>
                    <h3>{{ report.totalSchedules }}</h3>
                </div>
            </div>

            <div class="row d-flex gap-4 my-5">
                <div class="col-sm-12 col-md-6 col-md-5 col-xl-5 p-0" @click="showitem(1)">
                        <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g" style="cursor:pointer">
                            <div class="d-flex mt-2">
                                <h5><b>ESTACIONES OCUPADOS HOY</b></h5>
                                <span class="d-inline-block ml-auto">
                                    <h5><b> {{ programacionhoy.length }} / {{ programacionhoy.length + estacioneshoy.length }}
                                    </b></h5>
                                </span>
                            </div>
                            <div class="progress progress-sm mb-3">
                                <div class="progress-bar bg-fusion-400" role="progressbar"
                                    v-bind:style="{ width: indices.totalHoy + '%' }" aria-valuenow="65" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex">
                                <h5><b>ESTACIONES DISPONIBLES HOY</b></h5>
                                <span class="d-inline-block ml-auto">
                                    <h5><b> {{ estacioneshoy.length }} / {{ programacionhoy.length + estacioneshoy.length }}
                                        </b></h5>
                                </span>
                            </div>
                            <div class="progress progress-sm mb-3">
                                <div class="progress-bar bg-success-500" role="progressbar"
                                    v-bind:style="{ width: ((estacioneshoy.length / (programacionhoy.length + estacioneshoy.length)) * 100) + '%' }"
                                    aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex">
                                <h5><b>OCUPABILIDAD HOY</b></h5>
                                <span class="d-inline-block ml-auto">
                                    <h5><b>{{ indices.totalHoy }} %</b></h5>
                                </span>
                            </div>
                            <div class="progress progress-sm mb-3">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success-600"
                                    role="progressbar" v-bind:style="{ width: indices.totalHoy + '%' }" aria-valuenow="77"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6"
                                style="font-size: 8rem;"></i>
                        </div>
                </div>

                <div class="col-sm-12 col-md-6 col-md-5 col-xl-5 p-0" @click="showitem(2)">
                        <div class="p-3 bg-danger-200 rounded overflow-hidden position-relative text-white mb-g" style="cursor:pointer">
                            <div class="d-flex mt-2">
                                <h5><b>ESTACIONES OCUPADOS MAÑANA</b></h5>
                                <span class="d-inline-block ml-auto">
                                    <h5><b> {{ programacionma.length }} / {{ programacionma.length + estacionesma.length }} </b>
                                    </h5>
                                </span>
                            </div>
                            <div class="progress progress-sm mb-3">
                                <div class="progress-bar bg-fusion-400" role="progressbar"
                                    v-bind:style="{ width: indices.totalManana + '%' }" aria-valuenow="65" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex">
                                <h5><b>ESTACIONES DISPONIBLES MAÑANA</b></h5>
                                <span class="d-inline-block ml-auto">
                                    <h5><b> {{ estacionesma.length }} / {{ programacionma.length + estacionesma.length }} </b>
                                    </h5>
                                </span>
                            </div>
                            <div class="progress progress-sm mb-3">
                                <div class="progress-bar bg-success-500" role="progressbar"
                                    v-bind:style="{ width: ((estacionesma.length / (programacionma.length + estacionesma.length)) * 100) + '%' }"
                                    aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex">
                                <h5><b>OCUPABILIDAD MAÑANA</b></h5>
                                <span class="d-inline-block ml-auto">
                                    <h5><b>{{ indices.totalManana }} %</b></h5>
                                </span>
                            </div>
                            <div class="progress progress-sm mb-3">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success-600"
                                    role="progressbar" v-bind:style="{ width: indices.totalManana + '%' }" aria-valuenow="77"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <i class="fal fa-lightbulb position-absolute pos-right pos-bottom opacity-15 mb-n5 mr-n6"
                                style="font-size: 8rem;"></i>
                        </div>
                </div>                
            </div>

            <!-- Estacionamientos Ocupados Hoy -->
            <div class="row">
                <div class="col-sm-12 col-md-6 col-md-2 col-xl-2" style="display: none;">
                    <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g"
                        style="margin-bottom: 1%!important;">
                        <div class="">
                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                {{ report.totalUsers }}
                                <small class="m-0 l-h-n">Usuarios</small>
                            </h3>
                        </div>
                        <i class="fal fa-user position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1"
                            style="font-size:6rem; margin-bottom: 1%!important;"></i>
                    </div>
                    <div class="p-3 bg-warning-400 rounded overflow-hidden position-relative text-white mb-g">
                        <div class="">
                            <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                {{ report.totalParkings }}
                                <small class="m-0 l-h-n">Estacionamientos</small>
                            </h3>
                        </div>
                        <i class="fal fa-gem position-absolute pos-right pos-bottom opacity-15  mb-n1 mr-n4"
                            style="font-size: 6rem;"></i>
                    </div>
                </div>
            </div>
    
    
            <div class="row" id="hoy" style="display:none;">
                <div class="col-lg-12 p-0">
                    <div id="panel-4" class="panel">
                        <div class="panel-hdr">
                            <h2>
                                <h2 style="text-align: center; font-size: 1.125rem;"><b> ESTACIONAMIENTOS OCUPADOS HOY</b>
                                </h2>
                            </h2>
                            <div class="panel-toolbar">
                                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse"
                                    data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen"
                                    data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button> -->
                            </div>
                        </div>
                        <div class="panel-container show">
                            <div class="panel-content">
                                <!-- inicio datatable end -->
                                <table id="td-ocupadoshoy" class="table table-bordered table-hover table-striped w-100">
                                    <thead class="bg-warning-200">
                                        <tr>
                                            <th>Estacionamiento</th>
                                            <th>Usuario</th>
                                            <th>DNI</th>
                                            <th>Fecha Programada</th>
                                            <th>Hora Incio</th>
                                            <th>Hora Final</th>
                                            <th>Fecha creación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="pm in programacionhoy" :key="pm.parking.numero+pm.id">
                                            <td>{{ pm.parking.numero }}</td>
                                            <td>{{ pm.user.nombre + " " + pm.user.apellido }}</td>
                                            <td>{{ pm.user.documento }}</td>
                                            <td>{{ pm.fecha }}</td>
                                            <td>{{ pm.hora_inicio }}</td>
                                            <td>{{ pm.hora_fin }}</td>
                                            <td>{{ $dateFormat(pm.created_at) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- datatable end -->
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-lg-12 p-0">
                    <div id="panel-4" class="panel">
                        <div class="panel-hdr">
                            <h2>
                                <h2 style="text-align: center; font-size: 1.125rem;"><b> ESTACIONAMIENTOS DISPONIBLES
                                        HOY</b></h2>
                            </h2>
                            <div class="panel-toolbar">
                                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse"
                                    data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen"
                                    data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button> -->
                            </div>
                        </div>
                        <div class="panel-container show">
                            <div class="panel-content">
    
                                <!-- inicio datatable end -->
                                <table id="td-disponibleshoy" class="table table-bordered table-hover table-striped w-100">
                                    <thead class="bg-warning-200">
                                        <tr>
                                            <th>Número</th>
                                            <th>Sede</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="pmd in estacioneshoy" :key="pmd.numero+pmd.id">
                                            <td>{{ pmd.numero }}</td>
                                            <td>{{ pmd.sede_name }}</td>
                                            <td>{{ pmd.sede_email }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- datatable end -->
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>
    
            <div class="row" id="manana" style="display:none;">
                <div class="col-lg-12 p-0">
                    <div id="panel-4" class="panel">
                        <div class="panel-hdr">
                            <h2>
                                <h2 style="text-align: center; font-size: 1.125rem;"><b> ESTACIONAMIENTOS OCUPADOS PARA
                                        MAÑANA</b></h2>
                            </h2>
                            <div class="panel-toolbar">
                                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse"
                                    data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen"
                                    data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button> -->
                            </div>
                        </div>
                        <div class="panel-container show">
                            <div class="panel-content">
    
                                <!-- inicio datatable end -->
                                <table id="td-ocupadosman" class="table table-bordered table-hover table-striped w-100">
                                    <thead class="bg-warning-200">
                                        <tr>
                                            <th>Estacionamiento</th>
                                            <th>Usuario</th>
                                            <th>DNI</th>
                                            <th>Fecha Programada</th>
                                            <th>Hora Incio</th>
                                            <th>Hora Final</th>
                                            <th>Fecha creación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="pm in programacionma" :key="pm.parking.numero+pm.id">
                                            <td>{{ pm.parking.numero }}</td>
                                            <td>{{ pm.user.nombre + " " + pm.user.apellido }}</td>
                                            <td>{{ pm.user.documento }}</td>
                                            <td>{{ pm.fecha }}</td>
                                            <td>{{ pm.hora_inicio }}</td>
                                            <td>{{ pm.hora_fin }}</td>
                                            <td>{{ $dateFormat(pm.created_at) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- datatable end -->
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-lg-12 p-0">
                    <div id="panel-4" class="panel">
                        <div class="panel-hdr">
                            <h2>
                                <h2 style="text-align: center; font-size: 1.125rem;"><b> ESTACIONAMIENTOS DISPONIBLES PARA MAÑANA</b></h2>
                            </h2>
                            <div class="panel-toolbar">
                                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse"
                                    data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen"
                                    data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                                <!-- <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button> -->
                            </div>
                        </div>
                        <div class="panel-container show">
                            <div class="panel-content">
    
                                <!-- inicio datatable end -->
                                <table id="td-disponiblesman" class="table table-bordered table-hover table-striped w-100">
                                    <thead class="bg-warning-200">
                                        <tr>
                                            <th>Número</th>
                                            <th>Sede</th>
                                            <th>Email</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="pmd in estacionesma" :key="pmd.numero+pmd.id">
                                            <td>{{ pmd.numero }}</td>
                                            <td>{{ pmd.sede_name }}</td>
                                            <td>{{ pmd.sede_email }}</td>
                                            <td style="display: none">
                                                <a :href="'https://api.whatsapp.com/send?phone=51' + pmd.telefono +'&text=Hola'"
                                                    target="_blank" v-if="pmd.telefono && pmd.telefono.length == 9"
                                                    class="btn btn-success">
                                                    <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <button @click="abrirModal(pmd)" class="btn btn-primary" v-if="pmd.email && pmd.email.includes('@')">
                                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                                    Reservar
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- datatable end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="modal fade" id="modalForm">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> <i class="fa fa-paper-plane"></i> Solicitud por Email</h5>
                            <button @click.prevent="cerrarModal" type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form>
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="Propietario">Propietario:</label>
                                        <input type="text" id="Propietario" class="form-control" placeholder="" required="" v-model="propietario" :disabled="true">
            
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Estacionamiento">Estacionamiento:</label>
                                        <input type="text" id="Estacionamiento" class="form-control" placeholder="Ej. SOTANO 1" required="" v-model="numero" :disabled="true">
                                    </div>
                                </div>
    
                                <div class="form-row mb-5">
                                    <div class="form-group col-md-6">
                                        <label for="Fecha">Fecha:</label>
                                        <input type="text" id="Fecha" class="form-control" placeholder="" required="" v-model="fecha"
                                            :disabled="true">
                                    </div>
                                </div>
    
                                <div class="form-row mb-2">
                                    <!-- <div class="form-group col-md-4">
                                        <label for="Fecha">Fecha de programación</label>
                                        <input v-if="btnEditar" type="date" id="pickerProgramacion" class="form-control" placeholder="Fecha"
                                            v-model="datos.fecha">
                                
                                        <date-range-picker v-if="!btnEditar" v-model="pickerDates" :locale-data="locale">
                                            <template v-slot:input="pickerDates" style="min-width: 350px;">{{
                                                pickerDates.startDate | date }} - {{ pickerDates.endDate | date
                                                }} <i class="fa fa-calendar"></i></template>
                                        </date-range-picker>
                                    </div> -->
                                    <div class="frame-wrap bg-faded col-md-12">
                                        <div class="custom-control custom-checkbox d-inline-flex mr-3">
                                            <input type="checkbox" class="custom-control-input" name="bordered" id="option-bordered" v-model="allDay"
                                                @click="onChange('D')">
                                            <label class="custom-control-label" for="option-bordered">Todo el día</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-flex mr-3">
                                            <input type="checkbox" class="custom-control-input" name="small" id="option-small" v-model="morning"
                                                @click="onChange('M')">
                                            <label class="custom-control-label" for="option-small">Mañana</label>
                                        </div>
                                        <div class="custom-control custom-checkbox d-inline-flex mr-3">
                                            <input type="checkbox" class="custom-control-input" name="small" id="option-small2" v-model="afternoon"
                                                @click="onChange('T')">
                                            <label class="custom-control-label" for="option-small2">Tarde</label>
                                        </div>
                                    </div>
    
                                    
                                </div>
    
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="hora_inicio">Hora Inicio:</label>
                                        <input type="time" min="06:00" max="18:00" id="hora_inicio" class="form-control" :disabled="true"
                                            placeholder="Hora inicio" v-model="datos.hora_inicio">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="hora_fin">Hora Fin:</label>
                                        <input type="time" min="06:00" max="18:00" id="hora_fin" class="form-control" :disabled="true"
                                            placeholder="Hora fin" v-model="datos.hora_fin">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" @click.prevent="cerrarModal"
                                    data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" @click.prevent="sendEmail">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>

import Spinner from './Spinner.vue';

export default {
    components: {
        Spinner
    },
    data() {
        let date = new Date();
        date.setDate(date.getDate() + 1);
        return{
            item1:true,
            item2: false,
            user: null,
            isLoading: false,
            schedules: [],
            sedes: [],
            programacionma: [],
            estacionesma: [],
            programacionhoy: [],
            estacioneshoy: [],
            allDay: false,
            morning: false,
            afternoon: false,
            disabled: false,
            datos: {
                estacionamiento_id: '',
                user_id: '',
                fecha: date,
                fecha_inicio: '',
                fecha_fin: '',
                hora_inicio: '',
                hora_fin: '',
                turno: '',
                observacion: '',
                created_by: ''
            },
            propietario: "",
            numero: "",
            fecha: date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear(),
            report: {
                totalUsers : 0,
                totalParkings : 0,
                totalSchedules: 0,
                programacionManana: 0
            },
            indices: {
                totalHoy: 0,
                totalManana: 0,
                totallHoy: 0,
                totallManana: 0
            }
        }
    },
    mounted(){
        this.init();
    },
    methods:{
        async getDataDashboard(filters = false, sede_id = 
        this.user.sede_id) {
            this.isLoading = true;

            await this.axios.get(`/api/dashboard?user_id=${this.user.id}&filters=${filters}&sede_id=${sede_id}`)
                    .then(response=> {                        
                        let report = response.data;

                        console.log(response.data)

                        this.sedes = report.sedes;
                        this.report.totalUsers = report.total_users;
                        this.report.totalParkings = report.total_parkings;
                        this.report.totalSchedules = report.total_schedules;
                        this.schedules = report.schedules
                        this.estacioneshoy = report.estacioneshoy;
                        this.programacionhoy = report.programacionhoy;
                        this.programacionma = report.programacionma;
                        this.estacionesma = report.estacionesma;

                        this.indices.totalHoy = Math.round((this.programacionhoy.length / (this.programacionhoy.length + this.estacioneshoy.length) ) * 100);
                        this.indices.totalManana = Math.round((this.programacionma.length / (this.programacionma.length + this.estacionesma.length) ) * 100);

                    //     this.report.programacionManana = report.programacionManana;
                        
                    })
                    .catch(error=>{
                        console.log(error.msg);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });

                    this.$tablaGlobal('#td-ocupadoshoy');
                    this.$tablaGlobal('#td-disponibleshoy');
                    this.$tablaGlobal('#td-ocupadosman');
                    this.$tablaGlobal('#td-disponiblesman');
        },
        async init() {
            this.isLoading = true;
            
            const token = localStorage.getItem('access_token');
            await axios.get('api/getSession/' + token).then((res) => {
                this.user = res.data;
            });

            await this.getDataDashboard();
        },
        showitem(option){
            var x = document.getElementById("hoy");
            var y = document.getElementById("manana");
            if(option == 1){
                    y.style.display = "none";
                    x.style.display = "block";
            }else if(option == 2){
                    y.style.display = "block";
                    x.style.display = "none";
            }
        },
        async sendEmail() {
            if (!this.datos.estacionamiento_id || !this.datos.user_id || !this.datos.hora_inicio || !this.datos.hora_fin) {
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Completa los campos requeridos!',
                });
                return false;
            }
            await axios.post('/api/sendProgrammingLink',{
                    'user': this.user,
                    'programacion': this.datos
            }).then((res) => {
                this.$swal.fire(
                    'Solicitud enviada',
                    '',
                    'success'
                )
                $('#modalForm').modal('hide')
                
             }).catch(error => {
                 this.$swal.fire({
                     icon: 'error',
                     title: 'Error de envio',
                     text: 'Ocurrio un error',
                 })
             }); 
        },
        onChange(param) {
            this.disabled = false;
            switch (param) {
                case "D":
                    this.allDay = !this.allDay;
                    this.morning = false;
                    this.afternoon = false;

                    if (this.allDay) {
                        this.disabled = true;
                        this.datos.hora_inicio = "07:00";
                        this.datos.hora_fin = "19:00";
                        this.datos.turno = "D";
                    }

                    break;
                case "M":
                    this.morning = !this.morning;
                    this.allDay = false;
                    this.afternoon = false;

                    if (this.morning) {
                        this.disabled = true;
                        this.datos.hora_inicio = "07:00";
                        this.datos.hora_fin = "13:30";
                        this.datos.turno = "M";
                    }
                    break;
                case "T":
                    this.afternoon = !this.afternoon;
                    this.morning = false;
                    this.allDay = false;

                    if (this.afternoon) {
                        this.disabled = true;
                        this.datos.hora_inicio = "13:31";
                        this.datos.hora_fin = "19:00";
                        this.datos.turno = "T";
                    }
                    break;
            }
        },
        abrirModal(item) {
            this.datos.estacionamiento_id = item.id;
            this.datos.user_id = this.user.id;
            this.datos.hora_inicio = "";
            this.datos.hora_fin = "";
            this.datos.turno = "";
            this.propietario = item.nombre + " " + item.apellido;
            this.numero = item.numero;
            this.allDay = false;
            this.morning = false;
            this.afternoon = false;
            $('#modalForm').modal('show')
        },
        exportExcel(){
            axios.get('/api/export').then((res)=>{
                console.log(res)
            }); 
        },
        cerrarModal() {
            $('#modalForm').modal('hide');
        },
        changeSede(e) {
            this.getDataDashboard(true, e.target.value)
        }
    }
}
</script>
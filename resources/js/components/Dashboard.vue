<template>
    <main id="js-page-content" role="main" class="page-content">

        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-chart-area'></i> <span class='fw-300'>Dashboard</span>

            </h1>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6 col-md-2 col-xl-2">
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

            <div class="col-sm-12 col-md-6 col-md-5 col-xl-5" @click="showitem(1)">
                <div class="p-3 bg-success-200 rounded overflow-hidden position-relative text-white mb-g">
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
            <div class="col-sm-12 col-md-6 col-md-5 col-xl-5" @click="showitem(2)">
                <div class="p-3 bg-danger-200 rounded overflow-hidden position-relative text-white mb-g">
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


        <div class="row" id="hoy" style="display:block;">
            <div class="col-lg-12">
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
                                        <th>Propietario</th>
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
                                        <td>{{ pm.propietario.nombre + " " + pm.propietario.apellido }}</td>
                                        <td>{{ $dateFormat(pm.created_at) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- datatable end -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
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
                                        <th>Propietario</th>
                                        <th>Sede</th>
                                        <th>Telefono</th>
                                        <th>Email</th>
                                        <th>Ubicación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="pmd in estacioneshoy" :key="pmd.numero+pmd.id">
                                        <td>{{ pmd.numero }}</td>
                                        <td v-if="pmd.nombre == null">VISITA</td>
                                        <td v-else>{{ pmd.nombre + " " + pmd.apellido }}</td>
                                        <td>{{ pmd.sede }}</td>
                                        <td>{{ pmd.telefono }}</td>
                                        <td>{{ pmd.email }}</td>
                                        <td>{{ pmd.ubicacion }}</td>
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
            <div class="col-lg-12">
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
                                        <th>Propietario</th>
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
                                        <td>{{ pm.propietario.nombre + " " + pm.propietario.apellido }}</td>
                                        <td>{{ $dateFormat(pm.created_at) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- datatable end -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div id="panel-4" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            <h2 style="text-align: center; font-size: 1.125rem;"><b> ESTACIONAMIENTOS DISPONIBLES PARA
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
                            <table id="td-disponiblesman" class="table table-bordered table-hover table-striped w-100">
                                <thead class="bg-warning-200">
                                    <tr>
                                        <th>Número</th>
                                        <th>Propietario</th>
                                        <th>Sede</th>
                                        <th>Ubicación</th>
                                        <th>Telefono</th>
                                        <th>Email</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="pmd in estacionesma" :key="pmd.numero+pmd.id">
                                        <td>{{ pmd.numero }}</td>
                                        <td>{{ pmd.nombre + " " + pmd.apellido}}</td>
                                        <td>{{ pmd.sede }}</td>
                                        <td>{{ pmd.ubicacion }}</td>
                                        <td>{{ pmd.telefono }}</td>
                                        <td>{{ pmd.email }}</td>
                                        <td>
                                            <a :href="'https://api.whatsapp.com/send?phone=51' + pmd.telefono +'&text=Hola'"
                                                target="_blank" v-if="pmd.telefono && pmd.telefono.length == 9"
                                                class="btn btn-success">
                                                <i class="fa-brands fa-whatsapp" aria-hidden="true"></i> mensaje
                                            </a>
                                        </td>
                                        <td>
                                            <button @click="sendEmail(pmd)"
                                                class="btn btn-primary">
                                                <i class="fa fa-list" aria-hidden="true"></i> Solicitud
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
    </main>
</template>
<script>

export default {
    data(){
        return{
            item1:true,
            item2: false,
            user: null,
            schedules: [],
            programacionma: [],
            estacionesma: [],
            programacionhoy: [],
            estacioneshoy: [],
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
        async init() {
            const token = localStorage.getItem('access_token');
            await axios.get('api/getSession/' + token).then((res) => {
                this.user = res.data;
            });

            await this.axios.get('/api/dashboard')
                    .then(response=> {
                        let report = response.data;
                        this.report.totalUsers = report.usersTotal;
                        this.report.totalParkings = report.parkingsTotal;
                        this.report.totalSchedules = report.schedulesTotal;
                        this.report.programacionManana = report.programacionManana;
                        this.schedules = report.schedules;

                        this.programacionma = report.programacionma;
                        this.estacionesma = report.estacionesma;

                        this.programacionhoy = report.programacionhoy;
                        this.estacioneshoy = report.estacioneshoy;

                        this.indices.totalManana = Math.round((this.programacionma.length / (this.programacionma.length + this.estacionesma.length) ) * 100);
                        this.indices.totalHoy = Math.round((this.programacionhoy.length / (this.programacionhoy.length + this.estacioneshoy.length) ) * 100);
                    })
                    .catch(error=>{
                        console.log(error);
                    })
                    this.$tablaGlobal('#td-ocupadoshoy');
                    this.$tablaGlobal('#td-disponibleshoy');
                    this.$tablaGlobal('#td-ocupadosman');
                    this.$tablaGlobal('#td-disponiblesman');
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
        async sendEmail(row) {
            await axios.post('/api/sendEmail',{
                    'user': this.user,
                    'parking': row
            }).then((res) => {
                this.$swal.fire(
                    'Solicitud enviada',
                    '',
                    'success'
                )
                 console.log(res)
                
             }).catch(error => {
                 this.$swal.fire({
                     icon: 'error',
                     title: 'Error de envio',
                     text: 'Ocurrio un error',
                 })
             }); 
        },
        exportExcel(){
            axios.get('/api/export').then((res)=>{
                console.log(res)
            }); 
        }
    }
}
</script>
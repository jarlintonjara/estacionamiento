<template>

    <main id="js-page-content" role="main" class="page-content">

        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-chart-area'></i> PROGRAMACIÓN DE ESTACIONAMIENTOS
            </h1>
        </div>
        <div class="col-lg-12">
            <div id="panel-4" class="panel">
                <div class="panel-hdr">
                    <h2 style="text-align: center; font-size: 1.125rem;"><b>{{title}} </b></h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse"
                            data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen"
                            data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="panel-hdr">
                            <button class="btn btn-success" @click="abrirModalCrear">Nuevo</button>
                            <button style="margin-left: 68%;" class="btn btn-danger" @click="showT(1)">Semana
                                Actual</button>
                            <button style="margin-left: auto;" class="btn btn-danger" @click="showT(2)">Semana
                                siguiente</button>
                        </div><br>
                        <div v-if="showTable">
                            <table id="td-schedule" class="table table-bordered table-hover table-striped w-100">
                                <thead class="bg-warning-200">
                                    <tr>
                                        <th>N_Estac</th>
                                        <th>Asignado</th>
                                        <th>Dia de semana</th>
                                        <th>Hora Incio</th>
                                        <th>Hora Final</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="schedule in schedulesFilter" :key="schedule.id">
                                        <td>{{ schedule.parking.numero }}</td>
                                        <td>{{ schedule.user.nombre + " " + schedule.user.apellido }}</td>
                                        <td>{{ schedule.dia }}</td>
                                        <td>{{ schedule.hora_inicio }}</td>
                                        <td>{{ schedule.hora_fin }}</td>
                                        <td>
                                            <button class="btn btn-warning" @click="abrirModalEditar(schedule)"><i
                                                    class="far fa-edit"></i></button>
                                            <button class="btn btn-danger" @click="borrar(schedule.id)"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="showTable2">
                            <table id="td-schedule2" class="table table-bordered table-hover table-striped w-100">
                                <thead class="bg-warning-200">
                                    <tr>
                                        <th>N_Estac</th>
                                        <th>Asignado</th>
                                        <th>Dia de semana</th>
                                        <th>Hora Incio</th>
                                        <th>Hora Final</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="schedule in nextSchedulesFilter" :key="schedule.id">
                                        <td>{{ schedule.parking.numero }}</td>
                                        <td>{{ schedule.user.nombre + " " + schedule.user.apellido }}</td>
                                        <td>{{ schedule.dia }}</td>
                                        <td>{{ schedule.hora_inicio }}</td>
                                        <td>{{ schedule.hora_fin }}</td>
                                        <td>
                                            <button class="btn btn-warning" @click="abrirModalEditar(schedule)"><i
                                                    class="far fa-edit"></i></button>
                                            <button class="btn btn-danger" @click="borrar(schedule.id)"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalForm">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> <i class="fa fa-user-plus"></i> {{titulo}}</h5>
                        <button @click.prevent="cerrarModal" type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="Usuario">Usuario</label>
                                    <v-select class="vue-select2" name="select2" :options="usersFilter"
                                        v-model="datos.user_id" :reduce="label => label.code">
                                    </v-select>

                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Estacionamiento">Estacionamiento</label>
                                    <select id="Estacionamiento" class="browser-default custom-select"
                                        v-model="datos.estacionamiento_id">
                                        <option v-for="parking in parkingsFilter" :key="parking.numero"
                                            :value="parking.id">{{ parking.numero }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="Fecha">Fecha de programación</label>
                                    <date-range-picker v-model="pickerDates" :locale-data="locale">
                                        <template v-slot:input="pickerDates" style="min-width: 350px;">{{
                                            pickerDates.startDate | date }} - {{ pickerDates.endDate | date
                                            }} <i class="fa fa-calendar"></i></template>
                                    </date-range-picker>
                                </div>
                                <div class="frame-wrap bg-faded col-md-8" style="text-align: center; margin: auto;">
                                    <div class="custom-control custom-checkbox d-inline-flex mr-3">
                                        <input type="checkbox" class="custom-control-input" name="bordered"
                                            id="option-bordered" v-model="allDay" @click="onChange('D')">
                                        <label class="custom-control-label" for="option-bordered">Todo el día</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-flex mr-3">
                                        <input type="checkbox" class="custom-control-input" name="small"
                                            id="option-small" v-model="morning" @click="onChange('M')">
                                        <label class="custom-control-label" for="option-small">Mañana</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-inline-flex mr-3">
                                        <input type="checkbox" class="custom-control-input" name="small"
                                            id="option-small2" v-model="afternoon" @click="onChange('T')">
                                        <label class="custom-control-label" for="option-small2">Tarde</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                </div>
                                <div class="form-group col-md-3">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="hora_inicio">Hora Inicio</label>
                                    <input type="time" min="06:00" max="18:00" id="hora_inicio" class="form-control"
                                        :disabled="true" placeholder="Hora inicio" v-model="datos.hora_inicio">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="hora_fin">Hora Fin</label>
                                    <input type="time" min="06:00" max="18:00" id="hora_fin" class="form-control"
                                        :disabled="true" placeholder="Hora fin" v-model="datos.hora_fin">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="Observaciones">Observaciones</label>
                                    <textarea id="Observaciones" class="form-control"
                                        v-model="datos.observacion"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" @click.prevent="cerrarModal"
                                data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" @click.prevent="crear"
                                v-if="btnCrear">Crear</button>
                            <button type="submit" class="btn btn-primary" @click.prevent="editar"
                                v-if="btnEditar">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>

</template>
<script>
import DateRangePicker from 'vue2-daterange-picker'
//you need to import the CSS manually
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'

export default {
    name: "Programacion",
    components: { DateRangePicker },
    data() {
        const startDate = new Date();
        const endDate = new Date();
        endDate.setDate(endDate.getDate());
        return {
            pickerDates: {
                startDate,
                endDate
            },
            locale: {
                format: 'mm/dd/yyyy',
                separator: ' - ',
                applyLabel: 'Aplicar',
                cancelLabel: 'Cancel',
                daysOfWeek: ['Dom', 'Lun', 'Mar', 'Mier', 'Jue', 'Vie', 'Sab'],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiempre', 'Octubre', 'Noviembre', 'Diciembre']

            },
            
            firstDay: 0,
            users:[],
            session: {},
            parkings:[],
            usersFilter: [],
            parkingsFilter: [],
            schedules:[],
            schedulesFilter:[],
            nextSchedules:[],
            nextSchedulesFilter:[],
            allDay: false,
            morning: false,
            afternoon: false,
            disabled: false,
            info: [],
            datos: {
                estacionamiento_id:'', 
                user_id:'', 
                fecha:'', 
                fecha_inicio: startDate, 
                fecha_fin: endDate, 
                hora_inicio:'', 
                hora_fin: '', 
                turno: '', 
                observacion: '', 
                created_by : ''
            },
            titulo:'',
            title:"SEMANA ACTUAL",
            btnCrear:false,
            btnEditar:false,
            id:'',
            showTable: true,
            showTable2: false
        }
    },
    created: async function(){
       const token = localStorage.getItem('access_token');
        await axios.get('api/getSession/'+ token).then((res)=>{
            this.session = res.data;
            this.datos.created_by = this.session.id;
        })  
    },
    mounted: async function(){
        await this.init();
    },
    filters: {
        date(date) {
            return new Intl.DateTimeFormat("en-US").format(date);
        }
    },
    methods:{
        async init(){
            await this.axios.get('/api/programacion')
                .then(response=> {
                    this.users = response.data.users;
                    this.parkings = response.data.parkings;
                    this.schedules = response.data.schedules;
                    this.nextSchedules = response.data.nextSchedules;
                })
                .catch(error=>{
                    console.log(error);
                    this.schedules =[]
                })
                $('#td-schedule').DataTable().destroy();
                $('#td-schedule2').DataTable().destroy();
                await this.validarRole();
                this.$tablaGlobal('#td-schedule');
                this.$tablaGlobal('#td-schedule2');
        },
        validarCampos(){
            if(!this.datos.estacionamiento_id || !this.datos.user_id || !this.datos.hora_inicio || !this.datos.hora_fin ){
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Completa los campos requeridos!',
                });
                return false;
            }
            return true;
        },
        validarRole(){
            let self = this;
            return new Promise(function(resolve, reject) {
                self.parkingsFilter = [];
                self.usersFilter = [];
                self.schedulesFilter = [];
                self.nextSchedulesFilter = [];
                if(self.session.role_id === 1){
                    self.usersFilter = self.users;
                    self.usersFilter = self.usersFilter.map(e => { return { code : e.id, label: e.nombre + " " + e.apellido } })
                    self.parkingsFilter = self.parkings;
                    self.schedulesFilter = self.schedules;
                    self.nextSchedulesFilter = self.nextSchedules;
                    resolve();
                    
                }else if(self.session.role_id == 3){
                    self.parkingsFilter = [].concat(self.parkings.filter(e => e.id == self.session.parking_id))
                    self.usersFilter = self.users;
                    self.usersFilter = self.usersFilter.map(e => { return { code : e.id, label: e.nombre + " " + e.apellido } })
                    self.schedulesFilter = [].concat(self.schedules.filter(e => e.estacionamiento_id == self.session.parking_id));
                    self.nextSchedulesFilter = [].concat(self.nextSchedules.filter(e => e.created_by == self.session.id));
                    self.datos.estacionamiento_id = self.session.parking_id;
                    self.datos.user_id = self.session.id;
                    resolve();
                }else{
                    resolve();
                }
            });
        },
        showT(id){
            if(id == 1){
                this.showTable = true;
                this.showTable2 = false;
                this.title = "SEMANA ACTUAL";
            }else{
                this.showTable = false;
                this.showTable2 = true;
                this.title = "SEMANA SIGUIENTE";
            }
            $('#td-schedule').DataTable().destroy();
            $('#td-schedule2').DataTable().destroy();
            this.$tablaGlobal('#td-schedule');
            this.$tablaGlobal('#td-schedule2');
        },
        onChange(param){
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
        async crear(){
            let valid = await this.validarCampos();
            let resp = false;
            this.datos.fecha_inicio = this.pickerDates.startDate;
            this.datos.fecha_fin = this.pickerDates.endDate;
            if(valid){
                await axios.post('api/programacion', this.datos).then(response=>{
                    if(response.data.isSuccess == false){
                        this.$swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.data.message,
                        })
                    } else { 
                        resp = true;
                        this.schedules = [].concat(response.data.schedules);          
                        this.nextSchedules = [].concat(response.data.nextSchedules);
                        $('#modalForm').modal('hide');
                        this.$swal.fire(
                            'Programación creada!',
                            '',
                            'success'
                        )
                    }
                   
                }).catch(function (error) {
                    console.log(error);
                });
                if(resp){
                    $('#td-schedule').DataTable().destroy();
                    $('#td-schedule2').DataTable().destroy();
                    await this.validarRole();
                    this.$tablaGlobal('#td-schedule');
                    this.$tablaGlobal('#td-schedule2');
                }
            }
        },
        async editar(){
            let valid = await this.validarCampos();
            if(valid){
                let resp = false;
                await axios.put('/api/programacion/'+this.id, this.datos).then(response=>{
                    if(response.data.isSuccess == false){
                        
                        this.$swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.data.message,
                        })
                    }else{
                        resp = true;
                        this.schedules = [].concat(response.data.schedules);          
                        this.nextSchedules = [].concat(response.data.nextSchedules);          
                        this.id='';
                        $('#modalForm').modal('hide');
                        this.$swal.fire(
                            'Programación editado correctamente!',
                            '',
                            'success'
                        )
                    }
                    
                }).catch(function (error) {
                    console.log(error);
                });
                if(resp){
                    $('#td-schedule').DataTable().destroy();
                    $('#td-schedule2').DataTable().destroy();
                    await this.validarRole();
                    this.$tablaGlobal('#td-schedule');
                    this.$tablaGlobal('#td-schedule2');
                }
            }
        },
        borrar(id){
            let self = this;
            this.$swal.fire({
                title: 'Seguro de eliminar?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si'
            }).then(function () {
                
                self.axios.delete(`/api/programacion/${id}`).then(response => {
                    let id = response.data.id;
                    self.schedulesFilter = [].concat(self.schedulesFilter.filter(e => e.id !== id));
                    self.nextSchedulesFilter =  [].concat(self.nextSchedulesFilter.filter(e => e.id !== id));
                    self.$swal.fire(
                        'Eliminado!',
                        '',
                        'success'
                    );
                }).catch(error=>{
                    console.log(error)
                })
            })
        },
        abrirModalCrear() {
            const startDate = new Date();
            const endDate = new Date();
            endDate.setDate(endDate.getDate());
            this.pickerDates = {
                startDate,
                endDate
            }
            this.allDay = false;
            this.morning = false;
            this.afternoon = false;
            this.disabled = false;
            this.datos.estacionamiento_id = this.parkingsFilter.length == 1 ? this.parkingsFilter[0].id : '';
            this.datos.user_id = '';
            this.datos.fecha = '';
            this.datos.fecha_inicio = '';
            this.datos.fecha_fin = '';
            this.datos.hora_inicio = '';
            this.datos.hora_fin = '';
            this.datos.observacion = '';
            this.titulo='Crear programacion';
            this.btnCrear=true;
            this.btnEditar=false;
            $('#modalForm').modal('show')
        },
        abrirModalEditar(datos){
            this.allDay = false;
            this.partialDay = false;
            this.disabled = false;
            this.datos.estacionamiento_id = datos.estacionamiento_id;
            this.datos.user_id = datos.user_id;
            this.datos.fecha = datos.fecha;
            this.datos.hora_inicio = datos.hora_inicio;
            this.datos.hora_fin = datos.hora_fin;
            this.datos.turno = datos.turno;
            this.datos.observacion = datos.observacion;
            this.titulo=' Editar Programación'
            this.btnCrear=false
            this.btnEditar=true
            this.id=datos.id;
            this.onChange(this.datos.turno);
            $('#modalForm').modal('show')
        },
        cerrarModal(){
            $('#modalForm').modal('hide');
        }
    }
}

</script>
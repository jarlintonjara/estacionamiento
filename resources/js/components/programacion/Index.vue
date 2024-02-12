<template>
    <main id="js-page-content" role="main" class="page-content">

        <div class="content">
            <div class="subheader">
                <h1 class="subheader-title">
                    <i class='subheader-icon fal fa-chart-area'></i> RESERVA DE ESTACIONAMIENTOS
                </h1>
            </div>
            <div class="col-lg-12">
                <div id="panel-4" class="panel">
                    <div class="panel-hdr">
                        <h2 style="text-align: center; font-size: 1.125rem;"><b>{{ title }} </b></h2>
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
                                <button class="btn btn-success" @click="abrirModalCrear"
                                    :disabled="isBtnDisableNew">
                                        <span v-if="!isLoadingModalNuevo">Nuevo</span>
                                        <span v-if="isLoadingModalNuevo">Cargando...</span>
                                    </button>

                                <button style="margin-left: 68%;" class="btn btn-danger" @click="showT(1)">Semana
                                    Actual</button>

                                <button style="margin-left: auto;" class="btn btn-danger" @click="showT(2)">Semana
                                    Siguiente</button>
                            </div><br>
                            <div v-if="showTable">
                                <table id="td-schedule" class="table table-bordered table-hover table-striped w-100">
                                    <thead class="bg-warning-200">
                                        <tr>
                                            <th>N_Estac *</th>
                                            <th>Asignado</th>
                                            <th>Sede</th>
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
                                            <td>{{ schedule.sede.name }}</td>
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
                                            <th>Sede</th>
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
                                            <td>{{ schedule.sede.name }}</td>
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

        </div>

        <!-- Reservation Modal -->
        <div class="modal fade" ref="refModal" id="modalForm">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> <i class="fa fa-user-plus"></i> {{ titulo }}</h5>
                        <button @click.prevent="cerrarModal" type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <!-- Paso 1 -->
                            <div class="content_pass_one py-4">
                                <div class="form-row">
                                    <!-- Fecha Reserva -->
                                    <div class="form-group col-md-6">
                                        <label for="Fecha" class="d-block">Fecha de reserva</label>
                                        <input v-if="btnEditar" type="date" id="pickerProgramacion" class="form-control"
                                            placeholder="Fecha" v-model="datos.fecha">

                                        <v-datepicker :disabled-dates="disabledCustomDates" :language="es"
                                            @selected="verifyAvailableParking" id="datePicker"
                                            placeholder="Seleccionar Fecha">
                                        </v-datepicker>
                                    </div>

                                    <!-- Usuario Admin -->
                                    <div class="form-group col-md-6" v-if="session && session.role_id == 1">
                                        <label for="Usuario">Usuario</label>
                                        <v-select class="vue-select2" name="select2" :options="usersFilter"
                                            v-model="datos.user_id" :reduce="label => label.code" @input="changeUser">
                                        </v-select>
                                    </div>

                                    <!-- Usuario Normal -->
                                    <div class="form-group col-md-6" v-if="session && session.role_id != 1">
                                        <label for="Usuario">Usuario</label>
                                        <select id="Usuario" class="browser-default custom-select" disabled
                                            v-model="datos.user_id">
                                            <option :value="session.id" :key="session.id + session.nombre">{{ session.nombre
                                                + ' ' + session.apellido }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6" v-if="isSearchSedes">
                                        <span class="w-100" v-if="isSearchSedes">Cargando Sedes...</span>
                                    </div>

                                    <!-- Sedes -->
                                    <div class="form-group col-md-6 d-none" id="contentSedes">
                                        <label for="Sedes">Sedes</label>
                                        <select name="Sedes" id="Sedes" class="browser-default custom-select"
                                            @change="changeSede" :disabled="session.role_id != 1" v-model="datos.sede_id">
                                            <option value="">Selecciona una sede</option>
                                            <option v-for="multisede in datos.multisedes" :key="multisede.sede_id"
                                                :value="multisede.sede_id">{{ multisede.sede_name }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Paso 2 -->
                            <div class="content_pass_two d-none py-4">
                                <!-- Estacionamientos Disponibles -->
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-6" id="contentEstacionamientos">
                                        <label for="Estacionamiento">Estacionamiento Disponibles</label>
                                        <select id="Estacionamiento" class="browser-default custom-select"
                                            v-model="datos.estacionamiento_id">
                                            <option v-for="parking in available_parkings" :key="parking.numero"
                                                :value="parking.id">{{ parking.numero }}</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Fechas De Estacionamiento -->
                                <div class="form-row">
                                    <div class="frame-wrap bg-faded col-md-6" style="text-align: center; margin: auto;">
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

                                <div class="form-row ">
                                    <div class="form-group col-md-12">
                                        <label for="Observaciones">Observaciones</label>
                                        <textarea id="Observaciones" class="form-control"
                                            v-model="datos.observacion"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Modal -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" @click.prevent="cerrarModal" v-if="btnClose"
                                data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-danger" @click.prevent="back"
                                v-if="btnBack">Volver</button>
                            <button type="button" class="btn btn-primary" @click.prevent="buscar" v-if="isBtnSearch"
                                :disabled="isBtnSearchDisabled">
                                <span v-if="!isLoadingBtnSearch">Buscar</span>
                                <span v-if="isLoadingBtnSearch">Buscando...</span>
                            </button>
                            <button type="submit" class="btn btn-primary" @click.prevent="crear"
                                v-if="btnCrear">Crear</button>
                            <button type="submit" class="btn btn-primary" @click.prevent="editar"
                                v-if="btnEditar">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Reservation Modal -->
    </main>
</template>

<style>
#datePicker {
    display: block;
    width: 100%;
    height: calc(1.5em + 0.75rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.vdp-datepicker .prev,
.vdp-datepicker .next {
    display: none;
}

.vdp-datepicker__calendar header span.day__month_btn,
.vdp-datepicker__calendar header span.month__year_btn {
    display: block;
    width: 100%;
}
</style>

<script>
import DateRangePicker from 'vue2-daterange-picker'
//you need to import the CSS manually
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'

import { es } from 'vuejs-datepicker/dist/locale';

const getVerifyDate = () => {
    let curr_date = new Date();
    let num_day = curr_date.getDay();

    if (num_day == 0) curr_date.setDate(curr_date.getDate() + 1);

    if (num_day == 6) curr_date.setDate(curr_date.getDate() + 2);

    let curr_date_tomorrow = new Date(curr_date);
    curr_date_tomorrow.setDate(curr_date_tomorrow.getDate() + 1)

    return {
        'start_date': curr_date,
        'end_date': curr_date_tomorrow
    };
}

const main_date = getVerifyDate();

export default {
    name: "Programacion",
    components: { DateRangePicker },
    data() {
        const date = new Date();
        const startDate = new Date(date.getFullYear(), date.getMonth(), 1);
        const endDate = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        endDate.setDate(endDate.getDate());

        return {
            isLoadingModalNuevo: false,
            es: es,
            disabledCustomDates: {
                customPredictor: function (date) {
                    return date.getDate() != main_date.start_date.getDate() && date.getDate() != main_date.end_date.getDate()
                }
            },
            startDate,
            pickerDates: {
                startDate,
                endDate
            },
            locale: {
                format: 'mm/dd/yyyy',
                separator: ' - ',
                applyLabel: 'Aplicar',
                cancelLabel: 'Cancel',
                daysOfWeek: ['Lun', 'Mar', 'Mier', 'Jue', 'Vie'],
                monthNames: ['Febrero']
            },

            firstDay: 0,
            users: [],
            session: {},
            parkings: [],
            usersFilter: [],
            parkingsFilter: [],
            schedules: [],
            schedulesFilter: [],
            nextSchedules: [],
            nextSchedulesFilter: [],
            available_parkings: [],
            allDay: false,
            morning: false,
            afternoon: false,
            disabled: false,
            info: [],
            isSearchSedes: false,
            isBtnSearch: false,
            isBtnSearchDisabled: true,
            isBtnDisableNew: true,
            datos: {
                estacionamiento_id: '',
                user_id: '',
                fecha: '',
                fecha_inicio: '',
                fecha_fin: '',
                hora_inicio: '',
                hora_fin: '',
                turno: '',
                sede_id: 0,
                observacion: '',
                created_by: '',
                multisedes: []
            },
            titulo: '',
            title: "SEMANA ACTUAL",
            btnCrear: false,
            btnEditar: false,
            btnClose: false,
            btnBack: false,
            isLoading: false,
            isLoadingBtnSearch: false,
            id: '',
            showTable: true,
            showTable2: false
        }
    },
    created: async function () {
        const token = localStorage.getItem('access_token');
        await axios.get('api/getSession/' + token).then((res) => {
            this.session = res.data;
            this.datos.created_by = this.session.id;
        })
    },
    mounted: async function () {
        await this.init();
        this.$refs.refModal.addEventListener('hidden.bs.modal', event  => {
            this.cerrarModal();
        });
    },
    filters: {
        date(date) {
            return new Intl.DateTimeFormat("en-US").format(date);
        }
    },
    methods: {
        async init() {
            this.isLoading = true;

            await this.axios.get('/api/programacion')
                .then(response => {
                    this.users = response.data.users;
                    this.parkings = response.data.parkings;
                    this.schedules = response.data.schedules;
                    this.nextSchedules = response.data.nextSchedules;
                })
                .catch(error => {
                    console.log(error);
                    this.schedules = []
                })
                .finally(() => {
                    this.isLoading = false;
                    this.isBtnDisableNew = false;
                })

            $('#td-schedule').DataTable().destroy();
            $('#td-schedule2').DataTable().destroy();
            await this.validarRole();

            this.$tablaGlobal('#td-schedule');
            this.$tablaGlobal('#td-schedule2');

            this.datos.user_id = this.session.id;
        },
        validarCampos() {
            if (!this.datos.estacionamiento_id || !this.datos.hora_inicio || !this.datos.hora_fin) {
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Completa los campos requeridos!',
                });
                return false;
            }
            return true;
        },
        validarRole() {
            let self = this;
            return new Promise(function (resolve, reject) {
                self.parkingsFilter = [];
                self.usersFilter = [];
                self.schedulesFilter = [];
                self.nextSchedulesFilter = [];

                if (self.session.role_id === 1) {
                    self.usersFilter = self.users;
                    self.usersFilter = self.usersFilter.map(e => { return { code: e.id, label: e.nombre + " " + e.apellido } })
                    self.parkingsFilter = self.parkings;
                    self.schedulesFilter = self.schedules;
                    self.nextSchedulesFilter = self.nextSchedules;
                    resolve();
                } else if (self.session.role_id == 3 || self.session.role_id == 2) {
                    self.usersFilter = self.users;
                    self.usersFilter = self.usersFilter.map(e => { return { code: e.id, label: e.nombre + " " + e.apellido } })
                    self.parkingsFilter = [].concat(self.parkings.filter(p => p.sede_id == self.session.sede_id));
                    self.schedulesFilter = [].concat(self.schedules.filter(s => s.sede.id == self.session.sede_id && s.user_id == self.session.id));
                    self.nextSchedulesFilter = [].concat(self.nextSchedules.filter(e => e.created_by == self.session.id));
                    self.datos.estacionamiento_id = self.session.parking_id;
                    self.datos.user_id = self.session.id;
                    resolve();
                } else {
                    resolve();
                }
            });
        },
        showT(id) {
            if (id == 1) {
                this.showTable = true;
                this.showTable2 = false;
                this.title = "SEMANA ACTUAL";
            } else {
                this.showTable = false;
                this.showTable2 = true;
                this.title = "SEMANA SIGUIENTE";
            }
            $('#td-schedule').DataTable().destroy();
            $('#td-schedule2').DataTable().destroy();
            this.$tablaGlobal('#td-schedule');
            this.$tablaGlobal('#td-schedule2');
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
        async crear() {
            let valid = await this.validarCampos();
            let resp = false;
            // this.datos.fecha_inicio = this.pickerDates.startDate;
            // this.datos.fecha_fin = this.pickerDates.endDate;

            if (valid) {
                await axios.post('api/programacion', this.datos).then(response => {
                    console.log(response.data)
                    // return;
                    if (response.data.isSuccess == false) {
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
                        this.init();
                    }

                }).catch(function (error) {
                    console.log(error);
                });

                if (resp) {
                    $('#td-schedule').DataTable().destroy();
                    $('#td-schedule2').DataTable().destroy();
                    await this.validarRole();
                    this.$tablaGlobal('#td-schedule');
                    this.$tablaGlobal('#td-schedule2');
                }
            }
        },
        buscar: async function () {
            console.log("------------ buscar estacionamientos ------------");

            if(this.datos.fecha == "") return this.$swal.fire({
                icon: "warning",
                title: "Campos faltantes",
                text: "Ingresa la fecha de la reserva"
            })

            this.isLoadingBtnSearch = true;
            
            await axios.post('/api/validar-disponibilidad-reservas-fecha', this.datos)
                .then((res) => {
                    const { available_parkings } = res.data

                    this.available_parkings = available_parkings

                    $(".content_pass_one").addClass('d-none')
                    $(".content_pass_two").removeClass('d-none')

                    this.btnCrear = true;
                    this.btnClose = false;
                    this.btnBack = true;
                    this.isBtnSearch = false;
                })
                .catch((err) => {
                    console.log(err)
                })
                .finally(() => {
                    this.isLoadingBtnSearch = false;
                })
        },
        back: function () {
            $(".content_pass_one").removeClass('d-none')
            $(".content_pass_two").addClass('d-none')

            this.btnCrear = false;
            if (this.datos.sede_id == "") this.isBtnSearchDisabled = true;
            this.btnBack = false;
            this.btnClose = true;
            this.isBtnSearch = true;
        },
        async editar() {
            let valid = await this.validarCampos();
            if (valid) {
                let resp = false;
                await axios.put('/api/programacion/' + this.id, this.datos).then(response => {
                    if (response.data.isSuccess == false) {

                        this.$swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.data.message,
                        })
                    } else {
                        resp = true;
                        this.schedules = [].concat(response.data.schedules);
                        this.nextSchedules = [].concat(response.data.nextSchedules);
                        this.id = '';
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
                if (resp) {
                    $('#td-schedule').DataTable().destroy();
                    $('#td-schedule2').DataTable().destroy();
                    await this.validarRole();
                    this.$tablaGlobal('#td-schedule');
                    this.$tablaGlobal('#td-schedule2');
                }
            }
        },
        borrar(id) {
            let self = this;
            // this.$swal.fire({
            //     title: 'Seguro de eliminar?',
            //     text: "",
            //     type: 'warning',
            //     showCancelButton: true,
            //     confirmButtonColor: '#3085d6',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: 'Si'
            // }).then(function (result) {
            //     if (result.isConfirmed) {
            //     }
            // })
            if (confirm("¿Confirma eliminar el registro?")) {
                self.axios.delete(`/api/programacion/${id}`).then(response => {
                    let id = response.data.id;
                    self.schedulesFilter = [].concat(self.schedulesFilter.filter(e => e.id !== id));
                    self.nextSchedulesFilter = [].concat(self.nextSchedulesFilter.filter(e => e.id !== id));
                    self.$swal.fire(
                        'Eliminado!',
                        '',
                        'success'
                    );
                }).catch(error => {
                    console.log(error)
                })
            }
        },
        abrirModalCrear: async function() {
            console.log('-------------- abrir modal crear --------------')

            this.isLoadingModalNuevo = true;

            this.isBtnSearch = true;
            this.btnClose = true;
            this.titulo = "Crer Reserva"
            this.datos.sede_id = this.session.curr_sede_id;

            await this.changeUser(this.datos.user_id);

            $('#modalForm').modal('show');

            // const startDate = new Date();
            // const endDate = new Date();
            // endDate.setDate(endDate.getDate());
            // this.pickerDates = {
            //     startDate,
            //     endDate
            // }
            // this.allDay = false;
            // this.morning = false;
            // this.afternoon = false;
            // this.disabled = false;
            // this.datos.estacionamiento_id = this.parkingsFilter.length == 1 ? this.parkingsFilter[0].id : '';
            // // this.datos.user_id = '';
            // this.datos.fecha = '';
            // this.datos.fecha_inicio = '';
            // this.datos.fecha_fin = '';
            // this.datos.hora_inicio = '';
            // this.datos.hora_fin = '';
            // this.datos.observacion = '';
            // this.titulo = 'Crear Reserva';
            // this.btnCrear = false;
            // this.btnClose = true;
            // this.isBtnSearch = true;
            // this.btnEditar = false;

        },
        abrirModalEditar(datos) {
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
            this.titulo = ' Editar Reserva'
            this.btnCrear = false
            this.btnEditar = true
            this.id = datos.id;
            this.onChange(this.datos.turno);
            $('#modalForm').modal('show')
        },
        cerrarModal: function () {
            console.log('--------------  cerrar modal --------------');
            $('#modalForm').modal('hide');
            
            $(".content_pass_one").removeClass('d-none');
            $(".content_pass_two").addClass('d-none');

            console.log(' ----------- reset datos ------------- ');

            this.allDay = false;
            this.morning = false;
            this.afternoon = false;

            this.datos.hora_inicio = '';
            this.datos.hora_fin = '';
            this.datos.observacion = '';
            this.datos.estacionamiento_id = 0;

            this.btnClose = true;
            this.btnBack = false;
            this.isBtnSearch = true;
            this.btnCrear = false;
        },
        async verifyAvailableParking(date) {
            this.datos.fecha = date;
            this.datos.fecha_inicio = date;
            this.datos.fecha_fin = date;
        },
        changeUser: async function (userId) {
            console.log(' ---------- change user ----------- ');

            console.log(this.datos)

            this.isSearchSedes = true;
            
            // Cuando un usuario tiene la sede seleccionda en su perfil global, esa sede se debe mostrar en el select de sedes y haiblitar automaticamente el boton buscar
            if(this.datos.sede_id != 0 || this.datos.sede_id != null || this.datos.sede_id != undefined)  this.isBtnSearchDisabled = false;

            $("#contentSedes").addClass('d-none');

            await axios.post('/api/multisedes-usuario', {
                user_id: this.datos.user_id
            })
                .then((res) => {

                    $("#contentSedes").removeClass('d-none');

                    this.datos.multisedes = res.data.user.multisedes;
                    this.datos.user_id = userId;
                })
                .catch((err) => console.log(err))
                .finally(() => {
                    this.isLoadingModalNuevo = false;
                    this.isSearchSedes = false;
                })
        },
        changeSede: function (e) {
            console.log('----------------- cambiar sede ----------------- ')

            if(e.target.value == "") this.isBtnSearchDisabled = true
            else this.isBtnSearchDisabled = false;

            this.datos.sede_id = e.target.value
        }
    }
}

</script>

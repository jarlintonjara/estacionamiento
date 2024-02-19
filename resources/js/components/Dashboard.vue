<template>
    <main id="js-page-content" role="main" class="page-content">
        <div class="content">
            <div class="subheader">
                <h1 class="subheader-title">
                    <i class='subheader-icon fal fa-chart-area'></i> <span class='fw-300'>Dashboard</span>
                </h1>
            </div>
            
            <!-- Total Usuarios, Estacionamientos y Programaciones -->
            <div class="row d-flex gap-4 mb-5" v-if="user && user.role_id == 1">
                <!-- <div class="bg-success-400 col-12 col-lg-3 rounded-lg p-3">
                    <h5 style="font-weight: bold">Usuarios</h5>
                    <h3>{{ report.totalUsers }}</h3>
                </div> -->
    
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
                                        <tr v-for="pm in programacionhoy" :key="pm.parking.numero" v-if="programacionhoy.length > 0"> 
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
                                <h2 style="text-align: center; font-size: 1.125rem;"><b> ESTACIONAMIENTOS DISPONIBLES HOY</b></h2>
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
                                            <!-- <th>Email</th> -->
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="pmd in estacioneshoy" :key="pmd.numero+pmd.id">
                                            <td>{{ pmd.numero }}</td>
                                            <td>{{ pmd.sede_name }}</td>
                                            <!-- <td>{{ pmd.sede_email }}</td> -->
                                            <td>
                                                <button type="button" @click="abrirModal(pmd, 'hoy')" class="btn btn-primary" v-if="user.role_id == 2">
                                                    <span>Reservar</span>
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
                                        <tr class="text-center">
                                            <th>Número</th>
                                            <th>Sede</th>
                                            <!-- <th>Email</th> -->
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="pmd in estacionesma" :key="pmd.numero+pmd.id" class="text-center">
                                            <td>{{ pmd.numero }}</td>
                                            <td>{{ pmd.sede_name }}</td>
                                            <!-- <td>{{ pmd.sede_email }}</td> -->
                                            <td>
                                                <button @click="abrirModal(pmd, 'tomorrow')" class="btn btn-primary" v-if="user.role_id == 2">
                                                    <span>Reservar</span>
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
                                        <!-- <input v-if="btnEditar" type="date" id="pickerProgramacion" class="form-control"
                                            placeholder="Fecha"> -->

                                        <v-datepicker 
                                            :disabled-dates="disabledCustomDates" 
                                            :language="es"
                                            @selected="verifyAvailableParking" 
                                            id="datePicker"
                                            placeholder="Seleccionar Fecha"
                                            v-model="datos.fecha"
                                        >
                                        </v-datepicker>
                                    </div>

                                    <!-- Usuario Admin -->
                                    <!-- <div class="form-group col-md-6" v-if="user && user.role_id == 1">
                                        <label for="Usuario">Usuario</label>
                                        <v-select class="vue-select2" name="select2" :options="usersFilter"
                                            v-model="datos.user_id" :reduce="label => label.code" @input="changeUser">
                                        </v-select>
                                    </div> -->

                                    <!-- Usuario Normal -->
                                    <div class="form-group col-md-6" v-if="user && user.role_id != 1">
                                        <label for="Usuario">Usuario</label>
                                        <select id="Usuario" class="browser-default custom-select" disabled
                                            v-model="datos.user_id">
                                            <option :value="user.id" :key="user.id + user.nombre">{{ user.nombre
                                                + ' ' + user.apellido }}</option>
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
                                            @change="changeSede" :disabled="user.role_id != 1" v-model="datos.sede_id">
                                            <option value="">Selecciona una sede</option>
                                            <option v-for="multisede in datos.multisedes" :key="multisede.sede_id"
                                                :value="multisede.sede_id">{{ multisede.sede_name }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Paso 2 -->
                            <div class="content_pass_two py-4">
                                <!-- Estacionamientos Disponibles -->
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-6" id="contentEstacionamientos">
                                        <label for="Estacionamiento">Estacionamiento Disponibles</label>
                                        <select id="Estacionamiento" class="browser-default custom-select" disabled
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
                                v-if="btnCrear">
                                    <span v-if="!isSaving">Crear</span>
                                    <span v-if="isSaving">Creando...</span>
                                </button>

                            <button type="submit" class="btn btn-primary" @click.prevent="editar"
                                v-if="btnEditar">
                                <span>Actualizar</span>
                            </button>
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

import Spinner from './Spinner.vue';
import DateRangePicker from 'vue2-daterange-picker'
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'

import { es } from 'vuejs-datepicker/dist/locale';

const getVerifyDate = () => {
    let curr_date = new Date();
    let num_day = curr_date.getDay();

    if (num_day == 0) curr_date.setDate(curr_date.getDate() + 1);

    if (num_day == 6) curr_date.setDate(curr_date.getDate() + 2);

    let curr_date_tomorrow = new Date(curr_date);
    curr_date_tomorrow.setDate(curr_date_tomorrow.getDate() + 1);

    if(curr_date_tomorrow.getDay() == 0) curr_date_tomorrow.setDate(curr_date_tomorrow.getDate() + 1);

    if(curr_date_tomorrow.getDay() == 6) curr_date_tomorrow.setDate(curr_date_tomorrow.getDate() + 2)

    console.log({ curr_date, curr_date_tomorrow })

    return {
        'start_date': curr_date,
        'end_date': curr_date_tomorrow
    };
}

const main_date = getVerifyDate();

export default {
    components: {
        Spinner,
        DateRangePicker
    },
    data() {
        let date = new Date();
        date.setDate(date.getDate() + 1);
        const startDate = new Date();
        const endDate = new Date();
        endDate.setDate(endDate.getDate());
        
        return{
            titulo: '',
            pickerDates: {
                startDate,
                endDate
            },
            isLoadingBtnSearch: false,
            isBtnSearchDisabled: false,
            es: es,
            disabledCustomDates: {
                customPredictor: function (date) {
                    return date.getDate() != main_date.start_date.getDate() && date.getDate() != main_date.end_date.getDate()
                }
            },
            locale: {
                format: 'mm/dd/yyyy',
                separator: ' - ',
                applyLabel: 'Aplicar',
                cancelLabel: 'Cancel',
                daysOfWeek: ['Dom', 'Lun', 'Mar', 'Mier', 'Jue', 'Vie', 'Sab'],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiempre', 'Octubre', 'Noviembre', 'Diciembre']

            },
            curr_sede: 0,
            item1:true,
            item2: false,
            user: null,
            isLoading: false,
            schedules: [],
            sedes: [],
            available_parkings: [],
            programacionma: [],
            estacionesma: [],
            programacionhoy: [],
            estacioneshoy: [],
            allDay: false,
            morning: false,
            afternoon: false,
            btnClose: false,
            btnBack: false,
            isBtnSearch: false,
            btnCrear: false,
            btnEditar: false,
            disabled: false,
            isSearchSedes: false,
            isLoadingModalNuevo: false,
            datos: {
                estacionamiento_id: '',
                user_id: '',
                fecha: date,
                fecha_inicio: main_date.start_date,
                fecha_fin: main_date.end_date,
                hora_inicio: '',
                hora_fin: '',
                turno: '',
                observacion: '',
                created_by: ''
            },
            propietario: "",
            usuario: "",
            isSaving: false,
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
    created: async function(){
        const user_local = localStorage.getItem('curr_user');
        
        this.user = JSON.parse(user_local)

        // const token = localStorage.getItem('access_token');
        //     await axios.get('api/getuser/' + token).then((res) => {
        //         this.user = res.data;
        // });
    },
    mounted: function(){
        console.log(this.user)
        this.init();
    },
    filters: {
        date(date) {
            return new Intl.DateTimeFormat("en-US").format(date);
        }
    },
    methods:{
        getDataDashboard: async function(filters = false, sede_id = this.user.curr_sede_id) {
            console.log(this.user)
            console.log({filters, sede_id})
    
            this.isLoading = true;
    
            await this.axios.get(`/api/dashboard?user_id=${this.user.id}&filters=${filters}&sede_id=${sede_id}`)
                    .then(response=> {                        
                        let report = response.data;
    
                        console.log(' ---------------- obtener datos dashboard ---------------- ');
                        console.log(report.estacioneshoy)
    
                        this.sedes = report.sedes;
                        this.report.totalUsers = report.total_users;
                        this.report.totalParkings = report.total_parkings;
                        this.report.totalSchedules = report.total_schedules;
                        this.schedules = report.schedules
                        this.estacioneshoy = report.estacioneshoy;
                        this.programacionhoy = report.programacionhoy;
                        this.programacionma = report.programacionma;
                        this.estacionesma = report.estacionesma;
                        this.report.programacionManana = report.programacionManana;
    
                        this.indices.totalHoy = Math.round((this.programacionhoy.length / (this.programacionhoy.length + this.estacioneshoy.length) ) * 100);
                        this.indices.totalManana = Math.round((this.programacionma.length / (this.programacionma.length + this.estacionesma.length) ) * 100);
    
                        console.log(this.estacionesma)
                    })
                    .catch(error=>{
                        console.log(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
    
                    $('#td-ocupadoshoy').DataTable();
                    $('#td-disponibleshoy').DataTable();
                    $('#td-ocupadosman').DataTable();
                    $('#td-disponiblesman').DataTable();
        },
        init: async function() {
            this.isLoading = true;
            
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
                        this.datos.hora_inicio = "08:00";
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
                        this.datos.hora_inicio = "08:00";
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
        abrirModal: async function(item, type) {
            console.log('-------------- abrir modal crear --------------')

            this.isLoadingModalNuevo = true;

            this.available_parkings = [{
                id: item.id,
                numero: item.numero
            }];

            this.datos.estacionamiento_id = item.id;
            this.isBtnSearch = false;
            this.btnClose = true;
            this.btnEditar = false;
            this.btnCrear = true;
            this.titulo = "Crear Reserva";
            this.datos.sede_id = this.user.curr_sede_id;
            this.datos.fecha = type == 'hoy' ? main_date.start_date : main_date.end_date;
            this.mode = 'crear';

            await this.changeUser(this.user.id);

            this.isLoadingModalNuevo = false;

            $('#modalForm').modal('show');

            // console.log(this.user)
            // console.log(item)
            // console.log(item)
            // this.datos.estacionamiento_id = item.id;
            // this.datos.user_id = this.user.id;
            // this.datos.hora_inicio = "";
            // this.datos.hora_fin = "";
            // this.datos.turno = "";
            // this.propietario = item.nombre + " " + item.apellido;
            // this.usuario = `${this.user.nombre} ${this.user.apellido}`;
            // this.numero = item.numero;
            // this.allDay = false;
            // this.morning = false;
            // this.afternoon = false;
            // $('#modalForm').modal('show')            
        },
        exportExcel(){
            axios.get('/api/export').then((res)=>{
                console.log(res)
            }); 
        },
        cerrarModal() {
            $('#modalFormDashboard').modal('hide')
            // $('#modalForm').modal('hide');
        },
        changeSede(e) {
            this.getDataDashboard(true, e.target.value);
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
        crear: async function() {
            let valid = await this.validarCampos();

            if(valid) {
                this.isSaving = true;
                
                await axios.post('api/programacion', this.datos).then(response => {
                        if (response.data.isSuccess == false) {
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.data.message,
                            })
                        } else {
                            this.$router.push({ path: 'reservas' })
                            $("#modalForm").modal("hide");
                        }
    
                    }).catch(function (error) {
                        console.log(error);
                    })
                    .finally(() => {
                        this.isSaving = false;
                    });
            }
        },
        cerrarModal: function () {
            console.log('--------------  cerrar modal --------------');
            $('#modalForm').modal('hide');
            
            console.log(' ----------- reset datos ------------- ');

            this.allDay = false;
            this.morning = false;
            this.afternoon = false;

            this.datos.hora_inicio = '';
            this.datos.hora_fin = '';
            this.datos.observacion = '';
            this.datos.estacionamiento_id = 0;
            this.datos.fecha = "";

            this.btnClose = true;
            this.btnBack = false;
            this.isBtnSearch = true;
            this.btnCrear = false;
            this.btnEditar   = false;
        },
        verifyAvailableParking: async function(date) {            
            console.log(date)
            this.datos.fecha = date;
            this.datos.fecha_inicio = date;
            this.datos.fecha_fin = date;
        },
        changeUser: async function (userId) {
            console.log(' ---------- change user v2 ----------- ');

            this.isSearchSedes = true;

            console.log(userId)

            // Cuando un usuario tiene la sede seleccionda en su perfil global, esa sede se debe mostrar en el select de sedes y haiblitar automaticamente boton buscar
            if(this.datos.sede_id != 0 || this.datos.sede_id != null || this.datos.sede_id != undefined)  this.isBtnSearchDisabled = false;

            $("#contentSedes").addClass('d-none');

            await axios.post('/api/multisedes-usuario', {
                user_id: userId
            })
                .then((res) => {

                    $("#contentSedes").removeClass('d-none');

                    this.datos.multisedes = res.data.user.multisedes;
                    this.datos.user_id = userId;
                })
                .catch((err) => console.log(err))
                .finally(() => {
                    this.isSearchSedes = false;
                })
        },
        buscar: async function () {
            console.log("------------ buscar estacionamientos ------------");

            console.log(this.mode)

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
                })
                .catch((err) => {
                    console.log(err)
                })
                .finally(() => {
                    $(".content_pass_one").addClass('d-none')
                    $(".content_pass_two").removeClass('d-none')

                    this.btnClose = false;
                    
                    if(this.mode == 'crear') {
                        this.btnCrear = true;
                        this.btnEditar = false;
                    } else {
                        this.btnCrear = false;
                        this.btnEditar = true;
                    }

                    this.btnBack = true;
                    this.isBtnSearch = false;
                    this.isLoadingBtnSearch = false;
                })
        },
    }
}
</script>
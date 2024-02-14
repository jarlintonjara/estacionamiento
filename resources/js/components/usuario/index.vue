<template>
    <main id="js-page-content" role="main" class="page-content">
        <div class="content">
            <div class="subheader">
                <h1 class="subheader-title">
                    <i class="subheader-icon fal fa-chart-area"></i> Usuarios
                </h1>
            </div>
            <div class="col-lg-12">
                <div id="panel-4" class="panel">
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="panel-hdr">
                                <button class="btn btn-success" @click="abrirModalCrear">Nuevo</button>
                            </div>
                            <br />
                            <table id="tableUser" class="table table-bordered table-hover table-striped w-100">
                                <thead class="bg-warning-200">
                                    <tr>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Rol</th>
                                        <th>Documento</th>
                                        <th>Sede</th>
                                        <th>Email</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="user in users" :key="user.id">
                                        <td>{{ user.nombre }}</td>
                                        <td>{{ user.apellido }}</td>
                                        <td>{{ user.role.description }}</td>
                                        <td>{{ user.documento }}</td>
                                        <td>
                                            <ul style="list-style: none;" class="m-0 p-0 d-flex flex-column gap-1">
                                                <li class="bg-primary px-2 fw-bold py-1 m-0 text-center rounded-2 text-white"
                                                    v-for="(sede, index) in user.multisedes" :key="index"
                                                    style="font-size: 0.65rem">{{ sede.name }}</li>
                                            </ul>
                                        </td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ $dateFormat(user.created_at) }}</td>
                                        <td>
                                            <button class="btn btn-warning" @click="abrirModalEditar(user)">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button class="btn btn-success" title="Resetear Contraseña"
                                                @click="resetPassword(user.id)">
                                                <i class="fa fa-redo"></i>
                                            </button>
                                            <button class="btn btn-danger" @click="borrar(user.id)">
                                                <i class="fa fa-trash"></i>
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

        <!-- Modal User -->
        <div class="modal fade" id="modalForm">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-user-plus"></i> {{ titulo }}</h5>
                        <button @click.prevent="cerrarModal" type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="Nombres">Nombres</label>
                                    <input type="text" id="Nombres" class="form-control" placeholder="Nombres" required=""
                                        v-model="datos.nombre" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Apellidos">Apellidos</label>
                                    <input type="text" id="Apellidos" class="form-control" placeholder="Apellidos"
                                        required="" v-model="datos.apellido" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Documento">Documento</label>
                                    <input type="text" id="Documento" class="form-control" placeholder="Documento"
                                        v-model="datos.documento" />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="Telefono">Telefono</label>
                                    <input type="text" id="Telefono" class="form-control" placeholder="Documento"
                                        v-model="datos.telefono" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Email">Email</label>
                                    <input type="email" id="Email" class="form-control" placeholder="Email"
                                        v-model="datos.email" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Cargo">Cargo</label>
                                    <input type="text" id="Cargo" class="form-control" placeholder="Cargo"
                                        v-model="datos.cargo" />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="Area">Area</label>
                                    <input type="text" id="Area" class="form-control" placeholder="Area"
                                        v-model="datos.area" />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="Role">Rol</label>
                                    <select id="Perfil" class="browser-default custom-select" v-model="datos.role_id">
                                        <option>Seleccione un rol</option>
                                        <option v-for="role in roles" :key="role.nombre + role.id" :value="role.id">
                                            {{ role.nombre }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4" v-if="btnCrear">
                                    <label for="password">Contraseña</label>
                                    <input type="password" id="password" class="form-control" placeholder="password"
                                        v-model="datos.password" />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="Sede">Sede</label>                                 
                                    <v-multiselect 
                                        :options="sedes"
                                        :multiple="true"
                                        :close-on-select="false"
                                        :clear-on-select="false"
                                        :preserve-search="true"
                                        :preselect-first="false"
                                        label="name"
                                        track-by="sede_id"
                                        placeholder="Seleccionar"
                                        v-model="datos.multisede"
                                    >
                                        <template slot="selection" slot-scope="{ values, search, isOpen }">
                                            <p class="multiselect__single" v-if="values.length" v-show="!isOpen">
                                                {{ values.length }}
                                                <span v-if="values.length == 1">sede</span>
                                                <span v-if="values.length > 1">sedes</span>

                                                <span v-if="values.length == 1">seleccionada</span>
                                                <span v-if="values.length > 1">seleccionadas</span>
                                            </p>
                                        </template>
                                    </v-multiselect>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" @click.prevent="cerrarModal" data-dismiss="modal">
                                Cerrar
                            </button>
                            <button type="submit" class="btn btn-primary" @click.prevent="crear" v-if="btnCrear">
                                <span v-if="isLoading">Guardando...</span>
                                <span v-if="!isLoading">Crear</span>
                            </button>

                            <button type="submit" class="btn btn-primary" @click.prevent="editar" v-if="btnEditar">
                                <span v-if="isLoading">Actualizando...</span>
                                <span v-if="!isLoading">Editar</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Modal User -->
    </main>
</template>

<style>
#modalForm .modal-body {
    display: grid;
    gap: 1rem;
}
</style>

<script>

export default {
    name: "Usuario",
    data() {
        return {
            session: {},
            users: [],
            roles: [],
            sedes: [],
            parkings: [],
            parkingsFilter: [],
            datos: {
                id: "",
                nombre: "",
                apellido: "",
                documento: "",
                email: "",
                cargo: "",
                area: "",
                role_id: "",
                parking_id: "",
                telefono: "",
                curr_sede_id: 0,
                multisede: []
            },
            titulo: "",
            btnCrear: false,
            isLoading: false,
            btnEditar: false,
            id: "",
            datatable: null
        };
    },
    created:  function () {
        const curr_user = localStorage.getItem('curr_user');
        this.session = JSON.parse(curr_user);
    },
    mounted: async function () {
        await this.mostrarusers();
    },
    methods: {
        validarCampos() {
            if (
                !this.datos.nombre ||
                !this.datos.apellido ||
                !this.datos.email ||
                !this.datos.role_id
            ) {
                this.$swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Completa los campos requeridos!",
                });
                return false;
            }
            return true;
        },
        crear: async function () {
            let valid = await this.validarCampos();

            if (valid) {
                this.isLoading = true;
                
                axios
                    .post("api/usuario", this.datos)
                    .then((response) => {
                        $("#modalForm").modal("hide");
                        this.$swal.fire("Usuario creado correctamente!", "", "success");
                        this.mostrarusers();
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        },
        async editar() {
            let valid = await this.validarCampos();
            if (valid) {
                this.isLoading = true;
                axios
                    .put("/api/usuario/" + this.id, this.datos)
                    .then((response) => {
                        $("#modalForm").modal("hide");
                        this.$swal.fire("Usuario editado correctamente!", "", "success");
                        if(this.session.id == this.datos.id) return window.location.reload();
                        else this.mostrarusers();
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
                    
            }
        },
        borrar: function(id) {
            this.$swal.fire({
                icon: 'warning',
                title: '¿Estas seguro(a) de eliminar este registro?',
                showCancelButton: true,
                confirmButtonText: 'SI',
                cancelButtonText: 'NO'
            }).then((res) => {
                if(res.isConfirmed) {
                    this.loading();

                    this.axios.delete(`/api/usuario/${id}`)
                    .then((response) => {
                        console.log(' ------------- borrar -----------')
                    })
                    .catch((error) => {
                        console.log(error);
                    })
                    .finally(() => {
                        this.$swal.close();
                        window.location.reload();
                    })
                }
            })
        },
        abrirModalCrear: async function() {
            this.datos = {
                nombre: "",
                apellido: "",
                documento: "",
                email: "",
                role_id: "",
                parking_id: "",
                cargo: "",
                area: "",
                password: "",
                sede_id: "",
            };
            this.parkingsFilter = [];
            this.parkings.map((i) => {
                if (!this.users.find((e) => e.parking_id == i.id)) {
                    this.parkingsFilter.push(i);
                }
            });
            this.titulo = "Crear usuario";
            this.btnCrear = true;
            this.btnEditar = false;

            $("#modalForm").modal("show");

            this.mostrarusers();
        },
        abrirModalEditar(datos) {
            this.parkingsFilter = [];

            this.datos = {
                id: datos.id,
                nombre: datos.nombre,
                apellido: datos.apellido,
                documento: datos.documento,
                email: datos.email,
                role_id: datos.role_id,
                parking_id: datos.parking_id,
                password: datos.password,
                sede_id: datos.sede_id,
                cargo: datos.cargo,
                area: datos.area,
                telefono: datos.telefono,
                curr_sede_id: this.session.curr_sede_id,
                multisede:  this.parseSedeMultiselect(datos.multisedes, 'sede_id')
            };

            this.parkings.map((i) => {
                if (!this.users.find((e) => e.parking_id == i.id)) {
                    this.parkingsFilter.push(i);
                }
                if (i.id == this.datos.parking_id) {
                    this.parkingsFilter.push(i);
                }
            });

            this.titulo = " Editar usuario";
            this.btnCrear = false;
            this.btnEditar = true;
            this.id = datos.id;
            $("#modalForm").modal("show");
        },
        mostrarusers: async function() {
            this.isLoading = true;

            await this.axios
                .get("/api/usuario")
                .then((response) => {
                    this.users = response.data.users;
                    this.roles = response.data.roles;
                    this.sedes = this.parseSedeMultiselect(response.data.sedes);
                    this.parkings = response.data.parkings;
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.isLoading = false;
                });

                $("#tableUser").DataTable();
        },
        cerrarModal: function() {
            $("#modalForm").modal("hide");
        },
        resetPassword(id) {
            this.$swal
                .fire({
                    icon: "warning",
                    title: "Resetear Contraseña",
                    text: "¿Estas seguro de resetear la contraseña?",
                })
                .then(async (res) => {
                    if (res.isConfirmed) {
                        await this.axios
                            .post("/api/resetSimplePassword", { id_user: id })
                            .then((res) => {
                                this.$swal.fire({
                                    icon: "success",
                                    title: "Contraseña Generada",
                                    text: "La nueva contraseña es: " + res.data.pass,
                                });
                            });
                    }
                });
        },
        parseSedeMultiselect(sedesObserver, field_sede = 'id', field_name = 'name') {
            return Object.values(sedesObserver).map((e) => ({
                    sede_id: e[field_sede],
                    name: e[field_name]
            }))
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
        }
    },
};
</script>

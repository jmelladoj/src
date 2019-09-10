<template>
    <div class="page-wrapper">
        <b-container fluid>
            <b-row class="page-titles">
                <b-col cols="5" class="align-self-center"><h4 class="text-themecolor">Servicios</h4></b-col>
                <b-col cols="7">
                    <div class="d-flex justify-content-end align-items-center">
                        <ol class="breadcrumb">
                            <b-link class="breadcrumb-item">Inicio</b-link>
                            <b-link class="breadcrumb-item">Servicios</b-link>
                        </ol>
                        <b-button @click="abrirModalServicio(1)" class="btn btn-info d-lg-block m-l-15" v-b-tooltip.hover title="Agrega un servicio a la plataforma"><i class="fa fa-plus-circle"></i> Agregar Servicio</b-button>
                    </div>                    
                </b-col>
            </b-row>

            <b-row>
                <b-col>
                    <b-card>
                        <b-form-group>
                            <b-container fluid>
                                <b-row>
                                    <b-col md="6" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Filtrar" class="mb-0">
                                        <b-input-group>
                                            <b-form-input v-model="filter" placeholder="Escribe para buscar" />
                                            <b-input-group-append>
                                            <b-button :disabled="!filter" @click="filter = ''">Limpiar</b-button>
                                            </b-input-group-append>
                                        </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="6" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Ordenar" class="mb-0">
                                        <b-input-group>
                                            <b-form-select v-model="sortBy" :options="sortOptions">
                                            <option slot="first" :value="null">-- nada --</option>
                                            </b-form-select>
                                            <b-form-select :disabled="!sortBy" v-model="sortDesc" slot="append">
                                            <option :value="false">Asc</option> <option :value="true">Desc</option>
                                            </b-form-select>
                                        </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="6" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Dirección" class="mb-0">
                                        <b-input-group>
                                            <b-form-select v-model="sortDirection" slot="append">
                                            <option value="asc">Asc</option> <option value="desc">Desc</option>
                                            <option value="last">Último</option>
                                            </b-form-select>
                                        </b-input-group>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="6" class="my-1">
                                        <b-form-group label-cols-sm="3" label="Por página" class="mb-0">
                                        <b-form-select :options="pageOptions" v-model="perPage" />
                                        </b-form-group>
                                    </b-col>
                                </b-row>

                                <!-- Main table element -->
                                <b-table show-empty responsive striped borderless outlined small hover
                                    :items="items"
                                    :fields="fields"
                                    :current-page="currentPage"
                                    :per-page="perPage"
                                    :filter="filter"
                                    :sort-by.sync="sortBy"
                                    :sort-desc.sync="sortDesc"
                                    :sort-direction="sortDirection"
                                    @filtered="onFiltered"
                                >

                                <template slot="empty">
                                    <center><h5>No hay registros para mostrar.</h5></center>
                                </template>

                                <template slot="emptyfiltered">
                                    <center><h5>No hay registros que coincidan con su solicitud.</h5></center>
                                </template>

                                <template slot="index" slot-scope="data">
                                    {{ data.index + 1 }}
                                </template>

                                <template slot="acciones" slot-scope="row">
                                    <b-button size="xs" v-b-tooltip.hover.left title="Agregar productos al servicio" @click="abrirModalProducto(row.item)" class="btn btn-success">
                                        <i class="fa fa-plus"></i>
                                    </b-button>

                                    <b-button size="xs" v-b-tooltip.hover.left title="Actualizar información de servicio" @click="abrirModalServicio(2, row.item)" class="btn btn-warning">
                                        <i class="fa fa-pencil"></i>
                                    </b-button>

                                    <template>
                                        <b-button v-if="row.item.deleted_at" size="xs" v-b-tooltip.hover.left title="Restaurar servicio" @click="activarOdesactivar(row.item.id, 2)" class="btn btn-warning">
                                            <i class="fa fa-undo"></i>
                                        </b-button>

                                        <b-button v-else size="xs" v-b-tooltip.hover.left title="Eliminar servicio" @click="activarOdesactivar(row.item.id, 1)"  class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </b-button>
                            
                                    </template>
                                </template>

                                </b-table>

                                <b-row>
                                    <b-col md="6" class="my-1">
                                        <b-pagination
                                        :total-rows="totalRows"
                                        :per-page="perPage"
                                        v-model="currentPage"
                                        class="my-0"
                                        />
                                    </b-col>
                                </b-row>
                            </b-container>
                        </b-form-group>
                    </b-card>
                </b-col>
            </b-row>
            
            <ValidationObserver v-slot="{ valid }">
                <b-modal ref="modal_servicio" :title="modal_servicio.titulo" no-close-on-backdrop>
                    <b-form>
                        <b-form-group label="Nombre de Servicio">
                            <ValidationProvider name="nombre" rules="required|min:3|alpha_spaces" v-slot="{ errors }" :bails="false" >
                                <b-form-input type="text" v-model="servicio.nombre"></b-form-input>
                                <b-alert variant="danger" :show="errors.length > 0">
                                    <label for="" v-for="(error, index) in errors" :key="index" v-text="'* ' + error"></label>
                                </b-alert>
                            </ValidationProvider>
                        </b-form-group>
                    </b-form>

                    <template slot="modal-footer">
                        <b-button :disabled="!valid" v-show="modal_servicio.accion == 1" size="md" variant="success" @click="crearOactualizarServicio(1)"> Guardar </b-button>
                        <b-button v-show="modal_servicio.accion == 2" size="md" variant="warning" @click="crearOactualizarServicio(2)"> Actualizar </b-button>
                        <b-button size="md" variant="danger" @click="cerrarModalServicio()"> Cerrar </b-button>
                    </template>
                </b-modal>
            </ValidationObserver>

            <ValidationObserver ref="observer_producto" tag="form" v-slot="{ valid }">
                <b-modal ref="modal_producto" :title="modal_producto.titulo" no-close-on-backdrop size="lg">
                    <b-form>
                        <b-form-group>
                            <b-row>                       
                                <b-col lg="4" sm="4">
                                    <ValidationProvider name="nombre" rules="required|min:3|alpha_spaces" v-slot="{ errors }" :bails="false" >
                                        <b-form-input type="text" v-model="producto.nombre" placeholder="Nombre"></b-form-input>
                                        <b-alert variant="danger" :show="errors.length > 0">
                                            <label for="" v-for="(error, index) in errors" :key="index" v-text="'* ' + error"></label>
                                        </b-alert>
                                    </ValidationProvider>
                                </b-col>
                                <b-col lg="4" sm="4">
                                    <ValidationProvider name="sesiones" rules="required|numeric|min_value:1" v-slot="{ errors }" :bails="false" >
                                        <b-form-input type="number" v-model="producto.sesiones" placeholder="Sesiones"></b-form-input>
                                        <b-alert variant="danger" :show="errors.length > 0">
                                            <label for="" v-for="(error, index) in errors" :key="index" v-text="'* ' + error"></label>
                                        </b-alert>
                                    </ValidationProvider>
                                </b-col>
                                <b-col lg="4" sm="4" v-show="modal_producto.accion == 1">
                                    <b-button :disabled="!valid" variant="success" class="btn-block" @click="crearOactualizarProducto(1)"> Guardar </b-button>
                                </b-col>
                                <b-col lg="4" sm="4" v-show="modal_producto.accion == 2">
                                    <b-button variant="warning" class="btn-block" @click="crearOactualizarProducto(2)"> Actualizar </b-button>
                                </b-col>
                            </b-row>
                        </b-form-group>
                        <b-form-group>
                            <b-table show-empty responsive striped borderless outlined small hover
                                :items="productos" 
                                :fields="campos">

                                <template slot="empty">
                                    <center><h5>No hay registros para mostrar.</h5></center>
                                </template>

                                <template slot="index" slot-scope="data">
                                    {{ data.index + 1 }}
                                </template>

                                <template slot="acciones" slot-scope="row">
                                    <b-button size="xs" v-b-tooltip.hover.left title="Actualizar información de producto" @click="cargarProducto(row.item)" class="btn btn-warning">
                                        <i class="fa fa-pencil"></i>
                                    </b-button>

                                    <b-button size="xs" v-b-tooltip.hover.left title="Eliminar producto" @click="eliminarProducto(row.item.id)"  class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </b-button>             
                                </template>
                            </b-table>
                        </b-form-group>
                    </b-form>

                    <template slot="modal-footer">
                        <b-button size="md" variant="success" v-show="modal_producto.accion == 2" @click="limpiarDatosProducto()"> Agregar </b-button>
                        <b-button size="md" variant="danger" @click="cerrarModalProducto()"> Cerrar </b-button>
                    </template>
                </b-modal>
            </ValidationObserver>

        </b-container>

    </div>
</template>

<script>
    const items = [];

    export default {
        data() {
            return {
                servicio: {
                    id: 0,
                    nombre: ''
                },
                producto: {
                    id: 0,
                    nombre: '',
                    sesiones: ''
                },
                modal_servicio: {
                    titulo: '',
                    accion: 0
                },
                modal_producto: {
                    titulo: '',
                    accion: 1
                },
                items: items,
                productos: [],
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre', label: 'NOMBRE', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'ACCIONES', sortable: true, class: 'text-center' }
                ],
                campos: [
                    { key: 'index', label: '#', class: 'text-center' },
                    { key: 'nombre', label: 'NOMBRE', class: 'text-left'},
                    { key: 'acciones', label: 'ACCIONES', class: 'text-center'}
                ],
                currentPage: 1,
                perPage: 10,
                totalRows: 0,
                pageOptions: [10, 25, 50, 100],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null
            }
        },    
        computed:{
            sortOptions() {
                return this.fields.filter(f => f.sortable).map(f => {
                    return { text: f.label, value: f.key }
                })
            }
        },
        methods:{
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            mensaje(clase, mensaje) {
                Swal.fire({
                    type: clase,
                    title: mensaje,
                    showConfirmButton: true,
                    timer: 2000
                });
            },
            listarServicios (){
                let me=this;
                axios.get('/servicios/administrador').then(function (response) {
                    me.items = response.data.servicios;
                    me.totalRows = me.items.length;
                })
                .catch(function (error) {
                    console.log(error.response.data);
                });
            },
            listarProductos (id){
                let me = this;
                me.productos = [];

                axios.get('/servicio/' + id).then(function (response) {
                    me.productos = response.data.productos;
                })
                .catch(function (error) {
                    console.log(error.response.data);
                });
            },
            crearOactualizarServicio(accion){
                let me = this;
                var mensaje = accion == 1 ? 'Registro agregado exitosamente' : 'Registro actualizado exitosamente';

                axios.post('/servicio/crear/actualizar',{
                    'servicio_id': me.servicio.id,
                    'nombre': me.servicio.nombre.toUpperCase()
                }).then(function (response) {
                    me.limpiarDatosServicio();
                    me.listarServicios();
                    me.cerrarModalServicio();
                    me.mensaje('success', mensaje);
                }).catch(function (error) {
                    console.error(error);
                }); 
            },
            crearOactualizarProducto(accion){
                let me = this;
                var mensaje = accion == 1 ? 'Registro agregado exitosamente' : 'Registro actualizado exitosamente';

                axios.post('/producto/crear/actualizar',{
                    'producto_id': me.producto.id,
                    'nombre': me.producto.nombre.toUpperCase(),
                    'sesiones': me.producto.sesiones,
                    'servicio_id': me.servicio.id
                }).then(function (response) {
                    me.limpiarDatosProducto();
                    me.listarProductos(me.servicio.id);
                    me.$refs.observer_producto.reset();
                    me.mensaje('success', mensaje);
                }).catch(function (error) {
                    console.error(error);
                }); 
            },
            activarOdesactivar(id, accion){
                var mensaje = accion == 2 ? '¿Deseas restaurar el servicio?' : '¿Deseas borrar el servicio?';
                var mensaje_dos = accion == 2 ? 'El servicio ha sido restaurad0!' : 'El servicio ha sido quitado!';
                Swal.fire({
                    title: mensaje,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                }).then((result) => {
                    if (result.value) {
                        let me = this;

                        axios.post('/servicio/activar/desactivar',{
                            'id': id,
                            'accion': accion
                        }).then(function (response) {
                            me.limpiarDatosServicio();
                            me.listarServicios();
                            me.mensaje('success', mensaje_dos);
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === swal.DismissReason.cancel) {}
                })
            },
            eliminarProducto(id){
                Swal.fire({
                    title: '¿Deseas borrar el producto?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                }).then((result) => {
                    if (result.value) {
                        let me = this;

                        axios.post('/producto/eliminar',{
                            'id': id
                        }).then(function (response) {
                            me.listarProductos(me.servicio.id);
                            me.mensaje('success', 'El producto ha sido quitado!');
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === swal.DismissReason.cancel) {}
                })
            },
            cerrarModalServicio(){
                this.modal_servicio.titulo = "";
                this.modal_servicio.accion = 0;
                this.limpiarDatosServicio();
                this.$refs['modal_servicio'].hide();
            },
            cerrarModalProducto(){
                this.modal_producto.titulo = "";
                this.modal_producto.accion = 0;
                this.productos = [];
                this.servicio.id = 0;
                this.limpiarDatosProducto();
                this.$refs['modal_producto'].hide();
            },
            abrirModalServicio(accion, data = []){
                let me = this;

                if(accion == 1){
                    me.modal_servicio.titulo = "Agregar Servicio";
                    me.modal_servicio.accion = 1;
                } else if(accion == 2){
                    me.modal_servicio.titulo = "Modificar Servicio";
                    me.modal_servicio.accion = 2;

                    me.servicio.id = data['id'];
                    me.servicio.nombre = data['nombre'];
                }

                this.$refs['modal_servicio'].show();
            },
            abrirModalProducto(data = []){
                let me = this;

                me.modal_producto.titulo = "Productos del Servicio: " + data['nombre'];
                me.servicio.id = data['id'];

                this.listarProductos(me.servicio.id);
                this.$refs['modal_producto'].show();
            },
            cargarProducto(data = []){
                let me = this;

                me.producto.id = data['id'];
                me.producto.nombre = data['nombre'];
                me.producto.sesiones = data['cantidad_sesiones'];
                me.modal_producto.accion = 2;

                me.$refs.observer_producto.valid = true;
            },
            limpiarDatosServicio(){
                this.servicio.id = 0;
                this.servicio.nombre = '';
            },
            limpiarDatosProducto(){
                this.producto.id = 0;
                this.producto.nombre = '';
                this.producto.sesiones = '';
                this.modal_producto.accion = 1;
            },
        },
        mounted() {
            this.listarServicios();
        }
    }
</script>

<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }

    .modal-body{
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }

    .page-titles .breadcrumb {
        padding-left: 30px;
    }
</style>
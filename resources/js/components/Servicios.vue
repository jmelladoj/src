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
                        <b-button @click="abrirModal(1)" class="btn btn-info d-lg-block m-l-15" v-b-tooltip.hover title="Agrega un servicio a la plataforma"><i class="fa fa-plus-circle"></i> Agregar Servicio</b-button>
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
                                <b-table
                                    show-empty
                                    responsive
                                    striped
                                    borderless
                                    outlined
                                    small
                                    hover
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
                                    <b-button size="xs" v-b-tooltip.hover title="Actualizar información de servicio" @click="abrirModal(2, row.item)" class="btn btn-warning">
                                        <i class="fa fa-pencil"></i>
                                    </b-button>


                                    <template>
                                        <b-button v-if="row.item.deleted_at" size="xs" v-b-tooltip.hover title="Restaurar servicio" @click="borrarOrestaurar(row.item.id, 2)" class="btn btn-warning">
                                            <i class="fa fa-undo"></i>
                                        </b-button>

                                        <b-button v-else size="xs" v-b-tooltip.hover title="Eliminar servicio" @click="borrarOrestaurar(row.item.id, 1)"  class="btn btn-danger">
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
                            <ValidationProvider ref="validar" name="nombre" rules="required|min:3|alpha_spaces" v-slot="{ errors }" :bails="false" >
                                <b-form-input type="text" v-model="servicio.nombre"></b-form-input>
                                <b-alert variant="danger" :show="errors.length > 0">
                                    <label for="" v-for="(error, index) in errors" :key="index" v-text="'* ' + error"></label>
                                </b-alert>
                            </ValidationProvider>
                        </b-form-group>
                    </b-form>

                    <template slot="modal-footer">
                        <b-button :disabled="!valid" v-show="modal_servicio.accion == 1" size="md" variant="success" @click="crearOactualizar(1)"> Guardar </b-button>
                        <b-button v-show="modal_servicio.accion == 2" size="md" variant="warning" @click="crearOactualizar(2)"> Actualizar </b-button>
                        <b-button size="md" variant="danger" @click="cerrarModal()"> Cerrar </b-button>
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
                    nombre: '',
                    sesiones: ''
                },
                modal_servicio: {
                    titulo: '',
                    accion: 0
                },
                items: items,
                fields: [
                    { key: 'index', label: '#', sortable: true, sortDirection: 'desc', class: 'text-center' },
                    { key: 'nombre', label: 'NOMBRE', sortable: true, class: 'text-left' },
                    { key: 'acciones', label: 'ACCIONES', sortable: true, class: 'text-center' }
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
            crearOactualizar(accion){
                let me = this;

                this.$validator.validateAll('modal_ciudad').then(valido => {
                    if (valido) {
        

                        var url = accion == 1 ? '/ciudad/crear' : '/ciudad/actualizar';
                        axios.post(url,{
                            'ciudad_id': me.ciudad.id,
                            'nombre': me.ciudad.nombre
                        }).then(function (response) {
                            me.listarServicios();
                            me.cerrarModal();
                            var mensaje = me.modal_servicio.accion == 1 ? 'Registro agregado exitosamente' : 'Registro actualizado exitosamente';
                            swal.fire({
                                type: 'success',
                                title: mensaje,
                                showConfirmButton: false,
                                timer: 2000
                            })
                        }).catch(function (error) {
                            console.error(error);
                        });
                    }
                })
            },
            borrarOrestaurar(id, accion){
                var mensaje = accion == 2 ? '¿Deseas restaurar la Ciudad?' : '¿Deseas borrar la Ciudad?';
                swal.fire({
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

                        axios.post('/ciudad/borrar',{
                            'id': id
                        }).then(function (response) {
                            var mensaje_dos = accion == 2 ? 'La Ciudad ha sido restaurada!' : 'La Ciudad ha sido quitada!';
                            me.limpiarDatos();
                            me.listarServicios();
                            swal.fire(
                                mensaje_dos,
                                'El registro ha sido actualizado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (result.dismiss === swal.DismissReason.cancel) {}
                })
            },
            cerrarModal(){
  
                this.modal_servicio.titulo = "";
                this.modal_servicio.accion = 0;
                this.limpiarDatosServicio();
                this.$refs['modal_servicio'].hide();

            },
            abrirModal(accion, data = []){
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
            limpiarDatosServicio(){
                this.servicio.id = 0;
                this.servicio.nombre = '';
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

    .modal-lg{
        max-width: 90%;
    }

    .form-group{
        margin-bottom: 5px; 
    }

    .custom-file-input:lang(en) ~ .custom-file-label::after {
        content: 'Buscar';
    }

    .btn-file {
        position: relative;
        overflow: hidden;
    }

    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;   
        cursor: inherit;
        display: block;
    }

    .btn-bottom{
        bottom: 0;
        position: absolute;
    }  

    .btn-block {
        width: 90%;
    }

    .btn-block-modal {
        width: 100%;
    }

    .tabla-altura {
        max-height: 325px;
    }

</style>
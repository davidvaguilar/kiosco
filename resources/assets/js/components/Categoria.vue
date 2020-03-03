<template>
  <main>
    <section class="content-header">
      <h1>
        Listado de Categorias
        <small>preview of simple tables</small>
      </h1>
      <ol class="breadcrumb">
        <div class="pull-right">
          <button @click="abrirModal( 'categoria', 'registrar')" type="button" class="btn btn-success">
            <i class="fa fa-fw fa-plus"></i>Agregar Categoria
          </button>
        </div>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Responsive Hover Table</h3>

              <div class="box-tools">
                <div class="input-group" style="width: 450px;">  
                  <div class="input-group my-group"> 
                    <select class="form-control col-md-2" v-model="criterio">
                      <option value="nombre" selected>Categoría</option>
                      <option value="descripcion">Descripción</option>
                    </select> 
                    <input type="text" @keyup.enter="listarCategoria(1, buscar, criterio);" v-model="buscar" class="form-control" placeholder="Buscar texto">
                    <span class="input-group-btn">
                      <button type="button" @click="listarCategoria(1, buscar, criterio);" class="btn btn-primary"> <!--submit-->
                        <i class="fa fa-fw fa-search"></i> Buscar
                      </button>
                    </span>
                  </div>
                </div>

              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Categoría</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Editar</th>
                    <th>Cambiar Estado</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="categoria in arrayCategoria" :key="categoria.id">
                    <td v-text="categoria.nombre"></td>
                    <td v-text="categoria.descripcion"></td>
                    <td>            
                     <!--<i class="fa fa-fw fa-check" v-if="categoria.condicion"></i>-->
                      <span class="label label-success" v-if="categoria.condicion">activo</span>              
                      <!--<i class="fa fa-fw fa-times" v-else></i>-->  
                      <span class="label label-danger" v-else>desactivo</span> 
                    </td>
                    <td>
                      <button type="button" class="btn btn-block btn-info" @click="abrirModal( 'categoria', 'actualizar', categoria)">
                        <i class="fa fa-fw fa-edit"></i>
                      </button>
                    </td>
                    <td>         
                      <template v-if="categoria.condicion">              
                        <button type="button" class="btn btn-block btn-danger" @click="desactivarCategoria(categoria.id)">
                          <!--<i class="fa fa-fw fa-lock"></i>--> Desactivar
                        </button>
                      </template>
                      <template v-else>              
                        <button type="button" class="btn btn-block btn-success" @click="activarCategoria(categoria.id)">
                          <!--<i class="fa fa-fw fa-check"></i>--> Activar
                        </button>
                      </template>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">
                <li v-if="pagination.current_page > 1">
                  <a @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)" href="#">Anterior</a>
                </li>
                <li v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                  <a @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page" href="#"></a>
                </li>
                <li v-if="pagination.current_page < pagination.last_page">
                  <a @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)" href="#">Siguiente</a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>

    <div :class="{'mostrar':modal}" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button @click="cerrarModal()" type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" v-text="tituloModal"></h4>
          </div>
          <div class="modal-body">
            <div v-show="errorCategoria" class="alert alert-danger alert-dismissible">
                <div v-for="error in errorMostrarMsjCategoria" :key="error" v-text="error"></div>
            </div>

            <form action="" enctype="multipart/form-data" class="form-horizontal" method="POST">
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Categoría</label>
                <div class="col-md-9">
                    <input v-model="nombre" placeholder="Nombre de categoría" type="text" class="form-control">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                <div class="col-md-9">
                <input v-model="descripcion" placeholder="Ingrese descripcion" class="form-control" type="text">
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button @click="cerrarModal()" type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-fw fa-times"></i> Cerrar</button>
            <button type="button" @click="registrarCategoria()" v-if="tipoAccion==1" class="btn btn-success"><i class="fa fa-fw fa-save"></i> Guardar</button>
            <button type="button" @click="actualizarCategoria()" v-if="tipoAccion==2" class="btn btn-primary"><i class="fa fa-fw fa-pencil"></i> Actualizar</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
  </main>
</template>

<script>
  export default {

    data(){
      return {
        categoria_id: 0,
        nombre: '',
        descripcion: '',
        arrayCategoria: [],
        modal: 0,
        tituloModal: '',
        tipoAccion: 0,
        errorCategoria: 0,
        errorMostrarMsjCategoria: [],
        pagination: {
          'total': 0,
          'current_page': 0,
          'per_page': 0,
          'last_page': 0,
          'from': 0,
          'to': 0,
        },
        offset: 3,
        criterio: 'nombre',
        buscar: ''
      }
    },
    computed:{
      isActived: function(){
        return this.pagination.current_page;
      },
      pagesNumber: function(){
        if( !this.pagination.to ){
          return [];
        }
        var from = this.pagination.current_page-this.offset;
        if( from < 1 ){
          from = 1;
        }
        var to = from +(this.offset*2);
        if( to >= this.pagination.last_page ){
          to = this.pagination.last_page;
        }

        var pagesArray = []; 
        while( from <= to ){
          pagesArray.push(from);
          from++;
        }
        return pagesArray;
      }
    },

    methods:{
      listarCategoria(page, buscar, criterio){
        let me = this;
        var url = '/categoria?page=' + page+ '&buscar=' + buscar + '&criterio=' + criterio;

        axios.get(url).then(function(response){
          var respuesta = response.data;
          me.arrayCategoria = respuesta.categorias.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function (error){
          console.log(error);
        });
      },
      cambiarPagina(page, buscar, criterio){
        let me = this;
        me.pagination.current_page = page;
        me.listarCategoria(page, buscar, criterio);
      },
      registrarCategoria(){
        if( this.validarCategoria() ){
          return;
        }
        let me = this;
        axios.post('/categoria/registrar', {
          'nombre': this.nombre,
          'descripcion': this.descripcion
        }).then(function(response){
          me.cerrarModal();
          me.listarCategoria(1, '', 'nombre');
        })
        .catch(function (error){
          console.log(error);        
        });
      },
      actualizarCategoria(){
        if( this.validarCategoria() ){
          return;
        }
        let me = this;
        axios.put('/categoria/actualizar', {
          'id': this.categoria_id,
          'nombre': this.nombre,
          'descripcion': this.descripcion
        }).then(function(response){
          me.cerrarModal();
          me.listarCategoria(1, '', 'nombre');
        })
        .catch(function (error){
          console.log(error);        
        });
      },
      desactivarCategoria(id){
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
          buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
          title: '¿Estas seguro de desactivar la categoria?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: '<i class="fa fa-check fa-2x"></i> Aceptar',
          cancelButtonText: '<i class="fa fa-times fa-2x"></i> Cancelar',
          reverseButtons: true
        }).then((result) => {
          if (result.value) {
            let me = this;
            axios.put('/categoria/desactivar', {
              'id' : id
            }).then(function(response){
              me.listarCategoria(1, '', 'nombre');
              swalWithBootstrapButtons.fire(
                'Desactivado!',
                'El registro ha sido desactivado con exito.',
                'success'
              )
            })
            .catch(function (error){
              console.log(error);        
            });
          } else if (
            result.dismiss === Swal.DismissReason.cancel
          ) {
           
          }
        })
      },
      activarCategoria(id){
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
          buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
          title: '¿Estas seguro de activar la categoria?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: '<i class="fa fa-check fa-2x"></i> Aceptar',
          cancelButtonText: '<i class="fa fa-times fa-2x"></i> Cancelar',
          reverseButtons: true
        }).then((result) => {
          if (result.value) {
            let me = this;
            axios.put('/categoria/activar', {
              'id' : id
            }).then(function(response){
              me.listarCategoria(1, '', 'nombre');
              swalWithBootstrapButtons.fire(
                'Activado!',
                'El registro ha sido activado con exito.',
                'success'
              )
            })
            .catch(function (error){
              console.log(error);        
            });
          } else if (
            result.dismiss === Swal.DismissReason.cancel
          ) {
           
          }
        })
      },
      validarCategoria(){
        this.errorCategoria = 0;
        this.errorMostrarMsjCategoria = [];
        if( !this.nombre ){
          this.errorMostrarMsjCategoria.push("(*)El nombre de la categoria no puede estar vacio");
        }
        if( this.errorMostrarMsjCategoria.length ){
          this.errorCategoria = 1;
        }
        return this.errorCategoria;
      },
      cerrarModal(){
        this.modal = 0;
        this.tituloModal = "";
        this.nombre = "";
        this.descripcion = "";
      },
      abrirModal( modelo, accion, data=[] ){
        switch( modelo ){
          case "categoria":
          {
            switch( accion ){
              case "registrar":
              {
                this.modal = 1;
                this.tituloModal = "Agregar categoría";
                this.nombre = "";
                this.descripcion = "";
                this.tipoAccion = 1;
                break;
              }
              case "actualizar":
              {
                this.modal = 1;
                this.tituloModal = "Editar categoria";
                this.tipoAccion = 2;
                this.categoria_id = data["id"];
                this.nombre = data["nombre"];
                this.descripcion = data["descripcion"];
                break;
              }
            }
          }
        }
      }
    },

    mounted() {
      this.listarCategoria(1, this.buscar, this.criterio);
    }

  }
</script>

<style>
  .modal-content{
    width:100% !important;
    position:absolute !important;
  }

  .mostrar{
    display:list-item !important;
    opacity:1 !important;
    position:absolute !important;
    background-color: #3c29297a !important;
  }

  .div-error{
    display:flex;
    justify-content:center;
  }

  .text-error{
    color: red !important;
    font-weight: bold;
    font-size: 20px;
  }
</style>
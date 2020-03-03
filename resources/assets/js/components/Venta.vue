<template>
  <main class="main">
    <section class="content-header">
      <h1>
        Listado de Ventas
        <small>preview of simple tables</small>
      </h1>
      <ol class="breadcrumb">
        <div class="pull-right">
          <button @click="mostrarDetalle()" type="button" class="btn btn-success">
            <i class="fa fa-fw fa-plus"></i><span v-text="this.impuesto"></span>
          </button>
        </div>
      </ol>
    </section>
<!-- Main content -->
    <section class="content">
      <template v-if="listado==1">   
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Responsive Hover Table</h3>

                <div class="box-tools">
                  <div class="input-group" style="width: 450px;">  
                    <div class="input-group my-group"> 
                      <select class="form-control col-md-2" v-model="criterio">
                        <option value="tipo_identificacion">Tipo identificación</option>
                        <option value="num_venta">Número Venta</option>
                        <option value="fecha_venta">Fecha Venta</option>
                      </select> 
                      <input @keyup.enter="listarVenta(1, buscar, criterio);" v-model="buscar" class="form-control" placeholder="Buscar texto"  type="text">
                      <span class="input-group-btn">
                        <button @click="listarVenta(1, buscar, criterio);" type="button" class="btn btn-primary">
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
                      <th>Ver</th>
                      <th>Fecha Venta</th>
                      <th>Número Venta</th>
                      <th>Cliente</th>
                      <th>Tipo de identificación</th>
                      <th>Vendedor</th>  
                      <th>Total</th>
                      <th>Impuesto</th>
                      <th>Estado</th>
                      <th>Cambiar estado</th>
                      <th>Descargar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="venta in arrayVenta" :key="venta.id">
                      <td> <!--compra.id-->
                        <button @click="verVenta(venta.id)" type="button" class="btn btn-block btn-warning" title="DETALLE">
                          <i class="fa fa-fw fa-eye"></i>
                        </button>
                      </td>
                      <td v-text="venta.fecha_venta"></td>
                      <td v-text="venta.num_venta"></td>
                      <td v-text="venta.nombre"></td>
                      <td v-text="venta.tipo_identificacion"></td> 
                      <td v-text="venta.usuario"></td> 
                      <td v-text="'$ '+venta.total"></td>
                      <td v-text="venta.impuesto * 100 + ' %'"></td>
                      <td>
                        <span v-if="venta.estado=='Registrado'" title="REGISTRADO" class="label label-success">Activo</span>              
                        <span v-else title="ANULADO" class="label label-danger">Anulado</span> 
                      </td>
                      <td>
                        <template v-if="venta.estado=='Registrado'">
                          <button type="button" class="btn btn-block btn-danger" @click="desactivarVenta(venta.id)">
                            <i class="fa fa-times"></i> Anular Venta
                          </button>
                        </template>
                        <!--<template v-else>
                            <button type="button" class="btn btn-block btn-danger">
                              <i class="fa fa-check"></i> Cambiado
                            </button>
                        </template>-->
                      </td>
                      <td>                 
                        <button @click="pdfVenta(venta.id)" type="button" class="btn btn-block btn-info">
                          <i class="fa fa-fw fa-file"></i> PDF
                        </button>
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
      </template>
      <!-- /.row -->
      <template v-else-if="listado==2">
        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Detalle de Venta</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="col-md-3">
              <div class="form-group">
                <label class="text-uppercase"><strong>Cliente</strong></label>
                <p v-text="cliente"></p>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="text-uppercase"><strong>Tipo de identificación</strong></label>
                <p v-text="tipo_identificacion"></p>
              </div>
            </div>    
            <div class="col-md-3">
              <div class="form-group">
                <label class="text-uppercase"><strong>Número Venta</strong></label>
                <p v-text="num_venta"></p>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="text-uppercase"><strong>Impuesto</strong></label>
                <p v-text="impuesto"></p>
              </div>
            </div>

            <div class="box-body table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Descuento</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody v-if="arrayDetalle.length">
                  <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                    <td v-text="detalle.producto"> </td>
                    <td v-text="detalle.precio"> </td>
                    <td v-text="detalle.cantidad"> </td>
                    <td v-text="detalle.descuento"> </td>
                    <td>$ {{ detalle.precio * detalle.cantidad - detalle.descuento }} </td>
                  </tr>
                  <tr>
                    <td colspan="4" align="right"><strong>Sub-Total:</strong></td>
                    <td><strong>$ {{ subTotal = (total - subTotalImpuesto) }}</strong></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="right"><strong>Impuesto:</strong></td>
                    <td><strong>$ {{ subTotalImpuesto = ((total * impuesto)) }}</strong></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="right"><strong>Total:</strong></td>
                    <td><strong>$ {{ total }}</strong></td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td colspan="5"> No se han agregado productos </td>
                  </tr>
                </tbody>  
              </table>
            </div>

          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button @click="ocultarDetalle()" type="button" class="btn btn-danger">
              <i class="fa fa-times fa-2x"></i> Volver
            </button>
          </div>
          <!-- /.box-footer-->
        </div>
        <!-- /.box -->
      </template>
    </section>

  </main>
</template>

<script>
  import vSelect from 'vue-select';
  import 'vue-select/dist/vue-select.css';
  export default {
    data(){
      return {
        menu :7,
        venta_id : 0,
        idcliente : 0,
        cliente : '',
        tipo_identificacion : 'FACTURA',
        num_venta : '',
        impuesto : 0.18,
        total : 0.0,
        subTotalImpuesto : 0.0,
        subTotal : 0.0,
        arrayVenta : [],
        arrayCliente : [],
        arrayDetalle : [],
        listado : 1,
        modal : 0,
        tituloModal : '',
        tipoAccion : 0,
        errorVenta : 0,
        errorMostrarMsjVenta : [],
        pagination : {
            'total': 0,
            'current_page': 0,
            'per_page': 0,
            'last_page': 0,
            'from': 0,
            'to': 0,
        },
        offset:3,
        criterio:'num_venta',
        buscar:'',
        criterioP:'nombre',
        buscarP: '',
        arrayProducto: [],
        idproducto: 0,
        codigo: '',
        producto: '',
        precio: 0,
        cantidad:0,
        descuento:0,
        stock:0
      }

    },
    components: {
      vSelect
    },

    computed:{
      isActived: function(){
        return this.pagination.current_page;
      },
      //calcula los elementos de la paginacion
      pagesNumber: function(){
        if( !this.pagination.to ){
          return[];
        }
        var from = this.pagination.current_page - this.offset;
        if(from < 1){   
          from = 1;
        }
        var to = from + (this.offset * 2);
        if(to >= this.pagination.last_page){   
          to = this.pagination.last_page; 
        }
        var pagesArray = [];
        while(from <= to){   
          pagesArray.push(from);
          from++;
        }
        return pagesArray;
      }
    },

    methods:{
      listarVenta(page,buscar,criterio){
        let me = this;
        var url = '/venta?page=' + page + '&buscar='+ buscar + '&criterio=' + criterio;
        axios.get(url).then(function (response) {
          var respuesta = response.data;
          me.arrayVenta = respuesta.ventas.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function (error) {
          console.log(error);
        });
      },

      pdfVenta(id){
        //alert(window.location.host);
        window.open('http://tienda.dyi.cl/venta/pdf/'+id+','+ '_blank');
      },

      cambiarPagina(page, buscar, criterio){     
        let me = this;
        //Actualiza  la pagina actual
        me.pagination.current_page = page;
        me.listarCompra(page,buscar,criterio);
      },


      encuentra( id ){
        var sw = 0;
        for( var i=0; i < this.arrayDetalle.length; i++){
          if( this.arrayDetalle[i].idproducto == id ){
            sw = true;
          }
        }
        return sw;
      },

      listarProducto(buscar, criterio){
        let me=this;
        var url= '/producto/listarProductoVenta?buscar='+ buscar + '&criterio='+ criterio;
        axios.get(url).then(function (response) {
          var respuesta= response.data;
          me.arrayProducto = respuesta.productos.data;
        })
        .catch(function (error) {
          console.log(error);
        });
      },

      mostrarDetalle(){
        let me = this;       
        me.listado = 0;
        me.idproveedor = 0;
        me.tipo_identificacion = 'FACTURA';
        me.num_compra = '';
        me.impuesto = 0.18;
        me.total = 0.0;
        me.idproducto = 0;
        me.producto = '';
        me.cantidad = 0;
        me.precio = 0;
        me.arrayDetalle = [];
      },
      ocultarDetalle(){
        this.listado = 1;
      },
      verVenta(id){
        let me = this;
        me.listado = 2;
        var arrayVentaT = [];
        var url = '/venta/obtenerCabecera?id=' + id;
        axios.get(url).then(function (response) {
          var respuesta = response.data;
          arrayVentaT = respuesta.venta;
          me.cliente = arrayVentaT[0]['nombre'];
          me.tipo_identificacion = arrayVentaT[0]['tipo_identificacion'];
          me.num_venta = arrayVentaT[0]['num_venta'];
          me.impuesto = arrayVentaT[0]['impuesto'];
          me.total = arrayVentaT[0]['total'];
        })
        .catch(function (error) {
          console.log(error);
        });
        var urld = '/venta/obtenerDetalles?id=' + id;
        axios.get(urld).then(function (response) {
          console.log(response);
          var respuesta = response.data;
          me.arrayDetalle = respuesta.detalles;
        })
        .catch(function (error) {
          console.log(error);
        });     
      },
     
      desactivarVenta(id){
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
          buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
          title: 'Esta seguro de anular la venta?',
          //type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="fa fa-check fa-2x"></i> Aceptar!',
          cancelButtonText: '<i class="fa fa-times fa-2x"></i> Cancelar',
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false,
          reverseButtons: true
        }).then((result) => {
          if (result.value) {
            let me = this;
            axios.put('/venta/desactivar',{
                'id': id
            }).then(function (response) {
              me.listarVenta(1,'','num_venta');
              swalWithBootstrapButtons.fire(
                'Anulado!',
                'La venta ha sido anulada con éxito.',
                'success'
              )
            }).catch(function (error) {
                console.log(error);
            });
          } else if (
            result.dismiss === swal.DismissReason.cancel
          ) {     
          }
        }) 
      },
    },
    mounted() {
      this.listarVenta(1, this.buscar, this.criterio);
    }
  }
</script>

<style>
  .modal-content{
    width : 100% !important;
    position : absolute !important;
  }

  .mostrar{
    display : list-item !important;
    opacity : 1 !important;
    position : absolute !important;
    background-color : #3c29297a !important;
  }

  .div-error{
    display : flex;
    justify-content : center;
  }

  .text-error{
    color : red !important;
    font-weight : bold;
    font-size : 20px;
  }

  @media (min-width: 600px) {
    .btnagregar {
      margin-top : 2rem;
    }
  }
</style>
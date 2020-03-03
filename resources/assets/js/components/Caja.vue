<template>
  <main class="main">
    <section class="content-header">
      <h1>
        Caja
        <small>preview of simple tables</small>
      </h1>
      <ol class="breadcrumb">
        <div class="pull-right">
          <button type="button" class="btn btn-primary"><!---CAMBIAR-->
            <i class="fa fa-fw fa-cog"></i> Datos de Venta
          </button>
          <button @click="abrirModal()" type="button" class="btn btn-success"><!---CAMBIAR-->
            <i class="fa fa-fw fa-plus"></i> Agregar Producto
          </button>
        </div>
      </ol>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Registro de Venta</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>

        <div class="box-body">
          <div class="form-group row border">
            <!--<div class="col-md-6">
              <div class="form-group">
                <label class="text-uppercase"><strong>Número Venta(*)</strong></label>
                <input type="text" class="form-control" v-model="num_venta" placeholder="">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="text-uppercase"><strong>Cliente(*)</strong></label>
                <v-select
                    @search="selectCliente"
                    label="nombre"
                    :options="arrayCliente"
                    placeholder="Buscar Clientes..."
                    @input="getDatosCliente" >
                </v-select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="text-uppercase"><strong>Tipo Identificación</strong></label>
                <select class="form-control" v-model="tipo_identificacion">
                  <option value="BOLETA" selected>Boleta</option>
                  <option value="FACTURA">Factura</option>                        
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <label class="text-uppercase"><strong>Impuesto</strong></label>
              <input type="text" class="form-control" v-model="impuesto">
            </div>      -->
          </div>
          <div class="form-group row">
            <div class="col-md-12">
              <div v-show="errorVenta" class="form-group row div-error">
                <div class="text-center text-error">
                  <div v-for="error in errorMostrarMsjVenta" :key="error" v-text="error"> </div>
                </div>
              </div>
            </div>
          </div>
          <!--<div class="form-group row border">-->
            <!--<div class="col-md-6">
              <div class="form-group">
                <label>Producto </label>
                <div class="form-inline">
                  <input ref="codigo" v-model="codigo" @keyup.enter="buscarProducto()" v-focus placeholder="Ingrese código" type="text" class="form-control">
                  <button @click="abrirModal()" class="btn btn-primary">
                    <i class="fa fa-plus"></i>&nbsp;Agregar Productos
                  </button>
                  <input type="text" readonly class="form-control" v-model="producto">
                </div>                                    
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Cantidad </label>
                <input ref="cantidad" v-model="cantidad" v-on:keyup.65="aumentarCantidad()" v-on:keyup.90="disminuirCantidad()" @keyup.enter="agregarDetalle()" readonly type="number" class="form-control">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <button @click="agregarDetalle()" class="btn btn-primary form-control"><i class="fa fa-fw fa-plus"></i> Agregar detalle</button>
              </div>
            </div>-->
            <!--<div class="col-md-2">
              <div class="form-group">
                <label>Precio </label>
                <input type="number" value="0" step="any" class="form-control" v-model="precio">
              </div>
            </div>-->
            <!--<div class="col-md-2">
              <div class="form-group">
                <label>Descuento </label>
                <input type="number" value="0" class="form-control" v-model="descuento">
              </div>
            </div>-->            
          <!--</div>-->
        </div>

        <div class="table-responsive col-md-12">
          <table class="table table-bordered table-striped table-sm">
            <thead>
              <tr>
                <th>Eliminar</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <!--<th>Descuento</th>-->
                <th>Total</th>
              </tr>
            </thead>
            <tbody v-if="arrayDetalle.length">
              <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                <td>
                  <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-block">
                    <i class="fa fa-fw fa-times"></i>
                  </button>
                </td>
                <td v-text="detalle.producto"> </td>
                <td>
                  <input v-model="detalle.precio" type="number" class="form-control">
                </td>
                <td>
                  <span style="color:red;" v-show="detalle.cantidad>detalle.stock">Stock: {{detalle.stock}}</span>
                  <input v-model="detalle.cantidad" type="number" class="form-control">
                </td>
                <!--<td>
                  <span style="color:red;" v-show="detalle.descuento>(detalle.precio*detalle.cantidad)">Descuento superior al total</span>
                  <input v-model="detalle.descuento" type="number" class="form-control">
                </td>-->
                <td>{{ detalle.precio * detalle.cantidad }}</td>
              </tr>
              <tr>
                <td colspan="4" align="right"><strong>Sub-Total:</strong></td>
                <td><strong>$ {{ subTotal = (total - subTotalImpuesto).toFixed(2) }}</strong></td>
              </tr>
              <tr>
                <td colspan="4" align="right"><strong>Impuesto:</strong></td>
                <td><strong>$ {{ subTotalImpuesto = ( (total * impuesto) / (1 + impuesto) ).toFixed(2) }}</strong></td>
              </tr>
              <tr>
                <td colspan="4" align="right"><strong>Total:</strong></td>
                <td><strong>$ {{ total = calcularTotal }}</strong></td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr>
                <td colspan="5"> No se han agregado productos </td>
              </tr>
            </tbody>                                    
          </table>
        </div>

        <!-- /.box-body -->
        <div class="box-footer">
          <!--<button @click="ocultarDetalle()" type="button" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>-->
          <button @click="registrarVenta()" type="button" class="btn btn-success"><i class="fa fa-fw fa-save"></i> Registrar Venta</button>
          <span>
            <strong>(*) Campo obligatorio</strong>
          </span><br/>
        </div>
        <!-- /.box-footer-->
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
            <!--<div v-show="errorCategoria" class="alert alert-danger alert-dismissible">
                <div v-for="error in errorMostrarMsjCategoria" :key="error" v-text="error"></div>
            </div>-->
            <div class="form-group row">
              <label class="col-md-3 form-control-label" for="producto-input">Producto</label>
              <div class="col-md-9">
                  <input ref="codigo" v-model="codigo" @keyup.enter="buscarProducto()" v-focus placeholder="Ingrese código" type="text" class="form-control"> <!--buscarProducto() -->
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3 form-control-label" for="cantidad-input">Cantidad</label>
              <div class="col-md-9">
                  <input ref="cantidad" v-model="cantidad" v-on:keyup.65="aumentarCantidad()" v-on:keyup.90="disminuirCantidad()" @keyup.enter="agregarDetalle()" readonly type="number" class="form-control">
              </div>
            </div>
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




    <!--Inicio del modal agregar/actualizar
    <div class="modal fade" :class="{'mostrar':modal}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-text="tituloModal"></h4>
            <button type="button" @click="cerrarModal()" class="close" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="form-group row">
              <div class="col-md-8">
                <div class="input-group">
                  <select class="form-control col-md-5" v-model="criterioP">
                    <option value="nombre">Producto</option>
                    <option value="codigo">Código</option>
                  </select>
                  <input type="text"  @keyup.enter="listarProducto(buscarP,criterioP);" v-model="buscarP" class="form-control" placeholder="Buscar texto">
                  <button type="submit"  @click="listarProducto(buscarP,criterioP);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm text-center">
                <thead>
                  <tr class="bg-primary">                    
                    <th>Categoria</th>
                    <th>Producto</th>
                    <th>Codigo</th>
                    <th>Precio venta</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Estado</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="producto in arrayProducto" :key="producto.id">              
                    <td v-text="producto.nombre_categoria"></td>
                    <td v-text="producto.nombre"></td>
                    <td v-text="producto.codigo"></td>
                    <td v-text="'$ '+producto.precio_venta"></td>
                    <td v-text="producto.stock"></td>
                    <td>
                      <img :src="'img/producto/'+producto.imagen" class="img-responsive" width="50px" height="50px">
                    </td>
                    <td>
                      <button type="button" class="btn btn-success btn-sm" title="ACTIVO" v-if="producto.condicion">
                        <i class="fa fa-unlock fa-2x"></i>&nbsp;
                      </button>
                      <button type="button" class="btn btn-danger btn-sm" title="DESACTIVADO" v-else>
                        <i class="fa fa-lock fa-2x"></i>&nbsp;
                      </button>
                    </td>
                    <td>
                      <button type="button" @click="agregarDetalleModal(producto)" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus fa-2x"></i> Agregar 
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" @click="cerrarModal()" class="btn btn-danger"><i class="fa fa-times fa-2x"></i> Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    Fin del modal-->
  </main>
</template>

<script>
  import vSelect from 'vue-select';
  import 'vue-select/dist/vue-select.css';
  export default {
    directives: { 
      focus: {
        inserted: function (el) {
          el.focus()
        }
      }
    },
    data(){
      return {
        venta_id : 0,
        idcliente : 0,
        cliente : '',
        tipo_identificacion : 'FACTURA',
        num_venta : '',
        impuesto : 0.19,
        total : 0.0,
        subTotalImpuesto : 0.0,
        subTotal : 0.0,
        arrayVenta : [],
        arrayCliente : [],
        arrayDetalle : [],
        listado : 1,
        modal : 1,
        tituloModal : 'Ingresar productos',
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
        offset : 3,
        criterio : 'num_venta',
        buscar : '',
        criterioP : 'nombre',
        buscarP : '',
        arrayProducto : [],
        idproducto : 0,
        codigo : '',
        producto : '',
        precio : 0,
        cantidad :1,
        descuento : 0,
        stock : 0
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
      },
      calcularTotal: function(){
        var resultado = 0.0;
        for( var i=0; i < this.arrayDetalle.length; i++){
          resultado = resultado + (this.arrayDetalle[i].precio * this.arrayDetalle[i].cantidad)
        }
        return resultado;
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
      selectCliente(search, loading){
        let me = this;
        loading(true)
        var url = '/cliente/selectCliente?filtro=' + search;
        axios.get(url).then(function (response) {
          let respuesta = response.data;
          q: search
          me.arrayCliente = respuesta.clientes;
          loading(false)
        })
        .catch(function (error) {
          console.log(error);
        });
      },

      getDatosCliente(val1){
        let me = this;
        me.loading = true;
        me.idcliente = val1.id;
      },

      aumentarCantidad(){
        let me = this;
        me.cantidad = me.cantidad+1;
      },
      disminuirCantidad(){
        let me = this;
        if( me.cantidad > 1 ){
          me.cantidad = me.cantidad-1;
        }
      },

      buscarProducto(){
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
          buttonsStyling: false
        })
        let me = this;
        var url = '/producto/buscarProductoVenta?filtro=' + me.codigo;
        axios.get(url).then(function (response) {
          var respuesta = response.data;
          me.arrayProducto = respuesta.productos;
          if( me.arrayProducto.length > 0 ){
            me.producto = me.arrayProducto[0]['nombre'];
            me.idproducto = me.arrayProducto[0]['id'];
            me.precio = me.arrayProducto[0]['precio_venta'];
            me.stock = me.arrayProducto[0]['stock'];
            me.tituloModal = me.producto;
            me.$refs.cantidad.focus();
          }
          else{
            me.producto = 'No existe el producto';
            me.tituloModal = 'No existe el producto';
            me.idproducto = 0;
            swalWithBootstrapButtons.fire({
                type: 'error',
                title: 'Error...',
              text: 'No existe el producto',
            })
          }
        })
        .catch( function (error) {
          console.log(error);
        });
        
      },
      agregarDetalle(){
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
          buttonsStyling: false
        })
        let me = this;
        if( me.codigo==0 ){
          swalWithBootstrapButtons.fire({
            type: 'error',
            title: 'Error...',
            text: 'Ingrese Producto',
          })
        } else {
          var url = '/producto/buscarProductoVenta?filtro=' + me.codigo;
          axios.get(url).then(function (response) {
            var respuesta = response.data;
            me.arrayProducto = respuesta.productos;
            if( me.arrayProducto.length > 0 ){
              me.producto = me.arrayProducto[0]['nombre'];
              me.idproducto = me.arrayProducto[0]['id'];
              me.precio = me.arrayProducto[0]['precio_venta'];
              me.stock = me.arrayProducto[0]['stock'];

              if( me.cantidad > me.stock ){
                swalWithBootstrapButtons.fire({
                  type: 'error',
                  title: 'Error...',
                  text: 'Maximo stock disponible es: '+me.stock,
                })
                me.cantidad = me.stock;
              } else {
                me.arrayDetalle.push({
                    idproducto: me.idproducto,
                    producto: me.producto,
                    cantidad: me.cantidad,
                    precio: me.precio,
                    stock: me.stock
                });
                me.codigo = "";
                me.idproducto = 0;
                me.producto = "";
                me.cantidad = 1;
                me.precio = 0;
                me.stock = 0;
                me.$refs.codigo.focus();
              } 
            }
            else{
              me.producto = 'No existe el producto';
              me.idproducto = 0;
              swalWithBootstrapButtons.fire({
                type: 'error',
                title: 'Error...',
                text: 'No existe el producto',
              })
            }
          })
          .catch( function (error) {
            console.log(error);
          });/* FIN BUSQUEDA */

          /*if(me.encuentra(me.idproducto)){
            swalWithBootstrapButtons.fire({
              type: 'error',
              title: 'Error...',
              text: 'Ese producto ya fue agregado',
            })
          } else {
            if( me.cantidad>me.stock ){
              swalWithBootstrapButtons.fire({
                type: 'error',
                title: 'Error...',
                text: 'No hay stock disponible',
              })
            } else {
              me.arrayDetalle.push({
                  idproducto: me.idproducto,
                  producto: me.producto,
                  cantidad: me.cantidad,
                  precio: me.precio,
                  descuento: me.descuento,
                  stock: me.stock
              });
              me.codigo = "";
              me.idproducto = 0;
              me.producto = "";
              me.cantidad = 0;
              me.precio = 0;
              me.descuento = 0;
              me.stock = 0
            }
          }*/
        }
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
      eliminarDetalle(index){
        let me = this;
        me.arrayDetalle.splice(index, 1);
      },

      


      agregarDetalleModal( data=[] ){
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
          buttonsStyling: false
        })
        let me=this;
        if(me.encuentra(data['id'])){
          swalWithBootstrapButtons.fire({
            type: 'error',
            title: 'Error...',
            text: 'Ese producto ya fue agregado',
          })
        } else {
          me.arrayDetalle.push({
              idproducto: data['id'],
              producto: data['nombre'],
              cantidad: 1,
              precio: data['precio_venta'],
              descuento:0,
              stock:data['stock']
          }); 
        }
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

      registrarVenta(){
        if(this.validarVenta()){
          return;
        }
        let me = this;
        axios.post('/venta/registrar',{
          'idcliente': this.idcliente,
          'tipo_identificacion': this.tipo_identificacion,
          'num_venta' : this.num_venta,
          'impuesto' : this.impuesto,
          'total' : this.total,
          'data': this.arrayDetalle
        }).then(function (response) {
          me.listado = 1;
          me.listarVenta(1, '', 'num_venta');
          me.idcliente = 0;
          me.tipo_identificacion = 'FACTURA';
          me.num_venta = '';
          me.impuesto = 0.19;
          me.total = 0.0;
          me.idproducto = 0;
          me.producto = '';
          me.cantidad = 0;
          me.precio = 0;
          me.stock = 0;
          me.codigo = '';
          me.descuento = 0;
          me.arrayDetalle = [];
        }).catch(function (error) {
          console.log(error);
        });
      },

      validarVenta(){
        let me = this;
        me.errorVenta = 0;
        me.errorMostrarMsjVenta = [];
        var prod;
        me.arrayDetalle.map(function(x){
          if( x.cantidad>x.stock ){
            prod = x.producto + " con stock insuficiente";
            me.errorMostrarMsjVenta.push(prod);
          }
        });
        if( me.idcliente == 0 ) me.errorMostrarMsjVenta.push("Seleccione un Cliente");
        if( me.tipo_identificacion == 0 ) me.errorMostrarMsjVenta.push("Seleccione la identificación");
        if( !me.num_venta ) me.errorMostrarMsjVenta.push("Ingrese el número de venta");
        //if( !me.impuesto ) me.errorMostrarMsjVenta.push("Ingrese el impuesto de venta");
        if( me.arrayDetalle.length <= 0 ) me.errorMostrarMsjVenta.push("Ingrese detalles");
        if( me.errorMostrarMsjVenta.length ) me.errorVenta = 1;
        return me.errorVenta;
      },
      mostrarDetalle(){
        let me = this;       
        me.listado = 0;
        me.idproveedor = 0;
        me.tipo_identificacion = 'FACTURA';
        me.num_compra = '';
        me.impuesto = 0.19;
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
      cerrarModal(){
        this.modal = 0;
        this.tituloModal = '';
      },
      abrirModal(){    
        let me = this;    
        me.arrayProducto=[];
        me.tituloModal = 'Ingresar productos';
        me.codigo = "";
        me.modal = 1;
        me.$refs.codigo.focus();                      
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


</style>
<section>
    <div class="lead text-success">
    </div>
    <?php echo form_open();?>

 
        <div class="form-group">
            <label>Proyecto</label>
            <?php echo form_input('nombre',$proyecto->nombre,'class="form-control"')?>
        </div>
        <div class="form-group">
            <label>Clave</label>
            <?php echo form_input('clave',$proyecto->clave,'class="form-control"')?>
        </div>
        <div class="form-group">
            <label>Descripcion</label>
            <?php echo form_textarea('description',$proyecto->description,'class="form-control"')?>
        </div>
        <div class="form-group">
            <label>Repositorio</label>
            <?php echo form_input('repository',$proyecto->repository,'class="form-control"')?>
        </div>   
        <div class="form-group">
            <input type="hidden" name="tipo" value="1">
        </div>     

        <div class="divider"></div>
         <div class="form-actions">
      <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
     </div>
     

    <?php echo form_close();?>
    <button ui-wave class="btn btn-flat btn-primary" ng-click="close()" >Cerrar</button>
            <button ui-wave class="btn btn-flat" ng-disabled="!myForm.$valid" ng-click="save()" >Guardar</button>
</section>
<section>
    <div class="lead text-success">
    </div>
<?php echo form_open()?>

        <div class="form-group">
            <label>Nombre</label> 
               <?=form_input('nombre',$tarea->nombre,'class="form-control" required')?>   

        </div>
        <div class="row">

            <div class="col-md-6">
            <div class="form-group">
            <label>Tipo:</label>

            <?=form_dropdown('tipo',array(''=>' [ Elegir ]','0'=>'Mejora','1'=>'Tarea','2'=>'Nueva Funcion','3'=>'Error'),$tarea->tipo,'class="form-control" required')?>

            </div>


            <div class="form-group">
            <label >Asignar a:</label>

                 <?=form_dropdown('asignado',array(''=>' [ Elegir ] ')+$users,$tarea->asignado,'class="form-control"');?>
            </div>


             </div> 
            <div class="col-md-6">

             <div class="form-group">
            <label >Prioridad:</label>

            <?=form_dropdown('prioridad',array(''=>' [ Elegir ]','0'=>'Bajo','1'=>'Medio','2'=>'Alto','3'=>'Urgente'),$tarea->prioridad,'class="form-control" 
            required')?>

             </div>
                            <div class="form-group">
                            <label>Fecha de Entrega</label>
                            <div class="input-group ui-datepicker">
                             <?=form_input('entrega',NULL,'class="form-control" uib-datepicker-popup="yyyy-MM-dd" 
                                                   ng-init="entrega=\''.$tarea->entrega.'\'"
                                                   ng-model="entrega"
                                                   is-open="status.entrega"                              
                                                   datepicker-options="dateOptions" 
                                                   date-disabled="disabled(date, mode)" 
                                                   close-text="Cerrar" required')?>
                             <?php if($this->method!='details'):?>
                             <span class="input-group-addon" ng-click="status.entrega=true;"><i class="glyphicon glyphicon-calendar"></i></span>
                             <?php endif; ?>
                            </div>
                            </div>             


             </div> 

        </div>


           
        <div class="form-group" >
            <label>Descripcion</label>
                    <textarea name="description" class="form-control" rows="5"><?=$tarea->description?></textarea>
        </div>

         <div class="divider"></div>
         <div class="form-actions">
      <a href="<?=base_url('admin/proyectos/'.$id)?>" class="btn btn-w-md ui-wave btn-default">Cancelar</a>
      <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save',) )) ?>
     </div>
    
       <?php echo form_close();?>  
</section>
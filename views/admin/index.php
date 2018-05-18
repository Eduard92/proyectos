<section ng-controller="InputCtrl" >
   

    <div class="ui-tab-container ui-tab-horizontal">
      
        
        <uib-tabset justified="false" class="ui-tab">
            <uib-tab heading="Trabajo Pendiente">
                 <?php if(empty($tareas_pendietes)== false):?>

                <div clearfix">
                        
                        <a href="<?=base_url('admin/proyectos/create_task/'.$id)?>"  uib-tooltip="Nueva Tarea" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Nueva Tarea</a>
                     
                </div>
              
                    <div id="block-sprint" class="panel-body">
 

                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th width="85%"></th>
                          <th width="15%"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="(i,tarea) in tareas">

                          <td><a href="#" ng-click="prepend_edit(tarea)" >
                                       
                                       <strong>{{$index+1}}.- {{tarea.nombre}}</strong>
                                    </a></td>
                          <td>
                            <a href="<?=base_url('admin/proyectos/start_task/'.$id.'/'.'{{tarea.id}}')?>" uib-tooltip="Iniciar Tarea" class="btn-icon btn-icon-sm btn-info ui-wave"><i class="fa fa-play"></i></a>
                             <a href="<?=base_url('admin/proyectos/edit_task/'.'{{tarea.id}}')?>" uib-tooltip="Editar Tarea"  class="btn-icon btn-icon-sm btn-primary ui-wave"><i class="fa fa-edit"></i></a> 
                            <a href="<?=base_url('admin/proyectos/delete_task/'.$id.'/'.'{{tarea.id}}')?>" uib-tooltip="Eliminar Tarea" class="btn-icon btn-icon-sm btn-danger ui-wave"><i class="fa fa-remove"></i></a>
                            </td>
                        </tr>
                      </tbody>
                    </table>
                </div>
            <!-- FIN PANEL TAREAS --> 
             <?php else:?>
        <div class="alert alert-info text-center">
            <?=lang('tarea:not_found');?>

        <div class="divider"></div>
                    

                        <a href="<?=base_url('admin/proyectos/create_task/'.$id)?>"  uib-tooltip="Nueva Tarea" class="btn btn-primary"><i class="fa fa-plus"></i> Nueva Tarea</a>
        
     </div>
    <?php endif;?>  


                   
            </uib-tab>
            
            <uib-tab heading="Desarrollo">
            <?php if(empty($tareas_proceso)== false):?>
                 <!-- INICIA PANEL TAREAS -->  
                  <uib-accordion close-others="!oneAtATime" class="ui-accordion">



            <?php foreach($tareas_proceso as $tareas):?>
         <div uib-accordion-group class="panel-default" is-open=<?='"status.open'.$tareas->id.'"'?>>
                     <uib-accordion-heading>
                     <?=$tareas->nombre?> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php       $entrega = strtotime($tareas->entrega);
                                    $hoy = strtotime(date("Y-m-d"));        
                                    $dias_faltantes = date_diff(new DateTime(date("Y-m-d H:i:s", $hoy)), new DateTime(date("Y-m-d H:i:s", $entrega)));
                                                                    ?>
                         <?php if ($dias_faltantes->days > 20 && $dias_faltantes->invert != 1) :?>
                                           <span class="label label-success">Faltan <?=$dias_faltantes->days?> dias para la entrega </span>
                                    <?php elseif ($dias_faltantes->days > 15 && $dias_faltantes->invert != 1) :?>
                                            <span class="label label-info">Faltan <?=$dias_faltantes->days?> dias para la entrega</span>
                                    <?php elseif ($dias_faltantes->days > 8 && $dias_faltantes->invert != 1) :?>
                                           <span class="label label-warning">Faltan <?=$dias_faltantes->days?> dias para la entrega</span>
                                    <?php elseif ($dias_faltantes->days > 1 && $dias_faltantes->invert != 1) :?>
                                           <span class="label label-danger">Faltan <?=$dias_faltantes->days?> dias para la entrega</span>
                                    <?php elseif ($dias_faltantes->days = 1 && $dias_faltantes->invert != 1) :?>
                                           <span class="label label-danger">Falta <?=$dias_faltantes->days?> dia para la entrega</span>
                                    <?php elseif ($dias_faltantes->days = 0 && $dias_faltantes->invert != 1) :?>
                                           <span class="label label-default">Dia de Entrega</span>
                                    <?php else:?>
                                           <span class="label label-danger">Han Pasado <?=$dias_faltantes->days?> dias de la entrega</span>
                                    <?php endif;?> 

                        <i class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': <?='status.open'.$tareas->id?>, 'glyphicon-chevron-right': <?='!status.open'.$tareas->id?>}"></i>
                     </uib-accordion-heading>


                <div class="row">
                    <div class="col-md-6">                           
                          
                        <h4>Información </h4>
                            <div>
                                <strong>Creado: </strong><label><?=$tareas->created?></label>
                            </div>     
                            <div>
                                 <strong>Creado por: </strong><label><?=$tareas->created_by?> <i class="fa fa-user"></i></label>                    
                            </div>
                            <div>
                                 <strong>Iniciado: </strong><label><?=$tareas->started?></label>                    
                            </div>
                            <div>
                                <strong>Asignado a: </strong><label><?=$tareas->asignado?> <i class="fa fa-user"></i></label>                     
                            </div>
                            <div>
                                 <strong>Tipo: </strong>
                                 <?php if ($tareas->tipo == 0) :?>
                                           <span class="label label-success">Mejora</span>
                                    <?php elseif ($tareas->tipo == 1) :?>
                                            <span class="label label-info">Tarea</span>
                                    <?php elseif ($tareas->tipo == 2) :?>
                                           <span class="label label-warning">Nueva Funcion</span>
                                    <?php else:?>
                                            <span class="label label-danger">Error</span>
                                    <?php endif;?>                   
                      
                                <strong>Prioridad:</strong>
                                    <?php if ($tareas->prioridad == 0) :?>
                                           <span class="label label-success">Bajo</span>
                                    <?php elseif ($tareas->prioridad == 1) :?>
                                            <span class="label label-info">Medio</span>
                                    <?php elseif ($tareas->prioridad == 2) :?>
                                           <span class="label label-warning">Alto</span>
                                    <?php else:?>
                                            <span class="label label-danger">Urgente</span>
                                    <?php endif;?>
               
                            </div>
                            <div>
                                <strong>Fecha de Entrega: </strong><label><?=$tareas->entrega?></label> 
                                                  
                            </div>                       
                    </div>

                    <div class="col-md-6">                              
                        
                        <div class="form-group" >
                        <label>Descripcion</label>
                            <textarea class="form-control" rows="5" disabled><?=$tareas->description?></textarea>
                        </div>
               
                            <a href="<?=base_url('admin/proyectos/edit_task/'.$tareas->id)?>" uib-tooltip="Editar Tarea"  class="btn-icon btn-icon-sm btn-primary ui-wave"><i class="fa fa-edit"></i></a>
                            <a href="<?=base_url('admin/proyectos/finish_task/'.$tareas->id)?>" uib-tooltip="Terminar Tarea" class="btn-icon btn-icon-sm btn-success  ui-wave"><i class="fa fa-check"></i></a>
                    </div>
                </div> 
              </div>
                <?php endforeach;?>
                        
        </uib-accordion>
     <?php else:?>
        <div class="alert alert-info text-center">
            <?=lang('tarea:not_found_proceso');?>
        </div>
    <?php endif;?>  


            <!-- FIN PANEL TAREAS --> 


            </uib-tab>

            <uib-tab heading="Finalizados">
                  <?php if(empty($tareas_finalizadas)== false):?>
                 <!-- INICIA PANEL TAREAS -->  
                  <uib-accordion close-others="!oneAtATime" class="ui-accordion">

                  <?php foreach($tareas_finalizadas as $tareas):?>
            <div uib-accordion-group class="panel-default" is-open=<?='"status.open'.$tareas->id.'"'?>>
                     <uib-accordion-heading> <?=$tareas->nombre?> &nbsp;&nbsp;&nbsp;&nbsp;
                         <span class="label label-success">Finalizado <?=$tareas->finalized?>  </span>
                          <i class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': <?='status.open'.$tareas->id?>, 'glyphicon-chevron-right': <?='!status.open'.$tareas->id?>}"></i>
                     </uib-accordion-heading>

                <div class="row">
                    <div class="col-md-6">        
                        <h4>Información </h4>
                            <div>
                                <strong>Creado: </strong><label><?=$tareas->created?></label>
                            </div>     
                            <div>
                                 <strong>Creado por: </strong><label><?=$tareas->created_by?> <i class="fa fa-user"></i></label>                    
                            </div>
                            <div>
                                 <strong>Iniciado: </strong><label><?=$tareas->started?></label>                    
                            </div>
                            <div>
                                <strong>Asignado a: </strong><label><?=$tareas->asignado?> <i class="fa fa-user"></i></label>                     
                            </div>
                            <div>
                                 <strong>Tipo: </strong>
                                 <?php if ($tareas->tipo == 0) :?>
                                           <span class="label label-success">Mejora</span>
                                    <?php elseif ($tareas->tipo == 1) :?>
                                            <span class="label label-info">Tarea</span>
                                    <?php elseif ($tareas->tipo == 2) :?>
                                           <span class="label label-warning">Nueva Funcion</span>
                                    <?php else:?>
                                            <span class="label label-danger">Error</span>
                                    <?php endif;?>                                    
                                <strong>Prioridad:</strong>
                                    <?php if ($tareas->prioridad == 0) :?>
                                           <span class="label label-success">Bajo</span>
                                    <?php elseif ($tareas->prioridad == 1) :?>
                                            <span class="label label-info">Medio</span>
                                    <?php elseif ($tareas->prioridad == 2) :?>
                                           <span class="label label-warning">Alto</span>
                                    <?php else:?>
                                            <span class="label label-danger">Urgente</span>
                                    <?php endif;?>               
                            </div>
                            <div>
                                <strong>Fecha de Entrega: </strong><label><?=$tareas->entrega?></label>                                                   
                            </div>                         
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" >
                            <label>Descripcion</label>
                            <textarea class="form-control" rows="5" disabled><?=$tareas->description?></textarea>
                        </div>               
                            <a href="<?=base_url('admin/proyectos/edit_task/'.$tareas->id)?>" uib-tooltip="Editar Tarea"  class="btn-icon btn-icon-sm btn-primary ui-wave"><i class="fa fa-edit"></i></a>  
                            <a href="<?=base_url('admin/proyectos/restart_task/'.$tareas->id)?>" uib-tooltip="Reiniciar Tarea"  class="btn-icon btn-icon-sm btn-default ui-wave"><i class="fa fa-undo"></i></a>                        
                    </div>

                </div>  
       

         </div>
                <?php endforeach;?>
                        
        </uib-accordion>  
           <!-- FIN PANEL TAREAS -->                 
             <?php else:?>
                <div class="alert alert-info text-center">
                    <?=lang('tarea:not_found_finalizado');?>
                </div>
            <?php endif;?>  

            </uib-tab>

        </uib-tabset>
        
   
    </div>

</section>

<script type="text/ng-template" id="modal_plan.html">
    <div class="modal-header">
            <h3>Detalles</h3>
    </div>
    <div class="modal-body">
       <?php echo form_open(null,'name="myForm"')?>
        <div class="form-group">
            <label>Nombre</label> 
            <input type="text" class="form-control" ng-model="form.nombre" disabled/>
        </div>
        <div class="row">

            <div class="col-md-6">
            <div class="form-group">
            <label>Tipo:</label>

            <?=form_dropdown('tipo',array(''=>' [ Elegir ]','0'=>'<i class="fas fa-arrow-circle-up"></i> Mejora','1'=>'<i class="glyphicon glyphicon-link "></i>Tarea','2'=>'Nueva Funcion','3'=>'Error'),null,'class="form-control" ng-model="form.tipo" disabled')?>

            </div>


            <div class="form-group">
            <label>Asignado a:</label>

            <select name="select" class="form-control" ng-model="form.asignado" disabled>
                <option value="">Sin Asignar</option> 

                <<?php foreach ($users as $user): ?>
                <option value="<?=$user->username?>"><?=$user->display_name?></option> 
                    
                <?php endforeach ?>>
              

            </select>


        </div>


             </div> 
        <div class="col-md-6">

             <div class="form-group">
                <label>Prioridad:</label>
                 <?=form_dropdown('tipo',array(''=>' [ Elegir ]','0'=>'Bajo','1'=>'Medio','2'=>'Alto','3'=>'Urgente'),null,'class="form-control" ng-model="form.prioridad" disabled')?>

             </div>

             <div class="form-group">
                            <label>Fecha de Entrega </label>
                            <input type="text" class="form-control" ng-model="form.entrega" disabled/>
             </div> 


        </div> 


        </div>


           
        <div class="form-group" >
            <label>Descripcion</label>
            <textarea class="form-control" rows="5" id="description" ng-model="form.description" disabled></textarea>
        </div>
    
       <?php echo form_close();?>  
    </div>
    <div class="modal-footer">
            <button ui-wave class="btn btn-flat btn-primary" ng-click="close()" >Cerrar</button>
    </div>
</script>

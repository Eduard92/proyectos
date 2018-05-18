<div class="row">
    <?php if(empty($proyectos)==false):?>
     <div class="col-lg-12">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Clave</th>
                <th>Tipo</th>
                <th>Propietario</th>
                <th>Repositorio</th>
                <th width="15%"></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($proyectos as $proyecto):?>
            <tr>
                <td>
                    <a href="<?=base_url('admin/proyectos/'.$proyecto->id)?>"><span><?=$proyecto->nombre?></span></a>
                </td>
                <td><?=$proyecto->clave?></td>
                <td><?=($proyecto->tipo=1)?'<i class="zmdi zmdi-code"></i> <label> Software</label>':'Indefinido'?></td>
                <td><?=$proyecto->usuario?></td>
                <td>
                    <i class="glyphicon glyphicon-link "></i>

                     <a href="<?=($proyecto->repository)?>"><span>Ver</span></a>
                </td>

                <td>
                        <?php echo anchor('admin/proyectos/delete/'.$proyecto->id, lang('buttons:delete'), 'class="button" confirm-action') ?> |
                        <?php echo anchor('admin/proyectos/edit/'.$proyecto->id, lang('buttons:edit'), 'class="button edit"') ?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    </div> 

        <div class="col-md-6">
            <div class="panel panel-info">
              <div class="panel-heading">Mis Tareas</div>
              <div class="panel-body">
                <?php if(empty($tareas_asignadas)==false):?>
                    <div class="list-group">
                        <?php foreach($tareas_asignadas as $tareas):?>
                        <?php if($tareas->estado != 2):?>
                          <a href="<?='proyectos/'.$tareas->id_proyecto?>" class="list-group-item"><?=$tareas->nombre?><span class="badge">
                            <?php if($tareas->estado==1){echo ('Sin Iniciar');}else{echo('En Desarollo');}?></span></a>
                        <?php endif;?>

                      <?php endforeach;?> 
                    </div>
                <?php else:?> 
                <div class="alert alert-success text-center">
                   <?=lang('tareas:not_found');?>
                 </div>  
              <?php endif;?>
             </div>

            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-danger">
              <div class="panel-heading">Proximos a entregar</div>
              <div class="panel-body">
                <?php if(empty($tareas_asignadas)==false):?>
                    <div class="list-group">
                        <?php foreach($tareas_asignadas as $tareas):?>
                        <?php if($tareas->estado == 1 && $tareas->dias_faltantes < 15):?>
                          <a href="<?='proyectos/'.$tareas->id_proyecto?>" class="list-group-item"><?=$tareas->nombre?><span class="badge"><?=$tareas->dias_faltantes.' dias faltantes'?></span></a>
                           
                        <?php endif;?>

                      <?php endforeach;?> 
                    </div>
                <?php else:?> 
                <div class="alert alert-success text-center">
                   <?=lang('tareas:not_found');?>
                 </div>
              <?php endif;?>

              </div>

            </div>
        </div>
      

    <?php else:?>
        <div class="alert alert-info text-center">
            <?=lang('proyectos:not_found');?>
        </div>
    <?php endif;?>    




</div>
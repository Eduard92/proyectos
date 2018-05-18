<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Groups module
 *
 * @author PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Groups
 */ 
class Module_Proyectos extends Module
{
	public $version = '1.0';

	public function info()
	{
		$info= array(
			'name' => array(
				'en' => 'Support',
				
				'es' => 'Proyectos',
				
			),
			'description' => array(
				'en' => 'Project Task Management.',
				
				'es' => 'Administración de Tareas de un Proyecto',
				
			),
			'frontend' => false,
			'backend' => true,
			'menu' => 'admin',
            'roles' => array(
				'create', 'edit','delete'
			),
            'shortcuts' => array(
        			
                        array(
        					'name' => 'proyectos:create',
        					'uri' => 'admin/proyectos/create',
        					'class' => 'btn btn-success'
        				),
			),
           
        );
        
        return $info;
	}

	public function install()
	{
	    $this->dbforge->drop_table('proyectos');
        $this->dbforge->drop_table('proyecto_tareas');
		$tables = array(
			'proyectos'=>array(
    			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
                
                'nombre' => array('type' => 'VARCHAR','constraint' => 255),
                'clave' => array('type' => 'VARCHAR','constraint' => 255),
                'tipo' => array('type' => 'INT','constraint' => 11),                
                'created' => array('type' => 'DATE',),
                'updated' => array('type' => 'INT','constraint' => 11, 'null' => true),
                'finalized' => array('type' => 'INT','constraint' => 11, 'null' => true),
                'created_by' => array('type' => 'INT','constraint' => 11),
                'updated_by' => array('type' => 'INT','constraint' => 11),
                'description' => array('type' => 'TEXT', 'null' => true),
                'repository' => array('type' => 'VARCHAR','constraint' => 255, 'null' => true),            
            ),

          'proyecto_tareas'=>array(
          	'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true,),
          	'nombre' => array('type' => 'VARCHAR','constraint' => 255),               
            'created' => array('type' => 'DATE'),
            'started' => array('type' => 'DATE','null' => true),
            'finalized' => array('type' => 'DATE','null' => true),
            'id_proyecto' => array('type' => 'INT','constraint' => 11),
            'description' => array('type' => 'VARCHAR','constraint' => 255,'null' => true),
            'asignado' => array('type' => 'VARCHAR','constraint' => 255,'null' => true),
            'tipo' => array('type' => 'INT','constraint' => 11,),
            'created_by' => array('type' => 'VARCHAR','constraint' => 255,),
            'estado' => array('type' => 'INT','constraint' => 11,),
            'prioridad' => array('type' => 'INT','constraint' => 11,),
            'entrega' => array('type' => 'DATE'),
            'updated' => array('type' => 'DATE','null' => true),




          	),
			
		);
        
        if ( ! $this->install_tables($tables))
		{
			return false;
		}

        return true;
        
		

		
	}

	public function uninstall()
	{
	
	    $this->dbforge->drop_table('proyectos');
        $this->dbforge->drop_table('proyecto_tareas');
        $this->dbforge->drop_table('proyecto_tarea_inicidencias');
		return true;
	}

	public function upgrade($old_version)
	{
		return true;
	}
}

?>
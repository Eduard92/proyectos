<?php defined('BASEPATH') or exit('No direct script access allowed');

class Proyecto_m extends MY_Model {

	private $folder;

	public function __construct()
	{
		parent::__construct();
		$this->_table = 'proyectos';
		
	}
	     function create($input,$extra)
    {
    	
        $data = array(                
            'nombre'              => $input['nombre'],
            'clave'               => $input['clave'],
            'tipo'                => $input['tipo']?$input['tipo']:1,
            'created'             => $extra['created'],
            'created_by'          => $extra['author'],
            'description'         => $input['description']?$input['description']:NULL,
            'repository'          => $input['repository']?$input['repository']:NULL,            
        );
        
        
        return $this->insert($data);
        
    }

    function edit($id,$input,$extra)
    {
    
    	$data = array(                
            'nombre'              => $input['nombre'],
            'clave'               => $input['clave'],
            'tipo'                => $input['tipo']?$input['tipo']:1,
            'updated'             => $extra['update'],
            'update_by'          => $extra['author'],
            'description'         => $input['description']?$input['description']:NULL,
            'repository'          => $input['repository']?$input['repository']:NULL,            
        );

        return $this->db->where('id',$id)
                ->set($data)
                ->update($this->_table);

    }

 }

 ?>
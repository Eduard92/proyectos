<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tarea_m extends MY_Model {

	private $folder;

	public function __construct()
	{
		parent::__construct();
		$this->_table = 'proyecto_tareas';
		
	}
	     function create($input,$extra)
    {

        $data = array(                
            'nombre'              => $input['nombre'],            
            'created'             => $extra['created'],
            'id_proyecto'         => $extra['id_proyecto'],
            'description'         => $input['description']?$input['description']:NULL,
            'tipo'                => $input['tipo'],
            'prioridad'           => $input['prioridad'],
            'created_by'          => $extra['author'],
            'entrega'             => $input['entrega']           

        );
        
        
        return $this->insert($data);
        
    }

    function edit($id,$input)
    {
    
    	$data = array(                
            'nombre'              => $input['nombre'],
            'tipo'                => $input['tipo'],
            'asignado'            => $input['asignado'],
            'prioridad'           => $input['prioridad'],
            'entrega'             => $input['entrega'],
            'description'         => $input['description']?$input['description']:NULL,             
            'updated'             => date('Y-m-d', now()),
            
           
        );

        return $this->db->where('id',$id)
                ->set($data)
                ->update($this->_table);

    }

        function get_tarea($id=0)
      {

        $proyecto = $id;
       
        if($proyecto)
        {
            $tareas= $this->db->where('id_proyecto',$id)
                                        ->get('proyecto_tareas')->result();
                                        
           /* foreach($cuestionario->preguntas as &$pregunta)
            {
                $pregunta->opciones = $this->db->where('id_pregunta',$pregunta->id)
                                            ->get('cat_pregunta_opciones')->result();
            }*/
        return $tareas;
         //print_r($tareas);
        }
        return false;
    }

     function get_tarea_where($id,$base_where)
      {

        $proyecto = $id;
       
        if($proyecto)
        {
            $tareas= $this->db->where($base_where)->order_by("prioridad","desc")
                                        ->get('proyecto_tareas')->result();
                                        
           /* foreach($cuestionario->preguntas as &$pregunta)
            {
                $pregunta->opciones = $this->db->where('id_pregunta',$pregunta->id)
                                            ->get('cat_pregunta_opciones')->result();
            }*/
        return $tareas;
         //print_r($tareas);
        }
        return false;
    }

            function get_incidencias($id=0)
      {

        $tarea = $id;
       
        if($tarea)
        {
            $incidencias= $this->db->where('id_tarea',$id)
                                        ->get('proyecto_tarea_incidencias')->result();
                                        
           /* foreach($cuestionario->preguntas as &$pregunta)
            {
                $pregunta->opciones = $this->db->where('id_pregunta',$pregunta->id)
                                            ->get('cat_pregunta_opciones')->result();
            }*/
        return $incidencias;
         //print_r($tareas);
        }
        return false;
    }

        function get_tarea_unique($id,$base_where)
      {

       
        $proyecto = $id;

        if($proyecto)
        {
            $tarea= $this->db->where($base_where)
                                        ->get('proyecto_tareas')->result();

        return $tarea;
        }
        return false;
    }

    function start($id,$extra)
    {
        $data = array(                
                       
            'asignado'       => $extra['asignado'],
            'started'        => $extra['started'],   
            'estado'         => $extra['estado'],

        );

        return $this->db->where('id',$id)
                ->set($data)
                ->update($this->_table);
    }

        function finish($id,$extra)
    {
        $data = array(                
                       
            'finalized'       => $extra['finalizo'],
            'estado'         => $extra['estado'],

        );

        return $this->db->where('id',$id)
                ->set($data)
                ->update($this->_table);
    }

       function restart($id,$extra)
    {
        $data = array(                
                       
            'updated'       => $extra['updated'],
            'estado'         => $extra['estado'],

        );

        return $this->db->where('id',$id)
                ->set($data)
                ->update($this->_table);
    }



 }

 ?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends Admin_Controller {
	protected $section='proyectos';

	public function __construct()
	{
		parent::__construct();

        $this->lang->load(array('proyectos'));
        $this->load->model(array('proyecto_m', 'tarea_m'));
        $this->load->model('users/user_m');
        $this->load->model('groups/group_m');
       /* $this->load->model('files/file_folders_m');

       
         
         $this->config->load('files/files');
         $this->lang->load('files/files');
       
         $this->load->library('files/files');
         $this->_path = FCPATH.rtrim($this->config->item('files:path'), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;*/
         $this->validation_rules = array(
            
             array(
                'field' => 'nombre',
                'label' => 'Nombre',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'clave',
                'label' => 'Clave',
                'rules' => 'trim'
            ), 
            array(
                'field' => 'description',
                'label' => 'Descripcion',
                'rules' => 'trim'
            ),
            array(
                'field' => 'repository',
                'label' => 'Repositorio',
                'rules' => 'trim'
            ),
            array(
                'field' => 'tipo',
                'label' => 'Tipo',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'asignado',
                'label' => 'Asignado',
                'rules' => 'trim'
            ),
            array(
                'field' => 'prioridad',
                'label' => 'Prioridad',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'entrega',
                'label' => 'Entrega',
                'rules' => 'trim|required'
            ),
     
        );

        
    }

    function index()
    {        
    $proyectos = $this->db->select('default_proyectos.id ,nombre,clave,tipo,created,repository,default_users.email AS email, default_users.username AS usuario')
                        ->join('default_users','default_proyectos.created_by = default_users.id','LEFT')
                        ->get('proyectos') ->result();  
    $base_where = array(
                'asignado' => $this->current_user->username,
                'estado !='   =>  2) ;                  

    $tareas_asignadas = $this->db->where($base_where)->order_by("prioridad","desc")
                                        ->get('proyecto_tareas')->result();

    foreach($tareas_asignadas AS &$tareas)
    {
        $entrega = strtotime($tareas->entrega);
        $hoy = strtotime(date("Y-m-d"));        
        $dias_faltantes = date_diff(new DateTime(date("Y-m-d H:i:s", $hoy)), new DateTime(date("Y-m-d H:i:s", $entrega)));

        if ($dias_faltantes->invert != 1)
        $tareas->dias_faltantes = $dias_faltantes->days;
    } 
         
    $this->template->title($this->module_details['name'])
            ->set('tareas_asignadas',$tareas_asignadas)
            ->set('proyectos',$proyectos)
            ->build('admin/init');

    }
    
    function load($id='')
    {    

   

        $base_where = array(
            'group_id' => 1
        );

        $users = $this->user_m->get_many_by($base_where);


        //$tareas = $this->tarea_m->get_tarea($id);
        


                $base_where = array(
                         'estado' => '0',
                          'id_proyecto' => $id  ); 
                    $tareas_pendietes = $this->tarea_m->get_tarea_where($id,$base_where);
                
                $base_where = array(
                         'estado' => '1', 
                         'id_proyecto' => $id  );  

                    $tareas_proceso = $this->tarea_m->get_tarea_where($id,$base_where);                
                $base_where = array(
                         'estado' => '2',
                     'id_proyecto' => $id  ); 
                    $tareas_finalizadas = $this->db->where($base_where)->order_by("finalized","desc")
                                        ->get('proyecto_tareas')->result();
                   



        $this->template
           // ->title($this->module_details['name'])
            ->set('id',$id)
            ->set('users', $users)
            ->set('tareas_pendietes',$tareas_pendietes)
            ->set('tareas_proceso', $tareas_proceso)
            ->set('tareas_finalizadas', $tareas_finalizadas)

            ->append_js('module::proyecto.controller.js')
            ->append_metadata('<script type="text/javascript">var tareas='.($tareas_pendietes?json_encode($tareas_pendietes):'[]').';</script>')        
        //    ->append_metadata('<script type="text/javascript">var id_proyecto='.$id.';</script>')
            
            //->append_metadata('<script type="text/javascript">var incidencias='.($cuestionario->incidencias?json_encode($cuestionario->incidencias):'[]').';</script>')

            ->build('admin/index');


    }


    
    function create()
    {
        role_or_die($this->section, 'create');
        $proyecto = new StdClass();

                     

        $this->form_validation->set_rules($this->validation_rules);
        
        if ($this->form_validation->run())
        {
            $extra = array(
                
                'author'           => $this->current_user->username,
                'created'          => date('Y-m-d H:i:s', now())
            );

             unset($_POST['btnAction']);

            if($this->proyecto_m->create($this->input->post(), $extra))
            {
                
                $this->session->set_flashdata('success',sprintf(lang('proyectos:save_success'),$this->input->post('proyecto')));
                
            }
            else
            {
                $this->session->set_flashdata('error',lang('global:save_error'));
                
            }
            redirect('admin/proyectos');
        }
        
        foreach ($this->validation_rules as $key => $field)
        {
                $proyecto->$field['field'] = set_value($field['field']);
        }
        
        $this->template
                ->set('proyecto',$proyecto)
                ->build('admin/form');
    }
    function edit($id=0)
    {
      $proyecto = $this->proyecto_m->get($id) OR redirect('admin/proyectos');
        
        
        
        $this->form_validation->set_rules($this->validation_rules);
        
        if ($this->form_validation->run())
        {
            $extra = array(
                
                'author'           => $this->current_user->username,
                'update'          => date('Y-m-d H:i:s', now())
            );
             unset($_POST['btnAction']);
             
            if($this->proyecto_m->edit($id,$this->input->post(),$extra))
            {
                
                $this->session->set_flashdata('success',sprintf(lang('proyectos:save_success'),$this->input->post('proyecto')));
                
            }
            else
            {
                $this->session->set_flashdata('error',lang('global:save_error'));
                
            }
            redirect('admin/proyectos/edit/'.$id);
        }

        $this->template
                ->set('proyecto',$proyecto)
                ->build('admin/form');   

    }

    function delete($id=0)
    {
        role_or_die('proyectos', 'delete');
        if ($success = $this->proyecto_m->delete($id))
        {
            // Fire an event. A group has been deleted.
            //Events::trigger('group_deleted', $id);

            $this->session->set_flashdata('success', lang('global:delete_success'));
        }
        else
        {
            $this->session->set_flashdata('error', lang('global:delete_error'));
        }

        redirect('admin/proyectos');
    }
/* TAREAS*/
    function create_task($id=0)
    {
        $tarea = new StdClass();

        $proyecto = $this->proyecto_m->get($id) ;
        if(!$proyecto)
        {
            
            $this->session->set_flashdata('error',lang('global:not_found_edit'));
            
            redirect('admin/proyectos');
        }


        $users = $this->db->select('*')->where('group_id',1)
                                        ->get('users')->result();
        $extra = array(
               'author'           => $this->current_user->username,
               'created'          => date('Y-m-d', now()),
               'id_proyecto'      => $id,

            );


        $this->form_validation->set_rules($this->validation_rules);


        if ($this->form_validation->run())
        {
             unset($_POST['btnAction']);

            $input =  $this->input->post();

            $base_where = array(
            'nombre' => $input['nombre'], 
            'id_proyecto' => $id);

            $tareas = $this->tarea_m->get_tarea_unique($id,$base_where);

            if(empty($tareas)==false)
            {
                 $this->session->set_flashdata('error',lang('tarea:duplique'));
                 redirect('admin/proyectos/create_task'); 
            }

            if($this->tarea_m->create($input,$extra))
            {
                
                $this->session->set_flashdata('success',sprintf(lang('proyecto:save_success'),$this->input->post('tarea')));
                
            }
            else
            {
                $this->session->set_flashdata('error',lang('global:save_error'));
                
            }
            redirect('admin/proyectos/'.$id);
        }
                foreach ($this->validation_rules as $key => $field)
        {
                $tarea->$field['field'] = set_value($field['field']);
        }
        

                $this->template
               // ->append_js('module::proyecto.controller.js')
                ->set('id',$id)
                ->set('users',array_for_select($users,'username','username'))
                ->set('tarea',$tarea)
                ->build('admin/form_tarea');



    }
    function delete_task($id=0,$id_tarea)
    {
        $base_where = array('id' => $id_tarea, );

        if($id)
        {
                        
        $this->db->where($base_where)->delete('proyecto_tareas');
          
        $this->session->set_flashdata('success',lang('tarea:delete_success'));

        }
        else
        {
            $this->session->set_flashdata('error',lang('global:delete_error'));
        }
                   redirect('admin/proyectos/'.$id); 

 
   

    }

    function start_task($id_proyecto=0, $id)
    {
           
        if($id)
        {
                        
            $extra = array(
               'asignado'           => $this->current_user->username,
               'started'             => date('Y-m-d', now()),
               'estado'             => 1,

            );

            if($this->tarea_m->start($id,$extra))
            {    
                redirect('admin/proyectos/'.$id_proyecto); 


             }
        }
    }

        function edit_task($id=0)
    {
 
        $base_where = array(
            'group_id' => 1
        );

        $users = $this->db->select('*')->where('group_id',1)
                                        ->get('users')->result();

        $tarea = $this->tarea_m
                      ->get_by('id',$id) OR redirect('admin/proyectos');

    $this->form_validation->set_rules($this->validation_rules);
        
        if ($this->form_validation->run())
        {
            
            if($this->tarea_m->edit($id,$this->input->post()))
            {
                
                $this->session->set_flashdata('success',sprintf(lang('tarea:edit_success'),$this->input->post('tarea')));
                
            }
            else
            {
                $this->session->set_flashdata('error',lang('global:edit_error'));
                
            }
            redirect('admin/proyectos/'.$tarea->id_proyecto);
        }
        if($_POST)
        {
            $vehiculo = (Object)$_POST;
        }

                $this->template
                //->append_js('module::proyecto.controller.js')
                ->set('id',$tarea->id_proyecto)
                ->set('users',array_for_select($users,'username','username'))
                ->set('tarea',$tarea)
                ->build('admin/form_tarea');  
           

    }
   
    function finish_task($id=0)
    {
         if($id)
        {
             $tarea = $this->tarea_m->get_by('id',$id);
             $id_proyecto = $tarea->id_proyecto;
                        
            $extra = array(
               'finalizo'             => date('Y-m-d', now()),
               'estado'             => 2,

            );

            if($this->tarea_m->finish($id,$extra))
            {    
                redirect('admin/proyectos/'.$id_proyecto); 


             }
        }

           

    }
        function restart_task($id=0)
    {
         if($id)
        {
             $tarea = $this->tarea_m->get_by('id',$id);
             $id_proyecto = $tarea->id_proyecto;
                        
            $extra = array(
               'updated'             => date('Y-m-d', now()),
               'estado'             => 0,

            );

            if($this->tarea_m->restart($id,$extra))
            {    
                redirect('admin/proyectos/'.$id_proyecto); 


             }
        }

           

    }

/*
    function upload()
    {
        $result = array(
        
            'status'  => true,
            'message' => '',
            'data'    => false
        );
        $input = $this->input->post();
        
        $folder = $this->file_folders_m->get_by_path('proyectos');
        if(!$folder)
        {       Files::create_folder( 0, 'Proyectos', 'local');
                $folder = $this->file_folders_m->get_by_path('proyectos');
        }
        
        if($folder)
        {
            $result = Files::upload($folder->id,$input['name'],'file');
            
            if($result['status'])
            {
                $data = array(
                    'id_apoyo' => $input['id'],
                    
                    
                );
                
                 $result['data']['id'];
               
                
                
                
            }
            
        }
        else
        {
            $result['message'] = lang('files:no_folders_wysiwyg');
            $result['status']  = false;
        }
        
        echo  json_encode($result);
        exit();
    }*/


   

       
 
}

 ?>
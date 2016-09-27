<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
| Every controller should load the views in the following format:
| 
| 1. load the HEAD
| 2. load the intended content of the controller
| 3. load the foot
| Example:
| $this->load->view('templates/head'[,args]);
| $this->load->view('content_folder/CONTENT'[,args]);
| $this->load->view('templates/foot'[,args]);
*/
class Form extends CI_Controller {


    /*
    | The contructor is were I load the libraries needed.
    */
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }


    public function index()
    {
        $config_reglas = $this->establecer_reglas();
        $this->form_validation->set_rules($config_reglas);

        if ($this->form_validation->run() == FALSE) // If rules fails the form is refreshed with the error messages poping
        {
        	$this->load->view('templates/head'); // For code maintenance porpuse, head and foot are setup in different files
            $this->load->view('login/myform');
            $this->load->view('templates/foot'); // For code maintenance porpuse, head and foot are setup in different files
        }
        else // If rules aply, then it was a success.
        {
            $campos = $this->obtener_campos(); // Getting the form values
            $campos = $this->renombrar_archivos($campos); // Setting the file names (This will not modify the FILE object its just a string made of).

            $this->load->model('login'); // Loading the model to insert into the DB.
            $this->login->form_insert($campos); // Inserting

            $campos['sello_cer_upload'] = $this->reglas_archivos('sello_cer', $campos['sello_cer']);
            $campos['sello_key_upload'] = $this->reglas_archivos('sello_key', $campos['sello_key']);

        	$this->load->view('templates/head');
    		$this->load->view('login/formsuccess', $campos);
    		$this->load->view('templates/foot');
        }
    }


    /*
    | To catch the file submited from the user
    */
    private function reglas_archivos($campo_archivo, $nombre_archivo) {

        $config['file_name']        = $nombre_archivo;
        $config['upload_path']      = '.\sellos\\';
        $config['allowed_types']    = 'cer|key';
        $config['overwrite' ]       = TRUE; // overwrite TRUE since reloading the form_success will upload the files again.

        $this->load->library('upload'); // Loading the 'upload' Library, loaded here for testing porpuses, uploading several files by calling this function.
        $this->upload->initialize($config); // Load the configuration array.

        $resultado = $this->upload->do_upload($campo_archivo); // Here we actually load the file, for some reason it wont upload files after the first file uploaded.

        return array( // Return the array containing the status data of the do_upload()
            'upload_data'   => $this->upload->data(), // The status data of the do_upload()
            'resultado'     => $resultado // The result itselft (bool) for the sake of debuging, delete before release.
            );
    }


    /*
    | Simple function to rename the files
    */
    private function renombrar_archivos($campos) {
        $campos['sello_cer'] = $campos['RFC'] . '_' . $campos['usuario'] . '.cer';
        $campos['sello_key'] = $campos['RFC'] . '_' . $campos['usuario'] . '.key';
        return $campos;
    }


    /*
    | Just the array of rules, in a different function for code maintenance.
    */
    private function establecer_reglas() {
        return $config = array(
            array(
                'field' => 'nombre',
                'label' => 'Nombre',
                'rules' => 'required|alpha',
                'errors' => array(
                        'required' => 'El campo %s es requerido.',
                        'alpha' => 'El campo %s debe contener solo caracteres [a-zA-Z]',
                    ),
            ),
            array(
                'field' => 'apellido_paterno',
                'label' => 'Apellido paterno',
                'rules' => 'required|alpha',
                'errors' => array(
                        'required' => 'El campo %s es requerido.',
                        'alpha' => 'El campo %s debe contener solo caracteres [a-zA-Z]',
                    ),
            ),
            array(
                'field' => 'apellido_materno',
                'label' => 'Apellido materno',
                'rules' => 'required|alpha',
                'errors' => array(
                        'required' => 'El campo %s es requerido.',
                        'alpha' => 'El campo %s debe contener solo caracteres [a-zA-Z]',
                    ),
            ),
            array(
                'field' => 'usuario',
                'label' => 'Usuario',
                'rules' => 'required|min_length[4]|max_length[16]',
                'errors' => array(
                        'required' => 'El campo %s es requerido.',
                        'min_length' => 'El campo %s debe contener 4 caracteres como minimo.',
                        'max_length' => 'El campo %s debe contener 16 caracteres como maximo.',
                    ),
            ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => array(
                        'required' => 'El campo %s es requerido.',
                        'valid_email' => ' El campo %s no es valido.'
                    ),
            ),
            array(
                'field' => 'emailconf',
                'label' => 'Confirmacion de Email',
                'rules' => 'required|valid_email|matches[email]',
                'errors' => array(
                        'required' => 'El campo %s es requerido.',
                        'valid_email' => 'El campo %s no es valido.',
                        'matches' => 'El campo %s debe coincidir con Email.'
                    ),
            ),
            array(
                'field' => 'password',
                'label' => 'Contraseña del Certificado',
                'rules' => 'required',
                'errors' => 'El campo %s es requerido'
            ),
            array(
                'field' => 'RFC',
                'label' => 'RFC',
                'rules' => 'required',
                'errors' => 'El campo %s es requerido'
            )
        );
    }


    /*
    | To get the POST values of the form
    */
    private function obtener_campos() {
        return array(
                'nombre' => $_POST['nombre'],
                'apellido_paterno' => $_POST['apellido_paterno'],
                'apellido_materno' => $_POST['apellido_materno'],
                'usuario' => $_POST['usuario'],
                'email' => $_POST['email'],
                'sello_cer' => '',
                'sello_key' => '',
                'password' => $_POST['password'],
                'RFC' => $_POST['RFC'],
            );
    }


    /*
    | username_test
    | This method is intended to do some checks on user name.
    | Like if the user is already being used checking against the DB
    | or if there are any set of reserved words or dictionary that
    | the user should not use a his username.
    */
    private function username_check($str)
    {
        // In example, the word 'test' cannot be used as the username.
        if ($str == 'test')
        {
            $this->form_validation->set_message('username_check', 'The {field} field can not be the word "test"');
            return FALSE;
        }
        else
        {
            // UNDER CONSTRUCTION
            return TRUE;
        }
    }

}



/*
            array(
                'field' => 'sello_cer',
                'label' => 'Archivo *.CER',
                'rules' => 'required',
                'errors' => 'El campo %s es requerido'
            ),
            array(
                'field' => 'sello_key',
                'label' => 'Archivo *.KEY',
                'rules' => 'required',
                'errors' => 'El campo %s es requerido'
            ),
*/
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Empresa extends CI_Controller {

    function __construct() {
        parent::__construct();
        // Ignorar los abortos hechos por el usuario y permitir que el script
        // se ejecute para siempre, evita que se detenga el proceso por cerrar el navegador
        ignore_user_abort(true);
    }

    public function get_company_report() {
        $this->load->model('company_model');
        $obj_company_model = new Company_model();
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $filter = json_decode($this->input->get('filter'));
        $order_by = array($sort => $order);
        $res = $obj_company_model->get_company_data($limit, $offset, $filter, $order_by);
        $total = $obj_company_model->get_company_count($filter);
        echo '{"total": ' . $total . ', "rows":' . json_encode($res) . '}';
    }

    /* Llamada al formulario 
     * enlace de llamada:
     * <a id="call-php" href="#" data-target="messagesout" php-function="common/index/viewScreen/module/controller/open_ml_empresa">Nuevo</a>
     */
    function open_ml_empresa($id = 0) {
        $res['id'] = $id;
        $this->load->view("ml_company", $res);
    }

    /**
     * Subir imagen del logo de la empresa
     * @param type $company_id
     */
    private function _change_logo($company_id) {
        foreach ($_FILES as $key => $value) {
            if ($key == 'logo') {
                if (!empty($value['tmp_name'])) {
                    $logo_path = './uploads/' . $this->user->company_id . '/logo/';
                    makedirs($logo_path, $mode = 0755);

                    echo 'cargando logo en: ' . $logo_path;
                    $config['upload_path'] = $logo_path;
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '2000';
                    $config['max_width'] = '2000';
                    $config['max_height'] = '768';

                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload($key)) {
                        toast($this->upload->display_errors(), lang('ml_error'));
                    } else {
                        $upl_data = $this->upload->data();
                        $ml_company = new \gestcobra\company_model($company_id);
                        $ml_company->logo = $upl_data['file_name'];
                        $ml_company->save();
                    }
                }
            }
        }
    }

    function save() {
        $companyid = 0;
        $company = (new gestcobra\company_model())
                ->order_by('id','desc')
                ->limit('1')->find_one();
        
        $id = set_post_value('id');
        $ml_company = new \gestcobra\company_model($id);
        
        $companyid = $company->id;
        
        $this->db->trans_begin();

        $ml_company->nombre_comercial = set_post_value('nombre_comercial');
        $ml_company->direccion = set_post_value('direccion');
        $ml_company->email = set_post_value('email')."_".($companyid+1);
        $ml_company->telefono = set_post_value('telefono');
        $ml_company->curr_date = date('Y-m-d', time());

        if (!$ml_company->is_valid()) {
            $errors = $ml_company->validate();
            $str_errors = arraytostr($errors);
            errorAlert($str_errors[2], lang('ml_error'));
            $this->db->trans_rollback();
            exit(0);
        } else {
            $ml_company->save();
            $this->_change_logo($ml_company->id);

            /**
             * Si es el caso que se esta creando una nueva compania se
             * crea los datos de configuracion inicial
             */
            if ($id == 0) {
                /**
                 * Se crea la oficina Matriz, en el caso que se este creando una nueva
                 * se evita este paso cuando es actualizacion de datos
                 */
                $oficina = new gestcobra\oficina_company_model();
                $oficina->company_id = $ml_company->id;
                $oficina->direccion = set_post_value('direccion');
                $oficina->name = set_post_value('direccion');
                $oficina->save();

                /**
                 * Se crea el usuario principal solamente cuando se crea la empresa,
                 * no al momento de modificar
                 */
                $new_user = $this->_create_user($ml_company->id, $oficina->id);
                if (!$new_user) {
                    exit();
                }
                /**
                 * Se establece sesion en la nueva empresa creada
                 */
                $this->switch_company($ml_company->id);

                /**
                 * Ejecutar scripts con informacion inicial de la nueva empresa
                 */
//                                    $this->_exec_company_transaction('./assets/setup/new_company_setup.sql', $ml_company->id);                            
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            errorAlert(lang('ml_error_msg'), lang('ml_error'));
        } else {
            $this->db->trans_commit();

            successAlert(lang('ml_success_msg'), lang('ml_success'));
        }
    }

    /**
     * Activar o desactivar usuarios de la emrpesa, dependiendo 
     * del estado en que se encuentre la compania
     * @param type $company_status_id
     */
    

    
    /**
     * Se crea un usuario con todos los privilegios disponibles para la nueva empresa
     * @param type $param
     */
    private function _create_user($company_id, $oficina_id) {
        $email = set_post_value('email');
        $user = (new \gestcobra\oficial_credito_model())->where('company_id', $company_id)->where('email', $email)->find_one();

        /**
         * es_pasaporte = 0 , ya que es el ruc de la empresa, el mismo que siempre
         * se valida que sea correcto
         */
        $user->firstname = set_post_value('nombre_comercial');
        $user->lastname = '';
        $user->email = set_post_value('email');
        $user->telefono = set_post_value('telefono', '');
        $user->company_id = $company_id;
        $user->oficina_company_id = $oficina_id;
        $user->role_id = 3;

        $encryptedPass = $this->encrypt_password_callback(set_post_value('email'));
        $user->password = $encryptedPass;

        if (!$user->is_valid()) {
            $errors = $user->validate();
            $str_errors = arraytostr($errors);
            errorAlert($str_errors[2], lang('ml_error'));
            $this->db->trans_rollback();
            return false;
        } else {
            $user->save();
            return true;
        }
    }

    function encrypt_password_callback($clave) {
        $pass_word = (new gestcobra\setup_model())->where('variable', 'PASSWORDSALTMAIN')->find_one()->valor;
        $encryptedPass = MD5($clave . $pass_word);
        return $encryptedPass;
    }

    /**
     * Se busca la palabra company_id en el archivos sql y se reemplaza por el 
     * numero que corresponde a la compania creada
     * @param type $file_path
     * @param type $company_id
     */
   
    /**
     * Se establece la sesion a la compania seleccionada, para poder trabajar
     * creando usuarios y en otras situaciones
     * @param type $company_id
     */
    public function switch_company($company_id) {
        $this->session->set_userdata('company_id', $company_id);
        $ml_company = new gestcobra\company_model($company_id);
        $new_company_label = "<img width='34' height='34' src='" . base_url('uploads/' . $ml_company->id . '/logo/' . $ml_company->logo) . "' /> <strong class='text-danger'>" . $ml_company->nombre_comercial . "</strong>";
        echo '<script>$("#company_label").html("' . $new_company_label . '");</script>';
        toast('Empresa Establecida Correctamente!');
    }

}

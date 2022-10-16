<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * SAG ORM (objet relationnel mapping)
 * @author Yoann VANITOU
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link https://github.com/maltyxx/orm
 */
class Orm_association extends Orm {

    const TYPE_HAS_ONE = 'has_one';
    const TYPE_HAS_MANY = 'has_many';
    const TYPE_BELONGS_TO = 'belongs_to';

    public $association_key;
    public $type;
    public $model;
    public $primary_key;
    public $foreign_key;
    public $value;

    public function __construct(array $config, Orm_model $model) {
        foreach ($config as $config_key => $config_value) {
            $this->{$config_key} = $config_value;
        }

        if (empty($this->model)) {
            $this->model = '\\'.$model->get_namespace().'\\'.$this->association_key.'_model';
        } else {
            $this->model = '\\'.$model->get_namespace().'\\'.$this->model;
        }
        
        if (empty($this->primary_key))
            $this->primary_key = 'id';

        if (empty($this->foreign_key))
            $this->foreign_key = $this->association_key.'_id';
        
        $this->value = (int) (self::TYPE_HAS_MANY !== $this->type) ? $model->{$this->foreign_key} : $model->{$this->primary_key};
    }

    public function associated() {
        return new $this->model($this);
    }

}

/* End of file Orm_association.php */
/* Location: ./application/libraries/Orm_association.php */

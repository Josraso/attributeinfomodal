<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class AttributeInfoModal extends Module
{
    public function __construct()
    {
        $this->name = 'attributeinfomodal';
        $this->tab = 'front_office_features';
        $this->version = '1.1.0';
        $this->author = 'OpenAI';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Attribute Info Modal');
        $this->description = $this->l('Adds info icon with modal to selected attributes.');
    }

    public function install()
    {
        return parent::install()
            && $this->registerHook('displayProductVariants')
            && $this->registerHook('displayHeader')
            && $this->createTables();
    }

    public function uninstall()
    {
        return parent::uninstall() && $this->removeTables();
    }

    protected function createTables()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."attribute_info` (
            `id_attribute_group` INT(11) NOT NULL,
            `info` TEXT NOT NULL,
            PRIMARY KEY (`id_attribute_group`)
        ) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8;";
        return Db::getInstance()->execute($sql);
    }

    protected function removeTables()
    {
        return Db::getInstance()->execute("DROP TABLE IF EXISTS `"._DB_PREFIX_."attribute_info`");
    }

    public function getContent()
    {
        $output = '';
        if (Tools::isSubmit('submit_attribute_info')) {
            $id_group = (int)Tools::getValue('id_attribute_group');
            $info = Tools::getValue('info');
            Db::getInstance()->execute("REPLACE INTO `"._DB_PREFIX_."attribute_info` (`id_attribute_group`, `info`) VALUES ($id_group, '".pSQL($info, true)."')");
            $output .= $this->displayConfirmation($this->l('Settings updated'));
        }

        $attributes = AttributeGroup::getAttributesGroups($this->context->language->id);
        $selected_id = Tools::getValue('id_attribute_group', 0);
        $saved_info = '';
        if ($selected_id) {
            $saved_info = Db::getInstance()->getValue("SELECT info FROM `"._DB_PREFIX_."attribute_info` WHERE id_attribute_group = $selected_id");
        }

        $this->context->smarty->assign([
            'attributes' => $attributes,
            'saved_info' => $saved_info,
            'selected_id' => $selected_id
        ]);
        return $output.$this->display(__FILE__, 'views/templates/admin/configure.tpl');
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addJS($this->_path.'views/js/attributeinfomodal.js');
    }

    public function hookDisplayProductVariants($params)
    {
        $id_product = (int)Tools::getValue('id_product');
        $product = new Product($id_product);
$attribute_groups = $product->getAttributesGroups($this->context->language->id);

        $infos = Db::getInstance()->executeS("SELECT * FROM `"._DB_PREFIX_."attribute_info`");
        $info_map = [];
        foreach ($infos as $info) {
            $info_map[(int)$info['id_attribute_group']] = $info['info'];
        }

        $this->context->smarty->assign([
            'attribute_infos' => $info_map,
        ]);

        return $this->display(__FILE__, 'views/templates/hook/attribute_info.tpl');
    }
}
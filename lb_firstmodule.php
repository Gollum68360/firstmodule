<?php



// Non du dossier, nom du fichier, nom de la classe doit être exactement le même

class Lb_FirstModule extends Module
{

    public function __construct()
    {

        $this->displayName = "Mon premier module"; // nom publique visible par le marchand
        $this->name = "lb_firstmodule";
        $this->version = "1.0";
        $this->author = "Lucien";
        $this->description = "Création de mon premier module";
        $this->bootstrap = true;

        parent::__construct();
    }

    //ajoute le bouton configurer
    public function getContent()
    {

        if (Tools::isSubmit("submit_lb_firstmodule")) { //vérifie si formulaire envoyé avec la name de mon bouton

            // Tools::dieObject('test');  permet d'arrêter l'execution de la page et d'afficher une variable comme dd symfony

            $message = Tools::getValue('MON_PREMIER_CHAMP'); //getValue permet de récupérer des données envoyé en post ou get
            //updateValue à 2 paramètres : le nom de mon champ et la valeur
            Configuration::updateValue('NON_PREMIER_CHAMP', $message); //Inert ou update la table de config en fonction du nom du champ
        }

        return $this->displayForm();
    }

    // génère le formulaire de configuration via helperform
    public function displayForm()
    {

        //déclare au tableau avec les infos du formulaire
        $form_configuration['0']['form'] = [
            'legend' => [
                'title' => $this->l('settings'), //la function l permet de gérer les traductions
            ],
            'input' => [
                [
                    'type' => 'text', // typede champ : text, select, radio, etc...
                    'label' => $this->l('Chap de configuration'),
                    'name' => 'MON_PREMIER_CHAMP',  // convention majuscule
                    'required' => true,
                ],

            ],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-defaults pull-right',
            ]
        ];

        $helper = new HelperForm();

        $helper->module = $this; // instance du module
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules'); //récupère le token de la page module

        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name; //configurer l'atttribut action du formulaire
        $helper->default_form_language = (int)configuration::get('PS_LANG_DEFAULT');
        $helper->title = $this->displayName;
        $helper->submit_action = "submit_" . $this->name;  //ajoute un attribut name a mon bouton

        $helper->fields_value['MON_PREMIER_CHAMP'] = Tools::getValue('MON_PREMIER_CHAMP', Configuration::get('MON_PREMIER_CHAMP'));

        return $helper->generateForm($form_configuration);
    }
}

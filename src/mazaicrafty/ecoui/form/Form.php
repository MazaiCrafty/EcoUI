<?php

namespace mazaicrafty\ecoui\form;

use pocketmine\Server;

use mazaicrafty\ecoui\Main;

use jojoe77777\FormAPI\FormAPI;

use onebone\economyapi\EconomyAPI;

class Form{

    /** @var MenuForm */
    private static $menu_form;

    /** @var PayForm */
    private static $pay_form;

    /** @var InfoForm */
    private static $info_form;

    /** @var self */
    private static $instance;

    public static function init(): void{
        self::$menu_form = new MenuForm();
        self::$pay_form = new PayForm();
        self::$info_form = new InfoForm();
        self::$instance = new Form();
    }

    protected function getFormAPI(): FormAPI{
        return $this->getPlugin()->getFormAPI();
    }

    protected function getEconomyAPI(): EconomyAPI{
        return $this->getPlugin()->getEconomyAPI();
    }

    public function getMenuForm(): MenuForm{
        return self::$menu_form;
    }

    public function getPayForm(): PayForm{
        return self::$pay_form;
    }

    public function getInfoForm(): InfoForm{
        return self::$info_form;
    }

    protected function is_null($response): bool{
        return $response === null ? true : false;
    }

    protected function getPlugin(): Main{
        return Main::getInstance();
    }

    protected function getServer(): Server{
        return Server::getInstance();
    }

    public static function getInstance(): self{
        return self::$instance;
    }
}

<?php

namespace mazaicrafty\ecoui\form;

use pocketmine\Server;
use pocketmine\utils\Config;

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

    /** @var ReduceForm */
    private static $reduce_form;

    /** @var SetForm */
    private static $set_form;

    /** @var Config */
    private static $messages;

    /** @var self */
    private static $instance;

    public static function init(): void{
        self::$menu_form = new MenuForm();
        self::$pay_form = new PayForm();
        self::$info_form = new InfoForm();
        self::$reduce_form = new ReduceForm();
        self::$set_form = new SetForm();
        self::$instance = new Form();

        if (!file_exists(Main::getInstance()->getDataFolder())){
            @mkdir(Main::getInstance()->getDataFolder());
        }
        Main::getInstance()->saveResource("Messages.yml");
        self::$messages = new Config(Main::getInstance()->getDataFolder() . "Messages.yml", Config::YAML);
    }

    protected function getFormAPI(): FormAPI{
        return $this->getPlugin()->getFormAPI();
    }

    protected function getEconomyAPI(): EconomyAPI{
        return $this->getPlugin()->getEconomyAPI();
    }

    protected function getMessage(string $message): string{
        return self::$messages->get($message);
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

    public function getReduceForm(): ReduceForm{
        return self::$reduce_form;
    }

    public function getSetForm(): SetForm{
        return self::$set_form;
    }

    protected function is_null($response): bool{
        return ($response === null) ? true : false;
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

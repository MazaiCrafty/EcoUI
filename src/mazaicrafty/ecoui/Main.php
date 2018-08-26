<?php

namespace mazaicrafty\ecoui;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use mazaicrafty\ecoui\form\Form;

use jojoe77777\FormAPI\FormAPI;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;

use onebone\economyapi\EconomyAPI;

class Main extends PluginBase{

    // TODO: リファクタリングできるところがあればやっておきたい
    // TODO: ReduceFormクラスのcreateForm関数を呼び出す (MenuFormクラスにて)
    // TODO: SetFormクラスのcreateForm関数を呼び出す (MenuFormクラスにて)
    // TODO: すること終わったら絶対コメント消すんやで

    /** @var FormAPI */
    private $form_api;
    /** @var EconomyAPI */
    private $economy_api;
    /** @var self */
    private static $instance;

    protected function onLoad(): void{
        self::$instance = $this;
    }

    protected function onEnable(): void{
        Form::init();
        $this->form_api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $this->economy_api = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        if ($command->getName() === "ecoui"){
            if (!$sender instanceof Player){
                $sender->sendMessage("Please execute this command in-game");
                return true;
            }
            Form::getInstance()->getMenuForm()->createForm($sender)->sendToPlayer($sender);
            return true;
        }
        return false;
    }

    public function getFormAPI(): FormAPI{
        return $this->form_api;
    }

    public function getEconomyAPI(): EconomyAPI{
        return $this->economy_api;
    }

    public static function getInstance(): self{
        return self::$instance;
    }
}

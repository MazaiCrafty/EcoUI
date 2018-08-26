<?php

namespace mazaicrafty\ecoui\form;

use pocketmine\Player;

use jojoe77777\FormAPI\SimpleForm;

class InfoForm extends Form{

    public function createForm(Player $sender): SimpleForm{
        $form = $this->getFormAPI()->createSimpleForm(function(Player $player, int $result = null){
            if (!$this->is_null($result)){
                $this->getMenuForm()->createForm($player)->sendToPlayer($player);
            }
        });

        $form->setTitle($this->getMessage("info.title"));
        $message = str_replace("%MONEY%", $this->getEconomyAPI()->myMoney($sender), $this->getMessage("info.content"));
        $form->setContent($message);
        $form->addButton($this->getMessage("info.back.button"));
        return $form;
    }
}

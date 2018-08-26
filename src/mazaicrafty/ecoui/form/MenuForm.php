<?php

namespace mazaicrafty\ecoui\form;

use pocketmine\Player;

use jojoe77777\FormAPI\SimpleForm;

class MenuForm extends Form{

    const INFO_BUTTON = 0;
    const PAY_BUTTON = 1;
    const REDUCE_BUTTON = 2;
    const SET_BUTTON = 3;

    public function createForm(Player $sender): SimpleForm{
        $form = $this->getFormAPI()->createSimpleForm(function(Player $player, int $result = null){
            if (!$this->is_null($result)){
                switch ($result){
                    case self::INFO_BUTTON:
                        $this->getInfoForm()->createForm($player)->sendToPlayer($player);
                        break;
                    case self::PAY_BUTTON:
                        $this->getPayForm()->createForm($player)->sendToPlayer($player);
                        break;
                    case self::REDUCE_BUTTON:
                        $this->getReduceForm()->createForm()->sendToPlayer($player);
                        break;
                    case self::SET_BUTTON:
                        $this->getSetForm()->createForm()->sendToPlayer($player);
                        break;
                }
            }
        });
        $form->setTitle($this->getMessage("menu.title"));
        $form->setContent($this->getMessage("menu.content"));
        $form->addButton($this->getMessage("menu.info.button"));
        $form->addButton($this->getMessage("menu.pay.button"));
        if ($sender->isOp()){
            $form->addButton($this->getMessage("menu.reduce.button"));
            $form->addButton($this->getMessage("menu.set.button"));
        }
        return $form;
    }
}

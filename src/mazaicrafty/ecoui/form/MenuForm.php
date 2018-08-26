<?php

namespace mazaicrafty\ecoui\form;

use pocketmine\Player;

use jojoe77777\FormAPI\SimpleForm;

class MenuForm extends Form{

    // TODO: ReduceFormクラスのcreateForm関数を呼び出す
    // TODO: SetFormクラスのcreateForm関数を呼び出す

    const INFO_BUTTON = 0;
    const PAY_BUTTON = 1;
    const REDUCE_BUTTON = 2;
    const SET_BUTTON = 3;

    public function createForm(Player $sender): SimpleForm{
        $form = $this->getFormAPI()->createSimpleForm(function(Player $player, int $result = null){
            if (!$this->is_null($result)){
                switch ($result){
                    case self::INFO_BUTTON:
                        $this->getInfoForm($player)->createForm($player)->sendToPlayer($player);
                        break;
                    case self::PAY_BUTTON:
                        $this->getPayForm($player)->createForm($player)->sendToPlayer($player);
                        break;
                    case self::REDUCE_BUTTON:
                        break;
                    case self::SET_BUTTON:
                        break;
                }
            }
        });
        $form->setTitle("Menu");
        $form->setContent("Please select button");
        $form->addButton("Info");
        $form->addButton("Pay");
        if ($sender->isOp()){
            $form->addButton("Reduce money");
            $form->addButton("Set money");
        }
        return $form;
    }
}

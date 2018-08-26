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

        $form->setTitle("Info");
        $form->setContent("あなたの所持金: ". $this->getEconomyAPI()->myMoney($sender));
        $form->addButton("戻る");
        return $form;
    }
}

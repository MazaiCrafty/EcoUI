<?php

namespace mazaicrafty\ecoui\form;

use pocketmine\Player;

use jojoe77777\FormAPI\CustomForm;

class PayForm extends Form{

    /** @var array */
    private $list = array();

    public function createForm(Player $sender): CustomForm{
        $form = $this->getFormAPI()->createCustomForm(function(Player $player, array $result = null){
            if (!$this->is_null($result)){
                $target_name = $this->list[$result[0]];
                $target = $this->getServer()->getPlayer($target_name);
                $amount = $result[1];
                if ($this->is_null($target_name) || $result[0] === 0){
                    $player->sendMessage("プレイヤーを選択してください");
                    return;
                }
                if ($this->is_null($amount)){
                    $player->sendMessage("金額を設定してください");
                    return;
                }
                if ($target->getName() === $player->getName()){
                    $player->sendMessage("自身にお金を払うことはできません");
                    return;
                }
                $this->getEconomyAPI()->reduceMoney($player, $amount);
                $this->getEconomyAPI()->addMoney($target, $amount);

                $player->sendMessage($target->getName()."さんにお金払ったで");
                $target->sendMessage($player->getName()."さんからお金貰ったで");
                unset($this->list);
            }
        });
        $form->setTitle("Pay");
        $this->list[0] = "- Players -";
        foreach ($this->getServer()->getOnlinePlayers() as $player){
            $this->list[] = $player->getName();
        }
        $form->addDropdown("Players:", $this->list);
        $form->addSlider("Amount:", 1, $this->getEconomyAPI()->myMoney($sender));
        return $form;
    }
}

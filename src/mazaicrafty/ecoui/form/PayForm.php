<?php

namespace mazaicrafty\ecoui\form;

use pocketmine\Player;

use jojoe77777\FormAPI\CustomForm;

class PayForm extends Form{

    /** @var array */
    private $list = [];

    /**
     * @param   Player  $player
     * @return  CustomForm
     */
    public function createForm(Player $sender): CustomForm{
        $form = $this->getFormAPI()->createCustomForm(function(Player $player, array $result = null){
            if (!$this->is_null($result)){
                $target_name = $this->list[$result[0]];
                $target = $this->getServer()->getPlayer($target_name);
                $amount = $result[1];
                if ($this->is_null($target_name) || $result[0] === 0){
                    $player->sendMessage($this->getMessage("pay.notselected.player"));
                    return;
                }
                if ($this->is_null($amount)){
                    $player->sendMessage($this->getMessage("pay.notsetup.amount"));
                    return;
                }
                if ($target->getName() === $player->getName()){
                    $player->sendMessage($this->getMessage("pay.myself"));
                    return;
                }
                $this->getEconomyAPI()->reduceMoney($player, $amount);
                $this->getEconomyAPI()->addMoney($target, $amount);

                $str = [
                    "%SENDER%" => $player->getName(),
                    "%TARGET%" => $target->getName()
                ];
                foreach ($str as $str => $replace){
                    $sender_message = str_replace($str, $replace, $this->getMessage("pay.success.sender"));
                }
                foreach ($str as $str => $replace){
                    $target_message = str_replace($str, $replace, $this->getMessage("pay.success.target"));
                }
                $player->sendMessage($sender_message);
                $target->sendMessage($target_message);
                unset($this->list);
            }
        });
        $form->setTitle($this->getMessage("pay.title"));
        $this->list[0] = $this->getMessage("pay.dropdown.prefix");
        foreach ($this->getServer()->getOnlinePlayers() as $player){
            $this->list[] = $player->getName();
        }
        $form->addDropdown($this->getMessage("pay.dropdown"), $this->list);
        $form->addSlider($this->getMessage("pay.slider"), 1, $this->getEconomyAPI()->myMoney($sender));
        return $form;
    }
}

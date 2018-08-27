<?php

namespace mazaicrafty\ecoui\form;

use pocketmine\Player;

use jojoe77777\FormAPI\CustomForm;

class SetForm extends Form{

    /** @var array */
    private $list = [];

    /**
     * @return  CustomForm
     */
    public function createForm(): CustomForm{
        $form = $this->getFormAPI()->createCustomForm(function(Player $player, array $result = null){
            if (!$this->is_null($result)){
                $target_name = $this->list[$result[0]];
                $target = $this->getServer()->getPlayer($target_name);
                $amount = $result[1];
                if ($this->is_null($target_name) || $result[0] === 0){
                    $player->sendMessage($this->getMessage("set.notselected.player"));
                    return;
                }
                if ($this->is_null($amount)){
                    $player->sendMessage($this->getMessage("set.notsetup.amount"));
                    return;
                }
                $this->getEconomyAPI()->setMoney($target, $amount);

                $str = [
                    "%SENDER%" => $player->getName(),
                    "%TARGET%" => $target->getName()
                ];
                foreach ($str as $str => $replace){
                    $sender_message = str_replace($str, $replace, $this->getMessage("set.success.sender"));
                }
                foreach ($str as $str => $replace){
                    $target_message = str_replace($str, $replace, $this->getMessage("set.success.target"));
                }
                $player->sendMessage($sender_message);
                $target->sendMessage($target_message);
                unset($this->list);
            }
        });
        $form->setTitle($this->getMessage("set.title"));
        $this->list[0] = $this->getMessage("set.dropdown.prefix");
        foreach ($this->getServer()->getOnlinePlayers() as $player){
            $this->list[] = $player->getName();
        }
        $form->addDropdown($this->getMessage("set.dropdown"), $this->list);
        $form->addSlider($this->getMessage("set.slider"), 1, $this->getEconomyAPI()->getConfig()->get("max-money"));
        return $form;
    }
}

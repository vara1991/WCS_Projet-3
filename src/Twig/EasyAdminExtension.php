<?php
namespace App\Twig;

use App\Entity\Company;
use App\Entity\Session;
use App\Entity\Trainer;
use App\Repository\SessionRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class EasyAdminExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter(
                'filter_admin_actions',
                [$this, 'filterActions']
            )
        ];
    }
    public function filterActions(array $itemActions, $item)
    {
        if ($item instanceof Session && $item->getIsArchived() == true) {
            unset($itemActions['archived']);
            unset($itemActions['session_register']);
            unset($itemActions['edit']);
        } elseif ($item instanceof Session && $item->getIsArchived() == false) {
            unset($itemActions['qcm_list']);
            unset($itemActions['evaluation_pdf']);
        }

        if ($item instanceof Session && $item->getUser() == true) {
            unset($itemActions['session_register']);
            unset($itemActions['edit']);
        }elseif ($item instanceof Session && $item->getUser() == false){
            unset($itemActions['archived']);
        }

        if ($item instanceof Company && $item->getSessions()) {
            $sessions = $item->getSessions();
            foreach ($sessions as $session){
                if ($session->getId()){
                    unset($itemActions['delete']);
                }
            }
        }

        if ($item instanceof Trainer && $item->getTrainings()) {
            $trainings = $item->getTrainings();
            foreach ($trainings as $training){
                if ($training->getId()){
                    unset($itemActions['delete']);
                }
            }
        }

        return $itemActions;
    }
}
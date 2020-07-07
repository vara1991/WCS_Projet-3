<?php
namespace App\Twig;

use App\Entity\Session;
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

        if ($item instanceof Session && $item->getUser()) {
            unset($itemActions['session_register']);
            unset($itemActions['edit']);
        }

        return $itemActions;
    }
}
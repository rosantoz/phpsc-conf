<?php
namespace PHPSC\Conference\UI;

use Lcobucci\DisplayObjects\Core\UIComponent;
use PHPSC\Conference\Domain\Entity\Event;
use PHPSC\Conference\Domain\Entity\User;

/**
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class MainMenu extends UIComponent
{
    /**
     * @var Event
     */
    protected $event;

    /**
     * @var User
     */
    protected $user;

    /**
     * @param Event $event
     * @param User $user
     */
    public function __construct(Event $event, User $user = null)
    {
        $this->event = $event;
        $this->user = $user;
    }

    /**
     * @return string
     */
    protected function getItems()
    {
        if ($this->user === null) {
            return $this->getUnloggedUserItems();
        }

        return $this->getLoggedUserItems();
    }

    /**
     * @return array
     */
    protected function getLoggedUserItems()
    {
        $items = array(
            'Meus dados' => $this->getUrl('user'),
            'Trabalhos submetidos' => $this->getUrl('call4papers/submissions')
        );

        if ($this->user->hasManagementPrivilegesOn($this->event)) {
            $this->appendAdministrativesItems($items);
        }

        $items[] = null;
        $items['Sair'] = $this->getUrl('logoff');

        return $items;
    }

    /**
     * @param array $items
     */
    protected function appendAdministrativesItems(array &$items)
    {
        $items[] = null;

        if ($this->user->isAdmin()) {
            $items['Gerenciar apoiadores'] = $this->getUrl('adm/supporters');
            $items['Gerenciar inscritos'] = $this->getUrl('adm/credentialing');
        }

        $items['Ver palestras'] = $this->getUrl('adm/talks');
    }

    /**
     * @return array
     */
    protected function getUnloggedUserItems()
    {
        return array(
            'Github' => $this->getUrl('oauth/github'),
            'Facebook' => $this->getUrl('oauth/facebook'),
            'Google' => $this->getUrl('oauth/google'),
            'LinkedIn' => $this->getUrl('oauth/linkedin'),
            'Microsoft Live' => $this->getUrl('oauth/live'),
        );
    }
}

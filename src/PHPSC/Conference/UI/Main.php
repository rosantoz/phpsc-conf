<?php
namespace PHPSC\Conference\UI;

use \Lcobucci\DisplayObjects\Core\UIComponent;
use \Lcobucci\ActionMapper2\Application;

class Main extends UIComponent
{
    /**
     * @var string
     */
    protected $description;

    /**
     * @var \Lcobucci\ActionMapper2\Application
     */
    protected $application;

    /**
     * @var \Lcobucci\DisplayObjects\Core\UIComponent
     */
    protected $content;

    /**
     * @var array
     */
    protected static $scripts;

    /**
     * @param \Lcobucci\DisplayObjects\Core\UIComponent $content
     * @param \Lcobucci\ActionMapper2\Application $application
     * @return \PHPSC\Conference\UI\Main
     */
    public static function create(
        UIComponent $content,
        Application $application,
        $description = ''
    ) {
        $component = new static($content);
        $component->setApplication($application);
        $component->setDescription($description);

        return $component;
    }

    /**
     * @param \Lcobucci\DisplayObjects\Core\UIComponent $content
     */
    public function __construct(UIComponent $content)
    {
        $this->content = $content;

        static::appendScript($this->getUrl('js/vendor/bootstrap.min.js'), true);
        static::appendScript($this->getUrl('js/vendor/jquery-1.10.2.min.js'), true);
    }

    /**
     * @param \Lcobucci\ActionMapper2\Application $application
     */
    public function setApplication(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return \Lcobucci\DisplayObjects\Core\UIComponent
     */
    public function renderContent()
    {
        return $this->content;
    }

    /**
     * @return \PHPSC\Conference\UI\NavigationBar
     */
    public function renderNavigation()
    {
        $container = $this->application->getDependencyContainer();

        return new NavigationBar(
            $container->get('event.management.service')->findCurrentEvent(),
            $container->get('authentication.service')->getLoggedUser()
        );
    }

    /**
     * @return \PHPSC\Conference\UI\Footer
     */
    public function renderFooter()
    {
        return new Footer();
    }

    /**
     * @param string $url
     */
    public static function appendScript($url, $prepend = false)
    {
        if (static::$scripts === null) {
            static::$scripts = array();
        }

        if (!in_array($url, static::$scripts)) {
            if ($prepend) {
                array_unshift(static::$scripts, $url);
                return ;
            }

            static::$scripts[] = $url;
        }
    }

    /**
     * @return array
     */
    public function getScripts()
    {
        return static::$scripts;
    }
}

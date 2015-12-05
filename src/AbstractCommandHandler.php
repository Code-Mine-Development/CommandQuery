<?php
/**
 * Created by PhpStorm.
 * User: adamgrabek
 * Date: 18.11.2015
 * Time: 16:34
 */

namespace CodeMine\CommandQuery;


use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;

/**
 * Class AbstractCommandHandler
 *
 * @package Application
 */
abstract class AbstractCommandHandler implements EventManagerAwareInterface
{
    /**
     * @var EventManagerInterface
     */
    private $eventManager;

    /**
     * @param CommandQueryInterface $commandInterface
     *
     * @return mixed
     */
    abstract public function process(CommandQueryInterface $commandInterface);

    /**
     * @param CommandQueryInterface $commandInterface
     *
     * @return mixed
     * @throws \Exception
     */
    final public function handle(CommandQueryInterface $commandInterface)
    {
        $this->eventManager->trigger(self::commandEventPre($commandInterface::name()), $commandInterface);

        try {
            if (TRUE === $commandInterface instanceof CommandQueryInputFilterAwareInterface) {
                $commandInterface->validate();
            }
            $result = $this->process($commandInterface);
        } catch (\Exception $exception) {
            $this->eventManager->trigger(self::commandEventError($commandInterface::name(), $commandInterface, ['commandError' => $exception]));
            throw $exception;
        }

        $this->eventManager->trigger(self::commandEventPost($commandInterface::name(), $commandInterface));

        return $result;
    }

    public static function commandEventPre($command)
    {
        return $command . '.post';
    }

    public static function commandEventError($command)
    {
        return $command . '.error.post';
    }

    public static function commandEventPost($command)
    {
        return $command . '.post';
    }

    /**
     * Inject an EventManager instance
     *
     * @param  EventManagerInterface $eventManager
     *
     * @return void
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }


}
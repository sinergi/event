<?php
namespace Dispatch;

use Closure;
use InvalidArgumentException;

class Event
{
    /**
     * Event listeners
     *
     * @var array
     */
    private static $listeners = [];

    /**
     * Unbind an event.
     *
     * @param string $event
     * @throws InvalidArgumentException
     * @return bool
     */
    public static function off($event)
    {
        if (!is_string($event)) {
            throw new InvalidArgumentException("Parameter \$event passed to Dispatch\\Event::off() is not a valid string ressource");
        }

        unset(self::$listeners[$event]);

        return true;
    }

    /**
     * Bind an event.
     *
     * @param string $event
     * @param callable $callback
     * @throws InvalidArgumentException
     * @return bool
     */
    public static function on($event, Closure $callback)
    {
        if (!is_string($event)) {
            throw new InvalidArgumentException("Parameter \$event passed to Dispatch\\Event::on() is not a valid string ressource");
        }

        if (!isset(self::$listeners[$event])) {
            self::$listeners[$event] = [];
        }

        self::$listeners[$event][] = $callback;

        return true;
    }

    /**
     * Trigger an event
     *
     * @param string $event
     * @param array $arguments
     * @throws InvalidArgumentException
     * @return array
     */
    public static function trigger($event, array $arguments = [])
    {
        if (!is_string($event)) {
            throw new InvalidArgumentException("Parameter \$event passed to Dispatch::trigger() is not a valid string ressource");
        }

        $output = [];

        if (isset(self::$listeners[$event])) {
            foreach (self::$listeners[$event] as $listener) {
                $output[] = call_user_func_array($listener, $arguments);
            }
        }

        return $output;
    }
}
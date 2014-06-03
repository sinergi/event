<?php
namespace Sinergi\Event;

use Closure;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

class Dispatcher
{
    const EVENT_METHOD_PREFIX = 'on';
    const EVENT_BINDING_PREFIX = '.';

    /**
     * @var array
     */
    private $listeners = [];

    /**
     * @var array
     */
    private $events = [];

    /**
     * @var array
     */
    private $listenerWasScanned = [];

    /**
     * @param ListenerInterface $listener
     */
    public function add(ListenerInterface $listener)
    {
        $id = spl_object_hash($listener);
        $this->listeners[$id] = $listener;
    }

    private function findAllListenersEvents()
    {
        $listeners = array_diff_key($this->listeners, $this->listenerWasScanned);
        foreach ($listeners as $listener) {
            $this->findListenerEvents($listener);
        }
    }

    /**
     * @param ListenerInterface $listener
     */
    private function findListenerEvents(ListenerInterface $listener)
    {
        $listenerKey = spl_object_hash($listener);
        $this->listenerWasScanned[$listenerKey] = true;
        $reflection = new ReflectionClass($listener);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            if (0 === strncmp(self::EVENT_METHOD_PREFIX, $method->name, 2)) {
                $parameter = $method->getParameters()[0];
                if ($parameterType = $this->getMethodParameterType($parameter)) {
                    $event = substr($method->name, 2);
                    $this->attachListenerEvent($parameterType, $event, $listenerKey);
                }
            }
        }
    }

    /**
     * @param string $subject
     * @param string $event
     * @param string $listener
     */
    private function attachListenerEvent($subject, $event, $listener)
    {
        $binding = $subject . self::EVENT_BINDING_PREFIX . strtolower($event);
        if (!isset($this->events[$binding])) {
            $this->events[$binding] = [];
        }
        $this->events[$binding][] = $listener;
    }

    /**
     * @param ReflectionParameter $parameter
     * @return null|string
     */
    private function getMethodParameterType(ReflectionParameter $parameter)
    {
        $parameterType = $parameter->export([$parameter->getDeclaringClass()->name, $parameter->getDeclaringFunction()->name], $parameter->name, true);
        $parameterType = explode('<required> ', $parameterType, 2);
        if (isset($parameterType[1])) {
            $parameterType = explode(' ', $parameterType[1], 2);
            if (isset($parameterType[0])) {
                return (string)$parameterType[0];
            }
        }
        return null;
    }

    /**
     * @param mixed $subject
     * @param string $event
     * @param array $parameters
     * @return bool
     */
    public function trigger($subject, $event, array $parameters = [])
    {
        $retval = false;
        $this->findAllListenersEvents();
        $class = get_class($subject);
        $event = strtolower($event);
        $binding = $class . self::EVENT_BINDING_PREFIX . $event;
        if (isset($this->events[$binding])) {
            foreach ($this->events[$binding] as $listenerKey) {
                $listener = $this->listeners[$listenerKey];
                if (method_exists($listener, self::EVENT_METHOD_PREFIX . $event)) {
                    call_user_func_array([$listener, self::EVENT_METHOD_PREFIX . $event], array_merge([$subject], $parameters));
                    $retval = true;
                }
            }
        }
        return $retval;
    }
}
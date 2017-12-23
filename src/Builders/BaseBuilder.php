<?php

namespace markhuot\CraftQL\Builders;

use yii\base\Component;
use markhuot\CraftQL\Request;

class BaseBuilder extends Component {

    /**
     * The name of our schema
     *
     * @var string
     */
    protected $name;

    /**
     * The request used to generate the schema
     *
     * @var [type]
     */
    protected $request;

    /**
     * Add behaviors to our builder
     *
     * @param string $behavior
     * @return self
     */
    function use(string $behavior): self {
        $reflect = new \ReflectionClass($behavior);
        $this->attachBehavior($reflect->getShortName(), $behavior);
        return $this;
    }

    /**
     * Run the behavior's init methods
     *
     * @return void
     */
    function bootBehaviors() {
        if ($behaviors=$this->getBehaviors()) {
            foreach ($behaviors as $key => $behavior) {
                $this->{"init{$key}"}();
            }
        }
    }

    /**
     * Set the name of the schema/object
     *
     * @param string $name
     * @return self
     */
    function name(string $name): self {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the name of the schema/object
     *
     * @return string
     */
    function getName(): string {
        if ($this->name === null) {
            $reflect = new \ReflectionClass(static::class);
            return $this->name = $reflect->getShortName();
        }

        return $this->name;
    }

    /**
     * The request that generated this schema
     *
     * @return Request
     */
    function getRequest(): Request {
        return $this->request;
    }

}
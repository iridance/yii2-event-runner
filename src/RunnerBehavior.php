<?php

namespace event\runner;

class RunnerBehavior extends \yii\base\Behavior
{
    protected $when;

    /**
     * 設定執行條件
     *
     * @param callable|bool $value
     * @return RunnerBehavior
     */
    public function setWhen($value)
    {
        if (is_callable($value) || is_bool($value)) {
            $this->when = $value;
        } else {
            throw new \yii\base\InvalidArgumentException('"when" must be callable or boolean.');
        }
        return $this;
    }

    /**
     * 取得是否執行
     *
     * @return bool
     */
    public function getWhen()
    {
        if (is_callable($this->when)) {
            $this->when = ($this->when)();
        }
        return $this->when;
    }

    protected $runCallback;

    /**
     * 設定runCallback function
     *
     * @param callable $value
     * @return RunnerBehavior
     */
    public function setRunCallback($value)
    {
        if (is_callable($value)) {
            $this->runCallback = $value;
        } else {
            throw new \yii\base\InvalidArgumentException('"RunCallback" must be callable.');
        }
        return $this;
    }

    /**
     * 取得callback結果
     *
     * @return mixed
     */
    public function getRunCallback()
    {
        //$this->callback = ($this->callback)();
        return $this->runCallback;
    }

    public function events()
    {
        return $this->events;
    }

    protected $events;

    public function setEvents($value)
    {
        if (is_callable($value)) {
            $value = $value();
        }
        if (is_array($value)) {
            $this->events = array_fill_keys($value, 'run');
        } else {
            throw new \yii\base\InvalidArgumentException('"event" must be array.');
        }
        return $this;
    }

    public function run($event)
    {
        if (!$this->getWhen()) {
            return false;
        }

        $runCallback = $this->getRunCallback();
        if (!is_callable($runCallback)) {
            throw new \yii\base\InvalidArgumentException('"runCallback" must be callable.');
        }
        
        return $runCallback();
    }
}
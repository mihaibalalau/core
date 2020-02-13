<?php

class Output {

    /**
     * @var mixed $output
     */
    private $output;

    /**
     * @var $type
     */
    private $type;


    public function write(string $output, $overwrite = false) {

        $this->output = $overwrite ? $output : ($this->output . $output);
    }

    public function get() {

        return $this->output;
    }

    public function setType($type) {

        $this->type = $type;
    }

    public function getType() {

        return $this->type;
    }
}
<?php namespace Redenz\BulmaForms;

use Redenz\BulmaForms\BulmaFormBuilder;

class BulmaForm
{
    protected $builder;
    protected $basicFormBuilder;
    protected $horizontalFormBuilder;

    public function __construct(BulmaFormBuilder $basicFormBuilder, HorizontalFormBuilder $horizontalFormBuilder)
    {
        $this->basicFormBuilder = $basicFormBuilder;
        $this->horizontalFormBuilder = $horizontalFormBuilder;
    }

    public function open()
    {
        $this->builder = $this->basicFormBuilder;
        return $this->builder->open();
    }

    public function openHorizontal($columnSizes)
    {
        $this->horizontalFormBuilder->setColumnSizes($columnSizes);
        $this->builder = $this->horizontalFormBuilder;
        return $this->builder->open();
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->builder, $method], $parameters);
    }
}

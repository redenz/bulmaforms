<?php namespace Redenz\BulmaForms;

use AdamWathan\Form\ErrorStore\IlluminateErrorStore;
use AdamWathan\Form\FormBuilder;
use AdamWathan\Form\OldInput\IlluminateOldInputProvider;
use Illuminate\Support\ServiceProvider;
use Redenz\BulmaForms\BulmaForm;
use Redenz\BulmaForms\BulmaFormBuilder;

class BulmaFormsServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerErrorStore();
        $this->registerOldInput();
        $this->registerFormBuilder();
        $this->registerBasicFormBuilder();
        $this->registerHorizontalFormBuilder();
        $this->registerBootForm();
    }

    protected function registerErrorStore()
    {
        $this->app['redenz.form.errorstore'] = $this->app->share(function ($app) {
            return new IlluminateErrorStore($app['session.store']);
        });
    }

    protected function registerOldInput()
    {
        $this->app['redenz.form.oldinput'] = $this->app->share(function ($app) {
            return new IlluminateOldInputProvider($app['session.store']);
        });
    }

    protected function registerFormBuilder()
    {
        $this->app['redenz.form'] = $this->app->share(function ($app) {
            $formBuilder = new FormBuilder;
            $formBuilder->setErrorStore($app['redenz.form.errorstore']);
            $formBuilder->setOldInputProvider($app['redenz.form.oldinput']);
            $formBuilder->setToken($app['session.store']->getToken());

            return $formBuilder;
        });
    }

    protected function registerBasicFormBuilder()
    {
        $this->app['bulmaform.basic'] = $this->app->share(function ($app) {
            return new BulmaFormBuilder($app['redenz.form']);
        });
    }

    protected function registerHorizontalFormBuilder()
    {
        $this->app['bulmaform.horizontal'] = $this->app->share(function ($app) {
            return new HorizontalFormBuilder($app['adamwathan.form']);
        });
    }

    protected function registerBootForm()
    {
        $this->app['bulmaform'] = $this->app->share(function ($app) {
            return new BulmaForm($app['bulmaform.basic'], $app['bulmaform.horizontal']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['bulmaform'];
    }
}

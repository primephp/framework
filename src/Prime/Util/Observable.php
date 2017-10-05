<?php

namespace Prime\Util;

use SplObserver;

/**
 * Descrição da Classe Observable
 *
 * @author Elton Luiz 
 */
class Observable implements IObservable
{

    /**
     * Armazena os objetos Observer
     * @var ArrayList
     */
    protected $observers;

    /**
     * Armazena se o status do objeto observável foi altererado, caso tenha sido alterado
     * o seu valor é TRUE, do contrário seu valor é FALSE
     * @var TBoolean 
     */
    protected $_change = FALSE;

    /**
     * 
     */
    public function __construct()
    {
        $this->observers = new ArrayList();
    }

    /**
     * Método simliat a addObserver, diferenciando-se apenas pelo fato de aceitar observer
     * que implementa apenas a interface SplObserver
     * @param SplObserver $observer
     */
    public function attach(SplObserver $observer)
    {
        $this->addObserver($observer);
    }

    /**
     * Método similar a deleteObserver, diferenciando-se apenas pelo fato de aceitar observer
     * que implementa apenas a interface SplObserver
     * @param SplObserver $observer
     */
    public function detach(SplObserver $observer)
    {
        $this->deleteObserver($observer);
    }

    /**
     * Alias para NotifyObservers
     * @namespace
     */
    public function notify()
    {
        $this->notifyObservers();
    }

    /**
     * Adiciona um observador para o conjunto de observadores para este objeto, desde que 
     * não é o mesmo que alguns observadores já no set.
     * @param \Prime\util\Observer $o
     */
    public function addObserver(Observer $o)
    {
        $this->observers->add($observer);
    }

    /**
     * Indica que este objeto não mudou, ou que já notificou todos os seus 
     * observadores da sua alteração mais recente, de modo que o método 
     * hasChanged vai agora retornar false.
     */
    protected function clearChanged()
    {
        $this->_change = FALSE;
    }

    /**
     * Retorna o número de observadores deste objeto observável.
     */
    public function countObservers()
    {
        return $this->observers->size();
    }

    /**
     * Exclui um observador do conjunto de observadores deste objeto.
     * @param \Prime\util\Observer $o
     */
    public function deleteObserver(Observer $o)
    {
        return $this->observers->remove($o);
    }

    /**
     * Limpa a lista observador para que este objeto não tem mais observadores.
     */
    public function deleteObservers()
    {
        $this->observers->clear();
    }

    /**
     * Testa se o objeto mudou.
     * @return TBoolean Caso o objeto tenha sido alterado retorna TRUE, do contrário retorna
     * FALSE;
     */
    public function hasChanged()
    {
        return $this->_change;
    }

    /**
     * Se este objeto foi alterado, como indicado pelo método hasChanged, em seguida, 
     * notificar todos os seus observadores e, em seguida, chamar o método clearChanged 
     * para indicar que este objeto não mudou.
     * @param \Prime\util\Object $arg
     */
    public function notifyObservers()
    {
        for ($index = 0; $index < count($this->observers->size()); $index++) {
            $observer = $this->observers->get($index);
            /* @var $observer IObserver */
            $observer->update($this);
        }
        $this->clearChanged();
    }

    /**
     * Marca este objeto observável como tendo sido alterado;
     * o método hasChanged agora vai retornar true.
     */
    protected function setChanged()
    {
        $this->_change = TRUE;
    }

}

?>

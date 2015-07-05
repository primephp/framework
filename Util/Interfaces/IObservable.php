<?php

namespace Prime\Util\Interfaces;

use SplSubject;

/**
 * Descrição da Interface IObservable
 * classe representa um objeto observável, ou "dados" no paradigma Model-View.
 * Ele pode ser uma subclasse para representar um objeto que o aplicativo deseja ter observado. 
 * @package Prime\util
 * @dateCreate 28/05/2014
 * @author comforsup-0215
 */
interface IObservable extends SplSubject {

    /**
     * Adiciona um observador para o conjunto de observadores para este objeto, 
     * desde que não é o mesmo que alguns observadores já no set.
     */
    public function addObserver(Observer $o);

    /**
     *   Retorna o número de observadores deste objeto observável.
     * @return int
     */
    public function countObservers();

    /**
     *   Exclui um observador do conjunto de observadores deste objeto.
     */
    public function deleteObserver(Observer $o);

    /**
     * Limpa a lista observador para que este objeto não tem mais observadores.
     */
    public function deleteObservers();

    /**
     * Testa se o objeto mudou.
     */
    public function hasChanged();

    /**
     * Se este objeto foi alterado, como indicado pelo método hasChanged, 
     * em seguida, notificar todos os seus observadores e, em seguida, chamar 
     * o método clearChanged para indicar que este objeto não mudou.
     */
    public function notifyObservers(Object $arg = NULL);
}

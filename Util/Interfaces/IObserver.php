<?php

namespace Prime\Util\Interfaces;

use \SplObserver;

/**
 * Descrição da Interface IObserver
 * Uma classe pode implementar a interface Observer quando quer ser informado 
 * das alterações nos objetos observáveis.
 * @package Prime\util
 * @dateCreate 28/05/2014
 * @author comforsup-0215
 */
interface IObserver extends SplObserver {

    /**
     * Este método é chamado sempre que o objecto observado é alterada. 
     * Um aplicativo chama o método notifyObservers de um objeto observável 
     * para ter todos os observadores do objeto notificados da mudança.
     * @param $subject Objeto observável
     */
    public function update(SplSubject $subject);
}

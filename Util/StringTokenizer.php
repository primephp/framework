<?php

namespace Prime\util;

use Prime\core\Object;

/**
 * Descrição de StringTokenizer
 * A classe string tokenizer permite que um aplicativo para quebrar uma string 
 * em tokens. O método de geração de tokens é muito mais simples do que a 
 * utilizada pela classe StreamTokenizer. Os métodos StringTokenizer não fazem 
 * distinção entre os identificadores, números e strings entre aspas, nem 
 * reconhecer e ignorar comentários. <br>
 * O conjunto de delimitadores (os caracteres que separam os tokens) pode ser 
 * especificado no momento da criação ou em uma base per-token. 
 * @dateCreate 28/05/2014
 * @author Elton Luiz
 */
class StringTokenizer extends Object implements IEnumeration {

    /**
     * Constrói um tokenizador corda para a seqüência especificada. 
     * O tokenizador usa o conjunto delimitador padrão, que é "\ t \ n \ r \ f":
     * o caractere de espaço, o caractere de tabulação, o caractere de nova 
     * linha, o personagem de retorno de carro, eo carácter de avanço. Próprios 
     * caracteres delimitadores não será tratado como tokens.
     * @param string $string
     * @param string $delim
     */
    public function __construct($string, $delim) {
        ;
    }

    /**
     * Testa se há mais tokens disponíveis de cordas deste tokenizador. Se esse 
     * método retorna true, em seguida, uma chamada subseqüente para nextToken 
     * sem argumento retornará com sucesso um token.
     * @return TBoolean TRUE se há mais tokens; FALSO caso contrário.
     */
    public function hasMoreToken() {
        
    }

    /**
     * Retorna o próximo token a partir desta tokenizador string.<br>
     * Primeiro, o conjunto de caracteres considerados delimitadores por este 
     * objeto StringTokenizer é alterado para ser os personagens do delim string. 
     * Em seguida, o próximo token na seqüência após a posição atual é retornado. 
     * A posição atual é avançado além das símbolo reconhecidos. O novo conjunto 
     * delimitador continua a ser o padrão após esta chamada.
     * @param string $delim Novo delimitador 
     * @return string O próximo tokem a partir deste tokenizador de string
     */
    public function nextToken($delim = NULL) {
        
    }

    /**
     * Retorna o mesmo valor que o método hasMoreTokens. Ela existe para que 
     * esta classe pode implementar a interface Enumeration.
     * @return TBoolean TRUE se há mais tokens; FALSO caso contrário.
     */
    public function hasMoreElements() {
        return $this->hasMoreToken();
    }

    /**
     * Retorna o mesmo valor que o método nextToken, exceto que seu valor de 
     * retorno declarado é objeto, em vez de cadeia. Ela existe para que esta 
     * classe pode implementar a interface Enumeration.
     * @return string 
     */
    public function nextElement() {
        return $this->nextToken();
    }

    /**
     * Calcula o número de vezes que o método nextToken deste tokenizador podem 
     * ser chamados antes de gerar uma exceção. A posição atual não é avançado. 
     * @return int O número de tokens restantes na string usando o conjunto 
     * delimitador atual.
     */
    public function countTokens() {
        
    }

}

?>

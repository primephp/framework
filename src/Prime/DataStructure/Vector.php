<?php

/*
 * The MIT License
 *
 * Copyright 2017 TomSailor.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Prime\DataStructure;

use OutOfRangeException;
use Traversable;
use UnexpectedValueException;

/**
 * Um Vector é uma sequência de valores contínuos que cresce e diminui 
 * automaticamente
 * @name Vector
 * @package Prime\DataStructure
 * @since 30/10/2017
 * @author TomSailor
 */
class Vector implements Sequence
{

    /**
     * O conteúdo do vetor
     * @var array
     */
    private $array = [];

    /**
     * A posição do ponteiro no objeto
     * @var int
     */
    private $cursor = 0;

    /**
     * Cria uma nova instância de Vector, usando um objeto traversable ou um 
     * array
     * @param Traversable|array $values Um objeto Traversable ou um array usado para
     * os valores iniciais do objeto
     */
    public function __construct($values = null)
    {
        $this->cursor = 0;
        if (!is_null($values)) {
            if (!is_array($values) && !$values instanceof Traversable) {
                throw new UnexpectedValueException(get_called_class() . ' aceita apenas array ou objetos Traversable para sua inicializacao');
            }
            foreach ($values as $value) {
                $this->add($value);
            }
        }
    }

    /**
     * Adicona o elemento no final do Vetor
     * @param mixed $value
     */
    private function add($value)
    {
        array_push($this->array, $value);
    }

    /**
     * Reindexa o array, necessário quando se é removido um valor no meio ou no
     * início do índice
     */
    private function reIndex()
    {
        $this->array = array_values($this->array);
    }

    /**
     * Retorna um array com o conteúdo em ordem reversa
     * @return array
     */
    private function reverted()
    {
        return array_reverse($this->array);
    }

    /**
     * Define o valor para a capacidade do Vetor, adicionado elementos vazios
     * em todas as posições
     * @param int $capacity
     */
    public function allocate(int $capacity)
    {
        $this->array = array_pad($this->array, $capacity, '');
    }

    /**
     * Atualiza todos os valores aplicando uma função de retorno de chamada para cada valor.
     * @param callable $callback
     */
    public function apply(callable $callback)
    {
        array_walk($this->array, $callback);
    }

    /**
     * Verifica se o objeto contem os valores passados
     * @param mixed $values Valores passados
     */
    public function contains(...$values): bool
    {
        foreach ($values as $value) {
            if (!in_array($value, $this->array)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Cria uma nova sequência usando um callable para determinar quais valores
     * incluir
     * @param callable $callback
     */
    public function filter(callable $callback): Sequence
    {
        return new Vector(array_filter($this->array, $callback));
    }

    /**
     * Atualiza todos os valores aplicando uma função de retorno de chamada 
     * para cada valor.
     * @param mixed $value
     */
    public function find($value)
    {
        return array_search($value, $this->array);
    }

    /**
     * Retorna o primeiro valor da sequência
     * @return mixed O primeiro valor da sequência
     */
    public function first()
    {
        $this->rewind();
        return $this->current();
    }

    /**
     * Retorna o valor de um determinado índice
     * @param int $index O índice para acessar, começando de 0
     */
    public function get(int $index)
    {
        return $this->offsetGet($index);
    }

    /**
     * Insere valores na sequência em um determinado índice.
     * @param int $index O índice para inserir. 0 <= index <= count
     * @param mixed $values
     */
    public function insert(int $index, ...$values)
    {
        $i = $index;
        foreach ($values as $value) {
            $this->offsetSet($i, $value);
            $i++;
        }
    }

    /**
     * Verifica se há elementos no objeto 
     * @return bool Retorna TRUE caso não haja elementos e FALSE do contrário
     */
    public function isEmpty(): bool
    {
        $array = array_filter($this->array);
        if (!empty($array)) {
            return false;
        }
        return true;
    }

    /**
     * Junta todos os valores como uma string usando um separador opcional entre 
     * cada valor
     * 
     * @param string $glue Uma string opcional para separar cada valor
     */
    public function join(string $glue = ''): string
    {
        return implode($glue, $this->array);
    }

    /**
     * Retorna o último valor da sequência
     * @return mixed O último valor da sequência
     */
    public function last()
    {
        return end($this->array);
    }

    /**
     * Remove todos os elementos do objeto
     */
    public function clear()
    {
        $this->rewind();
        $this->array = [];
    }

    /**
     * Retorna um novo objeto Vector contendo os elemento do objeto atual
     * @return \Prime\DataStructure\Collection
     */
    public function copy(): Collection
    {
        return new Vector($this->array);
    }

    /**
     * Retorna um array contendo todos os elementos/valores
     * @return array Um array de elementos/valores
     */
    public function toArray(): array
    {
        return $this->array;
    }

    /**
     * Retorna o total de elementos
     * @return int O número de elementos
     */
    public function count(): int
    {
        return count($this->array);
    }

    /**
     * Retorna um string contendo a representação JSON dos valores
     * @return string A representação JSON dos valores
     */
    public function jsonSerialize()
    {
        return json_encode($this->array);
    }

    /**
     * Retorna o resultado a aplicação da função $callback para cada valor da
     * sequência
     * @param callable $callback
     */
    public function map(callable $callback): Sequence
    {
        return new Vector(array_map($callback, $this->array));
    }

    /**
     * 
     * @param Traversable|array $values
     * @return Sequence
     */
    public function merge($values): Sequence
    {
        $array = array_merge($this->toArray(), $values);
        return new Vector($array);
    }

    /**
     * Remove e retorna o último valor
     * @return mixed O último valor removido
     */
    public function pop()
    {
        return array_pop($this->array);
    }

    /**
     * Adiciona valores no final do objeto
     * @param mixed $values Os valores a serem adicionados
     */
    public function push(...$values)
    {
        foreach ($values as $value) {
            $this->add($value);
        }
    }

    /**
     * Reduz a sequência para um único valor usando uma função $callback.
     * @param callable $callback
     * @param int $initial
     */
    public function reduce(callable $callback, int $initial = 0)
    {
        $this->array = array_reduce($this->array, $callback, $initial);
    }

    /**
     * Remove e retorna o valor do índice informado
     * @param int $index O índice do valor a ser removeido
     * @throws \OutOfRangeException Se o índice não é válido
     */
    public function remove(int $index)
    {
        if ($this->offsetExists($index)) {
            $this->offsetUnset($index);
            $this->reIndex();
        } else {
            throw new OutOfRangeException('Indice para ' . __METHOD__ . ' invalido');
        }
    }

    /**
     * Inverte a sequenca do conteúdo do objeto
     */
    public function reverse()
    {
        $this->array = $this->reverted();
    }

    /**
     * Retorna uma cópia (um objeto Vector) com o conteúdo em ordem inversa
     * @return Sequence Uma cópia inversa do objeto
     */
    public function reversed(): Sequence
    {
        return new Vector($this->reverted());
    }

    /**
     * Rotociona a sequência um determinado número de vezes, removendo o primeiro
     * elemento e colocando-o no final da sequência
     * @param int $rotations Número de vezes que a sequência deverá ser 
     * rotacionada
     */
    public function rotate(int $rotations)
    {
        for ($index = 0; $index < $rotations; $index++) {
            $value = $this->shift();
            $this->push($value);
        }
    }

    /**
     * Atualiza o valor de um determinado índice
     * @param int $index O índice do valor a ser atualizado
     * @param mixed $value O novo valor
     * @throws \OutOfRangeException Se o índice não for válido
     */
    public function set(int $index, $value)
    {
        $this->offsetSet($index, $value);
    }

    /**
     * Remove e retorna o primeiro valor da sequência
     * @return mixed O primeiro valor, que foi removido
     */
    public function shift()
    {
        return array_shift($this->array);
    }

    /**
     * Retorna uma sub-sequência de um determinado intervalo
     * @param int $index O índice no qual a sub-sequência começa
     * @param int $length Se um comprimento é dado e é positivo, a sequência 
     * resultante terá muitos valores nela. Se o comprimento resultar em um 
     * transbordamento, somente os valores até o final da seqüência serão 
     * incluídos. Se um comprimento é dado e é negativo, a seqüência irá parar 
     * que muitos valores do final. Se um comprimento não for fornecido, a 
     * seqüência resultante conterá todos os valores entre o índice e o fim 
     * da seqüência.
     * @return Sequence Uma sub-sequência do intervalo dado
     */
    public function slice(int $index, int $length = 0): Sequence
    {
        return new Vector(array_slice($this->array, $length, $index));
    }

    /**
     * Ordena o conteúdo do objeto
     * @return bool Retorna TRUE em caso de sucesso ou FALSE em caso de falha
     * na ordenação
     */
    public function sort()
    {
        return sort($this->array);
    }

    /**
     * Retorna uma cópia do objeto com os elementos ordenados
     * @param callable $comparator
     * @return Sequence Retorna uma cópia ordenada do conteúdo da Sequência
     */
    public function sorted(): Sequence
    {
        $copy = $this->copy();
        $copy->sort();
        return $copy;
    }

    /**
     * Retorna uma soma de todos os elementos da sequência. Arrays e objetos são 
     * considerados iguais a zero ao calcular a soma.
     * @return number A soma de todos os elementos da sequência 
     */
    public function sum(): number
    {
        return array_sum($this->array);
    }

    /**
     * Adiciona valores no início da sequência
     * @param mixed $values
     */
    public function unshift(...$values)
    {
        foreach ($values as $value) {
            array_unshift($this->array, $value);
        }
    }

    /**
     * Retorna o elemento corrente
     * @return mixed O elemento corrente
     */
    public function current()
    {
        if ($this->valid()) {
            return $this->array[$this->cursor];
        } else {
            throw new OutOfRangeException('Indice ' . $this->cursor . ' para ' . __METHOD__ . ' invalido');
        }
    }

    public function rewind()
    {
        $this->cursor = 0;
    }

    public function key()
    {
        return $this->cursor;
    }

    public function next()
    {
        ++$this->cursor;
    }

    public function valid()
    {
        return isset($this->array[$this->cursor]);
    }

    public function offsetExists($index)
    {
        return isset($this->array[$index]);
    }

    /**
     * 
     * @param type $index
     * @return type
     * @throws OutOfRangeException
     */
    public function offsetGet($index)
    {
        if (isset($this->array[$index])) {
            return $this->array[$index];
        } else {
            throw new OutOfRangeException('Indice para ' . __METHOD__ . ' invalido');
        }
    }

    public function offsetSet($index, $value)
    {
        if (empty($index)) {
            $index = $this->count() + 1;
        }
        if (!$this->offsetExists($index) && ($index <> $this->count() + 1)) {
            throw new OutOfRangeException('Indice para ' . __METHOD__ . ' invalido');
        }
        $this->array[$index] = $value;
    }

    public function offsetUnset($index)
    {
        unset($this->array[$index]);
    }

}

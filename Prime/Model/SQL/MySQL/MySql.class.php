<?php

namespace Prime\Model\SQL\MySQL;

/**
 * Descrição de MySql
 * Implementa funções e métodos inerentes as consultas SQL com o banco de dados
 * MySQL
 * @author tom
 */
class MySql {

    /**
     * Retorna função DATE_FORMAT devidamente formatada
     * @example 
     * <table border="1">
      <tr>
      <td width="10%">Especificação</td>
      <td>Descrição</td>
      </tr>
      <tr>
      <td><code class="literal">%M</code></td>
      <td>Nome do mês (<code class="literal">January</code>..<code class="literal">December</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%W</code></td>
      <td>Nome da semana (<code class="literal">Sunday</code>..<code class="literal">Saturday</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%D</code></td>
      <td>Dia do mês com sufixo Inglês (<code class="literal">0th</code>,
      <code class="literal">1st</code>, <code class="literal">2nd</code>,
      <code class="literal">3rd</code>, etc.)</td>
      </tr>
      <tr>
      <td><code class="literal">%Y</code></td>
      <td>Ano, numerico, 4 digitos</td>
      </tr>
      <tr>
      <td><code class="literal">%y</code></td>
      <td>Ano, numerico, 2 digitos</td>
      </tr>
      <tr>
      <td><code class="literal">%X</code></td>
      <td>Ano para a semana onde o Domingo é o primeiro dia da semana, numerico,
      4 digitos; usado com <code class="literal">%V</code>
      </td>
      </tr>
      <tr>
      <td><code class="literal">%x</code></td>
      <td>Ano para a semana onde a segunda é o primeiro dia da semana, numerico,
      4 digitos; usado com <code class="literal">%v</code>
      </td>
      </tr>
      <tr>
      <td><code class="literal">%a</code></td>
      <td>Nome da semana abreviado
      (<code class="literal">Sun</code>..<code class="literal">Sat</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%d</code></td>
      <td>Dia do mês, numerico (<code class="literal">00</code>..<code class="literal">31</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%e</code></td>
      <td>Dia do mês, numerico (<code class="literal">0</code>..<code class="literal">31</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%m</code></td>
      <td>Mês, numerico (<code class="literal">00</code>..<code class="literal">12</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%c</code></td>
      <td>Mês, numerico (<code class="literal">0</code>..<code class="literal">12</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%b</code></td>
      <td>Nome do mês abreviado (<code class="literal">Jan</code>..<code class="literal">Dec</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%j</code></td>
      <td>Dia do ano (<code class="literal">001</code>..<code class="literal">366</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%H</code></td>
      <td>Hora (<code class="literal">00</code>..<code class="literal">23</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%k</code></td>
      <td>Hora (<code class="literal">0</code>..<code class="literal">23</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%h</code></td>
      <td>Hora (<code class="literal">01</code>..<code class="literal">12</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%I</code></td>
      <td>Hora (<code class="literal">01</code>..<code class="literal">12</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%l</code></td>
      <td>Hora (<code class="literal">1</code>..<code class="literal">12</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%i</code></td>
      <td>Minutos, numerico (<code class="literal">00</code>..<code class="literal">59</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%r</code></td>
      <td>Tempo, 12-horas (<code class="literal">hh:mm:ss</code> seguido por
      <code class="literal">AM</code> ou <code class="literal">PM</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%T</code></td>
      <td>Tempo, 24-horas (<code class="literal">hh:mm:ss</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%S</code></td>
      <td>Segundos (<code class="literal">00</code>..<code class="literal">59</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%s</code></td>
      <td>Segundos (<code class="literal">00</code>..<code class="literal">59</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%f</code></td>
      <td>Microsegundos (<code class="literal">000000</code>..<code class="literal">999999</code>)</td>
      </tr>
      <tr>
      <td><code class="literal">%p</code></td>
      <td>
      <code class="literal">AM</code> ou <code class="literal">PM</code>
      </td>
      </tr>
      <tr>
      <td><code class="literal">%w</code></td>
      <td>Dia da semana
      (<code class="literal">0</code>=Domingo..<code class="literal">6</code>=Sabado)</td>
      </tr>
      <tr>
      <td><code class="literal">%U</code></td>
      <td>Semana(<code class="literal">00</code>..<code class="literal">53</code>), onde o Domingo é
      o primeiro dia da semana.</td>
      </tr>
      <tr>
      <td><code class="literal">%u</code></td>
      <td>Semana(<code class="literal">00</code>..<code class="literal">53</code>), onde a Segunda é
      o primeiro dia da semana.</td>
      </tr>
      <tr>
      <td><code class="literal">%V</code></td>
      <td>Semana(<code class="literal">01</code>..<code class="literal">53</code>), onde o Domingo é
      o primeiro dia da semana; usado com
      <code class="literal">%X</code>
      </td>
      </tr>
      <tr>
      <td><code class="literal">%v</code></td>
      <td>Semana(<code class="literal">01</code>..<code class="literal">53</code>), onde a Segunda é
      o primeiro dia da semana; usado com
      <code class="literal">%x</code>
      </td>
      </tr>
      <tr>
      <td><code class="literal">%%</code></td>
      <td>Um literal ‘<code class="literal">%</code>’.</td>
      </tr>
      </table>
     * @param string $field
     * @param string $format
     * @param string $as_name
     * @return string 
     */
    public static function DateFormat($field, $format, $as_name = NULL) {
        if (is_null($as_name)) {
            $as_name = $field;
        }
        return "DATE_FORMAT($field, '$format') AS $as_name";
    }

}



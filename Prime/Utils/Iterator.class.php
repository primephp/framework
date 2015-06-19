<?php

namespace Prime\Utils;

/**
 * @type Class
 *
 * This class is alot like the vector class in C++ it allows you to perform
 * certain operations and navigate through an array.
 * Example:
 *          $arrayA = array("A", 1, $someVar);
 *          $obj_It_1 = new Iterator($arrayA);
 *          for($i=$obj_It_1->index_begin(); $i!=$obj_It_1->index_end(); $i++)
 *          {
 *              echo $obj_It_1->at($i);
 *          }
 *          OR
 *          $arrayA = array("A", 1, $someVar);
 *          $obj_It_B = new Iterator();
 *          foreach($arrayA as $element)
 *          {
 *              $obj_It_B->push_back($element);
 *          }
 *
 * @author       Alex Guzman <theshadowx@softhome.net>
 * 		Jonatan Evald Buus <jona@cydev.biz>
 * @copyright    GPL 12/27/2003
 * @name         Iterator
 * @todo         Handle sub-arrays as part of the data and allow access to the sub-array elements
 * @version      1.1.2
 * @changelog    12/28/03 - Added method replace($index, $var) to actually update different elements in the array
 * 		 04/22/04 - Cleaned up comments, indentions and clarified some if statements by adding === true/false
 * 		 04/22/04 - Created short named wrapper functions for previous, insert and delete
 * 		 04/22/04 - Created clarification wrapper functions for begin, index_begin and index_end
 * 		 04/22/04 - Implemented ability to not create array before initializing Iterator class
 * 		 04/22/04 - Implemented destructor
 * 		 04/22/04 - Removed internal variable _Classname, uses get_class($this) instead
 * 		 04/22/04 - Renamed function iterator_ to all, iterator_ still works but generates a user notice
 * @package	Prime\Utils
 * @name 	Iterator
 * @access 	public
 */
class Iterator implements Iterator {

    /**
     * @var	$iArray - The mixed array that will be handled by the class
     * @access	public
     */
    var $iArray;

    /**
     * @var	$_index - This holds the current position of the array
     * @access	private
     */
    var $_index;

    // public:

    /**
     * @name	Iterator - This is the constructor for the class
     * @param	Arbitary mixed - Can be either one array or a number of elements to turn into the internal iterator array
     * @access	public
     */
    public function __construct() {
        // Initialize internal array depending on number of function arguments
        switch (func_num_args()) {
            case (0): // No parameters passed
                $iArr = array();
                break;
            case (1): // 1 parameter passed, check type
                switch (true) {
                    case (is_array(func_get_arg(0)) ): // Input is an array
                        $iArr = func_get_arg(0);
                        break;
                    default:       // Input is no an array
                        $iArr = array();
                        $iArr[] = func_get_arg(0);
                        break;
                }
                break;
            default: // Arbitary number of input parameters
                $iArr = array();
                $aFuncArgs = func_get_args();
                // Loop through inpu paramters
                for ($i = 0; $i < count($aFuncArgs); $i++) {
                    // Current parameter is not an array
                    if (is_array($aFuncArgs[$i]) === false) {
                        $iArr[$i] = $aFuncArgs[$i];
                    }
                    // Error: Array found amongst input parameters
                    else {
                        $iArr = false;
                        $i = count($aFuncArgs);
                    }
                }
                break;
        }
        // Valid input parameters, initialize internal data
        if (is_array($iArr) === true) {
            $this->iArray = $iArr;
            $this->begin();
        }
        // Error: Invalid input
        else {
            die(get_class($this) . " :: 0x000001 Constructor of class Iterator recieved invalid input.");
        }
    }

    /**
     * @name		_Iterator - This is the destructor for the class
     * @param	NONE
     * @access	private
     */
    function _Iterator() {
        $aClassVars = get_class_vars(get_class($this));

        foreach ($aClassVars as $name => $value) {
            unset($this->$name);
        }
    }

    /**
     * @name	begin - This function will set _index to the beginning of the array
     * @param	NONE
     * @access	public
     */
    function begin() {
        $this->_index = 0;
    }

    /**
     * @name	start - Wrapper function for begin
     * @param	NONE
     * @access	public
     */
    function start() {
        $this->begin();
    }

    public function rewind() {
        $this->begin();
    }

    /**
     * @name	size - This function will return the current size of the array
     * @param	NONE
     * @return	INT
     * @access	public
     */
    function size() {
        return sizeof($this->iArray);
    }

    /**
     * @name	end - This function will set _index to the last element in the array
     * @param	NONE
     * @access	public
     */
    function end() {
        $this->_index = ($this->size() - 1);
    }

    /**
     * @name	index_end - This will return the index of the last element in the array
     * @param	NONE
     * @access	public
     */
    function index_end() {
        return ($this->size() - 1);
    }

    /**
     * @name	index_last - Wrapper function for index_end
     * @param	NONE
     * @access	public
     */
    function index_last() {
        return $this->index_end();
    }

    /**
     * @name	index_begin - This will return the index of the first element
     * @param	NONE
     * @access	public
     */
    function index_begin() {
        return 0;
    }

    /**
     * @name	index_first - Wrapper function for index_first
     * @param	NONE
     * @access	public
     */
    function index_first() {
        return $this->index_begin();
    }

    /**
     * @name	at - This will return the element at given index
     * @param	$index int - The offset of the element
     * @return	mixed
     * @access	public
     */
    function at($index) {
        if ($index > $this->size() || $index < 0 || is_int($index) === false) {
            die(get_class($this) . " :: 0x000002 Function at(int index) recieved a non int value.");
        }

        return $this->iArray[$index];
    }

    public function current() {
        return $this->at($this->_index);
    }

    public function valid() {
        ;
    }

    /**
     * @name	pos - Returns the element that _index is currently set to
     * @param	NONE
     * @return	mixed
     * @access	public
     */
    function pos() {
        return $this->iArray[$this->_index];
    }

    /**
     * @name	first - Returns the first element in the array
     * @param	NONE
     * @return	mixed
     * @access	public
     */
    function first() {
        return $this->iArray[0];
    }

    /**
     * @name	last - Returns the last element in the array
     * @param	NONE
     * @return	mixed
     * @access	public
     */
    function last() {
        return $this->iArray[($this->size() - 1)];
    }

    /**
     * @name	index - Returns the value of _index
     * @param	NONE
     * @return	INT
     * @access	public
     */
    function index() {
        return $this->_index;
    }

    public function key() {
        return $this->index();
    }

    /**
     * @name	previous - Increments the index by one position
     * @param	NONE
     * @access	public
     */
    function next() {
        $idx = $this->index();
        if (($idx + 1) > $this->size()) {
            $idx = $this->size();
        } else {
            $idx++;
        }
        $this->_index = $idx;
    }

    /**
     * @name	previous - Decrements the index by one position
     * @param	NONE
     * @access	public
     */
    function previous() {
        $idx = $this->_index;

        if (($idx - 1) < 0) {
            $idx = 0;
        } else {
            $idx = ($idx - 1);
        }

        $this->_index = $idx;
    }

    /**
     * @name	prev - Wrapper function for previous
     * @param	NONE
     * @access	public
     */
    function prev() {
        $this->previous();
    }

    /**
     * @name	insert - Inserts an element at the offset
     * @param	$offset int - The offset to insert the element
     *        	$var mixed - The new element to be inserted
     * @access	public
     */
    function insert($offset, $var) {
        if (is_int($offset) === false || is_null($offset) === true || $offset > $this->size() || $offset < 0) {
            die(get_class($this) . " :: 0x000003 Function insert recieved a non int value or non existant offset.");
        }

        $arr_one = array_slice($this->iArray, 0, $offset);
        $arr_two = array_reverse(array_slice($this->iArray, $offset, ($this->size() - $offset)));
        array_push($arr_two, $var);
        $arr_two = array_reverse($arr_two);
        $this->iArray = $this->array_combine($arr_one, $arr_two);
    }

    /**
     * @name	ins - Wrapper function for insert
     * @param	$offset int - The offset to insert the element
     *        	$var mixed - The new element to be inserted
     * @access	public
     */
    function ins($offset, $var) {
        $this->insert($offset, $var);
    }

    /**
     * @name	delete - Deletes an element from the array at given index
     * @param	$index int - The offset to delete the element
     * @access	public
     */
    function delete($index) {
        if (is_int($index) === false || is_null($index) === true || $index > $this->size() || $index < 0) {
            die(get_class($this) . " :: 0x000004 Function delete recieved a non int value or non existant offset.");
        }

        $arr_one = array_slice($this->iArray, 0, $index);
        $arr_two = array_slice($this->iArray, ($index + 1), ($this->size() - $index));
        $this->iArray = $this->array_combine($arr_one, $arr_two);
    }

    /**
     * @name	del - Wrapper function for delete
     * @param	$index int - The offset to delete the element
     * @access	public
     */
    function del($index) {
        $this->delete($index);
    }

    /**
     * @name	push_back - Adds an element onto the end of the array
     * @param	$var mixed - The new element to be inserted
     * @access	public
     */
    function push_back($var) {
        array_push($this->iArray, $var);
    }

    /**
     * @name	push_front - Adds an element onto the beginning of the array
     * @param	$var mixed - The new element to be inserted
     * @access	public
     */
    function push_front($var) {
        $a = array_reverse($this->iArray);
        array_push($a, $var);
        $this->iArray = array_reverse($a);
    }

    /**
     * @name	pop_front - Removes the first element from the array
     * @access	public
     */
    function pop_front() {
        array_pop($this->iArray);
    }

    /**
     * @name	pop_back - Removes the last element from the array
     * @access	public
     */
    function pop_back() {
        $a = array_reverse($this->iArray);
        array_pop($a);
        $this->iArray = $a;
    }

    /**
     * @name	array_combine - Combines two arrays together
     * @param	$a array - This is the array that array $b appended to
      $b array - This is the array appended to array $a
     * @access public
     */
    function array_combine($a, $b) {
        if (is_array($a) === true && is_array($b) === true) {
            foreach ($b as $i) {
                array_push($a, $i);
            }
            return $a;
        }
        return false;
    }

    /**
     * @name	slice - This returns a chunk of the array from the offset to length
     * @param	$offset int - The place to start copying the chunk from
      $length int - The number of elements to return;
     * @return	array mixed
     * @access	public
     */
    function slice($offset, $length) {
        if ($length > $this->size() || $length < 0 || is_int($offset) === false || is_int($length) === false || $length < 0 || ($offset + $length) > $this->size()) {
            die(get_class($this) . " :: 0x000005 Function slice recieved a non int value or non existant offset.");
        }
        return array_slice($this->iArray, $offset, $length);
    }

    /**
     * @name	reverse	- This function will return the reverse of the set array
     * @param	NONE
     * @return	array mixed
     * @access	public
     */
    function reverse() {
        return array_reverse($this->iArray);
    }

    /**
     * @name	all - This funtion will return the whole set array
     * @param	NONE
     * @return	array mixed
     * @access	public
     */
    function all() {
        return $this->iArray;
    }

    /**
     * @name	iterator_ - Wrapper function for all, this function is depreceated, use all() instead
     * @param	NONE
     * @return	array mixed
     * @access	public
     */
    function iterator_() {
        trigger_error("$this->iterator_() is depreceated, please use the $this->all() instead", E_USER_NOTICE);

        return $this->all();
    }

    /**
     * @name	replace - This will replace an element at index
     * @param	$index int - The element to be replaced
     * @access	public
     */
    function replace($index, $var) {
        if (is_null($index) === true || is_int($index) === false || is_null($var) === true || $index > $this->size() || $index < 0) {
            die(get_class($this) . " :: 0x000006 Function replace has recieved a null or non valid int value.");
        }
        $this->iArray[$index] = $var;
    }

}


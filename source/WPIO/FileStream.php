<?php
/**
 * Wudi Personal Input and Output Library (WPIO)
 *
 * PHP versions 5
 *
 * LICENSE: This library is free software; you can redistribute it
 * and/or modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301 USA.
 *
 * @category   File_System
 * @package    WPIO
 * @author     Wudi Liu <wudicgi@gmail.com>
 * @copyright  2009-2010 Wudi Labs
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    SVN: $Id$
 * @link       http://www.wudilabs.org/
 */

/**
 * WPIO_FileStream
 *
 * @category   File_System
 * @package    WPIO
 * @author     Wudi Liu <wudicgi@gmail.com>
 * @copyright  2009-2010 Wudi Labs
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link       http://www.wudilabs.org/
 */
class WPIO_FileStream extends WPIO_Stream {
    private $_fp = null;

    function __construct($filename, $mode) {
        assert('is_string($filename)');
        assert('is_string($mode)');

        $this->_fp = fopen($filename, $mode);

        // resource fopen() 在失败时返回 false
        if ($this->_fp == false) {
            throw new WPDP_InternalException("Failed to open file $filename using fopen()");
        }
    }

    public function isReadable() {
        return true;
    }

    public function isWritable() {
        return true;
    }

    public function isSeekable() {
        return true;
    }

    public function close() {
        $success = fclose($this->_fp);

        // bool fclose() 在失败时返回 false
        if ($success == false) {
            throw new WPIO_Exception("Failed to close file using fclose()");
        }

        return true;
    }

    public function seek($offset, $whence = WPIO::SEEK_SET) {
        static $table = array(
            WPIO::SEEK_SET => SEEK_SET,
            WPIO::SEEK_CUR => SEEK_CUR,
            WPIO::SEEK_END => SEEK_END
        );

        assert('is_int($offset)');
        assert('is_int($whence)');

        assert('in_array($whence, array(WPIO::SEEK_SET, WPIO::SEEK_CUR, WPIO::SEEK_END))');

        if (!$this->isSeekable()) {
            throw new WPIO_Exception("This stream is unseekable");
        }

        $status = fseek($this->_fp, $offset, $table[$whence]);

        // int fseek() 在成功时返回 0
        if ($status != 0) {
            throw new WPIO_Exception("Failed to seek to specified offset using fseek()");
        }

        return true;
    }

    public function tell() {
        if (!$this->isSeekable()) {
            throw new WPIO_Exception("This stream is unseekable");
        }

        $offset = ftell($this->_fp);

        // 使用全等运算符判断，以避免 $offset 为 0 时判断错误
        if ($offset === false) {
            throw new WPIO_Exception("Failed to get the current offset using ftell()");
        }

        return $offset;
    }

    public function read($length) {
        assert('is_int($length)');

        if (!$this->isReadable()) {
            throw new WPIO_Exception("This stream is unreadable");
        }

        $data = fread($this->_fp, $length);

        // string fread() 在失败时返回 false
        // 使用全等运算符判断，以避免 $data 为空字符串时判断错误
        if ($data === false) {
            throw new WPIO_Exception("Failed to write to file using fwrite()");
        }

        return $data;
    }

    public function write($data) {
        assert('is_string($data)');

        if (!$this->isWritable()) {
            throw new WPIO_Exception("This stream is unwritable");
        }

        $len = fwrite($this->_fp, $data);

        // int fwrite() 在失败时返回 false
        // 使用全等运算符判断，以避免 $len 为 0 时判断错误
        if ($len === false) {
            throw new WPIO_Exception("Failed to write to file using fwrite()");
        }

        return $len;
    }

    public function eof() {
        return feof($this->_fp);
    }
}

?>

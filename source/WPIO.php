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
 * WPIO
 *
 * @category   File_System
 * @package    WPIO
 * @author     Wudi Liu <wudicgi@gmail.com>
 * @copyright  2009-2010 Wudi Labs
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link       http://www.wudilabs.org/
 */
class WPIO {
    // {{{ 常量

    /**
     * 定位起始点常量
     *
     * @global integer SEEK_SET 开始位置
     * @global integer SEEK_CUR 当前位置
     * @global integer SEEK_END 结尾位置
     */
    const SEEK_SET = 0;
    const SEEK_CUR = 1;
    const SEEK_END = 2;

    const _LIBRARY_VERSION = '0.1.0-dev';

    // }}}

    public static function libraryVersion() {
        return self::_LIBRARY_VERSION;
    }

    public static function libraryCompatibleWith($version) {
        if (version_compare($version, self::libraryVersion()) <= 0) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * WPIO_Stream
 *
 * @category   File_System
 * @package    WPIO
 * @author     Wudi Liu <wudicgi@gmail.com>
 * @copyright  2009-2010 Wudi Labs
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link       http://www.wudilabs.org/
 */
abstract class WPIO_Stream {
    // {{{ isReadable()

    /**
     * 测试流是否支持读取
     *
     * @access public
     *
     * @return bool 若支持读取则返回 true, 否则返回 false
     */
    abstract public function isReadable();

    // }}}

    // {{{ isWritable()

    /**
     * 测试流是否支持写入
     *
     * @access public
     *
     * @return bool 若支持写入则返回 true, 否则返回 false
     */
    abstract public function isWritable();

    // }}}

    // {{{ isSeekable()

    /**
     * 测试流是否支持定位
     *
     * @access public
     *
     * @return bool 若支持定位则返回 true, 否则返回 false
     */
    abstract public function isSeekable();

    // }}}

    // {{{ close()

    /**
     * 关闭流
     *
     * @access public
     *
     * @return bool 成功时返回 true, 失败时抛出异常
     *
     * @throws WPIO_Exception
     */
    abstract public function close();

    // }}}

    // {{{ flush()

    /**
     * 将缓冲内容输出到流
     *
     * @access public
     *
     * @return bool 成功时返回 true, 失败时抛出异常
     *
     * @throws WPIO_Exception
     */
    abstract public function flush();

    // }}}

    // {{{ seek()

    /**
     * 在流中定位
     *
     * @access public
     *
     * @param int $offset   偏移量
     * @param int $whence   定位起始点
     *
     * @return bool 成功时返回 true, 失败时抛出异常
     *
     * @throws WPIO_Exception
     */
    abstract public function seek($offset, $whence = WPIO::SEEK_SET);

    // }}}

    // {{{ tell()

    /**
     * 获取指针在流中的位置
     *
     * @access public
     *
     * @return int 返回指针在流中的位置，产生错误时抛出异常
     *
     * @throws WPIO_Exception
     */
    abstract public function tell();

    // }}}

    // {{{ read()

    /**
     * 读取流
     *
     * 如果可读取的数据没有请求的那么多，则返回的字符串长度小于所请求的字节数。
     * 如果到达流的结尾，返回值为空字符串。
     *
     * @access public
     *
     * @param int $length   最多读取的字节数
     *
     * @return string 返回实际所读取的数据，产生错误时抛出异常
     *
     * @throws WPIO_Exception
     */
    abstract public function read($length);

    // }}}

    // {{{ write()

    /**
     * 写入流
     *
     * 如果可写入流的数据没有请求的那么多，则返回的实际写入的字节数小于所请求的字节数。
     *
     * @access public
     *
     * @param string $data  要写入的数据
     *
     * @return int 返回实际写入的字节数，产生错误时抛出异常
     *
     * @throws WPIO_Exception
     */
    abstract public function write($data);

    // }}}

    // {{{ eof()

    /**
     * 测试指针是否到了流结束的位置
     *
     * @access public
     *
     * @return bool 如果指针到了流结束的位置则返回 true, 否则返回 false
     *
     * @throws WPIO_Exception
     */
    abstract public function eof();

    // }}}
}

class WPIO_Exception extends Exception {
}

?>

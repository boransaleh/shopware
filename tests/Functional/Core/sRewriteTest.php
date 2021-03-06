<?php
/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

class sRewriteTest extends PHPUnit\Framework\TestCase
{
    /**
     * @var sRewriteTable
     */
    private $rewriteTable;

    public function setUp(): void
    {
        $this->rewriteTable = Shopware()->Modules()->RewriteTable();
    }

    /**
     * * @dataProvider provider
     */
    public function testRewriteString($string, $result)
    {
        static::assertEquals($result, $this->rewriteTable->sCleanupPath($string));
    }

    public function provider()
    {
        return [
            [' a  b ', 'a-b'],
            ['hello', 'hello'],
            ['Hello', 'Hello'],
            ['Hello World', 'Hello-World'],
            ['Hello-World', 'Hello-World'],
            ['Hello:World', 'Hello-World'],
            ['Hello,World', 'Hello-World'],
            ['Hello;World', 'Hello-World'],
            ['Hello&World', 'Hello-World'],
            ['Hello & World', 'Hello-World'],
            ['Hello.World.html', 'Hello.World.html'],
            ['Hello World.html', 'Hello-World.html'],
            ['Hello World!', 'Hello-World'],
            ['Hello World!.html', 'Hello-World.html'],
            ['Hello / World', 'Hello/World'],
            ['Hello/World', 'Hello/World'],
            ['H+e#l1l--o/W??o r.l:d)', 'H-e-l1l-o/W-o-r.l-d'],
            [': World', 'World'],
            ['Nguy???n ????ng Khoa', 'Nguyen-Dang-Khoa'],
            ['?? ?? ?? ?? ?? ?? ??', 'AE-ae-OE-oe-UE-ue-ss'],
            ['?? ?? ?? ?? ?? ?? ?? ?? ?? ?? ?? ?? ?? ?? ?? ?? ?? ??', 'A-A-a-a-E-E-e-e-O-O-o-o-N-n-U-U-u-u'],
            ['?? ?? ?? ?? ?? ?? ?? ??', 'A-a-E-e-O-o-U-u'],
            ['?? ?? ?? ?? ?? ?? ?? 1', 'A-a-E-e-O-o-U-1'],
            ['???????????? ??????', 'Privet-mir'],
            ['???????????? ????????', 'Privit-svit'],
            ['????????@', '0123at'],
            ['M??r?? th??n w??rds', 'More-thaan-woerds'],
            ['???????? ????????????', 'Blog-jizhachka'],
            ['??????????', 'film'],
            ['??????????', 'drama'],
            ['????????????????', 'ellinika'],
            ['C???est du fran??ais !', 'C-est-du-francais'],
            ['????n jaar', 'Een-jaar'],
            ['ti???ng vi???t r???t kh??', 'tieng-viet-rat-kho'],
        ];
    }
}

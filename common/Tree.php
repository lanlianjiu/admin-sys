<?php
/**
 * 无限分类树
 *
 * @author: jiangyi
 * @date: 下午10:06 2018/7/12
 */

namespace common;


class Tree
{
    public static function make($branches)
    {
        $tree = [];
        foreach ($branches as $id => $branch) {
            if (isset($branches[$branch['pid']])) {
                $branches[$branch['pid']]['children'] = &$branches[$id];
            } else {
                $tree[] = &$branches[$branch['id']];
            }
        }
        return $tree;
    }
}

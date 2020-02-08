<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;

class GovController extends Controller
{
    // 概述
    public function summary(Request $request)
    {
        $townId = $request->get('town', '700000');
        $ret = [];

        $enterprise_count = Redis::hGet('blgov:summary:enterprise:count', $townId);
        $ret['summary'][] = ['label' => '企业数量', 'value' => $enterprise_count ?? 0];
        $enployee_count = Redis::hGet('blgov:summary:employee:count', $townId);
        $ret['summary'][] = ['label' => '员工总数', 'value' => $enployee_count ?? 0];
        $back_count = Redis::hGet('blgov:summary:employee_back:count', $townId);
        $ret['summary'][] = ['label' => '在甬员工数', 'value' => $back_count ?? 0];
        $not_back_count = Redis::hGet('blgov:summary:employee_not_back:count', $townId);
        $ret['summary'][] = ['label' => '非在甬员工数', 'value' => $not_back_count ?? 0];

        $gender_count =  Redis::hGetAll('blgov:summary:employee_gender:count:' . $townId);
        $gender_key = [0 => '男', 1 => '女'];
        if ($gender_count) {
            foreach ($gender_count as $gender => $count) {
                $ret['gender'][] = ['value' => $count, 'key' => $gender_key[$gender]];
            }
        } else {
            $ret['gender'] = [
                ['value' => 0, 'key' => '男'],
                ['value' => 0, 'key' => '女']
            ];
        }

        $outing_count =  Redis::hGetAll('blgov:summary:employee_outing:count:' . $townId);
        $outing_key = [
            0 => '宁波',
            1 => '湖北',
            2 => '温州',
            3 => '台州',
            4 => '其它'
        ];
        if ($outing_count) {
            foreach ($outing_count as $outing => $count) {
                $ret['outing'][] = ['value' => $count, 'key' => $outing_key[$outing]];
            }
        } else {
            $ret['out'] = [
                ['value' => 0, 'key' => '宁波'],
                ['value' => 0, 'key' => '湖北'],
                ['value' => 0, 'key' => '温州'],
                ['value' => 0, 'key' => '台州'],
                ['value' => 0, 'key' => '其它']
            ];
        }

        return response()->json($ret);
    }

    // 返甬时间
    public function back(Request $request) {
        $townId = $request->get('town', '700000');
        $start = $request->get('start', '2020-02-01');
        $end = $request->get('end', '2020-03-31');
        $ret = [];
        $time_range = Redis::zRangeByLex('blgov:summary:employee_back_date:count:' . $townId, '[' . $start, '[' . $end);
        foreach ($time_range as $time) {
            $ret[] = ['time' => $time, 'value' => Redis::zScore('blgov:summary:employee_back_date:count:' . $townId, $time)];
        }
        $ret = array_values(Arr::sort($ret, function ($value) {
            return strtotime($value['time']);
        }));
        return response()->json($ret);
    }
}

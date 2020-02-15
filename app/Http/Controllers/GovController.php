<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $ret['summary'][] = ['label' => '企业数量', 'value' => $enterprise_count ? $enterprise_count : 0];
        $enployee_count = Redis::hGet('blgov:summary:employee:count', $townId);
        $ret['summary'][] = ['label' => '员工总数', 'value' => $enployee_count ? $enployee_count : 0];
        $back_count = Redis::hGet('blgov:summary:employee_back:count', $townId);
        $ret['summary'][] = ['label' => '在甬员工数', 'value' => $back_count ? $back_count : 0];
        $not_back_count = Redis::hGet('blgov:summary:employee_not_back:count', $townId);
        $ret['summary'][] = ['label' => '非在甬员工数', 'value' => $not_back_count ? $not_back_count : 0];

        $gender_count = Redis::hGetAll('blgov:summary:employee_gender:count:' . $townId);
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

        $outing_count = Redis::hGetAll('blgov:summary:employee_outing:count:' . $townId);
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
    public function back(Request $request)
    {
        $townId = $request->get('town', '700000');
        $start = $request->get('start', '2020-02-01');
        $end = $request->get('end', '2020-03-31');
        $ret = [];
        $start = Carbon::createFromFormat("Y-m-d", $start);
        $end = Carbon::createFromFormat("Y-m-d", $end);
        if ($start->gt($end)) {
            $temp = $start;
            $start = $end;
            $end = $temp;
        }
        $dates = [];
        for ($date = $start; $date->lte($end); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }
        $values = Redis::hMGet('blgov:summary:employee_back_date:count:' . $townId, $dates);
        $values = array_map(function ($value) {
            return $value ? $value : 0;
        }, $values);
        $values = array_combine($dates, $values);
        foreach ($values as $time => $value) {
            $ret[] = ['time' => $time, 'value' => $value];
        }
        return response()->json($ret);
    }

    // 接触情况
    public function touch(Request $request)
    {
        $townId = $request->get('town', '700000');
        $ret = [];

        $contact_situation_count = Redis::hGetAll('blgov:summary:employee_contact_situation:count:' . $townId);
        $contact_situation_key = [0 => '无接触', 1 => '疑似接触'];
        if ($contact_situation_count) {
            foreach ($contact_situation_count as $contact_situation => $count) {
                $ret[] = ['value' => $count, 'key' => $contact_situation_key[$contact_situation]];
            }
        } else {
            $ret = [
                ['value' => 0, 'key' => '无接触'],
                ['value' => 0, 'key' => '疑似接触']
            ];
        }

        return response()->json($ret);
    }

    // 医学观察
    public function medical(Request $request)
    {
        $townId = $request->get('town', '700000');
        $ret = [];

        $is_medical_count = Redis::hGet('blgov:summary:employee_is_medical:count', $townId);
        $ret[] = ['label' => '医学观察人数', 'value' => $is_medical_count ? $is_medical_count : 0];
        // 发热情况
        $owner_health_count = Redis::hGetAll('blgov:summary:employee_owner_health:count:' . $townId);
        $owner_health_key = [
            0 => '正常人数',
            1 => '发热人数',
            2 => '咳嗽人数',
            3 => '发热并咳嗽人数',
            4 => '其它症状人数'
        ];
        if ($owner_health_count) {
            foreach ($owner_health_count as $owner_health => $count) {
                $ret[] = ['value' => $count, 'key' => $owner_health_key[$owner_health]];
            }
        } else {
            $ret['out'] = [
                ['value' => 0, 'key' => '正常人数'],
                ['value' => 0, 'key' => '发热人数'],
                ['value' => 0, 'key' => '咳嗽人数'],
                ['value' => 0, 'key' => '发热并咳嗽人数'],
                ['value' => 0, 'key' => '其它症状人数']
            ];
        }

        return response()->json($ret);
    }


    public function detail(Request $request)
    {

    }

    private function getModel(&$model, $filter = [])
    {
        if (!empty($filter['status'])) {
            $model->reportStatus($filter['status']);
        }
        if (!empty($filter['industry'])) {
            $model->industry($filter['industry']);
        }
        $model->with(['report' => function($query) {
            $query->orderByDesc('report_at');
        }]);
    }
}
